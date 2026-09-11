@extends('layouts.dashboard')

@section('content')


<div class="finance-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


<div class="welcome-content">


<div class="welcome-label">
DISTRIBUSI DANA
</div>


<h1>
Monitoring Distribusi Keuangan
</h1>


<p>
Melihat penyebaran dana project ke setiap divisi perusahaan.
</p>



<div class="welcome-tags">

<span>
✓ Project Allocation
</span>


<span>
✓ Finance Flow
</span>


<span>
✓ Division Control
</span>


</div>


</div>


</div>









{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card distribution-card">


<div class="summary-icon green">
💰
</div>


<div>

<label>
Total Distribusi
</label>


<h2>
Rp {{number_format($totalDistribution,0,',','.')}}
</h2>


<small>
Dana tersalurkan
</small>


</div>


</div>







<div class="summary-card transaction-card">


<div class="summary-icon blue">
📄
</div>


<div>

<label>
Total Transaksi
</label>


<h2>
{{$totalTransaction}}
</h2>


<small>
Distribusi dana
</small>


</div>


</div>







<div class="summary-card division-card">


<div class="summary-icon purple">
🏢
</div>


<div>

<label>
Jumlah Divisi
</label>


<h2>
{{$totalDivision}}
</h2>


<small>
Penerima dana
</small>


</div>


</div>







<div class="summary-card project-card">


<div class="summary-icon orange">
📁
</div>


<div>

<label>
Project Terdistribusi
</label>


<h2>
{{$totalProject}}
</h2>


<small>
Project aktif
</small>


</div>


</div>





</div>









{{-- TABLE --}}


<div class="glass-panel">



<div class="panel-header">


<div>

<div class="panel-title">
Riwayat Distribusi Dana
</div>


<small>
Detail pembagian dana project ke setiap divisi
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
Divisi
</th>


<th>
Nominal
</th>


</tr>

</thead>





<tbody>


@forelse($distributions as $distribution)



<tr>


<td>

<div class="date-box">

{{\Carbon\Carbon::parse(
$distribution->created_at
)->format('d M Y')}}

</div>


</td>






<td>

<strong>

{{$distribution->setoranProyek?->proyek?->nama_proyek ?? '-'}}

</strong>

</td>






<td>

<span class="division-badge">

{{$distribution->divisi?->nama_divisi ?? '-'}}

</span>

</td>






<td class="money">


Rp {{number_format(
$distribution->nominal_diterima,
0,
',',
'.'
)}}


</td>



</tr>



@empty



<tr>

<td colspan="4" class="empty">

Belum ada distribusi dana

</td>

</tr>


@endforelse



</tbody>



</table>






<div class="total-footer">


<span>
Total Dana Tersalurkan
</span>


<strong>

Rp {{number_format(
$totalDistribution,
0,
',',
'.'
)}}

</strong>


</div>





</div>






</div>









<style>


.finance-wrapper{

width:100%;

}




/* HEADER */


.welcome-card{


background:#f8fafc;


border:1px solid #e2e8f0;


border-radius:24px;


padding:28px;


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

margin:12px 0;

font-size:25px;

font-weight:800;

color:#172033;

}



.welcome-card p{

margin:0;

font-size:13px;

color:#64748b;

}



.welcome-tags{

display:flex;

gap:10px;

margin-top:18px;

}



.welcome-tags span{

background:white;

border:1px solid #e2e8f0;

padding:7px 13px;

border-radius:999px;

font-size:10px;

font-weight:700;

color:#334155;

}









/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:16px;

margin-bottom:25px;

}



.summary-card{


background:white;


border:1px solid #e5e7eb;


border-radius:22px;


padding:18px;


display:flex;


align-items:center;


gap:15px;


position:relative;


overflow:hidden;


transition:.25s;


box-shadow:

0 10px 30px rgba(15,23,42,.05);


}



.summary-card:hover{

transform:translateY(-5px);

}





.summary-card::before{

content:"";

position:absolute;

top:0;

left:0;

width:100%;

height:4px;

}



.distribution-card::before{

background:#22c55e;

}



.transaction-card::before{

background:#3b82f6;

}



.division-card::before{

background:#8b5cf6;

}



.project-card::before{

background:#f59e0b;

}





.summary-icon{

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



.blue{

background:#dbeafe;

}



.purple{

background:#ede9fe;

}



.orange{

background:#fef3c7;

}





.summary-card label{

font-size:11px;

color:#64748b;

}



.summary-card h2{

margin:5px 0;

font-size:18px;

font-weight:800;

color:#172033;

}



.summary-card small{

font-size:10px;

color:#94a3b8;

}









/* PANEL */


.glass-panel{


background:white;


border:1px solid #e5e7eb;


border-radius:24px;


padding:20px;


box-shadow:

0 10px 30px rgba(15,23,42,.06);


}



.panel-header{

margin-bottom:18px;

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









/* TABLE */


table{

width:100%;

border-collapse:collapse;

}



th{

background:#f8fafc;

padding:14px;

font-size:11px;

color:#64748b;

text-align:left;

}



td{

padding:15px;

font-size:12px;

border-bottom:1px solid #f1f5f9;

color:#334155;

}



tbody tr{

transition:.2s;

}



tbody tr:hover{

background:#f8fafc;

transform:scale(1.005);

}



td strong{

color:#172033;

}





.date-box{

font-size:12px;

color:#64748b;

}





.division-badge{

background:#ede9fe;

color:#6d28d9;

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}





.money{

text-align:right;

font-weight:800;

color:#16a34a;

}





.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}









.total-footer{


margin-top:20px;


background:#f8fafc;


border:1px solid #e2e8f0;


border-radius:18px;


padding:18px;


display:flex;


justify-content:space-between;


align-items:center;


}



.total-footer span{

font-size:12px;

color:#64748b;

}



.total-footer strong{

font-size:20px;

color:#16a34a;

}








@media(max-width:1200px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:800px){


.summary-grid{

grid-template-columns:1fr;

}


.welcome-tags{

flex-wrap:wrap;

}


}



</style>


@endsection