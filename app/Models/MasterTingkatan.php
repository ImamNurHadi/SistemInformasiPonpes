<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterTingkatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_tingkatan';
    protected $fillable = ['nama', 'keterangan'];

    public function santri()
    {
        return $this->hasMany(Santri::class, 'tingkatan_masuk');
    }

    public function waliSantri()
    {
        return $this->hasMany(WaliSantri::class, 'kelas');
    }
}
