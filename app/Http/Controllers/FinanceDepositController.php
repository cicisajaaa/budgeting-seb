<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\DepositDistribution;
use App\Models\DivisionBalance;
use App\Models\BankAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class FinanceDepositController extends Controller
{


    public function index()
    {


        $projects = Project::all();



        $banks = BankAccount::where(
            'status',
            true
        )
        ->get();





        $deposits = ProjectDeposit::with([

            'project',

            'bank'

        ])
        ->latest()
        ->get();






        return view(

            'finance.deposit.index',

            compact(

                'projects',

                'banks',

                'deposits'

            )

        );


    }









    public function store(Request $request)
    {



        $request->validate([


            'project_id' => 'required',


            'bank_account_id' => 'required',


            'jumlah_setoran' => 'required|numeric',


            'tanggal_setoran' => 'required|date',


        ]);






        DB::transaction(function () use ($request) {



            /*
            |--------------------------------------------------------------------------
            | Simpan pembayaran masuk
            |--------------------------------------------------------------------------
            */


            $deposit = ProjectDeposit::create([


                'project_id' => $request->project_id,


                'bank_account_id' => $request->bank_account_id,


                'jumlah_setoran' => $request->jumlah_setoran,


                'tanggal_setoran' => $request->tanggal_setoran,


            ]);







            /*
            |--------------------------------------------------------------------------
            | Update saldo rekening bank
            |--------------------------------------------------------------------------
            */


            $bank = BankAccount::findOrFail(

                $request->bank_account_id

            );




            $bank->increment(

                'saldo',

                $request->jumlah_setoran

            );








            /*
            |--------------------------------------------------------------------------
            | Ambil aturan pembagian dana project
            |--------------------------------------------------------------------------
            */


            $allocations = $deposit
                ->project
                ->allocations;









            /*
            |--------------------------------------------------------------------------
            | Distribusi dana + update saldo divisi
            |--------------------------------------------------------------------------
            */


            foreach($allocations as $allocation)
            {



                $nominal =

                    $deposit->jumlah_setoran *

                    ($allocation->persentase / 100);








                /*
                |--------------------------------------------------------------------------
                | Simpan histori distribusi
                |--------------------------------------------------------------------------
                */


                DepositDistribution::create([


                    'deposit_id' => $deposit->id,


                    'division_id' => $allocation->division_id,


                    'nominal_diterima' => $nominal,


                ]);









                /*
                |--------------------------------------------------------------------------
                | Update saldo divisi
                |--------------------------------------------------------------------------
                */


                $balance = DivisionBalance::firstOrCreate(



                    [


                        'project_id' => $deposit->project_id,


                        'division_id' => $allocation->division_id,


                    ],



                    [


                        'saldo' => 0


                    ]



                );







                $balance->increment(

                    'saldo',

                    $nominal

                );





            }



        });









        return redirect()

            ->back()

            ->with(

                'success',

                'Pembayaran berhasil disimpan, saldo bank dan divisi berhasil diperbarui'

            );



    }



}