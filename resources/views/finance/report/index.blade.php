@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<div class="welcome-label">

LAPORAN KEUANGAN

</div>



<h1>

Monitoring Keuangan Perusahaan

</h1>



<p>

Rekap pemasukan, pengeluaran, dan kondisi saldo perusahaan.

</p>




<div class="welcome-tags">


<span>
✓ Dana Masuk
</span>


<span>
✓ Pengeluaran
</span>


<span>
✓ Saldo Aktif
</span>


</div>



</div>





<div class="system-status">

<span></span>

Finance Report

</div>



</div>









<!-- SUMMARY -->


<div class="finance-grid">



<div class="finance-card">


<div class="finance-icon green">

💰

</div>


<div>


<label>

Total Dana Masuk

</label>


<h2>

Rp {{number_format($totalIncome,0,',','.')}}

</h2>


<small>

Pembayaran project

</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon red">

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







<div class="finance-card">


<div class="finance-icon blue">

🏦

</div>


<div>


<label>

Saldo Akhir

</label>


<h2>

Rp {{number_format($balance,0,',','.')}}

</h2>


<small>

Dana tersedia

</small>


</div>


</div>



</div>









<!-- DETAIL SUMMARY -->


<div class="finance-grid">





<div class="finance-card">


<div class="finance-icon blue">

📥

</div>


<div>


<label>

Jumlah Pemasukan

</label>


<h2>

{{$deposits->count()}}

</h2>


<small>

Transaksi masuk

</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon red">

📤

</div>


<div>


<label>

Jumlah Pengeluaran

</label>


<h2>

{{$expenses->count()}}

</h2>


<small>

Transaksi keluar

</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon green">

📊

</div>


<div>


<label>

Efisiensi Dana

</label>



<h2>


@if($totalIncome > 0)

{{round(($balance/$totalIncome)*100)}}%

@else

0%

@endif


</h2>


<small>

Sisa dana tersedia

</small>


</div>


</div>






</div>









<!-- EXPORT -->


<div class="glass-panel">


<div class="panel-header">


<div>


<div class="panel-title">

📄 Laporan Keuangan

</div>



<small>

Data pemasukan dan pengeluaran perusahaan

</small>



</div>




<a href="{{route('finance.report.export')}}"
class="export-btn">


⬇ Export Excel


</a>



</div>



</div>









<!-- PEMASUKAN -->


<div class="glass-panel">


<div class="panel-title">

💰 Riwayat Dana Masuk

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

{{$deposit->project->nama_project ?? '-'}}

</td>




<td class="income">

+

Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

</td>



</tr>




@empty



<tr>

<td colspan="3" class="empty">

Belum ada pemasukan

</td>


</tr>



@endforelse




</tbody>



</table>



</div>









<!-- PENGELUARAN -->


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

{{$expense->request->user->name ?? '-'}}

</td>





<td>

{{$expense->request->project->nama_project ?? '-'}}

</td>





<td>

{{$expense->request->division->nama_divisi ?? '-'}}

</td>





<td class="expense">

-

Rp {{number_format($expense->jumlah,0,',','.')}}

</td>



</tr>



@empty



<tr>

<td colspan="5" class="empty">

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


margin-bottom:22px;


}





.welcome-label{


font-size:10px;


font-weight:700;


letter-spacing:2px;


opacity:.8;


}





.welcome-card h1{


font-size:28px;


margin:8px 0;


}





.welcome-card p{


font-size:13px;


opacity:.9;


}





.welcome-tags{


display:flex;


gap:10px;


margin-top:18px;


}





.welcome-tags span{


background:rgba(255,255,255,.15);


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


align-items:center;


gap:8px;


}




.system-status span{


width:9px;


height:9px;


background:#22c55e;


border-radius:50%;


}








.finance-grid{


display:grid;


grid-template-columns:repeat(3,1fr);


gap:18px;


margin-bottom:22px;


}






.finance-card{


background:white;


border-radius:20px;


padding:18px;


display:flex;


align-items:center;


gap:15px;


box-shadow:0 10px 30px rgba(0,0,0,.06);


}






.finance-icon{


width:45px;


height:45px;


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



.blue{

background:#dbeafe;

}







.finance-card label{


font-size:12px;


color:#64748b;


}



.finance-card h2{


font-size:18px;


color:#166534;


margin-top:5px;


}





.finance-card small{


font-size:11px;


color:#94a3b8;


}







.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:blur(15px);


border-radius:22px;


padding:22px;


margin-bottom:20px;


border:1px solid rgba(255,255,255,.8);


}





.panel-header{


display:flex;


justify-content:space-between;


align-items:center;


}





.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:10px;


}







.export-btn{


background:#166534;


color:white;


padding:11px 18px;


border-radius:14px;


text-decoration:none;


font-size:13px;


font-weight:600;


}





.export-btn:hover{


background:#22c55e;


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


background:#f8fafc;


}





td{


padding:14px;


border-bottom:1px solid #f1f5f9;


font-size:13px;


}





.income{


color:#16a34a;


font-weight:700;


}





.expense{


color:#dc2626;


font-weight:700;


}





.empty{


text-align:center;


padding:30px;


color:#94a3b8;


}





@media(max-width:900px){


.finance-grid{


grid-template-columns:1fr;


}



table{


display:block;


overflow-x:auto;


}



.welcome-card{


flex-direction:column;


align-items:flex-start;


gap:20px;


}



}



</style>



@endsection