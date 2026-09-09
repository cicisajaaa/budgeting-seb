<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Tugas;
use App\Models\Proyek;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Perusahaan;


use App\Helpers\AuditHelper;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TaskImport;
class TaskController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Monitoring Semua Task
    |--------------------------------------------------------------------------
    */
public function index(Request $request)
{
    $query = Tugas::with([
        'proyek.perusahaan',
        'karyawan',
        'divisi'
    ]);

    // =========================
    // SEARCH
    // =========================
    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where('nama_tugas', 'like', "%{$search}%")

              ->orWhereHas('proyek', function ($project) use ($search) {

                  $project->where(
                      'nama_proyek',
                      'like',
                      "%{$search}%"
                  );

              });

        });

    }






    // =========================
// FILTER PERUSAHAAN
// =========================

if ($request->filled('perusahaan_id')) {

    $query->whereHas('proyek', function ($q) use ($request) {

        $q->where(
            'perusahaan_id',
            $request->perusahaan_id
        );

    });

}


// =========================
// FILTER PROJECT
// =========================

if ($request->filled('project_id')) {

    $query->where(
        'proyek_id',
        $request->project_id
    );

}

    // =========================
    // FILTER STATUS
    // =========================
    if (
        $request->filled('status')
        && $request->status !== 'all'
    ) {

        $query->where(
            'status',
            $request->status
        );

    }


    // =========================
    // FILTER DIVISI
    // =========================
    if ($request->filled('divisi_id')) {

        $query->where(
            'divisi_id',
            $request->divisi_id
        );

    }


    // =========================
    // FILTER PIC
    // =========================
    if ($request->filled('karyawan_id')) {

        $query->where(
            'karyawan_id',
            $request->karyawan_id
        );

    }


    // =========================
    // DATA
    // =========================
    $tasks = $query
        ->latest()
        ->get();

    $averageProgress = $tasks->count()
    ? round($tasks->avg('progres_persen'))
    : 0;




    $progressByDivision = $tasks
    ->groupBy(function ($task) {
        return $task->divisi->nama_divisi ?? 'Tanpa Divisi';
    })
    ->map(function ($divisionTasks) {
        return [
            'total' => $divisionTasks->count(),
            'progress' => round(
                $divisionTasks->avg('progres_persen')
            ),
        ];
    })
    ->sortByDesc('progress');


    $progressByPIC = $tasks
    ->groupBy(function ($task) {
        return $task->karyawan->nama_karyawan ?? 'Tanpa PIC';
    })
    ->map(function ($picTasks) {
        $totalTask = $picTasks->count();

        return [
            'total' => $totalTask,

            'progress' => round(
                $picTasks->avg('progres_persen')
            ),

            'level' => $totalTask >= 15
                ? 'Tinggi'
                : ($totalTask >= 8 ? 'Sedang' : 'Normal'),
        ];
    })
    ->sortByDesc('total')
    ->take(10);
    // Data untuk dropdown filter
$divisi = Divisi::orderBy('nama_divisi')->get();

$karyawan = Karyawan::orderBy('nama_karyawan')->get();

$perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

$projects = Proyek::orderBy('nama_proyek')->get();

    return view(
        'admin.tasks.index',
compact(
    'tasks',
    'divisi',
    'karyawan',
    'perusahaan',
    'projects',
    'averageProgress',
    'progressByDivision',
    'progressByPIC'
)
    );
}





    /*
    |--------------------------------------------------------------------------
    | Detail Task
    |--------------------------------------------------------------------------
    */

    public function show(Tugas $task)
    {


$task->load([

    'proyek',
    'karyawan',
    'divisi',

'aktivitasTugas'=>function($query){

    $query->with('karyawan')
          ->orderByDesc('tanggal')
          ->orderByDesc('created_at');

}

]);


        return view(

            'admin.tasks.show',

            compact('task')

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Form Tambah Task
    |--------------------------------------------------------------------------
    */

    public function create(Proyek $project)
    {


        $karyawan = Karyawan::with('divisi')->get();

        $divisi = Divisi::all();



        return view(

            'admin.tasks.create',

            compact(

                'project',
                'karyawan',
                'divisi'

            )

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Simpan Task
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, Proyek $project)
    {


        $request->validate([


            'nama_tugas'=>'required|string|max:255',

            'divisi_id'=>'nullable|exists:divisi,id',

            'karyawan_id'=>'nullable|exists:karyawan,id',

            'tanggal'=>'required|date',

            'aktivitas'=>'required|string',

            'prioritas'=>'required|in:Low,Medium,High',

            'deadline'=>'nullable|date',

            'progres_persen'=>'required|numeric|min:0|max:100',

            'catatan'=>'nullable|string'


        ]);




        $task = $project->tugas()->create([


            'nama_tugas'=>$request->nama_tugas,

            'divisi_id'=>$request->divisi_id,

            'karyawan_id'=>$request->karyawan_id,

            'tanggal'=>$request->tanggal,

            'aktivitas'=>$request->aktivitas,

            'prioritas'=>$request->prioritas,

            'deadline'=>$request->deadline,

            'progres_persen'=>$request->progres_persen,

            'catatan'=>$request->catatan,


        ]);






        AuditHelper::create(

            'Tambah Task',

            'Manajemen Task',

            'Admin menambahkan task '.$task->nama_tugas

        );





        return redirect()

        ->route('admin.tasks.index')

        ->with(

            'success',

            'Tugas berhasil ditambahkan'

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Form Edit Task
    |--------------------------------------------------------------------------
    */
public function edit(Tugas $task)
{
    $task->load([
        'proyek.perusahaan',
        'karyawan',
        'divisi',
    ]);

    $divisi = Divisi::orderBy('nama_divisi')->get();

    $karyawan = Karyawan::orderBy('nama_karyawan')->get();

    $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

    $projects = Proyek::orderBy('nama_proyek')->get();

    return view(
        'admin.tasks.edit',
        compact(
            'task',
            'divisi',
            'karyawan',
            'perusahaan',
            'projects'
        )
    );
}






    /*
    |--------------------------------------------------------------------------
    | Update Task
    |--------------------------------------------------------------------------
    */
public function update(Request $request, Tugas $task)
{
    $validated = $request->validate([
        'perusahaan_id' => [
            'required',
            'exists:perusahaans,id',
        ],

        'proyek_id' => [
            'required',
            'exists:proyek,id',
            Rule::exists('proyek', 'id')->where(function ($query) use ($request) {
                $query->where('perusahaan_id', $request->perusahaan_id);
            }),
        ],

        'nama_tugas' => 'required|string|max:255',

        'divisi_id' => 'nullable|exists:divisi,id',

        'karyawan_id' => 'nullable|exists:karyawan,id',

        'tanggal' => 'required|date',

        'aktivitas' => 'required|string',

        'prioritas' => 'required|in:Low,Medium,High',

        'deadline' => 'nullable|date',

        'progres_persen' => 'required|numeric|min:0|max:100',

        'catatan' => 'nullable|string',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Status Otomatis
    |--------------------------------------------------------------------------
    */

    $status = $task->status;

    if ($task->status !== 'dibatalkan') {

        if ($validated['progres_persen'] >= 100) {

            $status = 'selesai';

        } elseif ($validated['progres_persen'] > 0) {

            $status = 'sedang_dikerjakan';

        } else {

            $status = 'belum_dikerjakan';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update Task
    |--------------------------------------------------------------------------
    */

    $task->update([

        'proyek_id' => $validated['proyek_id'],

        'nama_tugas' => $validated['nama_tugas'],

        'divisi_id' => $validated['divisi_id'] ?? null,

        'karyawan_id' => $validated['karyawan_id'] ?? null,

        'tanggal' => $validated['tanggal'],

        'aktivitas' => $validated['aktivitas'],

        'prioritas' => $validated['prioritas'],

        'deadline' => $validated['deadline'] ?? null,

        'progres_persen' => $validated['progres_persen'],

        'status' => $status,

        'catatan' => $validated['catatan'] ?? null,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Simpan Riwayat Aktivitas
    |--------------------------------------------------------------------------
    */

    $task->aktivitasTugas()->create([

        'karyawan_id' => $task->karyawan_id,

        'tanggal' => now(),

        'aktivitas' => $validated['aktivitas'],

        'progres' => $validated['progres_persen'],

        'anggaran_aktivitas' => 0,

        'catatan' => $validated['catatan'] ?? 'Update task oleh Admin',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    AuditHelper::create(
        'Update Task',
        'Manajemen Task',
        'Admin memperbarui task ' . $task->nama_tugas
    );

    return redirect()
        ->route('admin.tasks.show', $task->id)
        ->with(
            'success',
            'Task berhasil diperbarui'
        );
}


    /*
    |--------------------------------------------------------------------------
    | Batalkan Task
    |--------------------------------------------------------------------------
    */

    public function cancel(Tugas $task)
    {


        $task->update([

            'status'=>'dibatalkan'

        ]);





        AuditHelper::create(

            'Batalkan Task',

            'Manajemen Task',

            'Admin membatalkan task '.$task->nama_tugas

        );






        return back()

        ->with(

            'success',

            'Task berhasil dibatalkan'

        );


    }
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    $import = new TaskImport();

    Excel::import(
        $import,
        $request->file('file')
    );

    AuditHelper::create(
        'Import Task',
        'Manajemen Task',
        'Admin melakukan import data task dari Excel'
    );

    $pesan = 'Data task berhasil diproses. '
        . 'Berhasil: ' . $import->success
        . ' | Dilewati: ' . $import->failed;

    if (!empty($import->errors)) {
        $pesan .= ' | Detail: '
            . implode(' || ', $import->errors);
    }

    return redirect()
        ->route('admin.tasks.index')
        ->with('success', $pesan);
}


}
