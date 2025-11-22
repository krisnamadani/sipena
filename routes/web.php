<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AkunBelanjaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Akun Belanja
    Route::resource('akun-belanja', AkunBelanjaController::class);
    Route::get('/akun-belanja-import', [AkunBelanjaController::class, 'importForm'])->name('akun-belanja.import.form');
    Route::post('/akun-belanja-import', [AkunBelanjaController::class, 'import'])->name('akun-belanja.import');

    // Validasi
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::post('/validasi/proses', [ValidasiController::class, 'proses'])->name('validasi.proses');

    Route::resource('users', UserController::class);
});

Route::get('/home', [DashboardController::class, 'index'])->name('home');