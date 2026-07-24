<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class ExpenseRequest extends Model
{
protected $table = 'pengajuan_dana';

protected $fillable = [

    'pengguna_id',

    'proyek_id',

    'divisi_id',

    'judul',

    'keterangan',

    'jumlah',

    'status',

    'disetujui_oleh',

    'disetujui_pada',

    'catatan_persetujuan'

];







    protected $casts = [


        'jumlah'=>'integer',


        'approved_at'=>'datetime'


    ];









    /*
    |--------------------------------------------------------------------------
    | Relasi User Pemohon
    |--------------------------------------------------------------------------
    */


    public function user()
    {


        return $this->belongsTo(

            User::class

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Relasi Project
    |--------------------------------------------------------------------------
    */


    public function proyek()
    {


        return $this->belongsTo(

            proyek::class

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Relasi Division
    |--------------------------------------------------------------------------
    */


    public function division()
    {


        return $this->belongsTo(

            Division::class

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Relasi Approver
    |--------------------------------------------------------------------------
    */


    public function approver()
    {


        return $this->belongsTo(

            User::class,

            'approved_by'

        );


    }




}