<?php

namespace App\Http\Controllers;

use App\Models\HistoriSaldo;
use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $historiSaldo = $query->orderBy('created_at', 'desc')->get();
        } else {
            // Cek apakah user adalah santri
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $historiSaldo = $query->where('santri_id', $santri->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('saldo.histori', compact('historiSaldo', 'tingkatan'));
    }
} 