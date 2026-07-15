<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;



class ProjectController extends Controller
{


    public function index()
    {

        $projects = Project::latest()->get();


        return view(
            'admin.projects.index',
            compact('projects')
        );

    }





    public function create()
    {

        return view(
            'admin.projects.create'
        );

    }





    public function store(Request $request)
    {


        $request->validate([

            'nama_project'=>'required',

            'project_owner'=>'required',

            'total_budget'=>'required|numeric',

            'start_date'=>'required|date',

            'end_date'=>'required|date',

        ]);




        Project::create([


            'nama_project'=>$request->nama_project,


            'project_owner'=>$request->project_owner,


            'total_budget'=>$request->total_budget,


            'start_date'=>$request->start_date,


            'end_date'=>$request->end_date,


            'progress_keseluruhan'=>0,


        ]);




        return redirect()

            ->route('admin.projects.index')

            ->with(
                'success',
                'Project berhasil ditambahkan'
            );


    }






    public function edit(Project $project)
    {


        return view(
            'admin.projects.edit',
            compact('project')
        );


    }






    public function update(
        Request $request,
        Project $project
    )
    {


        $request->validate([

            'nama_project'=>'required',

            'project_owner'=>'required',

            'total_budget'=>'required|numeric',

            'start_date'=>'required|date',

            'end_date'=>'required|date',

        ]);




        $project->update([


            'nama_project'=>$request->nama_project,


            'project_owner'=>$request->project_owner,


            'total_budget'=>$request->total_budget,


            'start_date'=>$request->start_date,


            'end_date'=>$request->end_date,


        ]);



        return redirect()

            ->route('admin.projects.index')

            ->with(
                'success',
                'Project berhasil diperbarui'
            );


    }






    public function destroy(Project $project)
    {


        $project->delete();



        return back()

            ->with(
                'success',
                'Project berhasil dihapus'
            );


    }


}