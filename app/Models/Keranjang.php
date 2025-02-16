<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Keranjang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'menu_id',
        'jumlah',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
} 