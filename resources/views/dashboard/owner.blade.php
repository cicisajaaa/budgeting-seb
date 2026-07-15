@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<h1>
Dashboard Owner
</h1>


<p>
Monitoring perkembangan project dan kondisi keuangan perusahaan.
</p>


</div>


<div class="date-box">

{{ date('d M Y') }}

</div>


</div>







<div class="finance-grid">



<div class="finance-card">


<span>
Total Project
</span>


<h2>

{{ $totalProject }}

</h2>


<p>
Project terdaftar

</p>


</div>







<div class="finance-card">


<span>
Total Budget
</span>


<h2>

Rp {{ number_format($totalBudget,0,',','.') }}

</h2>


<p>
Nilai seluruh project

</p>


</div>







<div class="finance-card">


<span>
Dana Masuk
</span>


<h2>

Rp {{ number_format($totalDeposit,0,',','.') }}

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

Rp {{ number_format($totalExpense,0,',','.') }}

</h2>


<p>
Dana digunakan

</p>


</div>




</div>







<div class="finance-grid">



<div class="finance-card">


<span>
Sisa Dana

</span>


<h2 style="color:#2563eb">

Rp {{ number_format($sisaDana,0,',','.') }}

</h2>


<p>
Saldo tersedia

</p>


</div>







<div class="finance-card">


<span>
Progress Project

</span>


<h2>

{{ $totalProjectProgress }}%

</h2>


<p>
Rata-rata penyelesaian

</p>


</div>



</div>








<div class="content-grid">





<div class="panel">


<h3>
Ringkasan Keuangan
</h3>



<table>


<tr>

<td>
Dana Masuk
</td>


<td>

Rp {{number_format($totalDeposit,0,',','.')}}

</td>


</tr>




<tr>

<td>
Pengeluaran
</td>


<td>

Rp {{number_format($totalExpense,0,',','.')}}

</td>


</tr>




<tr>

<td>
Saldo Akhir
</td>


<td style="color:#10b981;font-weight:600">

Rp {{number_format($sisaDana,0,',','.')}}

</td>


</tr>



</table>



</div>








<div class="panel">


<h3>
Akses Owner
</h3>



<p>
Owner dapat melihat laporan keuangan secara keseluruhan.
</p>


<br>


<a href="{{route('finance.report')}}"
class="btn">


Lihat Laporan Keuangan


</a>



</div>





</div>





@endsection