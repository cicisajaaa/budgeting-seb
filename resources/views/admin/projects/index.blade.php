@extends('layouts.dashboard')


@section('content')


{{-- ================= HEADER ================= --}}


<div class="page-header-card">


<div>


<div class="page-label">
PROJECT MANAGEMENT
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








{{-- ================= STATISTIC ================= --}}


<div class="project-stat-grid">



<div class="project-stat">


<div class="stat-icon green">
📁
</div>


<div>

<span>
Total Project
</span>


<h3>
{{$projects->count()}}
</h3>


<small>
Project terdaftar
</small>


</div>


</div>








<div class="project-stat">


<div class="stat-icon blue">
🚀
</div>


<div>

<span>
Project Berjalan
</span>


<h3>

{{$projects->whereBetween(
'progres_keseluruhan',
[1,99]
)->count()}}

</h3>


<small>
Sedang dikerjakan
</small>


</div>


</div>








<div class="project-stat">


<div class="stat-icon orange">
✓
</div>


<div>

<span>
Project Selesai
</span>


<h3>

{{$projects->where(
'progres_keseluruhan',
100
)->count()}}

</h3>


<small>
Progress 100%
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



<div class="total-project">

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
Informasi
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


<div class="project-name">


<div class="project-icon">

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


<div class="project-info">


<span>

👤 
{{$project->pemilik_proyek ?? '-'}}

</span>



<span>

📅

{{\Carbon\Carbon::parse(
$project->tanggal_mulai
)->format('d M Y')}}

</span>



</div>


</td>









<td>


<strong class="budget-text">

Rp 

{{number_format(
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


<span class="status pending">

Belum Mulai

</span>



@elseif(($project->progres_keseluruhan ?? 0)<100)


<span class="status running">

Berjalan

</span>



@else


<span class="status done">

Selesai

</span>



@endif


</div>





<div class="progress-track">


<div style="
width:{{$project->progres_keseluruhan ?? 0}}%
">

</div>


</div>



</div>


</td>









<td>


<div class="action">



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

class="allocation"

title="Anggota">

👥

</a>

<a href="{{route(
'admin.tasks.create',
$project->id
)}}"

class="task"

title="Tambah Tugas">

📝

</a>

<form method="POST"

action="{{route(
'admin.projects.destroy',
$project->id
)}}">


@csrf

@method('DELETE')



<button class="delete"

title="Hapus"

onclick="
return confirm('Hapus project ini?')
">

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

.page-header-card,
.project-stat-grid,
.glass-panel{

    width:100%;

}



/* ===============================
HEADER
================================ */


.page-header-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:30px 32px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.06);

}



.page-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#94a3b8;

}



.page-header-card h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

    font-weight:800;

}



.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:14px;

}







/* ===============================
BUTTON
================================ */


.btn-primary{


    background:#1e293b;

    color:white;

    padding:13px 22px;

    border-radius:14px;

    font-size:13px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-primary:hover{

    background:#334155;

    transform:translateY(-2px);

}







/* ===============================
STATISTIC
================================ */


.project-stat-grid{


    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;


}




.project-stat{


    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:16px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);


}





.stat-icon{


    width:52px;

    height:52px;

    border-radius:16px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:23px;

}



.stat-icon.green{

    background:#dcfce7;

}



.stat-icon.blue{

    background:#dbeafe;

}



.stat-icon.orange{

    background:#fef3c7;

}





.project-stat span{

    font-size:12px;

    color:#64748b;

}



.project-stat h3{

    margin:5px 0;

    font-size:26px;

    color:#172033;

}



.project-stat small{

    font-size:11px;

    color:#94a3b8;

}









/* ===============================
ALERT
================================ */


.success-alert{


    background:#f0fdf4;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:15px 18px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:700;


}








/* ===============================
TABLE PANEL
================================ */


.glass-panel{


    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);


}






.table-header{


    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;


}



.table-header h3{


    margin:0;

    font-size:18px;

    color:#172033;


}



.table-header p{


    margin-top:5px;

    color:#64748b;

    font-size:13px;


}





.total-project{


    background:#eff6ff;

    color:#2563eb;

    padding:8px 16px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;


}









/* ===============================
TABLE
================================ */


.table-wrapper{

    width:100%;

    overflow-x:auto;

}



table{


    width:100%;

    border-collapse:collapse;


}



th{


    background:#f8fafc;

    padding:15px;

    text-align:left;

    font-size:12px;

    color:#64748b;


}



td{


    padding:18px 15px;

    border-bottom:1px solid #f1f5f9;

    font-size:13px;

    color:#334155;


}



tr:hover{

    background:#fafafa;

}









/* ===============================
PROJECT PROFILE
================================ */


.project-name{


    display:flex;

    align-items:center;

    gap:14px;


}





.project-icon{


    width:45px;

    height:45px;

    border-radius:15px;

    background:#eff6ff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;


}




.project-name strong{


    display:block;

    font-size:14px;

    color:#172033;


}




.project-name small{


    display:block;

    margin-top:4px;

    color:#94a3b8;

    font-size:11px;


}









/* ===============================
PROJECT INFO
================================ */


.project-info{


    display:flex;

    flex-direction:column;

    gap:7px;

    font-size:12px;

    color:#475569;


}








/* ===============================
BUDGET
================================ */


.budget-text{


    color:#172033;

    font-size:13px;

}








/* ===============================
PROGRESS
================================ */


.progress-box{

    width:150px;

}



.progress-label{


    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:8px;

    margin-bottom:8px;


}



.progress-label b{


    font-size:13px;

    color:#172033;


}





.progress-track{


    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;


}



.progress-track div{


    height:100%;

    background:#22c55e;

    border-radius:20px;


}









/* STATUS BADGE */


.status{


    padding:5px 10px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;


}



.status.pending{


    background:#f1f5f9;

    color:#64748b;


}



.status.running{


    background:#dcfce7;

    color:#166534;


}



.status.done{


    background:#dbeafe;

    color:#1d4ed8;


}









/* ===============================
ACTION
================================ */


.action{


    display:flex;

    gap:8px;

}



.action form{

    margin:0;

}





.edit,
.allocation,
.task,
.delete{


    width:38px;

    height:36px;

    border-radius:12px;

    display:flex;

    justify-content:center;

    align-items:center;

    border:none;

    text-decoration:none;

    cursor:pointer;

    font-size:15px;


}





.edit{


    background:#dbeafe;

    color:#2563eb;


}



.allocation{


    background:#fef3c7;

    color:#92400e;


}



.delete{


    background:#fee2e2;

    color:#dc2626;


}





.edit:hover{


    background:#2563eb;

    color:white;


}



.allocation:hover{


    background:#d97706;

    color:white;


}

.task{

    width:38px;

    height:36px;

    border-radius:12px;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#dcfce7;

    color:#166534;

    text-decoration:none;

    cursor:pointer;

    font-size:15px;

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

    padding:45px;

    color:#94a3b8;


}



.empty-icon{


    font-size:35px;

    margin-bottom:10px;


}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.project-stat-grid{

    grid-template-columns:repeat(2,1fr);

}


}





@media(max-width:800px){


.page-header-card{


    flex-direction:column;

    align-items:flex-start;

    gap:20px;


}



.project-stat-grid{


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