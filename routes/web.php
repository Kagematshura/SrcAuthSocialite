<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');


Route::get('/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);

Route::post('/login', [LoginController::class, 'login'])->name('login');
