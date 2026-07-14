@extends('layouts.dashboard')


@section('content')


<h2>
Distribusi Dana
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
Nominal
</th>

</tr>



@foreach($distributions as $item)


<tr>

<td>
{{ $item->deposit->project->nama_project }}
</td>


<td>
{{ $item->division->nama_divisi }}
</td>


<td>
Rp {{ number_format($item->nominal_diterima) }}
</td>


</tr>


@endforeach



</table>


</div>


@endsection