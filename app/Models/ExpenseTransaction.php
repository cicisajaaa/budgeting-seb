<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ExpenseTransaction extends Model
{


    protected $fillable = [


        'request_id',

        'approved_by',

        'bank_account_id',

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








    public function bank()
    {

        return $this->belongsTo(

            BankAccount::class,

            'bank_account_id'

        );

    }




}