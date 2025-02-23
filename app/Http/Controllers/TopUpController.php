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
            'jenis_saldo' => 'required|in:utama,belanja',
            'jumlah' => [
                'required',
                'numeric',
                'min:1000',
                function ($attribute, $value, $fail) {
                    if ($value % 500 !== 0) {
                        $fail('Jumlah harus kelipatan 500.');
                    }
                }
            ],
        ]);

        try {
            $santri = Santri::findOrFail($request->santri_id);
            
            // Update saldo berdasarkan jenis yang dipilih
            if ($request->jenis_saldo === 'belanja') {
                $santri->saldo_belanja = $santri->saldo_belanja + $request->jumlah;
            } else {
                $santri->saldo_utama = $santri->saldo_utama + $request->jumlah;
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

            return redirect()->route('histori-saldo.index')
                ->with('success', 'Saldo berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan top up: ' . $e->getMessage());
        }
    }
}
