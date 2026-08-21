@extends('layouts.dashboard')

@section('content')


{{-- ================= HEADER ================= --}}

<div class="project-detail-header">


<div>

<div class="page-label">
PROJECT DETAIL
</div>


<h1>
{{ $project->nama_proyek }}
</h1>


<p>
Detail informasi project, anggaran, progress, dan aktivitas.
</p>


</div>



<a href="{{route('admin.projects.index')}}" class="btn-back">

← Kembali

</a>


</div>





{{-- ================= SUMMARY CARD ================= --}}


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



</div>








{{-- ================= INFORMATION ================= --}}



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
{{$project->perusahaan->nama_perusahaan ?? '-'}}
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

{{\Carbon\Carbon::parse(
$project->tanggal_mulai
)->format('d M Y')}}

</td>


</tr>




<tr>

<td>
Tanggal Selesai
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









{{-- ================= STATISTIC ================= --}}


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








{{-- ================= TASK ================= --}}



<div class="glass-panel">


<div class="table-header">


<div>

<h3>
Daftar Tugas Project
</h3>


<p>
Monitoring pekerjaan dalam project.
</p>


</div>


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


<span class="status">

{{$task->status}}

</span>


</td>




<td>

@if($task->deadline)

{{\Carbon\Carbon::parse(
$task->deadline
)->format('d M Y')}}

@else

-

@endif


</td>


</tr>


@empty


<tr>

<td colspan="4" class="empty">

Belum ada tugas

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


/* ===============================
HEADER
================================ */

.project-detail-header{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:24px 28px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}


.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.project-detail-header h1{

    margin:8px 0;

    font-size:25px;

    font-weight:800;

    color:#1e293b;

}



.project-detail-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:10px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    display:flex;

    align-items:center;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

}







/* ===============================
SUMMARY CARD
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

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

    gap:12px;

    position:relative;

    overflow:hidden;

}



.detail-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:3px;

    background:#334155;

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

    display:block;

    font-size:10px;

    color:#64748b;

    font-weight:600;

}



.detail-card h3{

    margin:4px 0 0;

    font-size:14px;

    color:#172033;

    font-weight:800;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px;

    margin-bottom:20px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}





.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:18px;

}








/* ===============================
DETAIL TABLE
================================ */


.detail-table{

    width:100%;

    border-collapse:collapse;

}



.detail-table td{

    padding:11px 12px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

}



.detail-table td:first-child{

    width:180px;

    color:#64748b;

    font-weight:700;

}



.detail-table td:last-child{

    color:#172033;

    font-weight:600;

}







/* ===============================
STATISTIC
================================ */


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

    gap:12px;

    position:relative;

    overflow:hidden;

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:3px;

    background:#334155;

}



.stat-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.stat-card label{

    font-size:10px;

    color:#64748b;

    font-weight:700;

}



.stat-card h2{

    margin:4px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}



.stat-card small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
TASK TABLE
================================ */


.table-header{

    margin-bottom:15px;

}



.table-header h3{

    margin:0;

    padding-left:10px;

    border-left:4px solid #334155;

    font-size:15px;

    font-weight:800;

    color:#172033;

}



.table-header p{

    margin:5px 0;

    font-size:11px;

    color:#64748b;

}




table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:11px;

    text-align:left;

    font-size:10px;

    color:#64748b;

}



td{

    padding:12px;

    font-size:12px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

}



tbody tr:hover{

    background:#fafafa;

}







/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    padding:5px 11px;

    border-radius:999px;

    background:#dcfce7;

    color:#166534;

    font-size:10px;

    font-weight:800;

}







/* ===============================
EMPTY
================================ */


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

    font-size:12px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){

    .detail-grid{

        grid-template-columns:repeat(2,1fr);

    }

}



@media(max-width:800px){


.project-detail-header{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.detail-grid,

.stat-grid{

    grid-template-columns:1fr;

}



table{

    min-width:700px;

}


}

</style>


@endsection