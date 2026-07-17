<?php

namespace App\Http\Controllers;


use App\Models\ExpenseRequest;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use App\Models\BankAccount;
use App\Models\Project;
use App\Models\Division;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Notifications\ExpenseStatusNotification;
class ExpenseApprovalController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN APPROVAL BENDAHARA
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $requests = ExpenseRequest::with([

            'project',

            'division',

            'user'

        ])
        ->where(
            'status',
            'pending'
        )
        ->latest()
        ->get();




        $banks = BankAccount::where(
            'status',
            true
        )
        ->get();





        return view(

            'expense.approval.index',

            compact(

                'requests',

                'banks'

            )

        );


    }








    /*
    |--------------------------------------------------------------------------
    | APPROVE PENGELUARAN
    |--------------------------------------------------------------------------
    */


   public function approve(Request $request,$id)
{

    $request->validate([

        'bank_account_id'=>'required',

        'approval_note'=>'nullable|string'

    ]);



    try{


        $expenseRequest = DB::transaction(function() use($request,$id){



            $expenseRequest = ExpenseRequest::findOrFail($id);



            if($expenseRequest->status != 'pending')
            {

                throw new \Exception(
                    'Pengajuan sudah diproses sebelumnya'
                );

            }





            $bank = BankAccount::findOrFail(
                $request->bank_account_id
            );





            if($bank->saldo < $expenseRequest->jumlah)
            {

                throw new \Exception(
                    'Saldo rekening tidak mencukupi'
                );

            }





            $expenseRequest->update([

                'status'=>'approved',

                'approved_by'=>Auth::id(),

                'approved_at'=>now(),

                'approval_note'=>$request->approval_note 
                    ?? 
                    'Disetujui oleh bendahara'

            ]);







            ExpenseTransaction::create([

                'request_id'=>$expenseRequest->id,

                'approved_by'=>Auth::id(),

                'bank_account_id'=>$bank->id,

                'jumlah'=>$expenseRequest->jumlah,

                'tanggal'=>now(),

            ]);







            $bank->decrement(

                'saldo',

                $expenseRequest->jumlah

            );







            $balance = DivisionBalance::where([

                'project_id'=>$expenseRequest->project_id,

                'division_id'=>$expenseRequest->division_id

            ])
            ->first();



            if($balance)
            {

                $balance->decrement(

                    'saldo',

                    $expenseRequest->jumlah

                );

            }





            return $expenseRequest;


        });






        // NOTIFIKASI KE KARYAWAN

        $expenseRequest->user->notify(

            new ExpenseStatusNotification(

                $expenseRequest,

                'approved'

            )

        );





        return back()

        ->with(

            'success',

            'Pengajuan berhasil disetujui dan transaksi tercatat'

        );



    }


    catch(\Exception $e)
    {


        return back()

        ->with(

            'error',

            $e->getMessage()

        );


    }

}









    /*
    |--------------------------------------------------------------------------
    | REJECT PENGELUARAN
    |--------------------------------------------------------------------------
    */


    public function reject(Request $request,$id)
    {


        $request->validate([


            'approval_note'=>'required|string'


        ]);







        $expenseRequest = ExpenseRequest::findOrFail(

            $id

        );






        if($expenseRequest->status != 'pending')
        {


            return back()

            ->with(

                'error',

                'Pengajuan sudah diproses'

            );


        }








        $expenseRequest->update([



            'status'=>'rejected',



            'approved_by'=>Auth::id(),



            'approved_at'=>now(),



            'approval_note'=>$request->approval_note



        ]);





        $expenseRequest->user->notify(
            new ExpenseStatusNotification(
                $expenseRequest,
                'rejected'
            )
        );


        return back()

        ->with(

            'success',

            'Pengajuan berhasil ditolak'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HISTORY APPROVAL
    |--------------------------------------------------------------------------
    */


    public function history(Request $request)
    {


        $query = ExpenseRequest::with([


            'project',


            'division',


            'user',


            'approver'


        ])

        ->whereIn(

            'status',

            [

                'approved',

                'rejected'

            ]

        );









        /*
        |--------------------------------------------------------------------------
        | SEARCH PEMOHON
        |--------------------------------------------------------------------------
        */


        if($request->search)
        {


            $query->whereHas(

                'user',

                function($q) use($request){


                    $q->where(

                        'name',

                        'like',

                        '%'.$request->search.'%'

                    );


                }

            );


        }









        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */


        if($request->status)
        {


            $query->where(

                'status',

                $request->status

            );


        }









        /*
        |--------------------------------------------------------------------------
        | FILTER PROJECT
        |--------------------------------------------------------------------------
        */


        if($request->project_id)
        {


            $query->where(

                'project_id',

                $request->project_id

            );


        }









        /*
        |--------------------------------------------------------------------------
        | FILTER DIVISI
        |--------------------------------------------------------------------------
        */


        if($request->division_id)
        {


            $query->where(

                'division_id',

                $request->division_id

            );


        }









     $requests = $query
    ->latest()
    ->get();








        $projects = Project::all();


        $divisions = Division::all();








        return view(

            'expense.approval.history',

            compact(

                'requests',

                'projects',

                'divisions'

            )

        );


    }



}