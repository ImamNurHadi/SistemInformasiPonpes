<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKoperasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_koperasi',
        'lokasi',
        'pengurus_id',
        'username',
        'password_hash',
        'saldo_belanja',
        'user_id'
    ];

    /**
     * Get the pengurus that owns the koperasi.
     */
    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class);
    }
    
    /**
     * Get the user associated with the koperasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if koperasi has enough saldo belanja.
     */
    public function hasSufficientSaldo($amount)
    {
        return $this->saldo_belanja >= $amount;
    }
    
    /**
     * Add saldo belanja.
     */
    public function addSaldoBelanja($amount)
    {
        $this->saldo_belanja += $amount;
        $this->save();
        
        return $this;
    }
    
    /**
     * Reduce saldo belanja.
     */
    public function reduceSaldoBelanja($amount)
    {
        if (!$this->hasSufficientSaldo($amount)) {
            throw new \Exception('Saldo belanja tidak mencukupi.');
        }
        
        $this->saldo_belanja -= $amount;
        $this->save();
        
        return $this;
    }
}
