<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectDeposit;
use App\Models\ExpenseTransaction;
use App\Models\DivisionBalance;
use App\Models\BankAccount;
use App\Models\ExpenseRequest;
use App\Models\Task;
use App\Models\TaskActivity;

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


        $totalProjectAktif = Project::where(
            'progress_keseluruhan',
            '<',
            100
        )
        ->count();



        $totalBudget = Project::sum(
            'total_budget'
        );



        $totalProjectProgress = Project::with('tasks')
        ->get()
        ->avg(function($project){

            return $project->progress_keseluruhan;

        });



        $projects = Project::with([
            'tasks.activities'
        ])
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



        $averageTaskProgress = Task::avg(
            'progress_persen'
        );




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




        $totalTransactionExpense = ExpenseTransaction::sum(
            'jumlah'
        );




        $totalActivityExpense = TaskActivity::sum(
            'budget_activity'
        );




        $totalExpense = 
            $totalTransactionExpense
            +
            $totalActivityExpense;




        $sisaDana = 
            $totalDeposit 
            -
            $totalExpense;




        /*
        |--------------------------------------------------------------------------
        | PRESENTASE PENGGUNAAN BUDGET
        |--------------------------------------------------------------------------
        */


        $budgetUsage = 0;


        if($totalDeposit > 0)
        {

            $budgetUsage = round(
                ($totalExpense / $totalDeposit) * 100
            );

        }









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
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */


        $employeeTasks = collect();

        $deadlineTasks = collect();

        $projectProgress = collect();


        $taskChart = [

            'done'=>0,

            'progress'=>0,

            'todo'=>0

        ];





        if($user->role == 'karyawan')
        {


            $employee = $user->employee;



            if($employee)
            {



                $employeeTasks = $employee
                    ->tasks()
                    ->with([
                        'project',
                        'activities'
                    ])
                    ->latest()
                    ->get();





                $taskChart = [

                    'done'=>$employeeTasks
                        ->where('status','done')
                        ->count(),



                    'progress'=>$employeeTasks
                        ->where('status','progress')
                        ->count(),



                    'todo'=>$employeeTasks
                        ->where('status','todo')
                        ->count(),

                ];





                $deadlineTasks = $employeeTasks
                    ->whereNotNull('deadline')
                    ->sortBy('deadline')
                    ->take(5);







                $projectProgress = $employeeTasks
                    ->groupBy(function($task){

                        return $task->project->nama_project 
                        ?? 
                        'Tanpa Project';

                    })
                    ->map(function($tasks){

                        return round(
                            $tasks->avg('progress_persen')
                        );

                    });


            }

        }










        /*
        |--------------------------------------------------------------------------
        | DATA DIKIRIM KE VIEW
        |--------------------------------------------------------------------------
        */


        $data = [



            'employeeTasks'=>$employeeTasks,

            'deadlineTasks'=>$deadlineTasks,

            'projectProgress'=>$projectProgress,

            'taskChart'=>$taskChart,





            // PROJECT


            'projects'=>$projects,


            'totalProject'=>$totalProject,


            'totalProjectAktif'=>$totalProjectAktif,


            'totalBudget'=>$totalBudget,



            'totalProjectProgress'=>round(
                $totalProjectProgress ?? 0
            ),






            // TASK


            'totalTask'=>$totalTask,


            'taskDone'=>$taskDone,


            'taskProgress'=>$taskProgress,


            'taskTodo'=>$taskTodo,


            'averageTaskProgress'=>round(
                $averageTaskProgress ?? 0
            ),



            'recentTasks'=>$recentTasks,








            // FINANCE


            'totalDeposit'=>$totalDeposit,


            'totalExpense'=>$totalExpense,


            'totalBudgetActivity'=>$totalActivityExpense,


            'budgetUsage'=>$budgetUsage,


            'sisaDana'=>$sisaDana,








            // DIVISION


            'totalSaldoDivisi'=>$totalSaldoDivisi,








            // BANK


            'totalSaldoBank'=>$totalSaldoBank,


            'totalBankAktif'=>$totalBankAktif,








            // APPROVAL


            'totalApprovalPending'=>$totalApprovalPending,


            'recentApproval'=>$recentApproval,








            // TRANSACTION


            'recentExpenses'=>$recentExpenses,


            'recentDeposits'=>$recentDeposits,



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