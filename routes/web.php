<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;

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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/cars', CarController::class);
    
    // Manajemen Transaksi Sewa & Export (Susun urutan seperti ini)
    Route::get('/rentals/export', [RentalController::class, 'export'])->name('rentals.export');
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::patch('/rentals/{rental}/status', [RentalController::class, 'updateStatus'])->name('rentals.updateStatus');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... rute yang sudah ada sebelumnya (dashboard, cars, rentals, customers)

    // Rute Tambahan untuk Peminjaman Mobil
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{rental}/approval', [PeminjamanController::class, 'approval'])->name('peminjaman.approval');
    Route::patch('/peminjaman/{rental}/approve', [PeminjamanController::class, 'processApprove'])->name('peminjaman.processApprove');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... rute lainnya yang sudah ada

    // Rute Khusus Pengembalian Mobil
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{rental}/proses', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
    Route::patch('/pengembalian/{rental}/store', [PengembalianController::class, 'store'])->name('pengembalian.store');
});
});