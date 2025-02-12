<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    use HasFactory;

    protected $table = 'pengajars';

    protected $fillable = [
        'nama',
        'nik',
        'tanggal_lahir',
        'telepon',
        'kelurahan_domisili',
        'kecamatan_domisili',
        'kota_domisili',
        'kelurahan_kk',
        'kecamatan_kk',
        'kota_kk',
        'pendidikan_terakhir',
        'asal_kampus',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
} 