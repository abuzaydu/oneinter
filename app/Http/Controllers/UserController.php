<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        try {
            // Generate a random password
            $password = \Str::random(12);
            
            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'password' => Hash::make($password),
                'default_pass' => $password,
            ]);

            $role = Role::find($request['role_id']);
            $user->assignRole($role);
            // Send welcome email with credentials
            try {
                \Log::info('Sending welcome email to: ' . $user->email);
                $user->notify(new \App\Notifications\WelcomeUserNotification($user, $password));
                \Log::info('Welcome email sent successfully to: ' . $user->email);
                $message = 'User created successfully. Welcome email sent with login credentials.';
            } catch (\Exception $emailException) {
                // If email fails, still create the user but inform admin
                $message = 'User created successfully. However, the welcome email could not be sent. Please manually send login credentials to the user.';
                \Log::error('Failed to send welcome email to user: ' . $user->email, [
                    'error' => $emailException->getMessage(),
                    'user_id' => $user->id
                ]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while creating the user. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!auth()->user()->can('edit_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->can('edit_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        $user->save();

        $currroles = $user->roles()->get();
        if (!is_null($currroles)) {
            foreach ($currroles as $key => $role) {
                $user->removeRole($role);
            }
        }

        $role = Role::find($request['role_id']);
        $user->assignRole($role);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->can('delete_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Send password reset email to user
     */
    public function sendPasswordReset(User $user)
    {
        if (!auth()->user()->can('edit_users')) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            \Log::info('Sending password reset email to: ' . $user->email);
            Password::sendResetLink(['email' => $user->email]);
            \Log::info('Password reset email sent successfully to: ' . $user->email);

            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Password reset email sent successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email to user: ' . $user->email, [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                ->with('error', 'An error occurred while sending the password reset email. Please try again.');
        }
    }
}
