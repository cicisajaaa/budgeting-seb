@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
APPROVAL DANA
</div>


<h1>
Persetujuan Pengajuan Dana
</h1>


<p>
Kelola pengajuan dana karyawan dan lakukan proses persetujuan keuangan perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Finance Control
</span>


<span>
✓ Audit Approval
</span>


<span>
✓ Monitoring Dana
</span>


</div>


</div>


</div>










@if(session('error'))

<div class="error-box">
{{session('error')}}
</div>

@endif







{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
⏳
</div>


<div>

<label>
Menunggu Approval
</label>

<h2>
{{$requests->count()}}
</h2>

<small>
Pengajuan pending
</small>


</div>


</div>







<div class="summary-card">

<div class="summary-icon">
💰
</div>


<div>

<label>
Total Dana Diajukan
</label>

<h2>
Rp {{number_format($requests->sum('jumlah'),0,',','.')}}
</h2>

<small>
Nominal pending
</small>


</div>


</div>


</div>









<div class="glass-panel">


<div class="panel-title">

📋 Daftar Pengajuan Dana

</div>


<small class="subtitle">
Pengajuan yang membutuhkan keputusan keuangan
</small>







<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Pemohon
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

<th>
Tanggal
</th>

<th>
Aksi
</th>


</tr>


</thead>




<tbody>


@forelse($requests as $request)



<tr>


<td>


<strong>
{{$request->pengguna->name ?? '-'}}
</strong>


<br>


<small>
{{$request->judul}}
</small>


</td>





<td>

{{$request->proyek->nama_proyek ?? '-'}}

</td>





<td>

{{$request->divisi->nama_divisi ?? '-'}}

</td>





<td class="money">


Rp {{number_format($request->jumlah,0,',','.')}}

</td>





<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>







<td>


<div class="action-group">



<a href="{{route('expense.approval.detail',$request->id)}}"
class="detail-btn">

Detail

</a>





<form method="POST"
action="{{route('expense.approve',$request->id)}}">


@csrf



<input type="hidden"
name="rekening_bank_id"
value="{{$banks->first()->id ?? ''}}">



<button class="approve-btn"
onclick="return confirm('Setujui pengajuan ini?')">

Setujui

</button>


</form>







<form method="POST"
action="{{route('expense.reject',$request->id)}}">


@csrf


<input type="hidden"
name="catatan_persetujuan"
value="Ditolak oleh keuangan">



<button class="reject-btn"
onclick="return confirm('Tolak pengajuan ini?')">

Tolak

</button>


</form>




</div>



</td>




</tr>





@empty


<tr>

<td colspan="6"
class="empty">

Tidak ada pengajuan menunggu approval

</td>

</tr>


@endforelse



</tbody>


</table>


</div>



</div>









<style>


.welcome-card{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:20px;

}



.welcome-label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#64748b;

}



.welcome-card h1{

font-size:28px;

color:#6b4f1d;

margin:8px 0;

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

background:#fff7db;

color:#6b4f1d;

padding:7px 14px;

border-radius:20px;

font-size:11px;

font-weight:600;

}







.summary-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

margin-bottom:20px;

}



.summary-card{

background:white;

padding:20px;

border-radius:18px;

border:1px solid #e2e8f0;

display:flex;

gap:15px;

align-items:center;

}



.summary-icon{

width:50px;

height:50px;

border-radius:15px;

background:#fff7db;

display:flex;

justify-content:center;

align-items:center;

font-size:22px;

}



.summary-card label{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin-top:5px;

color:#6b4f1d;

}







.glass-panel{

background:white;

padding:22px;

border-radius:18px;

border:1px solid #e2e8f0;

}



.panel-title{

font-size:17px;

font-weight:700;

}



.subtitle{

color:#64748b;

}





.table-wrapper{

margin-top:20px;

overflow-x:auto;

}



table{

width:100%;

border-collapse:collapse;

}



th{

background:#faf7ef;

padding:14px;

text-align:left;

font-size:12px;

color:#64748b;

}



td{

padding:14px;

border-bottom:1px solid #f1f5f9;

font-size:13px;

}



.money{

font-weight:700;

color:#6b4f1d;

}





.action-group{

display:flex;

gap:8px;

}



.action-group a,
.action-group button{

border:none;

padding:8px 12px;

border-radius:10px;

font-size:12px;

cursor:pointer;

text-decoration:none;

font-weight:600;

}



.detail-btn{

background:#f1f5f9;

color:#334155;

}





.approve-btn{

background:#dcfce7;

color:#166534;

}





.reject-btn{

background:#fee2e2;

color:#dc2626;

}





.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}





.success-box{

background:#dcfce7;

color:#166534;

padding:15px;

border-radius:12px;

margin-bottom:20px;

}



.error-box{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:12px;

margin-bottom:20px;

}



@media(max-width:900px){

.summary-grid{

grid-template-columns:1fr;

}

}



</style>


@endsection