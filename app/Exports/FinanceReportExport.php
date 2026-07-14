<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class FinanceReportExport implements WithMultipleSheets
{


    public function sheets(): array
    {

        return [

            new IncomeSheet(),

            new ExpenseSheet(),

            new BalanceSheet(),

        ];

    }


}