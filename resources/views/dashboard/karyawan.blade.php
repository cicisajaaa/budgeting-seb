@extends('layouts.dashboard')

@section('content')

<div class="employee-dashboard">


{{-- ================= WELCOME ================= --}}

<div class="employee-welcome">


<div>

<span class="welcome-label">
DASHBOARD KARYAWAN
</span>


<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>


<p>
Monitoring pekerjaan, progress project dan aktivitas harian.
</p>



<div class="welcome-tags">

<span>
✓ Project
</span>

<span>
✓ Task
</span>

<span>
✓ Daily Tracker
</span>

</div>


</div>




<div class="today-card">

{{now()->format('d M Y')}}

</div>


</div>



{{-- ================= STATISTIC ================= --}}

<div class="employee-stats">


    {{-- TOTAL TASK --}}
    <div class="stat-card">

        <div class="stat-icon green">
            📁
        </div>

        <div>

            <label>
                Total Task
            </label>

            <h2>
                {{$employeeTasks->count()}}
            </h2>

            <small>
                Task diberikan
            </small>

        </div>

    </div>




    {{-- TASK SELESAI --}}
    <div class="stat-card">

        <div class="stat-icon blue">
            ✔
        </div>


        <div>

            <label>
                Task Selesai
            </label>


            <h2>

                {{$employeeTasks
                ->whereIn('status',['selesai','done'])
                ->count()}}

            </h2>


            <small>
                Selesai dikerjakan
            </small>

        </div>

    </div>





    {{-- TASK PROGRESS --}}
    <div class="stat-card">


        <div class="stat-icon orange">

            ⚡

        </div>


        <div>


            <label>
                Sedang Progress
            </label>


            <h2>

                {{$employeeTasks
                ->whereIn('status',['berjalan','progress'])
                ->count()}}

            </h2>


            <small>
                Sedang berjalan
            </small>


        </div>


    </div>





    {{-- AKTIVITAS --}}
    <div class="stat-card">


        <div class="stat-icon purple">

            📝

        </div>



        <div>


            <label>
                Aktivitas
            </label>



            <h2>

            {{$employeeTasks->sum(function($task){

                return $task->aktivitasTugas->count();

            })}}

            </h2>



            <small>
                Update pekerjaan
            </small>


        </div>


    </div>






    {{-- PENGAJUAN DANA --}}
    <div class="stat-card">


        <div class="stat-icon purple">

            💰

        </div>



        <div>


            <label>
                Pengajuan Dana
            </label>



            <h2>

                {{$totalExpenseRequest ?? 0}}

            </h2>



            <small>
                Total pengajuan
            </small>


        </div>


    </div>



</div>


{{-- ================= MAIN GRID ================= --}}


<div class="employee-grid">





{{-- ================= LEFT ================= --}}


<div class="employee-left">






{{-- PROJECT PROGRESS --}}


<div class="employee-panel">


<div class="panel-header">

📊 Progress Project

</div>




@forelse($projectProgress as $project=>$progress)


<div class="project-item">


<div class="project-top">


<strong>

{{$project}}

</strong>


<span>

{{$progress}}%

</span>


</div>



<div class="progress-bar">


<div class="progress-value"

style="width:{{$progress}}%">

</div>


</div>


</div>



@empty


<div class="empty-data">

Belum ada project

</div>


@endforelse



</div>








{{-- DETAIL TASK --}}


<div class="employee-panel">


<div class="panel-header">

📋 Detail Task Saya

</div>





@forelse($employeeTasks as $task)



<div class="task-row">


<div>


<strong>

{{$task->nama_tugas}}

</strong>



<p>

{{$task->proyek->nama_proyek ?? '-'}}

</p>


</div>





<span>

{{$task->status}}

</span>



</div>



@empty


<div class="empty-data">

Belum ada task

</div>


@endforelse



</div>







{{-- DEADLINE --}}


<div class="employee-panel">


<div class="panel-header">

⏰ Deadline Terdekat

</div>





@forelse($deadlineTasks as $task)



<div class="deadline-card">


<div>


<strong>

{{$task->nama_tugas}}

</strong>



<p>

{{$task->proyek->nama_proyek ?? '-'}}

</p>


</div>




<div class="deadline-date">

{{\Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

</div>



</div>




@empty


<div class="empty-data">

Tidak ada deadline

</div>


@endforelse



</div>




</div>
{{-- ================= RIGHT CONTENT ================= --}}


<div class="employee-right">





{{-- CHART --}}


<div class="employee-panel">


<div class="panel-header">

📈 Status Task

</div>



<div class="chart-box">

<canvas id="taskChart"></canvas>

</div>


</div>







{{-- PROJECT SAYA --}}


<div class="employee-panel">


<div class="panel-header">

📁 Project Saya

</div>





@forelse($employeeTasks->groupBy('proyek.nama_proyek') as $project=>$tasks)



<div class="info-row">


<span>
Project
</span>


<b>

{{$project}}

</b>


</div>




<div class="info-row">


<span>
Jumlah Task
</span>


<b>

{{$tasks->count()}}

</b>


</div>





@empty


<div class="empty-data">

Belum ada project

</div>


@endforelse




</div>







{{-- INFORMASI AKUN --}}


<div class="employee-panel">


<div class="panel-header">

👤 Informasi Akun

</div>





<div class="info-row">


<span>
Nama
</span>


<b>

{{auth()->user()->name}}

</b>


</div>





<div class="info-row">


<span>
Email
</span>


<b>

{{auth()->user()->email}}

</b>


</div>





<div class="info-row">


<span>
Divisi
</span>


<b>

{{auth()->user()->karyawan->divisi->nama_divisi ?? '-'}}

</b>


</div>





<div class="info-row">


<span>
Status
</span>


<b class="active-status">

Aktif

</b>


</div>




</div>





</div>


{{-- END RIGHT --}}



</div>


{{-- END GRID --}}






<div class="employee-panel">


<div class="panel-header">

💰 Riwayat Pengajuan Dana

</div>



@forelse($recentExpenseRequest ?? [] as $expense)



<div class="task-row">


<div>

<strong>

{{$expense->judul}}

</strong>


<p>

{{$expense->proyek->nama_proyek ?? '-'}}

</p>


</div>



@if($expense->status == 'pending')

<span style="background:#fef3c7;color:#92400e">

Menunggu

</span>


@elseif($expense->status == 'approved')

<span style="background:#dcfce7;color:#166534">

Disetujui

</span>


@else

<span style="background:#fee2e2;color:#991b1b">

Ditolak

</span>


@endif



</div>



@empty


<div class="empty-data">

Belum ada pengajuan dana

</div>


@endforelse


</div>


{{-- ================= AKTIVITAS TERAKHIR ================= --}}


<div class="employee-panel">


<div class="panel-header">

📝 Aktivitas Terakhir

</div>





@forelse($recentActivities as $activity)



<div class="activity-card">



<div class="activity-dot"></div>





<div class="activity-content">


<strong>

{{$activity['task']}}

</strong>





<p>

{{$activity['aktivitas']}}

</p>





<small>

{{\Carbon\Carbon::parse(
$activity['tanggal']
)->diffForHumans()}}

</small>



</div>





<div class="activity-percent">


{{$activity['progress']}}%

</div>




</div>





@empty



<div class="empty-data">

Belum ada aktivitas

</div>



@endforelse



</div>
{{-- ================= CHART SCRIPT ================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>


const canvas = document.getElementById('taskChart');


if(canvas){


new Chart(canvas,{


type:'doughnut',



data:{


labels:[

'Selesai',

'Berjalan',

'Belum Dikerjakan'

],



datasets:[{


data:[


{{$employeeTasks
->whereIn('status',['selesai','done'])
->count()}},



{{$employeeTasks
->whereIn('status',['berjalan','progress'])
->count()}},



{{$employeeTasks
->whereIn('status',['belum_dikerjakan','todo'])
->count()}}



],



borderWidth:0,



backgroundColor:[

'#22c55e',

'#3b82f6',

'#f59e0b'

]



}]


},



options:{


responsive:true,


maintainAspectRatio:false,


cutout:'70%',



plugins:{


legend:{


position:'bottom'


}


}



}



});


}



</script>

<style>

/* ===============================
GLOBAL
================================ */

.employee-dashboard{
    width:100%;
}


/* ===============================
WELCOME
================================ */

.employee-welcome{

    background:#ffffff;

    border:1px solid #e2e8f0;

    padding:32px;

    border-radius:24px;

    color:#172033;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}


.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    color:#64748b;

    font-weight:800;

}


.employee-welcome h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

}


.employee-welcome p{

    color:#64748b;

    margin:0;

}


.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:18px;

}


.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:8px 15px;

    border-radius:20px;

    font-size:12px;

    font-weight:600;

}


.today-card{

    background:#ecfdf5;

    color:#15803d;

    padding:12px 22px;

    border-radius:30px;

    font-weight:800;

}




/* ===============================
STATISTICS
================================ */


.employee-stats{

    display:grid;

    grid-template-columns:repeat(5,1fr);

    gap:16px;

    margin-bottom:22px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:20px;

    display:flex;

    align-items:center;

    gap:14px;

    transition:.25s;

}



.stat-card:hover{

    transform:translateY(-3px);

    box-shadow:
    0 10px 25px rgba(15,23,42,.08);

}



.stat-icon{

    width:46px;

    height:46px;

    border-radius:14px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:20px;

}


.stat-icon.green{
    background:#dcfce7;
}


.stat-icon.blue{
    background:#dbeafe;
}


.stat-icon.orange{
    background:#fef3c7;
}


.stat-icon.purple{
    background:#ede9fe;
}



.stat-card label{

    font-size:12px;

    color:#64748b;

}



.stat-card h2{

    margin:5px 0;

    font-size:24px;

    color:#172033;

}



.stat-card small{

    color:#94a3b8;

}





/* ===============================
GRID
================================ */


.employee-grid{

    display:grid;

    grid-template-columns:
    minmax(0,2fr)
    minmax(320px,1fr);

    gap:20px;

}





/* ===============================
PANEL
================================ */


.employee-panel{

    background:white;

    border:1px solid #e2e8f0;

    padding:22px;

    border-radius:22px;

    margin-bottom:20px;

}



.panel-header{

    font-size:17px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

}





/* ===============================
PROJECT
================================ */


.project-item{

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

    margin-bottom:12px;

}



.project-top{

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;

}



.project-top span{

    color:#15803d;

    font-weight:800;

}



.progress-bar{

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-value{

    height:100%;

    background:

    linear-gradient(
    90deg,
    #16a34a,
    #22c55e
    );

}





/* ===============================
TASK
================================ */


.task-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:15px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:16px;

    margin-bottom:12px;

}



.task-row strong{

    font-size:14px;

    color:#172033;

}



.task-row p{

    margin:5px 0 0;

    font-size:12px;

    color:#64748b;

}



.task-row span{

    background:#ecfdf5;

    color:#15803d;

    padding:6px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}





/* ===============================
CHART
================================ */


.chart-box{

    height:220px;

    display:flex;

    justify-content:center;

    align-items:center;

}


#taskChart{

    max-width:190px!important;

    max-height:190px!important;

}





/* ===============================
INFO
================================ */


.info-row{

    display:flex;

    justify-content:space-between;

    padding:14px 0;

    border-bottom:1px solid #f1f5f9;

}



.info-row span{

    color:#64748b;

    font-size:13px;

}



.info-row b{

    color:#15803d;

    font-size:13px;

}





/* ===============================
DEADLINE
================================ */


.deadline-card{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:15px;

    background:#f8fafc;

    border-radius:16px;

    margin-bottom:12px;

}



.deadline-card strong{

    font-size:13px;

}



.deadline-card p{

    margin:5px 0 0;

    font-size:12px;

    color:#64748b;

}



.deadline-date{

    background:#ecfdf5;

    color:#15803d;

    padding:7px 13px;

    border-radius:20px;

    font-size:12px;

    font-weight:700;

}





/* ===============================
ACTIVITY
================================ */


.activity-card{

    display:flex;

    align-items:flex-start;

    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #f1f5f9;

}



.activity-dot{

    width:10px;

    height:10px;

    background:#22c55e;

    border-radius:50%;

    margin-top:7px;

}



.activity-content{

    flex:1;

}


.activity-content strong{

    font-size:14px;

}


.activity-content p{

    margin:5px 0;

    font-size:13px;

    color:#475569;

}



.activity-content small{

    color:#94a3b8;

}



.activity-percent{

    background:#ecfdf5;

    color:#15803d;

    padding:6px 12px;

    border-radius:20px;

    font-size:12px;

    font-weight:700;

}





.empty-data{

    text-align:center;

    color:#94a3b8;

    padding:25px;

}





/* ===============================
RESPONSIVE
================================ */


@media(max-width:1300px){

.employee-stats{

    grid-template-columns:repeat(3,1fr);

}

}



@media(max-width:900px){


.employee-stats{

    grid-template-columns:repeat(2,1fr);

}


.employee-grid{

    grid-template-columns:1fr;

}


.employee-welcome{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



}


@media(max-width:600px){


.employee-stats{

    grid-template-columns:1fr;

}


.task-row,
.deadline-card{

    flex-direction:column;

    align-items:flex-start;

    gap:10px;

}


}


</style>

@endsection