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


.report-wrapper{

width:100%;

}



.welcome-card{

background:white;

padding:28px;

border-radius:20px;

border:1px solid #e2e8f0;

display:flex;

justify-content:space-between;

margin-bottom:20px;

}



.welcome-label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

color:#64748b;

}



.welcome-card h1{

color:#6b4f1d;

font-size:28px;

margin:8px 0;

}



.welcome-card p{

color:#64748b;

font-size:13px;

}



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:#fff7db;

padding:7px 12px;

border-radius:20px;

font-size:11px;

color:#6b4f1d;

font-weight:600;

}



.report-status{

background:#fff7db;

padding:10px 18px;

border-radius:20px;

height:max-content;

color:#6b4f1d;

font-weight:700;

font-size:13px;

}



.report-status span{

display:inline-block;

width:8px;

height:8px;

background:#16a34a;

border-radius:50%;

margin-right:8px;

}





.glass-panel{

background:white;

padding:22px;

border-radius:20px;

border:1px solid #e2e8f0;

margin-bottom:20px;

}



.panel-title{

font-weight:700;

font-size:16px;

margin-bottom:18px;

}




.filter-area{

display:flex;

gap:15px;

align-items:end;

}



label{

font-size:12px;

color:#64748b;

display:block;

margin-bottom:6px;

}



input{

padding:11px;

border-radius:12px;

border:1px solid #e2e8f0;

}



.btn-filter,
.btn-export{

padding:8px 14px;

border-radius:10px;

border:none;

font-size:12px;

font-weight:600;

text-decoration:none;

cursor:pointer;

display:inline-flex;

align-items:center;

justify-content:center;

height:38px;

}


.btn-filter{

background:#6b4f1d;

color:white;

}



.btn-export{

background:#dcfce7;

color:#166534;

padding:8px 13px;

}





.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:20px;

}



.summary-card{

background:white;

border:1px solid #e2e8f0;

padding:18px;

border-radius:18px;

display:flex;

gap:12px;

align-items:center;

}



.summary-icon{

width:45px;

height:45px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

}



.green{

background:#dcfce7;

}



.red{

background:#fee2e2;

}



.gold{

background:#fff7db;

}



.navy{

background:#e0e7ff;

}




.summary-card h2{

font-size:18px;

color:#6b4f1d;

}





.overview-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

}



.overview-item{

background:#faf7ef;

padding:15px;

border-radius:15px;

}



.overview-item span{

display:block;

font-size:12px;

color:#64748b;

}



.overview-item strong{

font-size:18px;

}





.income-text{

color:#16a34a;

font-weight:700;

}



.expense-text{

color:#dc2626;

font-weight:700;

}



.usage-box{

margin-top:20px;

}



.usage-header{

display:flex;

justify-content:space-between;

}



.progress{

height:10px;

background:#f1f5f9;

border-radius:20px;

margin:10px 0;

}



.progress div{

height:100%;

background:#6b4f1d;

border-radius:20px;

}





table{

width:100%;

border-collapse:collapse;

}



th{

background:#faf7ef;

padding:14px;

text-align:left;

font-size:12px;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

font-size:13px;

}



.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}





@media(max-width:1000px){

.summary-grid{

grid-template-columns:repeat(2,1fr);

}


.overview-grid{

grid-template-columns:1fr;

}

}



</style>



@endsection