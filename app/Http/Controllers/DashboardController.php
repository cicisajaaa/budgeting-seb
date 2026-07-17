<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use App\Models\BankAccount;
use App\Models\ExpenseRequest;

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



        $totalBudget = Project::sum(
            'total_budget'
        );



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

            $totalDeposit -

            $totalExpense;









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
        | DATA REKENING BANK
        |--------------------------------------------------------------------------
        */


        $totalSaldoBank = BankAccount::where(

            'status',

            true

        )
        ->sum(
            'saldo'
        );




        $totalBankAktif = BankAccount::where(

            'status',

            true

        )
        ->count();









        /*
        |--------------------------------------------------------------------------
        | APPROVAL PENDING
        |--------------------------------------------------------------------------
        */


        $totalApprovalPending = ExpenseRequest::where(

            'status',

            'pending'

        )
        ->count();







        $recentApproval = ExpenseRequest::with([

            'project',

            'division',

            'user'

        ])
        ->where(

            'status',

            'pending'

        )
        ->latest()
        ->take(5)
        ->get();









        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */


        $recentExpenses = ExpenseTransaction::with([

            'request.project',

            'request.division',

            'request.user'

        ])
        ->latest()
        ->take(5)
        ->get();






        $recentDeposits = ProjectDeposit::with([

            'project',

            'bank'

        ])
        ->latest()
        ->take(5)
        ->get();









        /*
        |--------------------------------------------------------------------------
        | DATA DIKIRIM KE VIEW
        |--------------------------------------------------------------------------
        */


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





            'totalSaldoBank' => $totalSaldoBank,



            'totalBankAktif' => $totalBankAktif,



            'totalApprovalPending' => $totalApprovalPending,



            'recentApproval' => $recentApproval,



            'recentExpenses' => $recentExpenses,



            'recentDeposits' => $recentDeposits,



        ];









        switch($user->role)

        {


            case 'owner':


                return view(

                    'dashboard.owner',

                    $data

                );





            case 'admin':


                return redirect()

                    ->route(

                        'admin.dashboard'

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