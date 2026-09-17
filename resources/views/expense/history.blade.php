@extends('layouts.dashboard')

@section('content')

@php

$totalApproved = $requests
    ->whereIn('status',['approved','selesai'])
    ->count();


$totalDanaApproved = $requests
    ->whereIn('status',['approved','selesai'])
    ->sum('jumlah');


$totalDana = $requests
    ->sum('jumlah');

@endphp


<div class="welcome-card">

    <div>

        <div class="welcome-label">
            EMPLOYEE FINANCE PORTAL
        </div>


        <h1>
            Riwayat Pengajuan Dana
        </h1>


        <p>
            Monitoring status permintaan dana project secara real-time.
        </p>


        <div class="welcome-tags">

            <span>
                ✓ Expense Tracking
            </span>

            <span>
                ✓ Approval Flow
            </span>

            <span>
                ✓ Budget Monitoring
            </span>

        </div>


    </div>



    <a href="{{route('expense.create')}}"
       class="create-btn">

        + Buat Pengajuan

    </a>


</div>





{{-- SUMMARY --}}

<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
📄
</div>

<div>

<label>
Total Pengajuan
</label>


<h2>
{{$requests->count()}}
</h2>


<small>
Seluruh pengajuan dana
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon">
⏳
</div>


<div>

<label>
Menunggu Approval
</label>


<h2>
{{$requests->where('status','pending')->count()}}
</h2>


<small>
Sedang diproses finance
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon">
✅
</div>


<div>

<label>
Disetujui
</label>


<h2>
{{$totalApproved}}
</h2>


<small>
Rp {{number_format($totalDanaApproved,0,',','.')}}
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon">
❌
</div>


<div>

<label>
Ditolak
</label>


<h2>
{{$requests->where('status','rejected')->count()}}
</h2>


<small>
Perlu diperiksa
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon">
💰
</div>


<div>

<label>
Total Dana
</label>


<h2>

{{number_format(
$totalDana/1000000,
1,
',',
'.'
)}} JT

</h2>


<small>
Seluruh nominal pengajuan
</small>


</div>

</div>



</div>






{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">
🔎 Filter Pengajuan Dana
</div>



<form method="GET"
action="{{route('expense.myhistory')}}">


<div class="filter-box">


<div>

<label>
Cari Pengajuan
</label>


<input
type="text"
name="search"
value="{{request('search')}}"
placeholder="Nomor / Judul pengajuan"
>


</div>




<div>

<label>
Status
</label>


<select name="status">


<option value="">
Semua Status
</option>


<option value="pending"
{{request('status')=='pending'?'selected':''}}>
Menunggu
</option>


<option value="approved"
{{request('status')=='approved'?'selected':''}}>
Disetujui
</option>


<option value="rejected"
{{request('status')=='rejected'?'selected':''}}>
Ditolak
</option>


<option value="selesai"
{{request('status')=='selesai'?'selected':''}}>
Selesai
</option>


</select>


</div>





<button type="submit">
Filter
</button>


<a href="{{route('expense.myhistory')}}">
Reset
</a>



</div>


</form>


</div>







{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">


<div class="panel-title">
📋 Daftar Pengajuan Dana
</div>


<small>
Riwayat pengajuan kebutuhan project
</small>


</div>





<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Nomor Pengajuan
</th>


<th>
Tanggal
</th>


<th>
Kebutuhan
</th>


<th>
Project
</th>


<th>
Perusahaan
</th>


<th>
Nominal
</th>


<th>
Status
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
{{$request->nomor_pengajuan ?? '-'}}
</strong>

</td>



<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>




<td>

<strong>
{{$request->judul}}
</strong>

<br>

<small>
{{$request->keterangan ?? '-'}}
</small>

</td>





<td>

<strong>
{{$request->proyek->nama_proyek ?? '-'}}
</strong>


<br>

<small>
{{$request->divisi->nama_divisi ?? '-'}}
</small>


</td>





<td>

{{$request->proyek->perusahaan->nama_perusahaan ?? '-'}}

</td>





<td class="money">

Rp {{number_format(
$request->jumlah ?? 0,
0,
',',
'.'
)}}

</td>





<td>


@if($request->status=='pending')

<span class="status pending">
● Menunggu
</span>


@elseif(in_array($request->status,['approved','selesai']))


<span class="status approved">
● Disetujui
</span>


@elseif($request->status=='rejected')


<span class="status rejected">
● Ditolak
</span>


@endif


</td>





<td>

<a href="{{route('expense.detail',$request->id)}}"
class="detail-btn">

Detail

</a>

</td>



</tr>



@empty


<tr>

<td colspan="8"
class="empty-cell">


<div class="empty">

<div class="empty-icon">
📄
</div>


<h3>
Belum Ada Pengajuan Dana
</h3>


<p>
Belum ada transaksi pengajuan dana.
</p>


<a href="{{route('expense.create')}}"
class="create-mini">

+ Buat Pengajuan

</a>


</div>


</td>


</tr>


@endforelse



</tbody>


</table>


</div>


</div>


<style>

*{
    box-sizing:border-box;
}


body{

    font-family:
    Inter,
    system-ui,
    sans-serif;

    color:#334155;

}



/* =========================
WELCOME
========================= */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:28px;

    margin-bottom:20px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

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

    margin:8px 0;

    font-size:25px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}



.welcome-tags{

    display:flex;

    flex-wrap:wrap;

    gap:8px;

    margin-top:15px;

}



.welcome-tags span{

    background:#eef2f7;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    color:#475569;

}



.create-btn{

    background:#0f172a;

    color:white;

    padding:12px 22px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

    white-space:nowrap;

}





.create-btn:hover{

    background:#334155;

}



/* =========================
SUMMARY
========================= */


.summary-grid{

    display:grid;

    grid-template-columns:
    repeat(5,1fr);

    gap:14px;

    margin-bottom:20px;

}



.summary-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:16px;

    display:flex;

    align-items:center;

    gap:12px;

    position:relative;

    overflow:hidden;

    min-height:90px;

    box-shadow:
    0 5px 18px rgba(15,23,42,.04);

}



.summary-card::before{

    content:"";

    position:absolute;

    left:0;

    top:0;

    height:100%;

    width:4px;

    background:#2563eb;

}



.summary-card:nth-child(2)::before{

    background:#f59e0b;

}


.summary-card:nth-child(3)::before{

    background:#16a34a;

}


.summary-card:nth-child(4)::before{

    background:#dc2626;

}


.summary-card:nth-child(5)::before{

    background:#7c3aed;

}



.summary-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    flex-shrink:0;

}


.summary-card:nth-child(1) .summary-icon{

    background:#dbeafe;

}


.summary-card:nth-child(2) .summary-icon{

    background:#fef3c7;

}


.summary-card:nth-child(3) .summary-icon{

    background:#dcfce7;

}


.summary-card:nth-child(4) .summary-icon{

    background:#fee2e2;

}


.summary-card:nth-child(5) .summary-icon{

    background:#ede9fe;

}



.summary-card label{

    display:block;

    font-size:10px;

    font-weight:700;

    color:#64748b;

}



.summary-card h2{

    margin:5px 0 2px;

    font-size:21px;

    font-weight:800;

    color:#172033;

}



.summary-card small{

    font-size:9px;

    color:#94a3b8;

}



/* =========================
PANEL
========================= */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px;

    margin-bottom:18px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.04);

}



.panel-title{

    font-size:15px;

    font-weight:800;

    color:#172033;

    border-left:4px solid #334155;

    padding-left:10px;

}



.panel-header small{

    display:block;

    margin-top:6px;

    margin-left:14px;

    color:#94a3b8;

    font-size:11px;

}



/* =========================
FILTER
========================= */


.filter-box{

    display:flex;

    align-items:flex-end;

    gap:12px;

    flex-wrap:wrap;

    margin-top:18px;

}



.filter-box > div{

    min-width:220px;

}



.filter-box label{

    display:block;

    margin-bottom:6px;

    font-size:10px;

    font-weight:700;

    color:#64748b;

}



.filter-box input,
.filter-box select{

    height:42px;

    width:100%;

    padding:0 12px;

    border-radius:10px;

    border:1px solid #cbd5e1;

    font-size:11px;

    background:white;

}



.filter-box button,
.filter-box a{


    height:42px;

    padding:0 18px;

    border-radius:10px;

    border:none;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.filter-box button{

    background:#334155;

    color:white;

}



.filter-box a{

    background:#f1f5f9;

    color:#334155;

}



/* =========================
TABLE
========================= */


.table-wrapper{

    overflow-x:auto;

    border:1px solid #e2e8f0;

    border-radius:15px;

}



table{

    width:100%;

    min-width:1050px;

    border-collapse:collapse;

}



thead th{

    background:#f8fafc;

    padding:13px;

    font-size:10px;

    font-weight:800;

    color:#64748b;

    text-align:left;

    white-space:nowrap;

}



tbody td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:11px;

    color:#475569;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    color:#172033;

}



td small{

    color:#94a3b8;

}



/* =========================
MONEY
========================= */


.money{

    font-weight:800;

    color:#15803d;

    white-space:nowrap;

}



/* =========================
STATUS
========================= */


.status{

    display:inline-flex;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    white-space:nowrap;

}



.pending{

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



/* =========================
BUTTON
========================= */


.detail-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 14px;

    background:#334155;

    color:white;

    border-radius:9px;

    font-size:10px;

    font-weight:700;

    text-decoration:none;

}



.detail-btn:hover{

    background:#0f172a;

}



/* =========================
EMPTY
========================= */


.empty{

    text-align:center;

    padding:50px;

}



.empty-icon{

    font-size:40px;

}


.empty h3{

    font-size:15px;

    color:#172033;

}



.empty p{

    font-size:11px;

    color:#94a3b8;

}



.create-mini{

    display:inline-block;

    margin-top:10px;

    padding:9px 15px;

    background:#334155;

    color:white;

    border-radius:10px;

    text-decoration:none;

    font-size:10px;

}






/* =========================
TABLET
========================= */


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:
    repeat(3,1fr);

}


}





/* =========================
MOBILE
========================= */


@media(max-width:900px){


.welcome-card{

    flex-direction:column;

    align-items:stretch;

}



.create-btn{

    width:100%;

    text-align:center;

}



.summary-grid{

    grid-template-columns:
    repeat(2,1fr);

}



.filter-box{

    flex-direction:column;

    align-items:stretch;

}



.filter-box > div{

    width:100%;

}



.filter-box button,
.filter-box a{

    width:100%;

}



.glass-panel{

    padding:16px;

}



}




@media(max-width:600px){



.welcome-card{

    padding:18px;

    border-radius:18px;

}



.welcome-card h1{

    font-size:20px;

}



.welcome-card p{

    font-size:11px;

}



.welcome-tags span{

    font-size:8px;

}



.summary-grid{

    grid-template-columns:
    1fr;

    gap:10px;

}



.summary-card{

    min-height:90px;

    padding:15px;

}



.summary-card h2{

    font-size:20px;

}



.summary-icon{

    width:40px;

    height:40px;

}



.glass-panel{

    padding:14px;

    border-radius:16px;

}



.panel-title{

    font-size:13px;

}



table{

    min-width:1050px;

}



thead th{

    font-size:8px;

    padding:10px;

}



tbody td{

    font-size:9px;

    padding:10px;

}



.status{

    font-size:8px;

}



.detail-btn{

    font-size:8px;

    padding:7px 10px;

}



}




</style>
@endsection