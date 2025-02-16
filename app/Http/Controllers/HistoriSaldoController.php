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
        if (Auth::user()->isAdmin()) {
            $historiSaldo = HistoriSaldo::with('santri')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $santri = Santri::where('user_id', Auth::id())->first();
            if (!$santri) {
                return redirect()->back()->with('error', 'Data santri tidak ditemukan');
            }
            
            $historiSaldo = HistoriSaldo::where('santri_id', $santri->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('saldo.histori', compact('historiSaldo'));
    }
} 