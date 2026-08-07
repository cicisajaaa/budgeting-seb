<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Tugas;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Karyawan;

use Illuminate\Http\Request;



class TaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Monitoring Semua Task
    |--------------------------------------------------------------------------
    */

    public function index()
    {


        $tasks = Tugas::with([

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







    /*
    |--------------------------------------------------------------------------
    | Detail Task
    |--------------------------------------------------------------------------
    */

    public function show(Tugas $task)
    {


        $task->load([

            'proyek',

            'karyawan',

            'divisi',

            'aktivitasTugas'

        ]);




        return view(

            'admin.tasks.show',

            compact('task')

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Form Tambah Tugas dari Project
    |--------------------------------------------------------------------------
    */

    public function create(Proyek $project)
    {


        /*
        |--------------------------------------------------------------------------
        | Ambil semua karyawan
        |--------------------------------------------------------------------------
        */


        $karyawan = Karyawan::all();



        $divisi = Divisi::all();






        return view(

            'admin.tasks.create',

            compact(

                'project',

                'karyawan',

                'divisi'

            )

        );


    }








    /*
    |--------------------------------------------------------------------------
    | Simpan Tugas
    |--------------------------------------------------------------------------
    */

    public function store(

        Request $request,

        Proyek $project

    )

    {


        $request->validate([


            'nama_tugas' =>

            'required|string|max:255',



            'divisi_id' =>

            'nullable|exists:divisi,id',



            'karyawan_id' =>

            'nullable|exists:karyawan,id',



            'tanggal' =>

            'required|date',



            'aktivitas' =>

            'required|string',



            'prioritas' =>

            'required|in:Low,Medium,High',



            'deadline' =>

            'nullable|date',



            'status' =>

            'required',



            'progres_persen' =>

            'required|numeric|min:0|max:100',


        ]);







        $project->tugas()->create([



            'nama_tugas' =>

            $request->nama_tugas,



            'divisi_id' =>

            $request->divisi_id,



            'karyawan_id' =>

            $request->karyawan_id,



            'tanggal' =>

            $request->tanggal,



            'aktivitas' =>

            $request->aktivitas,



            'prioritas' =>

            $request->prioritas,



            'deadline' =>

            $request->deadline,



            'status' =>

            $request->status,



            'progres_persen' =>

            $request->progres_persen,


        ]);







        return redirect()

            ->route(

                'admin.tasks.index'

            )

            ->with(

                'success',

                'Tugas berhasil ditambahkan'

            );


    }


}