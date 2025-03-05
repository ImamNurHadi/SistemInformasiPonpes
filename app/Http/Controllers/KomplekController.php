<?php

namespace App\Http\Controllers;

use App\Models\Komplek;
use Illuminate\Http\Request;

class KomplekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $komplek = Komplek::withCount('kamar')->get();
        return view('komplek.index', compact('komplek'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('komplek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_komplek' => 'required|string|max:255'
        ]);

        Komplek::create([
            'nama_komplek' => $request->nama_komplek
        ]);

        return redirect()->route('komplek.index')
            ->with('success', 'Data komplek berhasil ditambahkan!');
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
    public function edit(Komplek $komplek)
    {
        return view('komplek.edit', compact('komplek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komplek $komplek)
    {
        $request->validate([
            'nama_komplek' => 'required|string|max:255'
        ]);

        $komplek->update([
            'nama_komplek' => $request->nama_komplek
        ]);

        return redirect()->route('komplek.index')
            ->with('success', 'Data komplek berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komplek $komplek)
    {
        try {
            if ($komplek->kamar()->count() > 0) {
                return back()->with('error', 'Komplek tidak dapat dihapus karena masih memiliki kamar!');
            }

            $komplek->delete();
            return redirect()->route('komplek.index')
                ->with('success', 'Data komplek berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
