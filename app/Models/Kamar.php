<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kamar extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kamar';

    protected $fillable = [
        'gedung_id',
        'nama_kamar',
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function santri()
    {
        return $this->hasMany(Santri::class, 'kamar_id');
    }
} 