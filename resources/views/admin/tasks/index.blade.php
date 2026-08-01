@extends('layouts.dashboard')

@section('content')



<div class="page-header-card">


<div>

<div class="page-label">
MONITORING TUGAS
</div>


<h1>
Monitoring Tugas
</h1>


<p>
Pantau aktivitas pekerjaan, progress, dan penyelesaian task setiap project.
</p>


</div>


</div>







<div class="task-stat-grid">


<div class="task-stat">

<div class="icon-box green">
📝
</div>

<div>

<span>
Total Tugas
</span>

<h3>
{{$tasks->count()}}
</h3>


<small>
Seluruh pekerjaan
</small>

</div>


</div>





<div class="task-stat">

<div class="icon-box blue">
⏳
</div>


<div>

<span>
Berjalan
</span>


<h3>

{{$tasks->where('status','sedang_dikerjakan')->count()}}

</h3>


<small>
Sedang dikerjakan
</small>


</div>


</div>






<div class="task-stat">


<div class="icon-box orange">
✓
</div>


<div>

<span>
Selesai
</span>


<h3>

{{$tasks->where('status','selesai')->count()}}

</h3>


<small>
Task selesai
</small>


</div>


</div>


</div>









<div class="glass-panel">


<div class="table-header">


<div>

<h3>
Daftar Aktivitas Task
</h3>

<p>
Monitoring seluruh pekerjaan perusahaan.
</p>


</div>


<div class="total-data">

{{$tasks->count()}} Task

</div>


</div>







<table>


<thead>

<tr>

<th>
Task
</th>

<th>
Project
</th>

<th>
PIC
</th>

<th>
Divisi
</th>

<th>
Deadline
</th>

<th>
Progress
</th>

<th>
Status
</th>

<th>
Detail
</th>

</tr>

</thead>



<tbody>


@forelse($tasks as $task)



<tr>


<td>


<strong>
{{$task->nama_task}}
</strong>


<br>


<small>
{{$task->aktivitas ?? '-'}}
</small>


</td>




<td>

{{$task->proyek->nama_proyek ?? '-'}}

</td>





<td>



{{$task->karyawan->name ?? '-'}}


</td>



<td>

{{$task->divisi->nama_divisi ?? '-'}}

</td>






<td>

@if($task->deadline)

{{date('d M Y',strtotime($task->deadline))}}

@else

-

@endif


</td>






<td>

<div class="progress-wrapper">

    <div class="progress">

        <div class="progress-bar"
        style="width: {{$task->progres_persen ?? 0}}%">
        </div>

    </div>


    <div class="progress-text">

        {{number_format($task->progres_persen ?? 0,0)}}%

    </div>

</div>


</td>



<td>


<span class="badge-status 
@if($task->status=='selesai')
success
@elseif($task->status=='sedang_dikerjakan')
warning
@else
pending
@endif
">

{{$task->status}}

</span>


</td>






<td>


<a href="{{route('admin.tasks.show',$task->id)}}"
class="btn-detail">

Lihat

</a>


</td>


</tr>



@empty


<tr>

<td colspan="8">

Belum ada task

</td>

</tr>


@endforelse



</tbody>



</table>



</div>




<style>

/* ===============================
HEADER CARD
================================ */

.page-header-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:30px;

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

}



.page-header-card p{

    margin:0;

    font-size:14px;

    color:#64748b;

}







/* ===============================
STATISTIC
================================ */


.task-stat-grid{


    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;


}




.task-stat{


    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:15px;


    box-shadow:

    0 10px 30px rgba(15,23,42,.05);


}





.icon-box{


    width:50px;

    height:50px;

    border-radius:16px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:22px;


}



.icon-box.green{

    background:#dcfce7;

}



.icon-box.blue{

    background:#dbeafe;

}



.icon-box.orange{

    background:#fef3c7;

}





.task-stat span{


    font-size:12px;

    color:#64748b;


}



.task-stat h3{


    margin:5px 0;

    font-size:26px;

    color:#172033;


}



.task-stat small{


    color:#94a3b8;

    font-size:11px;


}








/* ===============================
TABLE CARD
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

    font-size:13px;

    color:#64748b;


}




.total-data{


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


table{


    width:100%;

    border-collapse:collapse;


}



th{


    padding:15px;

    background:#f8fafc;

    color:#64748b;

    font-size:12px;

    text-align:left;


}



td{


    padding:16px;

    font-size:13px;

    color:#334155;

    border-bottom:

    1px solid #f1f5f9;


}



tr:hover{


    background:#f8fafc;


}







td strong{


    color:#172033;

    font-size:14px;


}



td small{


    color:#94a3b8;

    font-size:11px;


}








/* ===============================
PROGRESS
================================ */


.progress{


    width:120px;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

    margin-bottom:5px;


}



.progress-bar{


    height:100%;

    background:

    linear-gradient(
        90deg,
        #166534,
        #22c55e
    );

    border-radius:20px;


}




td span{


    font-size:12px;

    color:#64748b;


}







.progress-wrapper{

    width:120px;

}



.progress{

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-bar{

    height:100%;

    background:#16a34a;

    border-radius:20px;

    transition:.3s;

}



.progress-text{

    margin-top:6px;

    font-size:12px;

    font-weight:700;

    color:#64748b;

}

/* ===============================
STATUS
================================ */

.badge-status{

padding:7px 14px;

border-radius:20px;

font-size:11px;

font-weight:700;

}


.badge-status.success{

background:#dcfce7;

color:#166534;

}


.badge-status.warning{

background:#fef3c7;

color:#92400e;

}


.badge-status.pending{

background:#e0f2fe;

color:#0369a1;

}

/* ===============================
DETAIL BUTTON
================================ */


.btn-detail{


    background:#dbeafe;

    color:#2563eb;

    padding:8px 15px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;


}



.btn-detail:hover{


    background:#2563eb;

    color:white;


}








/* EMPTY */

td[colspan="8"]{


    text-align:center;

    padding:40px;

    color:#94a3b8;


}







@media(max-width:900px){


.task-stat-grid{


    grid-template-columns:1fr;


}



.page-header-card{


    flex-direction:column;

    align-items:flex-start;

    gap:15px;


}



.table-wrapper{


    overflow-x:auto;


}



table{


    min-width:900px;


}


}


</style>

@endsection