<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use App\Models\LogAudit;

class PengajuanDana extends Model
{


    protected $table = 'pengajuan_dana';


protected $fillable = [


    'pengguna_id',

    'proyek_id',

    'divisi_id',

    'judul',

    'keterangan',

    'bukti_pengajuan',

    'jumlah',

    'status',

    'disetujui_oleh',

    'disetujui_pada',

    'catatan_persetujuan'


];




    protected $casts = [


        'jumlah' => 'integer',


        'disetujui_pada' => 'datetime'


    ];









    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Pengguna Pemohon
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
    | Relasi dengan Proyek
    |--------------------------------------------------------------------------
    */


    public function proyek()
    {


        return $this->belongsTo(

            Proyek::class,

            'proyek_id'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Relasi dengan Divisi
    |--------------------------------------------------------------------------
    */


    public function divisi()
    {


        return $this->belongsTo(

            Divisi::class,

            'divisi_id'

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



public function auditLogs()
{

    return $this->hasMany(

        LogAudit::class,

        'pengajuan_dana_id'

    )

    ->with('pengguna')

    ->latest();

}
}