<?php

namespace App\Http\Controllers;


use App\Models\Tugas;

use Illuminate\Support\Facades\Auth;



class EmployeeTaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DETAIL TASK KARYAWAN
    |--------------------------------------------------------------------------
    */


    public function show(Tugas $task)
    {


        $karyawan = Auth::user()->karyawan;





        /*
        |--------------------------------------------------------------------------
        | KEAMANAN AKSES
        |--------------------------------------------------------------------------
        */


        if(!$karyawan)
        {

            abort(403);

        }






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

            'proyek',

            'aktivitasTugas'

        ]);





        return view(

            'employee.tasks.show',

            compact('task')

        );


    }



}