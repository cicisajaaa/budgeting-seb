<?php

namespace App\Http\Controllers;


use App\Models\DistribusiSetoran;



class DepositDistributionController extends Controller
{


    public function index()
    {


        $distributions = DistribusiSetoran::with([

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