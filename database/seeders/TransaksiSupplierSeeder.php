<?php

namespace Database\Seeders;

use App\Models\DataKoperasi;
use App\Models\Supplier;
use App\Models\TransaksiSupplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan supplier pertama (PT Supplier Utama)
        $supplier = Supplier::first();
        
        if (!$supplier) {
            $this->command->error('Tidak ada supplier yang ditemukan. Silakan jalankan SupplierSeeder terlebih dahulu.');
            return;
        }
        
        // Dapatkan koperasi pertama (Koperasi Putra)
        $koperasi = DataKoperasi::first();
        
        if (!$koperasi) {
            $this->command->error('Tidak ada koperasi yang ditemukan. Silakan jalankan DataKoperasiSeeder terlebih dahulu.');
            return;
        }
        
        // Pertama, pastikan koperasi memiliki saldo yang cukup
        if ($koperasi->saldo_belanja < 50000) {
            $this->command->info("Mengupdate saldo koperasi {$koperasi->nama_koperasi} menjadi Rp 100.000");
            $koperasi->saldo_belanja = 100000;
            $koperasi->save();
        }
        
        // Simpan saldo awal untuk ditampilkan di report
        $saldoAwalSupplier = $supplier->saldo_belanja;
        $saldoAwalKoperasi = $koperasi->saldo_belanja;
        
        $this->command->info("Saldo awal supplier {$supplier->nama_supplier}: Rp " . number_format($saldoAwalSupplier, 2, ',', '.'));
        $this->command->info("Saldo awal koperasi {$koperasi->nama_koperasi}: Rp " . number_format($saldoAwalKoperasi, 2, ',', '.'));
        
        // Transaksi manual: supplier setor martabak 50 rb ke koperasi
        try {
            DB::beginTransaction();
            
            // Data transaksi
            $data = [
                'supplier_id' => $supplier->id,
                'koperasi_id' => $koperasi->id,
                'nama_barang' => 'Martabak',
                'jumlah' => 10, // 10 porsi
                'harga_satuan' => 5000, // @Rp 5.000 per porsi (total Rp 50.000)
                'keterangan' => 'Setoran martabak dari supplier ke koperasi'
            ];
            
            // Hitung total harga
            $total_harga = $data['jumlah'] * $data['harga_satuan'];
            
            // Buat transaksi secara manual, tanpa menggunakan createTransaction
            $transaction = TransaksiSupplier::create([
                'supplier_id' => $data['supplier_id'],
                'koperasi_id' => $data['koperasi_id'],
                'nama_barang' => $data['nama_barang'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $data['harga_satuan'],
                'total_harga' => $total_harga,
                'keterangan' => $data['keterangan'] ?? null,
                'status' => 'selesai'
            ]);
            
            // Update saldo: supplier bertambah, koperasi berkurang
            $supplier->saldo_belanja += $total_harga;
            $supplier->save();
            
            $koperasi->saldo_belanja -= $total_harga;
            $koperasi->save();
            
            $this->command->info("Transaksi berhasil: {$supplier->nama_supplier} menyetor Martabak ke {$koperasi->nama_koperasi}");
            $this->command->info("Jumlah: 10 porsi @ Rp 5.000 = Rp 50.000");
            $this->command->info("Saldo akhir supplier {$supplier->nama_supplier}: Rp " . number_format($supplier->saldo_belanja, 2, ',', '.'));
            $this->command->info("Saldo akhir koperasi {$koperasi->nama_koperasi}: Rp " . number_format($koperasi->saldo_belanja, 2, ',', '.'));
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Transaksi gagal: " . $e->getMessage());
            Log::error("TransaksiSupplierSeeder error: " . $e->getMessage());
        }
    }
}
