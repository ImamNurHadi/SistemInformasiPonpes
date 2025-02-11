<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use Illuminate\Http\Request;

class KoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koperasi = Koperasi::all();
        return view('koperasi.index', compact('koperasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('koperasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        Koperasi::create($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil ditambahkan');
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
    public function edit(Koperasi $koperasi)
    {
        return view('koperasi.edit', compact('koperasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Koperasi $koperasi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        $koperasi->update($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Koperasi $koperasi)
    {
        $koperasi->delete();

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil dihapus');
    }
}
