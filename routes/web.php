<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Page routes
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Google authentication routes
Route::get('/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home
Route::get('/home', [ArticleController::class, 'home'])->name('article.home');

// Article Routes
Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
Route::post('/article', [ArticleController::class, 'store'])->name('article.store');

// Edit and Update Routes
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('article.update');

// Delete Route
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

// Show Single Article
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');

// Drafts
Route::get('/drafts/create', [DraftController::class, 'create'])->name('drafts.create');
Route::post('/drafts/store', [DraftController::class, 'store'])->name('drafts.store');
Route::get('/drafts', [DraftController::class, 'index'])->name('drafts.index');
Route::post('/drafts/{id}/approve', [DraftController::class, 'approve'])->name('drafts.approve');

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
