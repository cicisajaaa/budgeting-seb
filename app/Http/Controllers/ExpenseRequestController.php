<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Proyek;
use App\Models\PengajuanDana;
use App\Models\User;
use App\Models\SaldoDivisi;

use App\Helpers\AuditHelper;

use App\Notifications\NewExpenseRequest;

use App\Http\Requests\StorePengajuanDanaRequest;



class ExpenseRequestController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | FORM PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        $employee = Auth::user()->karyawan;


        if(!$employee)
        {
            abort(403);
        }



        $projects = Proyek::whereHas(

            'tugas',

            function($query) use($employee){

                $query->where(
                    'karyawan_id',
                    $employee->id
                );

            }

        )

        ->with('perusahaan')

        ->get();



        $divisions = collect();



        return view(

            'expense.create',

            compact(
                'projects',
                'divisions'
            )

        );

    }









    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN DANA
    |--------------------------------------------------------------------------
    */


    public function store(StorePengajuanDanaRequest $request)
    {


        $employee = Auth::user()->karyawan;



        if(!$employee)
        {
            abort(403);
        }







        /*
        |--------------------------------------------------------------------------
        | CEK PROJECT MILIK KARYAWAN
        |--------------------------------------------------------------------------
        */


        $allowedProject = Proyek::whereHas(

            'tugas',

            function($query) use($employee){

                $query->where(
                    'karyawan_id',
                    $employee->id
                );

            }

        )

        ->where(
            'id',
            $request->proyek_id
        )

        ->exists();



        if(!$allowedProject)
        {
            abort(403);
        }







        /*
        |--------------------------------------------------------------------------
        | CEK DIVISI
        |--------------------------------------------------------------------------
        */


        if(
            $request->divisi_id != $employee->divisi_id
        )
        {
            abort(403);
        }









        /*
        |--------------------------------------------------------------------------
        | CEK DUPLICATE PENDING
        |--------------------------------------------------------------------------
        */


        $duplicate = PengajuanDana::where([

            'pengguna_id'=>Auth::id(),

            'proyek_id'=>$request->proyek_id,

            'divisi_id'=>$request->divisi_id,

            'status'=>'pending'

        ])

        ->exists();



        if($duplicate)
        {

            return back()

            ->withErrors([

                'jumlah'=>
                'Masih ada pengajuan dana yang menunggu persetujuan.'

            ])

            ->withInput();

        }










        /*
        |--------------------------------------------------------------------------
        | CEK SALDO DIVISI
        |--------------------------------------------------------------------------
        */


        $balance = SaldoDivisi::where([

            'proyek_id'=>$request->proyek_id,

            'divisi_id'=>$request->divisi_id

        ])

        ->first();





        if(!$balance)
        {

            return back()

            ->withErrors([

                'jumlah'=>
                'Saldo divisi belum tersedia.'

            ])

            ->withInput();

        }







        if(
            $balance->saldo < $request->jumlah
        )
        {

            return back()

            ->withErrors([

                'jumlah'=>
                'Saldo divisi tidak mencukupi.'

            ])

            ->withInput();

        }









        /*
        |--------------------------------------------------------------------------
        | CEK BUDGET PROJECT
        |--------------------------------------------------------------------------
        */


        $project = Proyek::findOrFail(
            $request->proyek_id
        );



        if(
            $project->sisa_budget < $request->jumlah
        )
        {

            return back()

            ->withErrors([

                'jumlah'=>
                'Budget project tidak mencukupi. Sisa budget: Rp '.

                number_format(
                    $project->sisa_budget,
                    0,
                    ',',
                    '.'
                )

            ])

            ->withInput();

        }









        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI
        |--------------------------------------------------------------------------
        */


        $filename = null;



        if(
            $request->hasFile(
                'bukti_pengajuan'
            )
        )
        {


            $file = $request->file(
                'bukti_pengajuan'
            );


            $filename =
                time().'_'.$file->hashName();



            if(
                !file_exists(
                    public_path(
                        'uploads/pengajuan'
                    )
                )
            )
            {

                mkdir(
                    public_path(
                        'uploads/pengajuan'
                    ),
                    0755,
                    true
                );

            }



            $file->move(

                public_path(
                    'uploads/pengajuan'
                ),

                $filename

            );

        }









        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */


        DB::transaction(function() use(

            $request,

            $filename,

            &$expense

        ){

            $expense = PengajuanDana::create([


                'proyek_id'=>$request->proyek_id,


                'divisi_id'=>$request->divisi_id,


                'pengguna_id'=>Auth::id(),


                'judul'=>$request->judul,


                'keterangan'=>$request->keterangan,


                'jumlah'=>$request->jumlah,


                'status'=>'pending',


                'bukti_pengajuan'=>$filename


            ]);


        });









        AuditHelper::create(

            'CREATE',

            'Pengajuan Dana',

            'Membuat pengajuan dana: '.$expense->judul,

            $expense->id

        );









        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI FINANCE
        |--------------------------------------------------------------------------
        */


        $keuangan = User::where(

            'role',

            'keuangan'

        )

        ->get();




        foreach($keuangan as $user)
        {

            $user->notify(

                new NewExpenseRequest(
                    $expense
                )

            );

        }








        return redirect()

        ->route(
            'expense.myhistory'
        )

        ->with(

            'success',

            'Pengajuan dana berhasil dikirim dan menunggu persetujuan'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY
    |--------------------------------------------------------------------------
    */


    public function history(Request $request)
    {

        $query = PengajuanDana::with([

            'proyek.perusahaan',

            'divisi',

            'penyetuju'

        ])

        ->where(

            'pengguna_id',

            Auth::id()

        );




if($request->filled('status'))
{
    if($request->status === 'approved')
    {
        $query->whereIn(
            'status',
            ['approved', 'selesai']
        );
    }
    else
    {
        $query->where(
            'status',
            $request->status
        );
    }
}





        $requests = $query

        ->latest()

        ->get();





        return view(

            'expense.history',

            compact(
                'requests'
            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */


    public function detail($id)
    {


        $request = PengajuanDana::with([

            'proyek.perusahaan',

            'proyek.transaksiDana',

            'divisi',

            'penyetuju',

            'pengguna',

            'auditLogs.pengguna'

        ])

        ->where(

            'pengguna_id',

            Auth::id()

        )

        ->findOrFail($id);





        return view(

            'expense.detail',

            compact(
                'request'
            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | GET DIVISI PROJECT
    |--------------------------------------------------------------------------
    */


    public function getDivisions(Proyek $project)
    {


        $employee = Auth::user()->karyawan;



        if(!$employee)
        {
            abort(403);
        }






        $allowed = $project->tugas()

            ->where(
                'karyawan_id',
                $employee->id
            )

            ->exists();






        if(!$allowed)
        {
            abort(403);
        }







        $divisions = $project

        ->saldoDivisi()

        ->with('divisi')

        ->where(

            'divisi_id',

            $employee->divisi_id

        )

        ->where(

            'saldo',

            '>',

            0

        )

        ->get();







        return response()->json(
            $divisions
        );


    }



}