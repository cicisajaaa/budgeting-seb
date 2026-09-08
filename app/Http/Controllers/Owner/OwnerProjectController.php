<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Proyek;



class OwnerProjectController extends Controller
{


    public function index()
    {


        $projects = Proyek::with([

            'perusahaan',

            'tugas',

            'tugas.aktivitasTugas',

            'tugas.karyawan',

            'tugas.divisi'


        ])

        ->latest()

        ->get();





        $totalProject = $projects->count();





        $totalBudget = $projects->sum(function($project){

            return $project->total_anggaran ?? 0;

        });





        $projectBerjalan = $projects

            ->filter(function($project){

                return $project->progres_keseluruhan > 0 
                &&
                $project->progres_keseluruhan < 100;

            })

            ->count();





        $projectSelesai = $projects

            ->filter(function($project){

                return $project->progres_keseluruhan >= 100;

            })

            ->count();





        $averageProgress = round(

            $projects->avg(
                'progres_keseluruhan'
            ) ?? 0

        );





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








    public function show(Proyek $project)
    {


        $project->load([


            'perusahaan',



            'tugas' => function($query){


                $query->orderByRaw("

                    CASE

                        WHEN status = 'belum_dikerjakan'
                        THEN 1


                        WHEN status IN (
                            'sedang_dikerjakan',
                            'berjalan',
                            'progress'
                        )
                        THEN 2


                        WHEN status IN (
                            'selesai',
                            'done'
                        )
                        THEN 3


                        ELSE 4


                    END

                ");


            },



            'tugas.aktivitasTugas' => function($query){

                $query->latest('tanggal');

            },


            'tugas.karyawan',


            'tugas.divisi'


        ]);







        $totalTask = $project->tugas->count();






        $taskSelesai = $project->tugas

            ->whereIn(

                'status',

                [
                    'selesai',
                    'done'
                ]

            )

            ->count();








        $taskProgress = $project->tugas

            ->whereIn(

                'status',

                [
                    'sedang_dikerjakan',
                    'berjalan',
                    'progress'
                ]

            )

            ->count();








        $taskTodo = $project->tugas

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