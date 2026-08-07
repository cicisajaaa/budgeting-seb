<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\AktivitasTugas;
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

        $karyawan = Auth::user()->karyawan;


        if(!$karyawan)
        {
            abort(403);
        }


        $tasks = Tugas::where(
            'karyawan_id',
            $karyawan->id
        )
        ->with([
            'proyek',
            'aktivitasTugas'
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
    | DETAIL TASK
    |--------------------------------------------------------------------------
    */

    public function show(Tugas $task)
    {

        $karyawan = Auth::user()->karyawan;


        if(!$karyawan)
        {
            abort(403);
        }



        if($task->karyawan_id != $karyawan->id)
        {
            abort(403);
        }



        $task->load([
            'proyek',
            'aktivitasTugas'
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


            'task_id'=>[
                'required',
                'exists:tugas,id'
            ],


            'aktivitas'=>[
                'required'
            ],


            'progres'=>[
                'required',
                'integer',
                'min:0',
                'max:100'
            ],


            'anggaran_aktivitas'=>[
                'nullable',
                'numeric',
                'min:0'
            ],


            'catatan'=>[
                'nullable'
            ]


        ]);





        $karyawan = Auth::user()->karyawan;



        if(!$karyawan)
        {
            abort(403);
        }




        $task = Tugas::findOrFail(
            $request->task_id
        );




        if($task->karyawan_id != $karyawan->id)
        {
            abort(403);
        }







        /*
        |--------------------------------------------------------------------------
        | SIMPAN AKTIVITAS TUGAS
        |--------------------------------------------------------------------------
        */


        AktivitasTugas::create([

            'tugas_id'=>$task->id,

            'karyawan_id'=>$karyawan->id,

            'tanggal'=>now(),

            'aktivitas'=>$request->aktivitas,

            'progres'=>$request->progres,

            'anggaran_aktivitas'=>$request->anggaran_aktivitas ?? 0,

            'catatan'=>$request->catatan

        ]);




        // refresh data aktivitas terbaru
        $task->refresh();








        /*
        |--------------------------------------------------------------------------
        | AUDIT LOG
        |--------------------------------------------------------------------------
        */


        AuditHelper::create(

            'Update Task Activity',

            'Manajemen Tugas',

            'Menambahkan aktivitas pada tugas '.
            $task->nama_tugas.
            ' dengan progres '.
            $request->progres.
            '%'

        );









        /*
        |--------------------------------------------------------------------------
        | UPDATE PROGRESS TASK
        |--------------------------------------------------------------------------
        */


        $progressBaru = $task
            ->aktivitasTugas()
            ->max('progres');



        $task->update([

            'progres_persen'=>$progressBaru ?? 0

        ]);


/*
|--------------------------------------------------------------------------
| UPDATE STATUS OTOMATIS
|--------------------------------------------------------------------------
*/


$task->updateStatus();






/*
|--------------------------------------------------------------------------
| UPDATE PROGRESS PROJECT
|--------------------------------------------------------------------------
*/


$project = $task->proyek;



if($project)
{


    $progressProject = $project

        ->tugas()

        ->avg('progres_persen');



    $project->update([

        'progres_keseluruhan' =>

        $progressProject ?? 0

    ]);


}






        return redirect()

            ->route(
                'daily-tracker.index'
            )

            ->with(
                'success',
                'Aktivitas berhasil diperbarui'
            );


    }


}