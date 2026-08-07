<?php

namespace App\Http\Controllers\Owner;


use App\Http\Controllers\Controller;

use App\Models\Proyek;
use App\Models\ProjectDeposit;
use App\Models\ExpenseRequest;
use App\Models\Tugas;



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
            'aktivitasTugas'
        ])
        ->latest()
        ->get();




        $totalProject = $projects->count();




        $totalBudget = $projects->sum(function($project){

            return $project->total_anggaran ?? 0;

        });





        $progressProject = $projects->avg(function($project){

            return $project->progres_keseluruhan ?? 0;

        });








        /*
        |--------------------------------------------------------------------------
        | FINANCE DATA
        |--------------------------------------------------------------------------
        */


        $totalDeposit = ProjectDeposit::sum(
            'jumlah_setoran'
        );



        $totalExpense = ExpenseRequest::sum(
            'jumlah'
        );



        $sisaDana = $totalDeposit - $totalExpense;









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
        | APPROVAL
        |--------------------------------------------------------------------------
        */


        $pendingApproval = ExpenseRequest::where(
            'status',
            'pending'
        )
        ->count();







        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */


        $recentTasks = Tugas::with([
            'proyek',
            'karyawan',
            'aktivitasTugas'
        ])
        ->latest()
        ->take(5)
        ->get();







        return view(
            'dashboard.owner',
            compact(

                'projects',

                'totalProject',

                'totalBudget',

                'totalDeposit',

                'totalExpense',

                'sisaDana',

                'progressProject',

                'totalTask',

                'taskSelesai',

                'taskBerjalan',

                'pendingApproval',

                'recentTasks'

            )
        );


    }


}