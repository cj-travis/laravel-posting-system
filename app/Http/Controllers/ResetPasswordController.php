<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    // reset password from the profile page
    public function userPasswordReset(User $user) {
        // user authorization
        Gate::authorize('modify', $user);

        // redirect user to the rest password form
        return view('auth.reset-user-password');
    }

    // update password after submitting the form from the reset password page from profile page
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

        // redirect
        return redirect()->route('user.show', $user)->with('success', 'Password was updated');
    }

    // send email link to reset password
    public function passwordEmail (Request $request) {
        // validate
        $request->validate(['email' => 'required|email']);
        
        // send reset link if there's an email, and also automatically check the email actually exists
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        // return status or error
        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]); // error will be shown at the email input field
    }

    // reset password view
    public function passwordReset (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    // update password
    public function passwordUpdate (Request $request) {

        // validate
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ]);
    
        $status = Password::reset(
            // pass in the credentials
            $request->only('email', 'password', 'password_confirmation', 'token'),

            // reset password
            function (User $user, string $password) {

                // update the password field
                $user->forceFill([
                    'password' => Hash::make($password) // hash the password
                ])->setRememberToken(Str::random(60)); // replace existing rmb token to a new one
    
                $user->save();
    
                event(new PasswordReset($user)); // send email to user
            }
        );
        
        // return status or error
        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
