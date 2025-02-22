<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunTabunganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $saldo = null;
        $santriList = null;
        $tingkatan = MasterTingkatan::all();

        if ($user->isAdmin() || $user->isOperator()) {
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

            $santriList = $query->get();
        } elseif ($user->isSantri()) {
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                $saldo = $santri->saldo_tabungan;
            }
        }

        return view('akun.tabungan', compact('saldo', 'santriList', 'tingkatan'));
    }
} 