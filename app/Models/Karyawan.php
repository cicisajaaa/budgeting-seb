<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Karyawan extends Model
{


    protected $table = 'karyawan';



    protected $fillable = [

        'pengguna_id',

        'nama_karyawan',

        'divisi_id',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Divisi
    |--------------------------------------------------------------------------
    */


    public function divisi()
    {

        return $this->belongsTo(

            Divisi::class,

            'divisi_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Pengguna
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
    | Relasi dengan Tugas
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