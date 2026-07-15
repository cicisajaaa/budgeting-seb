@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<h1>
Selamat Datang,
{{auth()->user()->name}}
</h1>


<p>
Monitoring project dan keuangan perusahaan dalam satu sistem.
</p>


</div>


<div class="date-box">

{{date('d M Y')}}

</div>


</div>





<div class="finance-grid">



<div class="finance-card">

<span>
Total Project
</span>


<h2>
{{$totalProject ?? 0}}
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

Rp {{number_format(
$totalBudget ?? 0,
0,
',',
'.'
)}}

</h2>


<p>
Nilai keseluruhan project
</p>

</div>





<div class="finance-card">

<span>
Dana Masuk
</span>


<h2>

Rp {{number_format(
$totalDeposit ?? 0,
0,
',',
'.'
)}}

</h2>


<p>
Total pembayaran
</p>

</div>





<div class="finance-card">

<span>
Progress Project
</span>


<h2>

{{$totalProjectProgress ?? 0}}%

</h2>


<p>
Rata-rata progress
</p>

</div>



</div>







<div class="content-grid">



<div class="panel">


<h3>
Financial Overview
</h3>



<div class="finance-row">


<div>

Dana Masuk

</div>


<strong>

Rp {{number_format(
$totalDeposit ?? 0,
0,
',',
'.'
)}}

</strong>


</div>



<div class="progress">

<div style="
width:70%;
">

</div>

</div>




<div class="finance-row">


<div>

Budget Project

</div>


<strong>

Rp {{number_format(
$totalBudget ?? 0,
0,
',',
'.'
)}}

</strong>


</div>


<div class="progress blue">

<div style="
width:50%;
">

</div>

</div>




</div>






<div class="panel">


<h3>
Informasi Sistem
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

{{auth()->user()->role}}

</td>


</tr>



<tr>

<td>
Status

</td>


<td style="color:#16a34a">

Aktif

</td>


</tr>


</table>


</div>


</div>






@endsection