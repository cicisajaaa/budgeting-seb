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

{{$task->nama_tugas}}

</strong>


<br>


<small>

{{$task->aktivitas ?? '-'}}

</small>


</td>







<td>

<strong>

{{$task->proyek->nama_proyek ?? '-'}}

</strong>


<br>


<small>

Project ID : {{$task->proyek_id}}

</small>


</td>







<td>

{{$task->karyawan->nama_karyawan ?? '-'}}

</td>







<td>

{{$task->divisi->nama_divisi ?? '-'}}

</td>







<td>


@if($task->deadline)

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

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
@if($task->status == 'selesai')
success

@elseif($task->status == 'sedang_dikerjakan')
warning

@else
pending

@endif
">


@if($task->status == 'selesai')

Selesai


@elseif($task->status == 'sedang_dikerjakan')

Sedang Dikerjakan


@else

Belum Dikerjakan


@endif


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
GLOBAL
================================ */

*{
    box-sizing:border-box;
}



/* ===============================
HEADER
================================ */


.page-header-card{

    width:100%;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px 28px;

    margin-bottom:20px;

    box-shadow:
    0 5px 18px rgba(15,23,42,.04);

}



.page-label{

    font-size:9px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:7px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:11px;

    color:#64748b;

}







/* ===============================
STAT CARD
================================ */


.task-stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:16px;

    margin-bottom:20px;

}





.task-stat{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:18px;


    padding:16px;


    display:flex;


    align-items:center;


    gap:12px;


    position:relative;


    overflow:hidden;


    box-shadow:


    0 6px 20px rgba(15,23,42,.04);


}





.task-stat::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:3px;

    background:#334155;

}





.icon-box{


    width:40px;


    height:40px;


    border-radius:12px;


    display:flex;


    align-items:center;


    justify-content:center;


    font-size:17px;


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

    font-size:10px;

    color:#64748b;

}





.task-stat h3{

    margin:3px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}





.task-stat small{

    font-size:9px;

    color:#94a3b8;

}









/* ===============================
TABLE CARD
================================ */


.glass-panel{


    width:100%;


    background:white;


    border:1px solid #e5e7eb;


    border-radius:20px;


    padding:18px;


    box-shadow:


    0 6px 20px rgba(15,23,42,.04);


}








.table-header{


    display:flex;


    justify-content:space-between;


    align-items:center;


    margin-bottom:15px;


}







.table-header h3{


    margin:0;


    font-size:15px;


    font-weight:800;


    color:#172033;


}







.table-header p{


    margin:4px 0 0;


    font-size:10px;


    color:#64748b;


}







.total-data{


    background:#f1f5f9;


    padding:6px 12px;


    border-radius:999px;


    font-size:10px;


    font-weight:700;


    color:#334155;


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





thead th{


    background:#f8fafc;


    padding:10px;


    font-size:10px;


    color:#64748b;


    font-weight:800;


    text-align:left;


}






tbody td{


    padding:11px 10px;


    border-bottom:1px solid #f1f5f9;


    font-size:11px;


    color:#334155;


}







tbody tr:hover{


    background:#fafafa;


}







td strong{


    font-size:12px;


    color:#172033;


}





td small{


    display:block;


    margin-top:3px;


    font-size:9px;


    color:#94a3b8;


}









/* ===============================
PROGRESS
================================ */


.progress-wrapper{


    width:95px;


}



.progress{


    width:95px;


    height:6px;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}





.progress-bar{


    height:100%;


    background:#334155;


}





.progress-text{


    margin-top:4px;


    font-size:9px;


    font-weight:700;


    color:#64748b;


}









/* ===============================
STATUS BADGE
================================ */


.badge-status{


    display:inline-flex;


    padding:5px 10px;


    border-radius:999px;


    font-size:9px;


    font-weight:800;


    white-space:nowrap;


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


    background:#dbeafe;


    color:#1d4ed8;


}









/* ===============================
DETAIL BUTTON
================================ */


.btn-detail{


    display:inline-flex;


    align-items:center;


    justify-content:center;


    padding:6px 12px;


    border-radius:10px;


    background:#dbeafe;


    color:#2563eb;


    text-decoration:none;


    font-size:10px;


    font-weight:800;


}





.btn-detail:hover{


    background:#2563eb;


    color:white;


}









/* ===============================
EMPTY
================================ */


td[colspan="8"]{


    text-align:center;


    padding:30px;


    color:#94a3b8;


}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:1100px){


.task-stat-grid{

    grid-template-columns:1fr;

}



table{

    min-width:900px;

}


}



</style>

@endsection