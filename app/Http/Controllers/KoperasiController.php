<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use App\Models\Santri;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koperasi = Koperasi::all();
        $santri = Santri::all();
        return view('koperasi.index', compact('koperasi', 'santri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('koperasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        Koperasi::create($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil ditambahkan');
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
    public function edit(Koperasi $koperasi)
    {
        return view('koperasi.edit', compact('koperasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Koperasi $koperasi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        $koperasi->update($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Koperasi $koperasi)
    {
        $koperasi->delete();

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil dihapus');
    }

    /**
     * Process payment from santri's balance
     */
    public function bayar(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            $santri = Santri::findOrFail($validated['santri_id']);

            // Cek saldo mencukupi
            if ($santri->saldo < $validated['total']) {
                throw new \Exception('Saldo tidak mencukupi');
            }

            // Kurangi saldo santri
            $santri->saldo -= $validated['total'];
            $santri->save();

            // Catat histori pembayaran
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $validated['total'],
                'keterangan' => 'Pembayaran di Koperasi',
                'tipe' => 'keluar'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil',
                'new_saldo' => $santri->saldo
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
