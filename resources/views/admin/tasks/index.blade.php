@extends('layouts.app')

@section('content')

<div class="container py-4">


<h2 class="fw-bold mb-4">
    Task Manager
</h2>


<a href="{{ route('admin.tasks.create') }}"
class="btn btn-primary mb-3">

+ Buat Task

</a>



@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>

@endif



<div class="card shadow-sm">

<div class="card-body">


<table class="table table-bordered">


<thead>

<tr>

<th>No</th>
<th>Task</th>
<th>Project</th>
<th>PIC</th>
<th>Status</th>
<th>Progress</th>

</tr>

</thead>



<tbody>


@foreach($tasks as $task)


<tr>


<td>
{{ $loop->iteration }}
</td>


<td>

<b>
{{ $task->nama_task }}
</b>

<br>

<small>
{{ $task->aktivitas }}
</small>

</td>



<td>
{{ $task->project->nama_project ?? '-' }}
</td>



<td>
{{ $task->employee->nama_karyawan ?? '-' }}
</td>



<td>

<span class="badge bg-info">

{{ $task->status }}

</span>

</td>



<td>

{{ $task->progress_persen }}%

</td>



</tr>


@endforeach


</tbody>


</table>


</div>

</div>


</div>


@endsection