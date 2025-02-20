<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('gedung')->withCount('santri')->get();
        $gedung = Gedung::all();
        return view('kamar.index', compact('kamar', 'gedung'));
    }

    public function create()
    {
        $gedung = Gedung::all();
        return view('kamar.create', compact('gedung'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar')->where(function ($query) use ($request) {
                    return $query->where('gedung_id', $request->gedung_id);
                }),
            ],
        ]);

        Kamar::create([
            'gedung_id' => $request->gedung_id,
            'nama_kamar' => strtoupper($request->nama_kamar),
        ]);

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan');
    }

    public function edit(Kamar $kamar)
    {
        $gedung = Gedung::all();
        return view('kamar.edit', compact('kamar', 'gedung'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar')->where(function ($query) use ($request) {
                    return $query->where('gedung_id', $request->gedung_id);
                })->ignore($kamar->id),
            ],
        ]);

        $kamar->update([
            'gedung_id' => $request->gedung_id,
            'nama_kamar' => strtoupper($request->nama_kamar),
        ]);

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }

    public function destroy(Kamar $kamar)
    {
        if ($kamar->santri()->count() > 0) {
            return back()->with('error', 'Kamar tidak dapat dihapus karena masih memiliki santri!');
        }

        $kamar->delete();

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil dihapus');
    }

    public function getByGedung($gedungId)
    {
        $kamar = Kamar::where('gedung_id', $gedungId)
            ->select('id', 'nama_kamar')
            ->orderBy('nama_kamar')
            ->get();
            
        return response()->json($kamar);
    }
} 