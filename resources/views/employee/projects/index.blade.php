@extends('layouts.dashboard')

@section('content')

<div class="project-container">


{{-- ================= HEADER ================= --}}

<div class="project-welcome-card">

    <div class="welcome-content">

        <span class="project-label">
            PROYEK SAYA
        </span>


        <h1>
            Proyek Saya
        </h1>


        <p>
            Monitoring project dan tugas yang diberikan kepada kamu.
        </p>

    </div>


    <div class="project-date-box">

        {{ date('d M Y') }}

    </div>


</div>



{{-- ================= SEARCH ================= --}}


<form method="GET"
action="{{ route('employee.project.index') }}"
class="project-search">


<input
type="text"
name="search"
value="{{ $search ?? '' }}"
placeholder="Cari nama project..."
>


<button type="submit">
    Cari
</button>


@if(!empty($search))

<a href="{{ route('employee.project.index') }}">
    Reset
</a>

@endif


</form>





{{-- ================= PROJECT LIST ================= --}}


@forelse($proyek as $project)


<div class="project-panel">



{{-- PROJECT HEADER --}}


<div class="project-card-header">


<div>


<h2>
📁 {{ $project->nama_proyek }}
</h2>


<p>
🏢
{{ $project->perusahaan->nama_perusahaan ?? '-' }}
</p>


</div>


<span class="project-status-top">

Aktif

</span>


</div>





{{-- DETAIL PERUSAHAAN --}}


<div class="company-info">


@if($project->perusahaan)

<div>

<span>
Alamat
</span>

<strong>
{{ $project->perusahaan->alamat ?? '-' }}
</strong>

</div>


<div>

<span>
Kontak
</span>

<strong>
{{ $project->perusahaan->kontak ?? '-' }}
</strong>

</div>


@endif



<div>

<span>
Pemilik Project
</span>


<strong>
{{ $project->pemilik_proyek ?? '-' }}
</strong>

</div>


</div>





{{-- INFO PROJECT --}}


<div class="project-info-grid">


<div>

<span>
📅 Periode
</span>


<strong>

{{
\Carbon\Carbon::parse($project->tanggal_mulai)
->format('d M Y')
}}


-

@if($project->tanggal_selesai)

{{
\Carbon\Carbon::parse($project->tanggal_selesai)
->format('d M Y')
}}

@else

Berjalan

@endif

</strong>


</div>





<div>

<span>
💰 Budget
</span>


<strong>

Rp {{ number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</strong>

</div>





<div>

<span>
👥 Anggota
</span>


<strong>

{{

$project->tugas
->pluck('karyawan_id')
->unique()
->count()

}}

 Orang

</strong>

</div>



</div>






{{-- SUMMARY --}}


<div class="project-summary">


<div>

<span>
Total Task
</span>

<strong>

{{ $project->tugas->count() }}

</strong>

</div>



<div>

<span>
Selesai
</span>

<strong>

{{

$project->tugas
->whereIn(
'status',
[
'selesai',
'done'
]
)
->count()

}}

</strong>

</div>




<div>

<span>
Progress
</span>


<strong>

{{ round(
$project->tugas
->avg('progres_persen') ?? 0
)}}%

</strong>


</div>




<div>

<span>
Project Perusahaan
</span>


<strong>

{{
$project->perusahaan?->proyek?->count() ?? 0
}}

</strong>


</div>


</div>

{{-- ================= AKTIVITAS TERAKHIR ================= --}}


<h3 class="section-title">
    🕒 Aktivitas Terakhir
</h3>


@php

$aktivitasTerakhir = $project->tugas
->pluck('aktivitasTugas')
->flatten()
->sortByDesc('created_at')
->take(3);

@endphp



@if($aktivitasTerakhir->count())


@foreach($aktivitasTerakhir as $aktivitas)


<div class="activity-card">


<div class="activity-icon">

✓

</div>



<div class="activity-content">


<strong>

{{ $aktivitas->aktivitas ?? 'Update Aktivitas' }}

</strong>



<p>

{{
$aktivitas->keterangan
??
$aktivitas->aktivitas
??
'-'
}}

</p>



<small>

{{
\Carbon\Carbon::parse($aktivitas->created_at)
->format('d M Y H:i')
}}

</small>



</div>


</div>


@endforeach


@else


<div class="empty-box">

Belum ada aktivitas

</div>


@endif







{{-- ================= TASK ================= --}}



<h3 class="section-title">

📌 Tugas Saya

</h3>



@if($project->tugas->count()==0)


<div class="empty-box">

Belum ada tugas

</div>


@endif





@foreach($project->tugas as $task)



<div class="task-card">



{{-- TASK CONTENT --}}


<div class="task-content">


<h4>

{{ $task->nama_tugas }}

</h4>



<div class="task-meta">


<div>

Deadline

<br>

<strong>

@if($task->deadline)

{{
\Carbon\Carbon::parse($task->deadline)
->format('d M Y')

}}

@else

-

@endif


</strong>


</div>



<div>

Status

<br>


<strong>

@if(
in_array(
$task->status,
[
'selesai',
'done'
]
)
)

Selesai


@elseif(
in_array(
$task->status,
[
'sedang_dikerjakan',
'berjalan',
'progress'
]
)
)

Sedang Dikerjakan


@else

Belum Dikerjakan


@endif


</strong>


</div>



</div>







@if(
$task->deadline
&&
!in_array(
$task->status,
[
'selesai',
'done'
]
)
)


@if(
\Carbon\Carbon::parse($task->deadline)
->isPast()
)


<span class="late-warning">

⚠ Terlambat

</span>


@endif


@endif






<div class="progress-header">


<span>

Progress

</span>



<strong>

{{ number_format(
$task->progres_persen ?? 0,
0
)}}%

</strong>



</div>




<div class="progress-track">


<div
class="progress-fill"
style="
width:
{{
max(
min(
$task->progres_persen ?? 0,
100
),
0
)
}}%
">

</div>


</div>







<div class="task-footer">


<span>

📝
{{
$task->aktivitasTugas?->count() ?? 0
}}
Aktivitas

</span>



<div class="task-button">


<a href="
{{
route(
'employee.task.show',
$task->id
)
}}
">

Detail

</a>





@if(
!in_array(
$task->status,
[
'selesai',
'done'
]
)
)


<a
class="update-btn"
href="
{{
route(
'daily-tracker.show',
$task->id
)
}}
">

Update

</a>



@endif



</div>



</div>






</div>





{{-- STATUS --}}


<div class="task-status">


@if(
in_array(
$task->status,
[
'selesai',
'done'
]
)
)


<span class="done">

Selesai

</span>



@elseif(
in_array(
$task->status,
[
'sedang_dikerjakan',
'berjalan',
'progress'
]
)
)


<span class="progress">

Sedang Dikerjakan

</span>



@else


<span class="todo">

Belum Dikerjakan

</span>



@endif


</div>





</div>





@endforeach





</div>


@empty



<div class="project-panel empty-box">

Belum ada project

</div>


@endforelse



</div>

<style>

*{
    box-sizing:border-box;
}


.project-container{
    width:100%;
}



/* ================= HEADER ================= */


.project-welcome-card{

    background:#f8fafc;

    padding:25px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.project-label{

    font-size:11px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.project-welcome-card h1{

    margin:8px 0;

    font-size:28px;

    color:#172033;

}



.project-welcome-card p{

    margin:0;

    color:#64748b;

    font-size:14px;

}



.project-date-box{

    background:#dcfce7;

    color:#166534;

    padding:10px 18px;

    border-radius:999px;

    font-weight:700;

    font-size:13px;

}




/* ================= SEARCH ================= */

.project-search {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 15px;
    margin-bottom: 25px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    box-sizing: border-box;
}

.project-search input {
    flex: 1;
    min-width: 0;
    width: 100%;
    height: 44px;
    padding: 0 15px;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    background: #ffffff;
    color: #172033;
    font-size: 13px;
    font-family: inherit;
    box-sizing: border-box;
    transition: .2s;
}

.project-search input::placeholder {
    color: #94a3b8;
}

.project-search input:hover {
    border-color: #94a3b8;
}

.project-search input:focus {
    outline: none;
    border-color: #64748b;
    box-shadow: 0 0 0 3px rgba(100, 116, 139, .08);
}

.project-search button {
    flex: 0 0 auto;
    height: 44px;
    padding: 0 22px;
    border: none;
    border-radius: 12px;
    background: #0f172a;
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: .2s;
}

.project-search button:hover {
    background: #1e293b;
}

.project-search a {
    flex: 0 0 auto;
    height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 18px;
    background: #f1f5f9;
    color: #334155;
    border-radius: 12px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    box-sizing: border-box;
    transition: .2s;
}

.project-search a:hover {
    background: #e2e8f0;
}




/* ================= PROJECT CARD ================= */



.project-panel{

    background:white;

    padding:25px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    margin-bottom:20px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}




.project-card-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:15px;

}



.project-card-header h2{

    margin:0;

    font-size:20px;

    color:#172033;

}



.project-card-header p{

    margin:8px 0;

    color:#64748b;

}



.project-status-top{

    background:#dcfce7;

    color:#166534;

    padding:7px 15px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}



/* ================= COMPANY INFO ================= */


.company-info{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:12px;

    margin-top:20px;

}



.company-info div,
.project-info-grid div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:15px;

    border-radius:15px;

}



.company-info span,
.project-info-grid span{

    display:block;

    font-size:11px;

    color:#64748b;

    margin-bottom:6px;

}



.company-info strong,
.project-info-grid strong{

    font-size:13px;

    color:#172033;

}



/* ================= INFO ================= */


.project-info-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:12px;

    margin-top:15px;

}



/* ================= SUMMARY ================= */


.project-summary{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin:25px 0;

}



.project-summary div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:18px;

}



.project-summary span{

    display:block;

    color:#64748b;

    font-size:12px;

}



.project-summary strong{

    display:block;

    margin-top:8px;

    font-size:24px;

    color:#172033;

}



/* ================= TITLE ================= */


.section-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    border-left:4px solid #334155;

    padding-left:10px;

    margin:25px 0 15px;

}





/* ================= ACTIVITY ================= */


.activity-card{

    display:flex;

    gap:12px;

    padding:15px;

    background:#f8fafc;

    border-radius:15px;

    border:1px solid #e2e8f0;

    margin-bottom:10px;

}



.activity-icon{

    width:35px;

    height:35px;

    border-radius:50%;

    background:#dcfce7;

    color:#166534;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

}



.activity-content strong{

    color:#172033;

    font-size:13px;

}



.activity-content p{

    margin:5px 0;

    color:#64748b;

    font-size:12px;

}



.activity-content small{

    color:#94a3b8;

}



/* ================= TASK ================= */


.task-card{

    display:grid;

    grid-template-columns:1fr 160px;

    gap:20px;

    background:#fff;

    border:1px solid #e2e8f0;

    padding:20px;

    border-radius:18px;

    margin-bottom:15px;

}



.task-content h4{

    margin:0 0 12px;

    font-size:16px;

    color:#172033;

}



.task-meta{

    display:flex;

    gap:30px;

    color:#64748b;

    font-size:12px;

}



.task-meta strong{

    color:#172033;

}



.late-warning{

    display:inline-block;

    margin-top:10px;

    background:#fee2e2;

    color:#b91c1c;

    padding:5px 12px;

    border-radius:999px;

    font-size:11px;

}



.progress-header{

    display:flex;

    justify-content:space-between;

    margin-top:15px;

}



.progress-track{

    height:9px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-fill{

    height:100%;

    background:#16a34a;

}



.task-footer{

    margin-top:15px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.task-footer span{

    color:#64748b;

    font-size:12px;

}



.task-button{

    display:flex;

    gap:8px;

}



.task-button a{

    padding:8px 15px;

    border-radius:10px;

    background:#334155;

    color:white;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.task-button .update-btn{

    background:#2563eb;

}



/* STATUS */


.task-status span{

    display:block;

    text-align:center;

    padding:8px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}



.task-status .done{

    background:#dcfce7;

    color:#166534;

}



.task-status .progress{

    background:#dbeafe;

    color:#1d4ed8;

}



.task-status .todo{

    background:#f1f5f9;

    color:#475569;

}



.empty-box{

    padding:30px;

    text-align:center;

    color:#94a3b8;

}



/* ================= MOBILE ================= */


@media(max-width:900px){


.project-welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.project-date-box{

    width:100%;

    text-align:center;

}



.company-info,
.project-info-grid{

    grid-template-columns:1fr;

}



.project-summary{

    grid-template-columns:repeat(2,1fr);

}



.task-card{

    grid-template-columns:1fr;

}



.task-status{

    order:-1;

}



}



@media(max-width:600px){


.project-panel{

    padding:15px;

}



.project-welcome-card h1{

    font-size:22px;

}


.project-search {
    flex-direction: column;
    align-items: stretch;
    gap: 9px;
    padding: 12px;
}

.project-search input {
    width: 100%;
    height: 42px;
    font-size: 12px;
}

.project-search button,
.project-search a {
    width: 100%;
    height: 40px;
    justify-content: center;
    box-sizing: border-box;
}

.project-search button {
    font-size: 11px;
}

.project-search a {
    font-size: 11px;
}

.project-summary{

    grid-template-columns:1fr 1fr;

}



.project-summary strong{

    font-size:18px;

}



.task-meta{

    flex-direction:column;

    gap:8px;

}



.task-footer{

    flex-direction:column;

    align-items:stretch;

    gap:12px;

}



.task-button a{

    flex:1;

    text-align:center;

}


}


</style>

@endsection