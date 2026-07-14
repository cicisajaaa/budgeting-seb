<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable([
    'name',
    'email',
    'password',
    'role'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    /**
     * Role checking
     */

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }


    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }



    /**
     * Get casts
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}