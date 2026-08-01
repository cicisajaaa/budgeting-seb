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

body{
    background:#f8fafc;
}


.welcome-card{

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



.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:30px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    color:#64748b;

    font-size:14px;

}




/* ===============================
BACK BUTTON
================================ */


.back-btn{

    background:#ecfdf5;

    color:#15803d;

    padding:12px 22px;

    border-radius:999px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.back-btn:hover{

    background:#dcfce7;

}



/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    padding:28px;

    border-radius:24px;

    margin-bottom:22px;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}



.glass-panel h2{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin:0 0 22px;

}





/* ===============================
DETAIL GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:18px;

}



.info-box{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:18px;

    transition:.2s;

}



.info-box:hover{

    transform:translateY(-3px);

}



.info-box label{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:600;

    margin-bottom:8px;

}



.info-box strong{

    color:#172033;

    font-size:14px;

}



/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    padding:7px 15px;

    border-radius:999px;

    font-size:11px;

    font-weight:800;

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

    color:#15803d;

}





/* ===============================
PROGRESS
================================ */


.progress-area{

    display:flex;

    align-items:center;

    gap:20px;

}



.progress-track{

    flex:1;

    height:14px;

    background:#e2e8f0;

    border-radius:999px;

    overflow:hidden;

}



.progress-value{

    height:100%;

    background:

    linear-gradient(
    90deg,
    #16a34a,
    #22c55e
    );

    border-radius:999px;

}



.progress-number{

    font-size:24px;

    font-weight:800;

    color:#15803d;

}





.update-btn{

    display:inline-flex;

    margin-top:22px;

    background:#0f172a;

    color:white;

    padding:12px 24px;

    border-radius:14px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.update-btn:hover{

    background:#166534;

}





/* ===============================
DESCRIPTION
================================ */


.description{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:20px;

    border-radius:18px;

    color:#475569;

    line-height:1.7;

    font-size:14px;

}





/* ===============================
TIMELINE
================================ */


.timeline-item{

    display:flex;

    gap:18px;

    padding:18px;

    background:#f8fafc;

    border-radius:18px;

    margin-bottom:14px;

}



.timeline-dot{

    width:14px;

    height:14px;

    flex:none;

    background:#22c55e;

    border-radius:50%;

    margin-top:6px;

}



.timeline-content strong{

    color:#15803d;

    font-size:14px;

}



.timeline-content p{

    margin:8px 0;

    color:#475569;

    font-size:13px;

}



.activity-progress{

    display:inline-block;

    background:#ecfdf5;

    color:#15803d;

    padding:5px 12px;

    border-radius:999px;

    font-size:12px;

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

    padding:30px;

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

    gap:20px;

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