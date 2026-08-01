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


@elseif(in_array($task->status,['berjalan','progress']))


progress


@else


todo


@endif

">



{{strtoupper($task->status)}}



</span>









<div class="project-button-group">



<a href="{{route(

'employee.task.show',

$task->id

)}}">


Detail


</a>








<a href="{{route(

'daily-tracker.show',

$task->id

)}}"

class="project-update-btn">


Update


</a>



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

    max-width:100%;

    overflow:hidden;

}


.project-container *{

    box-sizing:border-box;

}



/* ===============================
WELCOME HEADER
================================ */


.project-welcome-card{

    background:white;

    border:1px solid #e2e8f0;

    padding:32px;

    border-radius:24px;

    color:#172033;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:24px;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}



.project-welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.project-welcome-card h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

    font-weight:800;

}



.project-welcome-card p{

    margin:0;

    color:#64748b;

    font-size:14px;

}



.project-date-box{

    background:#ecfdf5;

    color:#15803d;

    padding:12px 22px;

    border-radius:999px;

    font-size:13px;

    font-weight:800;

}



/* ===============================
PROJECT PANEL
================================ */


.project-panel{

    background:white;

    border:1px solid #e2e8f0;

    padding:28px;

    border-radius:24px;

    margin-bottom:24px;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}



/* ===============================
PROJECT HEADER
================================ */


.project-card-header h2{

    margin:0 0 8px;

    color:#166534;

    font-size:20px;

    font-weight:800;

}



.project-card-header p{

    margin:0;

    color:#64748b;

    font-size:13px;

}





/* ===============================
SUMMARY
================================ */


.project-summary-box{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin:25px 0;

}



.project-summary-box div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:20px;

    border-radius:18px;

}



.project-summary-box span{

    display:block;

    color:#64748b;

    font-size:12px;

    font-weight:600;

    margin-bottom:8px;

}



.project-summary-box strong{

    color:#166534;

    font-size:22px;

    font-weight:800;

}





/* ===============================
TASK TITLE
================================ */


.project-section-title{

    font-size:17px;

    color:#172033;

    font-weight:800;

    margin:25px 0 15px;

}





/* ===============================
TASK CARD
================================ */


.project-task-card{

    display:flex;

    justify-content:space-between;

    gap:25px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:22px;

    border-radius:20px;

    margin-bottom:15px;

    transition:.25s;

}



.project-task-card:hover{

    transform:translateY(-3px);

    box-shadow:

    0 10px 25px rgba(15,23,42,.08);

}





.project-task-main{

    flex:1;

    min-width:0;

}





.project-task-title h4{

    margin:0 0 8px;

    color:#172033;

    font-size:16px;

    font-weight:800;

}



.project-task-title p{

    margin:0;

    color:#64748b;

    font-size:13px;

}





/* ===============================
PROGRESS
================================ */


.project-progress-label{

    display:flex;

    justify-content:space-between;

    margin-bottom:8px;

    font-size:12px;

}



.project-progress-label span{

    color:#64748b;

}



.project-progress-label b{

    color:#166534;

}



.project-progress-track{

    width:100%;

    height:12px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.project-progress-value{

    height:100%;

    background:

    linear-gradient(
    90deg,
    #166534,
    #22c55e
    );

    border-radius:20px;

}



.project-activity-info{

    margin-top:14px;

    color:#64748b;

    font-size:12px;

}





/* ===============================
SIDE TASK
================================ */


.project-task-side{

    width:160px;

    flex-shrink:0;

    text-align:right;

}



.project-deadline,
.project-status{

    display:block;

    padding:7px 12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

    margin-bottom:10px;

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



.project-deadline.secondary{

    background:#e2e8f0;

    color:#475569;

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



.deadline-text{

    display:block;

    color:#94a3b8;

    font-size:11px;

    margin-bottom:10px;

}



/* ===============================
BUTTON
================================ */


.project-button-group{

    display:flex;

    justify-content:flex-end;

    gap:8px;

    margin-top:15px;

}



.project-button-group a{

    background:#0f172a;

    color:white;

    text-decoration:none;

    padding:9px 16px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    transition:.2s;

}



.project-button-group a:hover{

    background:#166534;

}



.project-update-btn{

    background:#2563eb!important;

}



.project-update-btn:hover{

    background:#1d4ed8!important;

}





/* ===============================
EMPTY
================================ */


.empty-project{

    text-align:center;

    padding:50px;

    color:#94a3b8;

    font-weight:600;

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



.project-button-group{

    justify-content:flex-start;

}



.project-welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



}



@media(max-width:600px){


.project-panel{

    padding:18px;

}



.project-welcome-card h1{

    font-size:24px;

}


}

</style>



@endsection