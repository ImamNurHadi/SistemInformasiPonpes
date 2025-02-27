<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KantinController extends Controller
{
    public function index()
    {
        $santri = Santri::all();
        return view('kantin.index', compact('santri'));
    }

    public function bayar(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'total' => 'required|numeric|min:1',
            'items' => 'required|array|min:1'
        ]);

        try {
            DB::beginTransaction();

            $santri = Santri::lockForUpdate()->findOrFail($validated['santri_id']);

            if ($santri->saldo_belanja < $validated['total']) {
                throw new \InvalidArgumentException('Saldo belanja tidak mencukupi');
            }

            // Kurangi saldo belanja
            Santri::where('id', $santri->id)->decrement('saldo_belanja', $validated['total']);

            // Catat histori pembayaran
            HistoriSaldo::create([
                'santri_id' => $santri->id,
                'jumlah' => $validated['total'],
                'keterangan' => 'Pembayaran di Kantin',
                'tipe' => 'keluar'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil',
                'new_saldo_belanja' => $santri->fresh()->saldo_belanja
            ]);

        } catch (\InvalidArgumentException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan, silakan coba lagi'], 500);
        }
    }
} 