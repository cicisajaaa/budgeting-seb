<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Tugas;
use App\Models\PengajuanDana;
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


                'recentUsers',

                'recentProjects',

                'recentAudit'

            )

        );


    }



}