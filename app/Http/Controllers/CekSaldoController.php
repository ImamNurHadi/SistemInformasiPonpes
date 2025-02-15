<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekSaldoController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $santri = Santri::all();
            return view('saldo.ceksaldo', compact('santri'));
        } else {
            $santri = Santri::where('user_id', Auth::id())->first();
            return view('saldo.ceksaldo-santri', compact('santri'));
        }
    }
}
