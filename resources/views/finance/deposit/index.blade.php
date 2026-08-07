@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
PEMBAYARAN MASUK
</div>


<h1>
Kelola Pembayaran Client
</h1>


<p>
Monitoring pembayaran project yang masuk dan transaksi keuangan perusahaan.
</p>


</div>




<a href="{{route('finance.deposit.create')}}" class="btn-add">

+ Tambah Pembayaran

</a>



</div>















@if($errors->any())

<div class="error-box">

<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>

</div>

@endif







{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card">


<div class="summary-icon">
💰
</div>


<div>

<label>
Total Dana Masuk
</label>


<h2>
Rp {{number_format($totalDeposit ?? 0,0,',','.')}}
</h2>


<small>
Seluruh pembayaran
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
📄
</div>


<div>

<label>
Total Transaksi
</label>


<h2>
{{$totalTransaction ?? 0}}
</h2>


<small>
Pembayaran masuk
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
📁
</div>


<div>

<label>
Project Terbayar
</label>


<h2>
{{$totalProject ?? 0}}
</h2>


<small>
Project aktif
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
🏦
</div>


<div>

<label>
Rekening Digunakan
</label>


<h2>
{{$totalBank ?? 0}}
</h2>


<small>
Bank penerima
</small>


</div>


</div>



</div>









{{-- TABLE --}}



<div class="glass-panel">


<div class="panel-header">


<div>


<div class="panel-title">

📄 Riwayat Pembayaran

</div>


<small>
Daftar seluruh pembayaran client
</small>


</div>





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


<th>
Status
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

<strong>

{{$deposit->proyek->nama_proyek ?? '-'}}

</strong>

</td>





<td>

{{$deposit->rekeningBank->nama_bank ?? '-'}}

</td>





<td class="income">

+

Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

</td>





<td>

<span class="status-success">

Berhasil

</span>

</td>



</tr>




@empty



<tr>

<td colspan="5" class="empty">

Belum ada pembayaran masuk

</td>

</tr>



@endforelse




</tbody>


</table>



</div>









<style>


/* HEADER */


.welcome-card{

background:white;

padding:28px;

border-radius:12px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

border:1px solid #e2e8f0;

}



.welcome-label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#64748b;

}



.welcome-card h1{

font-size:28px;

color:#5b3a16;

margin:8px 0;

}



.welcome-card p{

font-size:13px;

color:#64748b;

}





.btn-add,
.btn-small{

background:#6b4f1d;

color:white;

padding:12px 18px;

border-radius:10px;

text-decoration:none;

font-size:13px;

font-weight:600;

}



.btn-add:hover,
.btn-small:hover{

background:#8b6b2e;

}









/* ALERT */


.success-box{

background:#fff7db;

color:#6b4f1d;

padding:15px;

border-radius:12px;

margin-bottom:20px;

font-weight:600;

}



.error-box{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:12px;

margin-bottom:20px;

}









/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:20px;

}



.summary-card{

background:white;

padding:20px;

border-radius:12px;

border:1px solid #e2e8f0;

display:flex;

align-items:center;

gap:15px;

}



.summary-icon{

width:45px;

height:45px;

background:#fff7db;

border-radius:12px;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

}



.summary-card label{

font-size:12px;

color:#64748b;

}



.summary-card h2{

font-size:18px;

color:#5b3a16;

margin-top:5px;

}



.summary-card small{

color:#94a3b8;

font-size:11px;

}









/* PANEL */


.glass-panel{

background:white;

padding:22px;

border-radius:12px;

border:1px solid #e2e8f0;

}



.panel-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:18px;

}



.panel-title{

font-size:16px;

font-weight:700;

}



.panel-header small{

color:#94a3b8;

font-size:12px;

}









/* TABLE */


table{

width:100%;

border-collapse:collapse;

}



th{

padding:14px;

background:#f8fafc;

text-align:left;

font-size:12px;

color:#64748b;

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



.status-success{

background:#dcfce7;

color:#166534;

padding:6px 12px;

border-radius:20px;

font-size:11px;

font-weight:600;

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


}



@media(max-width:700px){


.summary-grid{

grid-template-columns:1fr;

}



.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}



</style>


@endsection