<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;



class OwnerFinanceExport implements WithMultipleSheets
{


    protected $startDate;

    protected $endDate;





    public function __construct(
        $startDate = null,
        $endDate = null
    )
    {

        $this->startDate = $startDate;

        $this->endDate = $endDate;

    }








    public function sheets(): array
    {


        return [


            'Dashboard' => new DashboardSheet(
                $this->startDate,
                $this->endDate
            ),



            'Ringkasan Keuangan' => new FinanceSummarySheet(
                $this->startDate,
                $this->endDate
            ),




            'Transaksi Keuangan' => new FinanceTransactionSheet(
                $this->startDate,
                $this->endDate
            ),




            'Monitoring Project' => new FinanceProjectSheet(
                $this->startDate,
                $this->endDate
            ),



        ];


    }


}