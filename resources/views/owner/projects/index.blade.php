@extends('layouts.dashboard')


@section('content')


<div class="page-header">


<span class="label">
PEMANTAUAN PROYEK
</span>


<h1>
Pemantauan Proyek Perusahaan
</h1>


<p>
Melihat perkembangan proyek, anggaran, tenggat waktu, dan kondisi pekerjaan perusahaan.
</p>


</div>







<div class="summary-grid">



<div class="summary-card">

<span>
Total Proyek
</span>


<h2>
{{ $totalProject ?? 0 }}
</h2>


<p>
Jumlah seluruh proyek
</p>


</div>





<div class="summary-card">

<span>
Total Anggaran
</span>


<h2>
Rp {{number_format(
$totalBudget ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Total nilai proyek
</p>


</div>





<div class="summary-card">

<span>
Proyek Berjalan
</span>


<h2>
{{ $projectBerjalan ?? 0 }}
</h2>


<p>
Sedang dalam pengerjaan
</p>


</div>





<div class="summary-card">

<span>
Proyek Selesai
</span>


<h2>
{{ $projectSelesai ?? 0 }}
</h2>


<p>
Telah diselesaikan
</p>


</div>



</div>









<div class="panel">


<h3>
📁 Daftar Pemantauan Proyek
</h3>





<table>


<thead>

<tr>

<th>
Nama Proyek
</th>


<th>
Pemilik Proyek
</th>


<th>
Anggaran
</th>


<th>
Progress
</th>


<th>
Deadline
</th>


<th>
Status
</th>


<th>
Aksi
</th>


</tr>


</thead>





<tbody>


@forelse($projects ?? [] as $project)



<tr>



<td>

<strong>
{{ $project->nama_proyek ?? '-' }}
</strong>

</td>





<td>

{{ $project->pemilik_proyek ?? '-' }}

</td>





<td>

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>






<td>


<div class="progress">


<div class="progress-fill"

style="width:{{ $project->progres_keseluruhan ?? 0 }}%">

</div>


</div>



<span>

{{ $project->progres_keseluruhan ?? 0 }}%

</span>



</td>







<td>

@if($project->tanggal_selesai)

{{\Carbon\Carbon::parse(
$project->tanggal_selesai
)->format('d M Y')}}

@else

-

@endif


</td>







<td>



@if(($project->progres_keseluruhan ?? 0) >= 100)


<span class="status selesai">
Selesai
</span>



@elseif(
$project->tanggal_selesai &&
\Carbon\Carbon::parse($project->tanggal_selesai)->isPast()
)


<span class="status terlambat">
Terlambat
</span>



@else


<span class="status berjalan">
Berjalan
</span>



@endif



</td>







<td>


<a href="{{ route('owner.project.detail',$project->id) }}"
class="btn-detail">

Detail

</a>


</td>




</tr>





@empty


<tr>

<td colspan="7" align="center">

Belum terdapat data proyek

</td>


</tr>



@endforelse



</tbody>



</table>


</div>









<style>


.page-header{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

color:#64748b;

}



.page-header h1{

font-size:28px;

margin:10px 0;

color:#1e293b;

}



.page-header p{

font-size:14px;

color:#64748b;

}







.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:25px;

}





.summary-card{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.summary-card span{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin-top:10px;

font-size:25px;

color:#6b4f1d;

}



.summary-card p{

font-size:12px;

color:#94a3b8;

}







.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.panel h3{

margin-bottom:20px;

color:#1e293b;

}





table{

width:100%;

border-collapse:collapse;

}



th{

text-align:left;

font-size:12px;

color:#64748b;

padding:15px;

}



td{

padding:15px;

border-bottom:1px solid #eee;

font-size:14px;

}







.progress{

height:8px;

width:160px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-fill{

height:100%;

background:#a67c2e;

}







.status{

padding:6px 14px;

border-radius:20px;

font-size:12px;

font-weight:600;

}



.berjalan{

background:#dcfce7;

color:#166534;

}



.selesai{

background:#dbeafe;

color:#1d4ed8;

}



.terlambat{

background:#fee2e2;

color:#991b1b;

}






.btn-detail{

display:inline-block;

padding:8px 18px;

border-radius:12px;

background:#6b4f1d;

color:white;

text-decoration:none;

font-size:12px;

font-weight:600;

}



.btn-detail:hover{

background:#a67c2e;

color:white;

}






@media(max-width:1000px){

.summary-grid{

grid-template-columns:repeat(2,1fr);

}

}



</style>



@endsection