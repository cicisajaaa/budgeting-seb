<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Division extends Model
{
protected $table = 'divisi';
    protected $fillable = [

        'nama_divisi'

    ];



    public function allocations()
    {

        return $this->hasMany(
            ProjectDivisionAllocation::class
        );

    }


}