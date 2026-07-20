@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


    <div>

        <div class="welcome-label">
            TASK DETAIL
        </div>


        <h1>
            {{ $task->nama_task }}
        </h1>


        <p>
            {{ $task->project->nama_project ?? '-' }}
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
{{ $task->project->nama_project ?? '-' }}
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
@if($task->status=='done')
done
@elseif($task->status=='progress')
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









<div class="glass-panel">


<h2>
📊 Progress Pekerjaan
</h2>



<div class="progress-area">


<div class="progress-track">


<div class="progress-value"

style="width:{{ $task->progress_persen }}%">

</div>


</div>



<div class="progress-number">

{{ number_format($task->progress_persen,0) }}%

</div>


</div>






<a href="{{ route('daily-tracker.show',$task->id) }}"
class="update-btn">

📝 Update Progress

</a>



</div>









<div class="glass-panel">


<h2>
📝 Deskripsi Pekerjaan
</h2>


<div class="description">


{{ $task->aktivitas ?? 'Tidak ada deskripsi pekerjaan.' }}


</div>



</div>









<div class="glass-panel">


<h2>
⏳ Timeline Aktivitas
</h2>




@forelse($task->activities as $activity)


<div class="timeline-item">


<div class="timeline-dot"></div>



<div class="timeline-content">


<strong>

{{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}

</strong>


<p>

{{ $activity->aktivitas }}

</p>



<div class="activity-progress">

Progress :
{{ $activity->progress }}%

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


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:28px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.welcome-label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

opacity:.8;

}



.welcome-card h1{

margin:8px 0;

font-size:28px;

}



.back-btn{

background:white;

color:#166534;

padding:12px 20px;

border-radius:20px;

text-decoration:none;

font-weight:700;

font-size:13px;

}







.glass-panel{

background:white;

padding:24px;

border-radius:24px;

margin-bottom:20px;

box-shadow:
0 10px 30px rgba(15,23,42,.08);

}



.panel-header h2,
.glass-panel h2{

font-size:20px;

margin-bottom:18px;

color:#1e293b;

}







.detail-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

}



.info-box{

background:#f8fafc;

padding:18px;

border-radius:15px;

}



.info-box label{

display:block;

font-size:12px;

color:#64748b;

margin-bottom:8px;

}



.info-box strong{

color:#166534;

}








.status{

display:inline-block;

padding:7px 15px;

border-radius:20px;

font-size:12px;

font-weight:700;

}



.status.todo{

background:#e2e8f0;

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







.progress-track{

height:18px;

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




.progress-number{

font-size:28px;

font-weight:800;

color:#166534;

margin-top:12px;

}







.update-btn{

display:inline-block;

margin-top:20px;

background:#166534;

color:white;

padding:12px 22px;

border-radius:15px;

text-decoration:none;

font-weight:700;

font-size:13px;

}



.update-btn:hover{

background:#22c55e;

}







.description{

background:#f8fafc;

padding:18px;

border-radius:15px;

color:#475569;

line-height:1.6;

}







.timeline-item{

display:flex;

gap:15px;

padding:18px 0;

border-bottom:1px solid #e2e8f0;

}



.timeline-dot{

width:12px;

height:12px;

background:#22c55e;

border-radius:50%;

margin-top:8px;

}



.timeline-content strong{

color:#166534;

}



.timeline-content p{

margin:8px 0;

color:#475569;

}



.activity-progress{

font-weight:700;

color:#166534;

}



.timeline-content small{

color:#64748b;

}



.empty{

color:#94a3b8;

}






@media(max-width:1000px){


.detail-grid{

grid-template-columns:repeat(2,1fr);

}


}




@media(max-width:600px){


.detail-grid{

grid-template-columns:1fr;

}



.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}



</style>



@endsection