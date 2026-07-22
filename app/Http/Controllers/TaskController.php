<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Tugas;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. Menampilkan daftar tugas
    public function index(Proyek $project)
    {
        $tugas = $project->tasks()
            ->with([
                'division',
                'employee'
            ])
            ->orderBy('tanggal', 'desc')
            ->get();


        return view(
            'tasks.index',
            compact(
                'project',
                'tugas'
            )
        );
    }


    // 2. Menampilkan form tambah tugas baru
    public function create(Proyek $project)
    {
        $divisi = Divisi::all();

        $karyawan = Karyawan::all();


        return view(
            'tasks.create',
            compact(
                'project',
                'divisi',
                'karyawan'
            )
        );
    }


    // 3. Menyimpan tugas ke database
    public function store(Request $request, Proyek $project)
    {
        $request->validate([

            'division_id' => 'required|exists:divisions,id',

            'employee_id' => 'nullable|exists:employees,id',

            'tanggal' => 'required|date',

            'nama_task' => 'required|string|max:255',

            'aktivitas' => 'required|string',

            'prioritas' => 'required|in:Low,Medium,High',

            'status' => 'required|string',

            'progress_persen' => 'required|numeric|min:0|max:100',

        ]);



        $project->tasks()->create(
            $request->all()
        );



        return redirect()
            ->route(
                'tasks.index',
                $project->id
            )
            ->with(
                'success',
                'Tugas baru berhasil ditambahkan!'
            );
    }


    // 4. Memperbarui progres tugas
    public function updateStatus(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);



        $tugas->progress_persen = $request->progress_persen;



        $tugas->status = $request->progress_persen == 100
            ? 'Complete'
            : 'In Progress';



        $tugas->save();



        return redirect()
            ->back()
            ->with(
                'success',
                'Progress berhasil diperbarui!'
            );
    }
}