<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Tugas;
use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\LogAudit;



class AdminDashboardController extends Controller
{


    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | STATISTIK ADMIN
        |--------------------------------------------------------------------------
        */


        $totalUser = User::count();



        $totalProject = Proyek::count();



        $totalDivision = Divisi::count();



        $totalTask = Tugas::count();


$totalTaskBerjalan = Tugas::where(
    'status',
    'sedang_dikerjakan'
)->count();



$totalTaskSelesai = Tugas::where(
    'status',
    'selesai'
)->count();



$totalTaskBelum = Tugas::where(
    'status',
    'belum_dikerjakan'
)->count();



$totalTaskTerlambat = Tugas::where('status','!=','selesai')
    ->whereNotNull('deadline')
    ->whereDate('deadline','<',now())
    ->count();



$rataProgressTask = Tugas::avg(
    'progres_persen'
);
/*
|--------------------------------------------------------------------------
| STATISTIK BUDGET PROJECT
|--------------------------------------------------------------------------
*/


$totalBudget = Proyek::sum(
    'total_anggaran'
);



$totalRealisasi = TransaksiDana::sum(
    'jumlah'
);



$sisaBudget = $totalBudget - $totalRealisasi;



        /*
        |--------------------------------------------------------------------------
        | STATISTIK PENGAJUAN DANA
        |--------------------------------------------------------------------------
        */


        $totalExpenseRequest = PengajuanDana::count();



        $totalPendingExpense = PengajuanDana::where(

            'status',

            'pending'

        )
        ->count();




        $totalApprovedExpense = PengajuanDana::where(

            'status',

            'approved'

        )
        ->count();




        $totalRejectedExpense = PengajuanDana::where(

            'status',

            'rejected'

        )
        ->count();





/*
|--------------------------------------------------------------------------
| PROJECT PERFORMANCE
|--------------------------------------------------------------------------
*/


$projectPerformance = Proyek::withCount([

    'tugas'

])

->with([

    'tugas'

])

->get()

->map(function($project){


    $total = $project->tugas->count();


    $progress = $total > 0

        ? round(
            $project->tugas->avg('progres_persen'),
            2
        )

        : 0;



    $project->progress_project = $progress;


    return $project;


})

->sortByDesc('progress_project')

->take(5);



        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU
        |--------------------------------------------------------------------------
        */


        $recentUsers = User::latest()

            ->take(5)

            ->get();






        $recentProjects = Proyek::latest()

            ->take(5)

            ->get();









        /*
        |--------------------------------------------------------------------------
        | AUDIT TRAIL TERBARU
        |--------------------------------------------------------------------------
        */


        $recentAudit = LogAudit::with(

            'pengguna'

        )

        ->latest()

        ->take(10)

        ->get();





/*
|--------------------------------------------------------------------------
| PROJECT WARNING BUDGET
|--------------------------------------------------------------------------
*/


$projectWarning = Proyek::with(

    'perusahaan'

)

->get()

->filter(function($project){

    return $project->persentase_budget >= 75;

})

->sortByDesc(

    'persentase_budget'

)

->take(5);



        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */


        return view(

            'dashboard.admin',

            compact(

                'totalUser',

                'totalProject',

                'totalDivision',

                'totalTask',

                'totalTaskBerjalan',

                'totalTaskSelesai',

                'totalTaskBelum',

                'totalTaskTerlambat',

                'rataProgressTask',


                'totalExpenseRequest',

                'totalPendingExpense',

                'totalApprovedExpense',

                'totalRejectedExpense',


                'totalBudget',

                'totalRealisasi',

                'sisaBudget',

                'projectWarning',

                'recentUsers',

                'recentProjects',

                'recentAudit',

                'projectPerformance'

            )

        );


    }



}