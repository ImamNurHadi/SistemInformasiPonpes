<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisis = Divisi::all();
        return view('divisi.index', compact('divisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sub_divisi' => 'nullable|string|max:255',
        ]);

        Divisi::create($request->all());

        return redirect()->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan!');
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
    public function edit(Divisi $divisi)
    {
        return view('divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sub_divisi' => 'nullable|string|max:255',
        ]);

        $divisi->update($request->all());

        return redirect()->route('divisi.index')
            ->with('success', 'Divisi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus!');
    }
}
