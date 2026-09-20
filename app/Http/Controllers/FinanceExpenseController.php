<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransaksiDana;
use App\Exports\FinanceExpenseExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Helpers\AuditHelper;

class FinanceExpenseController extends Controller
{
    private function checkRole()
    {
        if (
            !in_array(
                auth()->user()->role,
                [
                    'admin',
                    'keuangan',
                    'owner'
                ]
            )
        ) {
            abort(403);
        }
    }


    /**
     * |--------------------------------------------------------------------------
     * | DAFTAR TRANSAKSI PENGELUARAN
     * |--------------------------------------------------------------------------
     */
    public function index(Request $request)
    {
        $this->checkRole();

        $query = TransaksiDana::with([
            'pengajuanDana.proyek.perusahaan',
            'pengajuanDana.divisi',
            'pengajuanDana.pengguna',
            'rekeningBank'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        // Jika hanya tanggal mulai yang diisi
        if ($request->filled('start_date')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->start_date
            );

        }


        // Jika hanya tanggal akhir yang diisi
        if ($request->filled('end_date')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->end_date
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalExpense = $transactions->sum('jumlah');


        $totalTransaction = $transactions->count();


        $totalProject = $transactions
            ->pluck('pengajuanDana.proyek_id')
            ->filter()
            ->unique()
            ->count();


        $totalBank = $transactions
            ->pluck('rekening_bank_id')
            ->filter()
            ->unique()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

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


    /**
     * |--------------------------------------------------------------------------
     * | DETAIL TRANSAKSI
     * |--------------------------------------------------------------------------
     */
    public function show($id)
    {
        $this->checkRole();

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


    /**
     * |--------------------------------------------------------------------------
     * | EXPORT EXCEL
     * |--------------------------------------------------------------------------
     */
    public function exportExcel(Request $request)
    {
        $this->checkRole();

        AuditHelper::create(
            'EXPORT',
            'Laporan Finance',
            'Export laporan pengeluaran dana Excel'
        );


        return Excel::download(
            new FinanceExpenseExport(
                $request->start_date,
                $request->end_date
            ),
            'laporan-pengeluaran-dana.xlsx'
        );
    }


    /**
     * |--------------------------------------------------------------------------
     * | EXPORT PDF
     * |--------------------------------------------------------------------------
     */
    public function exportPdf(Request $request)
    {
        $this->checkRole();

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

            $query->whereDate(
                'tanggal',
                '>=',
                $request->start_date
            );

        }


        if ($request->filled('end_date')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->end_date
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalExpense = $transactions->sum('jumlah');

        $totalTransaction = $transactions->count();


        /*
        |--------------------------------------------------------------------------
        | NAMA PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $companyName = config('app.name');


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
                ?? $companyName;
        }


        /*
        |--------------------------------------------------------------------------
        | PERIODE LAPORAN
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('start_date') &&
            $request->filled('end_date')
        ) {

            $period =
                \Carbon\Carbon::parse(
                    $request->start_date
                )->format('d-m-Y')
                . ' s/d ' .
                \Carbon\Carbon::parse(
                    $request->end_date
                )->format('d-m-Y');

        } elseif ($request->filled('start_date')) {

            $period =
                'Mulai ' .
                \Carbon\Carbon::parse(
                    $request->start_date
                )->format('d-m-Y');

        } elseif ($request->filled('end_date')) {

            $period =
                'Sampai ' .
                \Carbon\Carbon::parse(
                    $request->end_date
                )->format('d-m-Y');

        } else {

            $period = 'Seluruh Periode Transaksi';
        }


        /*
        |--------------------------------------------------------------------------
        | AUDIT LOG
        |--------------------------------------------------------------------------
        */

        AuditHelper::create(
            'EXPORT',
            'Laporan Finance',
            'Export laporan pengeluaran dana PDF'
        );


        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
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


        $pdf->setPaper(
            'a4',
            'landscape'
        );


        return $pdf->download(
            'laporan-pengeluaran-dana.pdf'
        );
    }

}