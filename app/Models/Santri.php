<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\MasterTingkatan;

class Santri extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'santri';

    protected $fillable = [
        'id',
        'user_id',
        'tingkatan_id',
        'komplek_id',
        'kamar_id',
        'nama',
        'nis',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'nama_wali',
        'no_hp_wali',
        'saldo_utama',
        'saldo_belanja',
        'saldo_tabungan',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'nama_ayah',
        'nama_ibu',
        'foto',
        'tingkatan_masuk',
        'anak_ke',
        'jumlah_saudara_kandung',
        'asal_kota',
        'alamat_kk_ayah',
        'alamat_domisili_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'alamat_kk_ibu',
        'alamat_domisili_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'kelas_id',
    ];

    protected $casts = [
        'id' => 'string',
        'tanggal_lahir' => 'date',
        'saldo_utama' => 'decimal:2',
        'saldo_belanja' => 'decimal:2',
        'saldo_tabungan' => 'decimal:2'
    ];

    public function tingkatan()
    {
        return $this->belongsTo(MasterTingkatan::class, 'tingkatan_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komplek()
    {
        return $this->belongsTo(Komplek::class, 'komplek_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function generateQrCode()
    {
        $qrCode = QrCode::size(100)->generate($this->id);
        return $qrCode;
    }

    public function saldo()
    {
        return $this->hasOne(Saldo::class);
    }

    public function transaksiKoperasi()
    {
        return $this->hasMany(TransaksiKoperasi::class);
    }
} 