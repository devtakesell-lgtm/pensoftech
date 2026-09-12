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
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
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

        // Leads Module
        Route::prefix('leads')->group(function () {
            Route::get('/', [AdminLeadController::class, 'index'])->name('leads')->middleware('can:view-leads');
            Route::get('/create', [AdminLeadController::class, 'create'])->name('leads.create')->middleware('can:create-leads');
            Route::post('/', [AdminLeadController::class, 'store'])->name('leads.store')->middleware('can:create-leads');
            Route::get('/{lead}', [AdminLeadController::class, 'show'])->name('leads.show')->middleware('can:view-leads');
            Route::get('/{lead}/edit', [AdminLeadController::class, 'edit'])->name('leads.edit')->middleware('can:edit-leads');
            Route::put('/{lead}', [AdminLeadController::class, 'update'])->name('leads.update')->middleware('can:edit-leads');
            Route::delete('/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy')->middleware('can:delete-leads');
            Route::patch('/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.update-status')->middleware('can:edit-leads');
            Route::post('/{lead}/convert', [AdminLeadController::class, 'convert'])->name('leads.convert')->middleware('can:edit-leads');
            Route::patch('/{lead}/assignee', [AdminLeadController::class, 'updateAssignee'])->name('leads.assignee')->middleware('can:edit-leads');
        });

        // Clients Module
        Route::prefix('clients')->group(function () {
            Route::get('/', [AdminClientController::class, 'index'])->name('clients')->middleware('can:view-clients');
        });

        // Quotes Module
        Route::prefix('quotes')->group(function () {
            Route::get('/', [AdminQuoteController::class, 'index'])->name('quotes')->middleware('can:view-quotes');
            Route::get('/create', [AdminQuoteController::class, 'create'])->name('quotes.create')->middleware('can:create-quotes');
            Route::post('/', [AdminQuoteController::class, 'store'])->name('quotes.store')->middleware('can:create-quotes');
            Route::get('/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show')->middleware('can:view-quotes');
            Route::get('/{quote}/edit', [AdminQuoteController::class, 'edit'])->name('quotes.edit')->middleware('can:edit-quotes');
            Route::put('/{quote}', [AdminQuoteController::class, 'update'])->name('quotes.update')->middleware('can:edit-quotes');
            Route::delete('/{quote}', [AdminQuoteController::class, 'destroy'])->name('quotes.destroy')->middleware('can:delete-quotes');
        });

        // Services Module
        Route::prefix('services')->group(function () {
            Route::get('/', [AdminServiceController::class, 'index'])->name('services')->middleware('can:view-services');
            Route::get('/create', [AdminServiceController::class, 'create'])->name('services.create')->middleware('can:create-services');
            Route::post('/', [AdminServiceController::class, 'store'])->name('services.store')->middleware('can:create-services');
            Route::get('/{service}/edit', [AdminServiceController::class, 'edit'])->name('services.edit')->middleware('can:edit-services');
            Route::put('/{service}', [AdminServiceController::class, 'update'])->name('services.update')->middleware('can:edit-services');
            Route::delete('/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:delete-services');
        });

        // Service Categories Module
        Route::prefix('service-categories')->name('service-categories.')->group(function () {
            Route::get('/', [AdminServiceCategoryController::class, 'index'])->name('index')->middleware('can:view-services');
            Route::get('/create', [AdminServiceCategoryController::class, 'create'])->name('create')->middleware('can:create-services');
            Route::post('/', [AdminServiceCategoryController::class, 'store'])->name('store')->middleware('can:create-services');
            Route::get('/{serviceCategory}/edit', [AdminServiceCategoryController::class, 'edit'])->name('edit')->middleware('can:edit-services');
            Route::put('/{serviceCategory}', [AdminServiceCategoryController::class, 'update'])->name('update')->middleware('can:edit-services');
            Route::delete('/{serviceCategory}', [AdminServiceCategoryController::class, 'destroy'])->name('destroy')->middleware('can:delete-services');
        });

        // Projects Module
        Route::prefix('projects')->group(function () {
            Route::get('/', [AdminProjectController::class, 'index'])->name('projects')->middleware('can:view-projects');
        });

        // Case Studies Module
        Route::prefix('case-studies')->group(function () {
            Route::get('/', [AdminCaseStudyController::class, 'index'])->name('case-studies')->middleware('can:view-case-studies');
        });

        // Industries Module
        Route::prefix('industries')->group(function () {
            Route::get('/', [AdminIndustryController::class, 'index'])->name('industries')->middleware('can:view-industries');
        });

        // CMS Pages Module
        Route::prefix('pages')->group(function () {
            Route::get('/', [AdminPageController::class, 'index'])->name('pages')->middleware('can:view-pages');
        });

        // Blog Module
        Route::prefix('blog')->group(function () {
            Route::get('/', [AdminBlogController::class, 'index'])->name('blog')->middleware('can:view-blogs');
        });

        // Careers / Jobs Module
        Route::prefix('careers')->group(function () {
            Route::get('/', [AdminCareerController::class, 'index'])->name('careers')->middleware('can:view-jobs');
        });

        // Users Module (Granular Capabilities)
        Route::prefix('users')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('users')->middleware('can:view-users');
            Route::get('/create', [AdminUserController::class, 'create'])->name('users.create')->middleware('can:create-users');
            Route::post('/', [AdminUserController::class, 'store'])->name('users.store')->middleware('can:create-users');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit')->middleware('can:edit-users');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('users.update')->middleware('can:edit-users');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy')->middleware('can:delete-users');
        });

        // Roles Module
        Route::prefix('roles')->group(function () {
            Route::get('/', [AdminRoleController::class, 'index'])->name('roles.index')->middleware('can:view-roles');
            Route::get('/create', [AdminRoleController::class, 'create'])->name('roles.create')->middleware('can:create-roles');
            Route::post('/', [AdminRoleController::class, 'store'])->name('roles.store')->middleware('can:create-roles');
            Route::get('/{role}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit')->middleware('can:edit-roles');
            Route::put('/{role}', [AdminRoleController::class, 'update'])->name('roles.update')->middleware('can:edit-roles');
            Route::delete('/{role}', [AdminRoleController::class, 'destroy'])->name('roles.destroy')->middleware('can:delete-roles');
        });

        // Permissions Module
        Route::prefix('permissions')->group(function () {
            Route::get('/', [AdminPermissionController::class, 'index'])->name('permissions.index')->middleware('can:view-roles');
        });

        // Analytics Module
        Route::prefix('analytics')->group(function () {
            Route::get('/', [AdminAnalyticsController::class, 'index'])->name('analytics')->middleware('can:view-analytics');
        });

        // Settings Module
        Route::prefix('settings')->group(function () {
            Route::get('/', [AdminSettingController::class, 'index'])->name('settings')->middleware('can:view-settings');
        });
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
