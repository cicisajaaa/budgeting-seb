@extends('layouts.dashboard')


@section('content')


<div class="project-container">


<div class="project-header">


<div class="project-label">
MY PROJECT
</div>


<h1>
Project Saya
</h1>


<p>
Daftar project yang menjadi tanggung jawab kamu.
</p>


</div>







@forelse($projects as $project)



<div class="project-card">



<div class="project-top">


<div>


<h2>
{{$project->nama_project}}
</h2>


<p>
{{$project->project_owner ?? '-'}}
</p>


</div>



<div class="progress-badge">

{{$project->progress_keseluruhan}}%

</div>


</div>






<div class="project-info">


<div>

<span>
Mulai
</span>

<strong>
{{$project->start_date}}
</strong>

</div>



<div>

<span>
Selesai
</span>

<strong>
{{$project->end_date}}
</strong>

</div>



<div>

<span>
Total Task
</span>

<strong>
{{$project->tasks->count()}}
</strong>

</div>


</div>






<div class="progress-area">


<div class="progress-title">

Progress Project

<b>
{{$project->progress_keseluruhan}}%
</b>

</div>



<div class="progress-track">


<div class="progress-fill"

style="
width:{{$project->progress_keseluruhan}}%
">

</div>


</div>


</div>







<h3>
📌 Task Dalam Project
</h3>





@foreach($project->tasks as $task)



<div class="task-item">


<div>


<strong>
{{$task->nama_task}}
</strong>


<p>
{{$task->aktivitas ?? '-'}}
</p>


<div class="mini-progress">


<div class="mini-progress-fill"
style="
width:{{$task->progress_persen}}%
">

</div>


</div>



</div>





<div class="task-right">


<span class="task-status">

{{strtoupper($task->status)}}

</span>


<br>


<small>

{{$task->progress_persen}}%

</small>

<a href="{{route('employee.task.show',$task->id)}}">

Detail

</a>


</div>



</div>


@endforeach




</div>




@empty


<div class="project-card">


Belum ada project yang diberikan.


</div>



@endforelse




</div>









<style>


.project-container{


padding:10px;


}



.project-label{


font-size:11px;

letter-spacing:2px;

font-weight:800;

color:#22c55e;


}



.project-header h1{


font-size:30px;

color:#166534;

font-weight:800;

margin:5px 0;


}



.project-header p{


color:#64748b;

margin-bottom:25px;


}







.project-card{


background:

rgba(255,255,255,.75);


backdrop-filter:blur(20px);


border-radius:25px;


padding:25px;


margin-bottom:25px;


box-shadow:

0 15px 40px rgba(15,23,42,.08);


}




.project-top{


display:flex;

justify-content:space-between;

align-items:center;


}



.project-top h2{


color:#166534;

font-size:22px;


}



.project-top p{


color:#64748b;


}




.progress-badge{


background:#dcfce7;

color:#166534;

padding:10px 18px;

border-radius:20px;

font-weight:800;


}







.project-info{


display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

margin:25px 0;


}



.project-info div{


background:#f8fafc;

padding:15px;

border-radius:15px;


}



.project-info span{


display:block;

font-size:12px;

color:#64748b;


}



.project-info strong{


color:#166534;

margin-top:5px;

display:block;


}







.progress-title{


display:flex;

justify-content:space-between;

margin-bottom:10px;


}



.progress-track{


height:15px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;


}



.progress-fill{


height:100%;


background:

linear-gradient(
90deg,
#166534,
#22c55e
);


}







.task-item{


display:flex;

justify-content:space-between;

align-items:center;


background:#f8fafc;


padding:15px;


border-radius:15px;


margin-top:10px;


}



.task-item p{


margin:5px 0;

font-size:13px;

color:#64748b;


}



.task-status{


background:#dcfce7;

color:#166534;

padding:6px 12px;

border-radius:20px;

font-size:11px;

font-weight:700;


}




@media(max-width:800px){


.project-info{


grid-template-columns:1fr;


}



.project-top{


flex-direction:column;

align-items:flex-start;

gap:15px;


}


}


.btn-task{


display:inline-block;


margin-top:10px;


padding:8px 15px;


background:

linear-gradient(
135deg,
#166534,
#22c55e
);


color:white;


border-radius:12px;


text-decoration:none;


font-size:12px;


font-weight:700;


}



.btn-task:hover{


opacity:.85;


}





.task-right{


text-align:right;


}



.mini-progress{


width:200px;


height:8px;


background:#e2e8f0;


border-radius:20px;


overflow:hidden;


margin-top:10px;


}




.mini-progress-fill{


height:100%;


background:

linear-gradient(
90deg,
#166534,
#22c55e
);


}
</style>



@endsection