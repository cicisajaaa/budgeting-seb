<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Karyawan;
use App\Models\PengajuanDana;
use App\Models\LogAudit;


class User extends Authenticatable
{


    use HasFactory, Notifiable;



    protected $fillable = [

        'name',

        'email',

        'password',

        'role'

    ];





    protected $hidden = [

        'password',

        'remember_token'

    ];





    /*
    |--------------------------------------------------------------------------
    | Pemeriksaan Role
    |--------------------------------------------------------------------------
    */


    public function isOwner(): bool
    {

        return $this->role === 'owner';

    }





    public function isAdmin(): bool
    {

        return $this->role === 'admin';

    }





    public function isKeuangan(): bool
    {

        return $this->role === 'keuangan';

    }





    public function isKaryawan(): bool
    {

        return $this->role === 'karyawan';

    }







    protected function casts(): array
    {

        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

        ];

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Karyawan
    |--------------------------------------------------------------------------
    */


    public function karyawan()
    {

        return $this->hasOne(

            Karyawan::class,

            'pengguna_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Pengajuan Dana
    |--------------------------------------------------------------------------
    */


    public function pengajuanDana()
    {

        return $this->hasMany(

            PengajuanDana::class,

            'pengguna_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Persetujuan Dana
    |--------------------------------------------------------------------------
    */


    public function persetujuanDana()
    {

        return $this->hasMany(

            PengajuanDana::class,

            'disetujui_oleh'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Log Audit
    |--------------------------------------------------------------------------
    */


    public function logAudit()
    {

        return $this->hasMany(

            LogAudit::class,

            'pengguna_id'

        );

    }


}