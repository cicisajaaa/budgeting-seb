<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Divisi extends Model
{


    protected $table = 'divisi';



    protected $fillable = [

        'nama_divisi'

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Alokasi Proyek
    |--------------------------------------------------------------------------
    */


    public function alokasiProyekDivisi()
    {

        return $this->hasMany(

            AlokasiProyekDivisi::class,

            'divisi_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Karyawan
    |--------------------------------------------------------------------------
    */


    public function karyawan()
    {

        return $this->hasMany(

            Karyawan::class,

            'divisi_id'

        );

    }



}