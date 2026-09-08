<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;



class EmployeeTaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DETAIL TASK EMPLOYEE
    |--------------------------------------------------------------------------
    */


    public function show(Tugas $task)
    {


        $karyawan = Auth::user()->karyawan;



        if(!$karyawan)
        {

            abort(403);

        }








        /*
        |--------------------------------------------------------------------------
        | CEK PEMILIK TASK
        |--------------------------------------------------------------------------
        */


        if($task->karyawan_id != $karyawan->id)
        {

            abort(403);

        }








        /*
        |--------------------------------------------------------------------------
        | LOAD DATA TASK
        |--------------------------------------------------------------------------
        */
$task->load([


    'proyek.perusahaan',


    'divisi',


    'karyawan',

'aktivitasTugas'=>function($query){

    $query->with('karyawan');

}


]);


$activities = $task->aktivitasTugas;




return view(

    'employee.tasks.show',

    compact(

        'task',

        'activities'

    )

);

    }


}