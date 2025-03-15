<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKoperasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_koperasi',
        'lokasi',
        'pengurus_id'
    ];

    /**
     * Get the pengurus that owns the koperasi.
     */
    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class);
    }
}
