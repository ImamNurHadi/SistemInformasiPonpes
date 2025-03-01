<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HiddenSaldoBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('tingkatan');
        $tingkatan = MasterTingkatan::all();

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

        $santri = $query->get();
        return view('saldo.hidden-saldo-belanja', compact('santri', 'tingkatan'));
    }

    public function showForm(Santri $santri)
    {
        return view('saldo.hidden-saldo-belanja-form', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jumlah' => 'required|numeric|min:1000|multiple_of:500'
        ]);

        try {
            DB::beginTransaction();

            $santri = Santri::lockForUpdate()->findOrFail($request->santri_id);
            
            // Update saldo belanja
            $santri->increment('saldo_belanja', $request->jumlah);

            // Catat histori
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $request->jumlah,
                'keterangan' => 'Top Up Saldo Belanja',
                'tipe' => 'masuk',
                'jenis_saldo' => 'belanja'
            ]);

            DB::commit();

            return redirect()->route('hidden-saldo-belanja.index')
                ->with('success', 'Top up saldo belanja berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat top up saldo belanja');
        }
    }
} 