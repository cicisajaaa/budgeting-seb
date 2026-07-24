@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

<div>

<div class="welcome-label">
FINANCE REPORT
</div>


<h1>
Laporan Keuangan
</h1>


<p>
Monitoring pemasukan, pengeluaran, dan kondisi saldo perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Dana Masuk
</span>

<span>
✓ Pengeluaran
</span>

<span>
✓ Audit Keuangan
</span>

</div>

</div>



<div class="system-status">

<span></span>

Report Aktif

</div>


</div>







<!-- SUMMARY -->


<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
💰
</div>


<div>

<small>
Total Dana Masuk
</small>

<h2>
Rp {{number_format($totalIncome,0,',','.')}}
</h2>

</div>

</div>






<div class="summary-card">


<div class="summary-icon red">
📤
</div>


<div>

<small>
Total Pengeluaran
</small>

<h2>
Rp {{number_format($totalExpense,0,',','.')}}
</h2>

</div>

</div>






<div class="summary-card">


<div class="summary-icon blue">
💳
</div>


<div>

<small>
Saldo Akhir
</small>

<h2>
Rp {{number_format($balance,0,',','.')}}
</h2>

</div>

</div>






<div class="summary-card">


<div class="summary-icon purple">
📊
</div>


<div>

<small>
Jumlah Transaksi
</small>


<h2>

{{$totalDepositTransaction + $totalExpenseTransaction}}

</h2>


</div>

</div>


</div>









<!-- FILTER -->


<div class="glass-panel">


<div class="panel-title">

🔎 Filter Laporan

</div>




<form method="GET"
action="{{route('finance.report')}}"
class="filter-grid">



<div>

<label>
Tanggal Awal
</label>


<input 
type="date"
name="start_date"
value="{{$startDate}}">

</div>





<div>

<label>
Tanggal Akhir
</label>


<input 
type="date"
name="end_date"
value="{{$endDate}}">

</div>




<div class="filter-action">


<button>
🔎 Tampilkan
</button>



<a href="{{route('finance.report')}}">
Reset
</a>



<a href="{{route('finance.report.export')}}?start_date={{$startDate}}&end_date={{$endDate}}"
class="excel">

⬇ Export Excel

</a>


</div>


</form>


</div>









<!-- PENGELUARAN -->


<div class="glass-panel">


<div class="panel-title">

📤 Riwayat Pengeluaran

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
Jumlah
</th>

<th>
Bank
</th>

<th>
Disetujui Oleh
</th>

<th>
Catatan
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


<br>


<small>

{{$expense->pengajuanDana->judul ?? '-'}}

</small>


</td>






<td>

{{$expense->pengajuanDana->proyek->nama_proyek ?? '-'}}

</td>






<td>

{{$expense->pengajuanDana->divisi->nama_divisi ?? '-'}}

</td>






<td class="money">

Rp {{number_format($expense->jumlah,0,',','.')}}

</td>







<td>


{{$expense->rekeningBank->nama_bank ?? '-'}}


<br>


<small>

{{$expense->rekeningBank->nomor_rekening ?? ''}}

</small>


</td>








<td>


{{$expense->penyetuju->name ?? '-'}}


<br>


<small>


@if($expense->pengajuanDana->disetujui_pada)


{{\Carbon\Carbon::parse($expense->pengajuanDana->disetujui_pada)->format('d M Y H:i')}}


@endif


</small>


</td>







<td>


{{$expense->pengajuanDana->catatan_persetujuan ?? '-'}}


</td>


</tr>



@empty


<tr>

<td colspan="8" class="empty">

Belum ada pengeluaran

</td>

</tr>


@endforelse



</tbody>


</table>



</div>









<style>


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:30px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}


.welcome-label{

font-size:10px;

letter-spacing:2px;

font-weight:700;

opacity:.8;

}


.welcome-card h1{

font-size:28px;

margin:8px 0;

}


.welcome-card p{

font-size:13px;

}



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}


.welcome-tags span{

background:rgba(255,255,255,.2);

padding:7px 12px;

border-radius:20px;

font-size:11px;

}



.system-status{

background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-weight:700;

display:flex;

gap:8px;

align-items:center;

}


.system-status span{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

}





.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:18px;

margin-bottom:20px;

}




.summary-card{

background:white;

padding:20px;

border-radius:20px;

display:flex;

gap:15px;

align-items:center;

box-shadow:0 10px 30px rgba(0,0,0,.06);

}



.summary-card small{

color:#64748b;

}



.summary-card h2{

font-size:20px;

color:#166534;

}



.summary-icon{

width:45px;

height:45px;

border-radius:15px;

display:flex;

align-items:center;

justify-content:center;

background:#dcfce7;

}



.summary-icon.red{

background:#fee2e2;

}


.summary-icon.blue{

background:#dbeafe;

}


.summary-icon.purple{

background:#ede9fe;

}




.glass-panel{

background:white;

padding:22px;

border-radius:22px;

margin-bottom:20px;

}





.panel-title{

font-weight:700;

font-size:16px;

margin-bottom:18px;

}





.filter-grid{

display:flex;

gap:15px;

align-items:end;

}



.filter-grid div{

flex:1;

}



label{

display:block;

font-size:12px;

font-weight:600;

margin-bottom:7px;

}



input{

width:100%;

height:40px;

border-radius:10px;

border:1px solid #e2e8f0;

padding:0 12px;

}



.filter-action{

display:flex;

gap:8px;

}



.filter-action button,
.filter-action a{

padding:10px 15px;

border-radius:10px;

border:none;

background:#166534;

color:white;

text-decoration:none;

font-size:12px;

font-weight:700;

}



.filter-action a{

background:#f1f5f9;

color:#475569;

}



.filter-action .excel{

background:#22c55e;

color:white;

}





table{

width:100%;

border-collapse:collapse;

}



th{

padding:14px;

background:#f8fafc;

font-size:12px;

color:#64748b;

text-align:left;

}



td{

padding:14px;

font-size:13px;

border-bottom:1px solid #f1f5f9;

}



td small{

font-size:11px;

color:#94a3b8;

}



.money{

font-weight:700;

color:#dc2626;

}



.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}




@media(max-width:1100px){

.summary-grid{

grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:700px){

.summary-grid{

grid-template-columns:1fr;

}


.filter-grid{

flex-direction:column;

}

}


</style>


@endsection