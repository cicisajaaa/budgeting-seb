@extends('layouts.dashboard')

@section('content')

<div class="approval-page">


{{-- ================= HEADER ================= --}}

<div class="welcome-card">

    <div class="welcome-label">
        FINANCE MONITORING
    </div>


    <h1>
        Riwayat Approval Dana
    </h1>


    <p>
        Monitoring seluruh proses persetujuan dan pencairan dana perusahaan.
    </p>


    <div class="welcome-tags">

        <span>
            ✓ Finance Approval
        </span>

        <span>
            ✓ Payment Control
        </span>

        <span>
            ✓ Audit Tracking
        </span>

    </div>

</div>



{{-- ================= SUMMARY ================= --}}


<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
#
</div>


<div>

<label>
Total Request
</label>


<h2>
{{ $requests->count() }}
</h2>


<small>
Data pengajuan
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon success">
✓
</div>


<div>

<label>
Approved
</label>


<h2>
{{ $requests->whereNotNull('disetujui_oleh')->count() }}
</h2>


<small>
Telah disetujui finance
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon money">
💰
</div>


<div>

<label>
Dana Dicairkan
</label>


<h2>
{{ $requests->where('status','selesai')->count() }}
</h2>


<small>
Selesai proses
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon pending">
Rp
</div>


<div>

<label>
Total Dana
</label>

<h2 class="money-text">

Rp {{ number_format(
    $requests->where('status','selesai')->sum('jumlah'),
    0,
    ',',
    '.'
)}}

</h2>


<small>
Nominal approval
</small>


</div>

</div>



</div>






{{-- ================= FILTER ================= --}}


<div class="glass-panel">


<div class="panel-header">


<div class="panel-title">
Filter Riwayat Approval
</div>


<div class="panel-subtitle">
Cari data approval berdasarkan kriteria.
</div>


</div>





<form method="GET"
action="{{route('expense.approval.history')}}">


<div class="filter-grid">



<div>

<label>
Cari Pemohon
</label>


<input
type="text"
name="search"
value="{{request('search')}}"
placeholder="Nama karyawan"
>


</div>





<div>

<label>
Project
</label>


<select name="proyek_id">


<option value="">
Semua Project
</option>


@foreach($projects ?? [] as $project)


<option value="{{$project->id}}"

{{request('proyek_id')==$project->id?'selected':''}}

>

{{$project->nama_proyek}}

</option>


@endforeach


</select>


</div>





<div>

<label>
Divisi
</label>


<select name="divisi_id">


<option value="">
Semua Divisi
</option>


@foreach($divisions ?? [] as $division)


<option value="{{$division->id}}"

{{request('divisi_id')==$division->id?'selected':''}}

>

{{$division->nama_divisi}}

</option>


@endforeach


</select>


</div>





<div>

<label>
Status
</label>


<select name="status">


<option value="">
Semua Status
</option>


<option value="approved"
{{request('status')=='approved'?'selected':''}}>
Approved
</option>


<option value="selesai"
{{request('status')=='selesai'?'selected':''}}>
Selesai
</option>


<option value="rejected"
{{request('status')=='rejected'?'selected':''}}>
Rejected
</option>

<option value="pending"
{{request('status')=='pending'?'selected':''}}>
Pending
</option>

</select>


</div>

<div class="filter-action">

    <button>
        🔎 Cari
    </button>

</div>


<div class="filter-action">

    <a href="{{route('expense.approval.history')}}">
        Reset
    </a>

</div>


</form>


</div>

{{-- ================= DATA RIWAYAT APPROVAL ================= --}}


<div class="glass-panel">


<div class="panel-header">

<div class="panel-title">
    Data Riwayat Approval
</div>


<div class="panel-subtitle">
    Daftar pengajuan yang sudah melalui proses finance.
</div>


</div>





<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Nomor
</th>


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
Rekening Cair
</th>

<th>
Status
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

{{ $request->nomor_pengajuan ?? 'REQ-'.$request->id }}

</strong>


</td>







<td>


<div class="user-box">


<div class="avatar">


{{ strtoupper(
substr(
$request->pengguna->name ?? 'U',
0,
1
)
) }}


</div>



<div>


<strong>

{{ $request->pengguna->name ?? '-' }}

</strong>



<small>

{{ $request->pengguna->email ?? '' }}

</small>


</div>


</div>


</td>








<td>


<strong>

{{ $request->proyek->nama_proyek ?? '-' }}

</strong>



@if($request->proyek?->perusahaan)


<small>

{{ $request->proyek->perusahaan->nama_perusahaan }}

</small>


@endif


</td>







<td>


<span class="division-badge">


{{ $request->divisi->nama_divisi ?? '-' }}


</span>


</td>







<td>


<strong class="nominal">


Rp {{ number_format(
$request->jumlah ?? 0,
0,
',',
'.'
) }}


</strong>


</td>

<td>

@if($request->transaksiDana->count())

@php
$transaksi = $request->transaksiDana->first();
@endphp


<div class="rekening-box">

<strong>
{{ $transaksi->rekeningBank->nama_bank ?? '-' }}
</strong>

<small>
{{ $transaksi->rekeningBank->nomor_rekening ?? '-' }}
</small>

</div>


@else

<span class="text-muted">
Belum dicairkan
</span>

@endif

</td>




<td>


@if($request->status == 'approved')


<span class="status success">

Approved

</span>



@elseif($request->status == 'selesai')


<span class="status done">

Selesai

</span>



@elseif($request->status == 'rejected')


<span class="status reject">

Rejected

</span>



@else


<span class="status waiting">

Pending

</span>



@endif



</td>








<td>


@if($request->created_at)


<strong>

{{ \Carbon\Carbon::parse(
$request->created_at
)->format('d M Y')
}}

</strong>


<small>

{{ \Carbon\Carbon::parse(
$request->created_at
)->format('H:i')
}}

</small>


@else

-

@endif



</td>








<td>


<a href="{{route(
'expense.approval.detail',
$request->id
)}}"

class="detail-btn"

>

Detail

</a>


</td>




</tr>



@empty



<tr>


<td colspan="9">


<div class="empty-state">

Belum ada riwayat approval.

</div>


</td>


</tr>



@endforelse



</tbody>



</table>



</div>



</div>



</div>

<style>

/* =========================
BASE
========================= */

.approval-page{

    width:100%;

    margin:0;

    padding:0 0 40px;

}

.welcome-card,
.summary-grid,
.glass-panel{

    width:100%;

}


*{

    box-sizing:border-box;

}





/* =========================
HEADER
========================= */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

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

    flex-wrap:wrap;

}



.welcome-tags span{

    background:white;

    border:1px solid #e2e8f0;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    color:#334155;

}








/* =========================
SUMMARY
========================= */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:18px;

    margin-bottom:25px;

}




.summary-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.05);

}




.summary-icon{

    width:45px;

    height:45px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

    font-size:18px;

    background:#f1f5f9;

}



.summary-icon.success{

    background:#dcfce7;

}



.summary-icon.money{

    background:#dbeafe;

}



.summary-icon.pending{

    background:#fef3c7;

}





.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:5px 0;

    font-size:18px;

    font-weight:800;

    color:#172033;

}



.summary-card small{

    font-size:10px;

    color:#94a3b8;

}



.money-text{

    font-size:16px!important;

}








/* =========================
PANEL
========================= */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.panel-header{

    margin-bottom:20px;

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

}



.panel-subtitle{

    font-size:11px;

    color:#94a3b8;

    margin-top:5px;

}






.filter-grid{

    display:grid;

    grid-template-columns:
    1.4fr 1fr 1fr 1fr auto auto;

    gap:14px;

    align-items:end;

}

.filter-grid > div{
    display:flex;
    flex-direction:column;
}


.filter-grid label{
    margin-bottom:8px;
    font-size:12px;
    font-weight:700;
    color:#475569;
}


.filter-grid input,
.filter-grid select{

    width:100%;
    height:44px;

    border-radius:12px;

    border:1px solid #cbd5e1;

    background:#ffffff;

    padding:0 14px;

    font-size:13px;

    color:#1e293b;

    transition:.2s;

}


.filter-grid input::placeholder{

    color:#94a3b8;

}


.filter-grid input:focus,
.filter-grid select:focus{

    outline:none;

    border-color:#64748b;

    box-shadow:
    0 0 0 3px rgba(100,116,139,.12);

}


.filter-action{

    display:flex;

    align-items:flex-end;

}


.filter-action button,
.filter-action a{

    height:44px;

    padding:0 22px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    display:flex;

    align-items:center;

    justify-content:center;

    text-decoration:none;

    white-space:nowrap;

}


.filter-action button{

    background:#334155;

    color:white;

    border:none;

}


.filter-action a{

    background:#f1f5f9;

    color:#475569;

}
/* BUTTON */
.filter-button{

    display:flex;

    gap:12px;

    margin-top:0;

}

.filter-grid{

    margin-bottom:20px;

}

.filter-button button,
.filter-button a{

    height:40px;

    padding:0 22px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    display:flex;

    align-items:center;

    justify-content:center;

    text-decoration:none;

}


.filter-button button{

    background:#334155;

    color:white;

    border:none;

    cursor:pointer;

}


.filter-button button:hover{

    background:#1e293b;

}


.filter-button a{

    background:#f1f5f9;

    color:#475569;

}


.filter-button a:hover{

    background:#e2e8f0;

}





/* =========================
TABLE
========================= */


.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



thead th{

    background:#f8fafc;

    padding:13px;

    font-size:11px;

    color:#64748b;

    text-align:left;

}



tbody td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    vertical-align:middle;

}



tbody tr:hover{

    background:#f8fafc;

}



small{

    display:block;

    color:#94a3b8;

    font-size:10px;

    margin-top:3px;

}



.rekening-box{

    background:#f8fafc;

    padding:8px 10px;

    border-radius:10px;

    border:1px solid #e2e8f0;

}


.rekening-box strong{

    font-size:12px;

    color:#1e293b;

}


.rekening-box small{

    font-size:10px;

    color:#64748b;

}



/* =========================
USER
========================= */


.user-box{

    display:flex;

    align-items:center;

    gap:10px;

}



.avatar{

    width:36px;

    height:36px;

    border-radius:50%;

    background:#e2e8f0;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:800;

}







/* =========================
BADGE
========================= */


.division-badge{

    background:#f1f5f9;

    padding:5px 10px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.nominal{

    color:#166534;

}





.status{

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    display:inline-flex;

}



.status.success{

    background:#dcfce7;

    color:#166534;

}



.status.done{

    background:#dbeafe;

    color:#1d4ed8;

}



.status.reject{

    background:#fee2e2;

    color:#991b1b;

}



.status.waiting{

    background:#fef3c7;

    color:#92400e;

}







/* =========================
BUTTON
========================= */


.detail-btn{

    height:34px;

    padding:0 18px;

    border-radius:10px;

    background:#334155;

    color:white;

    text-decoration:none;

    font-size:11px;

    font-weight:800;

    display:flex;

    align-items:center;

    justify-content:center;

}





.empty-state{

    text-align:center;

    padding:30px;

    color:#94a3b8;

    font-size:13px;

}








/* =========================
RESPONSIVE
========================= */


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


.filter-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:700px){


.approval-page{

    padding:18px 14px;

}



.welcome-card{

    padding:20px;

}



.welcome-card h1{

    font-size:20px;

}



.summary-grid{

    grid-template-columns:1fr;

}



.glass-panel{

    padding:18px;

}



.filter-grid{

    grid-template-columns:1fr;

}



.filter-button{

    flex-direction:column;

}



.table-wrapper{

    overflow-x:auto;

}



table{

    min-width:1000px;

}



}



</style>

@endsection 