@extends('layouts.dashboard')

@section('content')

<div class="employee-dashboard">


{{-- ================= WELCOME ================= --}}

<div class="employee-welcome">


<div>

<span class="welcome-label">
DASHBOARD KARYAWAN
</span>


<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>


<p>
Monitoring pekerjaan, progress project dan aktivitas harian.
</p>



<div class="welcome-tags">

<span>
✓ Project
</span>

<span>
✓ Task
</span>

<span>
✓ Daily Tracker
</span>

</div>


</div>




<div class="today-card">

{{now()->format('d M Y')}}

</div>


</div>







{{-- ================= STATISTIC ================= --}}


<div class="employee-stats">



<div class="stat-card">


<div class="stat-icon green">
📁
</div>



<div>

<label>
Total Task
</label>


<h2>
{{$employeeTasks->count()}}
</h2>


<small>
Task diberikan
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon blue">
✔
</div>



<div>

<label>
Task Selesai
</label>


<h2>

{{$employeeTasks
->whereIn('status',['selesai','done'])
->count()}}

</h2>


<small>
Selesai dikerjakan
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon orange">
⚡
</div>



<div>

<label>
Sedang Progress
</label>


<h2>

{{$employeeTasks
->whereIn('status',['berjalan','progress'])
->count()}}

</h2>


<small>
Sedang berjalan
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon purple">
📝
</div>



<div>

<label>
Aktivitas
</label>


<h2>

{{$employeeTasks->sum(function($task){

return $task->aktivitasTugas->count();

})}}

</h2>


<small>
Update pekerjaan
</small>


</div>


</div>




</div>









{{-- ================= MAIN GRID ================= --}}


<div class="employee-grid">





{{-- ================= LEFT ================= --}}


<div class="employee-left">






{{-- PROJECT PROGRESS --}}


<div class="employee-panel">


<div class="panel-header">

📊 Progress Project

</div>




@forelse($projectProgress as $project=>$progress)


<div class="project-item">


<div class="project-top">


<strong>

{{$project}}

</strong>


<span>

{{$progress}}%

</span>


</div>



<div class="progress-bar">


<div class="progress-value"

style="width:{{$progress}}%">

</div>


</div>


</div>



@empty


<div class="empty-data">

Belum ada project

</div>


@endforelse



</div>








{{-- DETAIL TASK --}}


<div class="employee-panel">


<div class="panel-header">

📋 Detail Task Saya

</div>





@forelse($employeeTasks as $task)



<div class="task-row">


<div>


<strong>

{{$task->nama_tugas}}

</strong>



<p>

{{$task->proyek->nama_proyek ?? '-'}}

</p>


</div>





<span>

{{$task->status}}

</span>



</div>



@empty


<div class="empty-data">

Belum ada task

</div>


@endforelse



</div>







{{-- DEADLINE --}}


<div class="employee-panel">


<div class="panel-header">

⏰ Deadline Terdekat

</div>





@forelse($deadlineTasks as $task)



<div class="deadline-card">


<div>


<strong>

{{$task->nama_tugas}}

</strong>



<p>

{{$task->proyek->nama_proyek ?? '-'}}

</p>


</div>




<div class="deadline-date">

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

</div>



</div>




@empty


<div class="empty-data">

Tidak ada deadline

</div>


@endforelse



</div>




</div>
{{-- ================= RIGHT CONTENT ================= --}}


<div class="employee-right">





{{-- CHART --}}


<div class="employee-panel">


<div class="panel-header">

📈 Status Task

</div>



<div class="chart-box">

<canvas id="taskChart"></canvas>

</div>


</div>







{{-- PROJECT SAYA --}}


<div class="employee-panel">


<div class="panel-header">

📁 Project Saya

</div>





@forelse($employeeTasks->groupBy('proyek.nama_proyek') as $project=>$tasks)



<div class="info-row">


<span>
Project
</span>


<b>

{{$project}}

</b>


</div>




<div class="info-row">


<span>
Jumlah Task
</span>


<b>

{{$tasks->count()}}

</b>


</div>





@empty


<div class="empty-data">

Belum ada project

</div>


@endforelse




</div>







{{-- INFORMASI AKUN --}}


<div class="employee-panel">


<div class="panel-header">

👤 Informasi Akun

</div>





<div class="info-row">


<span>
Nama
</span>


<b>

{{auth()->user()->name}}

</b>


</div>





<div class="info-row">


<span>
Email
</span>


<b>

{{auth()->user()->email}}

</b>


</div>





<div class="info-row">


<span>
Divisi
</span>


<b>

{{auth()->user()->karyawan->divisi->nama_divisi ?? '-'}}

</b>


</div>





<div class="info-row">


<span>
Status
</span>


<b class="active-status">

Aktif

</b>


</div>




</div>





</div>


{{-- END RIGHT --}}



</div>


{{-- END GRID --}}









{{-- ================= AKTIVITAS TERAKHIR ================= --}}


<div class="employee-panel">


<div class="panel-header">

📝 Aktivitas Terakhir

</div>





@php


$activities = $employeeTasks

->flatMap(function($task){


return $task->aktivitasTugas

->map(function($activity) use($task){


return [


'task'=>$task->nama_tugas,


'aktivitas'=>$activity->aktivitas,


'progress'=>$activity->progres ?? 0,


'tanggal'=>$activity->tanggal


];


});


})


->sortByDesc('tanggal')

->take(5);



@endphp








@forelse($activities as $activity)



<div class="activity-card">



<div class="activity-dot"></div>





<div class="activity-content">


<strong>

{{$activity['task']}}

</strong>




<p>

{{$activity['aktivitas']}}

</p>





<small>

{{\Carbon\Carbon::parse(
$activity['tanggal']
)->format('d M Y H:i')}}

</small>



</div>





<div class="activity-percent">


{{$activity['progress']}}%

</div>



</div>




@empty



<div class="empty-data">

Belum ada aktivitas

</div>



@endforelse



</div>









{{-- ================= CHART SCRIPT ================= --}}



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>


const canvas = document.getElementById('taskChart');


if(canvas){


new Chart(canvas,{


type:'doughnut',



data:{


labels:[

'Selesai',

'Berjalan',

'Belum Dikerjakan'

],



datasets:[{


data:[


{{$employeeTasks
->whereIn('status',['selesai','done'])
->count()}},



{{$employeeTasks
->whereIn('status',['berjalan','progress'])
->count()}},



{{$employeeTasks
->whereIn('status',['belum_dikerjakan','todo'])
->count()}}



],



borderWidth:0,



backgroundColor:[

'#22c55e',

'#3b82f6',

'#f59e0b'

]



}]


},



options:{


responsive:true,


maintainAspectRatio:false,


cutout:'70%',



plugins:{


legend:{


position:'bottom'


}


}



}



});


}



</script>

<style>


/* ===============================
GLOBAL
================================ */

.employee-dashboard{

    width:100%;

}



/* ===============================
WELCOME
================================ */


.employee-welcome{


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


    margin-bottom:22px;


    box-shadow:

    0 15px 35px rgba(22,101,52,.15);


}



.welcome-label{


    font-size:11px;


    letter-spacing:2px;


    font-weight:800;


    opacity:.8;


}



.employee-welcome h1{


    font-size:28px;


    margin:10px 0;


}



.employee-welcome p{


    margin:0;


    opacity:.9;


}



.welcome-tags{


    display:flex;


    gap:10px;


    margin-top:15px;


}



.welcome-tags span{


    background:

    rgba(255,255,255,.2);


    padding:8px 15px;


    border-radius:20px;


    font-size:12px;


}



.today-card{


    background:white;


    color:#166534;


    padding:12px 22px;


    border-radius:30px;


    font-weight:800;


}







/* ===============================
STAT CARD
================================ */


.employee-stats{


    display:grid;


    grid-template-columns:

    repeat(4,1fr);


    gap:18px;


    margin-bottom:22px;


}




.stat-card{


    background:white;


    padding:20px;


    border-radius:22px;


    display:flex;


    align-items:center;


    gap:15px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.08);


    transition:.3s;


}




.stat-card:hover{


    transform:translateY(-5px);


}




.stat-icon{


    width:48px;


    height:48px;


    display:flex;


    justify-content:center;


    align-items:center;


    border-radius:15px;


    font-size:22px;


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



.stat-icon.purple{

    background:#ede9fe;

}





.stat-card label{


    color:#64748b;


    font-size:12px;


}




.stat-card h2{


    margin:5px 0;


    color:#166534;


}









/* ===============================
GRID
================================ */


.employee-grid{


    display:grid;


    grid-template-columns:

    minmax(0,2fr)

    minmax(320px,1fr);


    gap:20px;


    align-items:start;


}



.employee-left,
.employee-right{


    min-width:0;


}





/* ===============================
PANEL
================================ */


.employee-panel{


    background:white;


    padding:22px;


    border-radius:22px;


    margin-bottom:20px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.08);


}




.panel-header{


    font-size:16px;


    font-weight:800;


    color:#1e293b;


    margin-bottom:18px;


}









/* ===============================
PROJECT
================================ */


.project-item{


    margin-bottom:20px;


}




.project-top{


    display:flex;


    justify-content:space-between;


    margin-bottom:10px;


}




.project-top span{


    color:#166534;


    font-weight:800;


}






.progress-bar{


    height:12px;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}




.progress-value{


    height:100%;


    background:

    linear-gradient(
        90deg,
        #166534,
        #22c55e
    );


    border-radius:20px;


}








/* ===============================
TASK
================================ */


.task-row{


    display:flex;


    justify-content:space-between;


    align-items:center;


    padding:14px;


    background:#f8fafc;


    border-radius:15px;


    margin-bottom:10px;


    transition:.3s;


}




.task-row:hover{


    background:#ecfdf5;


    transform:translateX(5px);


}





.task-row strong{


    font-size:13px;


}




.task-row p{


    margin-top:5px;


    color:#64748b;


    font-size:12px;


}





.task-row span{


    background:#dcfce7;


    color:#166534;


    padding:6px 12px;


    border-radius:20px;


    font-size:11px;


    text-transform:capitalize;


}









/* ===============================
CHART
================================ */


.chart-box{


    height:260px;


    display:flex;


    justify-content:center;


    align-items:center;


}



#taskChart{


    max-width:230px!important;


    max-height:230px!important;


}









/* ===============================
INFO
================================ */


.info-row{


    display:flex;


    justify-content:space-between;


    padding:13px 0;


    border-bottom:1px solid #f1f5f9;


}




.info-row span{


    color:#64748b;


    font-size:13px;


}





.info-row b{


    color:#166534;


    font-size:13px;


}




.active-status{


    color:#16a34a!important;


}








/* ===============================
DEADLINE
================================ */


.deadline-card{


    display:flex;


    justify-content:space-between;


    align-items:center;


    padding:15px;


    background:#f8fafc;


    border-radius:16px;


    margin-bottom:10px;


}





.deadline-card strong{


    font-size:13px;


}




.deadline-card p{


    margin-top:5px;


    color:#64748b;


    font-size:12px;


}




.deadline-date{


    background:#dcfce7;


    color:#166534;


    padding:7px 13px;


    border-radius:20px;


    font-size:12px;


    font-weight:700;


}








/* ===============================
ACTIVITY
================================ */


.activity-card{


    display:flex;


    align-items:flex-start;


    gap:15px;


    padding:15px 0;


    border-bottom:1px solid #f1f5f9;


}



.activity-dot{


    width:11px;


    height:11px;


    background:#22c55e;


    border-radius:50%;


    margin-top:7px;


}





.activity-content{


    flex:1;


}





.activity-content strong{


    font-size:13px;


}





.activity-content p{


    margin:5px 0;


    font-size:13px;


}





.activity-content small{


    color:#94a3b8;


}




.activity-percent{


    background:#dcfce7;


    color:#166534;


    padding:6px 12px;


    border-radius:20px;


    font-size:12px;


    font-weight:700;


}








.empty-data{


    text-align:center;


    color:#94a3b8;


    padding:20px;


}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.employee-stats{


    grid-template-columns:

    repeat(2,1fr);


}



.employee-grid{


    grid-template-columns:1fr;


}



}




@media(max-width:700px){


.employee-stats{


    grid-template-columns:1fr;


}




.employee-welcome{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}




.welcome-tags{


    flex-wrap:wrap;


}




.task-row,
.deadline-card{


    flex-direction:column;


    align-items:flex-start;


    gap:10px;


}



.employee-panel{


    padding:18px;


}


}



</style>


@endsection