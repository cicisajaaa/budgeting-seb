@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<h1>
Dashboard Karyawan
</h1>


<p>
Kelola aktivitas project dan pengajuan dana kamu melalui sistem.
</p>


</div>


<div class="date-box">

{{ date('d M Y') }}

</div>


</div>







<div class="finance-grid">



<div class="finance-card">


<span>
Project Aktif
</span>


<h2>
0
</h2>


<p>
Project yang sedang dikerjakan
</p>


</div>







<div class="finance-card">


<span>
Pengajuan Dana
</span>


<h2>
-
</h2>


<p>
Total pengajuan
</p>


</div>







<div class="finance-card">


<span>
Status Terakhir
</span>


<h2 style="color:#10b981">

Aktif

</h2>


<p>
Akun dapat digunakan
</p>


</div>







<div class="finance-card">


<span>
Role

</span>


<h2>

Karyawan

</h2>


<p>
User Project Tracker
</p>


</div>




</div>







<div class="content-grid">





<div class="panel">


<h3>
Menu Saya
</h3>



<table>


<tr>

<td>
Pengajuan Dana
</td>


<td>

<a href="{{ route('expense.create') }}">

Buka

</a>

</td>


</tr>





<tr>

<td>
Riwayat Pengajuan Dana
</td>


<td>

<a href="{{ route('expense.history') }}">

Lihat

</a>

</td>


</tr>





<tr>

<td>
Project Saya
</td>


<td>

<a href="#">

Lihat

</a>

</td>


</tr>



</table>



</div>







<div class="panel">


<h3>
Informasi Akun
</h3>


<table>


<tr>

<td>
Nama

</td>

<td>

{{ auth()->user()->name }}

</td>


</tr>



<tr>

<td>
Role

</td>


<td>

{{ auth()->user()->role }}

</td>


</tr>



<tr>

<td>
Status

</td>


<td style="color:#10b981">

Aktif

</td>


</tr>


</table>



</div>






</div>





@endsection