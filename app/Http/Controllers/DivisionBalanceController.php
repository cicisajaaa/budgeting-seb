<?php

namespace App\Http\Controllers;


use App\Models\SaldoDivisi;



class DivisionBalanceController extends Controller
{


    public function index()
    {


        $balances = SaldoDivisi::with([

            'proyek',

            'divisi'

        ])

        ->latest()

        ->get();




        $totalSaldo = $balances->sum('saldo');





        return view(

            'finance.balance.index',

            compact(

                'balances',

                'totalSaldo'

            )

        );


    }


}