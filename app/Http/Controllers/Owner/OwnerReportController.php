<?php

namespace App\Http\Controllers\Owner;


use Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;

use App\Exports\OwnerReportExport;
use App\Exports\ProjectReportExport;
use App\Exports\PerformanceReportExport;

use Maatwebsite\Excel\Facades\Excel;



class OwnerReportController extends Controller
{
public function index()
{


$totalPendapatan = ProjectDeposit::sum('jumlah_setoran');

$totalPengeluaran = ExpenseRequest::sum('jumlah');


$profit = $totalPendapatan - $totalPengeluaran;



$totalProject = Project::count();



$projectAktif = Project::where(
    'progres_keseluruhan',
    '<',
    100
)->count();



$totalBudget = Project::sum('total_anggaran');



$progressProject = Project::avg(
    'progres_keseluruhan'
) ?? 0;



$saldo = $profit;



// DATA MONITORING PROJECT
$projects = Project::latest()->get();



return view(
    'owner.reports.index',
    compact(
        'totalPendapatan',
        'totalPengeluaran',
        'profit',
        'totalProject',
        'projectAktif',
        'totalBudget',
        'progressProject',
        'saldo',
        'projects'
    )
);


}



/*
|--------------------------------------------------------------------------
| LAPORAN UMUM PDF
|--------------------------------------------------------------------------
*/


public function exportPdf()
{


$data = [

'totalPendapatan'=>ProjectDeposit::sum('jumlah_setoran'),


'totalPengeluaran'=>ExpenseRequest::sum('jumlah'),


'profit'=>

ProjectDeposit::sum('jumlah_setoran')
-
ExpenseRequest::sum('jumlah'),



'totalProject'=>Project::count(),



'projectAktif'=>Project::where(
    'progres_keseluruhan',
    '<',
    100
)->count(),



'totalBudget'=>Project::sum('total_anggaran'),



'progressProject'=>Project::avg(
    'progres_keseluruhan'
) ?? 0,



'saldo'=>

ProjectDeposit::sum('jumlah_setoran')
-
ExpenseRequest::sum('jumlah'),



'tanggal'=>Carbon::now(),



'projects'=>Project::latest()->get()


];




$pdf = app('dompdf.wrapper')
->loadView(
    'owner.reports.pdf',
    $data
);



return $pdf->download(
    'laporan-perusahaan.pdf'
);


}








/*
|--------------------------------------------------------------------------
| LAPORAN KEUANGAN
|--------------------------------------------------------------------------
*/


public function financePdf()
{


$data=[


'totalPendapatan'=>ProjectDeposit::sum('jumlah_setoran'),



'totalPengeluaran'=>ExpenseRequest::sum('jumlah'),



'saldo'=>

ProjectDeposit::sum('jumlah_setoran')
-
ExpenseRequest::sum('jumlah'),



'transaksi'=>ProjectDeposit::latest()->get()



];




$pdf=app('dompdf.wrapper')
->loadView(
    'owner.reports.pdf.finance',
    $data
);



return $pdf->download(
    'laporan-keuangan.pdf'
);


}




public function financeExcel()
{


return Excel::download(

new OwnerReportExport,

'laporan-keuangan-owner.xlsx'

);


}










/*
|--------------------------------------------------------------------------
| LAPORAN PROJECT
|--------------------------------------------------------------------------
*/


public function projectPdf()
{


$data=[


'projects'=>Project::latest()->get()



];



$pdf=app('dompdf.wrapper')
->loadView(
    'owner.reports.pdf.project',
    $data
);



return $pdf->download(
    'laporan-project.pdf'
);


}




public function projectExcel()
{


return Excel::download(

new ProjectReportExport,

'laporan-project.xlsx'

);


}









/*
|--------------------------------------------------------------------------
| LAPORAN PERFORMANCE
|--------------------------------------------------------------------------
*/


public function performancePdf()
{


$data=[



'totalProject'=>Project::count(),



'projectAktif'=>Project::where(
    'progres_keseluruhan',
    '<',
    100
)->count(),



'progress'=>Project::avg(
    'progres_keseluruhan'
) ?? 0



];




$pdf=app('dompdf.wrapper')
->loadView(
    'owner.reports.pdf.performance',
    $data
);



return $pdf->download(
    'analisis-performa.pdf'
);


}





public function performanceExcel()
{


return Excel::download(

new PerformanceReportExport,

'analisis-performa.xlsx'

);


}



}