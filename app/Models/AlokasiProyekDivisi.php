<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AlokasiProyekDivisi extends Model
{


    protected $table = 'alokasi_proyek_divisi';



    protected $fillable = [

        'proyek_id',

        'divisi_id',

        'persentase',

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