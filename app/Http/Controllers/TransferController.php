<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\HistoriSaldo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display the transfer form.
     */
    public function index()
    {
        // Get the authenticated santri
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan');
        }
        
        return view('transfer.index', compact('santri'));
    }

    /**
     * Process the transfer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_saldo' => 'required|in:belanja,tabungan',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        // Get the authenticated santri
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan');
        }
        
        // Check if the sender has enough balance in saldo utama
        $jumlah = $request->jumlah;
        $jenisSaldoTujuan = $request->jenis_saldo;
        
        if ($santri->saldo_utama < $jumlah) {
            return redirect()->back()->with('error', 'Saldo utama tidak mencukupi untuk melakukan transfer');
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Deduct from saldo utama
            $santri->saldo_utama -= $jumlah;
            
            // Add to destination saldo (belanja or tabungan)
            if ($jenisSaldoTujuan === 'belanja') {
                $santri->saldo_belanja += $jumlah;
            } else {
                $santri->saldo_tabungan += $jumlah;
            }
            
            $santri->save();
            
            // Record transaction history for saldo utama (source)
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $jumlah,
                'keterangan' => "Transfer ke Saldo " . ucfirst($jenisSaldoTujuan),
                'tipe' => 'masuk',
                'jenis_saldo' => 'utama',
            ]);
            
            // Record transaction history for destination saldo
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $jumlah,
                'keterangan' => "Transfer dari Saldo Utama",
                'tipe' => 'keluar',
                'jenis_saldo' => $jenisSaldoTujuan,
            ]);
            
            DB::commit();
            
            return redirect()->route('transfer.index')->with('success', 'Transfer berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
