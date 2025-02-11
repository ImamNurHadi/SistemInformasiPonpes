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
        'nuptk',
        'nik',
        'tanggal_lahir',
        'telepon',
        'alamat',
        'bidang_mata_pelajaran',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];
} 