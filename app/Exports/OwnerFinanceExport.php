<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;



class OwnerFinanceExport implements WithMultipleSheets
{


    public function sheets(): array
    {


        return [

            'Dashboard' => new DashboardSheet(),
            
            'Ringkasan Keuangan' => new FinanceSummarySheet(),


            'Transaksi Keuangan' => new FinanceTransactionSheet(),


            'Monitoring Project' => new FinanceProjectSheet(),


        ];


    }


}