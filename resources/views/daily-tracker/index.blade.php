@extends('layouts.dashboard')

@section('content')

<div class="daily-container">


{{-- ================= HEADER ================= --}}

<div class="daily-header">


<div>

<span class="daily-label">
AKTIVITAS HARIAN KARYAWAN
</span>


<h1>
Aktivitas Harian
</h1>


<p>
Monitoring aktivitas dan perkembangan pekerjaan harian kamu.
</p>


</div>



<div class="date-box">

{{date('d M Y')}}

</div>



</div>





{{-- ================= SUMMARY ================= --}}


<div class="summary-grid">



<div class="summary-card">

<span>
Total Tugas
</span>

<h2>
{{$tasks->count()}}
</h2>

<p>
Task diberikan
</p>

</div>





<div class="summary-card">

<span>
Total Aktivitas
</span>


<h2>

{{$tasks->sum(function($task){

return $task->aktivitasTugas->count();

})}}

</h2>


<p>
Update pekerjaan
</p>

</div>






<div class="summary-card">

<span>
Progress Rata-rata
</span>


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






<div class="summary-card">

<span>
Anggaran Aktivitas
</span>

<h2>

Rp 
{{ number_format(
    $tasks->sum(function($task){

        return $task->aktivitasTugas
            ->sum('anggaran_aktivitas');

    }),
    0,
    ',',
    '.'
) }}

</h2>

<p>
Penggunaan dana
</p>


</div>




</div>







{{-- ================= TASK MONITORING ================= --}}


<div class="panel">


<div class="panel-title">

📌 Pemantauan Tugas

</div>




@forelse($tasks as $task)

<div class="task-card">



<div class="task-top">


<div>


<h3>
{{$task->nama_tugas}}
</h3>


<p>
📁 {{$task->proyek->nama_proyek ?? '-'}}
</p>


</div>
<span class="task-status

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


</div>






<div class="task-info">



<div>

<label>
Deadline
</label>

<strong>

@if($task->deadline)

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

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
{{number_format($task->progres_persen,0)}}%
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




<div class="task-progress">


<div 
class="task-progress-fill

@if($task->progres_persen >= 100)

finish

@elseif($task->progres_persen > 0)

running

@else

empty

@endif

"

style="
width:{{min($task->progres_persen ?? 0,100)}}%
">

</div>


</div>

<div style="margin-top:20px;">

<a href="{{route(
'daily-tracker.show',
$task->id
)}}"
class="btn-update">

+ Update Aktivitas

</a>

</div>



</div>



@empty


<div class="empty">

Belum ada task.

</div>


@endforelse



</div>









{{-- ================= TIMELINE ================= --}}



<div class="panel">


<div class="panel-title">

📝 Timeline Aktivitas

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


$activities=$activities->sortByDesc(function($item){

return $item['activity']->tanggal;

});


@endphp





@forelse($activities as $item)



<div class="activity-card">


<div class="activity-head">


<div>

<h4>
{{$item['task']}}
</h4>


<span>
📁 {{$item['project']}}
</span>

</div>



<div class="activity-progress-badge">


{{$item['activity']->progres ?? 0}}%

</div>


</div>





<div class="activity-body">


<p>
{{$item['activity']->aktivitas}}
</p>



<div class="activity-line">


<span>

👤 
{{$item['activity']->karyawan->nama_karyawan ?? '-'}}

</span>



<span>

📅

{{Carbon\Carbon::parse(
$item['activity']->tanggal
)->format('d M Y')}}

</span>



</div>




@if($item['activity']->anggaran_aktivitas > 0)


<div class="budget-box">


💰 Budget :

Rp {{number_format(
$item['activity']->anggaran_aktivitas,
0,
',',
'.'
)}}


</div>


@endif




@if($item['activity']->catatan)


<div class="note-box">


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









<style>


.daily-container{

width:100%;

}




/* HEADER */


.daily-header{


background:white;

border:1px solid #e5e7eb;

padding:30px;

border-radius:24px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

}



.daily-label{

font-size:11px;

letter-spacing:2px;

font-weight:800;

color:#64748b;

}



.daily-header h1{

font-size:30px;

margin:10px 0;

color:#172033;

}



.daily-header p{

color:#64748b;

}





.date-box{

background:#f8f3ea;

color:#8b5e22;

padding:12px 20px;

border-radius:30px;

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

padding:22px;

border-radius:20px;

}



.summary-card span{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin:8px 0;

color:#172033;

}



.summary-card p{

font-size:12px;

color:#94a3b8;

}






/* PANEL */


.panel{

background:white;

border:1px solid #e5e7eb;

padding:25px;

border-radius:24px;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.05);

}



.panel-title{

font-size:18px;

font-weight:800;

margin-bottom:20px;

color:#172033;

}






/* TASK */


.task-card{

background:#fafafa;

border:1px solid #e5e7eb;

padding:20px;

border-radius:18px;

margin-bottom:15px;

}

.task-card{

transition:.25s ease;

}


.task-card:hover{

transform:translateY(-4px);

box-shadow:
0 12px 25px rgba(15,23,42,.08);

}

.task-top{

display:flex;

justify-content:space-between;

align-items:center;

}



.task-top h3{

color:#172033;

margin-bottom:5px;

}



.task-top p{

font-size:13px;

color:#64748b;

}



.task-status{

display:inline-flex;

padding:7px 14px;

border-radius:999px;

font-size:11px;

font-weight:800;

}



.task-status.todo{

background:#f1f5f9;

color:#475569;

}



.task-status.progress{

background:#dbeafe;

color:#1d4ed8;

}



.task-status.done{

background:#dcfce7;

color:#166534;

}



.task-info{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

margin:20px 0;

}





.task-info div{

background:white;

padding:15px;

border-radius:14px;

}



.task-info label{

display:block;

font-size:11px;

color:#64748b;

}



.task-info strong{

color:#172033;

}


.task-progress{

height:12px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.task-progress-fill{

height:100%;

border-radius:20px;

transition:.4s ease;

}



.task-progress-fill.finish{

background:#16a34a;

}



.task-progress-fill.running{

background:#2563eb;

}



.task-progress-fill.empty{

background:#94a3b8;

}


.btn-update{

display:inline-block;

background:#1e293b;

color:white;

padding:10px 18px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

}


.btn-update:hover{

background:#334155;

}






/* ACTIVITY */


.activity-item{

display:flex;

gap:15px;

padding:18px 0;

border-bottom:1px solid #e5e7eb;

}



.activity-dot{

width:12px;

height:12px;

background:#16a34a;

border-radius:50%;

margin-top:8px;

}



.activity-content h4{

margin-bottom:5px;

color:#172033;

}



.activity-content p{

color:#475569;

margin-bottom:8px;

}



.activity-content span{

font-size:12px;

color:#8b5e22;

font-weight:700;

}



.activity-footer{

margin-top:8px;

font-size:12px;

color:#64748b;

}


/* ===============================
ACTIVITY CARD TIMELINE
================================ */


.activity-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:18px;

padding:18px;

margin-bottom:15px;

transition:.25s ease;

}



.activity-card:hover{

transform:translateY(-3px);

box-shadow:
0 10px 25px rgba(15,23,42,.08);

}





.activity-head{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:12px;

}



.activity-head h4{

margin:0;

font-size:15px;

color:#1e293b;

}




.activity-head span{

font-size:12px;

color:#64748b;

}





.activity-progress-badge{

background:#dbeafe;

color:#1d4ed8;

padding:7px 14px;

border-radius:999px;

font-size:12px;

font-weight:800;

}





.activity-body p{

color:#475569;

font-size:13px;

line-height:1.6;

margin-bottom:15px;

}




.activity-line{

display:flex;

gap:20px;

font-size:12px;

color:#64748b;

flex-wrap:wrap;

}





.budget-box{

margin-top:12px;

background:#dcfce7;

color:#166534;

padding:10px 14px;

border-radius:12px;

font-size:12px;

font-weight:700;

}




.note-box{

margin-top:12px;

background:#fef3c7;

color:#92400e;

padding:12px 14px;

border-radius:12px;

font-size:12px;

}


.empty{

text-align:center;

padding:25px;

color:#94a3b8;

}






@media(max-width:1000px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}



}



@media(max-width:700px){


.summary-grid{

grid-template-columns:1fr;

}


.daily-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



.task-top{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



.task-info{

grid-template-columns:1fr;

}


}


</style>


@endsection