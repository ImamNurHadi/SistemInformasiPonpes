<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'koperasi');
        $supplies = Supply::where('kategori', $kategori)
            ->orderBy('nama_barang')
            ->paginate(10);
        
        return view('supply.index', compact('supplies', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supply.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'kategori' => 'required|in:koperasi,kantin',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            Supply::create($validated);
            return redirect()
                ->route('supply.index', ['kategori' => $validated['kategori']])
                ->with('success', 'Barang berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error saat menambah supply: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambah barang');
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
    public function edit(Supply $supply)
    {
        return view('supply.edit', compact('supply'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'kategori' => 'required|in:koperasi,kantin',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $supply->update($validated);
            return redirect()
                ->route('supply.index', ['kategori' => $supply->kategori])
                ->with('success', 'Barang berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error saat update supply: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        try {
            $kategori = $supply->kategori;
            $supply->delete();
            return redirect()
                ->route('supply.index', ['kategori' => $kategori])
                ->with('success', 'Barang berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus supply: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus barang');
        }
    }
}
