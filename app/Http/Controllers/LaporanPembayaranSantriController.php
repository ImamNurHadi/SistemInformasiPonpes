<?php

namespace App\Http\Controllers;

use App\Models\PembayaranSantri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPembayaranSantriController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pembayaran = collect(); // Empty collection by default
        $tingkatan = MasterTingkatan::all();
        $isSearching = false;

        // Only process search if form is submitted
        if ($request->has('search')) {
            $isSearching = true;
            $query = PembayaranSantri::with('santri.tingkatan');

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

            // Filter berdasarkan Jenis Pembayaran
            if ($request->filled('jenis_pembayaran')) {
                $query->where('jenis_pembayaran', $request->jenis_pembayaran);
            }

            // Filter berdasarkan Tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('created_at', '<=', $request->tanggal_akhir);
            }

            $pembayaran = $query->orderBy('created_at', 'desc')->get();
        }

        return view('laporan.pembayaran-santri.index', compact('pembayaran', 'tingkatan', 'isSearching'));
    }

    public function print(Request $request)
    {
        $query = PembayaranSantri::with('santri.tingkatan');

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

        // Filter berdasarkan Jenis Pembayaran
        if ($request->filled('jenis_pembayaran')) {
            $query->where('jenis_pembayaran', $request->jenis_pembayaran);
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('laporan.pembayaran-santri.pdf', [
            'pembayaran' => $pembayaran,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->stream('laporan-pembayaran-santri.pdf');
    }
}
