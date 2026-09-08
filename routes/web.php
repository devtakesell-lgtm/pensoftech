<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\LeadController as ClientLeadController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
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

// Public Client Authentication Routes (Guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [FrontendAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit');
});

// Client Logout
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Staff Login & Logout
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Protected Staff Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/leads', [DashboardController::class, 'leads'])->name('leads');
        Route::get('/clients', [DashboardController::class, 'clients'])->name('clients');
        Route::get('/quotes', [DashboardController::class, 'quotes'])->name('quotes');
        Route::get('/services', [DashboardController::class, 'services'])->name('services');
        Route::get('/projects', [DashboardController::class, 'projects'])->name('projects');
        Route::get('/case-studies', [DashboardController::class, 'caseStudies'])->name('case-studies');
        Route::get('/industries', [DashboardController::class, 'industries'])->name('industries');
        Route::get('/pages', [DashboardController::class, 'pages'])->name('pages');
        Route::get('/blog', [DashboardController::class, 'blog'])->name('blog');
        Route::get('/careers', [DashboardController::class, 'careers'])->name('careers');
        Route::get('/users', [DashboardController::class, 'users'])->name('users');
        Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    });
});

// Client Portal Routes
Route::prefix('client')->name('client.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('client.dashboard');
    });
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ClientProjectController::class, 'show'])->name('projects.show');
    Route::get('/leads', [ClientLeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [ClientLeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [ClientLeadController::class, 'store'])->name('leads.store');
});
