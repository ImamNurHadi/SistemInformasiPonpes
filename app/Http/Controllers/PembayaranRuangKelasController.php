<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\PembayaranSantri;
use App\Models\HistoriSaldo;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranRuangKelasController extends Controller
{
    public function index()
    {
        $tingkatan = MasterTingkatan::all();
        return view('pembayaran.ruang-kelas.index', compact('tingkatan'));
    }

    public function search(Request $request)
    {
        $tingkatan = MasterTingkatan::all();
        $query = Santri::with('tingkatan');

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
        return view('pembayaran.ruang-kelas.index', compact('santri', 'tingkatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string',
        ]);

        $santri = Santri::findOrFail($request->santri_id);
        $jumlah = $request->jumlah;
        
        // Cek apakah saldo utama mencukupi
        if ($santri->saldo_utama < $jumlah) {
            return redirect()->back()->with('error', 'Saldo utama santri tidak mencukupi untuk melakukan pembayaran');
        }
        
        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            // Kurangi saldo utama santri
            $santri->saldo_utama -= $jumlah;
            $santri->save();
            
            // Catat pembayaran
            PembayaranSantri::create([
                'santri_id' => $santri->id,
                'jenis_pembayaran' => 'ruang_kelas',
                'keterangan' => $request->keterangan ?? 'Pembayaran Ruang Kelas',
                'jumlah' => $jumlah,
            ]);
            
            // Catat histori saldo
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $jumlah,
                'keterangan' => $request->keterangan ?? 'Pembayaran Ruang Kelas',
                'tipe' => 'keluar',
                'jenis_saldo' => 'utama',
            ]);
            
            DB::commit();
            
            return redirect()->route('pembayaran-ruang-kelas.index')->with('success', 'Pembayaran ruang kelas berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
