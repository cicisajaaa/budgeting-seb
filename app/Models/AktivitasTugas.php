<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AktivitasTugas extends Model
{


    protected $table = 'aktivitas_tugas';



    protected $fillable = [

        'tugas_id',

        'karyawan_id',

        'tanggal',

        'aktivitas',

        'progres',

        'anggaran_aktivitas',

        'catatan',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Tugas
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->belongsTo(

            Tugas::class,

            'tugas_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Karyawan
    |--------------------------------------------------------------------------
    */


    public function karyawan()
    {

        return $this->belongsTo(

            Karyawan::class,

            'karyawan_id'

        );

    }



}