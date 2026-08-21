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
$distribution->setoranProyek?->proyek?->nama_proyek ?? '-'
}}

</td>





<td>

{{
$distribution->divisi?->nama_divisi ?? '-'
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

/* ===============================
HEADER
================================ */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}








/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

}







/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:14px;

    background:#f8fafc;

    text-align:left;

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tr:hover{

    background:#f8fafc;

}



.money{

    font-weight:800;

    color:#16a34a;

}





.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}








/* ===============================
SUMMARY DISTRIBUSI
================================ */


.summary-box{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}



.summary-box div{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:22px;


    padding:22px;


    display:flex;


    justify-content:space-between;


    align-items:center;


    box-shadow:


    0 10px 30px rgba(15,23,42,.05);


    position:relative;


    overflow:hidden;


}



.summary-box div::before{


    content:"";


    position:absolute;


    top:0;


    left:0;


    width:100%;


    height:4px;


    background:#334155;


}



.summary-box span{

    font-size:12px;

    color:#64748b;

}



.summary-box b{

    font-size:20px;

    color:#172033;

    font-weight:800;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:800px){


.summary-box{

    grid-template-columns:1fr;

}



.welcome-card{

    padding:25px;

}



}

</style>

@endsection