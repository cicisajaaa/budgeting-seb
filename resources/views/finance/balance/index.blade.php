@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<div class="welcome-label">

SALDO DIVISI

</div>



<h1>

Monitoring Saldo Keuangan Divisi

</h1>



<p>

Melihat saldo dana yang telah diterima setiap divisi.

</p>


</div>




<div class="system-status">

<span></span>

Finance Active

</div>


</div>







<!-- SUMMARY -->


<div class="finance-grid">


<div class="finance-card">


<div class="finance-icon green">

💰

</div>



<div>


<label>

Total Saldo Divisi

</label>


<h2>

Rp {{number_format($balances->sum('saldo'),0,',','.')}}

</h2>


<small>

Dana tersedia seluruh divisi

</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon blue">

🏢

</div>


<div>


<label>

Jumlah Divisi

</label>


<h2>

{{$balances->count()}}

</h2>


<small>

Divisi aktif

</small>


</div>


</div>



</div>









<!-- TABLE -->


<div class="glass-panel">


<div class="panel-title">

🏦 Detail Saldo Divisi

</div>






<table>


<thead>

<tr>


<th>

Project

</th>


<th>

Divisi

</th>


<th>

Saldo

</th>


</tr>


</thead>





<tbody>


@forelse($balances as $balance)



<tr>


<td>


{{$balance->proyek->nama_proyek ?? '-'}}


</td>



<td>


{{$balance->divisi->nama_divisi ?? '-'}}


</td>



<td class="money">


Rp {{number_format($balance->saldo,0,',','.')}}


</td>



</tr>



@empty


<tr>


<td colspan="3" class="empty">

Belum ada saldo divisi

</td>


</tr>



@endforelse



</tbody>



</table>




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







.finance-grid{


display:grid;

grid-template-columns:repeat(2,1fr);

gap:18px;

margin-bottom:22px;


}





.finance-card{


background:white;

border-radius:20px;

padding:18px;

display:flex;

align-items:center;

gap:15px;

box-shadow:0 10px 30px rgba(0,0,0,.06);


}





.finance-icon{


width:45px;

height:45px;

display:flex;

align-items:center;

justify-content:center;

border-radius:15px;

font-size:20px;


}



.green{

background:#dcfce7;

}



.blue{

background:#dbeafe;

}





.finance-card label{


font-size:12px;

color:#64748b;


}




.finance-card h2{


font-size:20px;

color:#166534;

margin-top:5px;


}





.glass-panel{


background:rgba(255,255,255,.65);

backdrop-filter:blur(15px);

border-radius:22px;

padding:22px;

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


padding:14px;

text-align:left;

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



@media(max-width:700px){


.finance-grid{

grid-template-columns:1fr;

}


}


</style>




@endsection