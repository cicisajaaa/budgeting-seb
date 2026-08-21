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

/* ===============================
GLOBAL
================================ */

body{
    color:#172033;
}


/* ===============================
HEADER
================================ */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

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

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}





.btn-add{

    background:#1e293b;

    color:white;

    padding:12px 22px;

    border-radius:14px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}





.btn-add:hover{

    background:#334155;

}







/* ===============================
SUMMARY CARD
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:18px;

    margin-bottom:25px;

}




.summary-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:14px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

}





.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    height:4px;

    width:100%;

    background:#334155;

}





.summary-icon{

    width:45px;

    height:45px;

    border-radius:14px;

    background:#fef3c7;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:4px 0;

    font-size:18px;

    font-weight:800;

    color:#172033;

}



.summary-card small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
PANEL
================================ */


.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:25px;


    box-shadow:

    0 10px 30px rgba(15,23,42,.06);


}





.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

}



.panel-header small{

    font-size:11px;

    color:#94a3b8;

}








/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:13px;

    font-size:11px;

    color:#64748b;

    text-align:left;

}



td{

    padding:14px;

    font-size:12px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

}



td strong{

    font-size:13px;

    color:#172033;

}



tr:hover{

    background:#fafafa;

}





.income{

    color:#16a34a;

    font-weight:800;

}





.status-success{

    background:#dcfce7;

    color:#166534;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

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