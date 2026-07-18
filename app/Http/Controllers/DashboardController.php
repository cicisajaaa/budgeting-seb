<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use App\Models\BankAccount;
use App\Models\ExpenseRequest;
use App\Models\Task;

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



        $projects = Project::with('tasks')
            ->latest()
            ->get();






        /*
        |--------------------------------------------------------------------------
        | DATA TASK TRACKER
        |--------------------------------------------------------------------------
        */


        $totalTask = Task::count();



        $taskDone = Task::where(
            'status',
            'done'
        )
        ->count();




        $taskProgress = Task::where(
            'status',
            'progress'
        )
        ->count();




        $taskTodo = Task::where(
            'status',
            'todo'
        )
        ->count();





        $recentTasks = Task::with([

            'project',

            'employee'

        ])
        ->latest()
        ->take(5)
        ->get();








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



        $sisaDana = $totalDeposit - $totalExpense;








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


            // PROJECT

            'projects' => $projects,


            'totalProject' => $totalProject,


            'totalBudget' => $totalBudget,


            'totalProjectProgress' => round(
                $totalProjectProgress ?? 0
            ),




            // TASK TRACKER

            'totalTask' => $totalTask,


            'taskDone' => $taskDone,


            'taskProgress' => $taskProgress,


            'taskTodo' => $taskTodo,


            'recentTasks' => $recentTasks,





            // FINANCE

            'totalDeposit' => $totalDeposit,


            'totalExpense' => $totalExpense,


            'sisaDana' => $sisaDana,





            // DIVISION

            'totalSaldoDivisi' => $totalSaldoDivisi,





            // BANK

            'totalSaldoBank' => $totalSaldoBank,


            'totalBankAktif' => $totalBankAktif,





            // APPROVAL

            'totalApprovalPending' => $totalApprovalPending,


            'recentApproval' => $recentApproval,





            // TRANSACTION

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