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
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'nama_ayah',
        'nama_ibu',
        'no_hp',
        'foto',
        'tingkatan_id',
        'tingkatan_masuk',
        'gedung_id',
        'kamar_id',
        'anak_ke',
        'jumlah_saudara_kandung'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'saldo' => 'decimal:2'
    ];

    public function tingkatan()
    {
        return $this->belongsTo(MasterTingkatan::class, 'tingkatan_id');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function historiSaldo()
    {
        return $this->hasMany(HistoriSaldo::class);
    }

    public function waliSantri()
    {
        return $this->hasOne(WaliSantri::class);
    }

    public function kelasWali()
    {
        return $this->belongsTo(MasterTingkatan::class, 'kelas_wali');
    }
} 