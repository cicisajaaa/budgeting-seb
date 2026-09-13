<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\SetoranProyek;
use App\Models\TransaksiDana;
use App\Models\MutasiKeuangan;


class RekeningBank extends Model
{

    protected $table = 'rekening_bank';



    protected $fillable = [

        'nama_bank',

        'nomor_rekening',

        'nama_pemilik',

        'saldo_awal',

        'status'

    ];







    protected $casts = [

        'saldo' => 'decimal:2',

        'saldo_awal' => 'decimal:2',

        'status' => 'boolean'

    ];









    /*
    |--------------------------------------------------------------------------
    | RELASI SETORAN PROYEK
    |--------------------------------------------------------------------------
    */

    public function setoranProyek()
    {

        return $this->hasMany(

            SetoranProyek::class,

            'rekening_bank_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI TRANSAKSI DANA
    |--------------------------------------------------------------------------
    */

    public function transaksiDana()
    {

        return $this->hasMany(

            TransaksiDana::class,

            'rekening_bank_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | HITUNG SALDO AKTUAL
    |--------------------------------------------------------------------------
    */

    public function saldoAktual()
    {

        $masuk = $this->mutasiKeuangan()

            ->where(
                'jenis',
                'masuk'
            )

            ->sum('nominal');



        $keluar = $this->mutasiKeuangan()

            ->where(
                'jenis',
                'keluar'
            )

            ->sum('nominal');



        return (float) $this->saldo_awal
            + $masuk
            - $keluar;

    }









    /*
    |--------------------------------------------------------------------------
    | RELASI MUTASI KEUANGAN
    |--------------------------------------------------------------------------
    */

    public function mutasiKeuangan()
    {

        return $this->hasMany(

            MutasiKeuangan::class,

            'rekening_bank_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | VALIDASI SALDO
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {

        static::saving(function($rekening){


            if($rekening->saldo < 0)
            {

                throw new \Exception(

                    'Saldo rekening tidak boleh negatif'

                );

            }


        });


    }


}