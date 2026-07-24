@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
DISTRIBUSI DANA
</div>


<h1>
Monitoring Distribusi Keuangan
</h1>


<p>
Melihat penyebaran dana project ke setiap divisi.
</p>


</div>



<div class="system-status">

<span></span>

Finance Active

</div>



</div>







<div class="glass-panel">


<div class="panel-title">

📤 Riwayat Distribusi Dana

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

{{\Carbon\Carbon::parse($distribution->created_at)->format('d M Y')}}

</td>





<td>

{{ 
$distribution->setoranProyek->proyek->nama_proyek ?? '-'
}}

</td>





<td>

{{
$distribution->divisi->nama_divisi ?? '-'
}}

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




</div>







<div class="glass-panel">


<div class="panel-title">

📊 Ringkasan Distribusi

</div>





<div class="summary-box">



<div>


<span>

Total Distribusi

</span>


<b>

Rp {{number_format(
$totalDistribution,
0,
',',
'.'
)}}

</b>


</div>




<div>


<span>

Jumlah Transaksi

</span>


<b>

{{$distributions->count()}}

Transaksi

</b>


</div>



</div>



</div>







<style>


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:30px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:22px;

}





.welcome-label{

font-size:10px;

letter-spacing:2px;

font-weight:700;

opacity:.8;

}



.welcome-card h1{

font-size:28px;

margin:8px 0;

}



.welcome-card p{

font-size:13px;

opacity:.9;

}



.system-status{

background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-weight:700;

font-size:13px;

display:flex;

align-items:center;

gap:8px;

}



.system-status span{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

}



.glass-panel{

background:rgba(255,255,255,.65);

backdrop-filter:blur(15px);

border-radius:22px;

padding:22px;

margin-bottom:20px;

border:1px solid rgba(255,255,255,.8);

}



.panel-title{

font-size:16px;

font-weight:700;

margin-bottom:18px;

}



table{

width:100%;

border-collapse:collapse;

}



th{

text-align:left;

padding:14px;

font-size:12px;

color:#64748b;

background:#f8fafc;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

font-size:13px;

}



.money{

font-weight:700;

color:#16a34a;

}



.empty{

text-align:center;

color:#94a3b8;

}




.summary-box{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}



.summary-box div{

background:#f8fafc;

padding:20px;

border-radius:15px;

display:flex;

justify-content:space-between;

}



.summary-box span{

color:#64748b;

font-size:13px;

}



.summary-box b{

color:#166534;

}



@media(max-width:800px){


.summary-box{

grid-template-columns:1fr;

}


}

</style>



@endsection