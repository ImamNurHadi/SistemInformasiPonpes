<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Supplier extends Model
{
    use HasFactory;
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'telepon',
        'email',
        'username',
        'password_hash',
        'saldo_belanja',
        'user_id'
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    
    /**
     * Get the user associated with the supplier.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if supplier has enough saldo belanja.
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
    
    /**
     * Generate QR Code for Supplier
     */
    public function generateQrCode()
    {
        $data = [
            'type' => 'supplier_qr',
            'id' => $this->id,
            'nama' => $this->nama_supplier,
            'email' => $this->email
        ];
        
        $qrCode = QrCode::size(200)->generate(json_encode($data));
        return $qrCode;
    }
}
