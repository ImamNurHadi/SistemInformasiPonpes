<?php

namespace App\Http\Controllers;

use App\Models\Pengajar;
use Illuminate\Http\Request;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajars = Pengajar::all();
        return view('pengajar.index', compact('pengajars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendidikan = ['SMA/Sederajat', 'S-1/Sederajat', 'S-2/Sederajat', 'S-3/Sederajat'];
        return view('pengajar.create', compact('pendidikan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:pengajars',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required',
            'kelurahan_domisili' => 'required',
            'kecamatan_domisili' => 'required',
            'kota_domisili' => 'required',
            'kelurahan_kk' => 'required',
            'kecamatan_kk' => 'required',
            'kota_kk' => 'required',
            'pendidikan_terakhir' => 'required|in:SMA/Sederajat,S-1/Sederajat,S-2/Sederajat,S-3/Sederajat',
            'asal_kampus' => 'required_unless:pendidikan_terakhir,SMA/Sederajat',
        ]);

        Pengajar::create($request->all());

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil ditambahkan!');
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
    public function edit(Pengajar $pengajar)
    {
        $pendidikan = ['SMA/Sederajat', 'S-1/Sederajat', 'S-2/Sederajat', 'S-3/Sederajat'];
        return view('pengajar.edit', compact('pengajar', 'pendidikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajar $pengajar)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:pengajars,nik,' . $pengajar->id,
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required',
            'kelurahan_domisili' => 'required',
            'kecamatan_domisili' => 'required',
            'kota_domisili' => 'required',
            'kelurahan_kk' => 'required',
            'kecamatan_kk' => 'required',
            'kota_kk' => 'required',
            'pendidikan_terakhir' => 'required|in:SMA/Sederajat,S-1/Sederajat,S-2/Sederajat,S-3/Sederajat',
            'asal_kampus' => 'required_unless:pendidikan_terakhir,SMA/Sederajat',
        ]);

        $pengajar->update($request->all());

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajar $pengajar)
    {
        $pengajar->delete();

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil dihapus!');
    }
}
