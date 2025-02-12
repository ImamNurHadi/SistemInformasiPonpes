<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $santris = Santri::all();
        return view('santri.index', compact('santris'));
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
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:santris',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'telepon_wali' => 'required',
        ]);

        Santri::create($request->all());

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil ditambahkan!');
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
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:santris,nik,' . $santri->id,
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'telepon_wali' => 'required',
        ]);

        $santri->update($request->all());

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Santri $santri)
    {
        if ($santri->user) {
            $santri->user->delete();
        }
        $santri->delete();

        return redirect()->route('santri.index')
            ->with('success', 'Data santri berhasil dihapus!');
    }
}
