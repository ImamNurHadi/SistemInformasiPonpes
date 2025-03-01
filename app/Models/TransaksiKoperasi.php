<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKoperasi extends Model
{
    use HasFactory;

    protected $table = 'transaksi_koperasi';

    protected $fillable = [
        'santri_id',
        'nama_barang',
        'harga_satuan',
        'kuantitas',
        'total'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
} 