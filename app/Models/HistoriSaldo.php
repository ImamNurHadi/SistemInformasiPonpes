<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class HistoriSaldo extends Model
{
    use HasFactory;

    protected $table = 'histori_saldo';

    protected $fillable = [
        'santri_id',
        'jumlah',
        'keterangan',
        'tipe',
        'jenis_saldo', // utama, belanja, atau tabungan
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Get the created_at attribute in Asia/Jakarta timezone.
     *
     * @param  string  $value
     * @return \Illuminate\Support\Carbon
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }

    /**
     * Get the updated_at attribute in Asia/Jakarta timezone.
     *
     * @param  string  $value
     * @return \Illuminate\Support\Carbon
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    }
} 