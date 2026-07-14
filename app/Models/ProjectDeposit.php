<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectDeposit extends Model
{

    protected $fillable = [

        'project_id',
        'jumlah_setoran',
        'tanggal_setoran',

    ];



    public function project()
    {
        return $this->belongsTo(Project::class);
    }



    public function distributions()
    {
        return $this->hasMany(
            DepositDistribution::class,
            'deposit_id'
        );
    }

}