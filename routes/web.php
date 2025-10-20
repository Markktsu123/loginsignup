<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpeechConversionController;
use App\Http\Controllers\SignLanguageController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Authentication pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'validate.session'])->name('dashboard');

// Profile routes
Route::middleware(['auth', 'validate.session'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Session validation routes
Route::get('/api/session/validate', [SessionController::class, 'validateSession'])->name('session.validate');
Route::post('/api/session/logout', [SessionController::class, 'forceLogout'])->name('session.logout');

// Protected routes - require authentication and session validation
Route::middleware(['auth', 'verified', 'validate.session'])->group(function () {
    // Speech Conversion Route
    Route::get('/speech-conversion', [SpeechConversionController::class, 'index'])->name('speech.conversion');
    Route::get('/sign-language', [SignLanguageController::class, 'sign'])->name('sign.language');
});



require __DIR__.'/auth.php';
