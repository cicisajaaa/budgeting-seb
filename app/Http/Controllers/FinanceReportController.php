<?php

namespace App\Http\Controllers;

use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Exports\FinanceReportExport;
use Maatwebsite\Excel\Facades\Excel;

class FinanceReportController extends Controller
{


    public function index()
    {


        $deposits = ProjectDeposit::with('project')
            ->latest()
            ->get();



        $expenses = ExpenseTransaction::with([
            'request.project',
            'request.division',
            'approver'
        ])
        ->latest()
        ->get();



        $totalIncome = $deposits->sum(
            'jumlah_setoran'
        );



        $totalExpense = $expenses->sum(
            'jumlah'
        );



        $balance =
            $totalIncome - $totalExpense;



        return view(
            'finance.report.index',
            compact(
                'deposits',
                'expenses',
                'totalIncome',
                'totalExpense',
                'balance'
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