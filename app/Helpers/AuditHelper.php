<?php

namespace App\Helpers;

use App\Models\LogAudit;
use Illuminate\Support\Facades\Auth;


class AuditHelper
{

    public static function create(
        $aksi,
        $modul,
        $deskripsi,
        $pengajuanDanaId = null
    )
    {


        LogAudit::create([

            'pengguna_id'=>Auth::id(),

            'pengajuan_dana_id'=>$pengajuanDanaId,

            'aksi'=>$aksi,

            'modul'=>$modul,

            'deskripsi'=>$deskripsi,

            'alamat_ip'=>request()->ip()

        ]);


    }


}