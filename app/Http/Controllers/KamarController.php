<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Komplek;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('komplek')->withCount('santri')->get();
        $komplek = Komplek::all();
        return view('kamar.index', compact('kamar', 'komplek'));
    }

    public function create()
    {
        $komplek = Komplek::all();
        return view('kamar.create', compact('komplek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'komplek_id' => 'required|exists:komplek,id',
            'nama_kamar' => 'required|string|max:255|unique:kamar,nama_kamar,NULL,id,komplek_id,' . $request->komplek_id,
        ], [
            'nama_kamar.unique' => 'Nama kamar sudah ada di komplek ini',
        ]);

        // Validasi nama kamar unik per gedung
        $existingKamar = Kamar::where('nama_kamar', $request->nama_kamar)
            ->where(function ($query) use ($request) {
                return $query->where('komplek_id', $request->komplek_id);
            })->first();

        if ($existingKamar) {
            return back()->withInput()->with('error', 'Nama kamar sudah ada di komplek ini');
        }

        Kamar::create([
            'komplek_id' => $request->komplek_id,
            'nama_kamar' => $request->nama_kamar,
        ]);

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan!');
    }

    public function edit(Kamar $kamar)
    {
        $komplek = Komplek::all();
        return view('kamar.edit', compact('kamar', 'komplek'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'komplek_id' => 'required|exists:komplek,id',
            'nama_kamar' => 'required|string|max:255|unique:kamar,nama_kamar,' . $kamar->id . ',id,komplek_id,' . $request->komplek_id,
        ], [
            'nama_kamar.unique' => 'Nama kamar sudah ada di komplek ini',
        ]);

        // Validasi nama kamar unik per gedung
        $existingKamar = Kamar::where('nama_kamar', $request->nama_kamar)
            ->where(function ($query) use ($request) {
                return $query->where('komplek_id', $request->komplek_id);
            })
            ->where('id', '!=', $kamar->id)
            ->first();

        if ($existingKamar) {
            return back()->withInput()->with('error', 'Nama kamar sudah ada di komplek ini');
        }

        $kamar->update([
            'komplek_id' => $request->komplek_id,
            'nama_kamar' => $request->nama_kamar,
        ]);

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy(Kamar $kamar)
    {
        try {
            if ($kamar->santri()->count() > 0) {
                return back()->with('error', 'Kamar tidak dapat dihapus karena masih memiliki santri!');
            }

            $kamar->delete();
            return redirect()->route('kamar.index')
                ->with('success', 'Data kamar berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getByKomplek($komplekId)
    {
        $kamar = Kamar::where('komplek_id', $komplekId)
            ->orderBy('nama_kamar')
            ->get();

        return response()->json($kamar);
    }
} 