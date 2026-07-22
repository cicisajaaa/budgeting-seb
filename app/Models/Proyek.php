<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Proyek extends Model
{


    protected $table = 'proyek';



    protected $fillable = [

        'nama_proyek',

        'tanggal_mulai',

        'tanggal_selesai',

        'pemilik_proyek',

        'total_anggaran',

        'progres_keseluruhan',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->hasMany(

            Tugas::class,

            'proyek_id'

        );

    }






    /*
    |--------------------------------------------------------------------------
    | Relasi Aktivitas Tugas
    |--------------------------------------------------------------------------
    */


    public function aktivitasTugas()
    {

        return $this->hasManyThrough(

            AktivitasTugas::class,

            Tugas::class,

            'proyek_id',

            'tugas_id'

        );

    }






    /*
    |--------------------------------------------------------------------------
    | Total Anggaran Aktivitas
    |--------------------------------------------------------------------------
    */


    public function getTotalAnggaranAktivitasAttribute()
    {

        return $this->aktivitasTugas()
            ->sum('anggaran_aktivitas');

    }







    /*
    |--------------------------------------------------------------------------
    | Sisa Anggaran Proyek
    |--------------------------------------------------------------------------
    */


    public function getSisaAnggaranAttribute()
    {

        return $this->total_anggaran -

               $this->total_anggaran_aktivitas;

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Setoran Proyek
    |--------------------------------------------------------------------------
    */


    public function setoranProyek()
    {

        return $this->hasMany(

            SetoranProyek::class,

            'proyek_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Alokasi Divisi
    |--------------------------------------------------------------------------
    */


    public function alokasiDivisi()
    {

        return $this->hasMany(

            AlokasiProyekDivisi::class,

            'proyek_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Saldo Divisi
    |--------------------------------------------------------------------------
    */


    public function saldoDivisi()
    {

        return $this->hasMany(

            SaldoDivisi::class,

            'proyek_id'

        );

    }








    /*
    |--------------------------------------------------------------------------
    | Progress Proyek Otomatis
    |--------------------------------------------------------------------------
    */


    public function getProgresKeseluruhanAttribute()
    {


        $totalTugas = $this->tugas()
            ->count();



        if($totalTugas == 0)
        {

            return 0;

        }




        return round(

            $this->tugas()
            ->avg('progres_persen')

        );


    }



}