<?php

use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LeadController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\ServiceController;
use Illuminate\Support\Facades\Route;

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/start-project', [LeadController::class, 'create'])->name('start-project');
Route::post('/start-project', [LeadController::class, 'store'])->name('start-project.store');

Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');
Route::get('/digital-marketing', [PageController::class, 'digitalMarketing'])->name('digital-marketing');
Route::get('/software-development', [PageController::class, 'softwareDevelopment'])->name('software-development');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{category_slug}', [ServiceController::class, 'category'])->name('services.category');
Route::get('/services/{category_slug}/{service_slug}', [ServiceController::class, 'show'])->name('services.single');

Route::get('/blog', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.single');
Route::post('/blog/{blog}/comments', [BlogController::class, 'storeComment'])->name('blogs.comments.store');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.single');

// Public Client Authentication Routes (Guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [FrontendAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit');
});

// Client Logout
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout')->middleware('auth');
