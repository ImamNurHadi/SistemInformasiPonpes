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
        return $this->role && $this->role->name === 'Super Admin';
    }

    public function isSantri()
    {
        return $this->role && $this->role->name === 'Santri';
    }

    public function isPengurus()
    {
        return $this->role && $this->role->name === 'Pengurus';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
