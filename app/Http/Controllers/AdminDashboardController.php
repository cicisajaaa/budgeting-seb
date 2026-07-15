<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Project;
use App\Models\Division;



class AdminDashboardController extends Controller
{


    public function index()
    {


        $totalUser = User::count();


        $totalProject = Project::count();


        $totalDivision = Division::count();



        return view(
            'dashboard.admin',
            compact(
                'totalUser',
                'totalProject',
                'totalDivision'
            )
        );


    }


}