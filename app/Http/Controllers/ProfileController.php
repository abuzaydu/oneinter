<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update profile picture
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = $request->user();

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            $oldPath = public_path($user->profile_picture);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Store new profile picture in public directory
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $publicPath = 'profile-pictures/' . $filename;
        
        // Create directory if it doesn't exist
        $uploadDir = public_path('profile-pictures');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Move file to public directory
        $file->move($uploadDir, $filename);
        
        // Update the profile picture field
        $user->update(['profile_picture' => $publicPath]);

        return Redirect::route('profile.edit')->with('status', 'picture-updated');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
