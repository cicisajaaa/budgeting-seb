<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\TaskActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditHelper;


class DailyTrackerController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST DAILY TRACKER
    |--------------------------------------------------------------------------
    */


    public function index()
    {

        $employee = Auth::user()->employee;



        $tasks = $employee
            ->tasks()
            ->with([
                'project',
                'activities'
            ])
            ->latest()
            ->get();




        return view(

            'daily-tracker.index',

            compact('tasks')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL UPDATE TASK
    |--------------------------------------------------------------------------
    */


    public function show(Task $task)
    {


        $employee = Auth::user()->employee;



        // keamanan task milik karyawan

        if($task->employee_id != $employee->id){

            abort(403);

        }





        $task->load([

            'project',

            'activities'

        ]);





        return view(

            'employee.tracker.show',

            compact('task')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN AKTIVITAS
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $request->validate([


            'task_id' => [

                'required',

                'exists:tasks,id'

            ],



            'aktivitas' => [

                'required'

            ],



            'progress' => [

                'required',

                'integer',

                'min:0',

                'max:100'

            ],



            'budget_activity' => [

                'nullable',

                'numeric'

            ],



            'catatan' => [

                'nullable'

            ],



        ]);







        $employee = Auth::user()->employee;








        $task = Task::findOrFail(

            $request->task_id

        );
        $project = $task->project;


/*
|--------------------------------------------------------------------------
| VALIDASI BUDGET ACTIVITY
|--------------------------------------------------------------------------
*/


if($request->budget_activity > 0)
{


    $totalUsed = $project
        ->tasks()
        ->with('activities')
        ->get()
        ->flatMap(function($task){

            return $task->activities;

        })
        ->sum('budget_activity');



    $sisaBudget = $project->total_budget - $totalUsed;



    if($request->budget_activity > $sisaBudget)
    {

        return back()
        ->withInput()
        ->with(
            'error',
            'Budget aktivitas melebihi sisa anggaran project. Sisa budget: Rp '.number_format($sisaBudget,0,',','.')
        );


    }


}








        // cek task milik karyawan login


        if($task->employee_id != $employee->id){


            abort(403);


        }









        /*
        |--------------------------------------------------------------------------
        | SIMPAN HISTORY AKTIVITAS
        |--------------------------------------------------------------------------
        */



        TaskActivity::create([


            'task_id' => $task->id,



            'employee_id' => $employee->id,



            'tanggal' => now(),



            'aktivitas' => $request->aktivitas,



            'progress' => $request->progress,



            'budget_activity' => $request->budget_activity ?? 0,



            'catatan' => $request->catatan,



        ]);


// AUDIT LOG

AuditHelper::create(

    'Update Task Activity',

    'Task Management',

    'Menambahkan aktivitas pada task '
    .
    $task->nama_task
    .
    ' dengan progress '
    .
    $request->progress
    .
    '%'

);






        /*
        |--------------------------------------------------------------------------
        | UPDATE PROGRESS TASK
        |--------------------------------------------------------------------------
        */



        $task->update([


            'progress_persen' => $request->progress,


        ]);









        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */


        $task->updateStatus();









        /*
        |--------------------------------------------------------------------------
        | REDIRECT KE DETAIL TASK
        |--------------------------------------------------------------------------
        */


        return redirect()

            ->route(

                'employee.task.show',

                $task->id

            )

            ->with(

                'success',

                'Aktivitas berhasil diperbarui'

            );


    }



}