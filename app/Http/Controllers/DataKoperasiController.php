<?php

namespace App\Http\Controllers;

use App\Models\DataKoperasi;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class DataKoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koperasis = DataKoperasi::with('pengurus')->orderBy('nama_koperasi')->get();
        return view('data-koperasi.index', compact('koperasis'));
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
        $validated = $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'pengurus_id' => 'required|exists:pengurus,id',
            'username' => 'required|string|max:255|unique:data_koperasis',
            'password' => 'required|string|min:6',
            'saldo_belanja' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $koperasi = DataKoperasi::create([
                'nama_koperasi' => $validated['nama_koperasi'],
                'lokasi' => $validated['lokasi'],
                'pengurus_id' => $validated['pengurus_id'],
                'username' => $validated['username'],
                'password_hash' => Hash::make($validated['password']),
                'saldo_belanja' => $validated['saldo_belanja'],
                'keuntungan' => 0
            ]);

            DB::commit();

            return redirect()
                ->route('data-koperasi.index')
                ->with('success', 'Koperasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menambah koperasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambah koperasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DataKoperasi $dataKoperasi)
    {
        $dataKoperasi->load(['pengurus', 'supplies']);
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
        $validated = $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'pengurus_id' => 'required|exists:pengurus,id',
            'username' => 'required|string|max:255|unique:data_koperasis,username,' . $dataKoperasi->id,
            'password' => 'nullable|string|min:6'
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'nama_koperasi' => $validated['nama_koperasi'],
                'lokasi' => $validated['lokasi'],
                'pengurus_id' => $validated['pengurus_id'],
                'username' => $validated['username']
            ];

            if (!empty($validated['password'])) {
                $data['password_hash'] = Hash::make($validated['password']);
            }

            $dataKoperasi->update($data);

            DB::commit();

            return redirect()
                ->route('data-koperasi.index')
                ->with('success', 'Data koperasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat mengupdate koperasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengupdate koperasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataKoperasi $dataKoperasi)
    {
        try {
            DB::beginTransaction();

            $dataKoperasi->delete();

            DB::commit();

            return redirect()
                ->route('data-koperasi.index')
                ->with('success', 'Koperasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menghapus koperasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus koperasi: ' . $e->getMessage());
        }
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

    /**
     * Cairkan keuntungan koperasi
     */
    public function cairkanKeuntungan(DataKoperasi $dataKoperasi)
    {
        try {
            DB::beginTransaction();

            // Update keuntungan terlebih dahulu
            $dataKoperasi->updateKeuntungan();

            // Cairkan keuntungan
            $dataKoperasi->cairkanKeuntungan();

            DB::commit();

            return redirect()
                ->route('data-koperasi.show', $dataKoperasi)
                ->with('success', 'Keuntungan berhasil dicairkan ke saldo belanja.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat mencairkan keuntungan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mencairkan keuntungan: ' . $e->getMessage());
        }
    }
}
