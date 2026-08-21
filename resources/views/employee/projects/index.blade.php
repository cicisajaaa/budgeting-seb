@extends('layouts.dashboard')

@section('content')

<div class="project-container">


{{-- ================= PROJECT HEADER ================= --}}

<div class="project-welcome-card">


    <div>


        <div class="project-welcome-label">

            PROYEK SAYA

        </div>




        <h1>

            Proyek Saya

        </h1>




        <p>

            Monitoring project dan tugas yang diberikan kepada kamu.

        </p>



    </div>





    <div class="project-date-box">

        {{date('d M Y')}}

    </div>



</div>









{{-- ================= LIST PROJECT ================= --}}


@forelse($proyek as $project)



<div class="project-panel">






<div class="project-card-header">



<div>



<h2>

📁 {{$project->nama_proyek}}

</h2>




<p>

Pemilik :

{{$project->pemilik_proyek ?? '-'}}

</p>



</div>



</div>









{{-- SUMMARY --}}


<div class="project-summary-box">



<div>


<span>

Total Tugas

</span>


<strong>

{{$project->tugas->count()}}

</strong>



</div>







<div>


<span>

Selesai

</span>


<strong>

{{$project->tugas

->whereIn(

'status',

[

'selesai',

'done'

]

)

->count()}}

</strong>



</div>







<div>


<span>

Progress Project

</span>



<strong>


{{$project->progres_keseluruhan}}%


</strong>



</div>



</div>









<h3 class="project-section-title">

📌 Tugas Saya

</h3>








@foreach($project->tugas as $task)



<div class="project-task-card">





<div class="project-task-main">





<div class="project-task-title">



<h4>

{{$task->nama_tugas}}

</h4>




<p>

{{$task->aktivitas ?? '-'}}

</p>



</div>








<div class="project-task-progress">



<div class="project-progress-label">



<span>

Progress

</span>




<b>

{{$task->progres_persen}}%

</b>



</div>






<div class="project-progress-track">



<div

class="project-progress-value"

style="width:{{$task->progres_persen}}%"

>

</div>



</div>






</div>








<div class="project-activity-info">


📝

{{$task->aktivitasTugas->count()}}

Aktivitas



</div>






</div>
{{-- ================= SIDE TASK ================= --}}


<div class="project-task-side">





@php

$statusDeadline = $task->statusDeadline();

@endphp






<span class="project-deadline {{$statusDeadline['color']}}">


{{$statusDeadline['label']}}


</span>


<span class="project-status

@if(in_array($task->status,['selesai','done']))

done

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

progress

@else

todo

@endif

">

@if(in_array($task->status,['selesai','done']))

Selesai

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

Sedang Dikerjakan

@else

Belum Dikerjakan

@endif


</span>



<div class="project-button-group">



<a href="{{route(

'employee.task.show',

$task->id

)}}">


Detail


</a>






@if(!in_array($task->status,['selesai','done']))

<a href="{{route(

'daily-tracker.show',

$task->id

)}}"

class="project-update-btn">

Update

</a>

@endif


</div>






</div>






</div>





@endforeach





</div>







@empty




<div class="project-panel">


Belum ada project.



</div>




@endforelse





</div>





<style>

/* ===============================
GLOBAL
================================ */

.project-container{
    width:100%;
}

.project-container *{
    box-sizing:border-box;
}



/* ===============================
HEADER OWNER STYLE
================================ */


.project-welcome-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.project-welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.project-welcome-card h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.project-welcome-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}



.project-date-box{

    background:#dcfce7;

    color:#166534;

    padding:10px 18px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}





/* ===============================
PROJECT PANEL
================================ */


.project-panel{

    background:white;

    padding:25px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}





/* ===============================
PROJECT TITLE
================================ */


.project-card-header h2{

    margin:0;

    font-size:18px;

    font-weight:800;

    color:#1e293b;

}



.project-card-header p{

    margin:6px 0 0;

    color:#64748b;

    font-size:12px;

}







/* ===============================
SUMMARY CARD OWNER STYLE
================================ */


.project-summary-box{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin:20px 0;

}



.project-summary-box div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

}



.project-summary-box span{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.project-summary-box strong{

    display:block;

    margin-top:8px;

    font-size:22px;

    color:#1e293b;

}







/* ===============================
SECTION TITLE
================================ */


.project-section-title{

    font-size:16px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin:25px 0 15px;

}







/* ===============================
TASK CARD
================================ */


.project-task-card{

    display:flex;

    justify-content:space-between;

    gap:20px;

    padding:18px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    margin-bottom:12px;

    transition:.2s;

}



.project-task-card:hover{

    background:white;

    transform:translateY(-2px);

    box-shadow:

    0 8px 20px rgba(15,23,42,.06);

}



.project-task-title h4{

    margin:0 0 6px;

    font-size:14px;

    font-weight:800;

    color:#1e293b;

}



.project-task-title p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* ===============================
PROGRESS
================================ */


.project-progress-label{

    display:flex;

    justify-content:space-between;

    margin-bottom:8px;

    font-size:11px;

}



.project-progress-label b{

    color:#166534;

}



.project-progress-track{

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.project-progress-value{

    height:100%;

    background:#16a34a;

    border-radius:20px;

}



.project-activity-info{

    margin-top:12px;

    font-size:12px;

    color:#64748b;

}







/* ===============================
BADGE STATUS
================================ */


.project-deadline,
.project-status{

    display:block;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    margin-bottom:8px;

}



.project-deadline.danger{

    background:#fee2e2;

    color:#991b1b;

}


.project-deadline.warning{

    background:#fef3c7;

    color:#92400e;

}


.project-deadline.success{

    background:#dcfce7;

    color:#166534;

}



.project-status.done{

    background:#dcfce7;

    color:#166534;

}


.project-status.progress{

    background:#dbeafe;

    color:#1d4ed8;

}


.project-status.todo{

    background:#f1f5f9;

    color:#475569;

}







/* ===============================
BUTTON OWNER STYLE
================================ */


.project-button-group{

    display:flex;

    gap:8px;

    margin-top:12px;

}



.project-button-group a{

    background:#334155;

    color:white;

    padding:8px 16px;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.project-button-group a:hover{

    background:#1e293b;

}



.project-update-btn{

    background:#2563eb!important;

}



.project-update-btn:hover{

    background:#1d4ed8!important;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.project-summary-box{

    grid-template-columns:1fr;

}



.project-task-card{

    flex-direction:column;

}



.project-task-side{

    width:100%;

    text-align:left;

}



.project-welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}



</style>



@endsection