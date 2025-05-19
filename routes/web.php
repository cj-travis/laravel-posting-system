<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// public homepage
Route::get('/', [PostController::class, 'index'])->name('index');
Route::view('/goodbye', 'users.goodbye')->name('goodbye');

// Routes
Route::resource('posts', PostController::class);
Route::resource('user', UserController::class);
Route::resource('comment', CommentController::class);
Route::resource('like', LikeController::class);

// public posts page
Route::get('/posts', [PostController::class, 'posts'])->name('posts');

// routes for authenticated users
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/reset-user-password/{user}', [ResetPasswordController::class, 'userPasswordReset'])->name('userpassword.reset');

    Route::post('/update-user-password', [ResetPasswordController::class, 'userPasswordUpdate'])->name('userpassword.update');

    Route::post('/like', [LikeController::class, 'store'])->name('like.store');

    
});

// routes for authenticated admins
Route::middleware(['auth', AdminMiddleware::class])->group(function() {
    Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->middleware([AdminMiddleware::class])->name('admin-dashboard');

    Route::put('/update-role/{user}', [UserController::class, 'updateRole'])->middleware([AdminMiddleware::class]) ->name('role.update');

    Route::put('/user-update-status/{user}', [UserController::class, 'updateUserStatus'])->middleware([AdminMiddleware::class]) ->name('user-status.update');
    
    Route::put('/post-update-status/{post}', [PostController::class, 'updatePostStatus'])->middleware([AdminMiddleware::class]) ->name('post-status.update');
});

// routes for guests
Route::middleware('guest')->group(function() {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});
