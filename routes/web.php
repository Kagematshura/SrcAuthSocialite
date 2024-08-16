<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

Route::get('/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);
