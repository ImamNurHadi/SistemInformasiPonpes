<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekSaldoController extends Controller
{
    public function index()
    {
        // Semua role bisa melihat daftar saldo santri
        $santri = Santri::all();
        return view('saldo.ceksaldo', compact('santri'));
    }
}
