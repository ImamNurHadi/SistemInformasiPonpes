<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'sub_divisi'
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
} 