<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class LogAudit extends Model
{


    protected $table = 'log_audit';



    protected $fillable = [

        'pengguna_id',

        'aksi',

        'modul',

        'deskripsi',

        'alamat_ip'

    ];







    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Pengguna
    |--------------------------------------------------------------------------
    */


    public function pengguna()
    {

        return $this->belongsTo(

            User::class,

            'pengguna_id'

        );

    }



}