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



@forelse($projects as $project)



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

.dashboard-header{

background:#f8fafc;

padding:15px;

border-radius:20px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:0 8px 25px rgba(15,23,42,.05);

}



.label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#64748b;

}


.dashboard-header h1{

margin:10px 0;

font-size:28px;

color:#1e293b;

}



.dashboard-header p{

color:#64748b;

}





.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:20px;

}





.summary-card{

background:white;

padding:22px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:0 5px 20px rgba(15,23,42,.05);

transition:.3s;

}


.summary-card:hover{

transform:translateY(-3px);

box-shadow:0 10px 30px rgba(15,23,42,.08);

}


.summary-card span{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin-top:10px;

font-size:24px;

color:#1e293b;

}



.summary-card p{

font-size:12px;

color:#94a3b8;

}

.summary-card:nth-child(1){
border-top:4px solid #334155;
}


.summary-card:nth-child(2){
border-top:4px solid #2563eb;
}


.summary-card:nth-child(3){
border-top:4px solid #16a34a;
}


.summary-card:nth-child(4){
border-top:4px solid #f59e0b;
}

.green{

color:#15803d!important;

}



.red{

color:#dc2626!important;

}




.chart-grid{

display:grid;

grid-template-columns:1.7fr 1fr;

gap:20px;

}



.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:0 5px 20px rgba(15,23,42,.05);

margin-bottom:20px;

}

.panel h3{

display:flex;

align-items:center;

gap:10px;

font-size:17px;

font-weight:700;

color:#1e293b;

}


.panel h3::before{

content:"";

width:4px;

height:20px;

margin-right:4px;

background:#334155;

border-radius:10px;

}


.finance-row,
.health-item{

display:flex;

justify-content:space-between;

padding:15px 0;

border-bottom:1px solid #f1f5f9;

}


.finance-row strong{
display:block;
font-weight:700;
}

tbody tr{

transition:.2s;

}


tbody tr:hover{

background:#f8fafc;

}


table{

width:100%;

border-collapse:collapse;

}



th{

padding:14px;

text-align:left;

font-size:12px;

color:#64748b;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

font-size:14px;

}





.status{

display:inline-flex;

align-items:center;

padding:7px 14px;

border-radius:999px;

font-size:12px;

font-weight:700;

letter-spacing:.2px;

}

.status-dot{

width:8px;

height:8px;

border-radius:50%;

background:currentColor;

margin-right:6px;

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

.kritis{

background:#fee2e2;

color:#b91c1c;

}



.perhatian{

background:#fef3c7;

color:#92400e;

}



.aman{

background:#dcfce7;

color:#166534;

}



.success{

background:#dcfce7;

color:#166534;

}


.warning{

background:#fef3c7;

color:#92400e;

}


.danger{

background:#fee2e2;

color:#b91c1c;

}

.progress-wrapper{

display:flex;

align-items:center;

gap:12px;

width:180px;

}


.progress-number{

font-size:14px;

font-weight:600;

color:#334155;

}

.progress-bar{

width:120px;

height:10px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}


.progress-fill{

height:100%;

border-radius:20px;

transition:.5s ease;

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


/* ================= RESPONSIVE ================= */

.table-wrapper{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.table-wrapper table{
    min-width:750px;
}

@media(max-width:600px){

.summary-grid{
    grid-template-columns:1fr;
    }

    .content-grid{
        grid-template-columns:1fr;
    }

    .chart-grid{
        grid-template-columns:1fr;
    }

}


@media(max-width:900px){

    .dashboard-header{
        padding:22px;
        border-radius:20px;
    }

    .dashboard-header h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .dashboard-header p{
        font-size:11px;
        line-height:1.5;
    }

    .summary-card{
        min-width:0;
        padding:15px;
        border-radius:18px;
    }

    .summary-card span,
    .summary-card h2,
    .summary-card p{
        word-break:break-word;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
    }

    .panel{
        padding:18px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel h3{
        font-size:14px;
        line-height:1.4;
    }

    .finance-row,
    .health-item{
        gap:12px;
    }

    .finance-row span,
    .health-item span,
    .finance-row strong,
    .health-item b{
        min-width:0;
        word-break:break-word;
        line-height:1.5;
    }

    .finance-row strong,
    .health-item b{
        text-align:right;
    }

    .progress-wrapper{
        width:150px;
        max-width:100%;
    }

    .progress-bar{
        width:100px;
    }

    .chart-grid{
        gap:15px;
    }

}


@media(max-width:600px){

    .dashboard-header{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .dashboard-header h1{
        font-size:19px;
        margin:7px 0;
    }

    .dashboard-header p{
        font-size:10px;
        line-height:1.5;
    }


.summary-grid{

    grid-template-columns:1fr;

    gap:12px;

    margin-bottom:15px;

}
    .summary-card{
        padding:12px;
        border-radius:16px;
    }

    .summary-card span{
        font-size:8px;
        line-height:1.3;
    }

    .summary-card h2{
        font-size:15px;
        margin:5px 0;
        line-height:1.35;
    }

    .summary-card p{
        font-size:8px;
        line-height:1.4;
    }


    .content-grid{
        grid-template-columns:1fr;
        gap:0;
    }

    .chart-grid{
        grid-template-columns:1fr;
        gap:0;
    }


    .panel{
        padding:15px;
        border-radius:18px;
        margin-bottom:15px;
    }

    .panel h3{
        font-size:13px;
        margin-bottom:13px;
    }


    .finance-row,
    .health-item{
        padding:11px 0;
        gap:10px;
    }

    .finance-row span,
    .health-item span{
        font-size:9px;
    }

    .finance-row strong,
    .health-item b{
        font-size:10px;
        text-align:right;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .table-wrapper table{
        min-width:650px;
    }

    th{
        padding:11px 9px;
        font-size:9px;
    }

    td{
        padding:11px 9px;
        font-size:10px;
    }

    td strong{
        font-size:10px;
    }

    td small{
        font-size:8px;
    }


    .status{
        padding:5px 9px;
        font-size:8px;
    }

    .status-dot{
        width:6px;
        height:6px;
        margin-right:5px;
    }


    .progress-wrapper{
        width:140px;
        gap:8px;
    }

    .progress-bar{
        width:90px;
        height:7px;
    }

    .progress-number{
        font-size:10px;
    }


    .chart-grid .panel > div{
        height:200px!important;
    }

}

@media(max-width:600px){

.chart-grid .panel > div{
    height:170px!important;
}

}


.table-wrapper{
position:relative;
}


.table-wrapper::after{

content:"Geser →";

position:absolute;

right:10px;

bottom:5px;

font-size:10px;

color:#94a3b8;

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