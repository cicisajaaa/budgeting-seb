@extends('layouts.dashboard')


@section('content')

<div class="dashboard-header">

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
Daftar Pemantauan Proyek
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

@php
    $progress = $project->progres_keseluruhan ?? 0;
@endphp


<div class="progress">


    <div class="progress-fill

    @if($progress >= 80)

        progress-green

    @elseif($progress >= 50)

        progress-blue

    @else

        progress-yellow

    @endif"

    style="width: {{ $progress }}%">

    </div>


</div>


<span class="progress-text">

{{ $progress }}%

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


@elseif(($project->progres_keseluruhan ?? 0) >= 50)

<span class="status berjalan">
Berjalan
</span>


@else

<span class="status aman">
Awal
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

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


body{
    font-family:Inter, system-ui, sans-serif;
}


/* ===============================
HEADER
================================ */


.dashboard-header{

    background:#f8fafc;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.dashboard-header h1{

    margin:8px 0;

    font-size:24px;

    line-height:1.3;

    color:#172033;

    font-weight:800;

}



.dashboard-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:22px;

}



.summary-card{

    background:white;

    padding:18px;

    min-height:105px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

    position:relative;

    overflow:hidden;

}



.summary-card:nth-child(1){

    border-top:4px solid #334155;

}


.summary-card:nth-child(2){

    border-top:4px solid #2563eb;

}


.summary-card:nth-child(3){

    border-top:4px solid #16a34a;

}


.summary-card:nth-child(4){

    border-top:4px solid #f59e0b;

}



.summary-card span{

    font-size:11px;

    color:#64748b;

    font-weight:600;

}



.summary-card h2{

    margin:8px 0;

    font-size:20px;

    color:#172033;

    font-weight:800;

}



.summary-card p{

    margin:0;

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
PANEL
================================ */


.panel{

    background:white;

    padding:22px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

    margin-bottom:22px;

}



.panel h3{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin:0 0 18px;

}







/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:13px;

    text-align:left;

    background:#f8fafc;

    color:#64748b;

    font-size:11px;

    font-weight:700;

}



td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    color:#172033;

    font-size:13px;

}







/* ===============================
PROGRESS
================================ */


.progress{

    width:140px;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

    display:inline-block;

    vertical-align:middle;

}



.progress-fill{

    height:100%;

    border-radius:20px;

    transition:.3s;

}



.progress-green{

    background:#16a34a;

}



.progress-blue{

    background:#2563eb;

}



.progress-yellow{

    background:#f59e0b;

}



.progress-text{

    margin-left:8px;

    font-size:12px;

    font-weight:700;

    color:#334155;

}







/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    align-items:center;

    gap:6px;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.status::before{

    content:"●";

    font-size:8px;

}



.selesai{

    background:#dbeafe;

    color:#1d4ed8;

}



.berjalan{

    background:#dcfce7;

    color:#166534;

}



.aman{

    background:#fef3c7;

    color:#92400e;

}



.terlambat{

    background:#fee2e2;

    color:#b91c1c;

}







/* ===============================
BUTTON
================================ */


.btn-detail{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    border-radius:12px;

    background:#0f172a;

    color:white;

    text-decoration:none;

    font-size:11px;

    font-weight:700;

}



.btn-detail:hover{

    background:#334155;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:700px){


.summary-grid{

    grid-template-columns:1fr;

}



.dashboard-header{

    padding:20px;

}



.panel{

    padding:18px;

}



table{

    display:block;

    overflow-x:auto;

}


}

</style>

@endsection