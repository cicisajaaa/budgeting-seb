<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. Menampilkan daftar tugas
    public function index(Project $project)
{
    // Pastikan ini return view('tasks.index', ...)
    $tasks = $project->tasks()->with(['division', 'employee'])->orderBy('tanggal', 'desc')->get();
    return view('tasks.index', compact('project', 'tasks'));
}

    // 2. Menampilkan Form Tambah Tugas Baru
    public function create(Project $project)
    {
        $divisions = Division::all();
        $employees = Employee::all();
        return view('tasks.create', compact('project', 'divisions', 'employees'));
    }

    // 3. Menyimpan Tugas ke Database
    public function store(Request $request, Project $project)
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

        $project->tasks()->create($request->all());

        return redirect()->route('tasks.index', $project->id)->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    // 4. Memperbarui Progres (Bisa dipanggil dari tombol di tabel)
  public function updateStatus(Request $request, $id)
{
    // Menggunakan findOrFail untuk memastikan jika ID tidak ada, errornya jelas
    $task = Task::findOrFail($id);
    
    $task->progress_persen = $request->progress_persen;
    $task->status = $request->progress_persen == 100 ? 'Complete' : 'In Progress';
    $task->save();

    // Langsung kembali ke halaman sebelumnya
    return redirect()->back()->with('success', 'Progress berhasil diupdate!');
}
}