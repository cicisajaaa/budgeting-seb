@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>


<div class="page-label">
PROJECT MANAGEMENT
</div>


<h1>
Kelola Project
</h1>


<p>
Kelola informasi project, anggaran, progres, dan alokasi dana perusahaan.
</p>


</div>



<a href="{{ route('admin.projects.create') }}" class="btn-primary">

＋ Tambah Project

</a>


</div>








{{-- STATISTIC --}}


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
Project Aktif
</span>


<h3>

{{$projects->where('progres_keseluruhan','<',100)->count()}}

</h3>


<small>
Sedang berjalan
</small>


</div>


</div>








<div class="project-stat">


<div class="stat-icon orange">
💰
</div>


<div>

<span>
Total Budget
</span>


<h3>

Rp {{number_format(
$projects->sum('total_anggaran'),
0,
',',
'.'
)}}

</h3>


<small>
Nilai keseluruhan
</small>


</div>


</div>



</div>









@if(session('success'))


<div class="success-alert">


<div>
✓
</div>


{{session('success')}}


</div>


@endif









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

{{$projects->count()}} Project

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
Owner
</th>


<th>
Budget
</th>


<th>
Periode
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

{{$project->pemilik_proyek ?? '-'}}

</td>








<td>


<span class="budget-text">


Rp {{number_format(
$project->total_anggaran,
0,
',',
'.'
)}}


</span>


</td>








<td>


<div class="date">


{{\Carbon\Carbon::parse(
$project->tanggal_mulai
)->format('d M Y')}}



<br>


<span>
s/d
</span>


<br>



@if($project->tanggal_selesai)

{{\Carbon\Carbon::parse(
$project->tanggal_selesai
)->format('d M Y')}}

@else

-

@endif



</div>


</td>
<td>


<div class="progress-box">


<div class="progress-label">


<span>
Progress
</span>


<b>

{{$project->progres_keseluruhan ?? 0}}%

</b>


</div>





<div class="progress-track">


<div style="width:{{$project->progres_keseluruhan ?? 0}}%">

</div>


</div>



</div>


</td>








<td>


<div class="action">



<a href="{{route('admin.projects.edit',$project->id)}}"

class="edit">

Edit

</a>






<a href="{{route('admin.allocation.index',['project'=>$project->id])}}"

class="allocation">

Dana

</a>






<form method="POST"

action="{{route('admin.projects.destroy',$project->id)}}">


@csrf

@method('DELETE')



<button class="delete"

onclick="return confirm('Hapus project ini?')">

Hapus

</button>



</form>


</div>


</td>



</tr>



@empty


<tr>

<td colspan="7" class="empty">

Belum ada project

</td>

</tr>



@endforelse



</tbody>


</table>


</div>


</div>





<style>

/* ===============================
HEADER CARD
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

    padding:12px 22px;

    border-radius:14px;

    font-size:13px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-primary:hover{

    background:#b8863b;

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

    width:48px;

    height:48px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

}



.stat-icon.green{

    background:#f1f5f9;

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

    font-size:25px;

    color:#172033;

}





.project-stat small{

    color:#94a3b8;

    font-size:11px;

}








/* ===============================
ALERT
================================ */


.success-alert{


    background:#f0fdf4;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:14px 18px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:600;


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


    font-size:18px;

    color:#172033;

    margin:0 0 5px;


}



.table-header p{


    color:#64748b;

    font-size:13px;

    margin:0;


}





.total-project{


    background:#f8fafc;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:8px 16px;

    border-radius:999px;

    font-size:12px;

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


    background:#f8fafc;

    padding:14px;

    text-align:left;

    font-size:12px;

    color:#64748b;


}



td{


    padding:15px;

    border-bottom:1px solid #e5e7eb;

    font-size:13px;

    color:#334155;


}



tr:hover{

    background:#fafafa;

}








/* ===============================
PROJECT NAME
================================ */


.project-name{


    display:flex;


    align-items:center;


    gap:12px;


}





.project-icon{


    width:40px;


    height:40px;


    border-radius:14px;


    background:#f1f5f9;


    display:flex;


    align-items:center;


    justify-content:center;


}





.project-name strong{


    display:block;


    color:#172033;


    font-size:13px;


}



.project-name small{


    color:#94a3b8;


    font-size:11px;


}







/* ===============================
BUDGET
================================ */


.budget-text{


    font-weight:700;


    color:#172033;


}








/* ===============================
DATE
================================ */


.date{


    font-size:12px;


    color:#475569;


}



.date span{


    color:#94a3b8;


}








/* ===============================
PROGRESS
================================ */


.progress-box{

    width:130px;

}



.progress-label{


    display:flex;


    justify-content:space-between;


    font-size:11px;


    margin-bottom:6px;


}



.progress-label b{


    color:#16a34a;


}





.progress-track{


    height:8px;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}



.progress-track div{


    height:100%;


    background:#16a34a;


    border-radius:20px;


}








/* ===============================
ACTION
================================ */


.action{


    display:flex;


    gap:7px;


}



.action form{


    display:inline;


}




.edit,
.allocation,
.delete{


    padding:8px 12px;


    border-radius:12px;


    font-size:11px;


    font-weight:700;


    text-decoration:none;


    border:none;


    cursor:pointer;


}




.edit{


    background:#dbeafe;


    color:#1d4ed8;


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



.delete:hover{


    background:#dc2626;

    color:white;

}








.empty{


    text-align:center;

    padding:30px;

    color:#94a3b8;


}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.project-stat-grid{


    grid-template-columns:1fr;


}



.page-header-card{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}



.table-header{


    flex-direction:column;


    align-items:flex-start;


    gap:15px;


}


}

</style>


@endsection