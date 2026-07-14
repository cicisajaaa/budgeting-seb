<?php

namespace App\Http\Controllers;

use App\Models\DepositDistribution;


class DepositDistributionController extends Controller
{

    public function index()
    {

        $distributions = DepositDistribution::with([
            'deposit.project',
            'division'
        ])
        ->latest()
        ->get();


        return view(
            'finance.distribution.index',
            compact('distributions')
        );

    }

}