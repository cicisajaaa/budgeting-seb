<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PengajuanDana;
use App\Models\User;
use App\Models\RekeningBank;
use App\Models\Proyek;

class TransaksiDana extends Model
{


    protected $table = 'transaksi_dana';



    protected $fillable = [


        'pengajuan_dana_id',

        'disetujui_oleh',

        'rekening_bank_id',

        'jumlah',

        'tanggal',


    ];







    protected $casts = [


        'jumlah' => 'integer',


        'tanggal' => 'date',


    ];









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









    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Penyetuju
    |--------------------------------------------------------------------------
    */


    public function penyetuju()
    {

        return $this->belongsTo(

            User::class,

            'disetujui_oleh'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Rekening Bank
    |--------------------------------------------------------------------------
    */


    public function rekeningBank()
    {

        return $this->belongsTo(

            RekeningBank::class,

            'rekening_bank_id'

        );

    }


/*
|--------------------------------------------------------------------------
| Relasi Project melalui Pengajuan Dana
|--------------------------------------------------------------------------
*/


public function proyek()
{

    return $this->hasOneThrough(

        Proyek::class,

        PengajuanDana::class,

        'id',

        'id',

        'pengajuan_dana_id',

        'proyek_id'

    );

}

}