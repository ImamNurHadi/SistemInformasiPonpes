<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Menu extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'menus';

    protected $fillable = [
        'outlet_id',
        'nama',
        'harga',
        'foto',
        'stok',
        'deskripsi'
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