<?php

namespace App\Http\Controllers;


use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\BankAccount;

use App\Exports\FinanceReportExport;

use Maatwebsite\Excel\Facades\Excel;



class FinanceReportController extends Controller
{


    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | DATA PEMASUKAN
        |--------------------------------------------------------------------------
        */


        $deposits = ProjectDeposit::with([

            'project',

            'bank'

        ])
        ->latest()
        ->get();








        /*
        |--------------------------------------------------------------------------
        | DATA PENGELUARAN
        |--------------------------------------------------------------------------
        */


        $expenses = ExpenseTransaction::with([

            'request.project',

            'request.division',

            'approver',

            'bank'

        ])
        ->latest()
        ->get();









        /*
        |--------------------------------------------------------------------------
        | TOTAL KEUANGAN
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
        | DATA REKENING BANK AKTIF
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

                'banks'

            )

        );


    }









    public function exportExcel()
    {


        return Excel::download(

            new FinanceReportExport,

            'Laporan_Keuangan.xlsx'

        );


    }



}