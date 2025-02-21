<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function index()
    {
        $santri = Santri::all();
        return view('saldo.topup', compact('santri'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jumlah' => 'required|numeric|min:0',
        ]);

        try {
            $santri = Santri::findOrFail($request->santri_id);
            
            // Update saldo utama
            $santri->saldo_utama = $santri->saldo_utama + $request->jumlah;
            $santri->save();

            // Catat histori top up
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $request->jumlah,
                'keterangan' => 'Top Up Saldo Utama',
                'tipe' => 'masuk',
                'jenis_saldo' => 'utama'
            ]);

            return redirect()->route('histori-saldo.index')
                ->with('success', 'Saldo utama berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan top up: ' . $e->getMessage());
        }
    }
}
