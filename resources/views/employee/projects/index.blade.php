@extends('layouts.dashboard')

@section('content')

<div class="project-container">


{{-- ================= PROJECT HEADER ================= --}}

<div class="project-welcome-card">


    <div>


        <div class="project-welcome-label">

            MY PROJECT

        </div>




        <h1>

            Project Saya

        </h1>




        <p>

            Monitoring project dan task yang diberikan kepada kamu.

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

Owner :

{{$project->pemilik_proyek ?? '-'}}

</p>



</div>



</div>









{{-- SUMMARY --}}


<div class="project-summary-box">



<div>


<span>

Total Task

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

📌 Task Saya

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


.project-container{

    width:100%;

    max-width:100%;

    overflow:hidden;

}






.project-welcome-card{


    background:

    linear-gradient(

        135deg,

        #166534,

        #22c55e

    );


    padding:30px;


    border-radius:24px;


    color:white;


    display:flex;


    justify-content:space-between;


    align-items:center;


    margin-bottom:25px;


    box-shadow:

    0 15px 40px rgba(34,197,94,.25);


}





.project-welcome-label{


    font-size:11px;


    letter-spacing:2px;


    font-weight:700;


    opacity:.8;


}






.project-welcome-card h1{


    font-size:30px;


    margin:8px 0;


}







.project-welcome-card p{


    font-size:13px;


    opacity:.9;


}








.project-date-box{


    background:white;


    color:#166534;


    padding:12px 20px;


    border-radius:30px;


    font-weight:700;


}









.project-panel{


    background:white;


    padding:25px;


    border-radius:24px;


    margin-bottom:25px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.08);


}









.project-card-header h2{


    color:#166534;


    margin-bottom:8px;


}





.project-card-header p{


    color:#64748b;


    font-size:13px;


}









.project-summary-box{


    display:grid;


    grid-template-columns:

    repeat(3,1fr);


    gap:15px;


    margin:25px 0;


}









.project-summary-box div{


    background:#f8fafc;


    padding:18px;


    border-radius:18px;


}








.project-summary-box span{


    display:block;


    font-size:12px;


    color:#64748b;


    margin-bottom:8px;


}








.project-summary-box strong{


    color:#166534;


    font-size:24px;


}









.project-section-title{


    margin-bottom:15px;


}









.project-task-card{


    display:flex;


    justify-content:space-between;


    gap:25px;


    background:#f8fafc;


    padding:22px;


    border-radius:20px;


    margin-bottom:15px;


}








.project-task-main{


    flex:1;


}








.project-task-title h4{


    color:#166534;


    font-size:17px;


    margin-bottom:5px;


}








.project-task-title p{


    color:#64748b;


    font-size:13px;


}









.project-progress-label{


    display:flex;


    justify-content:space-between;


    margin-bottom:8px;


    font-size:12px;


}








.project-progress-label b{


    color:#166534;


}








.project-progress-track{


    width:100%;


    height:10px;


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


}









.project-activity-info{


    margin-top:12px;


    font-size:12px;


    color:#64748b;


}









.project-task-side{


    width:180px;


    text-align:right;


}









.project-deadline,


.project-status{


    display:block;


    padding:7px 12px;


    border-radius:20px;


    font-size:11px;


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


    background:#e2e8f0;


    color:#475569;


}









.project-button-group{


    display:flex;


    justify-content:flex-end;


    gap:8px;


    margin-top:15px;


}








.project-button-group a{


    text-decoration:none;


    background:#166534;


    color:white;


    padding:9px 15px;


    border-radius:14px;


    font-size:12px;


    font-weight:700;


}








.project-update-btn{


    background:#2563eb!important;


}









@media(max-width:900px){



.project-welcome-card{


    flex-direction:column;


    align-items:flex-start;


    gap:15px;


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



}






@media(max-width:600px){


.project-summary-box{


    grid-template-columns:1fr;


}



.project-panel{


    padding:18px;


}



}






.project-container *{


    box-sizing:border-box;


}


</style>



@endsection