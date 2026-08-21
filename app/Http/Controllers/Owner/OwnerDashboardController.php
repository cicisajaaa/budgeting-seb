<?php

namespace App\Http\Controllers\Owner;


use App\Http\Controllers\Controller;


use App\Models\Proyek;
use App\Models\PengajuanDana;
use App\Models\TransaksiDana;
use App\Models\Tugas;
use App\Models\AktivitasTugas;



class OwnerDashboardController extends Controller
{


    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | PROJECT DATA
        |--------------------------------------------------------------------------
        */


        $projects = Proyek::with([

            'tugas',
            'aktivitasTugas',
            'perusahaan'

        ])

        ->latest()

        ->get();


$financeProjects = $projects->map(function($project){

    return [

        'nama' => $project->nama_proyek,

        'budget' => $project->total_anggaran,

        'realisasi' => $project->total_realisasi,

    ];

});



        $totalProject = $projects->count();






        $totalBudget = $projects->sum(function($project){

            return $project->total_anggaran ?? 0;

        });







        $progressProject = round(
            $projects->avg(function($project){

                return $project->progres_keseluruhan ?? 0;

            })
        );








        /*
        |--------------------------------------------------------------------------
        | FINANCE DATA
        |--------------------------------------------------------------------------
        */


        // Dana yang benar-benar sudah dicairkan finance

        $totalRealisasi = TransaksiDana::sum(

            'jumlah'

        );





        // Sisa seluruh budget proyek

       $sisaBudgetProyek = $totalBudget - $totalRealisasi;







        // Total pengajuan yang sudah disetujui

        $totalApprovedExpense = PengajuanDana::where(

            'status',

            'approved'

        )

        ->sum('jumlah');







        // Pengajuan yang masih menunggu approval

        $pendingApproval = PengajuanDana::where(

            'status',

            'pending'

        )

        ->count();









        /*
        |--------------------------------------------------------------------------
        | PROJECT BUDGET MONITORING
        |--------------------------------------------------------------------------
        */


        $criticalProjects = $projects->filter(function($project){


            return $project->persentase_budget >= 90;


        });








        /*
        |--------------------------------------------------------------------------
        | TASK MONITORING
        |--------------------------------------------------------------------------
        */


        $totalTask = Tugas::count();






        $taskSelesai = Tugas::where(

            'status',

            'selesai'

        )

        ->count();







        $taskBerjalan = Tugas::where(

            'status',

            'sedang_dikerjakan'

        )

        ->count();









        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $recentTasks = AktivitasTugas::with([

            'tugas.proyek',

            'karyawan'

        ])

        ->latest()

        ->take(5)

        ->get();








        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */


        return view(

            'dashboard.owner',

            compact(


                'projects',


                'totalProject',


                'totalBudget',


                'totalRealisasi',


                'sisaBudgetProyek',


                'totalApprovedExpense',


                'progressProject',


                'pendingApproval',


                'criticalProjects',


                'totalTask',


                'taskSelesai',


                'taskBerjalan',


                'recentTasks',

                'financeProjects'



            )

        );


    }


}