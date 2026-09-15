@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Tambah Task Baru</h2>
    <p>Project: <strong>{{ $project->nama_project }}</strong></p>

    <form action="{{ route('tasks.store', $project->id) }}" method="POST">
        @csrf
        <table class="task-form-table">
            <tr>
                <td style="border: none;"><label>Tanggal:</label></td>
                <td style="border: none;"><input type="date" name="tanggal" required style="width: 100%; padding: 8px;"></td>
            </tr>
            <tr>
                <td style="border: none;"><label>Divisi:</label></td>
                <td style="border: none;">
                    <select name="division_id" required style="width: 100%; padding: 8px;">
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}">{{ $div->nama_divisi }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><label>Person In Charge (PIC):</label></td>
                <td style="border: none;">
                    <select name="employee_id" style="width: 100%; padding: 8px;">
                        <option value="">-- Pilih PIC --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nama_karyawan }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><label>Nama Task:</label></td>
                <td style="border: none;"><input type="text" name="nama_task" placeholder="Contoh: UKL UPL 01" required style="width: 100%; padding: 8px;"></td>
            </tr>
            <tr>
                <td style="border: none;"><label>Aktivitas:</label></td>
                <td style="border: none;"><textarea name="aktivitas" rows="3" required style="width: 100%; padding: 8px;"></textarea></td>
            </tr>
            <tr>
                <td style="border: none;"><label>Prioritas:</label></td>
                <td style="border: none;">
                    <select name="prioritas" required style="width: 100%; padding: 8px;">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><label>Status:</label></td>
                <td style="border: none;"><input type="text" name="status" value="In Progress" required style="width: 100%; padding: 8px;"></td>
            </tr>
            <tr>
                <td style="border: none;"><label>Progress Awal (%):</label></td>
                <td style="border: none;"><input type="number" name="progress_persen" value="0" min="0" max="100" required style="width: 100%; padding: 8px;"></td>
            </tr>
        </table>
        
        <br>
        <button type="submit" class="btn btn-success">Simpan Task Baru</button>
        <a href="{{ route('tasks.index', $project->id) }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
</div>

<style>
.task-form-table{
    border:none;
    width:100%;
    max-width:600px;
}

.task-form-table td{
    border:none;
    padding:8px 0;
}

.task-form-table input,
.task-form-table select,
.task-form-table textarea{
    width:100%;
    padding:8px;
    box-sizing:border-box;
}

@media(max-width:600px){

    .card{
        width:100%;
        padding:16px;
        box-sizing:border-box;
    }

    .card h2{
        font-size:20px;
    }

    .task-form-table,
    .task-form-table tbody,
    .task-form-table tr,
    .task-form-table td{
        display:block;
        width:100%;
    }

    .task-form-table tr{
        margin-bottom:12px;
    }

    .task-form-table td:first-child{
        padding-bottom:5px;
    }

    .task-form-table td:last-child{
        padding-top:0;
    }

    .task-form-table input,
    .task-form-table select,
    .task-form-table textarea{
        width:100%;
        min-height:42px;
        font-size:14px;
    }

    .task-form-table textarea{
        min-height:90px;
    }

    .btn{
        display:block;
        width:100%;
        box-sizing:border-box;
        text-align:center;
        margin-top:8px;
    }

}
</style>
@endsection