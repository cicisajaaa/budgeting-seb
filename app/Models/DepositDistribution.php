<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DepositDistribution extends Model
{


    protected $table = 'distribusi_setoran';



    protected $fillable = [

        'setoran_proyek_id',

        'divisi_id',

        'nominal_diterima',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi Setoran Proyek
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
    | Relasi Divisi
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
    | Relasi Project melalui Setoran
    |--------------------------------------------------------------------------
    */

    public function proyek()
    {

        return $this->hasOneThrough(

            Proyek::class,

            SetoranProyek::class,

            'id',

            'id',

            'setoran_proyek_id',

            'proyek_id'

        );

    }


}