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
        $kompleks = MasterKompleks::all();
        return view('santri.create', compact('tingkatan', 'kompleks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:santri',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara_kandung' => 'required|integer|min:0',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'nomor_induk_santri' => 'required|string|max:50|unique:santri',
            'kompleks_id' => 'required|exists:master_kompleks,id',
            'kamar_id' => 'required|exists:kamar,id',
            'tingkatan_masuk' => 'required|exists:master_tingkatan,id',
            'tingkatan_id' => 'required|exists:master_tingkatan,id',
        ]);

        Santri::create($request->all());

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
        return view('santri.edit', compact('santri', 'tingkatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nis' => 'required|unique:santri,nis,' . $santri->id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara_kandung' => 'required|integer|min:0',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'nomor_induk_santri' => 'required|string|max:50|unique:santri,nomor_induk_santri,' . $santri->id,
            'asrama' => 'required|string|max:255',
            'kamar' => 'required|string|max:255',
            'tingkatan_masuk' => 'required|exists:master_tingkatan,id',
            'tingkatan_id' => 'required|exists:master_tingkatan,id',
        ]);

        $santri->update($request->all());

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil dihapus');
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
