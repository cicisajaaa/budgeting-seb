@extends('layouts.dashboard')


@section('content')

@if(session('error'))

<div class="alert-error">
    {{session('error')}}
</div>

@endif



<div class="tracker-card">



<div class="header-task">

<div>

<span class="label">
UPDATE PROGRESS
</span>


<h1>
{{ $task->nama_tugas }}
</h1>


<p>
📁 {{ $task->proyek->nama_proyek ?? '-' }}
</p>


</div>


<a href="{{route('daily-tracker.index')}}" class="back">
← Kembali
</a>


</div>






<div class="info-grid">



<div>

<label>
Status
</label>


<strong>
{{strtoupper($task->status)}}
</strong>

</div>





<div>

<label>
Deadline
</label>


<strong>
{{$task->deadline ?? '-'}}
</strong>

</div>





<div>

<label>
Progress Saat Ini
</label>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>

</div>



</div>







<hr>





<form action="{{route('daily-tracker.store')}}" method="POST">

@csrf



<input type="hidden"
name="task_id"
value="{{$task->id}}">





<label>
Aktivitas Hari Ini
</label>


<textarea
name="aktivitas"
placeholder="Tuliskan aktivitas yang dikerjakan..."
required></textarea>






<label>
Progress (%)
</label>


<input 
type="number"
name="progres"
min="{{$task->progres_persen ?? 0}}"
max="100"
value="{{$task->progres_persen ?? 0}}"
required
>




<label>
Anggaran Aktivitas
</label>


<input 
type="number"
name="anggaran_aktivitas"
min="0"
placeholder="Masukkan penggunaan anggaran">

<label>
Catatan
</label>


<textarea
name="catatan"
placeholder="Catatan tambahan"></textarea>





<button type="submit" class="submit-update-btn">
Simpan Update
</button>




</form>


<div class="employee-panel">


<div class="panel-header">
📝 Riwayat Aktivitas
</div>



@forelse($activities as $activity)


<div class="activity-card">


<div class="activity-content">


<strong>
{{$activity->aktivitas}}
</strong>


<p>
Progress:
{{$activity->progres}}%
</p>


<small>
{{\Carbon\Carbon::parse($activity->tanggal)->format('d M Y')}}
</small>


@if($activity->catatan)

<p>
Catatan:
{{$activity->catatan}}
</p>

@endif


</div>


</div>



@empty


<div class="empty-data">
Belum ada aktivitas
</div>


@endforelse


</div>
</div>





<style>

/* ===============================
GLOBAL
================================ */

.tracker-card{
    width:100%;
}



/* ===============================
HEADER
================================ */


.header-task{

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



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.header-task h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.header-task p{

    margin:0;

    color:#64748b;

    font-size:13px;

}





/* BUTTON BACK */


.back{

    background:#334155;

    color:white;

    padding:10px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.back:hover{

    background:#1e293b;

}





/* ===============================
INFO CARD
================================ */


.info-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;

}



.info-grid div{

    background:white;

    padding:20px;

    border-radius:18px;

    border:1px solid #e2e8f0;

    box-shadow:
    0 5px 20px rgba(15,23,42,.04);

}



.info-grid label{

    display:block;

    font-size:11px;

    color:#64748b;

    font-weight:700;

    margin-bottom:8px;

}



.info-grid strong{

    font-size:16px;

    color:#1e293b;

}







/* ===============================
FORM PANEL
================================ */


form{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}





form label{

    display:block;

    margin:18px 0 8px;

    font-size:12px;

    font-weight:700;

    color:#334155;

}



textarea,
input{


    width:100%;

    padding:12px 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:13px;

}



textarea{

    height:120px;

    resize:none;

}



textarea:focus,
input:focus{

    outline:none;

    background:white;

    border-color:#334155;

}





/* ===============================
SUBMIT
================================ */


.submit-update-btn{

    margin-top:25px;

    background:#334155;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.submit-update-btn:hover{

    background:#1e293b;

}







/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.status.progress{

    background:#dbeafe;

    color:#1d4ed8;

}



.status.done{

    background:#dcfce7;

    color:#166534;

}



.status.todo{

    background:#f1f5f9;

    color:#475569;

}








/* ===============================
ALERT
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:15px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:700;

}








/* ===============================
ACTIVITY PANEL
================================ */


.employee-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:25px;

    margin-top:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.panel-header{

    font-size:17px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:20px;

}







/* ===============================
ACTIVITY CARD
================================ */


.activity-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:16px;

    margin-bottom:12px;

}



.activity-content strong{

    color:#1e293b;

    font-size:14px;

}



.activity-content p{

    margin:8px 0;

    color:#64748b;

    font-size:13px;

}



.activity-content small{

    color:#94a3b8;

    font-size:12px;

}



.activity-content p:last-child{

    background:white;

    padding:10px;

    border-radius:12px;

    border:1px solid #e2e8f0;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.header-task{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.info-grid{

    grid-template-columns:1fr;

}



}



@media(max-width:600px){


.tracker-card{

    padding:0;

}



.submit-update-btn{

    width:100%;

}


}

</style>


@endsection