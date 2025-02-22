<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;

class TarikTunaiController extends Controller
{
    public function index()
    {
        $santri = Santri::all();
        return view('saldo.tarik-tunai', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
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
            
            // Cek apakah saldo mencukupi
            if ($santri->saldo_utama < $request->jumlah) {
                return back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan.');
            }

            // Kurangi saldo utama
            $santri->saldo_utama = $santri->saldo_utama - $request->jumlah;
            $santri->save();

            // Catat histori penarikan
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $request->jumlah,
                'keterangan' => 'Tarik Tunai',
                'tipe' => 'keluar',
                'jenis_saldo' => 'utama'
            ]);

            return redirect()->route('histori-saldo.index')
                ->with('success', 'Penarikan tunai berhasil dilakukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan penarikan: ' . $e->getMessage());
        }
    }
} 