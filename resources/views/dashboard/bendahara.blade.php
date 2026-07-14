@extends('layouts.dashboard')


@section('content')


<h2>
Dashboard Bendahara
</h2>


<div class="card">

<h3>
Total Dana Masuk
</h3>


<h1>
Rp {{ number_format($totalDeposit) }}
</h1>


</div>



<div class="card">

<h3>
Menu Finance
</h3>


<ul>

<li>
<a href="{{ route('finance.deposit') }}">
Input Pembayaran Client
</a>
</li>


<li>
Distribusi Dana
</li>


<li>
Pengeluaran
</li>


<li>
Laporan Keuangan
</li>


</ul>

</div>
<li>
<a href="{{route('finance.distribution')}}">
Lihat Distribusi Dana
</a>
</li>
<li>

<a href="{{route('expense.approval')}}">
Approval Pengeluaran
</a>

</li>

<li>

<a href="{{ route('finance.balance') }}">
Saldo Divisi
</a>

</li>
<div class="card">

<h3>
Total Pengeluaran
</h3>

<h2>
Rp {{number_format($totalExpense)}}
</h2>

</div>



<div class="card">

<h3>
Saldo Divisi
</h3>

<h2>
Rp {{number_format($totalSaldoDivisi)}}
</h2>

</div>

<li>

<a href="{{route('finance.report')}}">
Laporan Keuangan
</a>

</li>
@endsection