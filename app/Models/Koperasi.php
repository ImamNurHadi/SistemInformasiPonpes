<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'saldo_awal'
    ];

    protected $casts = [
        'saldo_awal' => 'decimal:2'
    ];
} 