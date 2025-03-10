<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriSaldo;
use App\Models\MasterTingkatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $historiSaldo = collect(); // Empty collection by default
        $tingkatan = MasterTingkatan::all();
        $isSearching = false;

        // Only process search if form is submitted
        if ($request->has('search')) {
            $isSearching = true;
            $query = HistoriSaldo::with('santri.tingkatan');

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

            // Filter berdasarkan Tipe Transaksi
            if ($request->filled('tipe')) {
                $query->where('tipe', $request->tipe);
            }

            // Filter berdasarkan Tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('created_at', '<=', $request->tanggal_akhir);
            }

            $historiSaldo = $query->orderBy('created_at', 'desc')->get();
        }

        return view('laporan.transaksi.index', compact('historiSaldo', 'tingkatan', 'isSearching'));
    }

    public function print(Request $request)
    {
        $query = HistoriSaldo::with('santri.tingkatan');

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

        // Filter berdasarkan Tipe Transaksi
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $historiSaldo = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('laporan.transaksi.pdf', [
            'historiSaldo' => $historiSaldo,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->stream('laporan-transaksi-santri.pdf');
    }
}
