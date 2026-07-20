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
{{ $task->nama_task }}
</h1>


<p>
📁 {{ $task->project->nama_project ?? '-' }}
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
{{$task->progress_persen}}%
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
name="progress"
min="0"
max="100"
value="{{$task->progress_persen}}"
>




<label>
Catatan
</label>


<textarea
name="catatan"
placeholder="Catatan tambahan"></textarea>





<button>
Simpan Update
</button>



</form>



</div>





<style>

.alert-error{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:15px;

margin-bottom:20px;

font-weight:600;

}
.tracker-card{

background:white;

padding:30px;

border-radius:25px;

box-shadow:0 15px 40px rgba(0,0,0,.08);

}



.header-task{

display:flex;

justify-content:space-between;

align-items:center;

background:linear-gradient(
135deg,
#166534,
#22c55e
);

padding:25px;

border-radius:20px;

color:white;

margin-bottom:25px;

}



.label{

font-size:11px;

letter-spacing:2px;

}



.header-task h1{

margin:8px 0;

font-size:28px;

}



.back{

background:white;

color:#166534;

padding:12px 20px;

border-radius:20px;

text-decoration:none;

font-weight:bold;

}




.info-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:20px;

margin-bottom:25px;

}



.info-grid div{

background:#f8fafc;

padding:20px;

border-radius:15px;

}



.info-grid label{

display:block;

font-size:12px;

color:#64748b;

margin-bottom:8px;

}



.info-grid strong{

color:#166534;

}





form label{

display:block;

font-weight:700;

margin-top:15px;

margin-bottom:8px;

}





textarea,
input{


width:100%;

padding:15px;

border-radius:15px;

border:1px solid #e2e8f0;

font-family:inherit;

}





textarea{

height:120px;

resize:none;

}





button{


margin-top:20px;

background:#166534;

color:white;

border:none;

padding:14px 30px;

border-radius:15px;

font-weight:bold;

cursor:pointer;


}



button:hover{

background:#22c55e;

}





@media(max-width:900px){

.info-grid{

grid-template-columns:1fr;

}

.header-task{

flex-direction:column;

align-items:flex-start;

gap:20px;

}

}


</style>


@endsection