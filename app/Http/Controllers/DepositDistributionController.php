<?php

namespace App\Http\Controllers;


use App\Models\DepositDistribution;



class DepositDistributionController extends Controller
{


    public function index()
    {


        $distributions = DepositDistribution::with([

            'project',

            'division'

        ])

        ->latest()

        ->get();





        $totalDistribution = $distributions->sum('jumlah');





        return view(

            'finance.distribution.index',

            compact(

                'distributions',

                'totalDistribution'

            )

        );


    }



}