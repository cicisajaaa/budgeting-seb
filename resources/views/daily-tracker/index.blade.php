@extends('layouts.dashboard')

@section('content')


<div class="daily-wrapper">


{{-- HEADER --}}

<div class="daily-header">


<div>

<span class="daily-label">
EMPLOYEE WORK TRACKING
</span>


<h1>
Aktivitas Harian
</h1>


<p>
Pantau progres pekerjaan, deadline, dan aktivitas tugas kamu dalam satu sistem.
</p>


</div>



<div class="date-card">

<div>
📅
</div>

<span>
{{date('d M Y')}}
</span>

</div>


</div>





{{-- SUMMARY --}}

<div class="summary-grid">



<div class="summary-card">

<div class="summary-icon blue">
📋
</div>


<div>

<label>
Total Tugas
</label>

<h2>
{{$tasks->count()}}
</h2>

<p>
Task diberikan
</p>

</div>


</div>





<div class="summary-card">

<div class="summary-icon green">
⚡
</div>


<div>

<label>
Total Aktivitas
</label>


<h2>

{{$tasks->sum(function($task){

return $task->aktivitasTugas->count();

})}}

</h2>


<p>
Update pekerjaan
</p>


</div>


</div>







<div class="summary-card">

<div class="summary-icon orange">
📊
</div>


<div>


<label>
Progress Rata-rata
</label>


<h2>

{{number_format(
$tasks->avg('progres_persen') ?? 0,
0
)}}%

</h2>


<p>
Keseluruhan task
</p>


</div>


</div>







<div class="summary-card">

<div class="summary-icon purple">
💰
</div>


<div>


<label>
Anggaran Aktivitas
</label>


<h2>

Rp {{number_format(

$tasks->sum(function($task){

return $task->aktivitasTugas
->sum('anggaran_aktivitas');

}),

0,

',',

'.'

)}}

</h2>


<p>
Penggunaan dana
</p>


</div>


</div>



</div>









{{-- TASK MONITORING --}}


<div class="content-panel">


<div class="panel-header">

<div>

<h3>
📌 Pemantauan Tugas
</h3>

<span>
Daftar pekerjaan yang sedang kamu kerjakan
</span>

</div>


</div>





<div class="task-grid">


@forelse($tasks as $task)



<div class="task-card">


<div class="task-header">


<div>

<h4>
{{$task->nama_tugas}}
</h4>


<p>
📁 {{$task->proyek->nama_proyek ?? '-'}}
</p>


</div>




<span class="status-badge

@if(in_array($task->status,['selesai','done']))

success

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

warning

@else

neutral

@endif

">


@if(in_array($task->status,['selesai','done']))

Selesai

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

Berjalan

@else

Belum Dikerjakan

@endif


</span>



</div>






<div class="task-detail">


<div>

<label>
Deadline
</label>


<strong>

@if($task->deadline)

{{Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

@else

-

@endif

</strong>


</div>




<div>

<label>
Progress
</label>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>


</div>




<div>

<label>
Aktivitas
</label>


<strong>
{{$task->aktivitasTugas->count()}}
Update
</strong>


</div>


</div>







<div class="progress-bar">


<div

style="
width:{{min($task->progres_persen ?? 0,100)}}%
"

class="progress-fill">

</div>


</div>







<a href="{{route(
'daily-tracker.show',
$task->id
)}}"

class="update-button">

+ Update Aktivitas

</a>



</div>



@empty


<div class="empty">

Belum ada task.

</div>


@endforelse



</div>


</div>

{{-- TIMELINE AKTIVITAS --}}


<div class="content-panel">


<div class="panel-header">

<div>

<h3>
📝 Timeline Aktivitas
</h3>


<span>
Riwayat update pekerjaan terbaru
</span>


</div>

</div>





@php

$activities = collect();


foreach($tasks as $task){

    foreach($task->aktivitasTugas as $activity){

        $activities->push([

            'task'=>$task->nama_tugas,

            'project'=>$task->proyek->nama_proyek ?? '-',

            'activity'=>$activity

        ]);

    }

}


$activities = $activities->sortByDesc(function($item){

return $item['activity']->tanggal;

});


@endphp






<div class="timeline">


@forelse($activities as $item)



<div class="timeline-item">


<div class="timeline-dot"></div>



<div class="timeline-card">


<div class="timeline-header">


<div>

<h4>
{{$item['task']}}
</h4>


<span>
📁 {{$item['project']}}
</span>


</div>



<div class="progress-badge">

{{$item['activity']->progres ?? 0}}%

</div>


</div>






<p>
{{$item['activity']->aktivitas}}
</p>






<div class="timeline-info">


<span>
👤 {{$item['activity']->karyawan->nama_karyawan ?? '-'}}
</span>


<span>
📅 {{Carbon\Carbon::parse(
$item['activity']->tanggal
)->format('d M Y')}}
</span>


</div>







@if($item['activity']->anggaran_aktivitas > 0)


<div class="budget">

💰 Rp {{number_format(
$item['activity']->anggaran_aktivitas,
0,
',',
'.'
)}}

</div>


@endif





@if($item['activity']->catatan)


<div class="note">

📝 {{$item['activity']->catatan}}

</div>


@endif



</div>


</div>




@empty


<div class="empty">

Belum ada aktivitas tercatat.

</div>


@endforelse



</div>


</div>



</div>






<style>


.daily-wrapper{

width:100%;

}





/* HEADER */


.daily-header{

background:white;

border:1px solid #e2e8f0;

border-radius:28px;

padding:32px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:
0 10px 30px rgba(15,23,42,.06);

}



.daily-label{

font-size:10px;

font-weight:800;

letter-spacing:2px;

color:#64748b;

}



.daily-header h1{

font-size:30px;

margin:10px 0;

font-weight:800;

color:#172033;

}



.daily-header p{

margin:0;

font-size:13px;

color:#64748b;

}



.date-card{

background:#1e293b;

color:white;

padding:15px 22px;

border-radius:18px;

display:flex;

align-items:center;

gap:10px;

font-weight:700;

}





/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:18px;

margin-bottom:25px;

}



.summary-card{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:20px;

display:flex;

align-items:center;

gap:15px;

box-shadow:
0 8px 25px rgba(15,23,42,.05);

}



.summary-icon{

width:45px;

height:45px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}



.summary-icon.blue{

background:#dbeafe;

}



.summary-icon.green{

background:#dcfce7;

}



.summary-icon.orange{

background:#fef3c7;

}



.summary-icon.purple{

background:#ede9fe;

}



.summary-card label{

font-size:11px;

color:#64748b;

display:block;

}



.summary-card h2{

margin:5px 0;

font-size:22px;

color:#172033;

}



.summary-card p{

font-size:10px;

color:#94a3b8;

margin:0;

}







/* PANEL */


.content-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:26px;

padding:28px;

margin-bottom:25px;

box-shadow:
0 10px 30px rgba(15,23,42,.05);

}



.panel-header{

margin-bottom:22px;

}



.panel-header h3{

margin:0;

font-size:17px;

font-weight:800;

color:#172033;

}



.panel-header span{

font-size:12px;

color:#94a3b8;

}





/* TASK */


.task-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:18px;

}



.task-card{

border:1px solid #e2e8f0;

border-radius:22px;

padding:22px;

background:#f8fafc;

transition:.25s;

}



.task-card:hover{

transform:translateY(-4px);

box-shadow:
0 15px 30px rgba(15,23,42,.08);

}



.task-header{

display:flex;

justify-content:space-between;

gap:15px;

}



.task-header h4{

margin:0 0 6px;

font-size:15px;

color:#172033;

}



.task-header p{

margin:0;

font-size:12px;

color:#64748b;

}



.status-badge{

padding:7px 13px;

border-radius:999px;

font-size:10px;

font-weight:800;

height:max-content;

}



.status-badge.success{

background:#dcfce7;

color:#166534;

}



.status-badge.warning{

background:#fef3c7;

color:#92400e;

}



.status-badge.neutral{

background:#e2e8f0;

color:#475569;

}





.task-detail{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:10px;

margin:20px 0;

}



.task-detail div{

background:white;

padding:12px;

border-radius:14px;

}



.task-detail label{

display:block;

font-size:10px;

color:#94a3b8;

}



.task-detail strong{

font-size:13px;

color:#172033;

}



.progress-bar{

height:10px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

margin-bottom:18px;

}



.progress-fill{

height:100%;

background:#334155;

border-radius:20px;

}





.update-button{

display:block;

text-align:center;

background:#1e293b;

color:white;

padding:11px;

border-radius:14px;

text-decoration:none;

font-size:12px;

font-weight:700;

}





/* TIMELINE */


.timeline{

position:relative;

padding-left:10px;

}



.timeline-item{

display:flex;

gap:15px;

margin-bottom:18px;

}



.timeline-dot{

width:12px;

height:12px;

background:#334155;

border-radius:50%;

margin-top:25px;

}



.timeline-card{

flex:1;

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:18px;

padding:18px;

}



.timeline-header{

display:flex;

justify-content:space-between;

}



.timeline-header h4{

margin:0 0 5px;

font-size:14px;

}



.timeline-header span{

font-size:12px;

color:#64748b;

}



.progress-badge{

background:#dbeafe;

color:#1d4ed8;

padding:6px 12px;

border-radius:999px;

font-size:11px;

font-weight:800;

}



.timeline-card p{

font-size:13px;

color:#475569;

line-height:1.5;

}



.timeline-info{

display:flex;

gap:20px;

font-size:12px;

color:#64748b;

}



.budget{

margin-top:12px;

background:#dcfce7;

color:#166534;

padding:10px;

border-radius:12px;

font-size:12px;

font-weight:700;

}



.note{

margin-top:10px;

background:#fef3c7;

color:#92400e;

padding:10px;

border-radius:12px;

font-size:12px;

}



.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}




@media(max-width:1100px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


.task-grid{

grid-template-columns:1fr;

}


}



@media(max-width:700px){


.summary-grid{

grid-template-columns:1fr;

}


.daily-header{

flex-direction:column;

align-items:flex-start;

gap:20px;

}


.task-detail{

grid-template-columns:1fr;

}


.timeline-header{

flex-direction:column;

gap:10px;

}



}


</style>


@endsection