<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'telepon',
        'kelurahan_domisili',
        'kecamatan_domisili',
        'kota_domisili',
        'kelurahan_kk',
        'kecamatan_kk',
        'kota_kk',
        'divisi_id',
        'sub_divisi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 