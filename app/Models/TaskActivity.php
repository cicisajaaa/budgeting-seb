<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Tugas;
use App\Models\Employee;



class TaskActivity extends Model
{


    protected $table = 'aktivitas_tugas';



    protected $fillable = [

        'tugas_id',

        'karyawan_id',

        'tanggal',

        'aktivitas',

        'progres',

        'anggaran_aktivitas',

        'catatan'

    ];







    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas
    |--------------------------------------------------------------------------
    */


    public function tugas()
    {

        return $this->belongsTo(

            Tugas::class,

            'tugas_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Karyawan
    |--------------------------------------------------------------------------
    */


    public function karyawan()
    {

        return $this->belongsTo(

            Employee::class,

            'karyawan_id'

        );

    }



}