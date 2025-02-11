<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'user_id',
        'id_emoney',
        'nis',
        'nama',
        'asrama',
        'kamar',
        'tingkatan_masuk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 