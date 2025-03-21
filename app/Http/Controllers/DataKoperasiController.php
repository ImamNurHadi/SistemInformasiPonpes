<?php

namespace App\Http\Controllers;

use App\Models\DataKoperasi;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataKoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKoperasi = DataKoperasi::with('pengurus')->get();
        return view('data-koperasi.index', compact('dataKoperasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengurus = Pengurus::all();
        return view('data-koperasi.create', compact('pengurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'pengurus_id' => 'required|exists:pengurus,id',
        ]);

        DataKoperasi::create($request->all());

        return redirect()->route('data-koperasi.index')
            ->with('success', 'Data koperasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataKoperasi $dataKoperasi)
    {
        return view('data-koperasi.show', compact('dataKoperasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataKoperasi $dataKoperasi)
    {
        $pengurus = Pengurus::all();
        return view('data-koperasi.edit', compact('dataKoperasi', 'pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataKoperasi $dataKoperasi)
    {
        $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'pengurus_id' => 'required|exists:pengurus,id',
        ]);

        $dataKoperasi->update($request->all());

        return redirect()->route('data-koperasi.index')
            ->with('success', 'Data koperasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataKoperasi $dataKoperasi)
    {
        $dataKoperasi->delete();

        return redirect()->route('data-koperasi.index')
            ->with('success', 'Data koperasi berhasil dihapus.');
    }

    /**
     * Top up saldo koperasi
     */
    public function topUpSaldo(Request $request, DataKoperasi $dataKoperasi)
    {
        $request->validate([
            'jumlah_topup' => 'required|numeric|min:1000',
        ]);

        try {
            DB::beginTransaction();
            
            // Tambahkan saldo
            $dataKoperasi->addSaldoBelanja($request->jumlah_topup);
            
            DB::commit();
            
            return redirect()->route('data-koperasi.edit', $dataKoperasi->id)
                ->with('success', 'Saldo koperasi berhasil ditambahkan sebesar Rp. ' . number_format($request->jumlah_topup, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat top up saldo: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menambah saldo: ' . $e->getMessage());
        }
    }
}
