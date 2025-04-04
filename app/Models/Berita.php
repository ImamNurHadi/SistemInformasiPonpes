<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    
    protected $fillable = [
        'judul',
        'tanggal',
        'image',
        'ringkasan',
        'konten',
        'slug'
    ];
    
    // Method untuk menghasilkan slug otomatis dari judul berita
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
        
        static::updating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }
    
    // Method untuk get route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }
} 