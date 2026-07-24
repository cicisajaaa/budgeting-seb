<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionBalance extends Model
{

    protected $table = 'saldo_divisi';


    protected $fillable = [

        'proyek_id',

        'divisi_id',

        'saldo',

    ];



    protected $casts = [

        'saldo' => 'integer',

    ];




    public function proyek()
    {

        return $this->belongsTo(
            Proyek::class,
            'proyek_id'
        );

    }




    public function division()
    {

        return $this->belongsTo(
            Division::class,
            'divisi_id'
        );

    }

}