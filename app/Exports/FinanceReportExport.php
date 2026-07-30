<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class FinanceReportExport implements WithMultipleSheets
{

    protected $startDate;
    protected $endDate;


    public function __construct($startDate=null,$endDate=null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }



    public function sheets(): array
    {

        return [

            new DashboardSheet(
                $this->startDate,
                $this->endDate
            ),

            new IncomeSheet(
                $this->startDate,
                $this->endDate
            ),

            new ExpenseSheet(
                $this->startDate,
                $this->endDate
            ),

            new BalanceSheet(),

            new BankBalanceSheet(),

            new ApprovalSheet(),

        ];

    }

}