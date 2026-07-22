<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{


    protected $table = 'karyawan';



    protected $fillable = [

        'pengguna_id',

        'nama_karyawan',

        'divisi_id',

    ];





    public function divisi()
    {

        return $this->belongsTo(

            Division::class,

            'divisi_id'

        );

    }





    public function pengguna()
    {

        return $this->belongsTo(

            User::class,

            'pengguna_id'

        );

    }





    public function tugas()
    {

        return $this->hasMany(

            Task::class,

            'karyawan_id'

        );

    }


}