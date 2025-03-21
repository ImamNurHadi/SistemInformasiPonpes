<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiSupplier extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'supplier_id',
        'koperasi_id',
        'nama_barang',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'keterangan',
        'status'
    ];
    
    /**
     * Get the supplier that owns the transaction.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    /**
     * Get the koperasi that owns the transaction.
     */
    public function koperasi()
    {
        return $this->belongsTo(DataKoperasi::class, 'koperasi_id');
    }
    
    /**
     * Create a new transaction and update saldo of supplier and koperasi.
     */
    public static function createTransaction($data)
    {
        DB::beginTransaction();
        
        try {
            $supplier = Supplier::findOrFail($data['supplier_id']);
            $koperasi = DataKoperasi::findOrFail($data['koperasi_id']);
            
            // Hitung total harga
            $total_harga = $data['jumlah'] * $data['harga_satuan'];
            
            // Cek apakah koperasi memiliki saldo yang cukup
            if (!$koperasi->hasSufficientSaldo($total_harga)) {
                throw new \Exception('Saldo koperasi tidak mencukupi untuk transaksi ini.');
            }
            
            // Buat transaksi
            $transaction = self::create([
                'supplier_id' => $data['supplier_id'],
                'koperasi_id' => $data['koperasi_id'],
                'nama_barang' => $data['nama_barang'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $data['harga_satuan'],
                'total_harga' => $total_harga,
                'keterangan' => $data['keterangan'] ?? null,
                'status' => 'selesai'
            ]);
            
            // Update saldo
            $koperasi->reduceSaldoBelanja($total_harga);
            $supplier->addSaldoBelanja($total_harga);
            
            DB::commit();
            
            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
