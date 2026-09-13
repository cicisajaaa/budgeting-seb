<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PengajuanDana;
use App\Models\User;
use App\Models\RekeningBank;


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
    | RELASI PENGAJUAN DANA
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
    | RELASI USER PENYETUJU
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
    | RELASI REKENING BANK
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
    | VALIDASI DATA TRANSAKSI
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI WAJIB MEMILIKI PENGAJUAN
        |--------------------------------------------------------------------------
        */

        static::creating(function($transaksi){

            if(!$transaksi->pengajuan_dana_id)
            {

                throw new \Exception(

                    'Transaksi harus memiliki pengajuan dana'

                );

            }

        });





        /*
        |--------------------------------------------------------------------------
        | NOMINAL TIDAK BOLEH NEGATIF
        |--------------------------------------------------------------------------
        */

        static::saving(function($transaksi){


            if($transaksi->jumlah < 0)
            {

                throw new \Exception(

                    'Jumlah transaksi tidak boleh negatif'

                );

            }


        });


    }


}