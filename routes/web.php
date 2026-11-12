<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\RiwayatPenguranganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Mechanic Engineer Inventory (PT Garuda Yamato Steel)
|--------------------------------------------------------------------------
|
| Rute sistem diatur dengan pemisahan hak akses:
| 1. Guest: Rute autentikasi (Login).
| 2. Authenticated: Rute inventaris yang bisa diakses seluruh user yang login (Admin & Staff Mekanik).
| 3. Admin Middleware: Rute mutasi data (Create, Update, Delete) khusus Administrator.
|
*/

// =========================================================================
// 1. Rute Guest (Belum Login)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// =========================================================================
// 2. Rute Authenticated (Sudah Login: Admin & Staff Mekanik)
// =========================================================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Katalog Data Barang & Rak (Read-Only untuk Staff)
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/rack', [RackController::class, 'index'])->name('rack.index');

    // Transaksi Pengambilan Suku Cadang & Log Riwayat
    Route::get('/riwayat-pengambilan', [RiwayatPenguranganController::class, 'index'])->name('pengurangan.index');
    Route::get('/barang/{id_barang}/ambil', [RiwayatPenguranganController::class, 'create'])->name('pengurangan.create');
    Route::post('/barang/{id_barang}/ambil', [RiwayatPenguranganController::class, 'store'])->name('pengurangan.store');

    // =====================================================================
    // 3. Rute Khusus Administrator (Kelola Master Data Barang & Rak)
    // =====================================================================
    Route::middleware('admin')->group(function () {
        // Mutasi Data Barang (Create, Edit, Update, Delete)
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/{id_barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/{id_barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

        // Mutasi Titik Rak (Create, Edit, Update, Delete)
        Route::get('/rack/create', [RackController::class, 'create'])->name('rack.create');
        Route::post('/rack', [RackController::class, 'store'])->name('rack.store');
        Route::get('/rack/{id_rack}/edit', [RackController::class, 'edit'])->name('rack.edit');
        Route::put('/rack/{id_rack}', [RackController::class, 'update'])->name('rack.update');
        Route::delete('/rack/{id_rack}', [RackController::class, 'destroy'])->name('rack.destroy');
    });
});
