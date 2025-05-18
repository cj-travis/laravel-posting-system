<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // register user
    public function register(Request $request) {

        // Validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed']
        ]);

        // Create user
        $user = User::create($fields);

        // Login user
        Auth::login($user);

        // Redirect
        return redirect()->route('posts');


    }

    // Login User
    public function login (Request $request) {
        
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required']
        ]);

        // Try to Login
        if(Auth::attempt($fields, $request->remember)) 
        {
            return redirect()->route('posts');
        }
        else
        {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records.'
            ]);
        }
  
    }

    //logout user
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate(); // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect('/');
    }
}
