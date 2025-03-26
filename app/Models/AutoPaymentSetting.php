<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoPaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_pembayaran',
        'jumlah',
        'tanggal_eksekusi',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_eksekusi' => 'integer',
        'aktif' => 'boolean',
    ];
}
