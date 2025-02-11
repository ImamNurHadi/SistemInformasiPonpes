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
        return view('pengajar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nuptk' => 'required|string|unique:pengajars',
            'nik' => 'required|string|unique:pengajars',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'bidang_mata_pelajaran' => 'required|string',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        Pengajar::create($validated);

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil ditambahkan');
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
        return view('pengajar.edit', compact('pengajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajar $pengajar)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nuptk' => 'required|string|unique:pengajars,nuptk,'.$pengajar->id,
            'nik' => 'required|string|unique:pengajars,nik,'.$pengajar->id,
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'bidang_mata_pelajaran' => 'required|string',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        $pengajar->update($validated);

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajar $pengajar)
    {
        $pengajar->delete();

        return redirect()->route('pengajar.index')
            ->with('success', 'Data pengajar berhasil dihapus');
    }
}
