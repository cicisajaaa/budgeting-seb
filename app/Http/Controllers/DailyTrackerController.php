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


        $user = Auth::user();


        if(!$user)
        {
            abort(403);
        }



        $karyawan = $user->karyawan;



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

            'aktivitasTugas.karyawan'

        ])


        ->orderByRaw("

            CASE

                WHEN deadline IS NULL

                THEN 1

                ELSE 0

            END

        ")


        ->orderBy(

            'deadline',

            'asc'

        )


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


        $user = Auth::user();


        if(!$user)
        {
            abort(403);
        }



        $karyawan = $user->karyawan;



        if(!$karyawan)
        {
            abort(403);
        }






        /*
        |--------------------------------------------------------------------------
        | CEK PEMILIK TASK
        |--------------------------------------------------------------------------
        */


        if($task->karyawan_id != $karyawan->id)
        {

            abort(403);

        }



$task->load([

    'proyek',

    'karyawan',

    'divisi',

    'aktivitasTugas'=>function($query){

        $query->with('karyawan')
              ->latest('tanggal');

    }

]);


$activities = $task->aktivitasTugas;





        return view(

            'employee.tracker.show',

            compact(

                'task',

                'activities'

            )

        );


    }





public function update(Tugas $task)
{

    $user = Auth::user();

    if(!$user)
    {
        abort(403);
    }


    $karyawan = $user->karyawan;


    if(!$karyawan)
    {
        abort(403);
    }



    if($task->karyawan_id != $karyawan->id)
    {
        abort(403);
    }



    $task->load([
        'proyek'
    ]);



    return view(
        'employee.tracker.update',
        compact('task')
    );

}



    /*
    |--------------------------------------------------------------------------
    | SIMPAN UPDATE AKTIVITAS
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, Tugas $task)
    {



        $request->validate([


            'aktivitas'=>[
                'required'
            ],


            'progres'=>[

                'required',

                'numeric',

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








        $user = Auth::user();


        if(!$user)
        {
            abort(403);
        }




        $karyawan = $user->karyawan;




        if(!$karyawan)
        {
            abort(403);
        }







        /*
        |--------------------------------------------------------------------------
        | KEAMANAN TASK
        |--------------------------------------------------------------------------
        */


        if($task->karyawan_id != $karyawan->id)
        {

            abort(403);

        }








        /*
        |--------------------------------------------------------------------------
        | TASK SELESAI
        |--------------------------------------------------------------------------
        */


if(in_array($task->status,['selesai','dibatalkan']))
{

    return back()

    ->withErrors([

        'progres'=>

        'Task sudah selesai atau dibatalkan dan tidak dapat diperbarui lagi.'

    ]);

}








        /*
        |--------------------------------------------------------------------------
        | PROGRESS TIDAK BOLEH TURUN
        |--------------------------------------------------------------------------
        */


        $currentProgress = $task->progres_persen ?? 0;



        if($request->progres < $currentProgress)
        {

            return back()

            ->withErrors([

                'progres'=>

                'Progress tidak boleh lebih rendah dari progress sebelumnya.'

            ]);

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


            'anggaran_aktivitas'=>

                $request->anggaran_aktivitas ?? 0,


            'catatan'=>$request->catatan


        ]);






/*
|--------------------------------------------------------------------------
| UPDATE PROGRESS + STATUS TASK
|--------------------------------------------------------------------------
*/

$status = 'belum_dikerjakan';


if($request->progres > 0 && $request->progres < 100)
{

    $status = 'sedang_dikerjakan';

}


elseif($request->progres >= 100)
{

    $status = 'selesai';

}



$task->update([

    'progres_persen'=>$request->progres,

    'status'=>$status

]);




        /*
        |--------------------------------------------------------------------------
        | AUDIT LOG
        |--------------------------------------------------------------------------
        */


        AuditHelper::create(


            'Update Task Activity',


            'Manajemen Tugas',


            'Menambahkan aktivitas pada tugas '

            .$task->nama_tugas.

            ' dengan progres '

            .$request->progres.

            '%'


        );









return redirect()

->route(

    'daily-tracker.show',

    $task->id

)

        ->with(

            'success',

            'Aktivitas berhasil diperbarui'

        );


    }




}