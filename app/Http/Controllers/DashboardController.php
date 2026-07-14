<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();



        /*
        |--------------------------------------------------------------------------
        | DATA PROJECT
        |--------------------------------------------------------------------------
        */


        $totalProject = Project::count();



        $totalBudget = Project::sum('total_budget');



        $totalProjectProgress = Project::avg(
            'progress_keseluruhan'
        );





        /*
        |--------------------------------------------------------------------------
        | DATA KEUANGAN
        |--------------------------------------------------------------------------
        */


        // Total uang masuk dari client

        $totalDeposit = ProjectDeposit::sum(
            'jumlah_setoran'
        );



        // Total uang yang sudah dikeluarkan

        $totalExpense = ExpenseTransaction::sum(
            'jumlah'
        );



        // Sisa uang perusahaan

        $sisaDana = 
            $totalDeposit - $totalExpense;




        /*
        |--------------------------------------------------------------------------
        | SALDO DIVISI
        |--------------------------------------------------------------------------
        */


        $totalSaldoDivisi = DivisionBalance::sum(
            'saldo'
        );





        $data = [


            'totalProject' => $totalProject,


            'totalBudget' => $totalBudget,


            'totalDeposit' => $totalDeposit,


            'totalExpense' => $totalExpense,


            'sisaDana' => $sisaDana,


            'totalSaldoDivisi' => $totalSaldoDivisi,


            'totalProjectProgress' => round(
                $totalProjectProgress ?? 0
            ),


        ];





        /*
        |--------------------------------------------------------------------------
        | DASHBOARD BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */


        switch ($user->role) {


            case 'owner':

                return view(
                    'dashboard.owner',
                    $data
                );



            case 'admin':

                return view(
                    'dashboard.admin',
                    $data
                );



            case 'bendahara':

                return view(
                    'dashboard.bendahara',
                    $data
                );



            case 'karyawan':

                return view(
                    'dashboard.karyawan',
                    $data
                );



            default:

                abort(403);


        }


    }

}