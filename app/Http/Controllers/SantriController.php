<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use App\Models\MasterKompleks;
use App\Models\Kamar;
use Illuminate\Http\Request;

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
        $kompleks = MasterKompleks::orderBy('nama_gedung')->orderBy('nama_kamar')->get();
        return view('santri.create', compact('tingkatan', 'kompleks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:santri',
            'nomor_induk_santri' => 'required|string|max:20|unique:santri',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara_kandung' => 'required|integer|min:0',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'tingkatan_id' => 'required|exists:master_tingkatan,id',
            'kompleks_id' => 'required|exists:master_kompleks,id',
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

        // Buat santri baru
        $santri = Santri::create($validatedData);

        // Buat data wali santri
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
        $santri->waliSantri()->create($waliData);

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $tingkatan = MasterTingkatan::all();
        $kompleks = MasterKompleks::orderBy('nama_gedung')->orderBy('nama_kamar')->get();
        return view('santri.edit', compact('santri', 'tingkatan', 'kompleks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:santri,nis,' . $santri->id,
            'nomor_induk_santri' => 'required|string|max:20|unique:santri,nomor_induk_santri,' . $santri->id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara_kandung' => 'required|integer|min:0',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'tingkatan_id' => 'required|exists:master_tingkatan,id',
            'kompleks_id' => 'required|exists:master_kompleks,id',
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

    public function getKamarByKompleks($kompleksId)
    {
        try {
            \Log::info('Mengambil data kamar untuk kompleks ID: ' . $kompleksId);
            
            $kamar = Kamar::where('kompleks_id', $kompleksId)
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
}
