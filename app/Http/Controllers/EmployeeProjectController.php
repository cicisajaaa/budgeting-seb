<?php

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Support\Facades\Auth;


class EmployeeProjectController extends Controller
{


    public function index()
    {


        $employee = Auth::user()->employee;



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


                $query
                ->where(
                    'employee_id',
                    $employee->id
                )

                ->with([
                    'activities'
                ]);


            }


        ])

        ->latest()

        ->get();





        return view(

            'employee.projects.index',

            compact('projects')

        );


    }


}