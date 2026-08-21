<?php

namespace App\Http\Controllers;


use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;
use App\Models\Proyek;
use App\Models\Divisi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Notifications\ExpenseStatusNotification;
use App\Helpers\AuditHelper;



class ExpenseApprovalController extends Controller
{


    public function index()
    {
        $requests = PengajuanDana::with([

            'proyek.perusahaan',

            'divisi',

            'pengguna'

        ])

        ->where('status','pending')

        ->latest()

        ->get();



        $banks = RekeningBank::where(
            'status',
            true
        )->get();



        return view(
            'expense.approval.index',
            compact(
                'requests',
                'banks'
            )
        );

    }







    public function approve(Request $request,$id)
    {


        $request->validate([

            'rekening_bank_id'=>'required',

            'catatan_persetujuan'=>'nullable|string'

        ]);




        try{


            $expenseRequest = DB::transaction(function() use($request,$id){


                $expenseRequest = PengajuanDana::findOrFail($id);



                if($expenseRequest->status != 'pending')
                {

                    throw new \Exception(
                        'Pengajuan sudah diproses sebelumnya'
                    );

                }



                $bank = RekeningBank::where(
                    'id',
                    $request->rekening_bank_id
                )
                ->where(
                    'status',
                    true
                )
                ->firstOrFail();



                if($bank->saldo < $expenseRequest->jumlah)
                {

                    throw new \Exception(
                        'Saldo rekening tidak mencukupi'
                    );

                }




                $balance = SaldoDivisi::where([

                    'proyek_id'=>$expenseRequest->proyek_id,

                    'divisi_id'=>$expenseRequest->divisi_id

                ])

                ->first();





                if(!$balance)
                {

                    throw new \Exception(
                        'Saldo divisi project belum tersedia'
                    );

                }




                if($balance->saldo < $expenseRequest->jumlah)
                {

                    throw new \Exception(
                        'Saldo divisi tidak mencukupi'
                    );

                }




$project = Proyek::findOrFail(
    $expenseRequest->proyek_id
);


if(
    $project->sisa_budget < $expenseRequest->jumlah
)
{

    throw new \Exception(
        'Budget proyek tidak mencukupi'
    );

}

                $expenseRequest->update([


                    'status'=>'approved',


                    'disetujui_oleh'=>Auth::id(),


                    'disetujui_pada'=>now(),


                    'catatan_persetujuan'=>

                    $request->catatan_persetujuan

                    ??

                    'Disetujui oleh '.Auth::user()->name


                ]);






                TransaksiDana::create([


                    'pengajuan_dana_id'=>$expenseRequest->id,


                    'disetujui_oleh'=>Auth::id(),


                    'rekening_bank_id'=>$bank->id,


                    'jumlah'=>$expenseRequest->jumlah,


                    'tanggal'=>now()


                ]);







                $bank->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );





                $balance->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );

            /*
            |--------------------------------------------------------------------------
            | AUDIT UPDATE SALDO
            |--------------------------------------------------------------------------
            */

            AuditHelper::create(

            'UPDATE SALDO',

            'Keuangan',

            'Pencairan dana project '.
            $project->nama_proyek.
            ' sebesar Rp '.
            number_format(
                $expenseRequest->jumlah,
                0,
                ',',
                '.'
            ),

            $expenseRequest->id

        );



                return $expenseRequest;


            });







            /*
            |--------------------------------------------------------------------------
            | AUDIT APPROVE
            |--------------------------------------------------------------------------
            */


            AuditHelper::create(

                'APPROVE',

                'Pengajuan Dana',

                'Menyetujui pengajuan dana "' .

                $expenseRequest->judul .

                '" sebesar Rp ' .

                number_format(

                    $expenseRequest->jumlah,

                    0,

                    ',',

                    '.'

                ),

                $expenseRequest->id

            );







            $expenseRequest->pengguna->notify(

                new ExpenseStatusNotification(

                    $expenseRequest,

                    'approved'

                )

            );







            return back()->with(

                'success',

                'Pengajuan berhasil disetujui'

            );



        }

        catch(\Exception $e)

        {

            return back()->with(

                'error',

                $e->getMessage()

            );

        }


    }









    public function reject(Request $request,$id)
    {


        $request->validate([

            'catatan_persetujuan'=>'required|string'

        ]);





        $expenseRequest = PengajuanDana::findOrFail($id);






        if($expenseRequest->status != 'pending')
        {

            return back()->with(

                'error',

                'Pengajuan sudah diproses'

            );

        }







        $expenseRequest->update([


            'status'=>'rejected',


            'disetujui_oleh'=>Auth::id(),


            'disetujui_pada'=>now(),


            'catatan_persetujuan'=>

            $request->catatan_persetujuan


        ]);








        /*
        |--------------------------------------------------------------------------
        | AUDIT REJECT
        |--------------------------------------------------------------------------
        */


        AuditHelper::create(

        'REJECT',

        'Pengajuan Dana',

        'Menolak pengajuan dana "' .

        $expenseRequest->judul .

        '" sebesar Rp ' .

        number_format(

            $expenseRequest->jumlah,

            0,

            ',',

            '.'

        )

        .

        ' dengan catatan: '

        .

        $request->catatan_persetujuan,

        $expenseRequest->id

    );








        $expenseRequest->pengguna->notify(

            new ExpenseStatusNotification(

                $expenseRequest,

                'rejected'

            )

        );







        return back()->with(

            'success',

            'Pengajuan berhasil ditolak'

        );


    }









    public function history(Request $request)
    {


        $query = PengajuanDana::with([

            'proyek',

            'divisi',

            'pengguna',

            'penyetuju'

        ])

        ->whereIn(

            'status',

            [

                'approved',

                'rejected'

            ]

        );







        if($request->search)
        {

            $query->whereHas(

                'pengguna',

                function($q) use($request){

                    $q->where(

                        'name',

                        'like',

                        '%'.$request->search.'%'

                    );

                }

            );

        }







        if($request->status)
        {

            $query->where(

                'status',

                $request->status

            );

        }







        if($request->proyek_id)
        {

            $query->where(

                'proyek_id',

                $request->proyek_id

            );

        }







        if($request->divisi_id)
        {

            $query->where(

                'divisi_id',

                $request->divisi_id

            );

        }








        $requests = $query

        ->latest()

        ->get();






        $projects = Proyek::all();

        $divisions = Divisi::all();







        return view(

            'expense.approval.history',

            compact(

                'requests',

                'projects',

                'divisions'

            )

        );


    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL APPROVAL FINANCE
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {


        $expense = PengajuanDana::with([

            'proyek.perusahaan',

            'proyek',

            'divisi',

            'pengguna',

            'penyetuju',

            'auditLogs'


        ])

        ->findOrFail($id);






        /*
        |--------------------------------------------------------------------------
        | AUDIT VIEW
        |--------------------------------------------------------------------------
        */


        AuditHelper::create(

            'VIEW',

            'Pengajuan Dana',

            'Melihat detail pengajuan dana: '.$expense->judul,

            $expense->id

        );







        return view(

        'expense.detail',

        [
            'request' => $expense
        ]

    );

    }

}