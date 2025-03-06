<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Komplek extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'komplek';
    protected $guarded = ['id'];

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'komplek_id');
    }

    public function santri()
    {
        return $this->hasMany(Santri::class, 'komplek_id');
    }
}
