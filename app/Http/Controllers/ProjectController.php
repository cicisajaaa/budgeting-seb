<?php

namespace App\Http\Controllers;


use App\Models\Project;


class ProjectController extends Controller
{


    public function myProject()
    {


        $employee = auth()->user()->employee;



        $projects = Project::whereHas(
            'tasks',
            function($query) use($employee){

                $query->where(
                    'employee_id',
                    $employee->id
                );

            }
        )
        ->with([

            'tasks' => function($query) use($employee){

                $query->where(
                    'employee_id',
                    $employee->id
                );

            },

            'tasks.activities'

        ])
        ->latest()
        ->get();





        return view(
            'project.my-project',
            compact('projects')
        );


    }


}