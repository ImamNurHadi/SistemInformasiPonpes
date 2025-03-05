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
        'nama_kamar',
        'komplek_id'
    ];

    public function komplek()
    {
        return $this->belongsTo(Komplek::class, 'komplek_id');
    }

    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
} 