@extends('layouts.dashboard')

@section('content')


{{-- HEADER --}}

<div class="project-detail-header">


<div>

<div class="page-label">
PROJECT DETAIL
</div>


<h1>
{{ $project->nama_proyek }}
</h1>


<p>
Detail informasi project, perusahaan, anggaran, progress, dan aktivitas.
</p>


</div>



<a href="{{route('admin.projects.index')}}"
class="btn-back">

← Kembali

</a>


</div>









{{-- SUMMARY --}}


<div class="detail-grid">



<div class="detail-card">

<div class="icon">
📁
</div>


<div>

<span>
Nama Project
</span>


<h3>
{{$project->nama_proyek}}
</h3>


</div>

</div>






<div class="detail-card">

<div class="icon">
🏢
</div>


<div>

<span>
Perusahaan
</span>


<h3>

{{$project->perusahaan->nama_perusahaan ?? '-'}}

</h3>


</div>

</div>







<div class="detail-card">

<div class="icon">
💰
</div>


<div>

<span>
Total Budget
</span>


<h3>

Rp {{number_format(
$project->total_anggaran,
0,
',',
'.'
)}}

</h3>


</div>

</div>







<div class="detail-card">

<div class="icon">
📊
</div>


<div>

<span>
Progress
</span>


<h3>

{{$project->progres_keseluruhan ?? 0}}%

</h3>


</div>

</div>







<div class="detail-card">

<div class="icon">
🚦
</div>


<div>

<span>
Status Project
</span>


<h3>

{{$project->status_project}}

</h3>


</div>

</div>







<div class="detail-card">

<div class="icon">
💳
</div>


<div>

<span>
Status Keuangan
</span>


<h3>

{{$project->status_keuangan}}

</h3>


</div>

</div>







<div class="detail-card">

<div class="icon">
🏭
</div>


<div>

<span>
Project Perusahaan
</span>


<h3>

{{$project->perusahaan?->proyek->count() ?? 0}}

</h3>


</div>

</div>




</div>









{{-- INFORMATION --}}


<div class="glass-panel">


<div class="panel-title">

📋 Informasi Project

</div>





<table class="detail-table">


<tr>

<td>
Nama Project
</td>


<td>
{{$project->nama_proyek}}
</td>


</tr>




<tr>

<td>
Perusahaan
</td>


<td>
<strong class="company-name">

{{$project->perusahaan->nama_perusahaan ?? '-'}}

</strong>


@if($project->perusahaan)


<div class="company-status">


@if($project->perusahaan->status=='aktif')

<span class="status-company">
Aktif
</span>


@else


<span class="status inactive">

Nonaktif

</span>


@endif


</div>


@endif

</td>


</tr>






<tr>

<td>
Pemilik Project
</td>


<td>

{{$project->pemilik_proyek ?? '-'}}

</td>


</tr>






<tr>

<td>
Tanggal Mulai
</td>


<td>


{{$project->tanggal_mulai
?->format('d M Y')}}


</td>


</tr>






<tr>

<td>
Tanggal Selesai
</td>


<td>


{{$project->tanggal_selesai
?->format('d M Y') ?? '-'}}


</td>


</tr>






<tr>

<td>
Total Anggaran
</td>


<td>


<strong>

Rp {{number_format(
$project->total_anggaran,
0,
',',
'.'
)}}

</strong>


</td>


</tr>




</table>



</div>









{{-- STATISTIK --}}


<div class="stat-grid">





<div class="stat-card">


<div class="stat-icon">

📝

</div>


<div>

<label>
Total Tugas
</label>


<h2>

{{$project->tugas->count()}}

</h2>


<small>
Aktivitas project
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon">

👥

</div>


<div>

<label>
Anggota Project
</label>


<h2>

{{$project->users->count()}}

</h2>


<small>
User terlibat
</small>


</div>


</div>








<div class="stat-card">


<div class="stat-icon">

🏛️

</div>


<div>

<label>
Divisi Terlibat
</label>


<h2>

{{$project->alokasiDivisi->count()}}

</h2>


<small>
Unit organisasi
</small>


</div>


</div>






</div>









{{-- TASK --}}


<div class="glass-panel">


<div class="table-header">


<h3>

📝 Daftar Tugas Project

</h3>


<p>

Monitoring pekerjaan project

</p>


</div>





<table>


<thead>

<tr>

<th>
No
</th>


<th>
Nama Tugas
</th>


<th>
Status
</th>


<th>
Deadline
</th>


</tr>


</thead>




<tbody>


@forelse($project->tugas as $task)


<tr>


<td>

{{$loop->iteration}}

</td>


<td>

{{$task->nama_tugas ?? '-'}}

</td>


<td>

<span class="task-status">
{{$task->status}}
</span>



</td>


<td>


{{$task->deadline
? \Carbon\Carbon::parse($task->deadline)->format('d M Y')
: '-'}}


</td>


</tr>


@empty


<tr>

<td colspan="4"
class="empty">

Belum ada tugas

</td>

</tr>


@endforelse



</tbody>


</table>



</div>






<style>

*{
    box-sizing:border-box;
}


/* HEADER */

.project-detail-header{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

}


.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}


.project-detail-header h1{

    font-size:24px;

    margin:8px 0;

    font-weight:800;

    color:#1e293b;

}


.project-detail-header p{

    font-size:12px;

    color:#64748b;

}



.btn-back{

    background:#f1f5f9;

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    color:#334155;

}





/* SUMMARY CARD */

.detail-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin-bottom:20px;

}



.detail-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:14px;

    min-height:90px;

}



.detail-card .icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.detail-card span{

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.detail-card h3{

    margin:5px 0 0;

    font-size:15px;

    font-weight:800;

    color:#172033;

}







/* PANEL */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    margin-bottom:20px;

}



.panel-title{

    font-size:16px;

    font-weight:800;

    border-left:4px solid #334155;

    padding-left:10px;

    margin-bottom:18px;

}







/* DETAIL TABLE */


.detail-table{

    width:100%;

    border-collapse:collapse;

}



.detail-table td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:13px;

}



.detail-table td:first-child{

    width:180px;

    color:#64748b;

    font-weight:700;

}





.company-name{

    display:block;

    font-weight:800;

    margin-bottom:8px;

}







/* STATUS COMPANY */


.company-status{

    margin-top:5px;

}



.status-company{

    display:inline-flex;

    padding:5px 12px;

    border-radius:999px;

    background:#dcfce7;

    color:#166534;

    font-size:10px;

    font-weight:700;

}







/* STATISTIC */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin-bottom:20px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:14px;

}



.stat-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    display:flex;

    align-items:center;

    justify-content:center;

}



.stat-card label{

    font-size:11px;

    color:#64748b;

}



.stat-card h2{

    margin:5px 0;

    font-size:20px;

}







/* TABLE */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:12px;

    font-size:11px;

    color:#64748b;

    text-align:left;

}



td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

}








/* TASK STATUS */


.task-status{

    display:inline-flex;

    padding:5px 12px;

    border-radius:999px;

    background:#dcfce7;

    color:#166534;

    font-size:10px;

    font-weight:700;

}






.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

}






@media(max-width:1000px){

.detail-grid{

grid-template-columns:1fr;

}


.stat-grid{

grid-template-columns:1fr;

}


}


</style>


@endsection