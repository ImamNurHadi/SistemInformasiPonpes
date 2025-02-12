<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTingkatan;

class MasterTingkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkatan = MasterTingkatan::all();
        return view('master.tingkatan.index', compact('tingkatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.tingkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        MasterTingkatan::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil ditambahkan');
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
    public function edit(MasterTingkatan $tingkatan)
    {
        return view('master.tingkatan.edit', compact('tingkatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterTingkatan $tingkatan)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        $tingkatan->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterTingkatan $tingkatan)
    {
        $tingkatan->delete();
        return redirect()->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil dihapus');
    }
}
