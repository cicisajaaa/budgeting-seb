@extends('layouts.dashboard')

@section('content')


<div class="approval-container">


{{-- HEADER --}}

<div class="page-header">

<span class="label">
PEMILIK PERUSAHAAN
</span>


<h1>
Persetujuan Dana
</h1>


<p>
Monitoring dan persetujuan pengajuan dana perusahaan.
</p>

</div>





{{-- SUMMARY --}}

<div class="summary-grid">


<div class="summary-card">

<span>
Menunggu Persetujuan
</span>

<h2>
{{ $requests->count() ?? 0 }}
</h2>

<p>
Pengajuan membutuhkan keputusan
</p>

</div>





<div class="summary-card">

<span>
Total Pengajuan
</span>

<h2>
{{ \App\Models\ExpenseRequest::count() }}
</h2>

<p>
Seluruh pengajuan dana
</p>

</div>





<div class="summary-card">

<span>
Dana Disetujui
</span>

<h2>
Rp {{number_format(
\App\Models\ExpenseRequest::where('status','approved')->sum('jumlah'),
0,
',',
'.'
)}}
</h2>

<p>
Total dana yang telah disetujui
</p>

</div>


</div>









{{-- LIST PENGAJUAN --}}


<div class="panel">


<h3>
📋 Daftar Pengajuan Dana
</h3>



<table>


<thead>

<tr>

<th>
Project
</th>


<th>
Keperluan
</th>


<th>
Pengaju
</th>


<th>
Nominal
</th>


<th>
Status
</th>


<th>
Detail
</th>


</tr>


</thead>





<tbody>


@forelse($requests ?? [] as $expense)



<tr>


<td>

<strong>

{{ $expense->proyek->nama_proyek ?? '-' }}

</strong>

</td>





<td>

{{ $expense->judul ?? '-' }}

</td>





<td>

{{ $expense->user->name ?? '-' }}

</td>





<td class="nominal">

Rp {{number_format(
$expense->jumlah ?? 0,
0,
',',
'.'
)}}

</td>






<td>


@if($expense->status == 'pending')


<span class="status waiting">

Menunggu

</span>



@elseif($expense->status == 'approved')


<span class="status approved">

Disetujui

</span>



@else


<span class="status rejected">

Ditolak

</span>


@endif


</td>





<td>

<a href="{{route('owner.approval.detail',$expense->id)}}"
class="btn detail">

Lihat Detail

</a>

</td>


</tr>





@empty


<tr>

<td colspan="6" align="center">

Belum ada pengajuan dana

</td>

</tr>


@endforelse



</tbody>


</table>


</div>



</div>








<style>


.approval-container{

margin-top:10px;

}




.page-header{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:
0 8px 25px rgba(15,23,42,.05);

}



.label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

color:#b08732;

}



.page-header h1{

margin:10px 0;

font-size:28px;

color:#1e293b;

}



.page-header p{

color:#64748b;

}





.summary-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:20px;

margin-bottom:25px;

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

font-size:26px;

color:#1e293b;

}



.summary-card p{

font-size:12px;

color:#94a3b8;

}





.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.panel h3{

margin-bottom:20px;

color:#1e293b;

}






table{

width:100%;

border-collapse:collapse;

}



th{

padding:15px;

text-align:left;

font-size:12px;

color:#64748b;

border-bottom:1px solid #e2e8f0;

}



td{

padding:15px;

font-size:14px;

border-bottom:1px solid #f1f5f9;

}



tr:hover{

background:#f8fafc;

}





.nominal{

font-weight:700;

color:#1e293b;

}







.status{

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:700;

}



.waiting{

background:#fef3c7;

color:#92400e;

}



.approved{

background:#dcfce7;

color:#166534;

}



.rejected{

background:#fee2e2;

color:#991b1b;

}








.btn{

border:none;

padding:8px 14px;

border-radius:10px;

font-size:12px;

font-weight:600;

cursor:pointer;

text-decoration:none;

}



.detail{

background:#f1f5f9;

color:#334155;

}







@media(max-width:1000px){


.summary-grid{

grid-template-columns:1fr;

}


table{

font-size:12px;

}


}


</style>


@endsection