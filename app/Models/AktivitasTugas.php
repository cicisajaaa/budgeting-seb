<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tugas;
use App\Models\Karyawan;


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



    protected $casts = [

        'tanggal' => 'date',

        'progres' => 'integer',

        'anggaran_aktivitas' => 'integer',

    ];

    /*

    |--------------------------------------------------------------------------

    | AUTO UPDATE PROGRESS TUGAS

    |--------------------------------------------------------------------------

    */

    protected static function booted()

    {

        static::saved(function($aktivitas){

            if($aktivitas->tugas)

            {

                $aktivitas->tugas->updateProgress();

            }

        });

    }








    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas
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
    | Relasi Karyawan
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