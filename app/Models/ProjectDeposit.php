<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectDeposit extends Model
{
protected $table = 'setoran_proyek';

    protected $fillable = [

        'proyek_id',

        'rekening_bank_id',

        'jumlah_setoran',

        'tanggal_setoran',

    ];


    public function proyek()
    {

        return $this->belongsTo(

            Proyek::class,
            
            'proyek_id'

        );
    }




public function bank()
{
    return $this->belongsTo(
        RekeningBank::class,
        'rekening_bank_id'
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