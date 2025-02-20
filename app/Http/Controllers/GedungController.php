<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gedung = Gedung::withCount('kamar')->get();
        return view('gedung.index', compact('gedung'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gedung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255'
        ]);

        try {
            Gedung::create([
                'nama_gedung' => $request->nama_gedung
            ]);

            return redirect()->route('gedung.index')
                ->with('success', 'Data gedung berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }
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
    public function edit(Gedung $gedung)
    {
        return view('gedung.edit', compact('gedung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gedung $gedung)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255'
        ]);

        try {
            $gedung->update([
                'nama_gedung' => $request->nama_gedung
            ]);

            return redirect()->route('gedung.index')
                ->with('success', 'Data gedung berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gedung $gedung)
    {
        try {
            if ($gedung->kamar()->count() > 0) {
                return back()->with('error', 'Gedung tidak dapat dihapus karena masih memiliki kamar!');
            }

            $gedung->delete();
            return redirect()->route('gedung.index')
                ->with('success', 'Data gedung berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data. ' . $e->getMessage());
        }
    }
}
