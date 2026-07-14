@extends('layouts.dashboard')


@section('content')


<h2>
Riwayat Pengajuan Dana
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
Keperluan
</th>

<th>
Jumlah
</th>

<th>
Status
</th>

</tr>



@foreach($requests as $item)


<tr>


<td>

{{ $item->project->nama_project }}

</td>



<td>

{{ $item->division->nama_divisi }}

</td>



<td>

{{ $item->judul }}

</td>



<td>

Rp {{ number_format($item->jumlah) }}

</td>



<td>


@if($item->status == 'pending')

<span>
Menunggu Persetujuan
</span>


@elseif($item->status == 'approved')


<span>
Disetujui
</span>


@else


<span>
Ditolak
</span>


@endif


</td>


</tr>


@endforeach


</table>


</div>


@endsection