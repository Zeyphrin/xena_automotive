<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarRentalController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [CarRentalController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarRentalController::class, 'show'])->name('cars.show');
Route::post('/cars/{car}/book', [CarRentalController::class, 'book'])->name('cars.book');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CarRentalController::class, 'dashboard'])->name('dashboard');
});
