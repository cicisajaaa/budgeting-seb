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


<div class="report-status">

<span></span>
Sistem Aktif

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


<input type="date"
name="start_date"
value="{{request('start_date')}}">


</div>




<div>

<label>
Tanggal Akhir
</label>


<input type="date"
name="end_date"
value="{{request('end_date')}}">


</div>




<button>

Tampilkan

</button>



</form>









{{-- KPI --}}


<div class="kpi-grid">


<div class="kpi-card">


<span>
Total Pendapatan
</span>


<h2>
Rp {{number_format($totalPendapatan ?? 0,0,',','.')}}
</h2>


<small>
Pemasukan perusahaan
</small>


</div>






<div class="kpi-card">


<span>
Total Pengeluaran
</span>


<h2>
Rp {{number_format($totalPengeluaran ?? 0,0,',','.')}}
</h2>


<small>
Dana digunakan
</small>


</div>







<div class="kpi-card">


<span>
Profit Bersih
</span>


<h2>
Rp {{number_format($profit ?? 0,0,',','.')}}
</h2>


<small>
Keuntungan perusahaan
</small>


</div>







<div class="kpi-card">


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

Rp {{number_format($totalPendapatan ?? 0,0,',','.')}}

</b>


</div>




<div>

<span>
Pengeluaran
</span>


<b class="red">

Rp {{number_format($totalPengeluaran ?? 0,0,',','.')}}

</b>


</div>




<div>

<span>
Saldo Bersih
</span>


<b>

Rp {{number_format($saldo ?? 0,0,',','.')}}

</b>


</div>



</div>



</div>









{{-- PUSAT LAPORAN --}}


<h2 class="section-title">

Pusat Laporan

</h2>





<div class="report-grid">



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
{{$project->nama_proyek}}
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

{{$project->progres_keseluruhan ?? 0}}%

</td>




<td>


@if(($project->progres_keseluruhan ?? 0)>=100)


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









{{-- SUMMARY --}}


<div class="panel">


<h3>
Ringkasan Eksekutif
</h3>



<div class="summary-row">


<span>
Total Proyek
</span>


<b>
{{$totalProject ?? 0}} Proyek
</b>


</div>





<div class="summary-row">


<span>
Rata-rata Progress
</span>


<b>
{{number_format($progressProject ?? 0,1)}}%
</b>


</div>





<div class="summary-row">


<span>
Saldo Perusahaan
</span>


<b>
Rp {{number_format($saldo ?? 0,0,',','.')}}
</b>


</div>



</div>








<style>

/* HEADER */

.report-header{

background:white;
padding:30px;
border-radius:20px;
border:1px solid #e2e8f0;
box-shadow:0 5px 20px rgba(15,23,42,.05);
margin-bottom:25px;

display:flex;
justify-content:space-between;
align-items:center;

}


.report-label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

color:#b08732;

text-transform:uppercase;

}



.report-header h1{

font-size:30px;
margin:10px 0;
color:#3b361e;

}



.report-header p{

color:#64748b;

}



.report-status{

background:#dcfce7;
color:#166534;

padding:10px 15px;

border-radius:20px;

font-size:12px;

font-weight:600;

}





/* FILTER */


.report-filter{

background:white;

padding:20px;

border-radius:18px;

border:1px solid #e2e8f0;

display:flex;

gap:15px;

align-items:end;

margin-bottom:25px;

}



.report-filter label{

display:block;

font-size:12px;

color:#64748b;

margin-bottom:6px;

}



.report-filter input,
.report-filter select{

height:40px;

border-radius:10px;

border:1px solid #cbd5e1;

padding:0 12px;

}



.report-filter button{

height:40px;

background:#334155;

color:white;

border:none;

border-radius:10px;

padding:0 20px;

font-weight:600;

}





/* KPI */


.kpi-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:25px;

}



.kpi-card{

background:white;

padding:22px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:0 5px 15px rgba(15,23,42,.04);

}



.kpi-card span{

font-size:12px;

color:#64748b;

}



.kpi-card h2{

margin-top:10px;

font-size:24px;

color:#1e293b;

}



.kpi-card small{

color:#94a3b8;

}





/* PANEL */


.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:25px;

}



.panel h3{

color:#1e293b;

margin-bottom:20px;

}





/* FINANCE */


.finance-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:20px;

}



.finance-grid div{

background:#f8fafc;

padding:20px;

border-radius:15px;

}



.finance-grid span{

font-size:12px;

color:#64748b;

display:block;

}



.finance-grid b{

font-size:20px;

color:#1e293b;

}



.green{

color:#16a34a!important;

}


.red{

color:#dc2626!important;

}





/* REPORT CARD */


.section-title{

font-size:18px;

color:#1e293b;

margin-bottom:20px;

}



.report-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:20px;

margin-bottom:25px;

}



.report-card{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

}



.report-icon{

font-size:30px;

margin-bottom:15px;

}



.report-card h3{

color:#1e293b;

}



.report-card p{

font-size:13px;

color:#64748b;

line-height:1.6;

}





.button-group{

display:flex;

gap:10px;

margin-top:20px;

}



.button-group a{

padding:9px 15px;

border-radius:10px;

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







/* TABLE PROJECT */


table{

width:100%;

border-collapse:collapse;

}



th{

padding:15px;

text-align:left;

font-size:12px;

color:#64748b;

}



td{

padding:15px;

border-bottom:1px solid #e2e8f0;

font-size:13px;

}



.status{

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}



.berjalan{

background:#dcfce7;

color:#15803d;

}



.selesai{

background:#dbeafe;

color:#1d4ed8;

}





/* SUMMARY */


.summary-row{

display:flex;

justify-content:space-between;

padding:15px 0;

border-bottom:1px solid #e2e8f0;

}



.summary-row b{

color:#1e293b;

}





@media(max-width:1000px){


.kpi-grid,
.report-grid{

grid-template-columns:1fr;

}



.finance-grid{

grid-template-columns:1fr;

}



.report-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



}
/* OVERRIDE OWNER REPORT COLOR */

.report-header *,
.report-filter *,
.kpi-card *,
.panel *,
.report-card *,
.summary-row *{

    font-family: inherit;

}




.kpi-card h2,
.summary-row b,
.finance-grid b{

    color:#1e293b!important;

}


.report-filter button{

    background:#334155!important;

}


.section-title{

    color:#1e293b!important;

}


.report-card h3,
.panel h3{

    color:#1e293b!important;

}


</style>

@endsection