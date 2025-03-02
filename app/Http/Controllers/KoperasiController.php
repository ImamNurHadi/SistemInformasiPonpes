<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use App\Models\Santri;
use App\Models\HistoriSaldo;
use App\Models\TransaksiKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class KoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koperasi = Koperasi::all();
        $santri = Santri::all();
        return view('koperasi.index', compact('koperasi', 'santri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('koperasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        Koperasi::create($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Koperasi $koperasi)
    {
        return view('koperasi.edit', compact('koperasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Koperasi $koperasi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0'
        ]);

        $koperasi->update($validated);

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Koperasi $koperasi)
    {
        $koperasi->delete();

        return redirect()->route('koperasi.index')
            ->with('success', 'Data koperasi berhasil dihapus');
    }

    /**
     * Process payment from santri's balance
     */
    public function bayar(Request $request)
    {
        Log::info('Request data koperasi:', $request->all());
        Log::info('Request headers:', $request->headers->all());

        try {
            // Validasi data input
            $validated = $request->validate([
                'santri_id' => 'required|exists:santri,id',
                'total' => 'required|numeric|min:1',
                'items' => 'required|array|min:1',
                'items.*.nama' => 'required|string',
                'items.*.harga' => 'required|numeric|min:0',
                'items.*.kuantitas' => 'required|numeric|min:1',
                'items.*.total' => 'required|numeric|min:0'
            ]);

            Log::info('Validated data koperasi:', $validated);
            Log::info('Santri ID type:', [
                'type' => gettype($validated['santri_id']),
                'value' => $validated['santri_id']
            ]);

            DB::beginTransaction();

            try {
                // Ambil data santri dengan lock untuk update
                $santri = Santri::lockForUpdate()->findOrFail($validated['santri_id']);
                Log::info('Santri found:', [
                    'id' => $santri->id,
                    'nama' => $santri->nama,
                    'saldo_belanja' => $santri->saldo_belanja,
                    'total_pembayaran' => $validated['total']
                ]);

                // Validasi saldo
                if ($santri->saldo_belanja < $validated['total']) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Saldo belanja tidak mencukupi. Saldo: Rp%s, Total Pembayaran: Rp%s',
                            number_format($santri->saldo_belanja, 0, ',', '.'),
                            number_format($validated['total'], 0, ',', '.')
                        )
                    );
                }

                // Validasi total pembayaran dengan total items
                $totalItems = collect($validated['items'])->sum('total');
                if (abs($totalItems - $validated['total']) > 0.01) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Total pembayaran (Rp%s) tidak sesuai dengan total item (Rp%s)',
                            number_format($validated['total'], 0, ',', '.'),
                            number_format($totalItems, 0, ',', '.')
                        )
                    );
                }

                // Simpan saldo awal untuk logging
                $saldoAwal = $santri->saldo_belanja;
                
                // Kurangi saldo belanja
                $santri->saldo_belanja -= $validated['total'];
                if (!$santri->save()) {
                    throw new \RuntimeException('Gagal menyimpan perubahan saldo');
                }

                // Verifikasi pengurangan saldo
                $selisih = $saldoAwal - $santri->saldo_belanja;
                if (abs($selisih - $validated['total']) > 0.01) {
                    throw new \RuntimeException(
                        sprintf(
                            'Pengurangan saldo tidak sesuai. Selisih: Rp%s, Seharusnya: Rp%s',
                            number_format($selisih, 0, ',', '.'),
                            number_format($validated['total'], 0, ',', '.')
                        )
                    );
                }

                Log::info('Saldo updated koperasi:', [
                    'santri_id' => $santri->id,
                    'nama_santri' => $santri->nama,
                    'saldo_awal' => $saldoAwal,
                    'jumlah_pengurangan' => $validated['total'],
                    'saldo_akhir' => $santri->saldo_belanja,
                    'selisih' => $selisih
                ]);

                // Catat histori pembayaran
                try {
                    $historiData = [
                        'santri_id' => $santri->id,
                        'jumlah' => $validated['total'],
                        'keterangan' => 'Pembayaran di Koperasi',
                        'tipe' => 'keluar'
                    ];
                    
                    // Cek apakah kolom jenis_saldo ada di tabel
                    if (Schema::hasColumn('histori_saldo', 'jenis_saldo')) {
                        $historiData['jenis_saldo'] = 'belanja';
                    }
                    
                    $histori = HistoriSaldo::create($historiData);

                    Log::info('Histori saldo created:', $histori->toArray());
                } catch (\Exception $e) {
                    Log::error('Error creating histori saldo:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw new \RuntimeException('Gagal mencatat histori saldo: ' . $e->getMessage());
                }

                // Catat setiap item transaksi
                foreach ($validated['items'] as $item) {
                    Log::info('Processing item koperasi:', $item);
                    
                    try {
                        $transaksi = TransaksiKoperasi::create([
                            'santri_id' => $santri->id,
                            'nama_barang' => $item['nama'],
                            'harga_satuan' => $item['harga'],
                            'kuantitas' => $item['kuantitas'],
                            'total' => $item['total']
                        ]);

                        Log::info('Transaksi created:', $transaksi->toArray());
                    } catch (\Exception $e) {
                        Log::error('Error creating transaksi:', [
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw new \RuntimeException('Gagal mencatat transaksi: ' . $e->getMessage());
                    }
                }

                DB::commit();
                Log::info('Transaction committed successfully koperasi. Final saldo: ' . $santri->saldo_belanja);

                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran berhasil',
                    'new_saldo_belanja' => $santri->saldo_belanja
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e; // Re-throw untuk ditangkap oleh catch di luar
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::warning('Validation error koperasi:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_map(function($errors) {
                    return implode(', ', $errors);
                }, $e->errors()))
            ], 422);
        } catch (\InvalidArgumentException $e) {
            DB::rollback();
            Log::warning('Invalid argument koperasi:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in transaction koperasi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ], 500);
        }
    }
}
