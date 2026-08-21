@extends('layouts.dashboard')

@section('content')


{{-- HEADER --}}

<div class="dashboard-header">

<span class="label">
LAPORAN PERUSAHAAN
</span>


<h1>
Laporan Perusahaan
</h1>


<p>
Ringkasan kondisi keuangan, proyek, dan performa bisnis perusahaan.
</p>


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


<h2 class="green">

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


<h2 class="red">

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


<h2 class="green">

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


<h2 class="blue">

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


<h2 class="green">

{{$totalProjectSelesai ?? 0}}

</h2>


<small>
Project selesai
</small>

</div>




<div class="kpi-card warning-card">

<span>
Project Terlambat
</span>


<h2 class="red">

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


<h2 class="blue">

{{number_format(
$rataProgress ?? 0,
1
)}}%

</h2>


<small>
Perkembangan project
</small>

</div>




<div class="kpi-card transaction-card">
<span>
Total Transaksi
</span>


<h2 class="purple">

{{$totalTransaksi ?? 0}}

</h2>


<small>
Jumlah transaksi
</small>

</div>


</div>







{{-- ANALISIS --}}


<div class="panel">


<h3>
Analisis Performa Perusahaan
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
Nilai seluruh project
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
Sedang dikerjakan
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
Efisiensi penggunaan dana
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
Saldo akhir
</small>

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
📄
</div>


<h3>
Laporan Perusahaan
</h3>


<p>
Ringkasan keseluruhan kondisi perusahaan.
</p>



<div class="button-group">


<a href="{{route('owner.report.pdf',[
'start_date'=>request('start_date'),
'end_date'=>request('end_date')
])}}"
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
Pemasukan, pengeluaran, saldo dan transaksi.
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
Detail project, anggaran, progress dan status.
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
Evaluasi perkembangan bisnis perusahaan.
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


<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}



/* ===============================
HEADER
================================ */


.dashboard-header{

    background:#f8fafc;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.dashboard-header h1{

    margin:8px 0;

    font-size:24px;

    color:#172033;

    font-weight:800;

}



.dashboard-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
FILTER
================================ */


.report-filter{

    background:white;

    padding:20px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:
    0 8px 20px rgba(15,23,42,.04);

    display:flex;

    gap:15px;

    align-items:end;

    margin-bottom:22px;

}



.report-filter div{

    flex:1;

}



.report-filter label{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:6px;

}



.report-filter input,
.report-filter select{

    width:100%;

    height:40px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    padding:0 12px;

    font-size:12px;

}



.report-filter button{

    height:40px;

    padding:0 22px;

    border:none;

    border-radius:12px;

    background:#0f172a;

    color:white;

    font-size:12px;

    font-weight:700;

}







/* ===============================
KPI GRID
================================ */


.kpi-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:22px;

}



.kpi-card{

    background:white;

    padding:18px;

    min-height:110px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

    position:relative;

    overflow:hidden;

}



.kpi-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.kpi-card span{

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.kpi-card h2{

    margin:8px 0;

    font-size:20px;

    font-weight:800;

    color:#172033;

}



.kpi-card small{

    font-size:11px;

    color:#94a3b8;

}




.income::before{

background:#16a34a;

}


.expense::before{

background:#dc2626;

}


.profit::before{

background:#2563eb;

}


.project::before{

background:#f59e0b;

}


.selesai-card::before{

background:#16a34a;

}


.warning-card::before{

background:#dc2626;

}


.progress-card::before{

background:#2563eb;

}


.transaction-card::before{

background:#7c3aed;

}







/* ===============================
PANEL
================================ */


.panel{

    background:white;

    padding:22px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

    margin-bottom:22px;

}



.panel h3{

    margin:0 0 18px;

    font-size:16px;

    font-weight:800;

    color:#172033;

}







/* ===============================
ANALYSIS SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

}



.summary-card{

    background:#f8fafc;

    padding:18px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}



.summary-card span{

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.summary-card h2{

    margin:8px 0;

    font-size:18px;

    color:#172033;

}



.summary-card small{

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
REPORT CENTER
================================ */


.section-title{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin:22px 0 15px;

}



.report-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

}



.report-card{

    background:white;

    padding:20px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

    min-height:230px;

    display:flex;

    flex-direction:column;

}



.report-icon{

    width:42px;

    height:42px;

    background:#f8fafc;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    margin-bottom:14px;

}



.report-card h3{

    font-size:15px;

    margin:0 0 8px;

    color:#172033;

}



.report-card p{

    font-size:12px;

    color:#64748b;

    line-height:1.5;

    flex:1;

}







/* ===============================
BUTTON
================================ */


.button-group{

    display:flex;

    gap:8px;

}



.button-group a{

    padding:8px 14px;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.pdf{

    background:#fee2e2;

    color:#b91c1c;

}



.excel{

    background:#dcfce7;

    color:#166534;

}







/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:12px;

    background:#f8fafc;

    text-align:left;

    font-size:11px;

    color:#64748b;

}



td{

    padding:12px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

}







/* ===============================
COLOR
================================ */


.green{

    color:#16a34a!important;

}


.red{

    color:#dc2626!important;

}


.blue{

    color:#2563eb!important;

}


.purple{

    color:#7c3aed!important;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){

.kpi-grid,
.report-grid,
.summary-grid{

    grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:700px){

.kpi-grid,
.report-grid,
.summary-grid{

    grid-template-columns:1fr;

}



.report-filter{

    flex-direction:column;

    align-items:stretch;

}

}


</style>



@endsection