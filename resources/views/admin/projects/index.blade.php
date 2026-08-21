@extends('layouts.dashboard')


@section('content')


{{-- ================= HEADER ================= --}}


<div class="page-header-card">


<div>

<div class="page-label">
ADMINISTRASI
</div>


<h1>
Kelola Project
</h1>


<p>
Kelola informasi project, anggaran, progres, dan aktivitas perusahaan.
</p>


</div>



<a href="{{route('admin.projects.create')}}"
class="btn-primary">

＋ Tambah Project

</a>


</div>




@if(session('success'))

<div class="success-alert">

{{session('success')}}

</div>

@endif



@if($errors->any())

<div class="alert-error">

<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>

</div>

@endif






{{-- ================= STATISTIK ================= --}}


<div class="stat-grid">



<div class="stat-card">


<div class="stat-icon">

📁

</div>


<div>

<label>
Total Project
</label>


<h2>
{{$projects->count()}}
</h2>


<small>
Project terdaftar
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon green">

🚀

</div>


<div>

<label>
Project Berjalan
</label>


<h2>

{{$projects->filter(function($item){

return ($item->progres_keseluruhan ?? 0) > 0 
&& 
($item->progres_keseluruhan ?? 0) < 100;

})->count()}}

</h2>


<small>
Sedang dikerjakan
</small>


</div>


</div>








<div class="stat-card">


<div class="stat-icon blue">

✓

</div>


<div>

<label>
Project Selesai
</label>


<h2>

{{$projects->where(
'progres_keseluruhan',
100
)->count()}}

</h2>


<small>
Progress 100%
</small>


</div>


</div>









<div class="stat-card">


<div class="stat-icon gold">

💰

</div>


<div>

<label>
Total Budget
</label>


<h2>

Rp {{number_format(
$projects->sum('total_anggaran'),
0,
',',
'.'
)}}

</h2>


<small>
Seluruh anggaran project
</small>


</div>


</div>



</div>









{{-- ================= TABLE ================= --}}


<div class="glass-panel">



<div class="table-header">


<div>

<h3>
Daftar Project
</h3>


<p>
Monitoring seluruh project perusahaan.
</p>


</div>



<div class="total-user">

{{$projects->count()}}

Project

</div>



</div>







<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
No
</th>


<th>
Project
</th>


<th>
Perusahaan
</th>


<th>
Budget
</th>


<th>
Progress
</th>


<th>
Aksi
</th>


</tr>


</thead>



<tbody>


@forelse($projects as $project)


<tr>


<td>

{{$loop->iteration}}

</td>




<td>


<div class="user-profile">


<div class="avatar project-avatar">

📁

</div>



<div>

<strong>

{{$project->nama_proyek}}

</strong>


<small>
Project Perusahaan
</small>


</div>


</div>


</td>






<td>


<strong>

{{$project->perusahaan->nama_perusahaan ?? '-'}}

</strong>


<br>


<small>

{{$project->pemilik_proyek ?? '-'}}

</small>


</td>






<td>


<strong class="budget-text">


Rp {{number_format(
$project->total_anggaran,
0,
',',
'.'
)}}


</strong>


</td>





<td>


<div class="progress-box">


<div class="progress-label">


<b>

{{$project->progres_keseluruhan ?? 0}}%

</b>


@if(($project->progres_keseluruhan ?? 0)==0)

<span class="badge pending">
Belum Mulai
</span>


@elseif(($project->progres_keseluruhan ?? 0)<100)

<span class="badge running">
Berjalan
</span>


@else


<span class="badge done">
Selesai
</span>


@endif


</div>





<div class="progress-track">


<div

style="
width:{{$project->progres_keseluruhan ?? 0}}%;
background:
@if(($project->progres_keseluruhan ?? 0)==100)
#2563eb
@elseif(($project->progres_keseluruhan ?? 0)>=50)
#22c55e
@else
#f59e0b
@endif
">

</div>


</div>


</div>


</td>

<td>


<div class="action">


<a href="{{route(
'admin.projects.show',
$project->id
)}}"
class="detail"
title="Detail">

👁

</a>





<a href="{{route(
'admin.projects.edit',
$project->id
)}}"
class="edit"
title="Edit">

✏️

</a>





<a href="{{route(
'admin.allocation.index',
['project'=>$project->id]
)}}"
class="allocation"
title="Dana">

💰

</a>






<a href="{{route(
'admin.members.index',
$project->id
)}}"
class="member"
title="Anggota">

👥

</a>






<a href="{{route(
'admin.tasks.create',
$project->id
)}}"
class="task"
title="Tambah Task">

📝

</a>







<form method="POST"

action="{{route(
'admin.projects.destroy',
$project->id
)}}">


@csrf

@method('DELETE')


<button

class="delete"

onclick="
return confirm('Hapus project ini?')
"

title="Hapus">

🗑

</button>


</form>



</div>


</td>



</tr>





@empty


<tr>


<td colspan="6" class="empty">


<div class="empty-icon">

📁

</div>


Belum ada project


<br>


<small>

Tambahkan project baru untuk memulai.

</small>


</td>


</tr>


@endforelse



</tbody>


</table>


</div>


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

.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}


.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}






/* ===============================
BUTTON
================================ */


.btn-primary{

    display:flex;

    align-items:center;

    justify-content:center;

    background:#334155;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-primary:hover{

    background:#1e293b;

}






/* ===============================
ALERT
================================ */


.success-alert{

    background:#dcfce7;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

}



.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

}







/* ===============================
STATISTIC
================================ */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    min-height:95px;

    display:flex;

    align-items:center;

    gap:14px;

    position:relative;

    overflow:hidden;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.stat-card:nth-child(2)::before{

    background:#16a34a;

}



.stat-card:nth-child(3)::before{

    background:#2563eb;

}



.stat-card:nth-child(4)::before{

    background:#f59e0b;

}





.stat-icon{

    width:42px;

    height:42px;

    border-radius:13px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    flex-shrink:0;

    background:#f1f5f9;

}



.stat-card:nth-child(1) .stat-icon{

    background:#dbeafe;

}



.stat-card:nth-child(2) .stat-icon{

    background:#dcfce7;

}



.stat-card:nth-child(3) .stat-icon{

    background:#dbeafe;

}



.stat-card:nth-child(4) .stat-icon{

    background:#fef3c7;

}





.stat-card label{

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.stat-card h2{

    font-size:20px;

    margin:5px 0;

    font-weight:800;

    color:#1e293b;

}



.stat-card small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}






/* ===============================
TABLE HEADER
================================ */


.table-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}



.table-header h3{

    margin:0;

    padding-left:10px;

    border-left:4px solid #334155;

    font-size:15px;

    font-weight:800;

    color:#1e293b;

}



.table-header p{

    margin:5px 0;

    font-size:11px;

    color:#64748b;

}



.total-user{

    background:#f1f5f9;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}







/* ===============================
TABLE
================================ */


.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:12px;

    background:#f8fafc;

    color:#64748b;

    font-size:11px;

    text-align:left;

}



td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr{

    transition:.2s;

}



tbody tr:hover{

    background:#f8fafc;

}






/* ===============================
PROJECT PROFILE
================================ */


.user-profile{

    display:flex;

    align-items:center;

    gap:12px;

}



.avatar{

    width:36px;

    height:36px;

    border-radius:12px;

    display:flex;

    justify-content:center;

    align-items:center;

}



.project-avatar{

    background:#dbeafe;

    font-size:15px;

}



.user-profile strong{

    display:block;

    color:#1e293b;

    font-size:12px;

}



.user-profile small{

    color:#94a3b8;

    font-size:10px;

}







/* ===============================
BUDGET
================================ */


.budget-text{

    color:#166534;

    font-size:12px;

    font-weight:800;

}







/* ===============================
PROGRESS
================================ */


.progress-box{

    width:140px;

}



.progress-label{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:6px;

}



.progress-label b{

    font-size:11px;

}



.progress-track{

    height:7px;

    background:#e2e8f0;

    border-radius:999px;

    overflow:hidden;

}



.progress-track div{

    height:100%;

    border-radius:999px;

}







/* ===============================
BADGE
================================ */


.badge{

    padding:4px 9px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.pending{

    background:#f1f5f9;

    color:#64748b;

}



.running{

    background:#dcfce7;

    color:#166534;

}



.done{

    background:#dbeafe;

    color:#1d4ed8;

}







/* ===============================
ACTION ICON
================================ */


.action{

    display:flex;

    gap:6px;

    flex-wrap:wrap;

}



.action form{

    margin:0;

}



.detail,
.edit,
.allocation,
.member,
.task,
.delete{

    width:32px;

    height:32px;

    border-radius:10px;

    display:flex;

    justify-content:center;

    align-items:center;

    border:none;

    cursor:pointer;

    text-decoration:none;

    font-size:13px;

    transition:.2s;

}



.detail{

    background:#dcfce7;

}



.edit{

    background:#dbeafe;

}



.allocation{

    background:#fef3c7;

}



.member{

    background:#ede9fe;

}



.task{

    background:#dcfce7;

}



.delete{

    background:#fee2e2;

}




.detail:hover{

    background:#16a34a;

    color:white;

}


.edit:hover{

    background:#2563eb;

    color:white;

}


.allocation:hover{

    background:#d97706;

    color:white;

}


.member:hover{

    background:#7c3aed;

    color:white;

}


.task:hover{

    background:#16a34a;

    color:white;

}


.delete:hover{

    background:#dc2626;

    color:white;

}







/* ===============================
EMPTY
================================ */


.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

    font-size:12px;

}



.empty-icon{

    font-size:30px;

    margin-bottom:10px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.stat-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:800px){


.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.stat-grid{

    grid-template-columns:1fr;

}



.table-header{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



}


</style>


@endsection