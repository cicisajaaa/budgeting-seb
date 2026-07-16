<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionBalance extends Model
{


    protected $fillable = [

        'project_id',

        'division_id',

        'saldo',

    ];





    protected $casts = [

        'saldo' => 'integer',

    ];







    public function project()
    {

        return $this->belongsTo(
            Project::class
        );

    }







    public function division()
    {

        return $this->belongsTo(
            Division::class
        );

    }



}