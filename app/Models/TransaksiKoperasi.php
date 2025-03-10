<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiKoperasi extends Model
{
    use HasFactory;

    protected $table = 'transaksi_koperasi';

    protected $fillable = [
        'santri_id',
        'jenis',
        'nama_barang',
        'harga_satuan',
        'kuantitas',
        'total'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2',
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