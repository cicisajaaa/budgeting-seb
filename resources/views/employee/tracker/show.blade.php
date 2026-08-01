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


<a href="{{route('employee.project.index')}}" class="back">
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
min="0"
max="100"
value="{{$task->progres_persen ?? 0}}"
required
>






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



</div>






<style>

/* ===============================
CONTAINER
================================ */

.tracker-card{

    width:100%;

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



/* ===============================
HEADER
================================ */


.header-task{

    background:white;

    border:1px solid #e2e8f0;

    padding:32px;

    border-radius:24px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

}





.label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}





.header-task h1{

    margin:10px 0;

    font-size:30px;

    color:#172033;

    font-weight:800;

}





.header-task p{

    color:#64748b;

    margin:0;

    font-size:14px;

}





.back{

    background:#f1f5f9;

    color:#172033;

    padding:12px 22px;

    border-radius:999px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.back:hover{

    background:#e2e8f0;

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

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:20px;

    border-radius:18px;

}





.info-grid label{

    display:block;

    font-size:12px;

    color:#64748b;

    font-weight:700;

    margin-bottom:10px;

}





.info-grid strong{

    color:#172033;

    font-size:16px;

}






/* ===============================
DIVIDER
================================ */


.tracker-card hr{

    border:none;

    height:1px;

    background:#e2e8f0;

    margin:30px 0;

}





/* ===============================
FORM CARD
================================ */


form{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:25px;

    border-radius:22px;

}





form label{

    display:block;

    margin-top:18px;

    margin-bottom:8px;

    font-size:12px;

    font-weight:800;

    color:#334155;

}





textarea,
input{


    width:100%;


    padding:14px 16px;


    border-radius:14px;


    border:1px solid #dbe3ee;


    background:white;


    font-size:14px;


    transition:.2s;


}





textarea:focus,
input:focus{


    outline:none;


    border-color:#2563eb;


    box-shadow:

    0 0 0 3px rgba(37,99,235,.12);


}





textarea{

    height:120px;

    resize:none;

}





input[type="number"]{

    height:48px;

}





/* ===============================
BUTTON
================================ */
.submit-update-btn{

    margin-top:25px;

    width:200px;

    height:48px;

    border:none;

    border-radius:14px;

    background:#2563eb;

    color:white;

    font-weight:800;

    cursor:pointer;

}








/* ===============================
STATUS
================================ */


.status{

    display:inline-block;

    padding:7px 14px;

    border-radius:20px;

    font-size:12px;

    font-weight:800;

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

    color:#991b1b;

    border:1px solid #fecaca;

    padding:15px;

    border-radius:15px;

    margin-bottom:20px;

    font-weight:700;

}





/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.info-grid{

    grid-template-columns:1fr;

}



.header-task{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



}



@media(max-width:600px){


.tracker-card{

    padding:18px;

}


button{

    width:100%;

}


}



</style>


@endsection