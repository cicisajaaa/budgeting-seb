@extends('layouts.dashboard')


@section('content')


<div class="dashboard-header">


<span class="label">
DASHBOARD UTAMA
</span>

<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>

<div class="header-line"></div>

<p>
Pemantauan kondisi proyek, keuangan, dan aktivitas perusahaan secara menyeluruh.
</p>


</div>






{{-- ================= RINGKASAN UTAMA ================= --}}


<div class="summary-grid">


<div class="summary-card">

<span>
Total Proyek
</span>


<h2>
{{$totalProject ?? 0}}
</h2>


<p>
Jumlah proyek perusahaan
</p>


</div>





<div class="summary-card">

<span>
Total Anggaran
</span>


<h2>
Rp {{number_format(
$totalBudget ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Nilai keseluruhan proyek
</p>


</div>


<div class="summary-card">

<span>
Dana Terealisasi
</span>


<h2>
Rp {{number_format(
$totalCairDana ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Dana yang sudah dicairkan
</p>


</div>


<div class="summary-card">

<span>
Dana Disetujui
</span>


<h2>
Rp {{number_format(
$totalApprovedExpense ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Total dana approval
</p>


</div>


</div>








{{-- ================= MONITORING OPERASIONAL ================= --}}


<div class="summary-grid">



<div class="summary-card">
<span>
Sisa Budget Proyek
</span>


<h2 class="green">

Rp {{number_format(
$sisaBudgetProyek ?? 0,
0,
',',
'.'
)}}

</h2>


<p>
Anggaran proyek yang belum digunakan
</p>

</div>






<div class="summary-card">

<span>
Progress Proyek
</span>


<h2>

{{number_format(
$progressProject ?? 0,
0
)}}%

</h2>


<p>
Rata-rata penyelesaian
</p>


</div>







<div class="summary-card">

<span>
Total Task
</span>


<h2>

{{$totalTask ?? 0}}

</h2>


<p>
Seluruh pekerjaan
</p>


</div>

<div class="summary-card">

<span>
Total Aktivitas
</span>

<h2>
{{$totalAktivitas ?? 0}}
</h2>

<p>
Update pekerjaan karyawan
</p>

</div>

<div class="summary-card">

<span>
Budget Aktivitas
</span>

<h2>

Rp {{number_format(
$totalAnggaranAktivitas ?? 0,
0,
',',
'.'
)}}

</h2>

<p>
Penggunaan aktivitas
</p>

</div>





<div class="summary-card">

<span>
Approval Pending
</span>


<h2>

{{$pendingApproval ?? 0}}

</h2>


<p>
Menunggu persetujuan
</p>


</div>



</div>








{{-- ================= KEUANGAN ================= --}}


<div class="content-grid">



<div class="panel">


<h3>
Ringkasan Keuangan
</h3>





<div class="finance-row">

<span>
Dana Terealisasi
</span>


<strong class="green">

Rp {{number_format(
$totalCairDana ?? 0,
0,
',',
'.'
)}}

</strong>


</div>





<div class="finance-row">

<span>
Total Approval Dana
</span>


<strong class="red">

Rp {{number_format(
$totalApprovedExpense ?? 0,
0,
',',
'.'
)}}

</strong>


</div>





<div class="finance-row">
<span>
Sisa Budget
</span>


<strong class="green">

Rp {{number_format(
$sisaBudgetProyek ?? 0,
0,
',',
'.'
)}}

</strong>

</div>



</div>









<div class="panel">


<h3>
Kondisi Perusahaan
</h3>





<div class="health-item">

<span>
Jumlah Project
</span>


<b>
{{$totalProject ?? 0}} Project
</b>

</div>






<div class="health-item">

<span>
Task Berjalan
</span>


<b>
{{$taskBerjalan ?? 0}} Task
</b>

</div>






<div class="health-item">

<span>
Task Selesai
</span>


<b>
{{$taskSelesai ?? 0}} Task
</b>

</div>





</div>



</div>









{{-- ================= PROJECT MONITORING ================= --}}



<div class="panel">


<h3>
Pemantauan Proyek
</h3>

<form method="GET"
      action="{{ route('owner.dashboard') }}"
      class="project-search">

    <input
        type="text"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Cari nama project..."
    >

    <button type="submit">
        Cari
    </button>

    @if(!empty($search))
        <a href="{{ route('owner.dashboard') }}">
            Reset
        </a>
    @endif

</form>

<div class="dashboard-info">
    Menampilkan maksimal 10 project terbaru
    @if(!empty($search))
        untuk pencarian "{{ $search }}"
    @endif
</div>


<div class="table-wrapper">
    <table>

        <thead>

<tr>


<th>
Nama Project
</th>


<th>
Progress
</th>


<th>
Anggaran
</th>


<th>
Status
</th>


</tr>


</thead>




<tbody>

@forelse($dashboardProjects as $project)


<tr>

<td>

<strong>

<a href="{{ route('owner.project.detail',$project->id) }}"
style="text-decoration:none;color:#1e293b">

{{$project->nama_proyek}}

</a>

</strong>

</td>

<td>


@php

$progress = $project->progres_keseluruhan ?? 0;

@endphp


<div class="progress-wrapper">


<div class="progress-bar">


<div class="progress-fill

@if($progress >= 80)

progress-green

@elseif($progress >= 50)

progress-blue

@else

progress-yellow

@endif"

style="width:{{ $progress }}%">

</div>


</div>



<span class="progress-number">

{{ $progress }}%

</span>



</div>


</td>




<td>

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

<br>

<small>
Terpakai:
{{ $project->persentase_budget ?? 0 }}%
</small>

</td>


<td>

<span class="status {{ $project->health_status['color'] }}">

<span class="status-dot"></span>

{{ $project->health_status['label'] }}

</span>


</td>

</tr>




@empty


<tr>

<td colspan="4">

Belum ada project

</td>


</tr>


@endforelse



</tbody>

</table>

</div>


</div>



<div class="chart-grid">


<div class="panel">

<h3>
Grafik Progress Proyek
</h3>


<div style="height:230px">

<canvas id="projectProgressChart"></canvas>

</div>


</div>



<div class="panel">

<h3>
Keuangan
</h3>


<div style="height:230px">

<canvas id="financeChart"></canvas>

</div>


</div>



</div>




{{-- ================= TASK TERBARU ================= --}}


<div class="panel">

    <h3>
        Aktivitas Pekerjaan Terbaru
    </h3>

    <div class="table-wrapper">
        <table>

<thead>


<tr>

<th>
Task
</th>


<th>
Project
</th>


<th>
PIC
</th>


<th>
Tanggal
</th>


</tr>


</thead>





<tbody>



@forelse($recentTasks ?? [] as $activity)



<tr>


<td>

<strong>

{{$activity->tugas->nama_tugas ?? '-'}}

</strong>


</td>





<td>

{{$activity->tugas->proyek?->nama_proyek ?? '-'}}

</td>





<td>

{{$activity->karyawan->nama_karyawan ?? '-'}}
</td>





<td>

{{$activity->created_at
? $activity->created_at->format('d M Y')
: '-'}}

</td>



</tr>



@empty


<tr>

<td colspan="4">

Belum ada aktivitas

</td>


</tr>


@endforelse



</tbody>



</table>

    </div>


</div>







<style>

/* =================================
   GLOBAL
================================= */

*{
    box-sizing:border-box;
}

body{
    font-family:Inter,system-ui,sans-serif;
}

/* =================================
   HEADER
================================= */

.dashboard-header{
    background:#f8fafc;
    padding:18px 22px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    margin-bottom:16px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.label{
    font-size:9px;
    font-weight:800;
    letter-spacing:1.7px;
    color:#64748b;
}

.dashboard-header h1{
    margin:6px 0;
    font-size:21px;
    line-height:1.25;
    color:#1e293b;
    font-weight:800;
}

.dashboard-header p{
    margin:0;
    font-size:11px;
    line-height:1.5;
    color:#64748b;
}

/* =================================
   SUMMARY GRID
================================= */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:12px;
    margin-bottom:15px;
}

/* =================================
   SUMMARY CARD
================================= */

.summary-card{
    background:#fff;
    padding:14px 16px;
    min-width:0;
    min-height:88px;
    border-radius:16px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    transition:.2s ease;
    overflow:hidden;
}

.summary-card:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 22px rgba(15,23,42,.06);
}

.summary-card span{
    display:block;
    font-size:10px;
    color:#64748b;
    font-weight:600;
}

.summary-card h2{
    margin:5px 0;
    font-size:19px;
    line-height:1.25;
    color:#1e293b;
    font-weight:800;
    overflow-wrap:anywhere;
}

.summary-card p{
    margin:0;
    font-size:9px;
    line-height:1.4;
    color:#94a3b8;
}

.summary-card:nth-child(1){
    border-top:3px solid #334155;
}

.summary-card:nth-child(2){
    border-top:3px solid #2563eb;
}

.summary-card:nth-child(3){
    border-top:3px solid #16a34a;
}

.summary-card:nth-child(4){
    border-top:3px solid #f59e0b;
}

.green{
    color:#15803d !important;
}

.red{
    color:#dc2626 !important;
}

/* =================================
   CONTENT GRID
================================= */

.content-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

/* =================================
   CHART GRID
================================= */

.chart-grid{
    display:grid;
    grid-template-columns:1.5fr 1fr;
    gap:12px;
}

/* =================================
   PANEL
================================= */

.panel{
    background:#fff;
    padding:17px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    margin-bottom:15px;
    min-width:0;
}

.panel h3{
    display:flex;
    align-items:center;
    gap:7px;
    margin:0 0 12px;
    font-size:14px;
    line-height:1.3;
    font-weight:800;
    color:#1e293b;
}

.panel h3::before{
    content:"";
    width:3px;
    height:16px;
    margin-right:2px;
    background:#334155;
    border-radius:10px;
}

/* =================================
   FINANCE / HEALTH
================================= */

.finance-row,
.health-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:10px 0;
    border-bottom:1px solid #f1f5f9;
}

.finance-row:last-child,
.health-item:last-child{
    border-bottom:none;
}

.finance-row span,
.health-item span{
    min-width:0;
    font-size:10px;
    color:#64748b;
    overflow-wrap:anywhere;
}

.finance-row strong,
.health-item b{
    min-width:0;
    font-size:11px;
    font-weight:700;
    text-align:right;
    overflow-wrap:anywhere;
}

/* =================================
   SEARCH
================================= */

.project-search{
    display:flex;
    align-items:center;
    gap:8px;
    margin:10px 0 6px;
}

.project-search input{
    flex:1;
    min-width:0;
    height:36px;
    padding:0 12px;
    border:1px solid #e2e8f0;
    border-radius:9px;
    background:#fff;
    color:#334155;
    font-size:11px;
    outline:none;
}

.project-search input:focus{
    border-color:#94a3b8;
}

.project-search button{
    height:36px;
    padding:0 16px;
    border:none;
    border-radius:9px;
    background:#0f172a;
    color:#fff;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
}

.project-search button:hover{
    background:#334155;
}

.project-search a{
    height:36px;
    padding:0 13px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:#f1f5f9;
    color:#334155;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
}

.dashboard-info{
    margin-bottom:9px;
    font-size:9px;
    color:#94a3b8;
    line-height:1.4;
}

/* =================================
   TABLE
================================= */

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    position:relative;
}

.table-wrapper table{
    width:100%;
    min-width:650px;
    border-collapse:collapse;
}

th{
    padding:10px 11px;
    text-align:left;
    background:#f8fafc;
    color:#64748b;
    font-size:10px;
    font-weight:700;
    white-space:nowrap;
}

td{
    padding:10px 11px;
    border-bottom:1px solid #f1f5f9;
    font-size:10px;
    color:#334155;
    vertical-align:middle;
}

tbody tr{
    transition:.15s ease;
}

tbody tr:hover{
    background:#f8fafc;
}

td strong{
    color:#172033;
    font-size:11px;
}

/* =================================
   STATUS
================================= */

.status{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 9px;
    border-radius:999px;
    font-size:9px;
    font-weight:700;
    white-space:nowrap;
}

.status-dot{
    width:6px;
    height:6px;
    flex-shrink:0;
    border-radius:50%;
    background:currentColor;
}

.berjalan{
    background:#dcfce7;
    color:#166534;
}

.selesai{
    background:#dbeafe;
    color:#1d4ed8;
}

.pending{
    background:#fef3c7;
    color:#92400e;
}

.kritis,
.danger{
    background:#fee2e2;
    color:#b91c1c;
}

.perhatian,
.warning{
    background:#fef3c7;
    color:#92400e;
}

.aman,
.success{
    background:#dcfce7;
    color:#166534;
}

/* =================================
   PROGRESS
================================= */

.progress-wrapper{
    display:flex;
    align-items:center;
    gap:7px;
    width:150px;
}

.progress-bar{
    width:100px;
    height:7px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.progress-fill{
    height:100%;
    border-radius:20px;
    transition:.4s ease;
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

.progress-number{
    font-size:10px;
    font-weight:700;
    color:#334155;
    white-space:nowrap;
}

/* =================================
   CHART
================================= */

.chart-grid .panel > div{
    height:210px !important;
}

canvas{
    max-width:100%;
}

/* =================================
   SCROLL INDICATOR
================================= */

.table-wrapper::after{
    display:none;
}

/* =================================
   1200px
================================= */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .chart-grid{
        grid-template-columns:1fr 1fr;
    }
}

/* =================================
   900px
================================= */

@media(max-width:900px){

    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .content-grid,
    .chart-grid{
        grid-template-columns:1fr;
    }

    .dashboard-header{
        padding:17px;
    }

    .dashboard-header h1{
        font-size:19px;
    }

    .panel{
        padding:15px;
    }

    .chart-grid .panel > div{
        height:190px !important;
    }
}

/* =================================
   MOBILE
================================= */

@media(max-width:600px){

    .dashboard-header{
        padding:15px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.4px;
    }

    .dashboard-header h1{
        font-size:17px;
        margin:6px 0;
    }

    .dashboard-header p{
        font-size:9px;
        line-height:1.5;
    }

    /* SUMMARY */

    .summary-grid{
        grid-template-columns:1fr 1fr;
        gap:9px;
        margin-bottom:12px;
    }

    .summary-card{
        padding:11px;
        min-height:76px;
        border-radius:13px;
    }

    .summary-card span{
        font-size:8px;
    }

    .summary-card h2{
        font-size:14px;
        margin:4px 0;
    }

    .summary-card p{
        font-size:8px;
    }

    /* PANEL */

    .panel{
        padding:12px;
        border-radius:14px;
        margin-bottom:12px;
    }

    .panel h3{
        font-size:12px;
        margin-bottom:10px;
    }

    .panel h3::before{
        width:3px;
        height:14px;
    }

    /* FINANCE */

    .finance-row,
    .health-item{
        padding:9px 0;
    }

    .finance-row span,
    .health-item span{
        font-size:9px;
    }

    .finance-row strong,
    .health-item b{
        font-size:9px;
    }

    /* SEARCH */

    .project-search{
        display:grid;
        grid-template-columns:1fr auto;
        gap:7px;
        margin-top:8px;
    }

    .project-search input{
        height:34px;
        font-size:10px;
    }

    .project-search button{
        height:34px;
        padding:0 13px;
        font-size:10px;
    }

    .project-search a{
        grid-column:1 / -1;
        width:100%;
        height:31px;
        font-size:10px;
    }

    .dashboard-info{
        font-size:8px;
        margin-bottom:8px;
    }

    /* TABLE */

    .table-wrapper table{
        min-width:650px;
    }

    th{
        padding:9px;
        font-size:9px;
    }

    td{
        padding:9px;
        font-size:9px;
    }

    td strong{
        font-size:10px;
    }

    td small{
        font-size:8px;
    }

    /* PROGRESS */

    .progress-wrapper{
        width:125px;
        gap:6px;
    }

    .progress-bar{
        width:80px;
        height:6px;
    }

    .progress-number{
        font-size:9px;
    }

    /* STATUS */

    .status{
        padding:5px 8px;
        font-size:8px;
    }

    .status-dot{
        width:5px;
        height:5px;
    }

    /* CHART */

    .chart-grid .panel > div{
        height:165px !important;
    }

    /* MOBILE SCROLL */

    .table-wrapper::after{
        content:"Geser →";
        display:block;
        position:absolute;
        right:8px;
        bottom:4px;
        font-size:9px;
        color:#94a3b8;
        pointer-events:none;
    }
}

/* =================================
   SMALL MOBILE
================================= */

@media(max-width:380px){

    .summary-grid{
        grid-template-columns:1fr;
    }

    .summary-card{
        min-height:70px;
    }

    .summary-card h2{
        font-size:14px;
    }

    .project-search{
        grid-template-columns:1fr;
    }

    .project-search button{
        width:100%;
    }

    .chart-grid .panel > div{
        height:150px !important;
    }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function(){


/*
========================
CHART PROGRESS PROJECT
========================
*/

const projectLabels = @json(
    $progressProjects->pluck('nama_proyek')
);


const projectProgress = @json(
    $progressProjects->map(function($project){

        return $project->progres_keseluruhan;

    })
);


const progressCanvas = document.getElementById('projectProgressChart');


if(progressCanvas){

new Chart(

progressCanvas,

{

type:'bar',

data:{


labels:projectLabels,


datasets:[{

label:'Progress Proyek (%)',

data:projectProgress,

backgroundColor:[
'#64748b',
'#2563eb',
'#16a34a'
],

borderRadius:8

}]

},


options:{


responsive:true,

maintainAspectRatio:false,

plugins:{
    legend:{
        display:false
    }
},

scales:{


y:{

beginAtZero:true,

max:100,


ticks:{

callback:function(value){

return value+'%';

}

}


}


}


}


}

);
}



/*
========================
CHART KEUANGAN
========================
*/


const financeData = @json($financeProjects);



const financeCanvas = document.getElementById('financeChart');

if(financeCanvas){

new Chart(

financeCanvas,

{

type:'bar',

data:{

labels:financeData.map(item=>item.nama),

datasets:[

{
label:'Budget',

data:financeData.map(item=>item.budget),

backgroundColor:'#2563eb'

},

{
label:'Realisasi',

data:financeData.map(item=>item.realisasi),

backgroundColor:'#16a34a'

}

]

},

options:{

responsive:true,

maintainAspectRatio:false,

scales:{

y:{

beginAtZero:true,

ticks:{

callback:function(value){

return 'Rp '+value.toLocaleString();

}

}

}

}

}

}

);

}

});



</script>

@endsection