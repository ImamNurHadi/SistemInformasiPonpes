<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RuangKelas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ruang_kelas';
    protected $guarded = ['id'];

    public function santri()
    {
        return $this->hasMany(Santri::class, 'ruang_kelas_id');
    }
}
