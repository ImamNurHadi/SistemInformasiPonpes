<?php

namespace App\Http\Controllers;

use App\Models\Santri;
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
        return view('santri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emoney' => 'required|unique:santri',
            'nis' => 'required|unique:santri',
            'nama' => 'required',
            'asrama' => 'required',
            'kamar' => 'required',
            'tingkatan_masuk' => 'required'
        ]);

        Santri::create($validated);

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
        return view('santri.edit', compact('santri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'id_emoney' => 'required|unique:santri,id_emoney,' . $santri->id,
            'nis' => 'required|unique:santri,nis,' . $santri->id,
            'nama' => 'required',
            'asrama' => 'required',
            'kamar' => 'required',
            'tingkatan_masuk' => 'required'
        ]);

        $santri->update($validated);

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil diupdate');
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
}
