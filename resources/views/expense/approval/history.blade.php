@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

    <div>

        <div class="welcome-label">
            RIWAYAT APPROVAL FINANCE
        </div>


        <h1>
            Riwayat Approval Pengajuan Dana
        </h1>


        <p>
            Monitoring seluruh keputusan persetujuan dana karyawan.
        </p>


        <div class="welcome-tags">

            <span>
                ✓ Approved
            </span>

            <span>
                ✓ Rejected
            </span>

            <span>
                ✓ Audit Keuangan
            </span>

        </div>


    </div>


</div>



@if(session('success'))

<div class="success-box">
    {{session('success')}}
</div>

@endif



@if(session('error'))

<div class="error-box">
    {{session('error')}}
</div>

@endif





{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
📄
</div>


<div>

<label>
Total Diproses
</label>


<h2>
{{$requests->count()}}
</h2>


<small>
Seluruh approval
</small>


</div>


</div>





<div class="summary-card">

<div class="summary-icon">
✅
</div>


<div>

<label>
Approved
</label>


<h2>
{{$requests->whereIn('status',['approved','selesai'])->count()}}
</h2>


<small>
Disetujui finance
</small>


</div>


</div>





<div class="summary-card">

<div class="summary-icon">
❌
</div>


<div>

<label>
Rejected
</label>


<h2>
{{$requests->where('status','rejected')->count()}}
</h2>


<small>
Ditolak finance
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
Rp {{number_format($requests->sum('jumlah'),0,',','.')}}
</h2>


<small>
Nilai pengajuan
</small>


</div>


</div>



</div>





{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">
🔎 Filter Riwayat Approval
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
placeholder="Nama karyawan..."
value="{{request('search')}}"
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


@foreach($projects as $project)

<option value="{{$project->id}}"
{{request('proyek_id')==$project->id?'selected':''}}>

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


@foreach($divisions as $division)


<option value="{{$division->id}}"
{{request('divisi_id')==$division->id?'selected':''}}>


{{$division->nama_divisi}}


</option>


@endforeach


</select>


</div>



<div>

<label>
Status
</label>


<div class="status-action">


<select name="status">


<option value="">
Semua Status
</option>



<option value="approved"
{{request('status')=='approved'?'selected':''}}>
Approved
</option>



<option value="rejected"
{{request('status')=='rejected'?'selected':''}}>
Rejected
</option>


<option value="selesai"
{{request('status')=='selesai'?'selected':''}}>
Dana Dicairkan
</option>

</select>



<button type="submit">
🔎
</button>



<a href="{{route('expense.approval.history')}}">
Reset
</a>


</div>


</div>



</div>


</form>


</div>


{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">

<div class="panel-title">
📄 Riwayat Pengajuan Dana
</div>


<small>
Daftar pengajuan yang sudah diproses finance
</small>


</div>





<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
Tanggal
</th>


<th>
Pemohon
</th>


<th>
Perusahaan
</th>


<th>
Project
</th>


<th>
Nominal
</th>


<th>
Status
</th>


<th>
Disetujui Oleh
</th>


<th>
Catatan
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

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>





<td>


<strong>

{{$request->pengguna?->name ?? '-'}}

</strong>


<br>


<small>

{{$request->judul}}

</small>


</td>





<td>


{{$request->proyek?->perusahaan?->nama_perusahaan ?? '-'}}


</td>





<td>


<strong>

{{$request->proyek?->nama_proyek ?? '-'}}

</strong>


<br>


<span class="divisi">

{{$request->divisi?->nama_divisi ?? '-'}}

</span>


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

@if($request->status=='approved')

<span class="status approved">
✓ Approved
</span>


@elseif($request->status=='selesai')

<span class="status selesai">
💰 Dana Dicairkan
</span>


@elseif($request->status=='rejected')

<span class="status rejected">
✕ Rejected
</span>


@else

<span class="status pending">
⏳ Pending
</span>

@endif

</td>







<td>


{{$request->penyetuju?->name ?? '-'}}


<br>


<small>


@if($request->disetujui_pada)

{{\Carbon\Carbon::parse($request->disetujui_pada)
->format('d M Y H:i')}}


@endif


</small>


</td>







<td>


@if($request->catatan_persetujuan)


<div class="note-box">

{{$request->catatan_persetujuan}}

</div>


@else

-

@endif


</td>







<td>


<a href="{{route('expense.approval.detail',$request->id)}}"

class="detail-btn">

Detail

</a>


</td>





</tr>




@empty



<tr>


<td colspan="9" class="empty">


<div class="empty-icon">
📄
</div>


<h3>

Belum Ada Riwayat Approval

</h3>


<p>

Belum ada pengajuan yang sudah diproses.

</p>


</td>


</tr>


@endforelse




</tbody>


</table>


</div>


</div>


<style>


/* ===============================
WELCOME
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

    font-size:26px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}



.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    padding:7px 14px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    color:#334155;

}





/* ===============================
SUMMARY
================================ */



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

    position:relative;

    overflow:hidden;

    box-shadow:
    0 10px 25px rgba(15,23,42,.05);

}



.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    height:4px;

    width:100%;

    background:#334155;

}



.summary-icon{

    width:45px;

    height:45px;

    border-radius:14px;

    background:#f1f5f9;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:5px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}



.summary-card small{

    font-size:10px;

    color:#94a3b8;

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
    0 10px 30px rgba(15,23,42,.05);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

}



.panel-header small{

    color:#94a3b8;

    font-size:11px;

}



/* ===============================
FILTER
================================ */



.filter-grid{

    display:grid;

    grid-template-columns:1.3fr 1fr 1fr 1.2fr;

    gap:15px;

    align-items:end;

}



.filter-grid label{

    display:block;

    margin-bottom:7px;

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



.filter-grid input,

.filter-grid select{

    width:100%;

    height:42px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    padding:0 12px;

    font-size:12px;

}



.status-action{

    display:flex;

    gap:8px;

}



.status-action button{

    width:42px;

    height:42px;

    border:none;

    border-radius:12px;

    background:#1e293b;

    color:white;

    cursor:pointer;

}



.status-action a{

    display:flex;

    align-items:center;

    padding:0 15px;

    background:#f1f5f9;

    color:#334155;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

}





/* ===============================
TABLE
================================ */



.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:separate;

    border-spacing:0;

}



thead th{

    background:#f8fafc;

    padding:14px 16px;

    font-size:11px;

    font-weight:800;

    color:#64748b;

    text-align:left;

    border-bottom:1px solid #e2e8f0;

}



tbody td{

    padding:16px;

    font-size:12px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

    vertical-align:middle;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    color:#172033;

}



td small{

    color:#94a3b8;

    font-size:10px;

}



.divisi{

    font-size:10px;

    color:#64748b;

}





/* ===============================
MONEY
================================ */



.money{

    font-weight:800;

    color:#15803d;

    white-space:nowrap;

}





/* ===============================
STATUS
================================ */



.status{

    display:inline-flex;

    padding:7px 14px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.status.approved{

    background:#dcfce7;

    color:#166534;

}

.status.selesai{

    background:#dbeafe;

    color:#1d4ed8;

}

.status.rejected{

    background:#fee2e2;

    color:#b91c1c;

}



.status.pending{

    background:#fef3c7;

    color:#92400e;

}





/* ===============================
BUTTON
================================ */



.detail-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    background:#334155;

    color:white;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.detail-btn:hover{

    background:#1e293b;

}



/* ===============================
NOTE
================================ */



.note-box{

    max-width:220px;

    padding:10px;

    border-radius:12px;

    background:#f8fafc;

    font-size:11px;

    color:#475569;

}



/* ===============================
ALERT
================================ */



.success-box{

    background:#dcfce7;

    color:#166534;

    padding:14px;

    border-radius:14px;

    margin-bottom:20px;

}



.error-box{

    background:#fee2e2;

    color:#991b1b;

    padding:14px;

    border-radius:14px;

    margin-bottom:20px;

}



/* ===============================
EMPTY
================================ */



.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

}



.empty-icon{

    font-size:40px;

}



/* ===============================
RESPONSIVE
================================ */



@media(max-width:1100px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


.filter-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:700px){


.summary-grid{

    grid-template-columns:1fr;

}


.filter-grid{

    grid-template-columns:1fr;

}


.status-action{

    flex-direction:column;

}


}



</style>
@endsection