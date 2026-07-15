@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>

<h1>
Dashboard Bendahara
</h1>


<p>
Kelola transaksi keuangan, distribusi dana, dan pengeluaran project.
</p>


</div>


<div class="date-box">

{{ date('d M Y') }}

</div>


</div>







<div class="finance-grid">



<div class="finance-card">


<span>
Total Dana Masuk
</span>


<h2>

Rp {{ number_format($totalDeposit ?? 0,0,',','.') }}

</h2>


<p>
Pembayaran client
</p>


</div>







<div class="finance-card">


<span>
Total Pengeluaran
</span>


<h2>

Rp {{ number_format($totalExpense ?? 0,0,',','.') }}

</h2>


<p>
Dana yang sudah digunakan
</p>


</div>






<div class="finance-card">


<span>
Saldo Divisi
</span>


<h2>

Rp {{ number_format($totalSaldoDivisi ?? 0,0,',','.') }}

</h2>


<p>
Sisa dana tersedia
</p>


</div>







<div class="finance-card">


<span>
Status Keuangan
</span>


<h2 style="color:#10b981">

Aktif

</h2>


<p>
Sistem berjalan normal
</p>


</div>




</div>








<div class="content-grid">





<div class="panel">


<h3>
Menu Finance
</h3>



<table>


<tr>

<td>
Input Pembayaran Client
</td>


<td>

<a href="{{ route('finance.deposit') }}">

Buka

</a>

</td>


</tr>





<tr>

<td>
Distribusi Dana
</td>


<td>

<a href="{{ route('finance.distribution') }}">

Buka

</a>

</td>


</tr>





<tr>

<td>
Saldo Divisi
</td>


<td>

<a href="{{ route('finance.balance') }}">

Buka

</a>

</td>


</tr>





<tr>

<td>
Approval Pengeluaran
</td>


<td>

<a href="{{ route('expense.approval') }}">

Buka

</a>

</td>


</tr>





<tr>

<td>
Laporan Keuangan
</td>


<td>

<a href="{{ route('finance.report') }}">

Buka

</a>

</td>


</tr>



</table>



</div>








<div class="panel">


<h3>
Informasi Bendahara
</h3>



<table>


<tr>

<td>
User

</td>

<td>

{{auth()->user()->name}}

</td>

</tr>



<tr>

<td>
Role

</td>

<td>

Bendahara

</td>

</tr>



<tr>

<td>
Akses

</td>

<td style="color:#10b981">

Finance Management

</td>

</tr>



</table>



</div>




</div>





@endsection