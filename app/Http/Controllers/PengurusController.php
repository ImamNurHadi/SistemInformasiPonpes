<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus = Pengurus::with('divisi')->get();
        return view('pengurus.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisis = Divisi::all();
        return view('pengurus.create', compact('divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required',
                'nik' => 'required|unique:pengurus',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'telepon' => 'required',
                'kelurahan_domisili' => 'required',
                'kecamatan_domisili' => 'required',
                'kota_domisili' => 'required',
                'kelurahan_kk' => 'required',
                'kecamatan_kk' => 'required',
                'kota_kk' => 'required',
                'divisi_id' => 'nullable|exists:divisis,id',
            ]);
            
            Pengurus::create($validated);
            
            return redirect()->route('pengurus.index')
                ->with('success', 'Data pengurus berhasil disimpan!');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
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
    public function edit(Pengurus $penguru)
    {
        $divisis = Divisi::all();
        return view('pengurus.edit', compact('penguru', 'divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $penguru)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:pengurus,nik,' . $penguru->id,
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required',
            'kelurahan_domisili' => 'required',
            'kecamatan_domisili' => 'required',
            'kota_domisili' => 'required',
            'kelurahan_kk' => 'required',
            'kecamatan_kk' => 'required',
            'kota_kk' => 'required',
            'divisi_id' => 'required|exists:divisis,id',
            'sub_divisi' => 'nullable|string',
        ]);

        $penguru->update($request->all());

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $penguru)
    {
        if ($penguru->user) {
            $penguru->user->delete();
        }
        $penguru->delete();

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus!');
    }

    /**
     * Show the form for selecting division.
     */
    public function showDivisiForm($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $divisis = Divisi::all();
        return view('pengurus.divisi', compact('pengurus', 'divisis'));
    }

    /**
     * Update the division for the specified pengurus.
     */
    public function updateDivisi(Request $request, $id)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
            'sub_divisi' => 'nullable|string',
        ]);

        $pengurus = Pengurus::findOrFail($id);
        $pengurus->update([
            'divisi_id' => $request->divisi_id,
            'sub_divisi' => $request->sub_divisi,
        ]);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data divisi pengurus berhasil diperbarui!');
    }
}
