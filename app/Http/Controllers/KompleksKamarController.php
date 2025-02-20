<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KompleksKamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('gedung', 'santri')
            ->select('kamar.*')
            ->selectRaw('(SELECT COUNT(*) FROM santri WHERE santri.kamar_id = kamar.id) as santri_count')
            ->orderBy('nama_kamar')
            ->get();
            
        return view('kompleks-kamar.index', compact('kamar'));
    }

    public function storeKamar(Request $request)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        // Cari atau buat gedung baru
        $gedung = Gedung::firstOrCreate(
            ['nama_gedung' => strtoupper($request->nama_gedung)],
            ['keterangan' => '']
        );

        // Buat kamar baru
        Kamar::create([
            'nama_kamar' => strtoupper($request->nama_kamar),
            'gedung_id' => $gedung->id,
        ]);

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan');
    }

    public function destroyKamar($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil dihapus');
    }

    public function edit($id)
    {
        $kamar = Kamar::with('gedung')->findOrFail($id);
        return view('kompleks-kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'nama_kamar' => 'required|string|max:255',
        ]);

        $kamar = Kamar::findOrFail($id);
        
        // Update atau buat gedung baru
        $gedung = Gedung::firstOrCreate(
            ['nama_gedung' => strtoupper($request->nama_gedung)],
            ['keterangan' => '']
        );

        $kamar->update([
            'nama_kamar' => strtoupper($request->nama_kamar),
            'gedung_id' => $gedung->id,
        ]);

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }
} 