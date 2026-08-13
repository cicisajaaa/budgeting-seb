<?php

namespace App\Http\Controllers\Owner;


use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Models\Proyek;
use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;


use App\Exports\OwnerFinanceExport;
use App\Exports\ProjectReportExport;
use App\Exports\PerformanceReportExport;


use App\Helpers\AuditHelper;


use Maatwebsite\Excel\Facades\Excel;



class OwnerReportController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN OWNER
    |--------------------------------------------------------------------------
    */


    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | FILTER KEUANGAN
        |--------------------------------------------------------------------------
        */


        $totalPendapatan = ProjectDeposit::when(

            $request->start_date,

            function($query) use ($request){

                $query->whereDate(
                    'tanggal_setoran',
                    '>=',
                    $request->start_date
                );

            }

        )
        ->when(

            $request->end_date,

            function($query) use ($request){

                $query->whereDate(
                    'tanggal_setoran',
                    '<=',
                    $request->end_date
                );

            }

        )
        ->sum('jumlah_setoran');





        $totalPengeluaran = ExpenseRequest::where(
    'status',
    'approved'
)
->when(

            $request->start_date,

            function($query) use ($request){

                $query->whereDate(
                    'created_at',
                    '>=',
                    $request->start_date
                );

            }

        )
        ->when(

            $request->end_date,

            function($query) use ($request){

                $query->whereDate(
                    'created_at',
                    '<=',
                    $request->end_date
                );

            }

        )
        ->sum('jumlah');






        $totalTransaksi = 

            ProjectDeposit::when(

                $request->start_date,

                function($query) use ($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '>=',
                        $request->start_date
                    );

                }

            )
            ->when(

                $request->end_date,

                function($query) use ($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '<=',
                        $request->end_date
                    );

                }

            )
            ->count()


            +


            ExpenseRequest::when(

                $request->start_date,

                function($query) use ($request){

                    $query->whereDate(
                        'created_at',
                        '>=',
                        $request->start_date
                    );

                }

            )
            ->when(

                $request->end_date,

                function($query) use ($request){

                    $query->whereDate(
                        'created_at',
                        '<=',
                        $request->end_date
                    );

                }

            )
            ->count();






        $profit = 
            $totalPendapatan 
            -
            $totalPengeluaran;








        /*
        |--------------------------------------------------------------------------
        | DATA PROJECT
        |--------------------------------------------------------------------------
        */


        $projects = Proyek::with('tugas')

            ->when(

                $request->start_date,

                function($query) use ($request){

                    $query->whereDate(
                        'created_at',
                        '>=',
                        $request->start_date
                    );

                }

            )

            ->when(

                $request->end_date,

                function($query) use ($request){

                    $query->whereDate(
                        'created_at',
                        '<=',
                        $request->end_date
                    );

                }

            )

            ->latest()

            ->get();








        $totalProject = $projects->count();




        $totalProjectSelesai = $projects

            ->where(
                'progres_keseluruhan',
                100
            )

            ->count();






        $totalProjectTerlambat = $projects

            ->filter(function($project){


                if(!$project->tanggal_selesai){

                    return false;

                }



                return now()->gt(
                    $project->tanggal_selesai
                )

                &&

                $project->progres_keseluruhan < 100;



            })

            ->count();







        $rataProgress = $projects->avg(
            'progres_keseluruhan'
        );







        $projectAktif = $projects

            ->where(
                'progres_keseluruhan',
                '<',
                100
            )

            ->count();






        $progressProject = $projects->avg(function($project){

            return $project->progres_keseluruhan;

        }) ?? 0;







        $saldo = $profit;





$totalBudget = $projects->sum(
    'total_anggaran'
);


$totalAnggaranProject = $totalBudget;


        $totalProjectBerjalan = $projects

            ->filter(function($project){

                return 

                $project->progres_keseluruhan > 0

                &&

                $project->progres_keseluruhan < 100;


            })

            ->count();







        $efisiensiDana = 0;



        if($totalAnggaranProject > 0)

        {

            $efisiensiDana =

            ($saldo / $totalAnggaranProject) * 100;

        }







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

                'projects',

                'totalProjectSelesai',

                'totalProjectTerlambat',

                'rataProgress',

                'totalAnggaranProject',

                'totalProjectBerjalan',

                'efisiensiDana',

                'totalTransaksi'

            )

        );


    }







    /*
    |--------------------------------------------------------------------------
    | EXPORT LAPORAN UMUM PDF
    |--------------------------------------------------------------------------
    */
public function exportPdf(Request $request)
{


    /*
    |--------------------------------------------------------------------------
    | DATA PROJECT
    |--------------------------------------------------------------------------
    */


    $projects = Proyek::with('tugas')

        ->latest()

        ->get();





    /*
    |--------------------------------------------------------------------------
    | TOTAL KEUANGAN
    |--------------------------------------------------------------------------
    */


    $totalPendapatan = ProjectDeposit::sum(
        'jumlah_setoran'
    );




    $totalPengeluaran = ExpenseRequest::sum(
        'jumlah'
    );






    /*
    |--------------------------------------------------------------------------
    | DATA LAPORAN
    |--------------------------------------------------------------------------
    */


    $data = [


        'totalPendapatan'=>$totalPendapatan,



        'totalPengeluaran'=>$totalPengeluaran,



        'profit'=>

            $totalPendapatan
            -
            $totalPengeluaran,



        'totalProject'=>$projects->count(),

'projectAktif'=>$projects->filter(function($project){


    return $project->progres_keseluruhan > 0 
        && 
        $project->progres_keseluruhan < 100;


})->count(),





        'totalBudget'=>$projects->sum(

            'total_anggaran'

        ),






        'progressProject'=>$projects->avg(function($project){


            return $project->progres_keseluruhan;


        }) ?? 0,






        'saldo'=>

            $totalPendapatan
            -
            $totalPengeluaran,






        'tanggal'=>Carbon::now(),






        'projects'=>$projects,



    ];







    AuditHelper::create(

        'Export Laporan Perusahaan',

        'Laporan Owner',

        'Owner melakukan export laporan perusahaan PDF'

    );








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
    | LAPORAN KEUANGAN PDF
    |--------------------------------------------------------------------------
    */

public function financePdf(Request $request)
{

    Carbon::setLocale('id');


    /*
    |--------------------------------------------------------------------------
    | DATA PEMASUKAN
    |--------------------------------------------------------------------------
    */

    $pendapatan = ProjectDeposit::with('proyek')

        ->when(
            $request->start_date,

            function($query) use ($request){

                $query->whereDate(
                    'tanggal_setoran',
                    '>=',
                    $request->start_date
                );

            }

        )

        ->when(
            $request->end_date,

            function($query) use ($request){

                $query->whereDate(
                    'tanggal_setoran',
                    '<=',
                    $request->end_date
                );

            }

        )

        ->latest()

        ->get();





    /*
    |--------------------------------------------------------------------------
    | DATA PENGELUARAN
    |--------------------------------------------------------------------------
    */

    $pengeluaran = ExpenseRequest::where(
        'status',
        'approved'
    )

    ->when(
        $request->start_date,

        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );

        }

    )

    ->when(
        $request->end_date,

        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );

        }

    )

    ->latest()

    ->get();







    /*
    |--------------------------------------------------------------------------
    | GABUNG TRANSAKSI
    |--------------------------------------------------------------------------
    */


    $transaksi = collect();





    foreach($pendapatan as $item)
    {

        $transaksi->push([

            'tanggal'=>$item->tanggal_setoran,

            'keterangan'=>'Setoran Project',

            'project'=>$item->proyek->nama_proyek ?? '-',

            'nominal'=>$item->jumlah_setoran,

            'jenis'=>'Pemasukan'

        ]);

    }







    foreach($pengeluaran as $item)
    {

        $transaksi->push([

            'tanggal'=>$item->created_at,

            'keterangan'=>$item->judul ?? 'Pengeluaran Operasional',

            'project'=>$item->proyek->nama_proyek ?? '-',

            'nominal'=>$item->jumlah,

            'jenis'=>'Pengeluaran'

        ]);

    }







    $transaksi = $transaksi

        ->sortByDesc('tanggal')

        ->values();







    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */


    $totalPendapatan = $pendapatan->sum(
        'jumlah_setoran'
    );



    $totalPengeluaran = $pengeluaran->sum(
        'jumlah'
    );





    $saldo = 

        $totalPendapatan 
        -
        $totalPengeluaran;







   $data = [


    'totalPendapatan'=>$totalPendapatan,


    'totalPengeluaran'=>$totalPengeluaran,


    'saldo'=>$saldo,


    'transaksi'=>$transaksi,


    'totalTransaksi'=>$transaksi->count(),


    'tanggal'=>Carbon::now(),


];







    AuditHelper::create(

        'Export Laporan Keuangan',

        'Laporan Owner',

        'Owner melakukan export laporan keuangan PDF'

    );







    $pdf = app('dompdf.wrapper')

        ->loadView(

            'owner.reports.pdf.finance',

            $data

        );







    return $pdf->download(

        'laporan-keuangan.pdf'

    );


}








    /*
    |--------------------------------------------------------------------------
    | LAPORAN KEUANGAN EXCEL MULTI SHEET
    |--------------------------------------------------------------------------
    */

public function financeExcel(Request $request)
{


    AuditHelper::create(

        'Export Excel Keuangan',

        'Laporan Owner',

        'Owner melakukan export laporan keuangan Excel'

    );




    return Excel::download(

        new OwnerFinanceExport(
            $request->start_date,
            $request->end_date
        ),

        'laporan-keuangan-owner.xlsx'

    );


}







    /*
    |--------------------------------------------------------------------------
    | LAPORAN PROJECT PDF
    |--------------------------------------------------------------------------
    */
public function projectPdf(Request $request)
{


$projects = Proyek::with('tugas')

    ->when(
        $request->start_date,
        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );

        }
    )

    ->when(
        $request->end_date,
        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );

        }
    )

    ->latest()

    ->get();



$data=[

    'projects'=>$projects

];


AuditHelper::create(

    'Export Laporan Project',

    'Laporan Owner',

    'Owner melakukan export laporan project PDF'

);



$pdf = app('dompdf.wrapper')

    ->loadView(

        'owner.reports.pdf.project',

        $data

    );



return $pdf->download(

    'laporan-project.pdf'

);


}





    /*
    |--------------------------------------------------------------------------
    | LAPORAN PROJECT EXCEL
    |--------------------------------------------------------------------------
    */


    public function projectExcel(Request $request)
{


return Excel::download(

    new ProjectReportExport(

        $request->start_date,

        $request->end_date

    ),

    'laporan-project.xlsx'

);


}









    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE PDF
    |--------------------------------------------------------------------------
    */

public function performancePdf(Request $request)
{


$projects = Proyek::with('tugas')

    ->when(
        $request->start_date,
        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );

        }
    )

    ->when(
        $request->end_date,
        function($query) use ($request){

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );

        }
    )

    ->latest()

    ->get();



$data=[


    'totalProject'=>$projects->count(),


'projectAktif'=>$projects->filter(function($project){


    return $project->progres_keseluruhan > 0 
        && 
        $project->progres_keseluruhan < 100;


})->count(),



    'progress'=>$projects->avg(function($project){

        return $project->progres_keseluruhan;

    }) ?? 0,


];


$pdf = app('dompdf.wrapper')

    ->loadView(

        'owner.reports.pdf.performance',

        $data

    );


return $pdf->download(

    'analisis-performa.pdf'

);


}




    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE EXCEL
    |--------------------------------------------------------------------------
    */

public function performanceExcel(Request $request)
{

    AuditHelper::create(

        'Export Excel Performance',

        'Laporan Owner',

        'Owner melakukan export analisis performa Excel'

    );


    return Excel::download(

        new PerformanceReportExport(

            $request->start_date,

            $request->end_date

        ),

        'analisis-performa.xlsx'

    );

}

}