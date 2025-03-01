<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use App\Models\TransaksiKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiKoperasi::with(['santri.tingkatan']);
        $tingkatan = MasterTingkatan::all();

        // Filter berdasarkan NIS
        if ($request->filled('nis')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->nis . '%');
            });
        }

        // Filter berdasarkan Nama
        if ($request->filled('nama')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan Kelas
        if ($request->filled('tingkatan_id')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('tingkatan_id', $request->tingkatan_id);
            });
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Jika user adalah santri, hanya tampilkan historinya sendiri
        if (Auth::user()->isSantri()) {
            $santri = Santri::where('user_id', Auth::id())->first();
            if ($santri) {
                $query->where('santri_id', $santri->id);
            }
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();
        
        return view('saldo.histori-belanja', compact('transaksi', 'tingkatan'));
    }

    public function printPDF(Request $request)
    {
        $query = TransaksiKoperasi::with(['santri.tingkatan']);

        // Filter berdasarkan NIS
        if ($request->filled('nis')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->nis . '%');
            });
        }

        // Filter berdasarkan Nama
        if ($request->filled('nama')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan Kelas
        if ($request->filled('tingkatan_id')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('tingkatan_id', $request->tingkatan_id);
            });
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Jika user adalah santri, hanya tampilkan historinya sendiri
        if (Auth::user()->isSantri()) {
            $santri = Santri::where('user_id', Auth::id())->first();
            if ($santri) {
                $query->where('santri_id', $santri->id);
            }
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('saldo.histori-belanja-pdf', [
            'transaksi' => $transaksi,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->stream('histori-belanja-santri.pdf');
    }
} 