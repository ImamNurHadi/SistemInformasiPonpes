<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\HistoriTransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransferQRController extends Controller
{
    /**
     * Menampilkan halaman transfer QR
     */
    public function index()
    {
        $user = Auth::user();
        $saldo = $this->getUserSaldo($user);
        
        return view('transfer.qrcode.index', compact('saldo'));
    }
    
    /**
     * Menampilkan QR Code untuk login
     */
    public function showQRCode()
    {
        $user = Auth::user();
        
        // Gunakan format QR yang sama dengan generateLoginQR
        // Hindari generate token yang berbeda setiap kali
        $qrData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'token' => hash('sha256', $user->id . env('APP_KEY'))
        ];
        
        // Generate QR code
        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->margin(2)
                        ->generate(json_encode($qrData));
        
        return view('transfer.qrcode.show', compact('qrCode', 'qrData'));
    }
    
    /**
     * Menampilkan form transfer setelah scan QR
     */
    public function showTransferForm(Request $request)
    {
        $user = Auth::user();
        $saldo = $this->getUserSaldo($user);
        
        // Validasi parameter user_id dan token
        if (!$request->has('user_id') || !$request->has('token')) {
            return redirect()->route('transfer.qrcode')->with('error', 'Parameter tidak valid');
        }
        
        $targetUserId = $request->user_id;
        $targetSantri = Santri::whereHas('user', function($query) use ($targetUserId) {
            $query->where('id', $targetUserId);
        })->first();
        
        if (!$targetSantri) {
            return redirect()->route('transfer.qrcode')->with('error', 'Pengguna tidak ditemukan');
        }
        
        return view('transfer.qrcode.form', compact('saldo', 'targetSantri'));
    }
    
    /**
     * Memproses transfer saldo
     */
    public function processTransfer(Request $request)
    {
        $request->validate([
            'target_id' => 'required',
            'amount' => 'required|numeric|min:1000',
            'source_type' => 'required|in:utama,belanja,tabungan',
            'target_type' => 'required|in:utama,belanja,tabungan'
        ]);
        
        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            $user = Auth::user();
            $sourceSantri = Santri::where('user_id', $user->id)->first();
            $targetSantri = Santri::findOrFail($request->target_id);
            
            // Self transfer atau transfer ke orang lain
            $isSelfTransfer = $sourceSantri->id === $targetSantri->id;
            
            // Validasi saldo sumber cukup
            $sourceSaldoField = 'saldo_' . $request->source_type;
            
            if ($sourceSantri->{$sourceSaldoField} < $request->amount) {
                return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk transfer');
            }
            
            // Kurangi saldo sumber
            $sourceSantri->{$sourceSaldoField} -= $request->amount;
            $sourceSantri->save();
            
            // Tambahkan saldo target
            $targetSaldoField = 'saldo_' . $request->target_type;
            $targetSantri->{$targetSaldoField} += $request->amount;
            $targetSantri->save();
            
            // Catat histori transfer
            HistoriTransfer::create([
                'santri_pengirim_id' => $sourceSantri->id,
                'santri_penerima_id' => $targetSantri->id,
                'jumlah' => $request->amount,
                'tipe_sumber' => $request->source_type,
                'tipe_tujuan' => $request->target_type,
                'keterangan' => $request->keterangan ?? ($isSelfTransfer ? 'Transfer antar saldo' : 'Transfer via QR Code'),
                'tanggal' => now()
            ]);
            
            DB::commit();
            
            return redirect()->route('transfer.qrcode')->with('success', 'Transfer berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Mendapatkan saldo user berdasarkan jenis user
     */
    private function getUserSaldo($user)
    {
        $saldo = [];
        
        // Cek saldo di tabel Santri
        $santri = Santri::where('user_id', $user->id)->first();
        if ($santri) {
            // Untuk koperasi/supplier, selalu tambahkan saldo belanja
            if ($user->hasRole('koperasi') || $user->hasRole('supplier')) {
                $saldo['belanja'] = $santri->saldo_belanja;
            } else {
                // Untuk santri, tambahkan semua jenis saldo yang nilainya > 0
                if ($santri->saldo_utama > 0) $saldo['utama'] = $santri->saldo_utama;
                if ($santri->saldo_belanja > 0) $saldo['belanja'] = $santri->saldo_belanja;
                if ($santri->saldo_tabungan > 0) $saldo['tabungan'] = $santri->saldo_tabungan;
            }
        }
        
        return $saldo;
    }

    /**
     * Menampilkan halaman login dengan QR
     */
    public function showLoginQR()
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            return redirect()->route('transfer.qrcode');
        }
        
        return view('transfer.qrcode.login');
    }

    /**
     * Verifikasi login dengan QR code
     */
    public function verifyQRLogin(Request $request)
    {
        try {
            // Ambil data QR dari request
            $qrData = json_decode($request->input('qr_data'), true);
            
            \Log::debug('QR Login Data:', ['data' => $qrData]);
            
            // Validasi data QR
            if (!$qrData) {
                return response()->json(['success' => false, 'message' => 'Format QR Code tidak valid'], 400);
            }
            
            // Handle format QR santri dari model Santri
            if (isset($qrData['type']) && $qrData['type'] === 'santri_qr') {
                // QR Code dari model Santri (generateQrCode)
                if (!isset($qrData['id'])) {
                    return response()->json(['success' => false, 'message' => 'ID santri tidak ditemukan dalam QR Code'], 400);
                }
                
                $santri = \App\Models\Santri::find($qrData['id']);
                if (!$santri) {
                    return response()->json(['success' => false, 'message' => 'Santri tidak ditemukan'], 404);
                }
                
                // Login sebagai user santri
                Auth::login($santri->user);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Login berhasil sebagai ' . $santri->nama,
                    'redirect' => route('transfer.qrcode.standalone')
                ]);
            } 
            // Handle format QR koperasi
            elseif (isset($qrData['type']) && $qrData['type'] === 'koperasi_qr') {
                // QR Code dari model Koperasi
                if (!isset($qrData['id'])) {
                    return response()->json(['success' => false, 'message' => 'ID koperasi tidak ditemukan dalam QR Code'], 400);
                }
                
                $koperasi = \App\Models\DataKoperasi::find($qrData['id']);
                if (!$koperasi) {
                    return response()->json(['success' => false, 'message' => 'Koperasi tidak ditemukan'], 404);
                }
                
                // Login sebagai user koperasi
                Auth::login($koperasi->user);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Login berhasil sebagai ' . $koperasi->nama,
                    'redirect' => route('transfer.qrcode.standalone')
                ]);
            }
            // Format QR dari TransferQRController
            elseif (isset($qrData['user_id'])) {
                // Cari user berdasarkan ID
                $user = \App\Models\User::find($qrData['user_id']);
                
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan'], 404);
                }
                
                // Login user
                Auth::login($user);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Login berhasil',
                    'redirect' => route('transfer.qrcode.standalone')
                ]);
            }
            else {
                return response()->json(['success' => false, 'message' => 'Format QR Code tidak didukung'], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Error verifikasi QR login:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate QR Code login untuk user saat ini
     */
    public function generateLoginQR()
    {
        $user = Auth::user();
        
        // Informasi yang akan ditampilkan di QR Code
        // Gunakan format yang konsisten dengan showQRCode
        $qrData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'token' => hash('sha256', $user->id . env('APP_KEY'))
        ];
        
        // Generate QR code
        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->margin(2)
                        ->generate(json_encode($qrData));
        
        // Tampilkan view dengan QR code
        return view('transfer.qrcode.my-qrcode', compact('qrCode', 'qrData'));
    }
    
    /**
     * API untuk mendapatkan data santri berdasarkan ID
     */
    public function getSantriData($id)
    {
        try {
            $santri = Santri::findOrFail($id);
            
            \Log::info('Mengambil data santri via API:', [
                'santri_id' => $santri->id,
                'nama' => $santri->nama
            ]);
            
            return response()->json([
                'success' => true,
                'user_id' => $santri->user_id,
                'nama' => $santri->nama,
                'id' => $santri->id,
                'tempat_lahir' => $santri->tempat_lahir,
                'tingkatan' => $santri->tingkatan ? $santri->tingkatan->nama : null
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil data santri via API:', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Santri tidak ditemukan atau terjadi kesalahan'
            ], 404);
        }
    }
    
    /**
     * Proses transfer ke santri
     */
    public function processTransferAPI(Request $request)
    {
        try {
            $validated = $request->validate([
                'target_id' => 'required',
                'amount' => 'required|numeric|min:1000',
                'source_type' => 'required|in:utama,belanja,tabungan',
                'target_type' => 'required|in:utama,belanja,tabungan',
                'keterangan' => 'nullable|string'
            ]);
            
            // Mulai transaksi database
            DB::beginTransaction();
            
            $user = Auth::user();
            $sourceSantri = Santri::where('user_id', $user->id)->first();
            $targetSantri = Santri::where('user_id', $request->target_id)->first();
            
            if (!$targetSantri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Penerima tidak ditemukan'
                ], 404);
            }
            
            // Self transfer atau transfer ke orang lain
            $isSelfTransfer = $sourceSantri->id === $targetSantri->id;
            
            // Validasi saldo sumber cukup
            $sourceSaldoField = 'saldo_' . $request->source_type;
            
            if ($sourceSantri->{$sourceSaldoField} < $request->amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saldo tidak mencukupi untuk transfer'
                ], 400);
            }
            
            // Kurangi saldo sumber
            $sourceSantri->{$sourceSaldoField} -= $request->amount;
            $sourceSantri->save();
            
            // Tambahkan saldo target
            $targetSaldoField = 'saldo_' . $request->target_type;
            $targetSantri->{$targetSaldoField} += $request->amount;
            $targetSantri->save();
            
            // Catat histori transfer
            HistoriTransfer::create([
                'santri_pengirim_id' => $sourceSantri->id,
                'santri_penerima_id' => $targetSantri->id,
                'jumlah' => $request->amount,
                'tipe_sumber' => $request->source_type,
                'tipe_tujuan' => $request->target_type,
                'keterangan' => $request->keterangan ?? ($isSelfTransfer ? 'Transfer antar saldo' : 'Transfer via QR Code'),
                'tanggal' => now()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Transfer berhasil dilakukan'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan halaman transfer QR code tanpa perlu masuk ke sistem utama
     */
    public function standaloneQRTransfer()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login.qrcode');
        }
        
        $user = Auth::user();
        $saldo = $this->getUserSaldo($user);
        
        return view('transfer.qrcode.standalone', compact('saldo', 'user'));
    }

    /**
     * Memproses transfer saldo dari halaman standalone
     */
    public function processStandaloneTransfer(Request $request)
    {
        // Validasi JSON input
        $request->validate([
            'target_id' => 'required',
            'amount' => 'required|numeric|min:1000',
            'source_type' => 'required',
            'target_type' => 'required|in:utama,belanja,tabungan'
        ]);
        
        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            $user = Auth::user();
            
            // Jika user adalah koperasi/supplier dan source type adalah belanja
            if (($user->hasRole('koperasi') || $user->hasRole('supplier')) && $request->source_type === 'belanja') {
                $sourceSantri = Santri::where('user_id', $user->id)->first();
                
                if (!$sourceSantri) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data akun tidak ditemukan'
                    ], 404);
                }
                
                // Validasi saldo belanja
                if ($sourceSantri->saldo_belanja < $request->amount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Saldo belanja tidak mencukupi untuk transfer'
                    ], 400);
                }
                
                // Temukan santri tujuan
                $targetSantri = Santri::where('user_id', $request->target_id)->first();
                
                if (!$targetSantri) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data santri penerima tidak ditemukan'
                    ], 404);
                }
                
                // Kurangi saldo belanja pengirim
                $sourceSantri->saldo_belanja -= $request->amount;
                $sourceSantri->save();
                
                // Tambahkan saldo ke akun target
                $targetSaldoField = 'saldo_' . $request->target_type;
                $targetSantri->{$targetSaldoField} += $request->amount;
                $targetSantri->save();
                
                // Catat histori transfer
                HistoriTransfer::create([
                    'santri_pengirim_id' => $sourceSantri->id,
                    'santri_penerima_id' => $targetSantri->id,
                    'jumlah' => $request->amount,
                    'tipe_sumber' => 'belanja',
                    'tipe_tujuan' => $request->target_type,
                    'keterangan' => $request->keterangan ?? 'Transfer QR dari ' . $user->name,
                    'tanggal' => now()
                ]);
                
                DB::commit();
                
                // Ambil saldo terbaru
                $updatedSaldo = $this->getUserSaldo($user);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Transfer berhasil dilakukan',
                    'saldo' => $updatedSaldo
                ]);
            }
            // Jika bukan koperasi/supplier, proses sebagai transfer santri biasa
            else {
                $sourceSantri = Santri::where('user_id', $user->id)->first();
                
                if (!$sourceSantri) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data santri pengirim tidak ditemukan'
                    ], 404);
                }
                
                // Perbaiki error UUID dengan memastikan format target_id benar
                try {
                    // Mencoba menemukan santri dari user_id, bukan langsung mencari santri by ID
                    $targetSantri = Santri::where('user_id', $request->target_id)->first();
                    
                    if (!$targetSantri) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Data santri penerima tidak ditemukan'
                        ], 404);
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Format ID penerima tidak valid'
                    ], 400);
                }
                
                // Self transfer atau transfer ke orang lain
                $isSelfTransfer = $sourceSantri->id === $targetSantri->id;
                
                // Validasi saldo sumber cukup
                $sourceSaldoField = 'saldo_' . $request->source_type;
                
                if ($sourceSantri->{$sourceSaldoField} < $request->amount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Saldo tidak mencukupi untuk transfer'
                    ], 400);
                }
                
                // Kurangi saldo sumber
                $sourceSantri->{$sourceSaldoField} -= $request->amount;
                $sourceSantri->save();
                
                // Tambahkan saldo target
                $targetSaldoField = 'saldo_' . $request->target_type;
                $targetSantri->{$targetSaldoField} += $request->amount;
                $targetSantri->save();
                
                // Catat histori transfer
                HistoriTransfer::create([
                    'santri_pengirim_id' => $sourceSantri->id,
                    'santri_penerima_id' => $targetSantri->id,
                    'jumlah' => $request->amount,
                    'tipe_sumber' => $request->source_type,
                    'tipe_tujuan' => $request->target_type,
                    'keterangan' => $request->keterangan ?? ($isSelfTransfer ? 'Transfer antar saldo' : 'Transfer via QR Code'),
                    'tanggal' => now()
                ]);
                
                DB::commit();
                
                // Ambil saldo terbaru
                $updatedSaldo = $this->getUserSaldo($user);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Transfer berhasil dilakukan',
                    'saldo' => $updatedSaldo
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan jenis saldo yang tersedia untuk user
     */
    public function getAvailableSaldo($userId)
    {
        try {
            $santri = Santri::where('user_id', $userId)->first();
            $availableSaldo = [];
            
            if ($santri) {
                if ($santri->saldo_utama > 0) $availableSaldo[] = 'utama';
                if ($santri->saldo_belanja > 0) $availableSaldo[] = 'belanja';
                if ($santri->saldo_tabungan > 0) $availableSaldo[] = 'tabungan';
            }
            
            // Jika tidak ada saldo, berikan default saldo belanja
            if (empty($availableSaldo)) {
                $availableSaldo[] = 'belanja';
            }
            
            return response()->json([
                'success' => true,
                'available_saldo' => $availableSaldo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan informasi saldo'
            ], 500);
        }
    }
    
    /**
     * API untuk mendapatkan jenis saldo yang tersedia untuk santri by ID
     */
    public function getSantriSaldo($santriId)
    {
        try {
            $santri = Santri::find($santriId);
            $availableSaldo = [];
            
            if ($santri) {
                if ($santri->saldo_utama > 0) $availableSaldo[] = 'utama';
                if ($santri->saldo_belanja > 0) $availableSaldo[] = 'belanja';
                if ($santri->saldo_tabungan > 0) $availableSaldo[] = 'tabungan';
            }
            
            // Jika tidak ada saldo, berikan default saldo belanja
            if (empty($availableSaldo)) {
                $availableSaldo[] = 'belanja';
            }
            
            return response()->json([
                'success' => true,
                'available_saldo' => $availableSaldo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan informasi saldo santri'
            ], 500);
        }
    }
}
