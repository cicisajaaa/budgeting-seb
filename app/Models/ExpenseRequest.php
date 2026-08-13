<?php

namespace App\Models;


use App\Models\User;
use App\Models\Proyek;
use App\Models\Division;
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
        \App\Models\User::class,
        'pengguna_id',
        'id'
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
        Proyek::class,
        'proyek_id',
        'id'
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
        'disetujui_oleh'
    );
}




}