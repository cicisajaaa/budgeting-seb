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



        $totalExpense = ExpenseTransaction::sum('jumlah');



        $totalBudgetActivity = \App\Models\TaskActivity::sum(
            'budget_activity'
        );



        $totalExpense = $totalExpense + $totalBudgetActivity;



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


        /*
        |--------------------------------------------------------------------------
        | TASK DEADLINE TERDEKAT
        |--------------------------------------------------------------------------
        */


        $deadlineTasks = $employeeTasks
            ->whereNotNull('deadline')
            ->sortBy('deadline')
            ->take(5);



        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK PROJECT
        |--------------------------------------------------------------------------
        */


        $projectProgress = $employeeTasks
            ->groupBy(function($task){

                return $task->project->nama_project ?? 'Tanpa Project';

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

    'employeeTasks' => $employeeTasks,

    'deadlineTasks' => $deadlineTasks,

    'projectProgress' => $projectProgress,


    // PROJECT

    'projects' => $projects,

    'totalProject' => $totalProject,

    'totalBudget' => $totalBudget,

    'totalProjectProgress' => round(
        $totalProjectProgress ?? 0
    ),



    // TASK

    'totalTask' => $totalTask,

    'taskDone' => $taskDone,

    'taskProgress' => $taskProgress,

    'taskTodo' => $taskTodo,

    'recentTasks' => $recentTasks,



    // FINANCE


    'totalDeposit' => $totalDeposit,

    'totalExpense' => $totalExpense,

    'totalBudgetActivity' => $totalBudgetActivity,

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