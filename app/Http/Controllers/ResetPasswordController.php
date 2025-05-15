<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function userPasswordReset(User $user) {

        // user authorization
        Gate::authorize('modify', $user);

        return view('auth.reset-user-password');
    }

    public function userPasswordUpdate(Request $request, User $user) {
        // Validate
        $fields = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'min:3', 'confirmed']
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the old password matches the stored password
        if (!Hash::check($request->old_password, $user->password)) {
            // Return an error if the old password doesn't match
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.show', $user)->with('success', 'Password was updated');
    }
}
