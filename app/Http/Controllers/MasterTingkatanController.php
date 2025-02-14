<?php

namespace App\Http\Controllers;

use App\Models\MasterTingkatan;
use Illuminate\Http\Request;

class MasterTingkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkatan = MasterTingkatan::all();
        return view('tingkatan.index', compact('tingkatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('tingkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_tingkatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        MasterTingkatan::create([
            'nama' => $request->nama_tingkatan,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('tingkatan.index')
            ->with('success', 'Data tingkatan berhasil ditambahkan');
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
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('tingkatan.edit', compact('tingkatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterTingkatan $tingkatan)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_tingkatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $tingkatan->update($request->all());

        return redirect()->route('tingkatan.index')
            ->with('success', 'Data tingkatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterTingkatan $tingkatan)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $tingkatan->delete();

        return redirect()->route('tingkatan.index')
            ->with('success', 'Data tingkatan berhasil dihapus');
    }
}
