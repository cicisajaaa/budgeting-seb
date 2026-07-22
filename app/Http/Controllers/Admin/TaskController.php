<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;


use App\Models\Proyek;
use App\Models\Tugas;
use App\Models\Divisi;
use App\Models\Karyawan;


use Illuminate\Http\Request;



class TaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST TASK PROJECT
    |--------------------------------------------------------------------------
    */


    public function index(Proyek $project)
    {


        $tasks = Tugas::with([

            'divisi',

            'karyawan'

        ])

        ->where(

            'proyek_id',

            $project->id

        )

        ->latest()

        ->get();







        return view(

            'admin.tasks.index',

            compact(

                'project',

                'tasks'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH TASK
    |--------------------------------------------------------------------------
    */


    public function create(Proyek $project)
    {


        $divisi = Divisi::all();


        $karyawan = Karyawan::all();







        return view(

            'admin.tasks.create',

            compact(

                'project',

                'divisi',

                'karyawan'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN TASK
    |--------------------------------------------------------------------------
    */


    public function store(Request $request, Proyek $project)
    {


        $request->validate([



            'divisi_id'=>

                'required|exists:divisi,id',



            'karyawan_id'=>

                'nullable|exists:karyawan,id',



            'tanggal'=>

                'required|date',



            'nama_tugas'=>

                'required|string|max:255',



            'aktivitas'=>

                'required|string',



            'prioritas'=>

                'required|in:Low,Medium,High',



            'status'=>

                'required|string',



            'progres_persen'=>

                'required|numeric|min:0|max:100',



        ]);









        Tugas::create([



            'proyek_id'=>

                $project->id,



            'divisi_id'=>

                $request->divisi_id,



            'karyawan_id'=>

                $request->karyawan_id,



            'tanggal'=>

                $request->tanggal,



            'nama_tugas'=>

                $request->nama_tugas,



            'aktivitas'=>

                $request->aktivitas,



            'prioritas'=>

                $request->prioritas,



            'status'=>

                $request->status,



            'progres_persen'=>

                $request->progres_persen,



            'catatan'=>

                $request->catatan,



        ]);









        return redirect()

            ->route(

                'admin.tasks.index',

                $project->id

            )

            ->with(

                'success',

                'Tugas berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL TASK
    |--------------------------------------------------------------------------
    */


    public function show(Tugas $task)
    {


        $task->load([

            'proyek',

            'divisi',

            'karyawan',

            'aktivitasTugas'

        ]);






        return view(

            'admin.tasks.show',

            compact(

                'task'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT TASK
    |--------------------------------------------------------------------------
    */


    public function edit(Tugas $task)
    {


        $divisi = Divisi::all();


        $karyawan = Karyawan::all();






        return view(

            'admin.tasks.edit',

            compact(

                'task',

                'divisi',

                'karyawan'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE TASK
    |--------------------------------------------------------------------------
    */


    public function update(Request $request, Tugas $task)
    {


        $request->validate([



            'divisi_id'=>

                'required|exists:divisi,id',



            'karyawan_id'=>

                'nullable|exists:karyawan,id',



            'nama_tugas'=>

                'required|string|max:255',



            'prioritas'=>

                'required|in:Low,Medium,High',



            'status'=>

                'required|string',



            'progres_persen'=>

                'required|numeric|min:0|max:100',



        ]);









        $task->update([



            'divisi_id'=>

                $request->divisi_id,



            'karyawan_id'=>

                $request->karyawan_id,



            'nama_tugas'=>

                $request->nama_tugas,



            'prioritas'=>

                $request->prioritas,



            'status'=>

                $request->status,



            'progres_persen'=>

                $request->progres_persen,



            'catatan'=>

                $request->catatan,



        ]);









        return redirect()

            ->route(

                'admin.tasks.index',

                $task->proyek_id

            )

            ->with(

                'success',

                'Tugas berhasil diperbarui'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | HAPUS TASK
    |--------------------------------------------------------------------------
    */


    public function destroy(Tugas $task)
    {


        $projectId = $task->proyek_id;





        $task->delete();






        return redirect()

            ->route(

                'admin.tasks.index',

                $projectId

            )

            ->with(

                'success',

                'Tugas berhasil dihapus'

            );


    }



}