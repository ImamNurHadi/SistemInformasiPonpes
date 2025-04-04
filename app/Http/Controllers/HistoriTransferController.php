<?php

namespace App\Http\Controllers;

use App\Models\HistoriTransfer;
use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriTransferController extends Controller
{
    /**
     * Menampilkan halaman histori transfer QR code
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $historiTransfer = collect(); // Empty collection by default
        $tingkatan = MasterTingkatan::all();
        $isSearching = false;

        // Only process search if form is submitted
        if ($request->has('search') || $request->has('tanggal_mulai') || $request->has('tanggal_akhir')) {
            $isSearching = true;
            $query = HistoriTransfer::with(['pengirim.tingkatan', 'penerima.tingkatan']);

            // Filter berdasarkan NIS Pengirim
            if ($request->filled('nis_pengirim')) {
                $query->whereHas('pengirim', function($q) use ($request) {
                    $q->where('nis', 'like', '%' . $request->nis_pengirim . '%');
                });
            }

            // Filter berdasarkan Nama Pengirim
            if ($request->filled('nama_pengirim')) {
                $query->whereHas('pengirim', function($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->nama_pengirim . '%');
                });
            }

            // Filter berdasarkan NIS Penerima
            if ($request->filled('nis_penerima')) {
                $query->whereHas('penerima', function($q) use ($request) {
                    $q->where('nis', 'like', '%' . $request->nis_penerima . '%');
                });
            }

            // Filter berdasarkan Nama Penerima
            if ($request->filled('nama_penerima')) {
                $query->whereHas('penerima', function($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->nama_penerima . '%');
                });
            }

            // Filter berdasarkan Kelas Pengirim
            if ($request->filled('tingkatan_pengirim_id')) {
                $query->whereHas('pengirim', function($q) use ($request) {
                    $q->where('tingkatan_id', $request->tingkatan_pengirim_id);
                });
            }

            // Filter berdasarkan Kelas Penerima
            if ($request->filled('tingkatan_penerima_id')) {
                $query->whereHas('penerima', function($q) use ($request) {
                    $q->where('tingkatan_id', $request->tingkatan_penerima_id);
                });
            }

            // Filter berdasarkan Tipe Sumber
            if ($request->filled('tipe_sumber')) {
                $query->where('tipe_sumber', $request->tipe_sumber);
            }

            // Filter berdasarkan Tipe Tujuan
            if ($request->filled('tipe_tujuan')) {
                $query->where('tipe_tujuan', $request->tipe_tujuan);
            }

            // Filter berdasarkan Tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
            }

            $historiTransfer = $query->orderBy('tanggal', 'desc')->get();
        } else {
            // Jika tidak ada filter, tampilkan data 7 hari terakhir
            $query = HistoriTransfer::with(['pengirim.tingkatan', 'penerima.tingkatan'])
                ->whereDate('tanggal', '>=', now()->subDays(7))
                ->orderBy('tanggal', 'desc');

            $historiTransfer = $query->get();
        }

        return view('histori.transfer.index', compact('historiTransfer', 'tingkatan', 'isSearching'));
    }

    /**
     * Cetak histori transfer dalam format PDF
     */
    public function printPDF(Request $request)
    {
        $query = HistoriTransfer::with(['pengirim.tingkatan', 'penerima.tingkatan']);

        // Filter berdasarkan NIS Pengirim
        if ($request->filled('nis_pengirim')) {
            $query->whereHas('pengirim', function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->nis_pengirim . '%');
            });
        }

        // Filter berdasarkan Nama Pengirim
        if ($request->filled('nama_pengirim')) {
            $query->whereHas('pengirim', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama_pengirim . '%');
            });
        }

        // Filter berdasarkan NIS Penerima
        if ($request->filled('nis_penerima')) {
            $query->whereHas('penerima', function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->nis_penerima . '%');
            });
        }

        // Filter berdasarkan Nama Penerima
        if ($request->filled('nama_penerima')) {
            $query->whereHas('penerima', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama_penerima . '%');
            });
        }

        // Filter berdasarkan Kelas Pengirim
        if ($request->filled('tingkatan_pengirim_id')) {
            $query->whereHas('pengirim', function($q) use ($request) {
                $q->where('tingkatan_id', $request->tingkatan_pengirim_id);
            });
        }

        // Filter berdasarkan Kelas Penerima
        if ($request->filled('tingkatan_penerima_id')) {
            $query->whereHas('penerima', function($q) use ($request) {
                $q->where('tingkatan_id', $request->tingkatan_penerima_id);
            });
        }

        // Filter berdasarkan Tipe Sumber
        if ($request->filled('tipe_sumber')) {
            $query->where('tipe_sumber', $request->tipe_sumber);
        }

        // Filter berdasarkan Tipe Tujuan
        if ($request->filled('tipe_tujuan')) {
            $query->where('tipe_tujuan', $request->tipe_tujuan);
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $historiTransfer = $query->orderBy('tanggal', 'desc')->get();
        
        $tanggal = now()->format('d/m/Y H:i');
        $periodeTeks = '';
        
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $periodeTeks = 'Periode: ' . date('d/m/Y', strtotime($request->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($request->tanggal_akhir));
        } else if ($request->filled('tanggal_mulai')) {
            $periodeTeks = 'Periode: Mulai ' . date('d/m/Y', strtotime($request->tanggal_mulai));
        } else if ($request->filled('tanggal_akhir')) {
            $periodeTeks = 'Periode: Sampai ' . date('d/m/Y', strtotime($request->tanggal_akhir));
        }

        $pdf = PDF::loadView('histori.transfer.pdf', [
            'historiTransfer' => $historiTransfer,
            'tanggal' => $tanggal,
            'periodeTeks' => $periodeTeks
        ]);
        
        return $pdf->stream('laporan-histori-transfer.pdf');
    }
} 