<?php

namespace App\Http\Controllers;


use App\Models\SetoranProyek;
use App\Models\TransaksiDana;
use App\Models\MutasiKeuangan;
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


$mutasiQuery = MutasiKeuangan::with(
    'rekeningBank'
);


if($startDate && $endDate)
{
    $mutasiQuery->whereBetween(
        'tanggal',
        [
            $startDate,
            $endDate
        ]
    );
}


$mutasi = $mutasiQuery
    ->latest()
    ->get();






        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */
$totalMutasiMasuk = $mutasi
    ->where('jenis','masuk')
    ->sum('nominal');


$totalMutasiKeluar = $mutasi
    ->where('jenis','keluar')
    ->sum('nominal');


$totalIncome = $deposits->sum('jumlah_setoran');


$totalExpense = $expenses->sum('jumlah');

$totalCashIn =
    $totalIncome +
    $totalMutasiMasuk;


$totalCashOut =
    $totalExpense +
    $totalMutasiKeluar;


        /*
        |--------------------------------------------------------------------------
        | JUMLAH TRANSAKSI
        |--------------------------------------------------------------------------
        */


        $totalDepositTransaction =

            $deposits->count();



        $totalExpenseTransaction =

            $expenses->count();

$totalMutasiTransaction = $mutasi->count();





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


$totalBankSaldo = $banks->sum('saldo');


$totalSaldoSistem = $banks->sum(function($bank){

    return 
    ($bank->saldo_awal ?? 0)
        +
        $bank->mutasiKeuangan()
            ->where('jenis','masuk')
            ->sum('nominal')
        -
        $bank->mutasiKeuangan()
            ->where('jenis','keluar')
            ->sum('nominal');

});







           return view(
            
            'finance.report.index',

            compact(
                'deposits',
                'expenses',
                'totalBankSaldo',
                'totalSaldoSistem',
                'totalIncome',
                'totalExpense',
                'totalCashIn',
                'totalCashOut',
                'banks',
                'totalDepositTransaction',
                'totalExpenseTransaction',
                'totalMutasiTransaction',
                'mutasi',
                'totalMutasiMasuk',
                'totalMutasiKeluar',
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

public function reconciliation()
{
    $banks = RekeningBank::where(
        'status',
        true
    )->get();


$data = $banks->map(function($bank){


    $totalMasuk = $bank
        ->mutasiKeuangan()
        ->where('jenis','masuk')
        ->sum('nominal');


    $totalKeluar = $bank
        ->mutasiKeuangan()
        ->where('jenis','keluar')
        ->sum('nominal');



    // perhitungan saldo berdasarkan transaksi sistem
    $saldoSistem =
        $bank->saldo_awal
        + $totalMasuk
        - $totalKeluar;



    // saldo terakhir yang tersimpan pada rekening
    $saldoRekening = $bank->saldo;



  $selisih = round(
    $saldoRekening - $saldoSistem,
    0
);


return [
    'bank' => $bank,
    'saldo_sistem' => $saldoSistem,
    'saldo_rekening' => $saldoRekening,
    'selisih' => $selisih,
    'status' =>
        $selisih == 0
        ? 'Seimbang'
        : 'Perlu Pemeriksaan'
];

});


    return view(
        'finance.report.reconciliation',
        compact('data')
    );
}
}