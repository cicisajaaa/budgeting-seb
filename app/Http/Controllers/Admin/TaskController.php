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

'aktivitasTugas'=>function($query){

    $query->with('karyawan')
          ->orderByDesc('tanggal')
          ->orderByDesc('created_at');

}

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


        $karyawan = Karyawan::with('divisi')->get();

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

    public function store(Request $request, Proyek $project)
    {


        $request->validate([


            'nama_tugas'=>'required|string|max:255',

            'divisi_id'=>'nullable|exists:divisi,id',

            'karyawan_id'=>'nullable|exists:karyawan,id',

            'tanggal'=>'required|date',

            'aktivitas'=>'required|string',

            'prioritas'=>'required|in:Low,Medium,High',

            'deadline'=>'nullable|date',

            'progres_persen'=>'required|numeric|min:0|max:100',

            'catatan'=>'nullable|string'


        ]);




        $task = $project->tugas()->create([


            'nama_tugas'=>$request->nama_tugas,

            'divisi_id'=>$request->divisi_id,

            'karyawan_id'=>$request->karyawan_id,

            'tanggal'=>$request->tanggal,

            'aktivitas'=>$request->aktivitas,

            'prioritas'=>$request->prioritas,

            'deadline'=>$request->deadline,

            'progres_persen'=>$request->progres_persen,

            'catatan'=>$request->catatan,


        ]);






        AuditHelper::create(

            'Tambah Task',

            'Manajemen Task',

            'Admin menambahkan task '.$task->nama_tugas

        );





        return redirect()

        ->route('admin.tasks.index')

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



        $karyawan = Karyawan::with('divisi')->get();

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

    public function update(Request $request, Tugas $task)
    {


        $request->validate([


            'nama_tugas'=>'required|string|max:255',

            'divisi_id'=>'nullable|exists:divisi,id',

            'karyawan_id'=>'nullable|exists:karyawan,id',

            'tanggal'=>'required|date',

            'aktivitas'=>'required|string',

            'prioritas'=>'required|in:Low,Medium,High',

            'deadline'=>'nullable|date',

            'progres_persen'=>'required|numeric|min:0|max:100',

            'catatan'=>'nullable|string'


        ]);




        /*
        |--------------------------------------------------------------------------
        | Status Otomatis
        |--------------------------------------------------------------------------
        */

        $status = $task->status;



        if($task->status != 'dibatalkan'){


            if($request->progres_persen >= 100){

                $status = 'selesai';

            }

            elseif($request->progres_persen > 0){

                $status = 'sedang_dikerjakan';

            }

            else{

                $status = 'belum_dikerjakan';

            }


        }





        $task->update([


            'nama_tugas'=>$request->nama_tugas,

            'divisi_id'=>$request->divisi_id,

            'karyawan_id'=>$request->karyawan_id,

            'tanggal'=>$request->tanggal,

            'aktivitas'=>$request->aktivitas,

            'prioritas'=>$request->prioritas,

            'deadline'=>$request->deadline,

            'progres_persen'=>$request->progres_persen,

            'status'=>$status,

            'catatan'=>$request->catatan,


        ]);








        /*
        |--------------------------------------------------------------------------
        | Simpan Riwayat Aktivitas
        |--------------------------------------------------------------------------
        */


        $task->aktivitasTugas()->create([


            'karyawan_id'=>$task->karyawan_id,

            'tanggal'=>now(),

            'aktivitas'=>$request->aktivitas,

            'progres'=>$request->progres_persen,

            'anggaran_aktivitas'=>0,

            'catatan'=>$request->catatan ?? 'Update task oleh Admin'


        ]);








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
    | Batalkan Task
    |--------------------------------------------------------------------------
    */

    public function cancel(Tugas $task)
    {


        $task->update([

            'status'=>'dibatalkan'

        ]);





        AuditHelper::create(

            'Batalkan Task',

            'Manajemen Task',

            'Admin membatalkan task '.$task->nama_tugas

        );






        return back()

        ->with(

            'success',

            'Task berhasil dibatalkan'

        );


    }


}