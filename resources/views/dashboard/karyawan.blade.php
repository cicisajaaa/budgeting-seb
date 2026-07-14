@extends('layouts.dashboard')


@section('content')


<h2>
Dashboard Karyawan
</h2>


<div class="card">

<h3>
Menu Saya
</h3>


<ul>


<li>
<a href="#">
Project Saya
</a>
</li>



<li>
<a href="{{ route('expense.create') }}">
Pengajuan Dana
</a>
</li>



<li>
<a href="#">
Riwayat Pengeluaran
</a>
</li>


</ul>


</div>
<li>

<a href="{{ route('expense.history') }}">
Riwayat Pengajuan Dana
</a>

</li>

@endsection