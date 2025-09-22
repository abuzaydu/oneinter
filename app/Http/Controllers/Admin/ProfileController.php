<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $admin = auth()->user();
        return view('admin.profile.show', compact('admin'));
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $admin = auth()->user();

        // Delete old profile picture if exists
        if ($admin->profile_picture) {
            $oldPath = public_path($admin->profile_picture);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Store new profile picture in public directory for better accessibility
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $publicPath = 'profile-pictures/' . $filename;
        
        // Move file to public directory
        $file->move(public_path('profile-pictures'), $filename);
        
        // Update the profile picture field
        $result = $admin->update([
            'profile_picture' => $publicPath
        ]);

        if (!$result) {
            return back()->withErrors(['profile_picture' => 'Failed to update profile picture.']);
        }

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profile picture updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = auth()->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Password changed successfully.');
    }
}
