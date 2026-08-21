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




<a href="{{route('finance.report.export')}}"
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
Rp {{number_format($totalIncome,0,',','.')}}
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
Rp {{number_format($totalExpense,0,',','.')}}
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
Rp {{number_format($balance,0,',','.')}}
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
{{$totalDepositTransaction + $totalExpenseTransaction}}
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

📊 Financial Overview

</div>



<div class="overview-grid">



<div class="overview-item">

<span>
Dana Masuk
</span>


<strong class="income-text">

Rp {{number_format($totalIncome,0,',','.')}}
</strong>


</div>





<div class="overview-item">

<span>
Dana Keluar
</span>


<strong class="expense-text">

Rp {{number_format($totalExpense,0,',','.')}}
</strong>


</div>





<div class="overview-item">

<span>
Saldo Bank Aktif
</span>


<strong>

Rp {{number_format($totalBankSaldo ?? 0,0,',','.')}}
</strong>


</div>



</div>





@php

$usage = $totalIncome > 0 
? ($totalExpense/$totalIncome)*100 
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

💰 Riwayat Pembayaran Masuk

</div>




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









{{-- EXPENSE --}}


<div class="glass-panel">


<div class="panel-title">

💸 Riwayat Pengeluaran

</div>




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


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:800px){


.summary-grid,
.overview-grid{

    grid-template-columns:1fr;

}



.filter-area{

    flex-direction:column;

    align-items:flex-start;

}



.welcome-card{

    padding:22px;

}



table{

    display:block;

    overflow-x:auto;

}


}


</style>



@endsection