<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Menu extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'gambar'
    ];

    public function outlet()
    {
        return $this->belongsTo(User::class, 'outlet_id');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
} 