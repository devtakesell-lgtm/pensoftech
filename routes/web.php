<?php

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
