<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'public.index')->name('index');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');


