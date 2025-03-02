<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class HistoriSaldo extends Model
{
    use HasFactory;

    protected $table = 'histori_saldo';

    protected $fillable = [
        'santri_id',
        'jumlah',
        'keterangan',
        'tipe',
        'jenis_saldo', // utama, belanja, atau tabungan
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
} 