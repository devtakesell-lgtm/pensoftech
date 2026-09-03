<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [App\Http\Controllers\Pages\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\Pages\AboutController::class, 'index'])->name('about');
Route::get('/contact', [App\Http\Controllers\Pages\ContactController::class, 'index'])->name('contact');
Route::get('/digital-marketing', [App\Http\Controllers\Pages\DigitalMarketingController::class, 'index'])->name('digital-marketing');
Route::get('/software-development', [App\Http\Controllers\Pages\SoftwareDevelopmentController::class, 'index'])->name('software-development');
