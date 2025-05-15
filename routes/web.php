<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('index');

// Posts Routes
Route::resource('posts', PostController::class);
Route::resource('user', UserController::class);
Route::get('/posts', [PostController::class, 'posts'])->name('posts');

// routes for authenticated users
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    // Route::get('/user', [UserController::class, 'index'])->name('profile');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/reset-user-password/{user}', [ResetPasswordController::class, 'userPasswordReset'])->name('userpassword.reset');

    Route::post('/update-user-password', [ResetPasswordController::class, 'userPasswordUpdate'])->name('userpassword.update');
});

// routes for guests
Route::middleware('guest')->group(function() {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

    // Route::post('/forgot-password', function (Request $request) {
    //     $request->validate(['email' => 'required|email']);
    
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );
    
    //     return $status === Password::ResetLinkSent
    //         ? back()->with(['status' => __($status)])
    //         : back()->withErrors(['email' => __($status)]);
    // })->middleware('guest')->name('password.email');
});
