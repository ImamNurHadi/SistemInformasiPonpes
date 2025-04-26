<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        'keuntungan'
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
    public function hasSufficientSaldoBelanja($amount)
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
        if (!$this->hasSufficientSaldoBelanja($amount)) {
            throw new \Exception('Saldo belanja tidak mencukupi.');
        }
        
        $this->saldo_belanja -= $amount;
        $this->save();
        
        return $this;
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'data_koperasi_id');
    }

    /**
     * Hitung keuntungan dari stok barang
     */
    public function hitungKeuntungan()
    {
        $totalKeuntungan = 0;
        $keuntunganPerUnit = 750; // Keuntungan tetap per unit

        foreach ($this->supplies as $supply) {
            $totalKeuntungan += $supply->stok * $keuntunganPerUnit;
        }

        $this->keuntungan = $totalKeuntungan;
        $this->save();
    }

    /**
     * Cairkan keuntungan ke saldo belanja
     */
    public function cairkanKeuntungan()
    {
        if ($this->keuntungan <= 0) {
            throw new \Exception('Tidak ada keuntungan yang dapat dicairkan.');
        }

        $this->saldo_belanja += $this->keuntungan;
        $this->keuntungan = 0;
        $this->save();

        return $this;
    }

    /**
     * Update keuntungan setiap kali ada perubahan stok
     */
    public function updateKeuntungan()
    {
        $this->hitungKeuntungan();
    }
    
    /**
     * Generate QR Code for Koperasi
     */
    public function generateQrCode()
    {
        $data = [
            'type' => 'koperasi_qr',
            'id' => $this->id,
            'nama' => $this->nama_koperasi,
            'lokasi' => $this->lokasi
        ];
        
        $qrCode = QrCode::format('svg')->size(200)->generate(json_encode($data));
        return $qrCode;
    }
}
