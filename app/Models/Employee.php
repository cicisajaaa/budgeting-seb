<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Division;
use App\Models\User;
use App\Models\Tugas;



class Employee extends Model
{


    protected $table = 'karyawan';



    protected $fillable = [

        'pengguna_id',

        'nama_karyawan',

        'divisi_id',

    ];







    /*
    |--------------------------------------------------------------------------
    | Relasi Divisi
    |--------------------------------------------------------------------------
    */


    public function divisi()
    {

        return $this->belongsTo(

            Division::class,

            'divisi_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi User
    |--------------------------------------------------------------------------
    */


    public function pengguna()
    {

        return $this->belongsTo(

            User::class,

            'pengguna_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas Karyawan
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->hasMany(

            Tugas::class,

            'karyawan_id'

        );

    }



}