<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSaldo extends Model
{
    use HasFactory;

    protected $table = 'histori_saldo';

    protected $fillable = [
        'santri_id',
        'jumlah',
        'keterangan',
        'tipe'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
} 