<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyProfileController; // <--- Tambahkan ini
use App\Http\Controllers\SupplierController;     // <--- Tambahkan ini
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;    // <--- Tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Produk
    Route::resource('products', ProductController::class);

    // Routes untuk Barang Masuk
    Route::resource('stock-ins', StockInController::class)->except(['show', 'edit', 'update', 'destroy']);

    // Routes untuk Barang Keluar
    Route::resource('stock-outs', StockOutController::class)->except(['show', 'edit', 'update', 'destroy']);

    // Routes untuk Pelaporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Routes untuk Company Profile
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company_profile.index');

    // Routes Untuk Supplier
    Route::resource('suppliers', SupplierController::class);

    // Routes Untuk Customers
    Route::resource('customers', CustomerController::class);

     // Routes untuk Pelaporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Route baru untuk generate PDF
    Route::get('/reports/pdf', [ReportController::class, 'generatePdf'])->name('reports.pdf');

    // ... (routes sebelumnya)

    // Routes untuk Manajemen User (hanya untuk Super Admin)
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']); // Hanya index, edit, update, destroy
});

require __DIR__.'/auth.php';