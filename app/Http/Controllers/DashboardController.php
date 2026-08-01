<?php

namespace App\Http\Controllers;


use App\Models\Proyek;
use App\Models\SetoranProyek;
use App\Models\TransaksiDana;
use App\Models\SaldoDivisi;
use App\Models\RekeningBank;
use App\Models\PengajuanDana;
use App\Models\Tugas;
use App\Models\AktivitasTugas;
use App\Models\Divisi;
use App\Models\LogAudit;


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


        $totalProject = Proyek::count();



        $totalProjectAktif = Proyek::where(
            'progres_keseluruhan',
            '<',
            100
        )->count();




        $totalBudget = Proyek::sum(
            'total_anggaran'
        );




        $totalProjectProgress = Proyek::avg(
            'progres_keseluruhan'
        );





        $projects = Proyek::with([

            'tugas.aktivitasTugas'

        ])

        ->latest()

        ->take(5)

        ->get();








        /*
        |--------------------------------------------------------------------------
        | DATA TASK
        |--------------------------------------------------------------------------
        */


        $totalTask = Tugas::count();



        $taskDone = Tugas::where(
            'status',
            'selesai'
        )->count();




        $taskProgress = Tugas::where(
            'status',
            'sedang_dikerjakan'
        )->count();




        $taskTodo = Tugas::where(
            'status',
            'belum_dikerjakan'
        )->count();




        $averageTaskProgress = Tugas::avg(
            'progres_persen'
        );





        $taskByPriority = Tugas::selectRaw(

            'prioritas, COUNT(*) as total'

        )

        ->groupBy(

            'prioritas'

        )

        ->get();





        $taskByProject = Proyek::withCount(
            'tugas'
        )

        ->get();





        $taskByEmployee = \App\Models\Karyawan::withCount(
            'tugas'
        )

        ->get();





        $taskByDivision = Divisi::withCount(
            'tugas'
        )

        ->get();





        $recentTasks = Tugas::with([

            'proyek',

            'karyawan'

        ])

        ->latest()

        ->take(5)

        ->get();
        
/*
|--------------------------------------------------------------------------
| DATA KEUANGAN
|--------------------------------------------------------------------------
*/


$totalDeposit = SetoranProyek::sum(
    'jumlah_setoran'
);


$totalTransactionExpense = TransaksiDana::sum(
    'jumlah'
);


$totalActivityExpense = AktivitasTugas::sum(
    'anggaran_aktivitas'
);


$totalExpense = 
    $totalTransactionExpense 
    +
    $totalActivityExpense;



$sisaDana = max(
    $totalDeposit - $totalExpense,
    0
);



$budgetUsage = 0;


if($totalDeposit > 0)
{

    $budgetUsage = round(
        ($totalExpense / $totalDeposit) * 100
    );

}






/*
|--------------------------------------------------------------------------
| DATA SALDO
|--------------------------------------------------------------------------
*/


$totalSaldoDivisi = SaldoDivisi::sum(
    'saldo'
);



$totalSaldoBank = RekeningBank::where(
    'status',
    true
)

->sum(
    'saldo'
);



$totalBankAktif = RekeningBank::where(
    'status',
    true
)

->count();







/*
|--------------------------------------------------------------------------
| DATA APPROVAL
|--------------------------------------------------------------------------
*/


$totalApprovalPending = PengajuanDana::where(
    'status',
    'pending'
)

->count();



$totalApprovalApproved = PengajuanDana::where(
    'status',
    'approved'
)

->count();



$totalApprovalRejected = PengajuanDana::where(
    'status',
    'rejected'
)

->count();





$recentApproval = PengajuanDana::with([

    'proyek',
    'divisi',
    'pengguna'

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


$recentExpenses = TransaksiDana::with(

    'pengajuanDana'

)

->latest()

->take(5)

->get();



$recentDeposits = SetoranProyek::with([

    'proyek',
    'rekeningBank'

])

->latest()

->take(5)

->get();







/*
|--------------------------------------------------------------------------
| PENGELUARAN BULAN INI
|--------------------------------------------------------------------------
*/


$expenseThisMonth = TransaksiDana::whereMonth(

    'tanggal',

    now()->month

)

->whereYear(

    'tanggal',

    now()->year

)

->sum(

    'jumlah'

);







/*
|--------------------------------------------------------------------------
| AUDIT TRAIL
|--------------------------------------------------------------------------
*/


$recentAudit = LogAudit::with(

    'pengguna'

)

->latest()

->take(5)

->get();
        /*
|--------------------------------------------------------------------------
| DASHBOARD KARYAWAN
|--------------------------------------------------------------------------
*/


// DEFAULT DATA KARYAWAN
// Supaya tidak undefined variable ketika login bukan karyawan

$totalExpenseRequest = 0;

$pendingExpenseRequest = 0;

$approvedExpenseRequest = 0;

$recentExpenseRequest = collect();



$employeeTasks = collect();


$deadlineTasks = collect();


$projectProgress = collect();


$recentActivities = collect();



$taskChart = [

    'done'=>0,

    'progress'=>0,

    'todo'=>0

];






        if($user->role == 'karyawan')
        {


            $employee = $user->karyawan;



            if($employee)
            {


                $employeeTasks = Tugas::where(

                    'karyawan_id',

                    $employee->id

                )

                ->with([

                    'proyek',

                    'aktivitasTugas'

                ])

                ->latest()

                ->get();







                $taskChart = [


                    'done'=>$employeeTasks

                    ->whereIn(

                        'status',

                        [

                            'selesai',

                            'done'

                        ]

                    )

                    ->count(),





                    'progress'=>$employeeTasks

                    ->whereIn(

                        'status',

                        [

                            'berjalan',

                            'progress'

                        ]

                    )

                    ->count(),





                    'todo'=>$employeeTasks

                    ->whereIn(

                        'status',

                        [

                            'belum_dikerjakan',

                            'todo'

                        ]

                    )

                    ->count(),


                ];







                $deadlineTasks = $employeeTasks

                ->whereNotNull(

                    'deadline'

                )

                ->sortBy(

                    'deadline'

                )

                ->take(5);







                $projectProgress = $employeeTasks

                ->groupBy(function($task){


                    return $task->proyek->nama_proyek

                    ??

                    'Tanpa Proyek';


                })

                ->map(function($tasks){


                    return round(

                        $tasks->avg(

                            'progres_persen'

                        )

                    );


                });








                $recentActivities = $employeeTasks

                ->flatMap(function($task){


                    return $task->aktivitasTugas

                    ->map(function($activity) use($task){


                        return [

                            'task'=>$task->nama_tugas,

                            'aktivitas'=>$activity->aktivitas,

                            'progress'=>$activity->progres,

                            'tanggal'=>$activity->created_at

                        ];


                    });


                })

                ->sortByDesc(

                    'tanggal'

                )

                ->take(5);


                $totalExpenseRequest = PengajuanDana::where(
                    'pengguna_id',
                    $user->id
                )->count();


                $pendingExpenseRequest = PengajuanDana::where(
                    'pengguna_id',
                    $user->id
                )
                ->where(
                    'status',
                    'pending'
                )
                ->count();



                $approvedExpenseRequest = PengajuanDana::where(
                    'pengguna_id',
                    $user->id
                )
                ->where(
                    'status',
                    'approved'
                )
                ->count();



                $recentExpenseRequest = PengajuanDana::with([
                    'proyek'
                ])
                ->where(
                    'pengguna_id',
                    $user->id
                )
                ->latest()
                ->take(5)
                ->get();

            }


        }










        /*
        |--------------------------------------------------------------------------
        | DATA KE VIEW
        |--------------------------------------------------------------------------
        */


        $data = [


            'employeeTasks'=>$employeeTasks,


            'deadlineTasks'=>$deadlineTasks,


            'projectProgress'=>$projectProgress,


            'recentActivities'=>$recentActivities,


            'taskChart'=>$taskChart,





            'projects'=>$projects,


            'totalProject'=>$totalProject,


            'totalProjectAktif'=>$totalProjectAktif,


            'totalBudget'=>$totalBudget,


            'totalProjectProgress'=>round(

                $totalProjectProgress ?? 0

            ),






            'totalTask'=>$totalTask,


            'taskDone'=>$taskDone,


            'taskProgress'=>$taskProgress,


            'taskTodo'=>$taskTodo,


            'averageTaskProgress'=>round(

                $averageTaskProgress ?? 0

            ),




            'recentTasks'=>$recentTasks,


            'taskByPriority'=>$taskByPriority,


            'taskByProject'=>$taskByProject,


            'taskByEmployee'=>$taskByEmployee,


            'taskByDivision'=>$taskByDivision,






            'totalDeposit'=>$totalDeposit,


            'totalExpense'=>$totalExpense,


            'totalBudgetActivity'=>$totalActivityExpense,


            'budgetUsage'=>$budgetUsage,


            'sisaDana'=>$sisaDana,


            'expenseThisMonth'=>$expenseThisMonth,






            'totalSaldoDivisi'=>$totalSaldoDivisi,


            'totalSaldoBank'=>$totalSaldoBank,


            'totalBankAktif'=>$totalBankAktif,






            'totalApprovalPending'=>$totalApprovalPending,


            'totalApprovalApproved'=>$totalApprovalApproved,


            'totalApprovalRejected'=>$totalApprovalRejected,


            'recentApproval'=>$recentApproval,







            'recentExpenses'=>$recentExpenses,


            'recentDeposits'=>$recentDeposits,






            'recentAudit'=>$recentAudit,



            'totalExpenseRequest'=>$totalExpenseRequest,

            'pendingExpenseRequest'=>$pendingExpenseRequest,

            'approvedExpenseRequest'=>$approvedExpenseRequest,

            'recentExpenseRequest'=>$recentExpenseRequest,
        ];










        /*
        |--------------------------------------------------------------------------
        | ROLE DASHBOARD
        |--------------------------------------------------------------------------
        */


        switch($user->role)

        {


            case 'owner':

                return view(

                    'dashboard.owner',

                    $data

                );





            case 'keuangan':

                return view(

                    'dashboard.keuangan',

                    $data

                );





            case 'karyawan':

                return view(

                    'dashboard.karyawan',

                    $data

                );





            case 'admin':

                return redirect()

                ->route(

                    'admin.dashboard'

                );





            default:

                abort(403);


        }


    }


}