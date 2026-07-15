<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{


    protected $fillable = [

        'nama_project',

        'start_date',

        'end_date',

        'project_owner',

        'total_budget',

        'progress_keseluruhan',

    ];





    /*
    |--------------------------------------------------------------------------
    | Relasi Task
    |--------------------------------------------------------------------------
    */


    public function tasks()
    {

        return $this->hasMany(
            Task::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Relasi Pembayaran Client
    |--------------------------------------------------------------------------
    */


    public function deposits()
    {

        return $this->hasMany(
            ProjectDeposit::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Relasi Pembagian Dana Divisi
    |--------------------------------------------------------------------------
    */


    public function allocations()
    {

        return $this->hasMany(
            ProjectDivisionAllocation::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Relasi Saldo Divisi
    |--------------------------------------------------------------------------
    */


    public function balances()
    {

        return $this->hasMany(
            DivisionBalance::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Progress Otomatis Project
    |--------------------------------------------------------------------------
    */


    public function getProgressKeseluruhanAttribute()
    {


        if($this->tasks->count()==0)
        {

            return 0;

        }



        return round(
            $this->tasks
            ->avg('progress_persen')
        );


    }



}