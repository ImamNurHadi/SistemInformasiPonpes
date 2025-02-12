<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSantri extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'wali_santri';
    
    protected $fillable = [
        'santri_id',
        'nama_wali',
        'kelas',
        'asal_kota',
        'nama_ayah',
        'alamat_kk_ayah',
        'alamat_domisili_ayah',
        'no_identitas_ayah',
        'no_hp_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'alamat_kk_ibu',
        'alamat_domisili_ibu',
        'no_identitas_ibu',
        'no_hp_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function tingkatan()
    {
        return $this->belongsTo(MasterTingkatan::class, 'kelas');
    }

    // Accessor untuk mendapatkan alamat yang ditampilkan (domisili)
    public function getAlamatAyahAttribute()
    {
        return $this->alamat_domisili_ayah;
    }

    public function getAlamatIbuAttribute()
    {
        return $this->alamat_domisili_ibu;
    }
}
