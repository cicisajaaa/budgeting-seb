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







        $tasks = $karyawan

            ->tugas()

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
    | DETAIL UPDATE TASK
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

                'numeric'

            ],




            'catatan'=>[

                'nullable'

            ]



        ]);








        $karyawan = Auth::user()->karyawan;







        $task = Tugas::findOrFail(

            $request->task_id

        );







        if($task->karyawan_id != $karyawan->id)
        {

            abort(403);

        }







        $proyek = $task->proyek;









        /*
        |--------------------------------------------------------------------------
        | CEK ANGGARAN PROYEK
        |--------------------------------------------------------------------------
        */


        if($request->anggaran_aktivitas > 0)
        {


            $totalUsed = $proyek

                ->tugas()

                ->with('aktivitasTugas')

                ->get()

                ->flatMap(function($task){

                    return $task->aktivitasTugas;

                })

                ->sum('anggaran_aktivitas');









            $sisaAnggaran =

                $proyek->total_anggaran

                -

                $totalUsed;








            if($request->anggaran_aktivitas > $sisaAnggaran)
            {


                return back()

                ->withInput()

                ->with(

                    'error',

                    'Anggaran aktivitas melebihi sisa anggaran proyek. Sisa anggaran: Rp '.

                    number_format(

                        $sisaAnggaran,

                        0,

                        ',',

                        '.'

                    )

                );


            }


        }









        /*
        |--------------------------------------------------------------------------
        | SIMPAN AKTIVITAS
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
        | UPDATE PROGRES TASK
        |--------------------------------------------------------------------------
        */


        $task->update([


            'progres_persen'=>$request->progres,


        ]);








        $task->updateStatus();









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