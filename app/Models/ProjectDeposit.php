<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectDeposit extends Model
{
protected $table = 'setoran_proyek';

    protected $fillable = [

        'project_id',

        'bank_account_id',

        'jumlah_setoran',

        'tanggal_setoran',

    ];




    public function proyek()
    {

        return $this->belongsTo(
            Proyek::class
        );

    }






    public function bank()
    {

        return $this->belongsTo(
            BankAccount::class,
            'bank_account_id'
        );

    }






    public function distributions()
    {

        return $this->hasMany(
            DepositDistribution::class,
            'deposit_id'
        );

    }



}