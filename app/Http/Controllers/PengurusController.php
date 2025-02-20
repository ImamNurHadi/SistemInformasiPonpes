<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            // Log request data
            \Log::info('Request data:', $request->all());

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|max:20|unique:pengurus',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'telepon' => 'required|string|max:15',
                'kelurahan_domisili' => 'required|string|max:255',
                'kecamatan_domisili' => 'required|string|max:255',
                'kota_domisili' => 'required|string|max:255',
                'kelurahan_kk' => 'required|string|max:255',
                'kecamatan_kk' => 'required|string|max:255',
                'kota_kk' => 'required|string|max:255',
                'divisi_id' => 'nullable|string|exists:divisis,id',
                'sub_divisi' => 'nullable|string|max:255',
                'jabatan' => 'required|string|in:Ketua,Wakil Ketua,Sekretaris,Bendahara,Anggota',
            ]);
            
            // Log validated data
            \Log::info('Data tervalidasi:', $validated);
            
            // Coba buat UUID secara manual
            $validated['id'] = Str::uuid()->toString();
            \Log::info('UUID yang dibuat:', ['id' => $validated['id']]);
            
            try {
                $pengurus = Pengurus::create($validated);
                \Log::info('Pengurus berhasil dibuat dengan ID: ' . $pengurus->id);
            } catch (\Exception $e) {
                \Log::error('Error saat create Pengurus:', [
                    'message' => $e->getMessage(),
                    'sql' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
                ]);
                throw $e;
            }
            
            return redirect()->route('pengurus.index')
                ->with('success', 'Data pengurus berhasil disimpan!');
                
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan pengurus: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return back()
                    ->withInput()
                    ->withErrors($e->errors());
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi atau hubungi administrator.']);
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
    public function edit(Pengurus $pengurus)
    {
        $divisis = Divisi::all();
        return view('pengurus.edit', compact('pengurus', 'divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        try {
            // Log request data
            \Log::info('Request data:', $request->all());

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|max:20|unique:pengurus,nik,' . $pengurus->id,
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'telepon' => 'required|string|max:15',
                'kelurahan_domisili' => 'required|string|max:255',
                'kecamatan_domisili' => 'required|string|max:255',
                'kota_domisili' => 'required|string|max:255',
                'kelurahan_kk' => 'required|string|max:255',
                'kecamatan_kk' => 'required|string|max:255',
                'kota_kk' => 'required|string|max:255',
                'divisi_id' => 'nullable|string|exists:divisis,id',
                'sub_divisi' => 'nullable|string|max:255',
                'jabatan' => 'required|string|in:Ketua,Wakil Ketua,Sekretaris,Bendahara,Anggota',
            ]);
            
            // Log validated data
            \Log::info('Data tervalidasi:', $validated);
            
            try {
                $pengurus->update($validated);
                \Log::info('Pengurus berhasil diperbarui dengan ID: ' . $pengurus->id);
            } catch (\Exception $e) {
                \Log::error('Error saat update Pengurus:', [
                    'message' => $e->getMessage(),
                    'sql' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
                ]);
                throw $e;
            }

            return redirect()->route('pengurus.index')
                ->with('success', 'Data pengurus berhasil diperbarui!');
                
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui pengurus: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return back()
                    ->withInput()
                    ->withErrors($e->errors());
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi atau hubungi administrator.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $pengurus)
    {
        if ($pengurus->user) {
            $pengurus->user->delete();
        }
        $pengurus->delete();

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
