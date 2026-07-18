<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyTrackerController extends Controller
{

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



    public function store(Request $request)
    {

        $request->validate([

            'task_id' => 'required|exists:tasks,id',

            'aktivitas' => 'required',

            'progress' => 'required|integer|min:0|max:100',

        ]);



        $employee = Auth::user()->employee;



        $task = Task::findOrFail(
            $request->task_id
        );



        // Pastikan task milik karyawan yang login

        if($task->employee_id != $employee->id){

            abort(403);

        }



        // Simpan histori aktivitas

        TaskActivity::create([

            'task_id' => $task->id,

            'employee_id' => $employee->id,

            'tanggal' => now(),

            'aktivitas' => $request->aktivitas,

            'progress' => $request->progress,

            'budget_activity' => $request->budget_activity ?? 0,

            'catatan' => $request->catatan,

        ]);




        // Update progress task

        $task->update([

            'progress_persen' => $request->progress,

        ]);



        // Update status otomatis

        $task->updateStatus();




        return back()->with(
            'success',
            'Aktivitas berhasil diperbarui'
        );

    }

}