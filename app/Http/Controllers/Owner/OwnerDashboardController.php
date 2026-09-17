<?php

namespace App\Http\Controllers\Owner;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\PengajuanDana;
use App\Models\Tugas;
use App\Models\AktivitasTugas;
use App\Models\TransaksiDana;


class OwnerDashboardController extends Controller
{

public function index(Request $request)
{


/*
|--------------------------------------------------------------------------
| PROJECT DATA
|--------------------------------------------------------------------------
*/


$projects = Proyek::with([

    'tugas',
    'aktivitasTugas',
    'perusahaan',
    'transaksiDana'

])

->get()

->sortByDesc(function($project){

    return $project->tugas->count();

})

->unique('nama_proyek')

->values();

/* =========================================
| PROJECT DASHBOARD SEARCH
========================================= */

$search = $request->get('search');

$dashboardProjects = $projects
    ->when($search, function($collection) use ($search) {
        return $collection->filter(function($project) use ($search) {
            return str_contains(
                strtolower($project->nama_proyek),
                strtolower($search)
            );
        });
    })
    ->sortByDesc(function($project){
        return $project->created_at;
    })
    ->take(10)
    ->values();


/*
|--------------------------------------------------------------------------
| FINANCE CHART DATA
|--------------------------------------------------------------------------
*/


$financeProjects = $projects->map(function($project){


    return [

        'nama' => $project->nama_proyek,


        'budget' => (float) $project->total_anggaran,


        'realisasi' => (float) $project->transaksiDana->sum('jumlah'),


    ];


});

/*
|--------------------------------------------------------------------------
| TOP PROGRESS PROJECT
|--------------------------------------------------------------------------
*/

$progressProjects = $projects
    ->sortByDesc(function($project){
        return $project->created_at;
    })
    ->take(5)
    ->values();


/*
|--------------------------------------------------------------------------
| PROJECT SUMMARY
|--------------------------------------------------------------------------
*/


$totalProject = $projects->count();



$totalBudget = $projects->sum(function($project){

    return (float) $project->total_anggaran;

});






$totalRealisasi = TransaksiDana::sum('jumlah');

$totalCairDana = $totalRealisasi;


$sisaBudgetProyek = max(
    0,
    $totalBudget - $totalRealisasi
);






$progressProject = round(
    $projects
    ->filter(function($project){
        return $project->tugas->count() > 0;
    })
    ->avg(function($project){
        return $project->progres_keseluruhan;
    }) ?? 0
);





/*
|--------------------------------------------------------------------------
| APPROVAL FINANCE
|--------------------------------------------------------------------------
*/
$totalApprovedExpense = PengajuanDana::whereIn(
    'status',
    ['approved', 'selesai']
)
->sum('jumlah');





$pendingApproval = PengajuanDana::where(
    'status',
    'pending'
)

->count();








/*
|--------------------------------------------------------------------------
| PROJECT MONITORING
|--------------------------------------------------------------------------
*/


$criticalProjects = $projects->filter(function($project){


    return $project->persentase_budget >= 90;


});









/*
|--------------------------------------------------------------------------
| TASK MONITORING
|--------------------------------------------------------------------------
*/


$totalTask = Tugas::count();



$taskSelesai = Tugas::where(
    'status',
    'selesai'
)

->count();





$taskBerjalan = Tugas::where(
    'status',
    'sedang_dikerjakan'
)

->count();









/*
|--------------------------------------------------------------------------
| AKTIVITAS TERBARU
|--------------------------------------------------------------------------
*/

$recentTasks = AktivitasTugas::with([

    'tugas.proyek',

    'karyawan'

])

->latest('tanggal')

->get()

->unique('tugas_id')

->take(5)

->values();





/*
|--------------------------------------------------------------------------
| AKTIVITAS MONITORING
|--------------------------------------------------------------------------
*/


$totalAktivitas = AktivitasTugas::count();



$totalAnggaranAktivitas = AktivitasTugas::sum(
    'anggaran_aktivitas'
);




$projects = $projects->map(function($project){

    if($project->persentase_budget >= 90){

        $project->health_status = [
            'label' => 'Kritis',
            'color' => 'danger'
        ];

    }elseif($project->progres_keseluruhan < 50){

        $project->health_status = [
            'label' => 'Perhatian',
            'color' => 'warning'
        ];

    }else{

        $project->health_status = [
            'label' => 'Aman',
            'color' => 'success'
        ];

    }


    return $project;

});



return view(

    'dashboard.owner',

    compact(
        'projects',

        'dashboardProjects',

        'search',

        'totalProject',

        'totalBudget',

        'totalRealisasi',

        'sisaBudgetProyek',

        'totalApprovedExpense',

        'totalCairDana',

        'progressProject',

        'pendingApproval',

        'criticalProjects',

        'totalTask',

        'taskSelesai',

        'taskBerjalan',

        'recentTasks',

        'financeProjects',

        'totalAktivitas',

        'totalAnggaranAktivitas',

        'progressProjects',

    )

);


}


}