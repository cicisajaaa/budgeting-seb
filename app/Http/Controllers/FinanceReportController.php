<?php

namespace App\Http\Controllers;


use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\BankAccount;

use App\Exports\FinanceReportExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;



class FinanceReportController extends Controller
{


    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */


        $startDate = $request->start_date;

        $endDate = $request->end_date;







        /*
        |--------------------------------------------------------------------------
        | PEMASUKAN
        |--------------------------------------------------------------------------
        */


        $depositQuery = ProjectDeposit::with([

            'project',

            'bank'

        ]);





        if($startDate && $endDate)
        {

            $depositQuery->whereBetween(

                'tanggal',

                [
                    $startDate,
                    $endDate
                ]

            );

        }







        $deposits = $depositQuery

            ->latest()

            ->get();









        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN
        |--------------------------------------------------------------------------
        */


        $expenseQuery = ExpenseTransaction::with([

            'request.project',

            'request.division',

            'request.user',

            'request.approver',

            'approver',

            'bank'

        ]);





        if($startDate && $endDate)
        {

            $expenseQuery->whereBetween(

                'tanggal',

                [
                    $startDate,
                    $endDate
                ]

            );

        }








        $expenses = $expenseQuery

            ->latest()

            ->get();









        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */


        $totalIncome = $deposits->sum(

            'jumlah_setoran'

        );






        $totalExpense = $expenses->sum(

            'jumlah'

        );






        $balance =

            $totalIncome - $totalExpense;









        /*
        |--------------------------------------------------------------------------
        | JUMLAH TRANSAKSI
        |--------------------------------------------------------------------------
        */


        $totalDepositTransaction = $deposits->count();


        $totalExpenseTransaction = $expenses->count();









        /*
        |--------------------------------------------------------------------------
        | SALDO BANK
        |--------------------------------------------------------------------------
        */


        $banks = BankAccount::where(

            'status',

            true

        )
        ->get();









        return view(

            'finance.report.index',

            compact(

                'deposits',

                'expenses',

                'totalIncome',

                'totalExpense',

                'balance',

                'banks',

                'totalDepositTransaction',

                'totalExpenseTransaction',

                'startDate',

                'endDate'

            )

        );


    }









    public function exportExcel(Request $request)
    {


        return Excel::download(

            new FinanceReportExport(

                $request->start_date,

                $request->end_date

            ),

            'Laporan_Keuangan.xlsx'

        );


    }



}