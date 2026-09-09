<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tugas;
use App\Models\Karyawan;
use App\Models\Proyek;

class AktivitasTugas extends Model
{


    protected $table = 'aktivitas_tugas';



    protected $fillable = [

        'tugas_id',

        'karyawan_id',

        'tanggal',

        'aktivitas',

        'progres',

        'anggaran_aktivitas',

        'catatan',

    ];





    protected $casts = [

        'tanggal' => 'date',

        'progres' => 'integer',

        'anggaran_aktivitas' => 'integer',

    ];







    /*
    |--------------------------------------------------------------------------
    | RELASI TUGAS
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->belongsTo(

            Tugas::class,

            'tugas_id'

        );

    }





public function proyek()
{

    return $this->hasOneThrough(

        Proyek::class,

        Tugas::class,

        'id',
        'id',
        'tugas_id',
        'proyek_id'

    );

}


    /*
    |--------------------------------------------------------------------------
    | RELASI KARYAWAN
    |--------------------------------------------------------------------------
    */


    public function karyawan()
    {

        return $this->belongsTo(

            Karyawan::class,

            'karyawan_id'

        );

    }










    /*
    |--------------------------------------------------------------------------
    | SCOPE AKTIVITAS TERBARU
    |--------------------------------------------------------------------------
    */


    public function scopeTerbaru($query)
    {

        return $query

            ->orderByDesc('tanggal')

            ->orderByDesc('created_at');

    }










    /*
    |--------------------------------------------------------------------------
    | STATUS PROGRESS
    |--------------------------------------------------------------------------
    */


    public function getStatusProgressAttribute()
    {


        $progress = $this->progres ?? 0;



        if($progress >= 100)
        {

            return 'Selesai';

        }



        if($progress > 0)
        {

            return 'Berjalan';

        }



        return 'Belum Dimulai';


    }










    /*
    |--------------------------------------------------------------------------
    | FORMAT ANGGARAN
    |--------------------------------------------------------------------------
    */


    public function getFormatAnggaranAttribute()
    {

        return number_format(

            $this->anggaran_aktivitas ?? 0,

            0,

            ',',

            '.'

        );

    }




}