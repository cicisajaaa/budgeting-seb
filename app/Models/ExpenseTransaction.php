<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseTransaction extends Model
{


    protected $fillable = [

        'request_id',

        'approved_by',

        'jumlah',

        'tanggal',

    ];





    protected $casts = [

        'jumlah' => 'integer',

        'tanggal' => 'date',

    ];







    public function request()
    {

        return $this->belongsTo(
            ExpenseRequest::class,
            'request_id'
        );

    }







    public function approver()
    {

        return $this->belongsTo(
            User::class,
            'approved_by'
        );

    }



}