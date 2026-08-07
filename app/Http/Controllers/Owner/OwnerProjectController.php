<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Proyek;



class OwnerProjectController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST PROJECT OWNER
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $projects = Proyek::with([

            'tugas',
            'tugas.aktivitasTugas',
            'tugas.karyawan'

        ])

        ->latest()

        ->get();







        $totalProject = $projects->count();







        $totalBudget = $projects->sum(function($project){

            return $project->total_anggaran ?? 0;

        });







        $projectBerjalan = $projects->filter(function($project){


            return $project->progres_keseluruhan < 100;


        })

        ->count();








        $projectSelesai = $projects->filter(function($project){


            return $project->progres_keseluruhan >= 100;


        })

        ->count();








        $averageProgress = $projects->avg(function($project){


            return $project->progres_keseluruhan ?? 0;


        });









        return view(

            'owner.projects.index',

            compact(

                'projects',

                'totalProject',

                'totalBudget',

                'projectBerjalan',

                'projectSelesai',

                'averageProgress'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL PROJECT OWNER
    |--------------------------------------------------------------------------
    */


    public function show(Proyek $project)
    {


        $project->load([


            'tugas',

            'tugas.aktivitasTugas',

            'tugas.karyawan',

            'tugas.divisi'


        ]);








        $totalTask = $project

            ->tugas

            ->count();








        $taskSelesai = $project

            ->tugas

            ->where(

                'status',

                'selesai'

            )

            ->count();









        $taskProgress = $project

            ->tugas

            ->where(

                'status',

                'sedang_dikerjakan'

            )

            ->count();









        $taskTodo = $project

            ->tugas

            ->where(

                'status',

                'belum_dikerjakan'

            )

            ->count();









        return view(

            'owner.projects.detail',

            compact(

                'project',

                'totalTask',

                'taskSelesai',

                'taskProgress',

                'taskTodo'

            )

        );


    }



}