<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Metode fleksibel untuk memeriksa peran pengguna
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    // Cek apakah pengguna memiliki peran tertentu dengan ID langsung
    public function hasRoleId($roleId)
    {
        return $this->role_id === $roleId;
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function isSantri()
    {
        return $this->role && $this->role->name === 'Santri';
    }

    public function isOutlet()
    {
        return $this->isKoperasi();
    }

    public function isPengurus()
    {
        return $this->role && $this->role->name === 'Pengurus';
    }

    public function isOperator()
    {
        return $this->role && $this->role->name === 'Operator';
    }
    
    public function isKoperasi()
    {
        return $this->role && $this->role->name === 'Koperasi';
    }
    
    public function isSupplier()
    {
        return $this->role && $this->role->name === 'Supplier';
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function santri()
    {
        return $this->hasOne(Santri::class);
    }
    
    public function dataKoperasi()
    {
        return $this->hasOne(DataKoperasi::class);
    }
    
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }
}
