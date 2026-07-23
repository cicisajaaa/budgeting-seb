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
            'berjalan'
        )->count();



        $taskTodo = Tugas::where(
            'status',
            'belum_dikerjakan'
        )->count();




        $averageTaskProgress = Tugas::avg(
            'progres_persen'
        );





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




        $sisaDana =

            $totalDeposit

            -

            $totalExpense;




        $budgetUsage = 0;



        if($totalDeposit > 0)
        {

            $budgetUsage = round(

                ($totalExpense / $totalDeposit)

                *

                100

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


        $recentExpenses = TransaksiDana::with([

            'pengajuanDana'

        ])

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
        | DASHBOARD KARYAWAN
        |--------------------------------------------------------------------------
        */


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

                    'done'=>

                        $employeeTasks

                        ->whereIn(

                            'status',

                            [

                                'selesai',

                                'done'

                            ]

                        )

                        ->count(),





                    'progress'=>

                        $employeeTasks

                        ->whereIn(

                            'status',

                            [

                                'berjalan',

                                'progress'

                            ]

                        )

                        ->count(),





                    'todo'=>

                        $employeeTasks

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



            'totalDeposit'=>$totalDeposit,


            'totalExpense'=>$totalExpense,


            'totalBudgetActivity'=>$totalActivityExpense,


            'budgetUsage'=>$budgetUsage,


            'sisaDana'=>$sisaDana,



            'totalSaldoDivisi'=>$totalSaldoDivisi,


            'totalSaldoBank'=>$totalSaldoBank,


            'totalBankAktif'=>$totalBankAktif,



            'totalApprovalPending'=>$totalApprovalPending,


            'recentApproval'=>$recentApproval,


            'recentExpenses'=>$recentExpenses,


            'recentDeposits'=>$recentDeposits,


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



            case 'bendahara':

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