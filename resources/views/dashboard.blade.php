@extends('layouts.dashboard')

@section('content')


<div class="welcome-card">

    <div>

        <div class="welcome-label">
            ENTERPRISE MANAGEMENT SYSTEM
        </div>


        <h1>
            Selamat Datang,
            {{auth()->user()->name}}
        </h1>


        <p>
            Monitoring project, keuangan, dan aktivitas perusahaan dalam satu sistem terintegrasi.
        </p>


    </div>


    <div class="date-box">

        {{date('d M Y')}}

    </div>


</div>






<div class="finance-grid">


<div class="finance-card">

<div class="card-icon">
📁
</div>

<div>

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

</div>







<div class="finance-card">

<div class="card-icon">
💰
</div>

<div>

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

</div>







<div class="finance-card">

<div class="card-icon">
💳
</div>

<div>

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

</div>







<div class="finance-card">

<div class="card-icon">
📊
</div>

<div>

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



</div>









<div class="content-grid">



<div class="panel">


<div class="panel-title">
Financial Overview
</div>



<div class="finance-row">

<span>
Dana Masuk
</span>


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

<div style="width:70%"></div>

</div>






<div class="finance-row">

<span>
Budget Project
</span>


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

<div style="width:50%"></div>

</div>




</div>









<div class="panel">


<div class="panel-title">
Informasi Sistem
</div>



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
{{ucfirst(auth()->user()->role)}}
</td>

</tr>




<tr>

<td>
Status
</td>

<td class="active-status">
Aktif
</td>

</tr>



</table>



</div>


</div>









<style>


.welcome-card{

background:#f8fafc;
border:1px solid #e2e8f0;
border-radius:24px;
padding:30px;
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;

}


.welcome-label{

font-size:10px;
letter-spacing:2px;
font-weight:800;
color:#64748b;

}



.welcome-card h1{

font-size:26px;
margin:10px 0;
color:#172033;

}



.welcome-card p{

color:#64748b;
font-size:13px;

}



.date-box{

background:#334155;
color:white;
padding:12px 20px;
border-radius:14px;
font-size:13px;
font-weight:700;

}







.finance-grid{

display:grid;
grid-template-columns:repeat(4,1fr);
gap:18px;
margin-bottom:25px;

}



.finance-card{

background:white;
border:1px solid #e5e7eb;
border-radius:22px;
padding:20px;
display:flex;
align-items:center;
gap:15px;
box-shadow:0 10px 25px rgba(15,23,42,.05);

}



.card-icon{

width:45px;
height:45px;
border-radius:14px;
background:#f1f5f9;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;

}



.finance-card span{

font-size:11px;
color:#64748b;

}



.finance-card h2{

margin:5px 0;
font-size:20px;
font-weight:800;
color:#172033;

}



.finance-card p{

font-size:10px;
color:#94a3b8;

}









.content-grid{

display:grid;
grid-template-columns:2fr 1fr;
gap:20px;

}



.panel{

background:white;
border:1px solid #e5e7eb;
border-radius:24px;
padding:25px;
box-shadow:0 10px 30px rgba(15,23,42,.05);

}



.panel-title{

font-size:16px;
font-weight:800;
color:#172033;
margin-bottom:20px;

}



.finance-row{

display:flex;
justify-content:space-between;
margin-bottom:12px;
font-size:13px;

}



.finance-row span{

color:#64748b;

}



.finance-row strong{

color:#166534;

}



.progress{

height:10px;
background:#e2e8f0;
border-radius:20px;
overflow:hidden;
margin-bottom:25px;

}



.progress div{

height:100%;
background:#334155;

}



.progress.blue div{

background:#64748b;

}





table{

width:100%;
border-collapse:collapse;

}



td{

padding:12px 0;
font-size:13px;
border-bottom:1px solid #f1f5f9;

}



td:first-child{

color:#64748b;

}



.active-status{

color:#16a34a;
font-weight:700;

}







@media(max-width:1000px){

.finance-grid{

grid-template-columns:repeat(2,1fr);

}


.content-grid{

grid-template-columns:1fr;

}

}



@media(max-width:700px){

.finance-grid{

grid-template-columns:1fr;

}


.welcome-card{

flex-direction:column;
align-items:flex-start;
gap:20px;

}

}


</style>


@endsection