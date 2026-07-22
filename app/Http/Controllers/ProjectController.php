<?php

namespace App\Http\Controllers;

use App\Models\Proyek;

class ProjectController extends Controller
{
    public function myProject()
    {
        $karyawan = auth()->user()->employee;


        $proyek = Proyek::whereHas(
            'tasks',
            function ($query) use ($karyawan) {

                $query->where(
                    'employee_id',
                    $karyawan->id
                );

            }
        )
        ->with([

            'tasks' => function ($query) use ($karyawan) {

                $query->where(
                    'employee_id',
                    $karyawan->id
                );

            },

            'tasks.activities'

        ])
        ->latest()
        ->get();



        return view(
            'project.my-project',
            compact('proyek')
        );
    }
}