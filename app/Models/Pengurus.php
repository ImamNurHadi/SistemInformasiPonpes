<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'user_id',
        'nama',
        'divisi',
        'sub_divisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 