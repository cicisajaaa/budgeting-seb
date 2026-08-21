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

                'recentAudit'

            )

        );


    }



}