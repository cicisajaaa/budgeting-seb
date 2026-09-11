<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransaksiDana;


use App\Exports\FinanceExpenseExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class FinanceExpenseController extends Controller
{
    /**
     * Daftar transaksi pengeluaran dana
     */
   public function index(Request $request)
{

    $query = TransaksiDana::with([

        'pengajuanDana.proyek.perusahaan',
        'pengajuanDana.divisi',
        'pengajuanDana.pengguna',
        'rekeningBank',

    ]);



    if($request->start_date && $request->end_date)
    {

        $query->whereBetween(
            'tanggal',
            [
                $request->start_date,
                $request->end_date
            ]
        );

    }




 $transactions = $query
    ->latest('tanggal')
    ->get();



    $totalExpense = $transactions->sum('jumlah');



    $totalTransaction = $transactions->count();





    $totalProject = $transactions

        ->pluck('pengajuanDana.proyek_id')

        ->unique()

        ->count();





    $totalBank = $transactions

        ->pluck('rekening_bank_id')

        ->unique()

        ->count();





    return view(

        'finance.expense.index',

        compact(

            'transactions',

            'totalExpense',

            'totalTransaction',

            'totalProject',

            'totalBank',

            'request'

        )

    );


}


    public function show($id)
{

    $transaction = TransaksiDana::with([

        'pengajuanDana.proyek.perusahaan',

        'pengajuanDana.divisi',

        'pengajuanDana.pengguna',

        'rekeningBank',

        'penyetuju'

    ])

    ->findOrFail($id);



    return view(

        'finance.expense.show',

        compact('transaction')

    );

}

public function exportExcel()
{


return Excel::download(

new FinanceExpenseExport,

'laporan-pengeluaran-dana.xlsx'

);


}


public function exportPdf(Request $request)
{
    $query = TransaksiDana::with([
        'pengajuanDana.proyek.perusahaan',
        'pengajuanDana.divisi',
        'pengajuanDana.pengguna',
        'rekeningBank',
        'penyetuju',
    ]);

    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    if ($request->filled('start_date')) {
        $query->whereDate('tanggal', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('tanggal', '<=', $request->end_date);
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL TRANSAKSI
    |--------------------------------------------------------------------------
    */

    $transactions = $query
        ->latest('tanggal')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    $totalExpense = $transactions->sum('jumlah');

    $totalTransaction = $transactions->count();


    /*
    |--------------------------------------------------------------------------
    | NAMA PERUSAHAAN
    |--------------------------------------------------------------------------
    */

    $companyName = 'NAMA PERUSAHAAN';

    $firstTransaction = $transactions->first();

    if (
        $firstTransaction &&
        $firstTransaction->pengajuanDana &&
        $firstTransaction->pengajuanDana->proyek &&
        $firstTransaction->pengajuanDana->proyek->perusahaan
    ) {
        $companyName =
            $firstTransaction
                ->pengajuanDana
                ->proyek
                ->perusahaan
                ->nama_perusahaan
                ?? 'NAMA PERUSAHAAN';
    }


    /*
    |--------------------------------------------------------------------------
    | PERIODE
    |--------------------------------------------------------------------------
    */

    if ($request->filled('start_date') && $request->filled('end_date')) {

        $period = \Carbon\Carbon::parse($request->start_date)
            ->format('d-m-Y')
            . ' s/d ' .
            \Carbon\Carbon::parse($request->end_date)
            ->format('d-m-Y');

    } elseif ($request->filled('start_date')) {

        $period =
            'Mulai ' .
            \Carbon\Carbon::parse($request->start_date)
                ->format('d-m-Y');

    } elseif ($request->filled('end_date')) {

        $period =
            'Sampai ' .
            \Carbon\Carbon::parse($request->end_date)
                ->format('d-m-Y');

    } else {

        $period = 'Seluruh Periode Transaksi';

    }


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'finance.expense.pdf',
        compact(
            'transactions',
            'totalExpense',
            'totalTransaction',
            'companyName',
            'period'
        )
    );


    $pdf->setPaper('a4', 'landscape');


    return $pdf->download(
        'laporan-pengeluaran-dana.pdf'
    );
}
}