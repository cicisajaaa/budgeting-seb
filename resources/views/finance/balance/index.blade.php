@extends('layouts.dashboard')


@section('content')


<h2>
Saldo Divisi
</h2>


<div class="card">


<table border="1" width="100%">


<tr>

<th>
Project
</th>

<th>
Divisi
</th>

<th>
Saldo
</th>

</tr>



@foreach($balances as $item)


<tr>


<td>
{{ $item->project->nama_project }}
</td>


<td>
{{ $item->division->nama_divisi }}
</td>


<td>
Rp {{ number_format($item->saldo) }}
</td>


</tr>


@endforeach


</table>


</div>


@endsection