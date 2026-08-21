@extends('layouts.dashboard')

@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
TASK DETAIL
</div>


<h1>
{{$task->nama_tugas}}
</h1>


<p>
Detail monitoring pekerjaan, progress, dan informasi pelaksanaan task.
</p>


</div>



<div style="display:flex;gap:10px;">

<a href="{{route('admin.tasks.edit',$task->id)}}" class="btn-edit">

✏️ Edit

</a>


<a href="{{route('admin.tasks.index')}}" class="btn-back">

← Kembali

</a>

</div>

</div>









<div class="detail-grid">





{{-- INFORMASI TASK --}}


<div class="glass-panel">


<div class="panel-title">

📝 Informasi Task

</div>



<div class="info-list">



<div class="info-item">

<span>
Project
</span>

<strong>

{{$task->proyek->nama_proyek ?? '-'}}

</strong>

</div>






<div class="info-item">

<span>
PIC
</span>

<strong>

{{$task->karyawan->nama_karyawan ?? '-'}}

</strong>

</div>






<div class="info-item">

<span>
Divisi
</span>

<strong>

{{$task->divisi->nama_divisi ?? '-'}}

</strong>

</div>








<div class="info-item">

<span>
Prioritas
</span>

<strong>

{{$task->prioritas ?? '-'}}

</strong>

</div>







<div class="info-item">

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


</div>








{{-- STATUS --}}


<div class="glass-panel">


<div class="panel-title">

📊 Monitoring Progress

</div>





<div class="status-box">


<span>

Status

</span>


@php

$statusClass='pending';


if($task->status=='selesai'){

    $statusClass='success';

}

elseif($task->status=='berjalan'){

    $statusClass='warning';

}

@endphp



<span class="status-badge {{$statusClass}}">

{{$task->status}}

</span>



</div>








<div class="progress-header">


<span>

Progress Pekerjaan

</span>


<strong>

{{$task->progres_persen ?? 0}}%

</strong>


</div>




<div class="progress-track">


<div class="progress-bar"

style="width:{{$task->progres_persen ?? 0}}%">

</div>


</div>






<div class="progress-info">


@if(($task->progres_persen ?? 0) >=100)

✓ Task selesai


@elseif(($task->progres_persen ?? 0)>0)

⏳ Sedang berjalan


@else

Belum dimulai


@endif


</div>



</div>





</div>






{{-- AKTIVITAS PEKERJAAN --}}

<div class="glass-panel activity-card">


<div class="panel-title">

📌 Aktivitas Pekerjaan

</div>



<div class="description-box">

{{$task->aktivitas ?? 'Tidak ada aktivitas'}}

</div>


</div>






{{-- RIWAYAT UPDATE AKTIVITAS --}}


<div class="glass-panel activity-card">


<div class="panel-title">

📌 Riwayat Update Aktivitas

</div>




@forelse($task->aktivitasTugas as $aktivitas)



<div class="description-box" style="margin-bottom:12px">



<strong>

@if($aktivitas->tanggal)

{{\Carbon\Carbon::parse($aktivitas->tanggal)->format('d M Y')}}

@else

-

@endif


</strong>



<p style="margin-top:8px">

{{$aktivitas->aktivitas}}

</p>




<span>

Progress:
{{$aktivitas->progres}}%

</span>





@if($aktivitas->catatan)


<p>

Catatan:
{{$aktivitas->catatan}}

</p>


@endif




</div>



@empty


<div class="description-box">

Belum ada update aktivitas.

</div>


@endforelse



</div>




{{-- CATATAN --}}


<div class="glass-panel activity-card">


<div class="panel-title">

📝 Catatan

</div>



<div class="description-box">

{{$task->catatan ?? 'Tidak ada catatan'}}


</div>


</div>






<style>

/* ===============================
HEADER
================================ */

.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px 28px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}



.page-label{

    font-size:9px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    font-size:22px;

    margin:7px 0;

    color:#172033;

    font-weight:800;

}



.page-header-card p{

    margin:0;

    font-size:11px;

    color:#64748b;

}







/* ===============================
BUTTON
================================ */

.btn-back,
.btn-edit{

    padding:8px 16px;

    border-radius:11px;

    text-decoration:none;

    font-size:11px;

    font-weight:700;

    display:inline-flex;

    align-items:center;

    gap:5px;

}



.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    color:#334155;

}



.btn-edit{

    background:#dbeafe;

    border:1px solid #bfdbfe;

    color:#2563eb;

}



.btn-edit:hover{

    background:#2563eb;

    color:white;

}



.btn-back:hover{

    background:#1e293b;

    color:white;

}








/* ===============================
GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:1.4fr 1fr;

    gap:18px;

    margin-bottom:18px;

}









/* ===============================
CARD
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:20px;

    padding:20px;

    box-shadow:

    0 6px 20px rgba(15,23,42,.04);

    margin-bottom:18px;

}





.panel-title{

    font-size:15px;

    font-weight:800;

    color:#172033;

    padding-bottom:14px;

    margin-bottom:15px;

    border-bottom:1px solid #f1f5f9;

}









/* ===============================
INFO ITEM
================================ */


.info-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:11px 12px;

    background:#f8fafc;

    border-radius:12px;

    margin-bottom:9px;

}



.info-item span{

    color:#64748b;

    font-size:11px;

}



.info-item strong{

    color:#172033;

    font-size:11px;

}









/* ===============================
STATUS
================================ */


.status-box{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;

}



.status-box span:first-child{

    font-size:11px;

    color:#64748b;

}



.status-badge{

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:800;

}





.status-badge.success{

    background:#dcfce7;

    color:#166534;

}





.status-badge.warning{

    background:#fef3c7;

    color:#92400e;

}





.status-badge.pending{

    background:#dbeafe;

    color:#1d4ed8;

}









/* ===============================
PROGRESS
================================ */


.progress-header{

    display:flex;

    justify-content:space-between;

    margin-bottom:8px;

    font-size:11px;

    color:#64748b;

}



.progress-header strong{

    color:#172033;

}



.progress-track{

    width:100%;

    height:7px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-bar{

    height:100%;

    background:#334155;

    border-radius:20px;

}



.progress-info{

    margin-top:10px;

    font-size:11px;

    color:#64748b;

}








/* ===============================
DESCRIPTION
================================ */


.description-box{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:14px;

    border-radius:14px;

    color:#475569;

    font-size:12px;

    line-height:1.6;

}



.description-box p{

    font-size:12px;

}








/* ===============================
ACTIVITY
================================ */


.activity-card{

    margin-bottom:18px;

}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.detail-grid{

    grid-template-columns:1fr;

}



.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}

</style>


@endsection