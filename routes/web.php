<?php

use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/digital-marketing', [PageController::class, 'digitalMarketing'])->name('digital-marketing');
Route::get('/software-development', [PageController::class, 'softwareDevelopment'])->name('software-development');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{category_slug}', [PageController::class, 'serviceCategory'])->name('services.category');
Route::get('/services/{category_slug}/{service_slug}', [PageController::class, 'singleService'])->name('services.single');

// Public Client Authentication Routes (Guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [FrontendAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit');
});

// Client Logout
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout')->middleware('auth');
