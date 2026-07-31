@extends('layouts.dashboard')


@section('content')


<div class="dashboard-header">


<span class="label">
DASHBOARD UTAMA
</span>


<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>


<p>
Pemantauan kondisi proyek, keuangan, dan aktivitas perusahaan secara menyeluruh.
</p>


</div>







{{-- RINGKASAN UTAMA --}}


<div class="summary-grid">


<div class="summary-card">

<span>
Total Proyek
</span>


<h2>
{{$totalProject ?? 0}}
</h2>


<p>
Jumlah proyek perusahaan
</p>


</div>







<div class="summary-card">

<span>
Total Anggaran
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
Nilai keseluruhan proyek
</p>


</div>







<div class="summary-card">

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
Pembayaran dari pelanggan
</p>


</div>







<div class="summary-card">

<span>
Total Pengeluaran
</span>


<h2>
Rp {{number_format(
$totalExpense ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Dana yang telah digunakan
</p>


</div>



</div>









{{-- RINGKASAN TAMBAHAN --}}


<div class="summary-grid">



<div class="summary-card">

<span>
Saldo Perusahaan
</span>


<h2 class="green">

Rp {{number_format(
$sisaDana ?? 0,
0,
',',
'.'
)}}

</h2>


<p>
Dana yang tersedia
</p>


</div>








<div class="summary-card">

<span>
Persentase Penyelesaian Proyek
</span>


<h2>

{{$progressProject ?? 0}}%

</h2>


<p>
Rata-rata progres proyek
</p>


</div>








<div class="summary-card">

<span>
Persetujuan Tertunda
</span>


<h2>

{{$pendingApproval ?? 0}}

</h2>


<p>
Menunggu keputusan pemilik
</p>


</div>








<div class="summary-card">

<span>
Aktivitas Sistem
</span>


<h2>

{{$totalActivity ?? 0}}

</h2>


<p>
Riwayat aktivitas terbaru
</p>


</div>



</div>









{{-- KONDISI KEUANGAN --}}



<div class="content-grid">



<div class="panel">


<h3>
📊 Ringkasan Keuangan
</h3>




<div class="finance-row">

<span>
Dana Masuk
</span>


<strong class="green">

Rp {{number_format(
$totalDeposit ?? 0,
0,
',',
'.'
)}}

</strong>


</div>





<div class="finance-row">

<span>
Pengeluaran
</span>


<strong class="red">

Rp {{number_format(
$totalExpense ?? 0,
0,
',',
'.'
)}}

</strong>


</div>





<div class="finance-row">

<span>
Saldo Tersedia
</span>


<strong class="green">

Rp {{number_format(
$sisaDana ?? 0,
0,
',',
'.'
)}}

</strong>


</div>



</div>









<div class="panel">


<h3>
📌 Kondisi Perusahaan
</h3>





<div class="health-item">

<span>
Arus Keuangan
</span>


<b>
Stabil
</b>

</div>





<div class="health-item">

<span>
Jumlah Proyek Aktif
</span>


<b>
{{$totalProject ?? 0}} Proyek
</b>

</div>






<div class="health-item">

<span>
Persetujuan Dana
</span>


<b>
{{$pendingApproval ?? 0}} Menunggu
</b>

</div>



</div>



</div>









{{-- PEMANTAUAN PROYEK --}}



<div class="panel">


<h3>
📁 Pemantauan Proyek
</h3>



<table>


<thead>

<tr>


<th>
Nama Proyek
</th>


<th>
Progres
</th>


<th>
Anggaran
</th>


<th>
Status
</th>


</tr>


</thead>




<tbody>



@forelse($projects ?? [] as $project)



<tr>


<td>

<strong>

{{$project->nama_proyek}}

</strong>

</td>





<td>

{{$project->progres_keseluruhan ?? 0}}%

</td>





<td>

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>






<td>


@if(($project->progres_keseluruhan ?? 0) >= 100)


<span class="status selesai">

Selesai

</span>


@else


<span class="status berjalan">

Berjalan

</span>


@endif



</td>



</tr>




@empty


<tr>

<td colspan="4" align="center">

Belum terdapat data proyek

</td>


</tr>


@endforelse



</tbody>


</table>


</div>









{{-- AKTIVITAS TERBARU --}}



<div class="panel">


<h3>
📝 Aktivitas Terbaru
</h3>




<table>


<thead>


<tr>

<th>
Aktivitas
</th>


<th>
Tanggal
</th>

</tr>


</thead>



<tbody>



@forelse($activities ?? [] as $activity)



<tr>


<td>

{{$activity->description ?? '-'}}

</td>




<td>

{{$activity->created_at
? $activity->created_at->format('d M Y')
: '-'}}

</td>


</tr>




@empty


<tr>

<td colspan="2">

Belum ada aktivitas

</td>


</tr>


@endforelse



</tbody>



</table>



</div>







<style>


.dashboard-header{


background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:
0 5px 20px rgba(15,23,42,.05);


}



.label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#a67c2e;

}



.dashboard-header h1{

margin:10px 0;

font-size:28px;

color:#1e293b;

}



.dashboard-header p{

color:#64748b;

}






.summary-grid{


display:grid;

grid-template-columns:
repeat(4,1fr);

gap:20px;

margin-bottom:20px;


}




.summary-card{


background:white;

padding:22px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);


}



.summary-card span{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin-top:10px;

font-size:24px;

color:#6b4f1d;

}



.summary-card p{

font-size:12px;

color:#94a3b8;

}





.content-grid{

display:grid;

grid-template-columns:2fr 1fr;

gap:20px;

margin-bottom:20px;

}



.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:20px;

}




.finance-row,
.health-item{

display:flex;

justify-content:space-between;

padding:15px 0;

border-bottom:1px solid #f1f5f9;

}



.green{

color:#15803d!important;

}



.red{

color:#dc2626!important;

}





table{

width:100%;

border-collapse:collapse;

}



th{

padding:14px;

text-align:left;

font-size:12px;

color:#64748b;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

}





.status{

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:700;

}



.berjalan{

background:#dcfce7;

color:#166534;

}



.selesai{

background:#dbeafe;

color:#1d4ed8;

}



@media(max-width:1000px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


.content-grid{

grid-template-columns:1fr;

}


}


</style>



@endsection