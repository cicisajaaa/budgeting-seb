<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {

        $tasks = Task::with([
            'proyek',
            'karyawan',
            'divisi'
        ])
        ->latest()
        ->get();



        return view(
            'admin.tasks.index',
            compact('tasks')
        );

    }





    public function show(Task $task)
    {

        $task->load([
            'proyek',
            'karyawan',
            'divisi'
        ]);


        return view(
            'admin.tasks.show',
            compact('task')
        );

    }


}