<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use Illuminate\Http\Request;

class RuangKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangKelas = RuangKelas::withCount('santri')->orderBy('nama_ruang_kelas')->get();
        return view('ruang-kelas.index', compact('ruangKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ruang-kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang_kelas' => 'required|string|max:255|unique:ruang_kelas,nama_ruang_kelas',
            'keterangan' => 'nullable|string',
        ]);

        RuangKelas::create([
            'nama_ruang_kelas' => strtoupper($request->nama_ruang_kelas),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil ditambahkan');
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
    public function edit(RuangKelas $ruangKela)
    {
        return view('ruang-kelas.edit', ['ruangKelas' => $ruangKela]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RuangKelas $ruangKela)
    {
        $request->validate([
            'nama_ruang_kelas' => 'required|string|max:255|unique:ruang_kelas,nama_ruang_kelas,' . $ruangKela->id,
            'keterangan' => 'nullable|string',
        ]);

        $ruangKela->update([
            'nama_ruang_kelas' => strtoupper($request->nama_ruang_kelas),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RuangKelas $ruangKela)
    {
        $ruangKela->delete();

        return redirect()->route('ruang-kelas.index')
            ->with('success', 'Ruang Kelas berhasil dihapus');
    }
}
