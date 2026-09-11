@extends('layouts.dashboard')

@section('content')


<div class="employee-task-wrapper">


{{-- HEADER --}}

<div class="task-hero">


<div>

<span class="hero-label">
TASK DETAIL
</span>


<h1>
{{$task->nama_tugas}}
</h1>


<p>
📁 {{$task->proyek->nama_proyek ?? '-'}}
</p>


</div>



<a href="{{route('employee.project.index')}}" class="back-btn">

← Kembali

</a>



</div>







{{-- INFO CARD --}}

<div class="info-grid">



<div class="info-card">

<div class="info-icon">
📌
</div>


<div>

<span>
Status
</span>


<strong>

{{ucfirst(str_replace('_',' ',$task->status))}}

</strong>


</div>


</div>






<div class="info-card">

<div class="info-icon">
📅
</div>


<div>

<span>
Deadline
</span>


<strong>

@if($task->deadline)

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

@else

-

@endif

</strong>


</div>


</div>







<div class="info-card">

<div class="info-icon">
📊
</div>


<div>

<span>
Progress
</span>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>


</div>


</div>



</div>







{{-- PROGRESS BAR --}}

<div class="progress-card">


<div class="progress-head">


<span>
Progress Pekerjaan
</span>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>


</div>




<div class="progress-track">


<div class="progress-fill"

style="
width:{{min($task->progres_persen ?? 0,100)}}%
">

</div>


</div>


</div>







{{-- UPDATE FORM --}}


<div class="form-card">


<div class="section-title">

✏️ Update Aktivitas

</div>



@if(in_array($task->status,['selesai','done','dibatalkan']))

<div class="note">
    Task sudah selesai dan tidak dapat diperbarui lagi.
</div>

@else


<form method="POST"
action="{{route('daily-tracker.store',$task->id)}}">


@csrf



<div class="form-grid">



<div>


<label>
Aktivitas
</label>


<textarea

name="aktivitas"

placeholder="Tuliskan aktivitas hari ini..."

required></textarea>



<label>
Catatan
</label>


<textarea

name="catatan"

placeholder="Tambahkan catatan">

</textarea>



</div>






<div>


<label>
Progress (%)
</label>


<input
type="number"

name="progres"

min="0"

max="100"

value="{{$task->progres_persen ?? 0}}"
>




<label>
Anggaran Aktivitas
</label>


<input

type="number"

name="anggaran_aktivitas"

placeholder="Rp">




<button class="save-btn">

Simpan Update

</button>



</div>



</div>



</form>
@endif

</div>

{{-- RIWAYAT AKTIVITAS --}}

<div class="history-card">


<div class="section-title">

📋 Riwayat Aktivitas

</div>



@if($activities->count())


<div class="timeline">


@foreach($activities->sortByDesc('tanggal') as $activity)


<div class="timeline-item">


<div class="timeline-dot"></div>



<div class="timeline-content">


<div class="timeline-top">


<div>

<h4>
{{$activity->aktivitas}}
</h4>


<span>
{{$activity->karyawan->nama_karyawan ?? '-'}}
</span>


</div>



<div class="progress-badge">
{{$activity->progres ?? 0}}%
@if(($activity->progres ?? 0) >= 100)
 - Selesai
@elseif(($activity->progres ?? 0) > 0)
 - Berjalan
@endif
</div>

</div>





<div class="timeline-info">


<span>
📅
{{\Carbon\Carbon::parse($activity->tanggal)->format('d M Y')}}
</span>



@if($activity->anggaran_aktivitas)

<span>
💰
Rp {{number_format(
$activity->anggaran_aktivitas,
0,
',',
'.'
)}}
</span>

@endif


</div>






@if($activity->catatan)


<div class="note">

{{$activity->catatan}}

</div>


@endif



</div>


</div>



@endforeach


</div>



@else


<div class="empty">

Belum ada aktivitas.

</div>


@endif



</div>





</div>






<style>


.employee-task-wrapper{

width:100%;

}





/* HERO */


.task-hero{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:26px;

padding:30px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.hero-label{

font-size:10px;

font-weight:800;

letter-spacing:2px;

color:#64748b;

}



.task-hero h1{

margin:10px 0;

font-size:28px;

font-weight:800;

color:#172033;

}



.task-hero p{

margin:0;

color:#64748b;

font-size:13px;

}



.back-btn{

background:#334155;

color:white;

padding:12px 20px;

border-radius:14px;

font-size:12px;

font-weight:700;

text-decoration:none;

}







/* INFO */


.info-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

margin-bottom:25px;

}



.info-card{

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



.info-icon{

width:45px;

height:45px;

background:#f1f5f9;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}



.info-card span{

display:block;

font-size:11px;

color:#64748b;

}



.info-card strong{

display:block;

margin-top:5px;

font-size:15px;

color:#172033;

}






/* PROGRESS */


.progress-card{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

margin-bottom:25px;

}



.progress-head{

display:flex;

justify-content:space-between;

margin-bottom:12px;

font-size:13px;

}



.progress-head strong{

color:#16a34a;

}



.progress-track{

height:12px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-fill{

height:100%;

background:#334155;

border-radius:20px;

}







/* FORM */


.form-card,

.history-card{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

margin-bottom:25px;

box-shadow:
0 10px 30px rgba(15,23,42,.05);

}



.section-title{

font-size:16px;

font-weight:800;

color:#172033;

margin-bottom:20px;

}



.form-grid{

display:grid;

grid-template-columns:2fr 1fr;

gap:25px;

}



label{

display:block;

font-size:12px;

font-weight:700;

color:#475569;

margin-bottom:8px;

}



textarea,

input{

width:100%;

border:1px solid #e2e8f0;

background:#f8fafc;

border-radius:14px;

padding:12px;

font-size:13px;

margin-bottom:18px;

}



textarea{

min-height:90px;

resize:none;

}



textarea:focus,

input:focus{

outline:none;

background:white;

border-color:#334155;

}



.save-btn{

width:100%;

height:45px;

background:#1e293b;

color:white;

border:none;

border-radius:14px;

font-weight:700;

cursor:pointer;

}

.save-btn:hover{
    background:#0f172a;
    transform:translateY(-1px);
}




/* TIMELINE */


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



.timeline-content{

flex:1;

background:#f8fafc;

border-radius:18px;

padding:18px;

border:1px solid #e2e8f0;

}



.timeline-top{

display:flex;

justify-content:space-between;

}



.timeline-top h4{

margin:0 0 5px;

font-size:14px;

color:#172033;

}



.timeline-top span{

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



.timeline-info{

display:flex;

gap:20px;

font-size:12px;

color:#64748b;

margin-top:12px;

}



.note{

background:#fef3c7;

color:#92400e;

padding:10px;

border-radius:12px;

margin-top:12px;

font-size:12px;

}



.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}







@media(max-width:900px){


.info-grid{

grid-template-columns:1fr;

}



.form-grid{

grid-template-columns:1fr;

}



.task-hero{

flex-direction:column;

align-items:flex-start;

gap:20px;

}



}



</style>


@endsection