<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use App\Models\Kamar;
use App\Models\Role;
use App\Models\User;
use App\Models\Komplek;
use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        $komplek = Komplek::all();
        $kamar = Kamar::with('komplek')->get();
        $ruangKelas = RuangKelas::orderBy('nama_ruang_kelas')->get();
        return view('santri.create', compact('tingkatan', 'komplek', 'kamar', 'ruangKelas'));
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
                'kamar_id' => 'required|exists:kamar,id',
                'komplek_id' => 'required|exists:komplek,id',
                'ruang_kelas_id' => 'nullable|exists:ruang_kelas,id',
                
                // Data Wali Santri
                'nama_wali' => 'nullable|string|max:255',
                'asal_kota' => 'nullable|string|max:255',
                'nama_ayah' => 'nullable|string|max:255',
                'alamat_kk_ayah' => 'nullable|string',
                'alamat_domisili_ayah' => 'nullable|string',
                'no_identitas_ayah' => 'nullable|string|max:20',
                'no_hp_ayah' => 'nullable|string|max:15',
                'pendidikan_ayah' => 'nullable|string|max:255',
                'pekerjaan_ayah' => 'nullable|string|max:255',
                'nama_ibu' => 'nullable|string|max:255',
                'alamat_kk_ibu' => 'nullable|string',
                'alamat_domisili_ibu' => 'nullable|string',
                'no_identitas_ibu' => 'nullable|string|max:20',
                'no_hp_ibu' => 'nullable|string|max:15',
                'pendidikan_ibu' => 'nullable|string|max:255',
                'pekerjaan_ibu' => 'nullable|string|max:255',
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
                'kamar_id' => $request->kamar_id,
                'komplek_id' => $request->komplek_id,
                'ruang_kelas_id' => $request->ruang_kelas_id,
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
        $santri = Santri::with(['tingkatan', 'kamar', 'waliSantri'])->findOrFail($id);
        return view('santri.show', compact('santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $tingkatan = MasterTingkatan::all();
        $komplek = Komplek::all();
        $kamar = Kamar::where('komplek_id', $santri->komplek_id)->get();
        $ruangKelas = RuangKelas::orderBy('nama_ruang_kelas')->get();
        return view('santri.edit', compact('santri', 'tingkatan', 'komplek', 'kamar', 'ruangKelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        // Debug the request data
        \Log::info('Update request data:', ['request' => $request->all()]);
        \Log::info('Original santri ruang_kelas_id: ' . $santri->ruang_kelas_id);
        
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
            'kamar_id' => 'required|exists:kamar,id',
            'komplek_id' => 'required|exists:komplek,id',
            'ruang_kelas_id' => 'nullable|exists:ruang_kelas,id',
            'nama_wali' => 'nullable|string|max:255',
            'asal_kota' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat_kk_ayah' => 'nullable|string',
            'alamat_domisili_ayah' => 'nullable|string',
            'no_identitas_ayah' => 'nullable|string|max:20',
            'no_hp_ayah' => 'nullable|string|max:15',
            'pendidikan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'alamat_kk_ibu' => 'nullable|string',
            'alamat_domisili_ibu' => 'nullable|string',
            'no_identitas_ibu' => 'nullable|string|max:20',
            'no_hp_ibu' => 'nullable|string|max:15',
            'pendidikan_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
        ]);

        // Set nis dari nomor_induk_santri
        $validatedData['nis'] = $validatedData['nomor_induk_santri'];
        unset($validatedData['nomor_induk_santri']); // Hapus nomor_induk_santri dari array

        // Handle ruang_kelas_id explicitly
        if ($request->has('ruang_kelas_id')) {
            if (empty($request->ruang_kelas_id)) {
                $validatedData['ruang_kelas_id'] = null;
                \Log::info('Setting ruang_kelas_id to null');
            } else {
                $validatedData['ruang_kelas_id'] = $request->ruang_kelas_id;
                \Log::info('Setting ruang_kelas_id to: ' . $request->ruang_kelas_id);
            }
        } else {
            \Log::info('ruang_kelas_id not present in request');
        }

        // Pisahkan data santri dan data wali santri
        $santriData = [
            'nama' => $validatedData['nama'],
            'nis' => $validatedData['nis'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'anak_ke' => $validatedData['anak_ke'],
            'jumlah_saudara_kandung' => $validatedData['jumlah_saudara_kandung'],
            'kelurahan' => $validatedData['kelurahan'],
            'kecamatan' => $validatedData['kecamatan'],
            'kabupaten_kota' => $validatedData['kabupaten_kota'],
            'tingkatan_id' => $validatedData['tingkatan_id'],
            'kamar_id' => $validatedData['kamar_id'],
            'komplek_id' => $validatedData['komplek_id'],
            'ruang_kelas_id' => $validatedData['ruang_kelas_id'],
        ];

        // Debug the santriData array
        \Log::info('Santri data:', ['santriData' => $santriData]);

        try {
            DB::beginTransaction();

            // Update data santri
            $santri->update($santriData);
            
            // Debug the santri after update
            \Log::info('Santri after update:', ['santri' => $santri->toArray()]);
            \Log::info('Checking ruang_kelas_id after update: ' . $santri->ruang_kelas_id);
            
            // Force refresh from database to ensure we have the latest data
            $santri = $santri->fresh();
            \Log::info('Santri after fresh():', ['santri' => $santri->toArray()]);
            \Log::info('Checking ruang_kelas_id after fresh(): ' . $santri->ruang_kelas_id);

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
            
            // Debug the waliData array
            \Log::info('Wali data:', ['waliData' => $waliData]);
            
            // Update wali santri jika ada
            if ($santri->waliSantri) {
                $santri->waliSantri()->update($waliData);
            } else {
                // Buat wali santri baru jika belum ada
                $santri->waliSantri()->create($waliData);
            }

            // Update user email jika NIS berubah
            if ($santri->user && $santri->wasChanged('nis')) {
                $santri->user->update([
                    'email' => $santri->nis . '@santri.ponpes.id'
                ]);
            }

            // Generate ulang QR Code
            $santri->generateQrCode();

            DB::commit();

            return redirect()->route('santri.index')
                ->with('success', 'Data santri berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error saat memperbarui data: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
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

    public function getKamarByKomplek($komplekId)
    {
        $kamar = Kamar::where('komplek_id', $komplekId)
            ->orderBy('nama_kamar')
            ->get();

        return response()->json($kamar);
    }

    public function getSaldo(Santri $santri)
    {
        try {
            \Log::info('Mengambil data saldo untuk santri:', [
                'santri_id' => $santri->id,
                'nama' => $santri->nama
            ]);
            
            $saldo = $santri->saldo();
            \Log::info('Data saldo:', $saldo);
            
            return response()->json($saldo);
            
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

    /**
     * Get santri data for API
     */
    public function getSantriData(Santri $santri)
    {
        try {
            \Log::info('Mengambil data santri:', [
                'santri_id' => $santri->id,
                'nama' => $santri->nama
            ]);
            
            $data = [
                'id' => $santri->id,
                'nama' => $santri->nama,
                'tempat_lahir' => $santri->tempat_lahir,
                'tanggal_lahir' => $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : null,
                'jenis_kelamin' => $santri->jenis_kelamin,
                'tingkatan' => $santri->tingkatan ? $santri->tingkatan->nama : null,
                'kelas' => $santri->kelas ? $santri->kelas->nama : null,
                'komplek' => $santri->komplek ? $santri->komplek->nama : null,
                'kamar' => $santri->kamar ? $santri->kamar->nama : null
            ];
            
            \Log::info('Data santri berhasil diambil');
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil data santri:', [
                'santri_id' => $santri->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data santri: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update ruang_kelas_id for a santri
     */
    public function updateRuangKelas(Request $request, Santri $santri)
    {
        \Log::info('Updating ruang_kelas_id for santri: ' . $santri->id);
        \Log::info('Request data:', $request->all());
        
        $request->validate([
            'ruang_kelas_id' => 'nullable|exists:ruang_kelas,id',
        ]);
        
        $oldRuangKelasId = $santri->ruang_kelas_id;
        \Log::info('Old ruang_kelas_id: ' . $oldRuangKelasId);
        
        try {
            DB::beginTransaction();
            
            // Update directly using query builder to bypass any model events
            DB::table('santri')
                ->where('id', $santri->id)
                ->update(['ruang_kelas_id' => $request->ruang_kelas_id]);
                
            // Refresh the model
            $santri = $santri->fresh();
            
            \Log::info('Ruang kelas updated:', [
                'old_value' => $oldRuangKelasId,
                'new_value' => $santri->ruang_kelas_id,
                'santri_id' => $santri->id,
                'santri_nama' => $santri->nama
            ]);
            
            DB::commit();
            
            return redirect()->route('santri.edit', $santri->id)
                ->with('success', 'Ruang kelas berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating ruang_kelas_id: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui ruang kelas: ' . $e->getMessage());
        }
    }
}
