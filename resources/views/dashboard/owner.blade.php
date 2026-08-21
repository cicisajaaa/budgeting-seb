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
$totalRealisasi ?? 0,
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
Total Dana Disetujui
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
$totalRealisasi ?? 0,
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



@forelse($projects ?? [] as $project)



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

{{$activity->tugas->proyek->nama_proyek ?? '-'}}

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









<style>

.dashboard-header{

background:#f8fafc;

padding:30px;

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



@media(max-width:1000px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


.content-grid{

grid-template-columns:1fr;

}


}
/* ===============================
COMPACT FONT MODE
================================ */


/* HEADER */

.dashboard-header{

    padding:25px;

    border-radius:24px;

}



.label{

    font-size:10px;

}



.dashboard-header h1{

    font-size:24px;

    margin:8px 0;

}



.dashboard-header p{

    font-size:12px;

}







/* SUMMARY CARD */

.summary-grid{

    gap:15px;

}



.summary-card{

    padding:18px;

    border-radius:22px;

}



.summary-card span{

    font-size:11px;

}



.summary-card h2{

    font-size:19px;

    margin:8px 0;

}



.summary-card p{

    font-size:11px;

}







/* PANEL */

.panel{

    padding:20px;

    border-radius:24px;

}



.panel h3{

    font-size:15px;

    margin-bottom:15px;

}





.finance-row,
.health-item{

    padding:12px 0;

}



.finance-row span,
.health-item span{

    font-size:12px;

}



.finance-row strong,
.health-item b{

    font-size:13px;

}







/* TABLE */

th{

    padding:12px;

    font-size:11px;

}



td{

    padding:12px;

    font-size:12px;

}



td strong{

    font-size:13px;

}



td small{

    font-size:10px;

}







/* STATUS BADGE */

.status{

    padding:6px 12px;

    font-size:10px;

}





.status-dot{

    width:7px;

    height:7px;

}







/* PROGRESS */

.progress-wrapper{

    width:150px;

}



.progress-bar{

    width:100px;

    height:8px;

}



.progress-number{

    font-size:12px;

}







/* CHART TITLE */

.chart-grid .panel h3{

    font-size:15px;

}






/* MOBILE */

@media(max-width:1000px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:600px){


.summary-grid{

    grid-template-columns:1fr;

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
    $projects->pluck('nama_proyek')
);


const projectProgress = @json(
    $projects->map(function($project){

        return $project->progres_keseluruhan;

    })
);



new Chart(

document.getElementById('projectProgressChart'),

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





/*
========================
CHART KEUANGAN
========================
*/


const financeData = @json($financeProjects);



new Chart(

document.getElementById('financeChart'),

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



});


</script>

@endsection