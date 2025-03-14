<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CekSaldoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tingkatan = MasterTingkatan::all();
        
        // Jika user adalah santri, hanya tampilkan data santri tersebut
        if ($user->isSantri()) {
            $santri = Santri::with('tingkatan')
                ->where('user_id', $user->id)
                ->get();
            
            return view('saldo.ceksaldo', compact('santri', 'tingkatan'));
        }
        
        // Jika user bukan santri (admin/operator), tampilkan semua santri dengan filter
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
        return view('saldo.ceksaldo', compact('santri', 'tingkatan'));
    }

    public function printPDF(Request $request)
    {
        $user = Auth::user();
        
        // Jika user adalah santri, hanya cetak data santri tersebut
        if ($user->isSantri()) {
            $santri = Santri::with('tingkatan')
                ->where('user_id', $user->id)
                ->get();
                
            $pdf = PDF::loadView('saldo.ceksaldo-pdf', [
                'santri' => $santri,
                'tanggal' => now()->format('d/m/Y H:i')
            ]);
    
            return $pdf->stream('daftar-saldo-santri.pdf');
        }
        
        // Jika user bukan santri (admin/operator), cetak semua santri dengan filter
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
        
        $pdf = PDF::loadView('saldo.ceksaldo-pdf', [
            'santri' => $santri,
            'tanggal' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->stream('daftar-saldo-santri.pdf');
    }
}
