@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->


<div class="page-header">


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









<!-- STATISTIC -->


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

{{count($projects)}}

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

{{$projects->where('progress_keseluruhan','<',100)->count()}}

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

Rp {{number_format($projects->sum('total_budget'),0,',','.')}}

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







<!-- TABLE -->


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

{{count($projects)}} Project

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

{{$project->nama_project}}

</strong>



<small>

Project Perusahaan

</small>


</div>



</div>



</td>







<td>

{{$project->project_owner}}

</td>







<td>


<span class="budget-text">


Rp {{number_format(
$project->total_budget,
0,
',',
'.'
)}}


</span>


</td>







<td>


<div class="date">


{{$project->start_date}}

<br>

<span>

s/d

</span>

<br>

{{$project->end_date}}


</div>


</td>







<td>


<div class="progress-box">


<div class="progress-label">


<span>

Progress

</span>


<b>

{{$project->progress_keseluruhan ?? 0}}%

</b>


</div>




<div class="progress-track">


<div style="width:{{$project->progress_keseluruhan ?? 0}}%">

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


/* HEADER */


.page-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:22px;

}



.page-label{

font-size:10px;

letter-spacing:2px;

font-weight:800;

color:#94a3b8;

}



.page-header h1{

font-size:26px;

color:#166534;

margin:5px 0;

}



.page-header p{

font-size:13px;

color:#64748b;

}



.btn-primary{

background:

linear-gradient(

135deg,

#166534,

#22c55e

);


color:white;

padding:

12px 20px;


border-radius:14px;

font-size:13px;

font-weight:700;

text-decoration:none;

box-shadow:

0 12px 30px rgba(34,197,94,.25);

}







/* STAT */


.project-stat-grid{

display:grid;

grid-template-columns:

repeat(3,1fr);


gap:18px;

margin-bottom:22px;

}



.project-stat{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);


border-radius:20px;


padding:18px;


display:flex;


align-items:center;


gap:15px;


border:

1px solid rgba(255,255,255,.8);

}



.stat-icon{


width:45px;

height:45px;


border-radius:15px;


display:flex;

align-items:center;

justify-content:center;

font-size:20px;

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

font-size:11px;

color:#64748b;

display:block;

}



.project-stat h3{

font-size:22px;

color:#166534;

margin-top:3px;

}



.project-stat small{

font-size:11px;

color:#94a3b8;

}








/* CARD */


.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);


border-radius:22px;


padding:22px;


border:

1px solid rgba(255,255,255,.8);


box-shadow:

0 15px 35px rgba(15,23,42,.06);


}



.table-header{


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:18px;


}



.table-header h3{

font-size:16px;

}



.table-header p{

font-size:12px;

color:#64748b;

}



.total-project{


background:#dcfce7;


color:#166534;


padding:

7px 15px;


border-radius:20px;


font-size:12px;


font-weight:700;


}







/* TABLE */


table{

width:100%;

border-collapse:collapse;

}



th{

padding:14px;

text-align:left;

font-size:11px;

color:#64748b;

background:#f8fafc;

}



td{

padding:14px;

font-size:13px;

border-bottom:1px solid #f1f5f9;

}





tr:hover{

background:

rgba(220,252,231,.35);

}







/* PROJECT NAME */


.project-name{

display:flex;

align-items:center;

gap:10px;

}



.project-icon{


width:36px;

height:36px;


border-radius:12px;


background:#dcfce7;


display:flex;

align-items:center;

justify-content:center;


}



.project-name strong{

display:block;

font-size:13px;

color:#166534;

}



.project-name small{

font-size:11px;

color:#94a3b8;

}







/* BUDGET */


.budget-text{

font-weight:700;

color:#166534;

}





.date{

font-size:12px;

color:#475569;

}



.date span{

color:#94a3b8;

}








/* PROGRESS */


.progress-box{

width:130px;

}



.progress-label{

display:flex;

justify-content:space-between;

font-size:11px;

margin-bottom:5px;

}



.progress-label b{

color:#166534;

}



.progress-track{

height:7px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-track div{

height:100%;

background:

linear-gradient(

90deg,

#166534,

#22c55e

);

border-radius:20px;

}







/* ACTION */


.action{

display:flex;

gap:6px;

}



.action form{

display:inline;

}



.edit,

.allocation,

.delete{


border:none;

padding:

7px 10px;


border-radius:10px;


font-size:11px;


font-weight:600;


cursor:pointer;


text-decoration:none;


}



.edit{

background:#dcfce7;

color:#166534;

}



.allocation{

background:#dbeafe;

color:#1d4ed8;

}



.delete{

background:#fee2e2;

color:#dc2626;

}



.empty{

text-align:center;

padding:30px;

color:#64748b;

}




.success-alert{

display:flex;

gap:10px;

align-items:center;

background:#dcfce7;

color:#166534;

padding:13px 16px;

border-radius:15px;

margin-bottom:18px;

font-size:13px;

font-weight:600;

}





@media(max-width:900px){


.project-stat-grid{

grid-template-columns:1fr;

}



.page-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



}



</style>



@endsection