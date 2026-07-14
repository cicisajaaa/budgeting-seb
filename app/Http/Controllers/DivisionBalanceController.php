<?php

namespace App\Http\Controllers;

use App\Models\DivisionBalance;


class DivisionBalanceController extends Controller
{


    public function index()
    {


        $balances = DivisionBalance::with([
            'project',
            'division'
        ])
        ->get();



        return view(
            'finance.balance.index',
            compact('balances')
        );


    }


}