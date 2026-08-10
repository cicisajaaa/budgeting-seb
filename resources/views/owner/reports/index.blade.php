@extends('layouts.dashboard')

@section('content')


{{-- HEADER --}}

<div class="report-header">

    <div>

        <span class="report-label">
            LAPORAN PERUSAHAAN
        </span>


        <h1>
            Laporan Perusahaan
        </h1>


        <p>
            Ringkasan kondisi keuangan, proyek, dan performa bisnis perusahaan.
        </p>

    </div>



  

</div>





{{-- FILTER --}}

<form method="GET"
action="{{route('owner.reports')}}"
class="report-filter">


<div>

<label>
Periode
</label>


<select name="periode">


<option value="">
Semua Periode
</option>


<option value="bulan">
Bulanan
</option>


<option value="tahun">
Tahunan
</option>


</select>

</div>





<div>

<label>
Tanggal Mulai
</label>


<input
type="date"
name="start_date"
value="{{request('start_date')}}">

</div>





<div>

<label>
Tanggal Akhir
</label>


<input
type="date"
name="end_date"
value="{{request('end_date')}}">

</div>





<button type="submit">

Tampilkan

</button>


</form>









{{-- KPI --}}


<div class="kpi-grid">





<div class="kpi-card income">

<span>
Total Pendapatan
</span>


<h2>

Rp {{number_format(
$totalPendapatan ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Pemasukan perusahaan
</small>

</div>








<div class="kpi-card expense">


<span>
Total Pengeluaran
</span>


<h2>

Rp {{number_format(
$totalPengeluaran ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Dana digunakan
</small>


</div>








<div class="kpi-card profit">


<span>
Profit Bersih
</span>


<h2>

Rp {{number_format(
$profit ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Keuntungan perusahaan
</small>


</div>








<div class="kpi-card project">


<span>
Project Aktif
</span>


<h2>

{{$projectAktif ?? 0}}

</h2>


<small>
Project berjalan
</small>


</div>








<div class="kpi-card selesai-card">


<span>
Project Selesai
</span>


<h2>

{{$totalProjectSelesai ?? 0}}

</h2>


<small>
Project sudah selesai
</small>


</div>








<div class="kpi-card warning-card">


<span>
Project Terlambat
</span>


<h2>

{{$totalProjectTerlambat ?? 0}}

</h2>


<small>
Melewati deadline
</small>


</div>








<div class="kpi-card progress-card">


<span>
Rata-rata Progress
</span>


<h2>

{{number_format(
$rataProgress ?? 0,
1
)}}%

</h2>


<small>
Perkembangan seluruh project
</small>


</div>



</div>

{{-- RINGKASAN KEUANGAN --}}


<div class="panel">


<h3>
📊 Ringkasan Keuangan
</h3>



<div class="finance-grid">



<div>

<span>
Pendapatan
</span>


<b class="green">

Rp {{number_format(
$totalPendapatan ?? 0,
0,
',',
'.'
)}}

</b>

</div>





<div>

<span>
Pengeluaran
</span>


<b class="red">

Rp {{number_format(
$totalPengeluaran ?? 0,
0,
',',
'.'
)}}

</b>

</div>





<div>

<span>
Saldo Bersih
</span>


<b>

Rp {{number_format(
$saldo ?? 0,
0,
',',
'.'
)}}

</b>

</div>


</div>


</div>









{{-- ANALISIS PERFORMA --}}


<div class="panel">


<h3>
📊 Analisis Performa Perusahaan
</h3>



<div class="summary-grid">





<div class="summary-card">


<span>
Total Anggaran Project
</span>


<h2>

Rp {{number_format(
$totalAnggaranProject ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Total nilai seluruh project
</small>


</div>








<div class="summary-card">


<span>
Project Berjalan
</span>


<h2>

{{$totalProjectBerjalan ?? 0}}

</h2>


<small>
Project dalam pengerjaan
</small>


</div>








<div class="summary-card">


<span>
Efisiensi Dana
</span>


<h2>

{{number_format(
$efisiensiDana ?? 0,
1
)}}%

</h2>


<small>
Perbandingan saldo terhadap anggaran
</small>


</div>








<div class="summary-card">


<span>
Total Transaksi
</span>


<h2>

{{$totalTransaksi ?? 0}}

</h2>


<small>
Jumlah transaksi perusahaan
</small>


</div>




</div>


</div>









{{-- CHART --}}


<div class="chart-grid">



<div class="panel chart-card">


<h3>
📈 Grafik Keuangan
</h3>


<canvas id="financeChart"></canvas>


</div>







<div class="panel chart-card">


<h3>
📊 Progress Project
</h3>


<canvas id="projectChart"></canvas>


</div>



</div>









{{-- PUSAT LAPORAN --}}


<h2 class="section-title">

Pusat Laporan

</h2>







<div class="report-grid">






<div class="report-card">


<div class="report-icon">
📄
</div>


<h3>
Laporan Perusahaan
</h3>


<p>
Ringkasan keseluruhan kondisi keuangan,
project, dan performa perusahaan.
</p>





<div class="button-group">


<a href="{{route('owner.report.pdf')}}"
class="pdf">

PDF

</a>


</div>


</div>









<div class="report-card">


<div class="report-icon">
💰
</div>


<h3>
Laporan Keuangan
</h3>


<p>
Informasi pemasukan, pengeluaran,
saldo, dan transaksi perusahaan.
</p>





<div class="button-group">


<a href="{{route('owner.report.finance.pdf')}}"
class="pdf">

PDF

</a>



<a href="{{route('owner.report.finance.excel')}}"
class="excel">

Excel

</a>


</div>


</div>









<div class="report-card">


<div class="report-icon">
📁
</div>


<h3>
Laporan Proyek
</h3>


<p>
Informasi project, anggaran,
progress, dan status pekerjaan.
</p>





<div class="button-group">


<a href="{{route('owner.report.project.pdf')}}"
class="pdf">

PDF

</a>



<a href="{{route('owner.report.project.excel')}}"
class="excel">

Excel

</a>


</div>


</div>









<div class="report-card">


<div class="report-icon">
📊
</div>


<h3>
Analisis Performa
</h3>


<p>
Evaluasi perkembangan bisnis
dan performa perusahaan.
</p>





<div class="button-group">


<a href="{{route('owner.report.performance.pdf')}}"
class="pdf">

PDF

</a>



<a href="{{route('owner.report.performance.excel')}}"
class="excel">

Excel

</a>


</div>


</div>






</div>

{{-- PROJECT MONITORING --}}


<div class="panel">


<h3>
📁 Monitoring Project
</h3>




<table>


<thead>

<tr>

<th>
Project
</th>


<th>
Anggaran
</th>


<th>
Progress
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

{{$project->nama_proyek ?? '-'}}

</strong>

</td>





<td>

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>





<td>



<div class="progress-box">


<div class="progress-value">

{{number_format(
$project->progres_keseluruhan ?? 0,
0
)}}%

</div>




<div class="progress-track">


<div class="progress-fill"

style="width:{{min($project->progres_keseluruhan ?? 0,100)}}%">

</div>


</div>


</div>



</td>







<td>



@if(($project->progres_keseluruhan ?? 0) >= 100)


<span class="status selesai">

Selesai

</span>



@else


<span class="status berjalan">

Berjalan

</span>



@endif



</td>



</tr>





@empty


<tr>

<td colspan="4" align="center">

Belum ada project

</td>

</tr>


@endforelse



</tbody>


</table>


</div>









{{-- RINGKASAN EKSEKUTIF --}}


<div class="panel">


<h3>

📌 Ringkasan Eksekutif

</h3>




<div class="summary-grid">





<div class="summary-card">


<span>

Total Proyek

</span>



<h2>

{{$totalProject ?? 0}}

</h2>



<small>

Jumlah seluruh project

</small>


</div>







<div class="summary-card">


<span>

Rata-rata Progress

</span>



<h2>

{{number_format(
$progressProject ?? 0,
1
)}}%

</h2>



<small>

Perkembangan seluruh project

</small>


</div>








<div class="summary-card">


<span>

Saldo Perusahaan

</span>



<h2>

Rp {{number_format(
$saldo ?? 0,
0,
',',
'.'
)}}

</h2>



<small>

Dana tersedia saat ini

</small>


</div>








<div class="summary-card">


<span>

Total Transaksi

</span>



<h2>

{{$totalTransaksi ?? 0}}

</h2>



<small>

Jumlah transaksi keuangan

</small>


</div>




</div>



</div>





<style>

/* =====================================
   GLOBAL
===================================== */


*{

box-sizing:border-box;

}


body{

background:#f8fafc;

}



.report-header{

background:white;

padding:22px 25px;

border-radius:16px;

border:1px solid #e2e8f0;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:18px;

box-shadow:0 4px 12px rgba(15,23,42,.05);

}



.report-label{

font-size:11px;

font-weight:700;

letter-spacing:1.5px;

color:#64748b;

}



.report-header h1{

font-size:26px;

margin:8px 0;

color:#3b361e;

}



.report-header p{

margin:0;

font-size:14px;

color:#64748b;

}










/* =====================================
   FILTER
===================================== */


.report-filter{

background:white;

padding:18px;

border-radius:16px;

border:1px solid #e2e8f0;

display:flex;

gap:15px;

align-items:end;

margin-bottom:18px;

}



.report-filter div{

display:flex;

flex-direction:column;

gap:6px;

width:200px;

}



.report-filter label{

font-size:12px;

font-weight:700;

color:#64748b;

}



.report-filter input,
.report-filter select{

height:38px;

border-radius:10px;

border:1px solid #cbd5e1;

padding:0 12px;

font-size:13px;

}



.report-filter button{

height:38px;

padding:0 25px;

border:none;

border-radius:10px;

background:#334155;

color:white;

font-weight:700;

}






/* =====================================
   KPI
===================================== */


.kpi-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:18px;

}



.kpi-card{

background:white;

border:1px solid #e2e8f0;

border-radius:15px;

padding:18px;

height:115px;

display:flex;

flex-direction:column;

justify-content:center;

box-shadow:0 3px 10px rgba(15,23,42,.04);

}



.kpi-card span{

font-size:11px;

font-weight:700;

color:#64748b;

}



.kpi-card h2{

font-size:20px;

margin:8px 0;

font-weight:700;

}



.kpi-card small{

font-size:11px;

color:#94a3b8;

}



.income h2{

color:#16a34a;

}


.expense h2{

color:#dc2626;

}


.profit h2{

color:#8B5E22;

}


.project h2{

color:#2563eb;

}


.selesai-card h2{

color:#16a34a;

}


.warning-card h2{

color:#dc2626;

}


.progress-card h2{

color:#2563eb;

}







/* =====================================
 PANEL
===================================== */


.panel{

background:white;

padding:20px;

border-radius:16px;

border:1px solid #e2e8f0;

margin-bottom:18px;

box-shadow:0 3px 10px rgba(15,23,42,.04);

}



.panel h3{

font-size:16px;

margin:0 0 15px;

color:#1e293b;

}






/* =====================================
 FINANCE
===================================== */


.finance-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

}



.finance-grid div{

background:#f8fafc;

padding:18px;

border-radius:14px;

}



.finance-grid span{

display:block;

font-size:11px;

font-weight:700;

color:#64748b;

margin-bottom:8px;

}



.finance-grid b{

font-size:18px;

}



.green{

color:#16a34a!important;

}


.red{

color:#dc2626!important;

}






/* =====================================
 SUMMARY
===================================== */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

}



.summary-card{

background:#f8fafc;

border:1px solid #e2e8f0;

padding:18px;

border-radius:14px;

}



.summary-card span{

font-size:11px;

font-weight:700;

color:#64748b;

}



.summary-card h2{

font-size:21px;

margin:8px 0;

color:#1e293b;

}



.summary-card small{

font-size:11px;

color:#94a3b8;

}







/* =====================================
 CHART
===================================== */


.chart-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:15px;

}



.chart-card{

height:290px;

overflow:hidden;

}



.chart-card canvas{

height:210px!important;

width:100%!important;

}






/* =====================================
 REPORT CARD
===================================== */


.section-title{

font-size:18px;

margin:20px 0 15px;

color:#1e293b;

}



.report-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

}



.report-card{

background:white;

border:1px solid #e2e8f0;

border-radius:16px;

padding:20px;

height:270px;

display:flex;

flex-direction:column;

box-shadow:0 3px 10px rgba(15,23,42,.04);

}



.report-icon{

width:42px;

height:42px;

border-radius:12px;

background:#f8fafc;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

margin-bottom:15px;

}



.report-card h3{

font-size:17px;

margin-bottom:8px;

color:#1e293b;

}



.report-card p{

font-size:13px;

color:#64748b;

line-height:1.5;

flex:1;

}



.button-group{

display:flex;

gap:10px;

}



.button-group a{

padding:8px 15px;

border-radius:8px;

font-size:12px;

font-weight:700;

text-decoration:none;

}



.pdf{

background:#fee2e2;

color:#b91c1c;

}



.excel{

background:#dcfce7;

color:#15803d;

}






/* =====================================
 TABLE
===================================== */


table{

width:100%;

border-collapse:collapse;

}



thead{

background:#f8fafc;

}



th{

padding:12px;

font-size:11px;

color:#64748b;

}



td{

padding:12px;

font-size:13px;

border-bottom:1px solid #e2e8f0;

}




/* =====================================
 PROGRESS
===================================== */


.progress-box{

width:150px;

}



.progress-value{

font-size:12px;

font-weight:700;

margin-bottom:5px;

}



.progress-track{

height:7px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-fill{

height:100%;

background:#8B5E22;

}





/* =====================================
 STATUS
===================================== */


.status{

padding:5px 12px;

border-radius:20px;

font-size:11px;

font-weight:700;

}



.berjalan{

background:#dcfce7;

color:#15803d;

}



.selesai{

background:#dbeafe;

color:#1d4ed8;

}






/* =====================================
 RESPONSIVE
===================================== */


@media(max-width:1400px){


.kpi-grid,
.report-grid{

grid-template-columns:repeat(3,1fr);

}


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.kpi-grid,
.report-grid,
.summary-grid,
.finance-grid,
.chart-grid{

grid-template-columns:1fr;

}



.report-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



.report-filter{

flex-direction:column;

align-items:stretch;

}


.report-filter div{

width:100%;

}


}

</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


/*
|--------------------------------------------------------------------------
| GRAFIK KEUANGAN
|--------------------------------------------------------------------------
*/


const financeCanvas = document.getElementById(
    'financeChart'
);



if(financeCanvas){



new Chart(financeCanvas, {


type:'bar',



data:{


labels:[

'Pendapatan',

'Pengeluaran',

'Saldo Bersih'

],



datasets:[{


label:'Nominal',

data:[


{{ $totalPendapatan ?? 0 }},


{{ $totalPengeluaran ?? 0 }},


{{ $saldo ?? 0 }}


],


borderWidth:1


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



ticks:{



callback:function(value){



return 'Rp ' +

value.toLocaleString(
'id-ID'
);



}



}



}



}



}



});



}









/*
|--------------------------------------------------------------------------
| GRAFIK PROJECT
|--------------------------------------------------------------------------
*/


const projectCanvas = document.getElementById(
    'projectChart'
);



if(projectCanvas){



new Chart(projectCanvas, {



type:'bar',




data:{



labels:[


@forelse($projects ?? [] as $project)


"{{ $project->nama_proyek }}",


@empty


"Tidak ada project"


@endforelse


],





datasets:[{


label:'Progress',



data:[


@forelse($projects ?? [] as $project)


{{ $project->progres_keseluruhan ?? 0 }},


@empty


0


@endforelse


],



borderWidth:1


}]




},






options:{



responsive:true,


maintainAspectRatio:false,



indexAxis:'y',




plugins:{



legend:{


display:false


}



},





scales:{



x:{


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



});



}



</script>
@endsection