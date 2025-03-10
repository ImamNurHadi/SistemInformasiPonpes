<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanAkunSaldoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $santri = collect(); // Empty collection by default
        $tingkatan = MasterTingkatan::all();
        $isSearching = false;
        $totalSaldoUtama = 0;
        $totalSaldoBelanja = 0;
        $totalSaldoTabungan = 0;

        // Only process search if form is submitted
        if ($request->has('search')) {
            $isSearching = true;
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

            // Calculate total saldo
            $totalSaldoUtama = $santri->sum('saldo_utama');
            $totalSaldoBelanja = $santri->sum('saldo_belanja');
            $totalSaldoTabungan = $santri->sum('saldo_tabungan');
        }

        return view('laporan.akun-saldo.index', compact(
            'santri', 
            'tingkatan', 
            'totalSaldoUtama', 
            'totalSaldoBelanja', 
            'totalSaldoTabungan',
            'isSearching'
        ));
    }

    public function print(Request $request)
    {
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

        // Calculate total saldo
        $totalSaldoUtama = $santri->sum('saldo_utama');
        $totalSaldoBelanja = $santri->sum('saldo_belanja');
        $totalSaldoTabungan = $santri->sum('saldo_tabungan');

        $pdf = PDF::loadView('laporan.akun-saldo.pdf', [
            'santri' => $santri,
            'totalSaldoUtama' => $totalSaldoUtama,
            'totalSaldoBelanja' => $totalSaldoBelanja,
            'totalSaldoTabungan' => $totalSaldoTabungan,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);
        
        return $pdf->stream('laporan-akun-saldo.pdf');
    }
}
