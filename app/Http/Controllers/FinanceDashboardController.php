<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\SetoranProyek;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;

use App\Models\LogAudit;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class FinanceDashboardController extends Controller
{


    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | FINANCE SUMMARY
        |--------------------------------------------------------------------------
        */


        // Total dana masuk
        $totalDeposit = SetoranProyek::sum('jumlah_setoran');;



        // Total pengeluaran yang sudah disetujui
$totalExpense = TransaksiDana::sum('jumlah');

// Saldo aktif rekening perusahaan
$totalSaldoBank = RekeningBank::sum('saldo');

$totalSaldoSistem = RekeningBank::sum('saldo_awal')
    +
    DB::table('mutasi_keuangan')
        ->where('jenis','masuk')
        ->sum('nominal')
    -
    DB::table('mutasi_keuangan')
        ->where('jenis','keluar')
        ->sum('nominal');

// Alias untuk card dashboard
$sisaDana = $totalSaldoBank;


// Total saldo seluruh divisi
$totalSaldoDivisi = SaldoDivisi::sum('saldo');


// Total transaksi keuangan
$totalTransaction =
    TransaksiDana::count()
    +
    SetoranProyek::count();
        /*
        |--------------------------------------------------------------------------
        | APPROVAL
        |--------------------------------------------------------------------------
        */


        $totalApprovalPending = PengajuanDana::where(
            'status',
            'pending'
        )
        ->count();


$totalApprovalApproved = PengajuanDana::whereIn(
    'status',
    [
        'approved',
        'selesai'
    ]
)
->count();


        $totalApprovalRejected = PengajuanDana::where(
            'status',
            'rejected'
        )
        ->count();





        /*
        |--------------------------------------------------------------------------
        | PROJECT
        |--------------------------------------------------------------------------
        */


        $totalProject = Proyek::count();



        $totalBudget = Proyek::sum(
            'total_anggaran'
        );



        $totalProjectProgress = round(
        Proyek::with('tugas')
        ->get()
        ->filter(function($project){

            return $project->tugas->count() > 0;

        })
        ->avg(function($project){

            return $project->tugas->avg('progres_persen');

        }) ?? 0
    );





        /*
        |--------------------------------------------------------------------------
        | MONTHLY EXPENSE
        |--------------------------------------------------------------------------
        */


$expenseThisMonth = TransaksiDana::whereMonth(
        'tanggal',
        Carbon::now()->month
    )
    ->whereYear(
        'tanggal',
        Carbon::now()->year
    )
    ->sum('jumlah');







        /*
        |--------------------------------------------------------------------------
        | RECENT DATA
        |--------------------------------------------------------------------------
        */


$recentApproval = PengajuanDana::with([
    'pengguna',
    'proyek'
])
->where(
    'status',
    'pending'
)
->latest()
->take(5)
->get();



$recentExpenses = TransaksiDana::with([
    'pengajuanDana.pengguna',
    'pengajuanDana.proyek'
])
->latest('tanggal')
->take(5)
->get();




        $recentDeposits = TransaksiDana::latest()
        ->take(5)
        ->get();





        $recentAudit = LogAudit::with(
            'pengguna'
        )
        ->latest()
        ->take(5)
        ->get();



// ===============================
// CHART CASH FLOW
// ===============================
$monthlyIncome = SetoranProyek::select(

    DB::raw('MONTH(tanggal_setoran) as bulan'),

    DB::raw('SUM(jumlah_setoran) as total')

)

->groupBy('bulan')

->orderBy('bulan')

->pluck('total','bulan');

$monthlyExpense = TransaksiDana::select(

    DB::raw('MONTH(tanggal) as bulan'),

    DB::raw('SUM(jumlah) as total')

)

->groupBy('bulan')

->orderBy('bulan')

->pluck('total','bulan');
   



$cashFlowChart = [

    'labels'=>[
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    ],


    'income'=>collect(range(1,12))
        ->map(function($bulan) use($monthlyIncome){

            return $monthlyIncome[$bulan] ?? 0;

        }),


    'expense'=>collect(range(1,12))
        ->map(function($bulan) use($monthlyExpense){

            return $monthlyExpense[$bulan] ?? 0;

        })

];


        return view(
            'dashboard.keuangan',
            compact(

                'totalDeposit',

                'totalExpense',

                'sisaDana',

                'totalSaldoDivisi',

                'totalSaldoBank',

                'totalTransaction',
                
                'totalSaldoSistem',

                'totalApprovalPending',

                'totalApprovalApproved',

                'totalApprovalRejected',

                'totalBudget',

                'totalProject',

                'totalProjectProgress',

                'expenseThisMonth',

                'recentApproval',

                'recentExpenses',

                'recentDeposits',

                'recentAudit',
                
                'cashFlowChart'

            )
        );

    }


}