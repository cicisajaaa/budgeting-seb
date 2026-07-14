<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\DepositDistribution;
use App\Models\DivisionBalance;
use Illuminate\Http\Request;


class FinanceDepositController extends Controller
{

    public function index()
    {

        $projects = Project::all();


        $deposits = ProjectDeposit::with('project')
            ->latest()
            ->get();



        return view(
            'finance.deposit.index',
            compact(
                'projects',
                'deposits'
            )
        );

    }




    public function store(Request $request)
    {


        $request->validate([

            'project_id' => 'required',

            'jumlah_setoran' => 'required|numeric',

            'tanggal_setoran' => 'required|date',

        ]);



        /*
        |--------------------------------------------------------------------------
        | Simpan pembayaran masuk
        |--------------------------------------------------------------------------
        */


        $deposit = ProjectDeposit::create([

            'project_id' => $request->project_id,

            'jumlah_setoran' => $request->jumlah_setoran,

            'tanggal_setoran' => $request->tanggal_setoran,

        ]);





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





            // Simpan histori distribusi

            DepositDistribution::create([

                'deposit_id' => $deposit->id,

                'division_id' => $allocation->division_id,

                'nominal_diterima' => $nominal,

            ]);





            // Update saldo divisi

            DivisionBalance::updateOrCreate(

                [

                    'project_id' => $deposit->project_id,

                    'division_id' => $allocation->division_id,

                ],


                [

                    'saldo' => \DB::raw(
                        "saldo + ".$nominal
                    )

                ]

            );



        }




        return redirect()
            ->back()
            ->with(
                'success',
                'Pembayaran berhasil disimpan dan dana otomatis didistribusikan'
            );


    }


}