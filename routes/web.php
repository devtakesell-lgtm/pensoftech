<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\DigitalMarketingController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\SoftwareDevelopmentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/digital-marketing', [DigitalMarketingController::class, 'index'])->name('digital-marketing');
Route::get('/software-development', [SoftwareDevelopmentController::class, 'index'])->name('software-development');

Route::prefix('admin')->name('admin.')->group(function () {
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
