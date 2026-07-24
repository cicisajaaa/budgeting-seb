<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectDivisionAllocation extends Model
{
protected $table = 'alokasi_proyek_divisi';

    protected $fillable = [

        'project_id',

        'division_id',

        'persentase',

    ];



    public function proyek()
    {

        return $this->belongsTo(
            Proyek::class
        );

    }




    public function division()
    {

        return $this->belongsTo(
            Division::class
        );

    }


}