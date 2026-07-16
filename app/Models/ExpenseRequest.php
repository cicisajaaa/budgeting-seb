<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseRequest extends Model
{

    protected $fillable = [

        'project_id',

        'division_id',

        'user_id',

        'judul',

        'keterangan',

        'jumlah',

        'status',

    ];



    protected $casts = [

        'jumlah' => 'integer',

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





    public function user()
    {

        return $this->belongsTo(
            User::class
        );

    }


}