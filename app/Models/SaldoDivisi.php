<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Proyek;
use App\Models\Divisi;


class SaldoDivisi extends Model
{


    protected $table = 'saldo_divisi';





    protected $fillable = [

        'proyek_id',

        'divisi_id',

    ];









    protected $casts = [

        'saldo' => 'integer',

    ];









    /*
    |--------------------------------------------------------------------------
    | RELASI DENGAN PROYEK
    |--------------------------------------------------------------------------
    */

    public function proyek()
    {

        return $this->belongsTo(

            Proyek::class,

            'proyek_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI DENGAN DIVISI
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
    | VALIDASI SALDO
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {

        static::saving(function($saldo){


            if($saldo->saldo < 0)
            {

                throw new \Exception(

                    'Saldo divisi tidak boleh negatif'

                );

            }


        });


    }


}