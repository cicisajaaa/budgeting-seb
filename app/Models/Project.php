<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use App\Models\Tugas;
use App\Models\AktivitasTugas;
use App\Models\ProjectDeposit;
use App\Models\ProjectDivisionAllocation;
use App\Models\DivisionBalance;
use App\Models\User;



class Project extends Model
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
    | Relasi Tugas Project
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
    | Sisa Anggaran
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


    public function setoran()
    {

        return $this->hasMany(

            ProjectDeposit::class,

            'proyek_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Pembagian Dana Divisi
    |--------------------------------------------------------------------------
    */


    public function alokasiDivisi()
    {

        return $this->hasMany(

            ProjectDivisionAllocation::class,

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

            DivisionBalance::class,

            'proyek_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Hitung Progress Otomatis
    |--------------------------------------------------------------------------
    */


    public function getProgresKeseluruhanAttribute($value)
    {


        $jumlahTugas = $this->tugas()

            ->count();



        if($jumlahTugas == 0)
        {

            return 0;

        }





        return round(

            $this->tugas()

            ->avg('progres_persen')

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Anggota Project
    |--------------------------------------------------------------------------
    */


    public function users()
    {

        return $this->belongsToMany(

            User::class,

            'project_user',

            'proyek_id',

            'user_id'

        );

    }



}