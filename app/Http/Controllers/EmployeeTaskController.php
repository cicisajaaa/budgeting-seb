<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Support\Facades\Auth;



class EmployeeTaskController extends Controller
{


    public function show(Task $task)
    {


        $employee = Auth::user()->employee;



        // keamanan
        if($task->employee_id != $employee->id){

            abort(403);

        }




        $task->load([

            'project',

            'activities'

        ]);





        return view(

            'employee.tasks.show',

            compact('task')

        );


    }


}