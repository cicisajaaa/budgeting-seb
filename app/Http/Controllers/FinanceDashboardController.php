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


// ===============================
// TOTAL DANA MASUK
// ===============================

$totalDepositQuery = SetoranProyek::query();

if (!empty($bulan)) {
    $totalDepositQuery->whereMonth('tanggal_setoran', $bulan);
}

if (!empty($tahun)) {
    $totalDepositQuery->whereYear('tanggal_setoran', $tahun);
}

$totalDeposit = $totalDepositQuery->sum('jumlah_setoran');


// ===============================
// TOTAL PENGELUARAN
// ===============================

$totalExpenseQuery = TransaksiDana::query();

if (!empty($bulan)) {
    $totalExpenseQuery->whereMonth('tanggal', $bulan);
}

if (!empty($tahun)) {
    $totalExpenseQuery->whereYear('tanggal', $tahun);
}

$totalExpense = $totalExpenseQuery->sum('jumlah');
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

// ===============================
// FILTER PUBLIC FINANCE
// ===============================

$bulan = request('bulan');
$tahun = request('tahun');

// ===============================
// DETAIL DANA MASUK
// ===============================

$publicDepositsQuery = SetoranProyek::with('proyek');

if (!empty($bulan)) {
    $publicDepositsQuery->whereMonth('tanggal_setoran', $bulan);
}

if (!empty($tahun)) {
    $publicDepositsQuery->whereYear('tanggal_setoran', $tahun);
}

$publicDeposits = $publicDepositsQuery
    ->latest('tanggal_setoran')
    ->get();


// ===============================
// DETAIL PENGELUARAN
// ===============================

$publicExpensesQuery = TransaksiDana::with([
    'pengajuanDana.proyek',
    'pengajuanDana.divisi',
]);

if (!empty($bulan)) {
    $publicExpensesQuery->whereMonth('tanggal', $bulan);
}

if (!empty($tahun)) {
    $publicExpensesQuery->whereYear('tanggal', $tahun);
}

$publicExpenses = $publicExpensesQuery
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
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalSelesai = $request->input('tanggal_selesai');

    // Default: Ambil semua data ringkasan global
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
    // TABEL DETAIL (DENGAN FILTER PERIODE / BULAN / TAHUN)
    // ===============================
    $queryDeposits = SetoranProyek::with('proyek')->latest('tanggal_setoran');
    $queryExpenses = TransaksiDana::with(['pengajuanDana.proyek', 'pengajuanDana.divisi'])->latest('tanggal');

    // Terapkan Filter Rentang Tanggal jika diisi
    if ($tanggalMulai && $tanggalSelesai) {
        $queryDeposits->whereBetween('tanggal_setoran', [$tanggalMulai, $tanggalSelesai]);
        $queryExpenses->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
    } else {
        // Jika tidak pakai rentang tanggal, cek filter bulan/tahun biasa
        if ($filterBulan) {
            $queryDeposits->whereMonth('tanggal_setoran', $filterBulan);
            $queryExpenses->whereMonth('tanggal', $filterBulan);
        }

        if ($filterTahun) {
            $queryDeposits->whereYear('tanggal_setoran', $filterTahun);
            $queryExpenses->whereYear('tanggal', $filterTahun);
        }
    }

    $publicDeposits = $queryDeposits->paginate(10, ['*'], 'deposits_page')->withQueryString();
    $publicExpenses = $queryExpenses->paginate(10, ['*'], 'expenses_page')->withQueryString();
    
    // Rekap Keuangan Per Project
    $publicProjectFinance = Proyek::with([
        'setoranProyek', 'saldoDivisi', 'alokasiDivisi', 'tugas',
        'pengajuanDana.transaksiDana', 'pengajuanDana.divisi',
    ])->paginate(10, ['*'], 'projects_page')->withQueryString();

    // ===============================
    // CHART CASH FLOW (Dinamis Mengikuti Filter Tahun)
    // ===============================
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

    // --- TAMBAHKAN DI DALAM METHOD public() ---
    
    // Ambil semua proyek dengan relasi keuangan untuk dihitung status kesehatannya
    $allProjectsForHealth = Proyek::with(['setoranProyek', 'pengajuanDana.transaksiDana'])->get();
    
    $proyekSehat = 0;
    $proyekKritis = 0;

    foreach ($allProjectsForHealth as $proj) {
        $pExp = $proj->pengajuanDana->flatMap(fn($p) => $p->transaksiDana)->sum('jumlah');
        $pDep = $proj->setoranProyek->sum('jumlah_setoran');
        $pBal = $pDep - $pExp;
        
        // Jika sisa saldo kurang dari 10% dari anggaran atau minus, kategorikan kritis/perhatian
        $anggaran = $proj->total_anggaran > 0 ? $proj->total_anggaran : 1;
        $persenTerpakai = ($pExp / $anggaran) * 100;

        if ($pBal < 0 || $persenTerpakai >= 90) {
            $proyekKritis++;
        } else {
            $proyekSehat++;
        }
    }

    return view('dashboard.keuangan-public', compact(
        'totalDeposit', 'totalExpense', 'sisaDana', 'totalSaldoDivisi', 'totalSaldoBank',
        'totalTransaction', 'totalBudget', 'totalProject', 'expenseThisMonth',
        'publicDeposits', 'publicExpenses', 'publicProjectFinance', 'publicCashFlow',
        'tanggalMulai', 'tanggalSelesai'
    ));
}
public function export(Request $request)
{
    $filterBulan = $request->input('bulan');
    $filterTahun = $request->input('tahun');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalSelesai = $request->input('tanggal_selesai');
    $type = $request->input('type'); // 'pdf' atau 'excel'

    // 1. Ambil Data dengan Filter
    $queryDeposits = SetoranProyek::with('proyek')->latest('tanggal_setoran');
    $queryExpenses = TransaksiDana::with(['pengajuanDana.proyek', 'pengajuanDana.divisi'])->latest('tanggal');

    if ($tanggalMulai && $tanggalSelesai) {
        $queryDeposits->whereBetween('tanggal_setoran', [$tanggalMulai, $tanggalSelesai]);
        $queryExpenses->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
    } else {
        if ($filterBulan) {
            $queryDeposits->whereMonth('tanggal_setoran', $filterBulan);
            $queryExpenses->whereMonth('tanggal', $filterBulan);
        }

        if ($filterTahun) {
            $queryDeposits->whereYear('tanggal_setoran', $filterTahun);
            $queryExpenses->whereYear('tanggal', $filterTahun);
        }
    }

    $deposits = $queryDeposits->get();
    $expenses = $queryExpenses->get();

    // 2. Eksekusi Export
    if ($type === 'pdf') {
        $pdf = Pdf::loadView('dashboard.export-keuangan', compact('deposits', 'expenses', 'filterBulan', 'filterTahun', 'tanggalMulai', 'tanggalSelesai', 'type'));
        return $pdf->download('Laporan_Keuangan_SEB.pdf');
        
    } elseif ($type === 'excel') {
        $fileName = "Laporan_Keuangan_SEB.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        
        return view('dashboard.export-keuangan-excel', compact('deposits', 'expenses', 'filterBulan', 'filterTahun', 'tanggalMulai', 'tanggalSelesai', 'type'));
    }

    return redirect()->back();
}


}