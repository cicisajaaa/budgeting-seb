<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Tugas;



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

                'recentUsers',

                'recentProjects'

            )

        );


    }



}