<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AlokasiProyekDivisi extends Model
{


    protected $table = 'alokasi_proyek_divisi';



    protected $fillable = [

        'proyek_id',

        'divisi_id',

        'persentase'

    ];






    /*
    |--------------------------------------------------------------------------
    | Relasi Proyek Indonesia
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
    | Relasi Proyek Lama (Compatibility)
    |--------------------------------------------------------------------------
    */


    public function project()
    {

        return $this->belongsTo(

            Proyek::class,

            'proyek_id'

        );

    }








    /*
    |--------------------------------------------------------------------------
    | Relasi Divisi Indonesia
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
    | Relasi Divisi Lama (Compatibility)
    |--------------------------------------------------------------------------
    */


    public function division()
    {

        return $this->belongsTo(

            Divisi::class,

            'divisi_id'

        );

    }



}