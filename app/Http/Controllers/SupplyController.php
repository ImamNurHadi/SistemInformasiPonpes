<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use App\Models\DataKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $supplier_id = $request->get('supplier_id');
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        
        $query = Supply::query()->with(['supplier', 'dataKoperasi']);
        
        if ($supplier_id) {
            $query->where('supplier_id', $supplier_id);
        }
        
        $supplies = $query->orderBy('tanggal_masuk', 'desc')->paginate(10);
        $selectedSupplier = $supplier_id ? Supplier::find($supplier_id) : null;
        
        return view('supply.index', compact('supplies', 'suppliers', 'selectedSupplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $dataKoperasi = DataKoperasi::orderBy('nama_koperasi')->get();
        return view('supply.create', compact('suppliers', 'dataKoperasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'data_koperasi_id' => 'required|exists:data_koperasis,id',
            'kategori' => 'nullable|string|max:255',
        ]);

        try {
            // Hitung total harga
            $validated['total_harga'] = $validated['stok'] * $validated['harga_satuan'];
            $validated['tanggal_masuk'] = now();
            
            // Tambahkan nilai default untuk kategori
            $validated['kategori'] = $request->input('kategori', 'Umum');
            
            // Double check untuk memastikan kategori tidak NULL
            if (empty($validated['kategori'])) {
                $validated['kategori'] = 'Umum';
            }
            
            // Dapatkan koperasi
            $koperasi = DataKoperasi::findOrFail($validated['data_koperasi_id']);
            
            // Periksa apakah saldo koperasi cukup
            if (!$koperasi->hasSufficientSaldo($validated['total_harga'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Saldo belanja koperasi tidak mencukupi');
            }
            
            DB::beginTransaction();
            
            // Kurangi saldo koperasi
            $koperasi->reduceSaldoBelanja($validated['total_harga']);
            
            // Simpan supply
            Supply::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('supply.index', ['supplier_id' => $validated['supplier_id']])
                ->with('success', 'Barang berhasil ditambahkan dan saldo koperasi berhasil dikurangi');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menambah supply: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambah barang: ' . $e->getMessage());
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
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $dataKoperasi = DataKoperasi::orderBy('nama_koperasi')->get();
        return view('supply.edit', compact('supply', 'suppliers', 'dataKoperasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'data_koperasi_id' => 'required|exists:data_koperasis,id',
            'kategori' => 'nullable|string|max:255',
        ]);

        try {
            // Tambahkan nilai default untuk kategori
            $validated['kategori'] = $request->input('kategori', $supply->kategori ?? 'Umum');
            
            // Double check untuk memastikan kategori tidak NULL
            if (empty($validated['kategori'])) {
                $validated['kategori'] = 'Umum';
            }
            
            // Hitung total harga baru
            $newTotalHarga = $validated['stok'] * $validated['harga_satuan'];
            $oldTotalHarga = $supply->total_harga;
            
            // Tentukan apakah ada perubahan pada total harga
            $priceDifference = $newTotalHarga - $oldTotalHarga;
            
            // Jika ada perubahan data_koperasi_id atau harga meningkat
            if ($supply->data_koperasi_id != $validated['data_koperasi_id'] || $priceDifference > 0) {
                // Jika koperasi berubah
                if ($supply->data_koperasi_id != $validated['data_koperasi_id']) {
                    $oldKoperasi = DataKoperasi::findOrFail($supply->data_koperasi_id);
                    $newKoperasi = DataKoperasi::findOrFail($validated['data_koperasi_id']);
                    
                    // Kembalikan saldo koperasi lama
                    $oldKoperasi->addSaldoBelanja($oldTotalHarga);
                    
                    // Periksa dan kurangi saldo koperasi baru
                    if (!$newKoperasi->hasSufficientSaldo($newTotalHarga)) {
                        return back()
                            ->withInput()
                            ->with('error', 'Saldo belanja koperasi tujuan tidak mencukupi');
                    }
                    
                    DB::beginTransaction();
                    
                    // Kurangi saldo koperasi baru
                    $newKoperasi->reduceSaldoBelanja($newTotalHarga);
                } else {
                    // Koperasi sama, cek apakah harganya bertambah
                    $koperasi = DataKoperasi::findOrFail($validated['data_koperasi_id']);
                    
                    // Periksa apakah saldo cukup untuk selisih harga
                    if ($priceDifference > 0 && !$koperasi->hasSufficientSaldo($priceDifference)) {
                        return back()
                            ->withInput()
                            ->with('error', 'Saldo belanja koperasi tidak mencukupi untuk penambahan harga');
                    }
                    
                    DB::beginTransaction();
                    
                    // Sesuaikan saldo koperasi
                    if ($priceDifference > 0) {
                        $koperasi->reduceSaldoBelanja($priceDifference);
                    } else if ($priceDifference < 0) {
                        $koperasi->addSaldoBelanja(abs($priceDifference));
                    }
                }
            } else {
                DB::beginTransaction();
            }
            
            // Simpan total harga baru
            $validated['total_harga'] = $newTotalHarga;
            
            // Update supply
            $supply->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('supply.index', ['supplier_id' => $supply->supplier_id])
                ->with('success', 'Barang berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat update supply: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui barang: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        try {
            $supplier_id = $supply->supplier_id;
            
            // Kembalikan saldo koperasi
            $koperasi = DataKoperasi::findOrFail($supply->data_koperasi_id);
            
            DB::beginTransaction();
            
            // Tambahkan kembali saldo koperasi
            $koperasi->addSaldoBelanja($supply->total_harga);
            
            // Hapus supply
            $supply->delete();
            
            DB::commit();
            
            return redirect()
                ->route('supply.index', ['supplier_id' => $supplier_id])
                ->with('success', 'Barang berhasil dihapus dan saldo koperasi berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menghapus supply: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus barang: ' . $e->getMessage());
        }
    }
}
