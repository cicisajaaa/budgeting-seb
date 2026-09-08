@extends('layouts.dashboard')


@section('content')





<div class="tracker-card">



<div class="header-task">


<div>


<span class="label">
UPDATE PROGRESS
</span>



<h1>
{{$task->nama_tugas}}
</h1>



<p>
📁 {{$task->proyek?->nama_proyek ?? '-'}}
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

@if($task->status=='belum_dikerjakan')

Belum Dikerjakan

@elseif($task->status=='sedang_dikerjakan')

Sedang Dikerjakan

@elseif($task->status=='selesai')

Selesai

@elseif($task->status=='dibatalkan')

Dibatalkan

@else

{{ucfirst($task->status)}}

@endif

</strong>

</div>






<div>

<label>
Deadline
</label>


<strong>

@if($task->deadline)

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

@else

-

@endif

</strong>

</div>





<div>

<label>
Progress Saat Ini
</label>

<div class="progress-wrapper">

    <div class="progress-header">

        <strong>
            {{$task->progres_persen ?? 0}}%
        </strong>

        <span>
            Progress
        </span>

    </div>


    <div class="progress-bar">

        <div 
        class="progress-fill
        @if(($task->progres_persen ?? 0) >= 100)
            selesai
        @elseif(($task->progres_persen ?? 0) > 0)
            berjalan
        @else
            kosong
        @endif
        "
        style="
        width: {{$task->progres_persen ?? 0}}%;
        ">
        </div>

    </div>


</div>


</div>



</div>







<hr>








<form action="{{route('daily-tracker.store',$task->id)}}" method="POST">


@csrf



<label>
Aktivitas Hari Ini
</label>



<textarea
name="aktivitas"
placeholder="Tuliskan aktivitas yang dikerjakan..."
@if(in_array($task->status,['selesai','dibatalkan']))
readonly
@endif
required></textarea>







<label>
Progress (%)
</label>



<input 
type="number"
name="progres"

min="{{$task->progres_persen ?? 0}}"

max="100"

step="1"

value="{{$task->progres_persen ?? 0}}"

@if($task->status=='selesai' || $task->status=='dibatalkan')
disabled
@endif

required
>




<label>
Anggaran Aktivitas
</label>


<input 
type="number"

name="anggaran_aktivitas"

min="0"

@if($task->status=='selesai' || $task->status=='dibatalkan')
disabled
@endif

placeholder="Masukkan penggunaan anggaran">







<label>
Catatan
</label>



<textarea

name="catatan"

placeholder="Catatan tambahan"

@if($task->status=='selesai' || $task->status=='dibatalkan')
disabled
@endif

></textarea>



@if($task->status == 'selesai')

<div class="alert-success">

✅ Task sudah selesai. Update progress tidak tersedia lagi.

</div>

@elseif($task->status == 'dibatalkan')

<div class="alert-error">

❌ Task dibatalkan. Update progress tidak tersedia.

</div>

@else

<button type="submit" 
class="submit-update-btn">

Simpan Update

</button>

@endif


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
Progress :
{{$activity->progres ?? 0}}%
</p>



<p>
Anggaran :
Rp {{number_format($activity->anggaran_aktivitas ?? 0,0,',','.')}}
</p>




<div style="
height:8px;
background:#e2e8f0;
border-radius:20px;
overflow:hidden;
">


<div style="
height:100%;
width:{{$activity->progres ?? 0}}%;
background:
@if($activity->progres >= 100)
#16a34a
@elseif($activity->progres > 0)
#f59e0b
@else
#94a3b8
@endif
;
border-radius:20px;
">
</div>


</div>





<small>

Oleh :
{{$activity->karyawan->nama_karyawan ?? '-'}}

<br>

{{\Carbon\Carbon::parse($activity->tanggal)
->format('d M Y')}}

</small>






@if($activity->catatan)

<p>

Catatan :
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





/* ===============================
BACK BUTTON
================================ */


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
INFO GRID
================================ */


.info-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;

}


.info-grid > div{

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








hr{

    border:none;

    border-top:1px solid #e2e8f0;

    margin:25px 0;

}



/* ===============================
PROGRESS CARD
================================ */

.progress-wrapper{

    margin-top:15px;

}


.progress-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:12px;

}


.progress-header strong{

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}


.progress-header span{

    font-size:12px;

    color:#64748b;

    font-weight:700;

}




.progress-bar{

    width:100%;

    height:10px;

    background:#e2e8f0;

    border-radius:50px;

    overflow:hidden;

}



.progress-fill{

    height:100%;

    border-radius:50px;

    transition:.5s ease;

}



.progress-fill.selesai{

    background:#22c55e;

}


.progress-fill.berjalan{

    background:#f59e0b;

}


.progress-fill.kosong{

    background:#94a3b8;

}



/* ===============================
FORM
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


input:disabled,
textarea:disabled{

    background:#e2e8f0;

    cursor:not-allowed;

    opacity:.7;

}




/* ===============================
BUTTON
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
ALERT
================================ */


.alert-success{

    background:#dcfce7;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:15px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:700;

}




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







.empty-data{

    text-align:center;

    padding:30px;

    color:#94a3b8;

    background:#f8fafc;

    border-radius:15px;

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


.submit-update-btn{

    width:100%;

}


}


</style>


@endsection
