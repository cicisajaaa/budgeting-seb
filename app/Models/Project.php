<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskActivity;

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
| Relasi Aktivitas Task
|--------------------------------------------------------------------------
*/

public function taskActivities()
{
    return $this->hasManyThrough(
        TaskActivity::class,
        Task::class
    );
}

public function getTotalBudgetActivityAttribute()
{
    return $this->taskActivities()
        ->sum('budget_activity');
}



public function getSisaBudgetAttribute()
{
    return $this->total_budget -
           $this->total_budget_activity;
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
    | Progress Project Otomatis
    |--------------------------------------------------------------------------
    |
    | Menghitung progress berdasarkan rata-rata
    | progress seluruh task dalam project.
    |
    | Contoh:
    |
    | Task 1 = 100%
    | Task 2 = 50%
    | Task 3 = 0%
    |
    | Progress Project = 50%
    |
    |--------------------------------------------------------------------------
    */


    public function getProgressKeseluruhanAttribute()
{

    $totalTask = $this->tasks()
        ->count();


    if($totalTask == 0)
    {
        return 0;
    }


    return round(
        $this->tasks()
        ->avg('progress_persen')
    );

}

}