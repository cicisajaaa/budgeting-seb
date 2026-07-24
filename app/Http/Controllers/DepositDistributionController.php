<?php

namespace App\Http\Controllers;


use App\Models\DepositDistribution;



class DepositDistributionController extends Controller
{


    public function index()
    {


        $distributions = DepositDistribution::with([

            'setoranProyek.proyek',

            'divisi'

        ])

        ->latest()

        ->get();




        $totalDistribution = $distributions->sum(
            'nominal_diterima'
        );





        return view(

            'finance.distribution.index',

            compact(

                'distributions',

                'totalDistribution'

            )

        );


    }


}