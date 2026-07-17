<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class ExpenseRequest extends Model
{


    protected $fillable = [


        'user_id',

        'project_id',

        'division_id',

        'judul',

        'keterangan',

        'jumlah',

        'status',

        'approved_by',

        'approved_at',

        'approval_note'


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


    public function project()
    {


        return $this->belongsTo(

            Project::class

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