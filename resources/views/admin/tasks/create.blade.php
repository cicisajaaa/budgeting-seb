@extends('layouts.app')

@section('content')

<div class="container py-4">


<h2 class="fw-bold mb-4">
    Buat Task Baru
</h2>



<div class="card shadow-sm">

<div class="card-body">


<form method="POST"
action="{{ route('admin.tasks.store') }}">

@csrf



<div class="mb-3">

<label class="form-label">
    Project
</label>

<select name="project_id"
class="form-control"
required>


<option value="">
-- Pilih Project --
</option>


@foreach($projects as $project)

<option value="{{ $project->id }}">

{{ $project->nama_project }}

</option>

@endforeach


</select>

</div>





<div class="mb-3">

<label>
    Division
</label>


<select name="division_id"
class="form-control">


<option value="">
-- Pilih Division --
</option>


@foreach($divisions as $division)

<option value="{{ $division->id }}">

{{ $division->nama_divisi }}

</option>


@endforeach


</select>

</div>





<div class="mb-3">

<label>
    PIC / Employee
</label>


<select name="employee_id"
class="form-control"
required>


<option value="">
-- Pilih Employee --
</option>


@foreach($employees as $employee)


<option value="{{ $employee->id }}">

{{ $employee->nama_karyawan }}

</option>


@endforeach


</select>

</div>






<div class="mb-3">

<label>
    Nama Task
</label>


<input type="text"
name="nama_task"
class="form-control"
required>

</div>







<div class="mb-3">

<label>
    Aktivitas Awal
</label>


<textarea
name="aktivitas"
class="form-control"></textarea>


</div>






<div class="row">


<div class="col-md-6">

<label>
Prioritas
</label>


<select name="prioritas"
class="form-control">


<option value="Low">
Low
</option>


<option value="Medium">
Medium
</option>


<option value="High">
High
</option>


</select>


</div>





<div class="col-md-6">

<label>
Deadline
</label>


<input type="date"
name="deadline"
class="form-control">


</div>


</div>





<br>



<div class="mb-3">

<label>
Catatan
</label>


<textarea
name="catatan"
class="form-control"></textarea>


</div>





<button class="btn btn-primary">

Simpan Task

</button>



<a href="{{ route('admin.tasks.index') }}"
class="btn btn-secondary">

Kembali

</a>



</form>


</div>

</div>


</div>


@endsection