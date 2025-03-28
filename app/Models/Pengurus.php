<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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
        'jabatan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Generate QR Code for Pengurus
     */
    public function generateQrCode()
    {
        $data = [
            'type' => 'pengurus_qr',
            'id' => $this->id,
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
            'divisi' => $this->divisi ? $this->divisi->nama : '-'
        ];
        
        $qrCode = QrCode::size(200)->generate(json_encode($data));
        return $qrCode;
    }
} 