<?php

namespace App\Http\Controllers;


use App\Models\ExpenseRequest;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use App\Models\BankAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ExpenseApprovalController extends Controller
{


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









    public function approve(Request $request, $id)
    {


        $request->validate([


            'bank_account_id'=>'required'


        ]);







        DB::transaction(function () use ($request, $id) {



            /*
            |--------------------------------------------------------------------------
            | Ambil pengajuan
            |--------------------------------------------------------------------------
            */


            $requestData = ExpenseRequest::findOrFail(

                $id

            );








            /*
            |--------------------------------------------------------------------------
            | Ambil rekening pembayaran
            |--------------------------------------------------------------------------
            */


            $bank = BankAccount::findOrFail(

                $request->bank_account_id

            );








            /*
            |--------------------------------------------------------------------------
            | Cek saldo bank
            |--------------------------------------------------------------------------
            */


            if($bank->saldo < $requestData->jumlah)
            {


                throw new \Exception(
                    'Saldo rekening tidak mencukupi'
                );


            }








            /*
            |--------------------------------------------------------------------------
            | Update status pengajuan
            |--------------------------------------------------------------------------
            */


            $requestData->update([


                'status'=>'approved'


            ]);









            /*
            |--------------------------------------------------------------------------
            | Simpan transaksi pengeluaran
            |--------------------------------------------------------------------------
            */


            ExpenseTransaction::create([


                'request_id'=>$requestData->id,


                'approved_by'=>Auth::id(),


                'bank_account_id'=>$bank->id,


                'jumlah'=>$requestData->jumlah,


                'tanggal'=>now(),


            ]);









            /*
            |--------------------------------------------------------------------------
            | Kurangi saldo bank
            |--------------------------------------------------------------------------
            */


            $bank->decrement(

                'saldo',

                $requestData->jumlah

            );









            /*
            |--------------------------------------------------------------------------
            | Kurangi saldo divisi
            |--------------------------------------------------------------------------
            */


            $balance = DivisionBalance::where(

                'project_id',

                $requestData->project_id

            )
            ->where(

                'division_id',

                $requestData->division_id

            )
            ->first();







            if($balance)
            {


                $balance->decrement(

                    'saldo',

                    $requestData->jumlah

                );


            }



        });









        return back()

            ->with(

                'success',

                'Pengajuan berhasil disetujui, saldo bank dan divisi diperbarui'

            );


    }









    public function reject($id)
    {


        $requestData = ExpenseRequest::findOrFail(

            $id

        );






        $requestData->update([


            'status'=>'rejected'


        ]);








        return back()

            ->with(

                'success',

                'Pengajuan berhasil ditolak'

            );


    }



}