<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'stok',
        'harga_satuan',
        'total_harga',
        'kategori',
        'supplier_id',
        'data_koperasi_id',
        'tanggal_masuk'
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];
    
    /**
     * Get the supplier that owns the supply.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    /**
     * Get the koperasi that owns the supply.
     */
    public function dataKoperasi()
    {
        return $this->belongsTo(DataKoperasi::class, 'data_koperasi_id');
    }

    protected static function booted()
    {
        static::saved(function ($supply) {
            // Update keuntungan koperasi setiap kali stok berubah
            $supply->dataKoperasi->updateKeuntungan();
        });
    }
} 