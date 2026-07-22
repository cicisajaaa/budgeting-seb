<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DepositDistribution extends Model
{
protected $table = 'distribusi_setoran';
    protected $fillable = [

        'deposit_id',
        'division_id',
        'nominal_diterima',

    ];



    public function deposit()
    {

        return $this->belongsTo(
            ProjectDeposit::class,
            'deposit_id'
        );

    }



    public function division()
    {

        return $this->belongsTo(
            Division::class
        );

    }

}