@extends('layouts.dashboard')

@section('content')

<div class="project-container">


<div class="project-welcome-card">

    <div>

        <div class="project-welcome-label">
            PROYEK SAYA
        </div>


        <h1>
            Proyek Saya
        </h1>


        <p>
            Monitoring project dan tugas yang diberikan kepada kamu.
        </p>

    </div>


    <div class="project-date-box">
        {{date('d M Y')}}
    </div>


</div>


@forelse($proyek as $project)


<div class="project-panel">


{{-- HEADER PROJECT --}}

<div class="project-card-header">


<h2>
📁 {{$project->nama_proyek}}
</h2>


<p>
🏢 Perusahaan :
<strong>
{{$project->perusahaan->nama_perusahaan ?? '-'}}
</strong>
</p>



@if($project->perusahaan)

<p>
📍 Alamat :
{{$project->perusahaan->alamat ?? '-'}}
</p>


<p>
☎ Kontak :
{{$project->perusahaan->kontak ?? '-'}}
</p>

@endif



<p>
Pemilik :
{{$project->pemilik_proyek ?? '-'}}
</p>



</div>




{{-- INFO PROJECT --}}

<div class="project-extra-info">


<div>

<span>
📅 Periode Project
</span>


<strong>

{{\Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y')}}

-

@if($project->tanggal_selesai)

{{\Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y')}}

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
Rp {{number_format($project->total_anggaran ?? 0,0,',','.')}}
</strong>

</div>




<div>

<span>
👥 Anggota
</span>


<strong>
{{$project->tugas
    ->pluck('karyawan_id')
    ->unique()
    ->count()
}} Orang
</strong>

</div>



</div>






{{-- SUMMARY --}}

<div class="project-summary-box">


<div>

<span>
Total Tugas
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
->whereIn('status',['selesai','done'])
->count()}}

</strong>


</div>




<div>

<span>
Progress Project
</span>


<strong>
{{round(
    $project->tugas->avg('progres_persen') ?? 0
)}}%
</strong>


</div>




<div>

<span>
Project Perusahaan
</span>


<strong>

{{$project->perusahaan?->proyek?->count() ?? 0}}

</strong>


</div>



</div>







{{-- AKTIVITAS --}}

<h3 class="project-section-title">
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


<div class="activity-item">


<div class="activity-icon">
✓
</div>



<div>

<strong>
{{$aktivitas->aktivitas ?? 'Update Aktivitas'}}
</strong>


<p>
{{$aktivitas->keterangan ?? $aktivitas->aktivitas ?? '-'}}
</p>


<small>

{{\Carbon\Carbon::parse($aktivitas->created_at)
->format('d M Y H:i')}}

</small>


</div>


</div>


@endforeach


@else


<p>
Belum ada aktivitas
</p>


@endif




{{-- TASK --}}

<h3 class="project-section-title">
    📌 Tugas Saya
</h3>


@if($project->tugas->count()==0)

<div class="empty-box">
    Belum ada tugas
</div>

@endif



@foreach($project->tugas as $task)


<div class="project-task-card">


    {{-- BAGIAN KIRI --}}

    <div class="project-task-main">


        <div class="project-task-title">

            <h4>
                {{$task->nama_tugas}}
            </h4>

<small>

Deadline:

@if($task->deadline)

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

@else

-

@endif


<br>


Status:

@if($task->status == 'belum_dikerjakan')

Belum Dikerjakan

@elseif(in_array($task->status,[
    'sedang_dikerjakan',
    'berjalan',
    'progress'
]))

Sedang Dikerjakan

@elseif(in_array($task->status,['selesai','done']))

Selesai

@else

{{$task->status}}

@endif


</small>

@if($task->deadline && !in_array($task->status,['selesai','done']))

@if(\Carbon\Carbon::parse($task->deadline)->isPast())

<span class="late-warning">
⚠ Terlambat
</span>

@endif

@endif
            <p>
                {{$task->aktivitas ?? '-'}}
            </p>

        </div>




        <div class="project-progress-label">

            <span>
                Progress
            </span>


            <b>
                {{number_format($task->progres_persen ?? 0,0)}}%
            </b>


        </div>





        <div class="project-progress-track">


            <div class="project-progress-value"
            style="width:{{max(min($task->progres_persen ?? 0,100),0)}}%">
            </div>


        </div>




        <div class="project-activity-info">

            📝 {{$task->aktivitasTugas?->count() ?? 0}} Aktivitas

        </div>


    </div>







    {{-- BAGIAN KANAN --}}

    <div class="project-task-side">



        <span class="project-status

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


        @elseif($task->status == 'belum_dikerjakan')

            Belum Dikerjakan


        @else

            {{$task->status}}

        @endif


        </span>





        <div class="project-button-group">


            <a href="{{route('employee.task.show',$task->id)}}">

                Detail

            </a>




            @if(!in_array($task->status,['selesai','done']))


            <a href="{{route('daily-tracker.show',$task->id)}}"
            class="project-update-btn">

                Update

            </a>


            @endif



        </div>


    </div>




</div>



@endforeach




</div> {{-- tutup project-panel --}}


@empty


<div class="project-panel">

    Belum ada project.

</div>


@endforelse


</div> {{-- tutup project-container --}}
<style>

/* ===============================
GLOBAL
================================ */

.project-container{
    width:100%;
}


.project-container *{
    box-sizing:border-box;
}





/* ===============================
HEADER
================================ */


.project-welcome-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.project-welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.project-welcome-card h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.project-welcome-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}



.project-date-box{

    background:#dcfce7;

    color:#166534;

    padding:10px 18px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}






/* ===============================
PROJECT PANEL
================================ */


.project-panel{

    background:white;

    padding:25px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    margin-bottom:20px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}





/* ===============================
PROJECT HEADER
================================ */


.project-card-header h2{

    margin:0;

    font-size:18px;

    font-weight:800;

    color:#1e293b;

}



.project-card-header p{

    margin:6px 0;

    font-size:12px;

    color:#64748b;

}






/* ===============================
EXTRA INFO
================================ */


.project-extra-info{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:12px;

    margin-top:20px;

}



.project-extra-info div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:15px;

    padding:14px;

}



.project-extra-info span{

    display:block;

    font-size:10px;

    color:#64748b;

    font-weight:700;

    margin-bottom:6px;

}



.project-extra-info strong{

    font-size:12px;

    color:#1e293b;

}







/* ===============================
SUMMARY
================================ */


.project-summary-box{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin:25px 0;

}



.project-summary-box div{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

}



.project-summary-box span{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.project-summary-box strong{

    display:block;

    margin-top:8px;

    font-size:22px;

    color:#1e293b;

}







/* ===============================
TITLE
================================ */


.project-section-title{

    font-size:16px;

    font-weight:800;

    color:#1e293b;

    border-left:4px solid #334155;

    padding-left:10px;

    margin:25px 0 15px;

}







/* ===============================
ACTIVITY
================================ */


.activity-item{

    display:flex;

    gap:12px;

    padding:14px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:14px;

    margin-bottom:10px;

}



.activity-icon{

    width:32px;

    height:32px;

    border-radius:50%;

    background:#dcfce7;

    color:#166534;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:800;

}



.activity-item strong{

    font-size:12px;

    color:#1e293b;

}



.activity-item p{

    margin:5px 0;

    font-size:11px;

    color:#64748b;

}



.activity-item small{

    font-size:10px;

    color:#94a3b8;

}



/* ===============================
TASK CARD
================================ */

.project-task-card{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:25px;

    width:100%;

    padding:18px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    margin-bottom:12px;

    transition:.2s;

}



.project-task-card:hover{

    background:white;

    transform:translateY(-2px);

    box-shadow:
    0 8px 20px rgba(15,23,42,.06);

}



.project-task-main{

    flex:1;

    min-width:0;

}




.project-task-title h4{

    margin:0 0 6px;

    font-size:14px;

    font-weight:800;

    color:#1e293b;

}



.project-task-title p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* ===============================
PROGRESS
================================ */


.project-progress-label{

    display:flex;

    justify-content:space-between;

    margin-top:15px;

    margin-bottom:7px;

    font-size:11px;

}



.project-progress-label b{

    color:#166534;

}



.project-progress-track{

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.project-progress-value{

    height:100%;

    background:#16a34a;

    border-radius:20px;

}



.project-activity-info{

    margin-top:12px;

    font-size:12px;

    color:#64748b;

}





/* ===============================
SIDE TASK
================================ */


.project-task-side{

    width:170px;

    flex-shrink:0;

}





.project-status{

    display:block;

    width:100%;

    padding:7px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    text-align:center;

    margin-bottom:10px;

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

    background:#f1f5f9;

    color:#475569;

}







/* ===============================
BUTTON
================================ */


.project-button-group{

    display:flex;

    gap:8px;

    width:100%;

}



.project-button-group a{

    flex:1;

    text-align:center;

    text-decoration:none;

    background:#334155;

    color:white;

    padding:8px 10px;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

}





.project-update-btn{

    background:#2563eb!important;

}




/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.project-summary-box{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.project-extra-info{

    grid-template-columns:1fr;

}



.project-task-card{

    flex-direction:column;

}




.project-summary-box{

    grid-template-columns:1fr;

}



.project-welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}





/* BUTTON AGAR RAPI */

.project-button-group a{

    flex:1;
    text-align:center;

}


/* STATUS LEBIH RAPI */

.project-status{

    letter-spacing:.3px;

}

.late-warning{

display:inline-block;

margin-top:8px;

background:#fee2e2;

color:#b91c1c;

padding:5px 10px;

border-radius:999px;

font-size:10px;

font-weight:700;

}

</style>
@endsection