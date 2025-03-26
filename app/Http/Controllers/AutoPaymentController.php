<?php

namespace App\Http\Controllers;

use App\Models\AutoPaymentSetting;
use App\Models\Santri;
use App\Models\PembayaranSantri;
use App\Models\HistoriSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AutoPaymentController extends Controller
{
    /**
     * Display the auto payment settings.
     */
    public function index()
    {
        $settings = AutoPaymentSetting::orderBy('jenis_pembayaran')->get();
        return view('pembayaran.auto.index', compact('settings'));
    }

    /**
     * Store a new auto payment setting.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|string',
            'jumlah' => 'required|numeric|min:500',
            'tanggal_eksekusi' => 'required|integer|min:1|max:28',
            'keterangan' => 'nullable|string',
        ]);

        // Memastikan jumlah adalah kelipatan 500
        if ($request->jumlah % 500 != 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jumlah' => 'Jumlah pembayaran harus dalam kelipatan 500']);
        }

        AutoPaymentSetting::create([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'jumlah' => $request->jumlah,
            'tanggal_eksekusi' => $request->tanggal_eksekusi,
            'aktif' => $request->has('aktif'),
            'keterangan' => $request->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($request->jenis_pembayaran),
        ]);

        return redirect()->route('pembayaran-auto.index')
            ->with('success', 'Pengaturan pembayaran otomatis berhasil ditambahkan');
    }

    /**
     * Update an auto payment setting.
     */
    public function update(Request $request, AutoPaymentSetting $setting)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|string',
            'jumlah' => 'required|numeric|min:500',
            'tanggal_eksekusi' => 'required|integer|min:1|max:28',
            'keterangan' => 'nullable|string',
        ]);

        // Memastikan jumlah adalah kelipatan 500
        if ($request->jumlah % 500 != 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jumlah' => 'Jumlah pembayaran harus dalam kelipatan 500']);
        }

        $setting->update([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'jumlah' => $request->jumlah,
            'tanggal_eksekusi' => $request->tanggal_eksekusi,
            'aktif' => $request->has('aktif'),
            'keterangan' => $request->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($request->jenis_pembayaran),
        ]);

        return redirect()->route('pembayaran-auto.index')
            ->with('success', 'Pengaturan pembayaran otomatis berhasil diperbarui');
    }

    /**
     * Toggle activation status of an auto payment setting.
     */
    public function toggleStatus(AutoPaymentSetting $setting)
    {
        $setting->update([
            'aktif' => !$setting->aktif
        ]);

        $status = $setting->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('pembayaran-auto.index')
            ->with('success', "Pembayaran otomatis berhasil $status");
    }

    /**
     * Process automatic payments for all santri.
     */
    public function processPayments(Request $request)
    {
        $settingId = $request->input('setting_id');
        $setting = AutoPaymentSetting::findOrFail($settingId);
        
        // Get all active santri
        $santriList = Santri::all();
        $successCount = 0;
        $failCount = 0;
        
        foreach ($santriList as $santri) {
            // Skip if santri doesn't have enough balance
            if ($santri->saldo_utama < $setting->jumlah) {
                $failCount++;
                continue;
            }
            
            // Begin database transaction
            DB::beginTransaction();
            
            try {
                // Reduce santri's balance
                $santri->saldo_utama -= $setting->jumlah;
                $santri->save();
                
                // Record payment
                PembayaranSantri::create([
                    'santri_id' => $santri->id,
                    'jenis_pembayaran' => $setting->jenis_pembayaran,
                    'keterangan' => $setting->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($setting->jenis_pembayaran),
                    'jumlah' => $setting->jumlah,
                ]);
                
                // Record balance history
                HistoriSaldo::create([
                    'santri_id' => $santri->id,
                    'jumlah' => $setting->jumlah,
                    'keterangan' => $setting->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($setting->jenis_pembayaran),
                    'tipe' => 'keluar',
                    'jenis_saldo' => 'utama',
                ]);
                
                DB::commit();
                $successCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                $failCount++;
            }
        }
        
        return redirect()->route('pembayaran-auto.index')
            ->with('success', "Pembayaran otomatis berhasil diproses untuk $successCount santri. Gagal: $failCount santri.");
    }

    /**
     * Method to be called by scheduler.
     */
    public function runScheduledPayments()
    {
        $today = Carbon::now()->day;
        
        // Get active settings scheduled for today
        $settings = AutoPaymentSetting::where('aktif', true)
            ->where('tanggal_eksekusi', $today)
            ->get();
            
        $totalProcessed = 0;
        
        foreach ($settings as $setting) {
            // Get all active santri
            $santriList = Santri::all();
            
            foreach ($santriList as $santri) {
                // Skip if santri doesn't have enough balance
                if ($santri->saldo_utama < $setting->jumlah) {
                    continue;
                }
                
                // Begin database transaction
                DB::beginTransaction();
                
                try {
                    // Reduce santri's balance
                    $santri->saldo_utama -= $setting->jumlah;
                    $santri->save();
                    
                    // Record payment
                    PembayaranSantri::create([
                        'santri_id' => $santri->id,
                        'jenis_pembayaran' => $setting->jenis_pembayaran,
                        'keterangan' => $setting->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($setting->jenis_pembayaran),
                        'jumlah' => $setting->jumlah,
                    ]);
                    
                    // Record balance history
                    HistoriSaldo::create([
                        'santri_id' => $santri->id,
                        'jumlah' => $setting->jumlah,
                        'keterangan' => $setting->keterangan ?? 'Pembayaran Otomatis ' . ucfirst($setting->jenis_pembayaran),
                        'tipe' => 'keluar',
                        'jenis_saldo' => 'utama',
                    ]);
                    
                    DB::commit();
                    $totalProcessed++;
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        }
        
        return $totalProcessed;
    }
}
