<?php

use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\LeadController as ClientLeadController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use Illuminate\Support\Facades\Route;

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
