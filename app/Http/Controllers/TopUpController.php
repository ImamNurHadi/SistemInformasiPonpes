<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\HistoriSaldo;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('tingkatan');
        $tingkatan = MasterTingkatan::all();
        $santri = null;

        // Filter berdasarkan NIS
        if ($request->filled('nis')) {
            $query->where('nis', 'like', '%' . $request->nis . '%');
        }

        // Filter berdasarkan Nama
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan Kelas
        if ($request->filled('tingkatan_id')) {
            $query->where('tingkatan_id', $request->tingkatan_id);
        }

        // Jika ada filter yang digunakan
        if ($request->filled('nis') || $request->filled('nama') || $request->filled('tingkatan_id')) {
            $santri = $query->get();
            
            if ($santri->isEmpty()) {
                return back()->with('error', 'Santri tidak ditemukan');
            }
        }

        return view('saldo.topup', compact('santri', 'tingkatan'));
    }

    public function showForm(Santri $santri)
    {
        return view('saldo.topup-form', compact('santri'));
    }

    public function topup(Request $request)
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
                ->with('success', 'Saldo berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan top up: ' . $e->getMessage());
        }
    }
}
