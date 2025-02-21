<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunTabunganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $saldo = null;
        $santriList = null;

        if ($user->isAdmin() || $user->isOperator()) {
            // Admin dan Operator bisa lihat semua saldo
            $santriList = Santri::all();
        } elseif ($user->isSantri()) {
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $saldo = $santri->saldo_tabungan;
            }
        }

        return view('akun.tabungan', compact('saldo', 'santriList'));
    }
} 