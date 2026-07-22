<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SaldoDivisi extends Model
{


    protected $table = 'saldo_divisi';



    protected $fillable = [

        'proyek_id',

        'divisi_id',

        'saldo',

    ];





    protected $casts = [

        'saldo' => 'integer',

    ];







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Proyek
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



}