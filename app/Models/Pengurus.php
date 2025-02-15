<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
} 