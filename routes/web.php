<?php

use App\Http\Controllers\CarRentalController;

Route::get('/', [CarRentalController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarRentalController::class, 'show'])->name('cars.show');
Route::post('/cars/{car}/book', [CarRentalController::class, 'book'])->name('cars.book');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CarRentalController::class, 'dashboard'])->name('dashboard');
});
