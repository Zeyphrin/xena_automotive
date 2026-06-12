<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [CarRentalController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarRentalController::class, 'show'])->name('cars.show');
Route::post('/cars/{car}/book', [CarRentalController::class, 'book'])->name('cars.book');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CarRentalController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // URL: 127.0.0.1:8000/admin/dashboard
    Route::get('/dashboard', function () {
        return 'Selamat datang, Bos Admin! Gembok berfungsi dengan baik.';
    })->name('dashboard');

});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
});