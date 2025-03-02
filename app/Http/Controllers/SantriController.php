<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use App\Models\Gedung;
use App\Models\Kamar;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $santri = Santri::all();
        return view('santri.index', compact('santri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tingkatan = MasterTingkatan::all();
        $gedung = Gedung::all();
        $kamar = Kamar::with('gedung')->get();
        return view('santri.create', compact('tingkatan', 'gedung', 'kamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Mencoba menyimpan data santri baru');
        
        try {
            $validated = $request->validate([
                // Data Santri
                'nama' => 'required|string|max:255',
                'nis' => 'required|string|max:20|unique:santri',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'anak_ke' => 'required|integer|min:1',
                'jumlah_saudara_kandung' => 'required|integer|min:0',
                'kelurahan' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kabupaten_kota' => 'required|string|max:255',
                'tingkatan_id' => 'required|exists:master_tingkatan,id',
                'gedung_id' => 'required|exists:gedung,id',
                'kamar_id' => 'required|exists:kamar,id',
                
                // Data Wali Santri
                'nama_wali' => 'required|string|max:255',
                'asal_kota' => 'required|string|max:255',
                'nama_ayah' => 'required|string|max:255',
                'alamat_kk_ayah' => 'required|string',
                'alamat_domisili_ayah' => 'required|string',
                'no_identitas_ayah' => 'nullable|string|max:20',
                'no_hp_ayah' => 'nullable|string|max:15',
                'pendidikan_ayah' => 'required|string|max:255',
                'pekerjaan_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:255',
                'alamat_kk_ibu' => 'required|string',
                'alamat_domisili_ibu' => 'required|string',
                'no_identitas_ibu' => 'nullable|string|max:20',
                'no_hp_ibu' => 'nullable|string|max:15',
                'pendidikan_ibu' => 'required|string|max:255',
                'pekerjaan_ibu' => 'required|string|max:255',
            ]);

            \Log::info('Validasi berhasil, mencoba membuat user dan data santri');

            // Buat user baru untuk santri
            $roleSantri = Role::where('name', 'Santri')->first();
            if (!$roleSantri) {
                throw new \Exception('Role Santri tidak ditemukan');
            }

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->nis . '@santri.ponpes.id',
                'password' => Hash::make($request->nis), // Password default adalah NIS
                'role_id' => $roleSantri->id
            ]);

            \Log::info('User berhasil dibuat dengan ID: ' . $user->id);

            $santri = Santri::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'nis' => $request->nis,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara_kandung' => $request->jumlah_saudara_kandung,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'tingkatan_id' => $request->tingkatan_id,
                'tingkatan_masuk' => $request->tingkatan_id,
                'gedung_id' => $request->gedung_id,
                'kamar_id' => $request->kamar_id,
                'saldo_utama' => 0,
                'saldo_belanja' => 0,
                'saldo_tabungan' => 0
            ]);

            \Log::info('Data santri berhasil dibuat dengan ID: ' . $santri->id);

            // Generate QR Code untuk santri
            $santri->generateQrCode();

            // Buat data wali santri
            if ($santri) {
                \Log::info('Mencoba membuat data wali santri');
                
                $waliSantri = $santri->waliSantri()->create([
                    'nama_wali' => $request->nama_wali,
                    'asal_kota' => $request->asal_kota,
                    'nama_ayah' => $request->nama_ayah,
                    'alamat_kk_ayah' => $request->alamat_kk_ayah,
                    'alamat_domisili_ayah' => $request->alamat_domisili_ayah,
                    'no_identitas_ayah' => $request->no_identitas_ayah,
                    'no_hp_ayah' => $request->no_hp_ayah,
                    'pendidikan_ayah' => $request->pendidikan_ayah,
                    'pekerjaan_ayah' => $request->pekerjaan_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'alamat_kk_ibu' => $request->alamat_kk_ibu,
                    'alamat_domisili_ibu' => $request->alamat_domisili_ibu,
                    'no_identitas_ibu' => $request->no_identitas_ibu,
                    'no_hp_ibu' => $request->no_hp_ibu,
                    'pendidikan_ibu' => $request->pendidikan_ibu,
                    'pekerjaan_ibu' => $request->pekerjaan_ibu,
                ]);
                
                \Log::info('Data wali santri berhasil dibuat');
            }

            return redirect()->route('santri.index')
                ->with('success', 'Data santri berhasil ditambahkan! Email: ' . $user->email . ' dan Password: ' . $request->nis);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan data: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $santri = Santri::with(['tingkatan', 'gedung', 'kamar', 'waliSantri'])->findOrFail($id);
        return view('santri.show', compact('santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $tingkatan = MasterTingkatan::all();
        $gedung = Gedung::all();
        $kamar = Kamar::where('gedung_id', $santri->gedung_id)->get();
        return view('santri.edit', compact('santri', 'tingkatan', 'gedung', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_induk_santri' => 'required|string|max:20|unique:santri,nis,' . $santri->id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara_kandung' => 'required|integer|min:0',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'tingkatan_id' => 'required|exists:master_tingkatan,id',
            'gedung_id' => 'required|exists:gedung,id',
            'kamar_id' => 'required|exists:kamar,id',
            'nama_wali' => 'required|string|max:255',
            'asal_kota' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'alamat_kk_ayah' => 'required|string',
            'alamat_domisili_ayah' => 'required|string',
            'no_identitas_ayah' => 'nullable|string|max:20',
            'no_hp_ayah' => 'nullable|string|max:15',
            'pendidikan_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'alamat_kk_ibu' => 'required|string',
            'alamat_domisili_ibu' => 'required|string',
            'no_identitas_ibu' => 'nullable|string|max:20',
            'no_hp_ibu' => 'nullable|string|max:15',
            'pendidikan_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
        ]);

        // Set nis dari nomor_induk_santri
        $validatedData['nis'] = $validatedData['nomor_induk_santri'];
        unset($validatedData['nomor_induk_santri']); // Hapus nomor_induk_santri dari array

        // Update data santri
        $santri->update($validatedData);

        // Update data wali santri
        $waliData = $request->only([
            'nama_wali',
            'asal_kota',
            'nama_ayah',
            'alamat_kk_ayah',
            'alamat_domisili_ayah',
            'no_identitas_ayah',
            'no_hp_ayah',
            'pendidikan_ayah',
            'pekerjaan_ayah',
            'nama_ibu',
            'alamat_kk_ibu',
            'alamat_domisili_ibu',
            'no_identitas_ibu',
            'no_hp_ibu',
            'pendidikan_ibu',
            'pekerjaan_ibu',
        ]);
        $santri->waliSantri()->update($waliData);

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Santri $santri)
    {
        if ($santri->user) {
            $santri->user->delete();
        }
        $santri->delete();

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil dihapus!');
    }

    public function getKamarByGedung($gedungId)
    {
        try {
            \Log::info('Mengambil data kamar untuk gedung ID: ' . $gedungId);
            
            $kamar = Kamar::where('gedung_id', $gedungId)
                         ->select('id', 'nama_kamar')
                         ->orderBy('nama_kamar')
                         ->get();
            
            \Log::info('Jumlah kamar yang ditemukan: ' . $kamar->count());
            
            return response()->json([
                'status' => 'success',
                'data' => $kamar
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil data kamar: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data kamar'
            ], 500);
        }
    }

    public function getSaldo(Santri $santri)
    {
        try {
            \Log::info('Mengambil data saldo santri:', [
                'santri_id' => $santri->id,
                'nama' => $santri->nama,
                'saldo_belanja' => $santri->saldo_belanja,
                'saldo_utama' => $santri->saldo_utama
            ]);
            
            return response()->json([
                'saldo_belanja' => $santri->saldo_belanja,
                'saldo_utama' => $santri->saldo_utama
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil data saldo:', [
                'santri_id' => $santri->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data saldo: ' . $e->getMessage()
            ], 500);
        }
    }
}
