@extends('layouts.dashboard')

@section('content')


<div class="welcome-card">

<div>

<div class="welcome-label">
EMPLOYEE DAILY TRACKER
</div>


<h1>
Daily Tracker
</h1>


<p>
Update progress pekerjaan dan aktivitas harian kamu
</p>


</div>


<div class="date-box">

{{date('d M Y')}}

</div>

</div>





@forelse($tasks as $task)


<div class="glass-panel task-card">


<div class="task-header">


<div>

<h2>
{{$task->nama_task}}
</h2>


<p>
Project :
{{$task->project->nama_project ?? '-'}}
</p>


</div>



<span class="status-badge">

{{strtoupper($task->status)}}

</span>



</div>




<div class="task-info">


<div>

<label>
Prioritas
</label>

<strong>
{{$task->prioritas}}
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
Progress
</label>


<strong>
{{$task->progress_persen}}%

</strong>


</div>



</div>





<div class="progress-wrapper">


<div class="progress-text">

Progress Pekerjaan

<span>
{{$task->progress_persen}}%
</span>

</div>



<div class="progress-bar">


<div class="progress-fill"
style="
width:{{$task->progress_persen}}%
">

</div>


</div>


</div>







<div class="update-box">


<h3>
Update Aktivitas
</h3>


<form method="POST"
action="{{route('daily-tracker.store')}}">


@csrf


<input type="hidden"
name="task_id"
value="{{$task->id}}">



<label>
Aktivitas Hari Ini
</label>


<textarea
name="aktivitas"
placeholder="Tuliskan aktivitas hari ini..."
required></textarea>





<div class="form-grid">


<div>

<label>
Progress (%)
</label>


<input
type="number"
name="progress"
min="0"
max="100"
value="{{$task->progress_persen}}">


</div>





<div>

<label>
Budget Activity
</label>


<input
type="number"
name="budget_activity"
value="0">


</div>



</div>





<label>
Catatan
</label>


<textarea
name="catatan"
placeholder="Catatan tambahan..."></textarea>





<button>

Simpan Update

</button>



</form>


</div>









<div class="history">


<h3>
Riwayat Aktivitas
</h3>

@forelse($task->aktivitasTugas ?? [] as $activity)



<div class="history-item">


<strong>

{{$activity->tanggal}}

</strong>


<p>

{{$activity->aktivitas}}

</p>


<span>

Progress {{$activity->progress}}%

</span>


</div>



@empty


<p>
Belum ada aktivitas.
</p>


@endforelse


</div>



</div>





@empty


<div class="glass-panel">

Belum ada task.

</div>


@endforelse







<style>


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:30px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.welcome-label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

}




.welcome-card h1{

font-size:28px;

margin:10px 0;

}




.date-box{

background:white;

color:#166534;

padding:12px 20px;

border-radius:30px;

font-weight:700;

}





.glass-panel{

background:
rgba(255,255,255,.75);

backdrop-filter:blur(15px);

border-radius:24px;

padding:25px;

margin-bottom:20px;

box-shadow:
0 10px 30px rgba(0,0,0,.08);

}





.task-header{

display:flex;

justify-content:space-between;

align-items:center;

}



.task-header h2{

font-size:22px;

color:#166534;

}



.task-header p{

color:#64748b;

}




.status-badge{

background:#dcfce7;

color:#166534;

padding:8px 15px;

border-radius:20px;

font-size:12px;

font-weight:700;

}





.task-info{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

margin-top:20px;

}



.task-info div{

background:#f8fafc;

padding:15px;

border-radius:15px;

}



.task-info label{

display:block;

font-size:12px;

color:#64748b;

}



.task-info strong{

color:#166534;

}





.progress-text{

display:flex;

justify-content:space-between;

margin:15px 0 8px;

font-weight:600;

}




.progress-bar{

height:12px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-fill{

height:100%;

background:
linear-gradient(
90deg,
#166534,
#22c55e
);

}





.update-box{

margin-top:25px;

background:#f8fafc;

padding:20px;

border-radius:20px;

}





.update-box textarea{

width:100%;

height:90px;

border-radius:15px;

border:1px solid #e2e8f0;

padding:12px;

margin:8px 0 15px;

}





.form-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

}





input{

width:100%;

padding:12px;

border-radius:12px;

border:1px solid #e2e8f0;

}




button{

margin-top:20px;

background:#166534;

color:white;

border:none;

padding:12px 25px;

border-radius:15px;

font-weight:700;

}




.history{

margin-top:25px;

}



.history-item{

padding:15px;

border-bottom:1px solid #e2e8f0;

}



.history-item span{

color:#166534;

font-weight:700;

}



</style>


@endsection