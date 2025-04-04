<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriTransfer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'santri_pengirim_id',
        'santri_penerima_id',
        'jumlah',
        'tipe_sumber',
        'tipe_tujuan',
        'keterangan',
        'tanggal'
    ];
    
    /**
     * Mendapatkan data santri pengirim
     */
    public function pengirim()
    {
        return $this->belongsTo(Santri::class, 'santri_pengirim_id');
    }
    
    /**
     * Mendapatkan data santri penerima
     */
    public function penerima()
    {
        return $this->belongsTo(Santri::class, 'santri_penerima_id');
    }
}
