<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Tugas;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Karyawan;

use App\Helpers\AuditHelper;

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
    | Form Tambah Task
    |--------------------------------------------------------------------------
    */

    public function create(Proyek $project)
    {


        $karyawan = Karyawan::with('divisi')

            ->get();



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
    | Simpan Task
    |--------------------------------------------------------------------------
    */

    public function store(

        Request $request,

        Proyek $project

    )
    {


        $request->validate([


            'nama_tugas'=>

            'required|string|max:255',



            'divisi_id'=>

            'nullable|exists:divisi,id',



            'karyawan_id'=>

            'nullable|exists:karyawan,id',



            'tanggal'=>

            'required|date',



            'aktivitas'=>

            'required|string',



            'prioritas'=>

            'required|in:Low,Medium,High',



            'deadline'=>

            'nullable|date',



            'status'=>

            'required|in:belum_dikerjakan,sedang_dikerjakan,selesai',



            'progres_persen'=>

            'required|numeric|min:0|max:100',



            'catatan'=>

            'nullable|string'


        ]);







        $task = $project->tugas()->create([


            'nama_tugas'=>

            $request->nama_tugas,



            'divisi_id'=>

            $request->divisi_id,



            'karyawan_id'=>

            $request->karyawan_id,



            'tanggal'=>

            $request->tanggal,



            'aktivitas'=>

            $request->aktivitas,



            'prioritas'=>

            $request->prioritas,



            'deadline'=>

            $request->deadline,



            'status'=>

            $request->status,



            'progres_persen'=>

            $request->progres_persen,



            'catatan'=>

            $request->catatan,


        ]);








        AuditHelper::create(

            'Tambah Task',

            'Manajemen Task',

            'Admin menambahkan task '.$task->nama_tugas

        );






        return redirect()

            ->route(

                'admin.tasks.index'

            )

            ->with(

                'success',

                'Tugas berhasil ditambahkan'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | Form Edit Task
    |--------------------------------------------------------------------------
    */

    public function edit(Tugas $task)
    {


        $task->load([

            'proyek',

            'karyawan',

            'divisi'

        ]);



        $karyawan = Karyawan::with('divisi')

            ->get();



        $divisi = Divisi::all();





        return view(

            'admin.tasks.edit',

            compact(

                'task',

                'karyawan',

                'divisi'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Update Task
    |--------------------------------------------------------------------------
    */

    public function update(

        Request $request,

        Tugas $task

    )
    {


        $request->validate([


            'nama_tugas'=>

            'required|string|max:255',



            'divisi_id'=>

            'nullable|exists:divisi,id',



            'karyawan_id'=>

            'nullable|exists:karyawan,id',



            'tanggal'=>

            'required|date',



            'aktivitas'=>

            'required|string',



            'prioritas'=>

            'required|in:Low,Medium,High',



            'deadline'=>

            'nullable|date',



            'status'=>

            'required|in:belum_dikerjakan,sedang_dikerjakan,selesai',



            'progres_persen'=>

            'required|numeric|min:0|max:100',



            'catatan'=>

            'nullable|string'


        ]);








        $task->update([


            'nama_tugas'=>

            $request->nama_tugas,



            'divisi_id'=>

            $request->divisi_id,



            'karyawan_id'=>

            $request->karyawan_id,



            'tanggal'=>

            $request->tanggal,



            'aktivitas'=>

            $request->aktivitas,



            'prioritas'=>

            $request->prioritas,



            'deadline'=>

            $request->deadline,



            'status'=>

            $request->status,



            'progres_persen'=>

            $request->progres_persen,



            'catatan'=>

            $request->catatan,


        ]);









        /*
        |--------------------------------------------------------------------------
        | Simpan Riwayat Aktivitas
        |--------------------------------------------------------------------------
        */


        $task->aktivitasTugas()->create([


            'karyawan_id'=>

            $task->karyawan_id,



            'tanggal'=>

            now(),



            'aktivitas'=>

            $request->aktivitas,



            'progres'=>

            $request->progres_persen,



            'catatan'=>

            $request->catatan 

            ??

            'Update task oleh Admin'


        ]);









        /*
        |--------------------------------------------------------------------------
        | Sinkronisasi Progress Task
        |--------------------------------------------------------------------------
        */


        $task->updateProgress();









        AuditHelper::create(

            'Update Task',

            'Manajemen Task',

            'Admin memperbarui task '.$task->nama_tugas

        );









        return redirect()

            ->route(

                'admin.tasks.show',

                $task->id

            )

            ->with(

                'success',

                'Task berhasil diperbarui'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | Hapus Task
    |--------------------------------------------------------------------------
    */

    public function destroy(Tugas $task)
    {


        if($task->aktivitasTugas()->count() > 0)
        {

            return back()->withErrors([

                'task'=>

                'Task tidak dapat dihapus karena memiliki aktivitas.'

            ]);

        }





        AuditHelper::create(

            'Hapus Task',

            'Manajemen Task',

            'Admin menghapus task '.$task->nama_tugas

        );






        $task->delete();






        return redirect()

            ->route(

                'admin.tasks.index'

            )

            ->with(

                'success',

                'Task berhasil dihapus'

            );


    }


}