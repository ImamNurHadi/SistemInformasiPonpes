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
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\HistoriSaldoController;
use App\Http\Controllers\KomplekController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\HistoriBelanjaController;
use App\Http\Controllers\AkunBelanjaController;
use App\Http\Controllers\AkunUtamaController;
use App\Http\Controllers\AkunTabunganController;
use App\Http\Controllers\TarikTunaiController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\HiddenSaldoBelanjaController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\DataKoperasiController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\PembayaranPondokController;
use App\Http\Controllers\PembayaranKamarController;
use App\Http\Controllers\PembayaranRuangKelasController;
use App\Http\Controllers\PembayaranTingkatanController;
use App\Http\Controllers\PembayaranKomplekController;
use App\Http\Controllers\LaporanPembayaranSantriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AutoPaymentController;
use App\Http\Middleware\IsAdminOrOperator;

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
    Route::post('/santri/{santri}/update-ruang-kelas', [SantriController::class, 'updateRuangKelas'])->name('santri.update-ruang-kelas');

    // Data Ruang Kelas
    Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('ruang-kelas.index');
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('ruang-kelas.create');
        Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('ruang-kelas.store');
        Route::get('/ruang-kelas/{ruangKela}/edit', [RuangKelasController::class, 'edit'])->name('ruang-kelas.edit');
        Route::put('/ruang-kelas/{ruangKela}', [RuangKelasController::class, 'update'])->name('ruang-kelas.update');
        Route::delete('/ruang-kelas/{ruangKela}', [RuangKelasController::class, 'destroy'])->name('ruang-kelas.destroy');
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

    // Koperasi - View only untuk semua user
    Route::get('/koperasi', [\App\Http\Controllers\KoperasiController::class, 'index'])->name('koperasi.index');
    Route::get('/koperasi/{koperasi}', [\App\Http\Controllers\KoperasiController::class, 'show'])->name('koperasi.show');
    Route::post('/koperasi/bayar', [\App\Http\Controllers\KoperasiController::class, 'bayar'])->name('koperasi.bayar');
    
    // Koperasi - Modify only untuk admin
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/koperasi/create', [\App\Http\Controllers\KoperasiController::class, 'create'])->name('koperasi.create');
        Route::post('/koperasi', [\App\Http\Controllers\KoperasiController::class, 'store'])->name('koperasi.store');
        Route::get('/koperasi/{koperasi}/edit', [\App\Http\Controllers\KoperasiController::class, 'edit'])->name('koperasi.edit');
        Route::put('/koperasi/{koperasi}', [\App\Http\Controllers\KoperasiController::class, 'update'])->name('koperasi.update');
        Route::delete('/koperasi/{koperasi}', [\App\Http\Controllers\KoperasiController::class, 'destroy'])->name('koperasi.destroy');
    });

    // Saldo, Tabungan
    Route::resource('saldo', \App\Http\Controllers\SaldoController::class);
    Route::resource('tabungan', \App\Http\Controllers\TabunganController::class);

    // Histori Saldo
    Route::get('/histori-saldo', [\App\Http\Controllers\HistoriSaldoController::class, 'index'])->name('histori-saldo.index');
    Route::get('/histori-saldo/print', [\App\Http\Controllers\HistoriSaldoController::class, 'printPDF'])->name('histori-saldo.print');

    // Topup - Only for Operator
    Route::middleware(['auth', \App\Http\Middleware\IsOperator::class])->group(function () {
        Route::get('/topup', [TopUpController::class, 'index'])->name('topup.index');
        Route::post('/topup', [TopUpController::class, 'topup'])->name('topup.store');
    });

    // Cek Saldo
    Route::middleware(['auth'])->group(function () {
        Route::get('/cek-saldo', [CekSaldoController::class, 'index'])->name('cek-saldo.index');
        Route::get('/cek-saldo/print', [CekSaldoController::class, 'printPDF'])->name('cek-saldo.print');
    });

    // Menu Kantin (Outlet Only)
    Route::middleware(['auth', \App\Http\Middleware\IsOutlet::class])->group(function () {
        Route::get('/kantin', [\App\Http\Controllers\KantinController::class, 'index'])->name('kantin.index');
        Route::post('/kantin/bayar', [\App\Http\Controllers\KantinController::class, 'bayar'])->name('kantin.bayar');
    });

    // Route untuk Kamar dan Komplek
    Route::resource('kamar', KamarController::class);
    Route::resource('komplek', KomplekController::class);
    Route::get('/kamar/komplek/{komplek_id}', [KamarController::class, 'getByKomplek'])->name('kamar.by-komplek');

    // Histori Belanja
    Route::get('/histori-belanja', [HistoriBelanjaController::class, 'index'])->name('histori-belanja.index');
    Route::get('/histori-belanja/print', [HistoriBelanjaController::class, 'printPDF'])->name('histori-belanja.print');

    // Akun Routes
    Route::prefix('akun')->group(function () {
        Route::get('/belanja', [AkunBelanjaController::class, 'index'])->name('akun-belanja.index');
        Route::get('/utama', [AkunUtamaController::class, 'index'])->name('akun-utama.index');
        Route::get('/tabungan', [AkunTabunganController::class, 'index'])->name('akun-tabungan.index');
    });

    // Tarik Tunai routes - Only for Operator
    Route::middleware(['auth', \App\Http\Middleware\IsOperator::class])->group(function () {
        Route::get('/tarik-tunai', [TarikTunaiController::class, 'index'])->name('tarik-tunai.index');
        Route::post('/tarik-tunai', [TarikTunaiController::class, 'store'])->name('tarik-tunai.store');
    });

    // Hidden Saldo Belanja - Accessible by all authenticated users
    Route::middleware(['auth'])->group(function () {
        Route::get('/hidden-saldo-belanja', [HiddenSaldoBelanjaController::class, 'index'])->name('hidden-saldo-belanja.index');
        Route::get('/hidden-saldo-belanja/{santri}', [HiddenSaldoBelanjaController::class, 'showForm'])->name('hidden-saldo-belanja.form');
        Route::post('/hidden-saldo-belanja', [HiddenSaldoBelanjaController::class, 'store'])->name('hidden-saldo-belanja.store');
    });

    // Laporan Routes
    Route::middleware(['auth', RoleMiddleware::class])->group(function () {
        Route::get('/laporan-transaksi', [App\Http\Controllers\LaporanTransaksiController::class, 'index'])->name('laporan-transaksi.index');
        Route::get('/laporan-transaksi/print', [App\Http\Controllers\LaporanTransaksiController::class, 'print'])->name('laporan-transaksi.print');
        
        Route::get('/laporan-pembayaran', [App\Http\Controllers\LaporanPembayaranController::class, 'index'])->name('laporan-pembayaran.index');
        Route::get('/laporan-pembayaran/print', [App\Http\Controllers\LaporanPembayaranController::class, 'print'])->name('laporan-pembayaran.print');
        
        Route::get('/laporan-tarik-tunai', [App\Http\Controllers\LaporanTarikTunaiController::class, 'index'])->name('laporan-tarik-tunai.index');
        Route::get('/laporan-tarik-tunai/print', [App\Http\Controllers\LaporanTarikTunaiController::class, 'print'])->name('laporan-tarik-tunai.print');
        
        Route::get('/laporan-akun-saldo', [App\Http\Controllers\LaporanAkunSaldoController::class, 'index'])->name('laporan-akun-saldo.index');
        Route::get('/laporan-akun-saldo/print', [App\Http\Controllers\LaporanAkunSaldoController::class, 'print'])->name('laporan-akun-saldo.print');
    });

    // Data Koperasi routes - Admin & Operator Only
    Route::middleware(['auth', \App\Http\Middleware\IsOperator::class])->group(function () {
        Route::get('/data-koperasi', [DataKoperasiController::class, 'index'])->name('data-koperasi.index');
        Route::get('/data-koperasi/create', [DataKoperasiController::class, 'create'])->name('data-koperasi.create');
        Route::post('/data-koperasi', [DataKoperasiController::class, 'store'])->name('data-koperasi.store');
        Route::get('/data-koperasi/{dataKoperasi}', [DataKoperasiController::class, 'show'])->name('data-koperasi.show');
        Route::get('/data-koperasi/{dataKoperasi}/edit', [DataKoperasiController::class, 'edit'])->name('data-koperasi.edit');
        Route::put('/data-koperasi/{dataKoperasi}', [DataKoperasiController::class, 'update'])->name('data-koperasi.update');
        Route::delete('/data-koperasi/{dataKoperasi}', [DataKoperasiController::class, 'destroy'])->name('data-koperasi.destroy');
        Route::post('/data-koperasi/{dataKoperasi}/cairkan-keuntungan', [DataKoperasiController::class, 'cairkanKeuntungan'])->name('data-koperasi.cairkan-keuntungan');
        Route::post('/data-koperasi/{dataKoperasi}/top-up', [DataKoperasiController::class, 'topUpSaldo'])->name('data-koperasi.top-up');
        
        // Supplier routes
        Route::resource('supplier', SupplierController::class);
        Route::post('supplier/{supplier}/top-up', [SupplierController::class, 'topUpSaldo'])->name('supplier.top-up');
    });

    // Supply routes - Only for users with the 'operator' role
    Route::middleware(['auth', \App\Http\Middleware\IsOperator::class])->group(function () {
        Route::resource('supply', SupplyController::class);
    });

    // Transfer routes - Only for users with the 'santri' role
    Route::middleware(['auth', \App\Http\Middleware\IsSantri::class])->group(function () {
        Route::get('/transfer', [TransferController::class, 'index'])->name('transfer.index');
        Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
    });

    // Pembayaran (Admin & Operator Only)
    Route::middleware(['auth', \App\Http\Middleware\IsAdminOrOperator::class])->group(function () {
        // Pembayaran Pondok
        Route::get('/pembayaran-pondok', [PembayaranPondokController::class, 'index'])->name('pembayaran-pondok.index');
        Route::get('/pembayaran-pondok/search', [PembayaranPondokController::class, 'search'])->name('pembayaran-pondok.search');
        Route::post('/pembayaran-pondok', [PembayaranPondokController::class, 'store'])->name('pembayaran-pondok.store');
        
        // Pembayaran Kamar
        Route::get('/pembayaran-kamar', [PembayaranKamarController::class, 'index'])->name('pembayaran-kamar.index');
        Route::get('/pembayaran-kamar/search', [PembayaranKamarController::class, 'search'])->name('pembayaran-kamar.search');
        Route::post('/pembayaran-kamar', [PembayaranKamarController::class, 'store'])->name('pembayaran-kamar.store');
        
        // Pembayaran Ruang Kelas
        Route::get('/pembayaran-ruang-kelas', [PembayaranRuangKelasController::class, 'index'])->name('pembayaran-ruang-kelas.index');
        Route::get('/pembayaran-ruang-kelas/search', [PembayaranRuangKelasController::class, 'search'])->name('pembayaran-ruang-kelas.search');
        Route::post('/pembayaran-ruang-kelas', [PembayaranRuangKelasController::class, 'store'])->name('pembayaran-ruang-kelas.store');
        
        // Pembayaran Tingkatan
        Route::get('/pembayaran-tingkatan', [PembayaranTingkatanController::class, 'index'])->name('pembayaran-tingkatan.index');
        Route::get('/pembayaran-tingkatan/search', [PembayaranTingkatanController::class, 'search'])->name('pembayaran-tingkatan.search');
        Route::post('/pembayaran-tingkatan', [PembayaranTingkatanController::class, 'store'])->name('pembayaran-tingkatan.store');
        
        // Pembayaran Komplek
        Route::get('/pembayaran-komplek', [PembayaranKomplekController::class, 'index'])->name('pembayaran-komplek.index');
        Route::get('/pembayaran-komplek/search', [PembayaranKomplekController::class, 'search'])->name('pembayaran-komplek.search');
        Route::post('/pembayaran-komplek', [PembayaranKomplekController::class, 'store'])->name('pembayaran-komplek.store');
    });

    // Laporan (Admin & Operator Only)
    Route::middleware(['auth', \App\Http\Middleware\IsAdminOrOperator::class])->group(function () {
        // Laporan Pembayaran Santri
        Route::get('/laporan-pembayaran-santri', [LaporanPembayaranSantriController::class, 'index'])->name('laporan-pembayaran-santri.index');
        Route::get('/laporan-pembayaran-santri/print', [LaporanPembayaranSantriController::class, 'print'])->name('laporan-pembayaran-santri.print');
    });

    // Pembayaran features
    Route::middleware(IsAdminOrOperator::class)->group(function () {
        // Auto Payment Settings
        Route::get('/pembayaran-auto', [AutoPaymentController::class, 'index'])->name('pembayaran-auto.index');
        Route::post('/pembayaran-auto', [AutoPaymentController::class, 'store'])->name('pembayaran-auto.store');
        Route::put('/pembayaran-auto/{setting}', [AutoPaymentController::class, 'update'])->name('pembayaran-auto.update');
        Route::patch('/pembayaran-auto/{setting}/toggle-status', [AutoPaymentController::class, 'toggleStatus'])->name('pembayaran-auto.toggle-status');
        Route::post('/pembayaran-auto/process', [AutoPaymentController::class, 'processPayments'])->name('pembayaran-auto.process');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/info', [ProfileController::class, 'editInfo'])->name('profile.edit-info');
    Route::get('/profile/security', [ProfileController::class, 'editSecurity'])->name('profile.edit-security');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test route for checking ruang_kelas table
Route::get('/test-ruang-kelas', function () {
    $ruangKelas = \App\Models\RuangKelas::all();
    return response()->json($ruangKelas);
});

// Test route for checking santri table
Route::get('/test-santri', function () {
    $santri = \App\Models\Santri::with('ruangKelas')->get();
    return response()->json($santri);
});

// Test route for updating a santri record
Route::get('/test-update-santri/{id}', function ($id) {
    $santri = \App\Models\Santri::findOrFail($id);
    $ruangKelas = \App\Models\RuangKelas::first();
    
    if ($ruangKelas) {
        $santri->ruang_kelas_id = $ruangKelas->id;
        $santri->save();
        return response()->json(['success' => true, 'santri' => $santri, 'ruang_kelas' => $ruangKelas]);
    } else {
        return response()->json(['success' => false, 'message' => 'No RuangKelas found']);
    }
});

// Test route for creating a new RuangKelas
Route::get('/test-create-ruang-kelas', function () {
    $ruangKelas = new \App\Models\RuangKelas();
    $ruangKelas->nama_ruang_kelas = 'KELAS TEST ' . rand(1, 100);
    $ruangKelas->keterangan = 'Kelas untuk testing';
    $ruangKelas->save();
    
    return response()->json(['success' => true, 'ruang_kelas' => $ruangKelas]);
});

require __DIR__.'/auth.php';
