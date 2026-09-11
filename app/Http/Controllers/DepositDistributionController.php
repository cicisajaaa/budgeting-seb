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
$totalTransaction = $distributions->count();


$totalDivision = $distributions
    ->pluck('divisi_id')
    ->unique()
    ->count();


$totalProject = $distributions
    ->pluck('setoranProyek.proyek_id')
    ->unique()
    ->count();




        return view(

            'finance.distribution.index',

            compact(

                'distributions',

                'totalDistribution',

                'totalTransaction',

                'totalDivision',

                'totalProject'


            )

        );


    }


}