<?php

namespace App\Http\Controllers\Owner;


use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;


use App\Models\Proyek;
use App\Models\SetoranProyek;
use App\Models\TransaksiDana;


use App\Exports\OwnerFinanceExport;
use App\Exports\ProjectReportExport;
use App\Exports\PerformanceReportExport;


use App\Helpers\AuditHelper;

use Barryvdh\DomPDF\Facade\Pdf;

use Maatwebsite\Excel\Facades\Excel;




class OwnerReportController extends Controller
{


    private function checkRole()
    {

        if(
            !in_array(
                Auth::user()->role,
                [
                    'owner',
                    'admin'
                ]
            )
        )
        {
            abort(403);
        }

    }









    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN OWNER
    |--------------------------------------------------------------------------
    */


    public function index(Request $request)
    {

        $this->checkRole();


if ($request->periode === 'bulan' && $request->bulan && $request->tahun) {

    $startDate = Carbon::create(
        $request->tahun,
        $request->bulan,
        1
    )->startOfMonth();

    $endDate = Carbon::create(
        $request->tahun,
        $request->bulan,
        1
    )->endOfMonth();

    $request->merge([
        'start_date' => $startDate->format('Y-m-d'),
        'end_date' => $endDate->format('Y-m-d'),
    ]);
}

if ($request->periode === 'tahun' && $request->tahun) {

    $request->merge([
        'start_date' => Carbon::create(
            $request->tahun,
            1,
            1
        )->startOfYear()->format('Y-m-d'),

        'end_date' => Carbon::create(
            $request->tahun,
            12,
            31
        )->endOfYear()->format('Y-m-d'),
    ]);
}
        $totalPendapatan = SetoranProyek::query()

            ->when(
                $request->start_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '<=',
                        $request->end_date
                    );

                }
            )

            ->sum('jumlah_setoran');








        $totalPengeluaran = TransaksiDana::query()

            ->when(
                $request->start_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal',
                        '<=',
                        $request->end_date
                    );

                }
            )

            ->sum('jumlah');









        $totalTransaksi =

            SetoranProyek::query()

            ->when(
                $request->start_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal_setoran',
                        '<=',
                        $request->end_date
                    );

                }
            )

            ->count()



            +

            TransaksiDana::query()

            ->when(
                $request->start_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function($query) use($request){

                    $query->whereDate(
                        'tanggal',
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









        $projects = Proyek::query()

            ->when(
                $request->start_date,
                function($query) use($request){

                    $query->whereDate(
                        'created_at',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function($query) use($request){

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

            ->filter(function($project){

                return (int)$project->progres_keseluruhan >= 100;

            })

            ->count();








        $totalProjectTerlambat = $projects

            ->filter(function($project){

                return

                $project->tanggal_selesai

                &&

                now()->gt(
                    $project->tanggal_selesai
                )

                &&

                $project->progres_keseluruhan < 100;

            })

            ->count();









        $rataProgress = $projects->avg(function($project){

            return (float)$project->progres_keseluruhan;

        }) ?? 0;









        $projectAktif = $projects

            ->filter(function($project){

                return

                $project->progres_keseluruhan > 0

                &&

                $project->progres_keseluruhan < 100;

            })

            ->count();


$totalProjectBerjalan = $projectAktif;

$saldo = $totalPendapatan - $totalPengeluaran;






        $totalAnggaranProject = $projects->sum(function($project){

            return (float)$project->total_anggaran;

        });









        $efisiensiDana = 0;


        if($totalAnggaranProject > 0)
        {

            $efisiensiDana = round(

                ($profit / $totalAnggaranProject) * 100,

                2

            );

        }








 

           return view(
    'owner.reports.index',
    compact(
        'totalPendapatan',
        'totalPengeluaran',
        'profit',
        'totalProject',
        'projectAktif',
        'totalProjectBerjalan',
        'totalAnggaranProject',
        'rataProgress',
        'totalProjectSelesai',
        'totalProjectTerlambat',
        'efisiensiDana',
        'totalTransaksi',
        'saldo',
        'projects'
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

        $this->checkRole();


        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export laporan owner PDF'

        );


        return response()->download(

            storage_path(
                'app/reports/owner-report.pdf'
            )

        );

    }









    /*
    |--------------------------------------------------------------------------
    | EXPORT FINANCE PDF
    |--------------------------------------------------------------------------
    */

    public function financePdf(Request $request)
{
    $this->checkRole();


    $transactions = TransaksiDana::with([
        'pengajuanDana.proyek.perusahaan',
        'pengajuanDana.divisi',
        'pengajuanDana.pengguna',
        'rekeningBank',
        'penyetuju'
    ])

    ->when($request->start_date, function($query) use($request){
        $query->whereDate(
            'tanggal',
            '>=',
            $request->start_date
        );
    })

    ->when($request->end_date, function($query) use($request){
        $query->whereDate(
            'tanggal',
            '<=',
            $request->end_date
        );
    })

    ->latest('tanggal')
    ->get();


$transaksi = $transactions->map(function($item){

    return [

        'tanggal' => $item->tanggal,

        'keterangan' => 
        $item->pengajuanDana?->judul ?? '-',

        'project' => 
            $item->pengajuanDana?->proyek?->nama_proyek ?? '-',

        'nominal' =>
            $item->jumlah,

        'jenis' =>
            'Pengeluaran'

    ];

});



    $totalPendapatan = $transaksi
        ->where('jenis','Pemasukan')
        ->sum('nominal');



    $totalPengeluaran = $transaksi
        ->where('jenis','Pengeluaran')
        ->sum('nominal');



    $saldo = $totalPendapatan - $totalPengeluaran;



    $totalTransaksi = $transaksi->count();



    $tanggal = now();

$pdf = Pdf::loadView(
    'owner.reports.pdf.finance',
    compact(
        'transaksi',
        'totalPendapatan',
        'totalPengeluaran',
        'saldo',
        'totalTransaksi',
        'tanggal'
    )
);


return $pdf->download(
    'laporan-keuangan-owner.pdf'
);
}
    /*
    |--------------------------------------------------------------------------
    | EXPORT FINANCE EXCEL
    |--------------------------------------------------------------------------
    */


    public function financeExcel(Request $request)
    {

        $this->checkRole();




        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export laporan finance owner Excel'

        );





        return Excel::download(

            new OwnerFinanceExport(

                $request->start_date,

                $request->end_date

            ),

            'owner-finance-report.xlsx'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | PROJECT REPORT PDF
    |--------------------------------------------------------------------------
    */


   public function projectPdf(Request $request)
{
    $this->checkRole();


    $projects = Proyek::with([

        'perusahaan',
        'tugas'

    ])

    ->when($request->start_date,function($query) use($request){

        $query->whereDate(
            'created_at',
            '>=',
            $request->start_date
        );

    })

    ->when($request->end_date,function($query) use($request){

        $query->whereDate(
            'created_at',
            '<=',
            $request->end_date
        );

    })

    ->latest()
    ->get();



    AuditHelper::create(

        'EXPORT',
        'Owner Report',
        'Export laporan project PDF'

    );



    $tanggal = now();



    $pdf = Pdf::loadView(

        'owner.reports.pdf.project',

        compact(
            'projects',
            'tanggal'
        )

    );


    return $pdf->download(
        'laporan-project-owner.pdf'
    );
}








    /*
    |--------------------------------------------------------------------------
    | PROJECT REPORT EXCEL
    |--------------------------------------------------------------------------
    */


    public function projectExcel(Request $request)
    {

        $this->checkRole();



        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export laporan project Excel'

        );







        return Excel::download(

            new ProjectReportExport(

                $request->start_date,

                $request->end_date

            ),

            'project-report.xlsx'

        );


    }












    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE PDF
    |--------------------------------------------------------------------------
    */
public function performancePdf(Request $request)
{
    $this->checkRole();



    $projects = Proyek::with([

        'tugas.karyawan',
        'tugas.divisi'

    ])

    ->latest()
    ->get();



    $totalProject = $projects->count();



    $projectAktif = $projects
        ->filter(function($project){

            return $project->progres_keseluruhan > 0
            &&
            $project->progres_keseluruhan < 100;

        })
        ->count();



    $projectSelesai = $projects
        ->filter(function($project){

            return $project->progres_keseluruhan >=100;

        })
        ->count();



    $progress = $projects->avg(function($project){

        return $project->progres_keseluruhan;

    }) ?? 0;




    if($progress >= 80){

        $status = "Performa Sangat Baik";

    }elseif($progress >=50){

        $status="Performa Cukup Baik";

    }else{

        $status="Perlu Monitoring";

    }



    $tanggal = now();



    AuditHelper::create(

        'EXPORT',
        'Owner Report',
        'Export performance project PDF'

    );



    $pdf = Pdf::loadView(

        'owner.reports.pdf.performance',

        compact(

            'projects',
            'totalProject',
            'projectAktif',
            'projectSelesai',
            'progress',
            'status',
            'tanggal'

        )

    );



    return $pdf->download(

        'laporan-performance-owner.pdf'

    );
}






    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE EXCEL
    |--------------------------------------------------------------------------
    */


    public function performanceExcel(Request $request)
    {

        $this->checkRole();





        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export performance project Excel'

        );







        return Excel::download(

            new PerformanceReportExport(

                $request->start_date,

                $request->end_date

            ),

            'performance-report.xlsx'

        );


    }



}