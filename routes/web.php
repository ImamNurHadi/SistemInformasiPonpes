<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MasterTingkatanController;
use App\Http\Controllers\KompleksKamarController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\DivisiController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\CekSaldoController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Manajemen User & Role (Admin Only)
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    // Data Santri
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/santri/create', [SantriController::class, 'create'])->name('santri.create');
        Route::post('/santri', [SantriController::class, 'store'])->name('santri.store');
    });
    Route::get('/santri', [SantriController::class, 'index'])->name('santri.index');
    Route::get('/santri/{santri}', [SantriController::class, 'show'])->name('santri.show');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/santri/{santri}/edit', [SantriController::class, 'edit'])->name('santri.edit');
        Route::put('/santri/{santri}', [SantriController::class, 'update'])->name('santri.update');
        Route::delete('/santri/{santri}', [SantriController::class, 'destroy'])->name('santri.destroy');
    });

    // Data Pengajar
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/pengajar/create', [PengajarController::class, 'create'])->name('pengajar.create');
        Route::post('/pengajar', [PengajarController::class, 'store'])->name('pengajar.store');
    });
    Route::get('/pengajar', [PengajarController::class, 'index'])->name('pengajar.index');
    Route::get('/pengajar/{pengajar}', [PengajarController::class, 'show'])->name('pengajar.show');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/pengajar/{pengajar}/edit', [PengajarController::class, 'edit'])->name('pengajar.edit');
        Route::put('/pengajar/{pengajar}', [PengajarController::class, 'update'])->name('pengajar.update');
        Route::delete('/pengajar/{pengajar}', [PengajarController::class, 'destroy'])->name('pengajar.destroy');
    });

    // Data Pengurus
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/pengurus/create', [PengurusController::class, 'create'])->name('pengurus.create');
        Route::post('/pengurus', [PengurusController::class, 'store'])->name('pengurus.store');
    });
    Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
    Route::get('/pengurus/{pengurus}', [PengurusController::class, 'show'])->name('pengurus.show');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/pengurus/{pengurus}/edit', [PengurusController::class, 'edit'])->name('pengurus.edit');
        Route::put('/pengurus/{pengurus}', [PengurusController::class, 'update'])->name('pengurus.update');
        Route::delete('/pengurus/{pengurus}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');
        Route::get('pengurus/{pengurus}/divisi', [PengurusController::class, 'showDivisiForm'])->name('pengurus.divisi');
        Route::put('pengurus/{pengurus}/divisi', [PengurusController::class, 'updateDivisi'])->name('pengurus.update-divisi');
    });

    // Data Divisi
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/divisi/create', [DivisiController::class, 'create'])->name('divisi.create');
        Route::post('/divisi', [DivisiController::class, 'store'])->name('divisi.store');
    });
    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::get('/divisi/{divisi}', [DivisiController::class, 'show'])->name('divisi.show');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/divisi/{divisi}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
        Route::put('/divisi/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');
        Route::delete('/divisi/{divisi}', [DivisiController::class, 'destroy'])->name('divisi.destroy');
    });

    // Data Tingkatan
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/tingkatan/create', [MasterTingkatanController::class, 'create'])->name('tingkatan.create');
        Route::post('/tingkatan', [MasterTingkatanController::class, 'store'])->name('tingkatan.store');
    });
    Route::get('/tingkatan', [MasterTingkatanController::class, 'index'])->name('tingkatan.index');
    Route::get('/tingkatan/{tingkatan}', [MasterTingkatanController::class, 'show'])->name('tingkatan.show');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/tingkatan/{tingkatan}/edit', [MasterTingkatanController::class, 'edit'])->name('tingkatan.edit');
        Route::put('/tingkatan/{tingkatan}', [MasterTingkatanController::class, 'update'])->name('tingkatan.update');
        Route::delete('/tingkatan/{tingkatan}', [MasterTingkatanController::class, 'destroy'])->name('tingkatan.destroy');
    });

    // Data Kompleks & Kamar
    Route::get('/kompleks-kamar', [KompleksKamarController::class, 'index'])->name('kompleks-kamar.index');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::post('/kompleks-kamar/store-kamar', [KompleksKamarController::class, 'storeKamar'])->name('kompleks-kamar.store-kamar');
        Route::get('/kompleks-kamar/{id}/edit', [KompleksKamarController::class, 'edit'])->name('kompleks-kamar.edit');
        Route::put('/kompleks-kamar/{id}', [KompleksKamarController::class, 'update'])->name('kompleks-kamar.update');
        Route::delete('/kompleks-kamar/destroy-kamar/{id}', [KompleksKamarController::class, 'destroyKamar'])->name('kompleks-kamar.destroy-kamar');
    });

    // Route untuk mendapatkan data kamar berdasarkan kompleks
    Route::get('/kamar/by-kompleks/{kompleksId}', [SantriController::class, 'getKamarByKompleks'])
        ->name('kamar.by-kompleks');

    // Koperasi, Saldo, Tabungan
    Route::resource('koperasi', \App\Http\Controllers\KoperasiController::class);
    Route::resource('saldo', \App\Http\Controllers\SaldoController::class);
    Route::resource('tabungan', \App\Http\Controllers\TabunganController::class);

    // Topup
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/topup', [TopUpController::class, 'index'])->name('topup.index');
        Route::post('/topup', [TopUpController::class, 'topup'])->name('topup.store');
    });

    // Cek Saldo
    Route::middleware(['auth'])->group(function () {
        Route::get('/ceksaldo', [CekSaldoController::class, 'index'])->name('ceksaldo.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
