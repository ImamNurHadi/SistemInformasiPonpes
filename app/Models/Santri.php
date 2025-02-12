<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Santri extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'santri';

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'anak_ke',
        'jumlah_saudara_kandung',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'nomor_induk_santri',
        'tingkatan_id',
        'kompleks_id',
        'kamar_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tingkatan()
    {
        return $this->belongsTo(MasterTingkatan::class, 'tingkatan_masuk');
    }

    public function tingkatanSaatIni()
    {
        return $this->belongsTo(MasterTingkatan::class, 'tingkatan_id');
    }

    public function waliSantri()
    {
        return $this->hasOne(WaliSantri::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function kompleks()
    {
        return $this->belongsTo(MasterKompleks::class, 'kompleks_id');
    }

    public function kelasWali()
    {
        return $this->belongsTo(MasterTingkatan::class, 'kelas_wali');
    }
} 