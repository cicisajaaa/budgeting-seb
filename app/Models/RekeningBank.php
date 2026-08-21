<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use App\Models\SetoranProyek;
use App\Models\TransaksiDana;


class RekeningBank extends Model
{


    protected $table = 'rekening_bank';



    protected $fillable = [

        'nama_bank',

        'nomor_rekening',

        'nama_pemilik',

        'saldo',

        'status'

    ];





    protected $casts = [

        'saldo' => 'decimal:2',

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



}