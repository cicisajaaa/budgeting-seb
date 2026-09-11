@extends('layouts.dashboard')

@section('content')


<div class="finance-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


<div>

<div class="welcome-label">
FINANCE CONTROL
</div>


<h1>
Rekonsiliasi Bank
</h1>


<p>
Perbandingan saldo sistem dengan saldo rekening perusahaan.
</p>


<div class="welcome-tags">

<span>
Bank Monitoring
</span>


<span>
Balance Checking
</span>


<span>
Audit Control
</span>


</div>


</div>


</div>





{{-- SUMMARY --}}

<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
🏦
</div>

<div>

<label>
Total Bank
</label>


<h2>
{{$data->count()}}
</h2>


<small>
Rekening aktif
</small>


</div>

</div>






<div class="summary-card">

<div class="summary-icon">
💰
</div>

<div>

<label>
Total Saldo Sistem
</label>


<h2>
Rp {{number_format(
$data->sum('saldo_sistem'),
0,
',',
'.'
)}}
</h2>


<small>
Perhitungan sistem
</small>


</div>

</div>







<div class="summary-card">

<div class="summary-icon">
⚠️
</div>

<div>

<label>
Total Selisih
</label>

<h2>
Rp {{number_format(
    $data->sum(function($item){
        return abs($item['selisih']);
    }),
    0,
    ',',
    '.'
)}}
</h2>


<small>
Perbedaan saldo
</small>


</div>

</div>







<div class="summary-card">

<div class="summary-icon">
✓
</div>

<div>

<label>
Status Bank
</label>


<h2>
{{$data->where('status','Seimbang')->count()}}
</h2>


<small>
Bank seimbang
</small>


</div>

</div>



</div>







{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">


<div>

<div class="panel-title">
Rekonsiliasi Rekening Bank
</div>


<small class="panel-desc">
Pemeriksaan saldo sistem dan saldo rekening aktual
</small>


</div>


</div>






<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Bank
</th>


<th>
No Rekening
</th>


<th>
Saldo Sistem
</th>


<th>
Saldo Rekening
</th>


<th>
Selisih
</th>


<th>
Status
</th>


</tr>


</thead>



<tbody>

@forelse($data as $item)

<tr>


<td>

<strong>

{{$item['bank']->nama_bank}}

</strong>

</td>


<td>
{{$item['bank']->nomor_rekening}}
</td>

<td>

Rp {{number_format(
$item['saldo_sistem'],
0,
',',
'.'
)}}

</td>




<td>

Rp {{number_format(
$item['saldo_rekening'],
0,
',',
'.'
)}}

</td>




<td>


@if($item['status']=='Seimbang')

<span class="status success">

Rp 0

</span>


@else


<span class="status danger">

@if($item['selisih'] < 0)
    -Rp {{number_format(
        abs($item['selisih']),
        0,
        ',',
        '.'
    )}}
@else
    Rp {{number_format(
        $item['selisih'],
        0,
        ',',
        '.'
    )}}
@endif
</span>


@endif


</td>




<td>

@if($item['status']=='Seimbang')

<span class="status success">
✓ Seimbang
</span>

@else

<span class="status danger">
⚠ Perlu Pemeriksaan
</span>

@endif

</td>



</tr>

@empty

<tr>
<td colspan="6" style="text-align:center;padding:30px;">
Belum ada rekening bank aktif
</td>
</tr>

@endforelse




</tbody>


</table>


</div>


</div>



</div>






<style>


.finance-wrapper{
width:100%;
}



.welcome-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:24px;

padding:25px;

margin-bottom:25px;

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

font-size:13px;

color:#64748b;

}





.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}


.welcome-tags span{

background:white;

border:1px solid #e2e8f0;

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}






.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:25px;

}



.summary-card{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:16px;

display:flex;

align-items:center;

gap:14px;

box-shadow:0 10px 30px rgba(15,23,42,.05);

}



.summary-icon{

width:42px;

height:42px;

border-radius:14px;

background:#f1f5f9;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

}



.summary-card label{

font-size:11px;

color:#64748b;

}


.summary-card h2{

font-size:18px;

margin:5px 0;

font-weight:800;

}





.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:20px;

}



.panel-title{

font-size:16px;

font-weight:800;

}



.panel-desc{

font-size:11px;

color:#94a3b8;

}





table{

width:100%;

border-collapse:collapse;

}



th{

background:#f8fafc;

padding:13px;

text-align:left;

font-size:11px;

color:#64748b;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

font-size:12px;

}





.status{

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}



.status.success{

background:#dcfce7;

color:#166534;

}



.status.danger{

background:#fee2e2;

color:#991b1b;

}





@media(max-width:1200px){

.summary-grid{

grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:900px){

.summary-grid{

grid-template-columns:1fr;

}

}


</style>


@endsection