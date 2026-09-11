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

    'saldo',

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
    | Relasi dengan Setoran Proyek
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
    | Relasi dengan Transaksi Dana
    |--------------------------------------------------------------------------
    */


    public function transaksiDana()
    {

        return $this->hasMany(

            TransaksiDana::class,

            'rekening_bank_id'

        );

    }


public function saldoAktual()
{
    $masuk = $this->mutasiKeuangan()
        ->where('jenis','masuk')
        ->sum('nominal');


    $keluar = $this->mutasiKeuangan()
        ->where('jenis','keluar')
        ->sum('nominal');


    return $this->saldo_awal
        + $masuk
        - $keluar;
}




public function mutasiKeuangan()
{
    return $this->hasMany(
        MutasiKeuangan::class,
        'rekening_bank_id'
    );
}

}