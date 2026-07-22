<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SetoranProyek extends Model
{


    protected $table = 'setoran_proyek';



    protected $fillable = [

        'proyek_id',

        'rekening_bank_id',

        'jumlah_setoran',

        'tanggal_setoran',

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
    | Relasi dengan Rekening Bank
    |--------------------------------------------------------------------------
    */


    public function rekeningBank()
    {

        return $this->belongsTo(

            RekeningBank::class,

            'rekening_bank_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Distribusi Dana
    |--------------------------------------------------------------------------
    */


    public function distribusiSetoran()
    {

        return $this->hasMany(

            DistribusiSetoran::class,

            'setoran_proyek_id'

        );

    }



}