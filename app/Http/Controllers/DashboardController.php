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


        $totalDeposit = ProjectDeposit::sum(
            'jumlah_setoran'
        );


        $totalExpense = ExpenseTransaction::sum(
            'jumlah'
        );


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



        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU (STEP 2)
        |--------------------------------------------------------------------------
        */


        $recentExpenses = ExpenseTransaction::with('request')
            ->latest()
            ->take(5)
            ->get();



        $recentDeposits = ProjectDeposit::with('project')
            ->latest()
            ->take(5)
            ->get();





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


            'recentExpenses' => $recentExpenses,


            'recentDeposits' => $recentDeposits,


        ];






        switch ($user->role) {


            case 'owner':

                return view(
                    'dashboard.owner',
                    $data
                );



            case 'admin':

                return redirect()
                    ->route('admin.dashboard');



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