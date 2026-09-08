<?php

use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\CaseStudyController as AdminCaseStudyController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IndustryController as AdminIndustryController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads');
        Route::get('/clients', [AdminClientController::class, 'index'])->name('clients');
        Route::get('/quotes', [AdminQuoteController::class, 'index'])->name('quotes');
        Route::get('/services', [AdminServiceController::class, 'index'])->name('services');
        Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects');
        Route::get('/case-studies', [AdminCaseStudyController::class, 'index'])->name('case-studies');
        Route::get('/industries', [AdminIndustryController::class, 'index'])->name('industries');
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages');
        Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog');
        Route::get('/careers', [AdminCareerController::class, 'index'])->name('careers');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::resource('roles', AdminRoleController::class)->except(['show']);
        Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('permissions.index');
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
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
