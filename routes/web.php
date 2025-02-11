<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Pengaturan
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    // Master Data
    Route::resource('pengajar', \App\Http\Controllers\PengajarController::class);
    Route::resource('santri', \App\Http\Controllers\SantriController::class);
    Route::resource('mahrom', \App\Http\Controllers\MahromController::class);
    Route::resource('pengurus', \App\Http\Controllers\PengurusController::class);
    Route::resource('divisi', \App\Http\Controllers\DivisiController::class);

    // Koperasi, Saldo, Tabungan
    Route::resource('koperasi', \App\Http\Controllers\KoperasiController::class);
    Route::resource('saldo', \App\Http\Controllers\SaldoController::class);
    Route::resource('tabungan', \App\Http\Controllers\TabunganController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
