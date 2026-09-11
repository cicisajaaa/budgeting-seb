<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaldoDivisi;

class Divisi extends Model
{


    protected $table = 'divisi';



    protected $fillable = [

        'nama_divisi',

        'deskripsi'

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi Karyawan
    |--------------------------------------------------------------------------
    */

    public function karyawan()
    {

        return $this->hasMany(

            Karyawan::class,

            'divisi_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Tugas
    |--------------------------------------------------------------------------
    */

    public function tugas()
    {

        return $this->hasMany(

            Tugas::class,

            'divisi_id'

        );

    }







    /*
    |--------------------------------------------------------------------------
    | Relasi Alokasi Project
    |--------------------------------------------------------------------------
    */

    public function alokasiProyekDivisi()
    {

        return $this->hasMany(

            AlokasiProyekDivisi::class,

            'divisi_id'

        );

    }


public function saldoDivisi()
{
    return $this->hasMany(
        SaldoDivisi::class,
        'divisi_id'
    );
}





}