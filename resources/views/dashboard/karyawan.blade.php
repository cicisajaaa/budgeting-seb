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

            {{$taskChart['progress']}}

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
        ->whereIn('status',
        [
            'berjalan',
            'progress',
            'sedang_dikerjakan'
        ])
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

@if(in_array($task->status,['selesai','done']))

Selesai

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

Sedang Dikerjakan

@else

Belum Dikerjakan

@endif

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


    new Chart(canvas, {


        type:'doughnut',


        data:{


            labels:[

                'Selesai',

                'Berjalan',

                'Belum Dikerjakan'

            ],



            datasets:[{


                data:[

                    {{$taskChart['done']}},

                    {{$taskChart['progress']}},

                    {{$taskChart['todo']}}

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

/* =================================
GLOBAL
================================= */

.employee-dashboard{
    width:100%;
}


/* =================================
HEADER OWNER STYLE
================================= */

.employee-welcome{

    background:#f8fafc;

    padding:25px;

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

    font-weight:700;

    letter-spacing:2px;

    color:#64748b;

}



.employee-welcome h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.employee-welcome p{

    font-size:12px;

    color:#64748b;

    margin:0;

}



.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    padding:7px 12px;

    border-radius:20px;

    font-size:11px;

    color:#334155;

    font-weight:600;

}



.today-card{

    background:#dcfce7;

    color:#166534;

    padding:10px 18px;

    border-radius:20px;

    font-size:12px;

    font-weight:700;

}





/* =================================
STAT CARD
================================= */


.employee-stats{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}



.stat-card{

    background:white;

    padding:18px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    display:flex;

    align-items:center;

    gap:14px;

    position:relative;

    overflow:hidden;

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.stat-card:nth-child(1)::before{

    background:#334155;

}


.stat-card:nth-child(2)::before{

    background:#2563eb;

}


.stat-card:nth-child(3)::before{

    background:#16a34a;

}


.stat-card:nth-child(4)::before{

    background:#f59e0b;

}



.stat-card:nth-child(5)::before{

    background:#7c3aed;

}




.stat-icon{

    width:45px;

    height:45px;

    border-radius:14px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

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

    font-size:11px;

    color:#64748b;

}



.stat-card h2{

    margin:8px 0;

    font-size:19px;

    color:#1e293b;

}



.stat-card small{

    font-size:11px;

    color:#94a3b8;

}





/* =================================
GRID
================================= */


.employee-grid{

    display:grid;

    grid-template-columns:1.7fr 1fr;

    gap:20px;

}





/* =================================
PANEL OWNER STYLE
================================= */


.employee-panel{

    background:white;

    padding:20px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.panel-header{

    font-size:15px;

    font-weight:800;

    color:#1e293b;

    margin-bottom:15px;

}





/* =================================
PROJECT PROGRESS
================================= */


.project-item{

    background:#f8fafc;

    padding:12px;

    border-radius:15px;

    margin-bottom:10px;

}



.project-top{

    display:flex;

    justify-content:space-between;

    margin-bottom:8px;

}



.project-top strong{

    font-size:13px;

    color:#1e293b;

}



.project-top span{

    font-size:12px;

    font-weight:700;

    color:#166534;

}



.progress-bar{

    width:100%;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-value{

    height:100%;

    background:#16a34a;

    border-radius:20px;

}





/* =================================
TASK
================================= */


.task-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:12px;

    background:#f8fafc;

    border-radius:15px;

    border:1px solid #e2e8f0;

    margin-bottom:10px;

}



.task-row strong{

    font-size:13px;

    color:#1e293b;

}



.task-row p{

    margin:5px 0 0;

    font-size:11px;

    color:#64748b;

}



.task-row span{

    background:#dcfce7;

    color:#166534;

    padding:6px 12px;

    border-radius:20px;

    font-size:10px;

    font-weight:700;

}





/* =================================
DEADLINE
================================= */


.deadline-card{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:12px;

    background:#f8fafc;

    border-radius:15px;

    margin-bottom:10px;

}



.deadline-card strong{

    font-size:13px;

}



.deadline-card p{

    margin:5px 0;

    font-size:11px;

    color:#64748b;

}



.deadline-date{

    background:#dcfce7;

    color:#166534;

    padding:6px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}





/* =================================
INFO
================================= */


.info-row{

    display:flex;

    justify-content:space-between;

    padding:12px 0;

    border-bottom:1px solid #f1f5f9;

}



.info-row span{

    font-size:12px;

    color:#64748b;

}



.info-row b{

    font-size:12px;

    color:#1e293b;

}



.active-status{

    background:#dcfce7;

    color:#166534!important;

    padding:5px 12px;

    border-radius:20px;

}





/* =================================
CHART
================================= */


.chart-box{

    height:200px;

    display:flex;

    justify-content:center;

    align-items:center;

}



#taskChart{

    max-width:170px!important;

    max-height:170px!important;

}





/* =================================
ACTIVITY
================================= */


.activity-card{

    display:flex;

    align-items:center;

    gap:15px;

    padding:12px 0;

    border-bottom:1px solid #f1f5f9;

}



.activity-dot{

    width:9px;

    height:9px;

    background:#16a34a;

    border-radius:50%;

}



.activity-content{

    flex:1;

}



.activity-content strong{

    font-size:13px;

}



.activity-content p{

    margin:5px 0;

    font-size:12px;

    color:#64748b;

}



.activity-content small{

    font-size:11px;

    color:#94a3b8;

}



.activity-percent{

    background:#dcfce7;

    color:#166534;

    padding:5px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}





/* =================================
EMPTY
================================= */


.empty-data{

    text-align:center;

    padding:25px;

    color:#94a3b8;

    font-size:12px;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:1200px){


.employee-stats{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.employee-grid{

    grid-template-columns:1fr;

}



.employee-welcome{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

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


/* =================================
EMPLOYEE DASHBOARD COMPACT MODE
SAMA DENGAN OWNER
================================= */


/* HEADER */

.employee-welcome{

    padding:25px;

    border-radius:24px;

}



.welcome-label{

    font-size:10px;

}



.employee-welcome h1{

    font-size:24px;

    margin:8px 0;

}



.employee-welcome p{

    font-size:12px;

}



.welcome-tags span{

    font-size:10px;

    padding:6px 10px;

}



.today-card{

    font-size:11px;

    padding:9px 16px;

}





/* =================================
STAT CARD
================================= */


.employee-stats{

    gap:15px;

}



.stat-card{

    padding:18px;

    border-radius:22px;

}



.stat-icon{

    width:40px;

    height:40px;

    font-size:16px;

}



.stat-card label{

    font-size:10px;

}



.stat-card h2{

    font-size:19px;

    margin:6px 0;

}



.stat-card small{

    font-size:10px;

}





/* =================================
PANEL
================================= */


.employee-panel{

    padding:20px;

    border-radius:24px;

}



.panel-header{

    font-size:15px;

    margin-bottom:15px;

}





/* =================================
PROJECT PROGRESS
================================= */


.project-item{

    padding:12px;

}



.project-top strong{

    font-size:12px;

}



.project-top span{

    font-size:11px;

}





.progress-bar{

    height:7px;

}





/* =================================
TASK
================================= */


.task-row{

    padding:12px;

}



.task-row strong{

    font-size:12px;

}



.task-row p{

    font-size:10px;

}



.task-row span{

    font-size:10px;

    padding:5px 10px;

}





/* =================================
DEADLINE
================================= */


.deadline-card{

    padding:12px;

}



.deadline-card strong{

    font-size:12px;

}



.deadline-card p{

    font-size:10px;

}



.deadline-date{

    font-size:10px;

    padding:5px 10px;

}





/* =================================
INFO ACCOUNT
================================= */


.info-row{

    padding:10px 0;

}



.info-row span{

    font-size:11px;

}



.info-row b{

    font-size:11px;

}





.active-status{

    padding:4px 10px;

    font-size:10px;

}





/* =================================
CHART
================================= */


.chart-box{

    height:180px;

}


#taskChart{

    max-width:150px!important;

    max-height:150px!important;

}





/* =================================
ACTIVITY
================================= */


.activity-card{

    gap:12px;

    padding:10px 0;

}



.activity-dot{

    width:8px;

    height:8px;

}



.activity-content strong{

    font-size:12px;

}



.activity-content p{

    font-size:11px;

}



.activity-content small{

    font-size:10px;

}



.activity-percent{

    font-size:10px;

    padding:5px 10px;

}





/* =================================
EMPTY
================================= */


.empty-data{

    font-size:11px;

    padding:20px;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:1200px){

.employee-stats{

    grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:600px){

.employee-stats{

    grid-template-columns:1fr;

}

}

</style>

@endsection