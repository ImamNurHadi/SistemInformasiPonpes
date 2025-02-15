<?php

namespace App\Http\Controllers;

use App\Models\MasterKompleks;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KompleksKamarController extends Controller
{
    public function index()
    {
        $kompleks = MasterKompleks::withCount('santri')
            ->orderBy('nama_gedung')
            ->orderBy('nama_kamar')
            ->get();
        return view('kompleks-kamar.index', compact('kompleks'));
    }

    public function storeKamar(Request $request)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('master_kompleks')->where(function ($query) use ($request) {
                    return $query->where('nama_gedung', strtoupper($request->nama_gedung));
                }),
            ],
        ]);

        MasterKompleks::create([
            'nama_gedung' => strtoupper($request->nama_gedung),
            'nama_kamar' => strtoupper($request->nama_kamar),
        ]);

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan');
    }

    public function destroyKamar($id)
    {
        $kompleks = MasterKompleks::findOrFail($id);
        $kompleks->delete();

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil dihapus');
    }

    public function edit($id)
    {
        $kompleks = MasterKompleks::findOrFail($id);
        return view('kompleks-kamar.edit', compact('kompleks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'nama_kamar' => 'required|string|max:255',
        ]);

        $kompleks = MasterKompleks::findOrFail($id);
        $kompleks->update([
            'nama_gedung' => $request->nama_gedung,
            'nama_kamar' => $request->nama_kamar,
        ]);

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }
} 