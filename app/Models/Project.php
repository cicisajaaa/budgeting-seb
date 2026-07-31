<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\TaskActivity;
use App\Models\ProjectDeposit;
use App\Models\ProjectDivisionAllocation;
use App\Models\DivisionBalance;

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
    | Relasi Tugas
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->hasMany(

            Task::class,

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

            TaskActivity::class,

            Task::class,

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
    | Hitung Progres Otomatis
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



}