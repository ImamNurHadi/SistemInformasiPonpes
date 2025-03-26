<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\HistoriSaldo;
use App\Models\MasterTingkatan;
use Illuminate\Http\Request;

class TarikTunaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('tingkatan');
        $tingkatan = MasterTingkatan::all();
        $santri = null;
        $selectedSantri = null;

        // Jika ada santri_id yang dipilih untuk tarik tunai
        if ($request->filled('santri_id')) {
            $selectedSantri = Santri::findOrFail($request->santri_id);
        }

        // Jika tombol cari diklik (ditandai dengan adanya request)
        if ($request->has('search') || $request->has('tingkatan_id')) {
            // Filter berdasarkan pencarian (jika ada)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nis', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%");
                });
            }
            
            // Filter berdasarkan kelas (jika ada)
            if ($request->filled('tingkatan_id')) {
                $query->where('tingkatan_id', $request->tingkatan_id);
            }
            
            // Ambil data santri (maksimal 100 data untuk performa)
            $santri = $query->limit(100)->get();
            
            // Hanya tampilkan pesan error jika ada filter yang digunakan tapi tidak ada hasil
            if ($santri->isEmpty() && ($request->filled('search') || $request->filled('tingkatan_id'))) {
                return back()->with('error', 'Santri tidak ditemukan');
            }
        }

        return view('saldo.tarik-tunai', compact('santri', 'tingkatan', 'selectedSantri'));
    }

    public function showForm(Santri $santri)
    {
        return view('saldo.tarik-tunai-form', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'jumlah' => [
                'required',
                'numeric',
                'min:1000',
                function ($attribute, $value, $fail) {
                    if ($value % 500 !== 0) {
                        $fail('Jumlah harus kelipatan 500.');
                    }
                }
            ],
        ]);

        try {
            $santri = Santri::findOrFail($request->santri_id);
            
            // Cek saldo mencukupi
            if ($santri->saldo_utama < $request->jumlah) {
                return back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan.');
            }

            // Update saldo utama
            $santri->saldo_utama = $santri->saldo_utama - $request->jumlah;
            $santri->save();

            // Catat histori penarikan
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $request->jumlah,
                'keterangan' => 'Tarik Tunai',
                'tipe' => 'keluar',
                'jenis_saldo' => 'utama'
            ]);

            return redirect()->route('histori-saldo.index')
                ->with('success', 'Penarikan tunai berhasil dilakukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan penarikan: ' . $e->getMessage());
        }
    }
} 