<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Gedung extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'gedung';

    protected $fillable = [
        'nama_gedung'
    ];

    public function kamar()
    {
        return $this->hasMany(Kamar::class);
    }
}
