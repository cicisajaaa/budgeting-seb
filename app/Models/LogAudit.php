<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LogAudit extends Model
{

    protected $table = 'log_audit';


    protected $fillable = [

        'pengguna_id',

        'pengajuan_dana_id',

        'aksi',

        'modul',

        'deskripsi',

        'alamat_ip'

    ];




    /*
    |--------------------------------------------------------------------------
    | Relasi User / Pengguna yang melakukan aktivitas
    |--------------------------------------------------------------------------
    */

    public function pengguna()
    {

        return $this->belongsTo(

            User::class,

            'pengguna_id'

        );

    }





    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Pengajuan Dana
    |--------------------------------------------------------------------------
    */

    public function pengajuanDana()
    {

        return $this->belongsTo(

            PengajuanDana::class,

            'pengajuan_dana_id'

        );

    }


}