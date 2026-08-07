<?php

namespace App\Models;


use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


use App\Models\Karyawan;
use App\Models\ExpenseRequest;
use App\Models\LogAudit;
use App\Models\Proyek;



class User extends Authenticatable
{


    protected $table = 'users';



    protected $primaryKey = 'id';



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







    protected function casts(): array
    {


        return [


            'email_verified_at' => 'datetime',


            'password' => 'hashed',


        ];


    }









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

            ExpenseRequest::class,

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

            ExpenseRequest::class,

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









    /*
    |--------------------------------------------------------------------------
    | Relasi Anggota Project
    |--------------------------------------------------------------------------
    */


    public function projects()
    {

        return $this->belongsToMany(

            Proyek::class,

            'project_user',

            'user_id',

            'proyek_id'

        );

    }



}