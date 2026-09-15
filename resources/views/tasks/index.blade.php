@extends('layouts.app')

@section('content')
<div class="card">
    <div class="task-header">
        <h2>Daily Tracker: {{ $project->nama_project }}</h2>
        <a href="{{ route('tasks.create', $project->id) }}" class="btn btn-success">+ Tambah Task Baru</a>
    </div>
    <p><a href="{{ route('dashboard') }}" style="color: #007bff; text-decoration: none;">&larr; Kembali ke Dashboard</a></p>
</div>

<div class="card">
    <h3>Daftar Tugas</h3>
    <div class="table-wrapper">
<table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Task</th>
                <th>PIC</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ \Carbon\Carbon::parse($task->tanggal)->format('d/m/y') }}</td>
                <td>{{ $task->nama_task }}</td>
                <td>{{ $task->employee->nama_karyawan ?? '-' }}</td>
                <td>{{ $task->prioritas }}</td>
                <td>{{ $task->status }}</td>
                <td>
                    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" style="display: flex; gap: 5px;">
                        @csrf
                        <input type="number" name="progress_persen" value="{{ $task->progress_persen }}" min="0" max="100" style="width: 50px;">
                        <input type="hidden" name="status" value="{{ $task->status }}">
                        <button type="submit" class="btn" style="padding: 2px 8px; font-size: 12px; background: #28a745;">Update</button>
                    </form>
                </td>
                <td>
                    <strong>{{ $task->progress_persen }}%</strong>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada data tugas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<style>

.task-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.table-wrapper table{
    min-width:850px;
}

@media(max-width:700px){

    .card{
        padding:16px;
        box-sizing:border-box;
    }

    .task-header{
        flex-direction:column;
        align-items:stretch;
    }

    .task-header h2{
        font-size:20px;
        line-height:1.4;
        margin:0;
    }

    .task-header .btn{
        width:100%;
        text-align:center;
        box-sizing:border-box;
    }

    .table-wrapper table{
        min-width:800px;
    }

    th,
    td{
        white-space:nowrap;
    }

    td form{
        min-width:120px;
    }

}

@media(max-width:480px){

    .card{
        padding:14px;
    }

    .task-header h2{
        font-size:18px;
    }

}

</style>
@endsection