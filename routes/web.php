<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Change Password
    Route::get('/profile/change-password', [AuthController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.update-password');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Category CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Blog CRUD
    Route::resource('blogs', BlogController::class);
});

