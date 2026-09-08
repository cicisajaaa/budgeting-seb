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
    | Relasi Pengajuan Dana
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
    | Relasi User Penyetuju
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
    | Relasi Rekening Bank
    |--------------------------------------------------------------------------
    */

    public function rekeningBank()
    {

        return $this->belongsTo(

            RekeningBank::class,

            'rekening_bank_id'

        );

    }



}