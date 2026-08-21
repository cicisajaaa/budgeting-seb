<?php

namespace App\Http\Controllers;


use App\Models\SaldoDivisi;
use App\Models\DistribusiSetoran;


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





    foreach($balances as $balance)
    {

        $balance->jumlah_distribusi = DistribusiSetoran::where(

            'divisi_id',

            $balance->divisi_id

        )

        ->whereHas('setoranProyek', function($query) use ($balance){

            $query->where(

                'proyek_id',

                $balance->proyek_id

            );

        })

        ->count();


    }





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