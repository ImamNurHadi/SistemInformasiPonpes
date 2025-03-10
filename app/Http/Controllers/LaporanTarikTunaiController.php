<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriSaldo;
use App\Models\MasterTingkatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanTarikTunaiController extends Controller
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
            $query = HistoriSaldo::with('santri.tingkatan')
                ->where('keterangan', 'like', '%Tarik Tunai%')
                ->where('tipe', 'keluar');

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

            // Filter berdasarkan Jenis Saldo
            if ($request->filled('jenis_saldo')) {
                $query->where('jenis_saldo', $request->jenis_saldo);
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

        return view('laporan.tarik-tunai.index', compact('historiSaldo', 'tingkatan', 'isSearching'));
    }

    public function print(Request $request)
    {
        $query = HistoriSaldo::with('santri.tingkatan')
            ->where('keterangan', 'like', '%Tarik Tunai%')
            ->where('tipe', 'keluar');

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

        // Filter berdasarkan Jenis Saldo
        if ($request->filled('jenis_saldo')) {
            $query->where('jenis_saldo', $request->jenis_saldo);
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $historiSaldo = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('laporan.tarik-tunai.pdf', [
            'historiSaldo' => $historiSaldo,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->stream('laporan-tarik-tunai.pdf');
    }
}
