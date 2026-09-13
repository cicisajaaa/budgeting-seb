<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\RekeningBank;
use App\Models\User;


class MutasiKeuangan extends Model
{


    protected $table = 'mutasi_keuangan';




    protected $fillable = [

        'rekening_bank_id',

        'jenis',

        'nominal',

        'referensi_type',

        'referensi_id',

        'tanggal',

        'keterangan',

        'created_by',

    ];





    protected $casts = [

        'nominal' => 'decimal:2',

        'tanggal' => 'date',

    ];









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
    | RELASI USER PEMBUAT
    |--------------------------------------------------------------------------
    */

    public function user()
    {

        return $this->belongsTo(

            User::class,

            'created_by'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | VALIDASI MUTASI
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {


        static::saving(function($mutasi){



            if($mutasi->nominal < 0)
            {

                throw new \Exception(

                    'Nominal mutasi tidak boleh negatif'

                );

            }





            if(
                !in_array(
                    $mutasi->jenis,
                    [
                        'masuk',
                        'keluar'
                    ]
                )
            )
            {

                throw new \Exception(

                    'Jenis mutasi tidak valid'

                );

            }



        });



    }



}