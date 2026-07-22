<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DistribusiSetoran extends Model
{


    protected $table = 'distribusi_setoran';



    protected $fillable = [

        'setoran_proyek_id',

        'divisi_id',

        'nominal_diterima',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Setoran Proyek
    |--------------------------------------------------------------------------
    */


    public function setoranProyek()
    {

        return $this->belongsTo(

            SetoranProyek::class,

            'setoran_proyek_id'

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