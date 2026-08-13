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



<a href="{{route('admin.tasks.index')}}" class="btn-back">

← Kembali 

</a>


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

elseif($task->status=='sedang_dikerjakan'){

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


.page-header-card{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:30px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

}



.page-label{

font-size:11px;

letter-spacing:2px;

font-weight:800;

color:#94a3b8;

}



.page-header-card h1{

font-size:30px;

margin:10px 0;

color:#172033;

}



.page-header-card p{

margin:0;

color:#64748b;

font-size:14px;

}





.btn-back{

background:#f8fafc;

border:1px solid #e2e8f0;

padding:11px 20px;

border-radius:14px;

text-decoration:none;

font-size:13px;

font-weight:700;

color:#475569;

}





.detail-grid{

display:grid;

grid-template-columns:1.5fr 1fr;

gap:20px;

margin-bottom:20px;

}







.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:28px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

}





.panel-title{

font-size:18px;

font-weight:800;

color:#172033;

margin-bottom:22px;

}








.info-item{

display:flex;

justify-content:space-between;

padding:15px;

background:#f8fafc;

border-radius:14px;

margin-bottom:12px;

}



.info-item span{

font-size:13px;

color:#64748b;

}



.info-item strong{

font-size:13px;

color:#172033;

}








.status-box{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.status-badge{

padding:8px 16px;

border-radius:999px;

font-size:12px;

font-weight:700;

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

background:#e0f2fe;

color:#0369a1;

}







.progress-header{

display:flex;

justify-content:space-between;

margin-bottom:10px;

font-size:13px;

color:#475569;

}



.progress-header strong{

color:#166534;

}





.progress-track{

height:12px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-bar{

height:100%;

background:#16a34a;

border-radius:20px;

}





.progress-info{

margin-top:15px;

font-size:13px;

color:#64748b;

}





.description-box{

background:#f8fafc;

padding:18px;

border-radius:16px;

color:#475569;

font-size:14px;

line-height:1.7;

}



.activity-card{

margin-bottom:20px;

}







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