<?php

namespace App\Http\Controllers;


use App\Models\SetoranProyek;
use App\Models\TransaksiDana;
use App\Models\RekeningBank;

use App\Exports\FinanceReportExport;

use Illuminate\Http\Request;

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


        $depositQuery = SetoranProyek::with([

            'proyek',

            'rekeningBank'

        ]);





        if($startDate && $endDate)
        {


            $depositQuery->whereBetween(

                'tanggal_setoran',

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


        $expenseQuery = TransaksiDana::with([


            'pengajuanDana.proyek',


            'pengajuanDana.divisi',


            'pengajuanDana.pengguna',


            'penyetuju',


            'rekeningBank'


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

            $totalIncome

            -

            $totalExpense;









        /*
        |--------------------------------------------------------------------------
        | JUMLAH TRANSAKSI
        |--------------------------------------------------------------------------
        */


        $totalDepositTransaction =

            $deposits->count();



        $totalExpenseTransaction =

            $expenses->count();









        /*
        |--------------------------------------------------------------------------
        | SALDO BANK
        |--------------------------------------------------------------------------
        */


        $banks = RekeningBank::where(

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