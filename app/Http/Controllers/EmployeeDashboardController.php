<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\PengajuanDana;
use App\Models\Tugas;


class EmployeeDashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $karyawan = $user->karyawan;



        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN DANA
        |--------------------------------------------------------------------------
        */


        $totalPengajuan = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )->count();



        $pendingPengajuan = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->where('status','pending')
        ->count();



        $approvedPengajuan = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->where('status','approved')
        ->count();



        $rejectedPengajuan = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->where('status','rejected')
        ->count();



        $totalDana = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->sum('jumlah');





        /*
        |--------------------------------------------------------------------------
        | TASK KARYAWAN
        |--------------------------------------------------------------------------
        */


        $employeeTasks = collect();


        if($karyawan)
        {

            $employeeTasks = Tugas::where(
                'karyawan_id',
                $karyawan->id
            )
            ->with([
                'proyek',
                'aktivitasTugas'
            ])
            ->get();

        }





        /*
        |--------------------------------------------------------------------------
        | PROJECT PROGRESS
        |--------------------------------------------------------------------------
        */


        $projectProgress = $employeeTasks

        ->groupBy(function($task){

            return $task->proyek->nama_proyek ?? 'Tanpa Project';

        })

        ->map(function($tasks){

            return round(
                $tasks->avg('progres_persen'),
                2
            );

        });







        /*
        |--------------------------------------------------------------------------
        | DEADLINE TASK
        |--------------------------------------------------------------------------
        */


        $deadlineTasks = $employeeTasks

        ->whereNotNull('deadline')

        ->where('status','!=','selesai')

        ->sortBy('deadline')

        ->take(5);








        /*
        |--------------------------------------------------------------------------
        | TASK CHART
        |--------------------------------------------------------------------------
        */


        $taskChart = [

            'done' => $employeeTasks

                ->where(
                    'status',
                    'selesai'
                )
                ->count(),



            'progress' => $employeeTasks

                ->whereIn(
                    'status',
                    [
                        'sedang_dikerjakan',
                        'progress'
                    ]
                )
                ->count(),



            'todo' => $employeeTasks

                ->whereIn(
                    'status',
                    [
                        'belum_dikerjakan',
                        'pending'
                    ]
                )
                ->count(),

        ];








        /*
        |--------------------------------------------------------------------------
        | TOTAL EXPENSE REQUEST
        |--------------------------------------------------------------------------
        */


        $totalExpenseRequest = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->count();








        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENGAJUAN TERBARU
        |--------------------------------------------------------------------------
        */


        $recentExpenseRequest = PengajuanDana::where(
            'pengguna_id',
            $user->id
        )
        ->latest()
        ->take(5)
        ->get();








        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */


        $recentActivities = $employeeTasks

        ->flatMap(function($task){


            return $task->aktivitasTugas->map(function($activity) use ($task){


                return [

                    'task' => $task->nama_tugas,

                    'aktivitas' => $activity->aktivitas ?? '-',

                    'tanggal' => $activity->tanggal,

                    'progress' => $task->progres_persen

                ];


            });


        })

        ->take(5);







        return view(
            'dashboard.karyawan',
            compact(

                'totalPengajuan',

                'pendingPengajuan',

                'approvedPengajuan',

                'rejectedPengajuan',

                'totalDana',

                'employeeTasks',

                'projectProgress',

                'deadlineTasks',

                'totalExpenseRequest',

                'taskChart',

                'recentExpenseRequest',

                'recentActivities'

            )
        );


    }

}