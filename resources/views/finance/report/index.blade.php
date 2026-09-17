@extends('layouts.dashboard')

@section('content')


<div class="report-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


 <div>


<div class="welcome-label">
FINANCIAL REPORT
</div>


<h1>
Laporan Keuangan Perusahaan
</h1>


<p>
Monitoring pemasukan, pengeluaran, saldo dan aktivitas transaksi perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Finance Monitoring
</span>

<span>
✓ Transaction Report
</span>

<span>
✓ Audit Ready
</span>

</div>


</div>





</div>













{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">

🔎 Filter Periode Laporan

</div>




<form method="GET"
action="{{route('finance.report')}}"
class="filter-area">



<div>

<label>
Tanggal Mulai
</label>

<input type="date"
name="start_date"
value="{{$startDate}}">

</div>





<div>

<label>
Tanggal Akhir
</label>

<input type="date"
name="end_date"
value="{{$endDate}}">

</div>





<button class="btn-filter">

Tampilkan

</button>




<a href="{{route('finance.report.export',[
'start_date'=>$startDate,
'end_date'=>$endDate
])}}"
class="btn-export">
⬇ Export Excel
</a>

</form>


</div>









{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card">

<div class="summary-icon green">
💰
</div>


<div>

<label>
Total Pemasukan
</label>


<h2>
Rp {{number_format($totalCashIn,0,',','.')}}
</h2>


<small>
Pembayaran client
</small>


</div>


</div>







<div class="summary-card">

<div class="summary-icon red">
💸
</div>


<div>

<label>
Total Pengeluaran
</label>


<h2>
Rp {{number_format($totalCashOut,0,',','.')}}
</h2>


<small>
Dana digunakan
</small>


</div>


</div>







<div class="summary-card">

<div class="summary-icon gold">
🏦
</div>


<div>

<label>
Saldo Bersih
</label>


<h2>
Rp {{number_format($totalSaldoSistem ?? $totalBankSaldo,0,',','.')}}
</h2>


<small>
Keuangan tersedia
</small>


</div>


</div>







<div class="summary-card">

<div class="summary-icon navy">
📄
</div>


<div>

<label>
Total Transaksi
</label>


<h2>
{{$totalDepositTransaction 
+ $totalExpenseTransaction
+ $totalMutasiTransaction}}
</h2>


<small>
Aktivitas keuangan
</small>


</div>


</div>



</div>









{{-- ANALYSIS --}}


<div class="glass-panel">


<div class="panel-title">

    Financial Overview

</div>



<div class="overview-grid">



<div class="overview-item">

<span>
Dana Masuk
</span>


<strong class="income-text">

Rp {{number_format($totalCashIn,0,',','.')}}
</strong>


</div>





<div class="overview-item">

<span>
Dana Keluar
</span>


<strong class="expense-text">
Rp {{number_format($totalCashOut,0,',','.')}}
</strong>


</div>





<div class="overview-item">

<span>
Saldo Bank Aktif
</span>


<strong>

Rp {{number_format($totalSaldoSistem ?? 0,0,',','.')}}
</strong>


</div>



</div>





@php
$usage = $totalIncome > 0 
? min(($totalExpense/$totalIncome)*100,100)
: 0;
@endphp





<div class="usage-box">


<div class="usage-header">

<span>
Penggunaan Dana
</span>


<b>
{{round($usage)}}%
</b>


</div>



<div class="progress">

<div style="width:{{$usage}}%"></div>

</div>



<small>
Persentase penggunaan dana berdasarkan transaksi.
</small>



</div>




</div>









{{-- DEPOSIT --}}


<div class="glass-panel">


<div class="panel-title">

Riwayat Pembayaran Masuk

</div>


<div class="table-wrapper">

<table>


<thead>

<tr>

<th>
Tanggal
</th>


<th>
Project
</th>


<th>
Bank
</th>


<th>
Nominal
</th>


</tr>

</thead>



<tbody>


@forelse($deposits as $deposit)



<tr>

<td>

{{\Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y')}}

</td>


<td>

{{$deposit->proyek->nama_proyek ?? '-'}}

</td>


<td>

{{$deposit->rekeningBank->nama_bank ?? '-'}}

</td>


<td class="income-text">

+
Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

</td>


</tr>



@empty


<tr>

<td colspan="4"
class="empty">

Belum ada pembayaran

</td>

</tr>


@endforelse


</tbody>


</table>


</div>






</div>


{{-- EXPENSE --}}


<div class="glass-panel">

<div class="panel-title">

Riwayat Pengeluaran

</div>

<div class="table-wrapper">

<table>


<thead>

<tr>

<th>
Tanggal
</th>


<th>
Pemohon
</th>


<th>
Project
</th>


<th>
Divisi
</th>


<th>
Nominal
</th>


</tr>


</thead>



<tbody>


@forelse($expenses as $expense)


<tr>


<td>

{{\Carbon\Carbon::parse($expense->tanggal)->format('d M Y')}}

</td>


<td>

{{$expense->pengajuanDana->pengguna->name ?? '-'}}

</td>


<td>

{{$expense->pengajuanDana->proyek->nama_proyek ?? '-'}}

</td>


<td>

{{$expense->pengajuanDana->divisi->nama_divisi ?? '-'}}

</td>


<td class="expense-text">

-
Rp {{number_format($expense->jumlah,0,',','.')}}

</td>


</tr>


@empty


<tr>

<td colspan="5"
class="empty">

Belum ada pengeluaran

</td>

</tr>


@endforelse


</tbody>


</table>

</div>

</div>
<div class="glass-panel">

<div class="panel-title">
Riwayat Mutasi Keuangan
</div>

<div class="table-wrapper">

<table>

<thead>

<tr>
<th>Tanggal</th>
<th>Jenis</th>
<th>Nominal</th>
<th>Keterangan</th>
<th>Bank</th>
</tr>

</thead>


<tbody>

@forelse($mutasi as $item)

<tr>

<td>
{{\Carbon\Carbon::parse($item->tanggal)->format('d M Y')}}
</td>


<td>

@if($item->jenis=='masuk')

<span class="income-text">
+ Masuk
</span>

@else

<span class="expense-text">
- Keluar
</span>

@endif

</td>


<td>
Rp {{number_format($item->nominal,0,',','.')}}
</td>


<td>
{{$item->keterangan}}
</td>


<td>
{{$item->rekeningBank->nama_bank ?? '-'}}
</td>


</tr>


@empty

<tr>
<td colspan="5" class="empty">
Belum ada mutasi
</td>
</tr>


@endforelse


</tbody>


</table>

</div>

</div>








<style>

/* ===============================
GLOBAL
================================ */

.report-wrapper{
    width:100%;
}


/* ===============================
WELCOME
================================ */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:20px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:28px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    font-size:13px;

    color:#64748b;

}






.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:7px 14px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}







/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:24px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}






/* ===============================
FILTER
================================ */


.filter-area{

    display:flex;

    align-items:end;

    gap:15px;

}



.filter-area label{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



.filter-area input{

    height:42px;

    padding:0 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    font-size:12px;

}



.btn-filter,
.btn-export{


    height:42px;

    padding:0 18px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    border:none;

    cursor:pointer;

    text-decoration:none;

    display:flex;

    align-items:center;

}



.btn-filter{

    background:#1e293b;

    color:white;

}



.btn-filter:hover{

    background:#334155;

}



.btn-export{

    background:#dcfce7;

    color:#166534;

}








/* ===============================
SUMMARY CARD
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:18px;

    margin-bottom:20px;

}



.summary-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    position:relative;

    overflow:hidden;

}



.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.summary-icon{

    width:48px;

    height:48px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

}



.green{

    background:#dcfce7;

}


.red{

    background:#fee2e2;

}


.gold{

    background:#fef3c7;

}


.navy{

    background:#dbeafe;

}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:5px 0;

    font-size:19px;

    color:#172033;

    font-weight:800;

}



.summary-card small{

    font-size:10px;

    color:#94a3b8;

}








/* ===============================
OVERVIEW
================================ */


.overview-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

}



.overview-item{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:16px;

}



.overview-item span{

    display:block;

    font-size:11px;

    color:#64748b;

    margin-bottom:8px;

}



.overview-item strong{

    font-size:18px;

    color:#172033;

}



.income-text{

    color:#16a34a!important;

    font-weight:800;

}



.expense-text{

    color:#dc2626!important;

    font-weight:800;

}







/* ===============================
PROGRESS
================================ */


.usage-header{

    display:flex;

    justify-content:space-between;

    font-size:12px;

    font-weight:700;

}



.progress{

    height:10px;

    background:#e2e8f0;

    border-radius:999px;

    margin:12px 0;

    overflow:hidden;

}



.progress div{

    height:100%;

    background:#1e293b;

    border-radius:999px;

}





.usage-box small{

    color:#94a3b8;

    font-size:11px;

}






/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



thead th{

    background:#f8fafc;

    padding:14px;

    text-align:left;

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



tbody td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr:hover{

    background:#f8fafc;

}






.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}






/* ===============================
RESPONSIVE
================================ */

/* ===============================
   RESPONSIVE
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .overview-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .filter-area{
        flex-wrap:wrap;
    }

}


@media(max-width:900px){

    .welcome-card{
        padding:22px;
        border-radius:20px;
    }

    .welcome-card h1{
        font-size:23px;
        line-height:1.35;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
    }

    .welcome-tags{
        flex-wrap:wrap;
        gap:7px;
    }

    .welcome-tags span{
        font-size:9px;
        padding:6px 10px;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
    }


    .filter-area{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
        align-items:end;
    }

    .filter-area > div{
        width:100%;
    }

    .filter-area input{
        width:100%;
        box-sizing:border-box;
    }

    .btn-filter,
    .btn-export{
        width:100%;
        justify-content:center;
        box-sizing:border-box;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        padding:15px;
        gap:11px;
        min-width:0;
    }

    .summary-icon{
        width:42px;
        height:42px;
        border-radius:12px;
        font-size:17px;
        flex-shrink:0;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }

    .summary-card label{
        font-size:9px;
    }

    .summary-card small{
        font-size:8px;
    }


    .overview-grid{
        grid-template-columns:1fr;
    }

    .overview-item{
        padding:15px;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    table{
        min-width:700px;
    }

    thead th,
    tbody td{
        white-space:nowrap;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        margin-bottom:15px;
        border-radius:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
    }

    .welcome-card p{
        font-size:10px;
    }

    .welcome-tags{
        margin-top:11px;
    }

    .welcome-tags span{
        font-size:8px;
        padding:5px 8px;
    }


    .glass-panel{
        padding:14px;
        margin-bottom:14px;
        border-radius:17px;
    }

    .panel-title{
        font-size:13px;
        margin-bottom:15px;
    }


    .filter-area{
        grid-template-columns:1fr;
        gap:10px;
    }

    .filter-area label{
        font-size:9px;
    }

    .filter-area input{
        height:40px;
        font-size:11px;
    }

    .btn-filter,
    .btn-export{
        height:40px;
        font-size:10px;
    }


    .summary-grid{
        grid-template-columns:1fr;
        gap:10px;
    }

    .summary-card{
        padding:13px;
        border-radius:16px;
    }

    .summary-icon{
        width:36px;
        height:36px;
        border-radius:10px;
        font-size:15px;
    }

    .summary-card label{
        font-size:8px;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0;
    }

    .summary-card small{
        font-size:7px;
    }


    .overview-grid{
        grid-template-columns:1fr;
        gap:9px;
    }

    .overview-item{
        padding:13px;
        border-radius:13px;
    }

    .overview-item span{
        font-size:9px;
        margin-bottom:6px;
    }

    .overview-item strong{
        font-size:16px;
    }


    .usage-header{
        font-size:10px;
    }

    .usage-box small{
        font-size:9px;
    }

    .progress{
        height:8px;
        margin:9px 0;
    }


    .table-wrapper{
        margin:0 -2px;
    }

    table{
        min-width:700px;
    }

    thead th{
        padding:11px;
        font-size:9px;
    }

    tbody td{
        padding:11px;
        font-size:10px;
    }

}

/* ===============================
   MOBILE TABLE & WIDTH FIX
================================ */

.report-wrapper,
.glass-panel,
.summary-grid,
.summary-card,
.overview-grid,
.overview-item,
.filter-area{
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}

.summary-card > div:last-child{
    min-width:0;
}

.summary-card h2,
.summary-card label,
.summary-card small{
    overflow-wrap:anywhere;
}

.filter-area input{
    max-width:100%;
    box-sizing:border-box;
}

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    box-sizing:border-box;
}

.table-wrapper table{
    min-width:700px;
}

@media(max-width:600px){

    .report-wrapper{
        width:100%;
        max-width:100%;
        overflow:hidden;
    }

    .glass-panel{
        width:100%;
        max-width:100%;
        overflow:hidden;
    }

    .filter-area{
        width:100%;
        max-width:100%;
    }

    .filter-area > div,
    .filter-area button,
    .filter-area a{
        width:100%;
        max-width:100%;
        box-sizing:border-box;
    }

    .summary-grid{
        width:100%;
        max-width:100%;
    }

    .summary-card{
        width:100%;
        max-width:100%;
    }

    .overview-grid{
        width:100%;
        max-width:100%;
    }

    .table-wrapper{
        width:100%;
        max-width:100%;
        margin:0;
        padding-bottom:4px;
    }

    .table-wrapper table{
        min-width:700px;
    }

}



/* =========================================
   FINAL MOBILE REPORT FIX
========================================= */

.report-wrapper {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.glass-panel,
.welcome-card,
.summary-grid,
.summary-card,
.overview-grid,
.overview-item {
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

/* FILTER */
.filter-area {
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.filter-area > div {
    min-width: 0;
}

.filter-area input {
    max-width: 100%;
    box-sizing: border-box;
}

/* SUMMARY */
.summary-card > div:last-child {
    min-width: 0;
    overflow: hidden;
}

.summary-card h2 {
    max-width: 100%;
    overflow-wrap: anywhere;
}

/* TABLE CONTAINER */
.table-wrapper {
    display: block;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    overflow-x: auto;
    overflow-y: hidden;
    box-sizing: border-box;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}

/* TABLE */
.table-wrapper table {
    width: 100%;
    min-width: 680px;
    margin: 0;
}

/* TABLE CELLS */
.table-wrapper th,
.table-wrapper td {
    white-space: nowrap;
}

/* =========================================
   MOBILE
========================================= */

@media (max-width: 600px) {

    .report-wrapper {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .welcome-card {
        width: 100%;
        padding: 16px;
        margin-bottom: 12px;
        border-radius: 16px;
    }

    .welcome-card h1 {
        font-size: 18px;
        line-height: 1.3;
        margin: 6px 0;
    }

    .welcome-card p {
        font-size: 10px;
        line-height: 1.5;
        margin: 0;
    }

    .welcome-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
    }

    .welcome-tags span {
        font-size: 8px;
        padding: 5px 8px;
    }

    /* PANEL */

    .glass-panel {
        width: 100%;
        max-width: 100%;
        padding: 13px;
        margin-bottom: 12px;
        border-radius: 16px;
        box-sizing: border-box;
    }

    .panel-title {
        font-size: 12px;
        margin-bottom: 12px;
    }

    /* FILTER */

    .filter-area {
        display: flex;
        flex-direction: column;
        gap: 9px;
        width: 100%;
    }

    .filter-area > div {
        width: 100%;
    }

    .filter-area label {
        display: block;
        font-size: 9px;
        margin-bottom: 5px;
    }

    .filter-area input {
        width: 100%;
        height: 39px;
        font-size: 11px;
        padding: 0 11px;
    }

    .btn-filter,
    .btn-export {
        width: 100%;
        height: 39px;
        justify-content: center;
        box-sizing: border-box;
        font-size: 10px;
    }

    /* SUMMARY */

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 9px;
        width: 100%;
    }

    .summary-card {
        width: 100%;
        padding: 12px;
        border-radius: 15px;
    }

    .summary-icon {
        width: 35px;
        height: 35px;
        min-width: 35px;
        border-radius: 9px;
        font-size: 14px;
    }

    .summary-card label {
        font-size: 8px;
    }

    .summary-card h2 {
        font-size: 15px;
        line-height: 1.3;
        margin: 3px 0;
    }

    .summary-card small {
        font-size: 7px;
    }

    /* OVERVIEW */

    .overview-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .overview-item {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
    }

    .overview-item span {
        font-size: 9px;
        margin-bottom: 5px;
    }

    .overview-item strong {
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    /* USAGE */

    .usage-header {
        font-size: 10px;
    }

    .usage-box small {
        display: block;
        font-size: 8px;
        line-height: 1.4;
    }

    /* TABLE */

    .table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        margin: 0;
        padding-bottom: 5px;
    }

    .table-wrapper table {
        min-width: 680px;
    }

    .table-wrapper th {
        padding: 10px;
        font-size: 9px;
    }

    .table-wrapper td {
        padding: 10px;
        font-size: 9px;
    }

}

/* =========================================
   SMALL PHONE
========================================= */

@media (max-width: 380px) {

    .glass-panel {
        padding: 11px;
    }

    .welcome-card {
        padding: 14px;
    }

    .welcome-card h1 {
        font-size: 17px;
    }

    .summary-card h2 {
        font-size: 14px;
    }

    .table-wrapper table {
        min-width: 650px;
    }

}



/* JARAK ANTAR PANEL RIWAYAT */

.glass-panel + .glass-panel {
    margin-top: 20px;
}

@media (max-width: 600px) {

    .glass-panel + .glass-panel {
        margin-top: 14px;
    }

}
</style>



@endsection