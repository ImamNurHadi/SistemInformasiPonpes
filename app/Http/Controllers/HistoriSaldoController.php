<?php

namespace App\Http\Controllers;

use App\Models\HistoriSaldo;
use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriSaldoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $historiSaldo = [];
        $tingkatan = MasterTingkatan::all();

        $query = HistoriSaldo::with('santri.tingkatan');

        if ($user->isAdmin() || $user->isOperator()) {
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
        } else {
            // Cek apakah user adalah santri
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $query->where('santri_id', $santri->id);

                // Filter berdasarkan Tipe Transaksi untuk santri
                if ($request->filled('tipe')) {
                    $query->where('tipe', $request->tipe);
                }

                // Filter berdasarkan Tanggal untuk santri
                if ($request->filled('tanggal_mulai')) {
                    $query->whereDate('created_at', '>=', $request->tanggal_mulai);
                }
                if ($request->filled('tanggal_akhir')) {
                    $query->whereDate('created_at', '<=', $request->tanggal_akhir);
                }

                $historiSaldo = $query->orderBy('created_at', 'desc')->get();
            }
        }

        return view('saldo.histori', compact('historiSaldo', 'tingkatan'));
    }

    public function printPDF(Request $request)
    {
        $user = Auth::user();
        $tingkatan = MasterTingkatan::all();
        $query = HistoriSaldo::with('santri.tingkatan');

        if ($user->isAdmin() || $user->isOperator()) {
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
        } else {
            // Jika user adalah santri, hanya tampilkan data mereka
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $query->where('santri_id', $santri->id);

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
            }
        }

        $historiSaldo = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('saldo.histori-pdf', [
            'historiSaldo' => $historiSaldo,
            'tingkatan' => $tingkatan,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->stream('laporan-histori-saldo.pdf');
    }
} 