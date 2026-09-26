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
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

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




// ===============================
// PUBLIC FINANCE DETAIL
// ===============================

// Detail dana masuk
$publicDeposits = SetoranProyek::with('proyek')
    ->latest('tanggal_setoran')
    ->get();

// Detail pengeluaran
$publicExpenses = TransaksiDana::with([
    'pengajuanDana.proyek'
])
    ->latest('tanggal')
    ->get();


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
public function public(Request $request)
{
    // Ambil input filter dari URL
    $filterBulan = $request->input('bulan');
    $filterTahun = $request->input('tahun');

    // Default: Ambil semua data (Ringkasan tetap global kecuali difilter spesifik)
    $totalDeposit = SetoranProyek::sum('jumlah_setoran');
    $totalExpense = TransaksiDana::sum('jumlah');
    $totalSaldoBank = RekeningBank::sum('saldo');
    $sisaDana = $totalSaldoBank;
    $totalSaldoDivisi = SaldoDivisi::sum('saldo');
    $totalTransaction = TransaksiDana::count() + SetoranProyek::count();
    $totalBudget = Proyek::sum('total_anggaran');
    $totalProject = Proyek::count();
    $expenseThisMonth = TransaksiDana::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->sum('jumlah');

    // ===============================
    // TABEL DETAIL (DENGAN FILTER)
    // ===============================
    $queryDeposits = SetoranProyek::with('proyek')->latest('tanggal_setoran');
    $queryExpenses = TransaksiDana::with(['pengajuanDana.proyek', 'pengajuanDana.divisi'])->latest('tanggal');

    // Terapkan Filter jika ada parameter 'bulan'
    if ($filterBulan) {
        $queryDeposits->whereMonth('tanggal_setoran', $filterBulan);
        $queryExpenses->whereMonth('tanggal', $filterBulan);
    }

    // Terapkan Filter jika ada parameter 'tahun'
    if ($filterTahun) {
        $queryDeposits->whereYear('tanggal_setoran', $filterTahun);
        $queryExpenses->whereYear('tanggal', $filterTahun);
    }

  $publicDeposits = $queryDeposits->paginate(10, ['*'], 'deposits_page')->withQueryString();
    $publicExpenses = $queryExpenses->paginate(10, ['*'], 'expenses_page')->withQueryString();
// Rekap Keuangan Per Project (Gunakan Paginate, bukan Get)
    $publicProjectFinance = Proyek::with([
        'setoranProyek', 'saldoDivisi', 'alokasiDivisi', 'tugas',
        'pengajuanDana.transaksiDana', 'pengajuanDana.divisi',
    ])->paginate(10, ['*'], 'projects_page')->withQueryString();
   // ===============================
    // CHART CASH FLOW (Dinamis Mengikuti Filter Tahun)
    // ===============================
    // Gunakan tahun dari filter, jika tidak ada, gunakan tahun ini
    $tahunChart = $filterTahun ? $filterTahun : Carbon::now()->year;

    $monthlyIncome = SetoranProyek::whereYear('tanggal_setoran', $tahunChart)
        ->select(DB::raw('MONTH(tanggal_setoran) as bulan'), DB::raw('SUM(jumlah_setoran) as total'))
        ->groupBy('bulan')->pluck('total', 'bulan');

    $monthlyExpense = TransaksiDana::whereYear('tanggal', $tahunChart)
        ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('SUM(jumlah) as total'))
        ->groupBy('bulan')->pluck('total', 'bulan');

    $publicCashFlow = [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        'income' => collect(range(1, 12))->map(fn($bulan) => $monthlyIncome[$bulan] ?? 0),
        'expense' => collect(range(1, 12))->map(fn($bulan) => $monthlyExpense[$bulan] ?? 0),
    ];

    return view('dashboard.keuangan-public', compact(
        'totalDeposit', 'totalExpense', 'sisaDana', 'totalSaldoDivisi', 'totalSaldoBank',
        'totalTransaction', 'totalBudget', 'totalProject', 'expenseThisMonth',
        'publicDeposits', 'publicExpenses', 'publicProjectFinance', 'publicCashFlow'
    ));
}

public function export(Request $request)
    {
        $filterBulan = $request->input('bulan');
        $filterTahun = $request->input('tahun');
        $type = $request->input('type'); // 'pdf' atau 'excel'

        // 1. Ambil Data (Bisa difilter)
        $queryDeposits = SetoranProyek::with('proyek')->latest('tanggal_setoran');
        $queryExpenses = TransaksiDana::with(['pengajuanDana.proyek', 'pengajuanDana.divisi'])->latest('tanggal');

        if ($filterBulan) {
            $queryDeposits->whereMonth('tanggal_setoran', $filterBulan);
            $queryExpenses->whereMonth('tanggal', $filterBulan);
        }

        if ($filterTahun) {
            $queryDeposits->whereYear('tanggal_setoran', $filterTahun);
            $queryExpenses->whereYear('tanggal', $filterTahun);
        }

        $deposits = $queryDeposits->get();
        $expenses = $queryExpenses->get();



   // 2. Eksekusi Export
        if ($type === 'pdf') {
            // Render PDF memanggil file export-keuangan
            $pdf = Pdf::loadView('dashboard.export-keuangan', compact('deposits', 'expenses', 'filterBulan', 'filterTahun', 'type'));
            return $pdf->download('Laporan_Keuangan_SEB.pdf');
            
        } elseif ($type === 'excel') {
            $fileName = "Laporan_Keuangan_SEB.xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            
            // 👇 PERHATIKAN BARIS INI: Harus ada tambahan -excel 👇
            return view('dashboard.export-keuangan-excel', compact('deposits', 'expenses', 'filterBulan', 'filterTahun', 'type'));
        }

        return redirect()->back();
    }



}