<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKoperasi;
use App\Models\MasterTingkatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $transaksi = collect(); // Empty collection by default
        $tingkatan = MasterTingkatan::all();
        $isSearching = false;

        // Only process search if form is submitted
        if ($request->has('search')) {
            $isSearching = true;
            $query = TransaksiKoperasi::with('santri.tingkatan');

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

            $transaksi = $query->orderBy('created_at', 'desc')->get();
        }

        return view('laporan.pembayaran.index', compact('transaksi', 'tingkatan', 'isSearching'));
    }

    public function print(Request $request)
    {
        $query = TransaksiKoperasi::with('santri.tingkatan');

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

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('laporan.pembayaran.pdf', [
            'transaksi' => $transaksi,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->stream('laporan-pembayaran.pdf');
    }
}
