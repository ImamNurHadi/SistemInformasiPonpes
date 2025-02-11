<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus = Pengurus::all();
        return view('pengurus.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengurus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'divisi' => 'required',
            'sub_divisi' => 'required'
        ]);

        Pengurus::create($validated);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil ditambahkan');
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
    public function edit(Pengurus $pengurus)
    {
        return view('pengurus.edit', compact('pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'divisi' => 'required',
            'sub_divisi' => 'required'
        ]);

        $pengurus->update($validated);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $pengurus)
    {
        $pengurus->delete();

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus');
    }
}
