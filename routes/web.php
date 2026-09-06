<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/digital-marketing', [PageController::class, 'digitalMarketing'])->name('digital-marketing');
Route::get('/software-development', [PageController::class, 'softwareDevelopment'])->name('software-development');

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
