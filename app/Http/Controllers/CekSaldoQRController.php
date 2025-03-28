<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Santri;
use App\Models\Pengurus;
use App\Models\Supplier;
use App\Models\DataKoperasi;
use App\Models\SaldoUtama;
use App\Models\SaldoBelanja;
use App\Models\SaldoTabungan;

class CekSaldoQRController extends Controller
{
    /**
     * Tampilkan halaman scanner QR Code
     */
    public function index()
    {
        return view('cek-saldo-qr.index');
    }
    
    /**
     * Periksa saldo berdasarkan QR Code yang di-scan
     */
    public function checkSaldo(Request $request)
    {
        try {
            $request->validate([
                'qr_code' => 'required|string',
            ]);
            
            // Log QR Code untuk debugging
            \Log::info('QR Code received:', ['qr_code' => $request->qr_code]);
            
            // Mendapatkan value dari QR Code
            $qrValue = $request->qr_code;
            
            // Coba parse QR code dengan beberapa format yang mungkin
            $userId = $this->parseQRCode($qrValue);
            
            \Log::info('Parsed user ID:', ['user_id' => $userId]);
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak dikenali.',
                    'debug' => ['qr_value' => $qrValue]
                ]);
            }
            
            // Cari user berdasarkan ID
            $user = User::find($userId);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.',
                    'debug' => ['user_id' => $userId]
                ]);
            }
            
            // Log user dan role data
            \Log::info('User found:', [
                'id' => $user->id, 
                'name' => $user->name, 
                'role_id' => $user->role_id,
                'has_role_relation' => $user->role ? true : false,
                'role_name' => $user->role ? $user->role->name : 'null'
            ]);
            
            // Cek tipe pengguna dan ambil saldo mereka
            $userInfo = $this->getUserInfo($user);
            $userSaldo = $this->getUserSaldo($user);
            
            if (empty($userSaldo)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada informasi saldo untuk pengguna ini.',
                    'debug' => ['user_id' => $userId, 'name' => $user->name, 'role' => $user->role ? $user->role->name : 'null']
                ]);
            }
            
            return response()->json([
                'success' => true,
                'user' => $userInfo,
                'saldo' => $userSaldo,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in checkSaldo:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'debug' => ['exception' => $e->getMessage()]
            ]);
        }
    }
    
    /**
     * Parse berbagai format QR code untuk mendapatkan user ID
     */
    private function parseQRCode($qrValue)
    {
        try {
            \Log::debug('Parsing QR value:', ['raw_value' => $qrValue]);
            
            // Coba parse JSON
            try {
                $jsonData = json_decode($qrValue, true);
                if (is_array($jsonData)) {
                    \Log::debug('QR is valid JSON:', ['parsed_data' => $jsonData]);
                    
                    // Format dari kantin/koperasi
                    if (isset($jsonData['type'])) {
                        // Format: santri_qr, pengurus_qr, supplier_qr, koperasi_qr
                        if (isset($jsonData['id'])) {
                            $id = $jsonData['id'];
                            \Log::debug('QR contains type and id:', ['type' => $jsonData['type'], 'id' => $id]);
                            
                            // Cari user_id berdasarkan tipe
                            if ($jsonData['type'] === 'santri_qr' || $jsonData['type'] === 'santri') {
                                $santri = Santri::find($id);
                                return $santri ? $santri->user_id : null;
                            } elseif ($jsonData['type'] === 'pengurus_qr') {
                                $pengurus = Pengurus::find($id);
                                return $pengurus ? $pengurus->user_id : null;
                            } elseif ($jsonData['type'] === 'supplier_qr') {
                                $supplier = Supplier::find($id);
                                return $supplier ? $supplier->user_id : null;
                            } elseif ($jsonData['type'] === 'koperasi_qr') {
                                $koperasi = DataKoperasi::find($id);
                                return $koperasi ? $koperasi->user_id : null;
                            }
                        }
                    } 
                    // Format JSON tanpa tipe tapi ada id
                    elseif (isset($jsonData['id'])) {
                        // Coba cari di semua model
                        $id = $jsonData['id'];
                        \Log::debug('QR contains id without type:', ['id' => $id]);
                        
                        $santri = Santri::find($id);
                        if ($santri) return $santri->user_id;
                        
                        $pengurus = Pengurus::find($id);
                        if ($pengurus) return $pengurus->user_id;
                        
                        $supplier = Supplier::find($id);
                        if ($supplier) return $supplier->user_id;
                        
                        $koperasi = DataKoperasi::find($id);
                        if ($koperasi) return $koperasi->user_id;
                    }
                    // Format dengan user_id langsung
                    elseif (isset($jsonData['user_id'])) {
                        \Log::debug('QR contains user_id directly:', ['user_id' => $jsonData['user_id']]);
                        return $jsonData['user_id'];
                    }
                }
            } catch (\Exception $e) {
                \Log::debug('JSON parsing failed:', ['error' => $e->getMessage()]);
                // Lanjutkan ke metode parsing berikutnya
            }
            
            // Coba format: user-{user_id}-{timestamp}
            if (preg_match('/^user-(\d+)-\d+$/', $qrValue, $matches)) {
                \Log::debug('QR matches user-id-timestamp format:', ['user_id' => $matches[1]]);
                return $matches[1];
            }
            
            // Coba format: user:{user_id}
            if (preg_match('/^user:(\d+)$/', $qrValue, $matches)) {
                \Log::debug('QR matches user:id format:', ['user_id' => $matches[1]]);
                return $matches[1];
            }
            
            // Coba format sederhana: hanya user ID (angka)
            if (is_numeric($qrValue)) {
                \Log::debug('QR is numeric, treating as direct user ID:', ['user_id' => $qrValue]);
                return $qrValue;
            }
            
            // Coba cari ID UUID dalam string (untuk santri baru yang menggunakan UUID)
            if (preg_match('/([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})/i', $qrValue, $matches)) {
                $uuid = $matches[1];
                \Log::debug('Found UUID in QR string:', ['uuid' => $uuid]);
                
                // Coba cari santri dengan UUID ini
                $santri = Santri::find($uuid);
                if ($santri) {
                    \Log::debug('Found santri with UUID:', ['user_id' => $santri->user_id]);
                    return $santri->user_id;
                }
                
                // Coba cari pengurus dengan UUID ini
                $pengurus = Pengurus::find($uuid);
                if ($pengurus) {
                    \Log::debug('Found pengurus with UUID:', ['user_id' => $pengurus->user_id]);
                    return $pengurus->user_id;
                }
                
                // Coba cari supplier dengan UUID ini
                $supplier = Supplier::find($uuid);
                if ($supplier) {
                    \Log::debug('Found supplier with UUID:', ['user_id' => $supplier->user_id]);
                    return $supplier->user_id;
                }
                
                // Coba cari koperasi dengan UUID ini
                $koperasi = DataKoperasi::find($uuid);
                if ($koperasi) {
                    \Log::debug('Found koperasi with UUID:', ['user_id' => $koperasi->user_id]);
                    return $koperasi->user_id;
                }
            }
            
            // Tidak bisa parse
            \Log::debug('Could not parse QR code to any supported format');
            return null;
        } catch (\Exception $e) {
            \Log::error('Error in parseQRCode:', ['error' => $e->getMessage(), 'qr_value' => $qrValue]);
            return null;
        }
    }
    
    /**
     * Dapatkan informasi dasar user
     */
    private function getUserInfo($user)
    {
        $info = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ? $user->role->name : 'Unknown',
            'photo' => null,
            'detail' => null,
        ];
        
        \Log::debug('User role info:', ['user_id' => $user->id, 'role' => $user->role ? $user->role->name : 'null']);
        
        // Ambil informasi tambahan berdasarkan role
        if ($user->hasRole('santri')) {
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $info['photo'] = $santri->foto;
                $info['detail'] = [
                    'nis' => $santri->nis,
                    'nama' => $santri->nama,
                    'jenis_kelamin' => $santri->jenis_kelamin,
                ];
            }
        } elseif ($user->hasRole('pengurus')) {
            $pengurus = Pengurus::where('user_id', $user->id)->first();
            if ($pengurus) {
                $info['photo'] = $pengurus->foto ?? null;
                $info['detail'] = [
                    'nik' => $pengurus->nik,
                    'nama' => $pengurus->nama,
                    'jabatan' => $pengurus->jabatan,
                ];
            }
        } elseif ($user->hasRole('supplier')) {
            $supplier = Supplier::where('user_id', $user->id)->first();
            if ($supplier) {
                $info['photo'] = null; // Supplier tidak memiliki foto
                $info['detail'] = [
                    'nama_supplier' => $supplier->nama_supplier,
                    'alamat' => $supplier->alamat,
                    'telepon' => $supplier->telepon,
                ];
            }
        } elseif ($user->hasRole('koperasi')) {
            $koperasi = DataKoperasi::where('user_id', $user->id)->first();
            if ($koperasi) {
                $info['photo'] = null; // Koperasi tidak memiliki foto
                $info['detail'] = [
                    'nama_koperasi' => $koperasi->nama_koperasi,
                    'lokasi' => $koperasi->lokasi,
                ];
            }
        }
        
        return $info;
    }
    
    /**
     * Dapatkan saldo user berdasarkan role
     */
    private function getUserSaldo($user)
    {
        $saldo = [];
        
        // Cek role user
        $role = $user->role ? $user->role->name : null;
        \Log::debug('Getting saldo for user with role:', ['user_id' => $user->id, 'role' => $role]);
        
        // Cek berdasarkan role user
        if ($role === 'Santri' || $user->hasRole('santri')) {
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                \Log::debug('Found santri record:', [
                    'santri_id' => $santri->id, 
                    'saldo_utama' => $santri->saldo_utama,
                    'saldo_belanja' => $santri->saldo_belanja,
                    'saldo_tabungan' => $santri->saldo_tabungan
                ]);
                
                // Menggunakan kolom saldo langsung dari tabel santri
                $saldo['utama'] = [
                    'jumlah' => $santri->saldo_utama,
                    'formattedAmount' => 'Rp ' . number_format($santri->saldo_utama, 0, ',', '.'),
                ];
                
                $saldo['belanja'] = [
                    'jumlah' => $santri->saldo_belanja,
                    'formattedAmount' => 'Rp ' . number_format($santri->saldo_belanja, 0, ',', '.'),
                ];
                
                $saldo['tabungan'] = [
                    'jumlah' => $santri->saldo_tabungan,
                    'formattedAmount' => 'Rp ' . number_format($santri->saldo_tabungan, 0, ',', '.'),
                ];
            }
        } elseif ($role === 'Supplier' || $user->hasRole('supplier')) {
            $supplier = Supplier::where('user_id', $user->id)->first();
            if ($supplier) {
                \Log::debug('Found supplier record:', [
                    'supplier_id' => $supplier->id, 
                    'saldo_belanja' => $supplier->saldo_belanja
                ]);
                
                $saldo['belanja'] = [
                    'jumlah' => $supplier->saldo_belanja,
                    'formattedAmount' => 'Rp ' . number_format($supplier->saldo_belanja, 0, ',', '.'),
                ];
            }
        } elseif ($role === 'Koperasi' || $user->hasRole('koperasi')) {
            $koperasi = DataKoperasi::where('user_id', $user->id)->first();
            if ($koperasi) {
                \Log::debug('Found koperasi record:', [
                    'koperasi_id' => $koperasi->id, 
                    'saldo_belanja' => $koperasi->saldo_belanja,
                    'keuntungan' => $koperasi->keuntungan
                ]);
                
                $saldo['belanja'] = [
                    'jumlah' => $koperasi->saldo_belanja,
                    'formattedAmount' => 'Rp ' . number_format($koperasi->saldo_belanja, 0, ',', '.'),
                ];
                
                $saldo['keuntungan'] = [
                    'jumlah' => $koperasi->keuntungan,
                    'formattedAmount' => 'Rp ' . number_format($koperasi->keuntungan, 0, ',', '.'),
                ];
            }
        } elseif ($role === 'Pengurus' || $user->hasRole('pengurus')) {
            $pengurus = Pengurus::where('user_id', $user->id)->first();
            if ($pengurus) {
                \Log::debug('Found pengurus record:', [
                    'pengurus_id' => $pengurus->id
                ]);
                
                // Pengurus tidak memiliki kolom saldo saat ini
                $saldo['info'] = [
                    'message' => 'Pengurus tidak memiliki informasi saldo'
                ];
            }
        }
        
        return $saldo;
    }
} 