<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:suppliers',
            'username' => 'required|string|max:255|unique:suppliers',
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::beginTransaction();
            
            $supplier = new Supplier();
            $supplier->nama_supplier = $request->nama_supplier;
            $supplier->alamat = $request->alamat;
            $supplier->telepon = $request->telepon;
            $supplier->email = $request->email;
            $supplier->username = $request->username;
            $supplier->password_hash = Hash::make($request->password);
            $supplier->saldo_belanja = 0; // Saldo awal 0
            $supplier->save();
            
            DB::commit();
            
            return redirect()->route('supplier.index')
                ->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menambah supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambah supplier: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:suppliers,email,' . $supplier->id,
            'username' => 'required|string|max:255|unique:suppliers,username,' . $supplier->id,
            'password' => 'nullable|string|min:8',
        ]);

        try {
            DB::beginTransaction();
            
            $supplier->nama_supplier = $request->nama_supplier;
            $supplier->alamat = $request->alamat;
            $supplier->telepon = $request->telepon;
            $supplier->email = $request->email;
            $supplier->username = $request->username;
            
            if ($request->filled('password')) {
                $supplier->password_hash = Hash::make($request->password);
            }
            
            $supplier->save();
            
            DB::commit();
            
            return redirect()->route('supplier.index')
                ->with('success', 'Supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat update supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui supplier: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            
            return redirect()->route('supplier.index')
                ->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus supplier: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus supplier: ' . $e->getMessage());
        }
    }
    
    /**
     * Top up saldo supplier
     */
    public function topUpSaldo(Request $request, Supplier $supplier)
    {
        $request->validate([
            'jumlah_topup' => 'required|numeric|min:1000',
        ]);

        try {
            DB::beginTransaction();
            
            // Tambahkan saldo
            $supplier->addSaldoBelanja($request->jumlah_topup);
            
            DB::commit();
            
            return redirect()->route('supplier.edit', $supplier->id)
                ->with('success', 'Saldo supplier berhasil ditambahkan sebesar Rp. ' . number_format($request->jumlah_topup, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat top up saldo supplier: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menambah saldo: ' . $e->getMessage());
        }
    }
} 