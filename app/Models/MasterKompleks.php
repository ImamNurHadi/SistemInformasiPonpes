<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterKompleks extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_kompleks';

    protected $fillable = [
        'nama_kompleks',
    ];

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'kompleks_id');
    }
} 