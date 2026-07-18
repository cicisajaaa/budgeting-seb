<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;


class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with([
            'project',
            'division',
            'employee'
        ])
        ->latest()
        ->get();


        return view(
            'admin.tasks.index',
            compact('tasks')
        );
    }



    public function create()
    {

        $projects = Project::all();

        $divisions = Division::all();

        $employees = Employee::all();


        return view(
            'admin.tasks.create',
            compact(
                'projects',
                'divisions',
                'employees'
            )
        );

    }



    public function store(Request $request)
{

    $request->validate([

        'project_id'=>'required',

        'employee_id'=>'required',

        'nama_task'=>'required',

        'prioritas'=>'required',

        'deadline'=>'nullable|date'

    ]);



    $task = Task::create([

        'project_id'=>$request->project_id,

        'division_id'=>$request->division_id,

        'employee_id'=>$request->employee_id,

        'tanggal'=>now(),

        'nama_task'=>$request->nama_task,

        'aktivitas'=>$request->aktivitas,

        'prioritas'=>$request->prioritas,

        'deadline'=>$request->deadline,

        'status'=>'todo',

        'progress_persen'=>0,

        'catatan'=>$request->catatan,

    ]);



    // Update progress project otomatis

    $task->project->updateProgress();



    return redirect()
        ->route('admin.tasks.index')
        ->with(
            'success',
            'Task berhasil dibuat'
        );

}


    public function destroy(Task $task)
    {

        $task->delete();


        return back();

    }


}