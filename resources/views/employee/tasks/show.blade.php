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




<a href="{{ route('daily-tracker.index') }}"
class="back-btn">

← Kembali

</a>


</div>








{{-- ===============================
INFORMASI TASK
================================ --}}



<div class="glass-panel">


<h2>
📌 Informasi Task
</h2>



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


@php

$priority = [
    'high'=>'Tinggi',
    'medium'=>'Sedang',
    'low'=>'Rendah'
];

$key = strtolower($task->prioritas ?? 'low');

@endphp



<span class="priority {{ $key }}">

{{ $priority[$key] ?? 'Rendah' }}

</span>


</div>




<div class="info-box">

<label>
Deadline
</label>


<strong>

@if($task->deadline)

{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}

@else

-

@endif

</strong>


</div>






<div class="info-box">

<label>
PIC
</label>


<strong>

{{ $task->karyawan->nama_karyawan ?? '-' }}

</strong>


</div>






<div class="info-box">

<label>
Divisi
</label>


<strong>

{{ $task->divisi->nama_divisi ?? '-' }}

</strong>


</div>




<div class="info-box">

<label>
Status
</label>

<span class="
status

@if($task->status == 'selesai')

done

@elseif($task->status == 'sedang_dikerjakan')

progress

@elseif($task->status == 'dibatalkan')

cancel

@else

todo

@endif

">

@if($task->status == 'selesai')

Selesai

@elseif($task->status == 'sedang_dikerjakan')

Sedang Dikerjakan

@elseif($task->status == 'dibatalkan')

Dibatalkan

@else

Belum Dikerjakan

@endif


</span>


</div>





@if($task->deadline)

<div class="info-box">


<label>
Deadline Status
</label>

@php
    $deadlineStatus = $task->deadline_status;
@endphp


@if($deadlineStatus['color']=='danger')

<span class="deadline danger">
⚠ {{ $deadlineStatus['label'] }}
</span>


@elseif($deadlineStatus['color']=='warning')

<span class="deadline warning">
⚠ {{ $deadlineStatus['label'] }}
</span>


@else

<span class="deadline aman">
✓ {{ $deadlineStatus['label'] }}
</span>


@endif


</div>

@endif





</div>


</div>









{{-- ===============================
PROGRESS
================================ --}}


<div class="glass-panel">


<h2>
📊 Progress Pekerjaan
</h2>



<div class="progress-container">


    <div class="progress-header">


        <span>
            Progress Saat Ini
        </span>


        <strong>
            {{ number_format($task->progres_persen ?? 0,0) }}%
        </strong>


    </div>




    <div class="progress-track">


        <div 
        class="progress-value

        @if(($task->progres_persen ?? 0) >= 100)

            progress-green

        @elseif(($task->progres_persen ?? 0) > 0)

            progress-blue

        @else

            progress-yellow

        @endif

        "

        style="
        width:{{ min($task->progres_persen ?? 0,100) }}%
        ">

        </div>


    </div>




    <div class="progress-status">


        @if(($task->progres_persen ?? 0) >= 100)

            ✅ Task Selesai


        @elseif(($task->progres_persen ?? 0) > 0)

            🔄 Sedang Dikerjakan


        @else

            ⏳ Belum Dimulai


        @endif


    </div>



</div>




@if(
    $task->status != 'dibatalkan'
    &&
    $task->status != 'selesai'
)

<a href="{{ route('daily-tracker.show',$task->id) }}"
class="update-btn">

✏️ Update Progress

</a>

@endif

</div>










{{-- ===============================
DESKRIPSI
================================ --}}



<div class="glass-panel">


<h2>
📝 Deskripsi Pekerjaan
</h2>



<div class="description">


{{ $task->aktivitas ?? 'Tidak ada deskripsi pekerjaan.' }}


</div>


</div>









{{-- ===============================
TIMELINE
================================ --}}


<div class="glass-panel">


<h2>
⏳ Timeline Aktivitas
</h2>




@forelse($task->aktivitasTugas as $activity)


<div class="timeline-item">


    <div class="timeline-dot"></div>



    <div class="timeline-content">



        <div class="timeline-top">


            <strong>
                {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}
            </strong>


            <span class="activity-badge">

                @if($activity->progres >= 100)

                    Selesai

                @elseif($activity->progres > 0)

                    Berjalan

                @else

                    Belum Dimulai

                @endif

            </span>


        </div>





        <p class="activity-text">

            {{ $activity->aktivitas }}

        </p>





        <div class="mini-progress">


            <div class="mini-track">


                <div class="mini-value"

                style="
                width:{{ $activity->progres ?? 0 }}%
                ">

                </div>


            </div>


            <span>

                {{ $activity->progres ?? 0 }}%

            </span>


        </div>







        <div class="activity-meta">


            👤 {{ $activity->karyawan->nama_karyawan ?? '-' }}

            |

            📅
            {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y H:i') }}



        </div>






        @if($activity->catatan)


        <div class="activity-note">

            📝 {{ $activity->catatan }}

        </div>


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

*{
    box-sizing:border-box;
}



/* ===============================
HEADER
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

    font-size:13px;

    color:#64748b;

}




/* ===============================
BACK BUTTON
================================ */


.back-btn{

    background:#0f172a;

    color:white;

    padding:10px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.back-btn:hover{

    background:#334155;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    padding:25px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

    margin-bottom:22px;

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

    padding:16px;

    border-radius:16px;

    border:1px solid #e2e8f0;

    min-height:90px;

}



.info-box label{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:700;

    margin-bottom:8px;

}
.info-box{
    transition:.2s ease;
}


.info-box:hover{

    transform:translateY(-3px);

    box-shadow:
    0 8px 20px rgba(15,23,42,.08);

}


.info-box strong{

    font-size:14px;

    color:#1e293b;

}





/* ===============================
PRIORITY
================================ */

.priority{

    display:inline-flex;

    width:max-content;

    padding:6px 12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}


.priority.high{

    background:#fee2e2;

    color:#b91c1c;

}


.priority.medium{

    background:#fef3c7;

    color:#92400e;

}


.priority.low{

    background:#dcfce7;

    color:#166534;

}





/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    width:max-content;

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


.status.cancel{

    background:#fee2e2;

    color:#b91c1c;

}




/* ===============================
DEADLINE
================================ */


.deadline{

    display:inline-flex;

    width:max-content;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.deadline.danger{

    background:#fee2e2;

    color:#b91c1c;

}



.deadline.warning{

    background:#fef3c7;

    color:#92400e;

}



.deadline.aman{

    background:#dcfce7;

    color:#166534;

}







/* ===============================
PROGRESS
================================ */

.progress-container{

    background:#f8fafc;

    padding:20px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}



.progress-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:12px;

}



.progress-header span{

    font-size:12px;

    font-weight:700;

    color:#64748b;

}



.progress-header strong{

    font-size:24px;

    font-weight:900;

    color:#1e293b;

}




.progress-track{

    width:100%;

    height:16px;

    background:#e2e8f0;

    border-radius:30px;

    overflow:hidden;

}



.progress-value{

    height:100%;

    border-radius:30px;

    transition:.5s ease;

}



.progress-green{

    background:#16a34a;

}



.progress-blue{

    background:#2563eb;

}



.progress-yellow{

    background:#f59e0b;

}



.progress-status{

    margin-top:12px;

    font-size:12px;

    font-weight:700;

    color:#64748b;

}





/* ===============================
UPDATE BUTTON
================================ */


.update-btn{

    display:inline-flex;

    margin-top:20px;

    background:#0f172a;

    color:white;

    padding:11px 22px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.update-btn:hover{

    background:#334155;

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
TIMELINE
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

    flex-shrink:0;

}



.timeline-content strong{

    font-size:13px;

    color:#1e293b;

}



.timeline-content p{

    margin:8px 0;

    font-size:12px;

    color:#64748b;

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
TIMELINE UPDATE
================================ */


.timeline-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:10px;

}



.timeline-top strong{

    font-size:13px;

    color:#1e293b;

}




.activity-badge{

    padding:5px 12px;

    border-radius:999px;

    background:#dcfce7;

    color:#166534;

    font-size:11px;

    font-weight:700;

}





.activity-text{

    font-size:13px;

    color:#475569;

    line-height:1.6;

    margin-bottom:15px;

}




.mini-progress{

    display:flex;

    align-items:center;

    gap:12px;

}




.mini-track{

    flex:1;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.mini-value{

    height:100%;

    background:#2563eb;

    border-radius:20px;

}




.mini-progress span{

    font-size:12px;

    font-weight:800;

    color:#1e293b;

}





.activity-meta{

    margin-top:15px;

    font-size:11px;

    color:#64748b;

}




.activity-note{

    margin-top:12px;

    padding:12px;

    background:#f1f5f9;

    border-radius:12px;

    font-size:12px;

    color:#475569;

}


/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){

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

    padding:18px;

}


}



</style>


@endsection