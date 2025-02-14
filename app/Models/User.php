<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Santri;
use App\Models\Pengurus;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function santri()
    {
        return $this->hasOne(Santri::class);
    }

    public function pengurus()
    {
        return $this->hasOne(Pengurus::class);
    }

    public function isAdmin()
    {
        return $this->role_id === '9e3407bd-3b45-40d4-99f0-7fb46f3a8d63';
    }

    public function isSantri()
    {
        return $this->role_id === '9e34da35-0cad-473d-ab84-ebaaed8e47c0';
    }

    public function isPengurus()
    {
        return $this->role_id === '9e34da34-c5c0-4962-8e76-c557e9add2c6';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
