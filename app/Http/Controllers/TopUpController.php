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

        $santri = Santri::findOrFail($request->santri_id);
        $santri->saldo += $request->jumlah;
        $santri->save();

        // Catat histori top up
        HistoriSaldo::create([
            'santri_id' => $santri->id,
            'jumlah' => $request->jumlah,
            'keterangan' => 'Top Up Saldo',
            'tipe' => 'masuk'
        ]);

        return redirect()->route('topup.index')->with('success', 'Saldo berhasil ditambahkan');
    }
}
