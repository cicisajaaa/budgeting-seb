<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


use App\Models\User;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\LogAudit;
use App\Models\TransaksiDana;

class PengajuanDana extends Model
{


    protected $table = 'pengajuan_dana';


protected $fillable = [


    'nomor_pengajuan',

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


/*
|--------------------------------------------------------------------------
| Relasi Transaksi Dana
|--------------------------------------------------------------------------
*/
public function transaksiDana()
{

    return $this->hasMany(

        TransaksiDana::class,

        'pengajuan_dana_id'

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



protected static function boot()
{
    parent::boot();


    static::creating(function($pengajuan){

        $tanggal = now()->format('Ym');


        $last = self::where(
            'nomor_pengajuan',
            'like',
            'REQ-'.$tanggal.'%'
        )
        ->latest('id')
        ->first();


        if($last){

            $number = intval(
                substr(
                    $last->nomor_pengajuan,
                    -4
                )
            ) + 1;

        } else {

            $number = 1;

        }


        $pengajuan->nomor_pengajuan =
            'REQ-' .
            $tanggal .
            '-' .
            str_pad(
                $number,
                4,
                '0',
                STR_PAD_LEFT
            );

    });
}



}