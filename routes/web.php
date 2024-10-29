<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FaviconController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Page routes
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');
Route::get('/payment', [PageController::class, 'payment'])->name('payment');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::put('/payment/{id}', [DashboardController::class, 'update']);
Route::delete('/payment/{transaction}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');

// Transaction


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
Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('article.update');

// Delete Route
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

// Show Single Article
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');

// Drafts
Route::get('/drafts/create', [DraftController::class, 'create'])->name('drafts.create');
Route::post('/drafts/store', [DraftController::class, 'store'])->name('drafts.store');
Route::get('/drafts', [DraftController::class, 'index'])->name('drafts.index');
Route::get('/drafts/{id}', [DraftController::class, 'show'])->name('drafts.show');
Route::post('/drafts/{id}/approve', [DraftController::class, 'approve'])->name('drafts.approve');
Route::post('/drafts/{id}/pending', [DraftController::class, 'setPending'])->name('drafts.pending');
Route::post('/drafts/{id}/notapproved', [DraftController::class, 'notApproved'])->name('drafts.notapproved');

//Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

// Payment
Route::post('/payment/store', [PaymentController::class, 'create']);
Route::post('/payment', [PaymentController::class, 'store']);
Route::post('/payment/notification', [PaymentController::class, 'handleMidtransNotification']);

// Favicons
Route::get('/favicon', [FaviconController::class, 'showUploadForm'])->name('favicon.index');
Route::post('/upload-favicon', [FaviconController::class, 'uploadFavicon'])->name('upload.favicon');
Route::delete('/favicons/{id}', [FaviconController::class, 'deleteFavicon'])->name('delete.favicon');
