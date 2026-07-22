<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class BankAccount extends Model
{

protected $table = 'rekening_bank';
    protected $fillable = [

        'nama_bank',

        'nomor_rekening',

        'nama_pemilik',

        'saldo',

        'status'

    ];




    protected $casts = [

        'saldo' => 'decimal:2',

        'status' => 'boolean'

    ];



    public function deposits()
    {

        return $this->hasMany(
            ProjectDeposit::class
        );

    }


}