@extends('layouts.dashboard')


@section('content')


<h2>
Input Pembayaran Client
</h2>


@if(session('success'))

<div class="card">
{{ session('success') }}
</div>

@endif



<div class="card">


<form method="POST"
action="{{ route('finance.deposit.store') }}">

@csrf


<label>
Project
</label>

<br>


<select name="project_id">


@foreach($projects as $project)

<option value="{{ $project->id }}">

{{ $project->nama_project }}

</option>


@endforeach


</select>


<br><br>


<label>
Jumlah Setoran
</label>

<br>


<input 
type="number"
name="jumlah_setoran"
placeholder="30000000"
>


<br><br>


<label>
Tanggal Setoran
</label>

<br>


<input
type="date"
name="tanggal_setoran"
>


<br><br>


<button type="submit">

Simpan

</button>


</form>


</div>



<div class="card">

<h3>
Riwayat Pembayaran
</h3>


<table border="1" width="100%">


<tr>

<th>
Project
</th>

<th>
Jumlah
</th>

<th>
Tanggal
</th>

</tr>



@foreach($deposits as $deposit)


<tr>

<td>
{{ $deposit->project->nama_project }}
</td>


<td>
Rp {{ number_format($deposit->jumlah_setoran) }}
</td>


<td>
{{ $deposit->tanggal_setoran }}
</td>


</tr>


@endforeach


</table>


</div>


@endsection