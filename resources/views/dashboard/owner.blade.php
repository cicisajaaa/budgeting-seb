@extends('layouts.dashboard')


@section('content')


<h2>
Dashboard Owner
</h2>



<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">



<div class="card">

<h3>
Total Project
</h3>

<h1>
{{ $totalProject }}
</h1>

</div>




<div class="card">

<h3>
Total Budget
</h3>

<h1>
Rp {{ number_format($totalBudget) }}
</h1>

</div>





<div class="card">

<h3>
Dana Masuk
</h3>

<h1>
Rp {{ number_format($totalDeposit) }}
</h1>

</div>





<div class="card">

<h3>
Total Pengeluaran
</h3>

<h1>
Rp {{ number_format($totalExpense) }}
</h1>

</div>





<div class="card">

<h3>
Sisa Dana
</h3>

<h1>
Rp {{ number_format($sisaDana) }}
</h1>

</div>





<div class="card">

<h3>
Progress Project
</h3>

<h1>
{{ $totalProjectProgress }}%
</h1>

</div>



</div>



<hr>



<h2>
Ringkasan Keuangan
</h2>



<table border="1" width="100%">


<tr>

<th>
Keterangan
</th>

<th>
Nominal
</th>

</tr>



<tr>

<td>
Dana Masuk
</td>

<td>
Rp {{number_format($totalDeposit)}}
</td>

</tr>



<tr>

<td>
Pengeluaran
</td>

<td>
Rp {{number_format($totalExpense)}}
</td>

</tr>



<tr>

<td>
Saldo Akhir
</td>

<td>
Rp {{number_format($sisaDana)}}
</td>

</tr>


</table>


<li>

<a href="{{route('finance.report')}}">
Laporan Keuangan
</a>

</li>
@endsection