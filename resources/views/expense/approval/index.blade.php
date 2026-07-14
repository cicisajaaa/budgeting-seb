@extends('layouts.dashboard')


@section('content')


<h2>
Approval Pengajuan Dana
</h2>



@if(session('success'))

<div class="card">

{{session('success')}}

</div>

@endif




<div class="card">


<table border="1" width="100%">


<tr>

<th>
Karyawan
</th>

<th>
Project
</th>

<th>
Divisi
</th>

<th>
Keperluan
</th>

<th>
Jumlah
</th>

<th>
Aksi
</th>

</tr>



@foreach($requests as $item)


<tr>


<td>

{{$item->user->name}}

</td>



<td>

{{$item->project->nama_project}}

</td>



<td>

{{$item->division->nama_divisi}}

</td>



<td>

{{$item->judul}}

</td>



<td>

Rp {{number_format($item->jumlah)}}

</td>



<td>


<form method="POST"
action="{{route('expense.approve',$item->id)}}">

@csrf

<button>
Approve
</button>

</form>



<br>


<form method="POST"
action="{{route('expense.reject',$item->id)}}">

@csrf

<button>
Reject
</button>

</form>


</td>


</tr>


@endforeach


</table>


</div>


@endsection