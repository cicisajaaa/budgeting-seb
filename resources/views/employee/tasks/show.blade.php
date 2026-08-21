@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>


<div class="welcome-label">

TASK DETAIL

</div>



<h1>

{{ $task->nama_tugas }}

</h1>



<p>

{{ $task->proyek->nama_proyek ?? '-' }}

</p>



</div>





<a href="{{ route('employee.project.index') }}"
class="back-btn">

← Kembali

</a>



</div>









<div class="glass-panel">


<div class="panel-header">


<h2>

📌 Informasi Task

</h2>


</div>






<div class="detail-grid">





<div class="info-box">


<label>

Project

</label>



<strong>

{{ $task->proyek->nama_proyek ?? '-' }}

</strong>



</div>







<div class="info-box">


<label>

Prioritas

</label>



<strong>

{{ $task->prioritas }}

</strong>



</div>







<div class="info-box">


<label>

Deadline

</label>



<strong>

{{ $task->deadline ?? '-' }}

</strong>



</div>








<div class="info-box">


<label>

Status

</label>



<span class="
status

@if(in_array($task->status,['selesai','done']))

done

@elseif(in_array($task->status,['berjalan','progress']))

progress

@else

todo

@endif

">


{{ strtoupper($task->status) }}


</span>



</div>





</div>



</div>
{{-- ================= PROGRESS ================= --}}


<div class="glass-panel">


<h2>

📊 Progress Pekerjaan

</h2>





<div class="progress-area">



<div class="progress-track">



<div class="progress-value"


style="width:{{ $task->progres_persen }}%">



</div>



</div>





<div class="progress-number">


{{ number_format($task->progres_persen,0) }}%


</div>




</div>







<a href="{{ route('daily-tracker.show',$task->id) }}"

class="update-btn">


📝 Update Progress


</a>



</div>









{{-- ================= DESKRIPSI ================= --}}



<div class="glass-panel">



<h2>

📝 Deskripsi Pekerjaan

</h2>




<div class="description">



{{ $task->aktivitas ?? 'Tidak ada deskripsi pekerjaan.' }}



</div>




</div>









{{-- ================= TIMELINE AKTIVITAS ================= --}}



<div class="glass-panel">



<h2>

⏳ Timeline Aktivitas

</h2>






@forelse($task->aktivitasTugas as $activity)





<div class="timeline-item">



<div class="timeline-dot"></div>






<div class="timeline-content">





<strong>


{{ \Carbon\Carbon::parse(

$activity->tanggal

)->format('d M Y') }}



</strong>






<p>


{{ $activity->aktivitas }}


</p>







<div class="activity-progress">


Progress :

{{ $activity->progres ?? 0 }}%


</div>







@if($activity->catatan)



<small>


Catatan:

{{ $activity->catatan }}



</small>



@endif






</div>





</div>






@empty




<div class="empty">


Belum ada aktivitas.


</div>




@endforelse





</div>


<style>

/* ===============================
GLOBAL
================================ */

.task-container{
    width:100%;
}



/* ===============================
HEADER OWNER STYLE
================================ */


.welcome-card{

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



.welcome-label{

    font-size:10px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.welcome-card h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.welcome-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}





/* ===============================
BACK BUTTON
================================ */


.back-btn{

    background:#334155;

    color:white;

    padding:10px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.back-btn:hover{

    background:#1e293b;

}







/* ===============================
PANEL OWNER STYLE
================================ */


.glass-panel{

    background:white;

    padding:25px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.glass-panel h2{

    font-size:17px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:20px;

}







/* ===============================
DETAIL GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

}



.info-box{

    background:#f8fafc;

    padding:18px;

    border-radius:16px;

    border:1px solid #e2e8f0;

}



.info-box label{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:700;

    margin-bottom:8px;

}



.info-box strong{

    font-size:14px;

    color:#1e293b;

}







/* ===============================
STATUS BADGE
================================ */


.status{

    display:inline-flex;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.status.todo{

    background:#f1f5f9;

    color:#475569;

}



.status.progress{

    background:#dbeafe;

    color:#1d4ed8;

}



.status.done{

    background:#dcfce7;

    color:#166534;

}







/* ===============================
PROGRESS OWNER STYLE
================================ */


.progress-area{

    display:flex;

    align-items:center;

    gap:15px;

}



.progress-track{

    flex:1;

    height:10px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-value{

    height:100%;

    background:#16a34a;

    border-radius:20px;

}



.progress-number{

    font-size:22px;

    font-weight:800;

    color:#1e293b;

}






/* ===============================
UPDATE BUTTON
================================ */


.update-btn{

    display:inline-flex;

    margin-top:20px;

    background:#334155;

    color:white;

    padding:10px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.update-btn:hover{

    background:#1e293b;

}







/* ===============================
DESCRIPTION
================================ */


.description{

    background:#f8fafc;

    padding:18px;

    border-radius:16px;

    border:1px solid #e2e8f0;

    color:#475569;

    font-size:13px;

    line-height:1.7;

}







/* ===============================
TIMELINE AUDIT STYLE
================================ */


.timeline-item{

    display:flex;

    gap:15px;

    padding:18px;

    background:#f8fafc;

    border-radius:16px;

    border:1px solid #e2e8f0;

    margin-bottom:12px;

}



.timeline-dot{

    width:12px;

    height:12px;

    background:#16a34a;

    border-radius:50%;

    margin-top:5px;

}



.timeline-content strong{

    color:#1e293b;

    font-size:13px;

}



.timeline-content p{

    margin:8px 0;

    color:#64748b;

    font-size:12px;

}



.activity-progress{

    display:inline-flex;

    padding:5px 12px;

    border-radius:999px;

    background:#dcfce7;

    color:#166534;

    font-size:11px;

    font-weight:700;

}



.timeline-content small{

    display:block;

    margin-top:8px;

    color:#64748b;

}







/* ===============================
EMPTY
================================ */


.empty{

    padding:35px;

    text-align:center;

    color:#94a3b8;

}





/* ===============================
RESPONSIVE
================================ */


@media(max-width:1100px){


.detail-grid{

grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:700px){


.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



.detail-grid{

grid-template-columns:1fr;

}



.progress-area{

flex-direction:column;

align-items:flex-start;

}



.progress-track{

width:100%;

}



.glass-panel{

padding:20px;

}


}


</style>


@endsection