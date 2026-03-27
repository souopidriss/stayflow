<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'actif'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'actif' => 'boolean'
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isReceptionniste(): bool
    {
        return $this->role === 'receptionniste';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function employe()
    {
        return $this->hasOne(Employe::class);
    }
}