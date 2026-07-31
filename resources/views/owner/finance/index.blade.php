@extends('layouts.dashboard')


@section('content')


<style>


.finance-container{

margin-top:30px;

}


/* SUMMARY */

.finance-cards{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

}



.finance-card{

background:white;

padding:25px;

border-radius:20px;

box-shadow:
0 10px 30px rgba(0,0,0,.06);

}



.finance-icon{

width:45px;

height:45px;

border-radius:12px;

background:#f8f3e8;

display:flex;

align-items:center;

justify-content:center;

color:#a67c2e;

font-size:20px;

margin-bottom:15px;

}



.finance-label{

font-size:13px;

color:#64748b;

}



.finance-value{

font-size:26px;

font-weight:800;

margin-top:8px;

color:#172033;

}



/* SECTION */


.finance-section{

background:white;

padding:30px;

border-radius:20px;

margin-top:30px;

box-shadow:

0 10px 30px rgba(0,0,0,.05);

}


.finance-section h3{

font-size:18px;

color:#172033;

margin-bottom:20px;

}



/* CHART */


.chart{

height:240px;

background:#f8fafc;

border-radius:18px;

display:flex;

justify-content:center;

align-items:center;

color:#94a3b8;

}



/* TABLE */


table{

width:100%;

border-collapse:collapse;

}



th{

text-align:left;

padding:15px;

font-size:13px;

color:#64748b;

border-bottom:1px solid #eee;

}



td{

padding:15px;

font-size:14px;

border-bottom:1px solid #f1f5f9;

}



.income{

color:#15803d;

font-weight:700;

}


.expense{

color:#dc2626;

font-weight:700;

}




</style>





<div class="finance-container">





<!-- SUMMARY -->

<div class="finance-cards">



<div class="finance-card">

<div class="finance-icon">

<i class="fa-solid fa-wallet"></i>

</div>


<div class="finance-label">

Saldo Perusahaan

</div>


<div class="finance-value">

Rp850 Jt

</div>

</div>





<div class="finance-card">

<div class="finance-icon">

<i class="fa-solid fa-arrow-trend-up"></i>

</div>


<div class="finance-label">

Total Pendapatan

</div>


<div class="finance-value">

Rp2,4 M

</div>

</div>






<div class="finance-card">

<div class="finance-icon">

<i class="fa-solid fa-arrow-trend-down"></i>

</div>


<div class="finance-label">

Total Pengeluaran

</div>


<div class="finance-value">

Rp1,2 M

</div>

</div>






<div class="finance-card">

<div class="finance-icon">

<i class="fa-solid fa-chart-line"></i>

</div>


<div class="finance-label">

Profit Bersih

</div>


<div class="finance-value">

Rp1,2 M

</div>

</div>




</div>






<!-- CASH FLOW -->


<div class="finance-section">


<h3>

Cash Flow Perusahaan

</h3>



<div class="chart">

Area Grafik Cash Flow

</div>



</div>







<!-- TRANSACTION -->


<div class="finance-section">


<h3>

Transaksi Terbaru

</h3>



<table>


<thead>

<tr>

<th>
Tanggal
</th>

<th>
Keterangan
</th>

<th>
Project
</th>

<th>
Nominal
</th>

<th>
Jenis
</th>

</tr>

</thead>


<tbody>


<tr>

<td>
31 Juli 2026
</td>


<td>
Pembayaran Termin Project
</td>


<td>
Project A
</td>


<td class="income">

+ Rp50.000.000

</td>


<td>

Pemasukan

</td>

</tr>





<tr>

<td>
30 Juli 2026
</td>


<td>
Pembelian Material
</td>


<td>
Project B
</td>


<td class="expense">

- Rp15.000.000

</td>


<td>

Pengeluaran

</td>

</tr>





<tr>

<td>
28 Juli 2026
</td>


<td>
Pembayaran Vendor
</td>


<td>
Project C
</td>


<td class="expense">

- Rp25.000.000

</td>


<td>

Pengeluaran

</td>

</tr>




</tbody>


</table>


</div>






</div>


@endsection