<?php

namespace App\Http\Controllers;

use App\Models\HistoriSaldo;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriSaldoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $historiSaldo = [];

        if ($user->isAdmin() || $user->isOperator()) {
            // Admin dan Operator bisa lihat semua histori
            $historiSaldo = HistoriSaldo::with('santri')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Cek apakah user adalah santri
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $historiSaldo = HistoriSaldo::where('santri_id', $santri->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('saldo.histori', compact('historiSaldo'));
    }
} 