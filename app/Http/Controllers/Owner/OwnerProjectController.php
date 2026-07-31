<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Project;


class OwnerProjectController extends Controller
{


    public function index()
    {

        $projects = Project::with('tugas')
            ->latest()
            ->get();



        $totalProject = $projects->count();



        $totalBudget = $projects->sum(function($project){

            return $project->total_anggaran ?? 0;

        });



        $projectBerjalan = $projects->filter(function($project){

            return $project->progres_keseluruhan < 100;

        })->count();



        $projectSelesai = $projects->filter(function($project){

            return $project->progres_keseluruhan >= 100;

        })->count();



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





    public function show(Project $project)
    {


        $project->load([
            'tugas'
        ]);



        $totalTask = $project->tugas->count();



        $taskSelesai = $project->tugas
            ->where('status','selesai')
            ->count();



        $taskProgress = $project->tugas
            ->where('status','progress')
            ->count();



        $taskTodo = $project->tugas
            ->where('status','todo')
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