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

                'totalAnggaranProject',

                'rataProgress',

                'totalProjectSelesai',

                'totalProjectTerlambat',

                'efisiensiDana',

                'totalTransaksi',

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

        ->latest('tanggal')

        ->get();







        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export laporan finance owner PDF'

        );







        return view(

            'owner.reports.finance-pdf',

            compact(
                'transactions'
            )

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








        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export laporan project PDF'

        );






        return view(

            'owner.reports.project-pdf',

            compact(
                'projects'
            )

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







        AuditHelper::create(

            'EXPORT',

            'Owner Report',

            'Export performance project PDF'

        );








        return view(

            'owner.reports.performance-pdf',

            compact(

                'projects'

            )

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