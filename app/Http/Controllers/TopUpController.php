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
            'jenis_saldo' => 'required|in:utama,belanja,tabungan',
        ]);

        $santri = Santri::findOrFail($request->santri_id);
        
        // Update saldo sesuai jenisnya
        switch($request->jenis_saldo) {
            case 'utama':
                $santri->saldo_utama += $request->jumlah;
                break;
            case 'belanja':
                $santri->saldo_belanja += $request->jumlah;
                break;
            case 'tabungan':
                $santri->saldo_tabungan += $request->jumlah;
                break;
        }
        
        $santri->save();

        // Catat histori top up
        HistoriSaldo::create([
            'santri_id' => $santri->id,
            'jumlah' => $request->jumlah,
            'keterangan' => 'Top Up Saldo ' . ucfirst($request->jenis_saldo),
            'tipe' => 'masuk',
            'jenis_saldo' => $request->jenis_saldo
        ]);

        return redirect()->route('histori-saldo.index')->with('success', 'Saldo ' . ucfirst($request->jenis_saldo) . ' berhasil ditambahkan');
    }
}
