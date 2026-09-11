@extends('layouts.dashboard')

@section('content')

<div class="approval-page">


{{-- HEADER --}}

<div class="welcome-card">

    <div class="welcome-label">
        FINANCE CONTROL
    </div>

    <h1>
        Approval Pengajuan Dana
    </h1>

    <p>
        Kelola verifikasi, persetujuan, dan proses pencairan dana perusahaan.
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





@if(isset($banks) && $banks->count() === 0)

<div class="alert warning">

Belum ada rekening bank aktif.
Pengajuan yang sudah disetujui belum dapat dicairkan.

</div>

@endif





{{-- SUMMARY --}}

<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon pending">

⏳

</div>

<div>

<label>
Pending Approval
</label>


<h2>
{{ $requests->where('status','pending')->count() }}
</h2>


<small>
Menunggu keputusan finance
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
{{ $requests->where('status','approved')->count() }}
</h2>


<small>
Menunggu pencairan
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon money">

Rp

</div>


<div>

<label>
Total Dana
</label>


<h2 class="money-text">

Rp {{number_format(
$requests->sum('jumlah'),
0,
',',
'.'
)}}

</h2>


<small>
Total nominal pengajuan
</small>


</div>

</div>





<div class="summary-card">

<div class="summary-icon">

#

</div>


<div>

<label>
Total Request
</label>


<h2>

{{$requests->count()}}

</h2>


<small>
Data pengajuan
</small>


</div>

</div>


</div>







{{-- TABLE --}}

<div class="glass-panel">


<div class="panel-header">

<div class="panel-title">

Daftar Pengajuan Dana

</div>


<div class="panel-subtitle">

Pengajuan yang membutuhkan proses finance

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

<strong class="number">

{{$request->nomor_pengajuan ?? '-'}}

</strong>

</td>





<td>

<div class="employee">

{{$request->pengguna->name ?? '-'}}

</div>


<small>

{{$request->judul ?? '-'}}

</small>


</td>





<td>

<div class="project">

{{$request->proyek->nama_proyek ?? '-'}}

</div>


<small>

{{$request->proyek->perusahaan->nama_perusahaan ?? ''}}

</small>


</td>





<td>

<span class="division">

{{$request->divisi->nama_divisi ?? '-'}}

</span>

</td>





<td>

<strong class="nominal">

Rp {{number_format(
$request->jumlah,
0,
',',
'.'
)}}

</strong>

</td>





<td>


@if($request->status=='pending')

<span class="status pending">
Menunggu
</span>


@elseif($request->status=='approved')

<span class="status approved">
Disetujui
</span>


@elseif($request->status=='rejected')

<span class="status rejected">
Ditolak
</span>


@else

<span class="status done">
Selesai
</span>


@endif


</td>





<td>

<div class="date">

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</div>


<small>

{{\Carbon\Carbon::parse($request->created_at)->format('H:i')}}

</small>


</td>





<td>


<div class="action-box">


<a href="{{route('expense.approval.detail',$request->id)}}"
class="detail-btn">

Detail

</a>





@if($request->status=='pending')


<div class="approval-action">


<form method="POST"
action="{{route('expense.approve',$request->id)}}">

@csrf


<button class="approve-btn"
onclick="return confirm('Setujui pengajuan ini?')">

Setujui

</button>


</form>



<button class="reject-btn"
onclick="openReject({{$request->id}})">

Tolak

</button>


</div>


@endif





@if($request->status=='approved')


<form method="POST"
action="{{route('expense.disburse',$request->id)}}"
class="disburse-form">


@csrf


<select name="rekening_bank_id"
class="bank-select"
required>


<option value="">
Pilih Bank
</option>


@foreach($banks as $bank)

<option value="{{$bank->id}}">

{{$bank->nama_bank}}
-
Rp {{number_format($bank->saldo,0,',','.')}}

</option>

@endforeach


</select>



<button class="disburse-btn">

Cairkan

</button>


</form>

<form method="POST"
action="{{route('expense.cancelApproval',$request->id)}}">

@csrf
@method('PUT')

<button 
class="cancel-approve-btn"
onclick="return confirm('Kembalikan pengajuan ini ke status pending?')">

Kembalikan Pending

</button>

</form>


@endif



</div>


</td>


</tr>


@empty


<tr>

<td colspan="8">

<div class="empty">

Belum Ada Pengajuan Dana

</div>

</td>

</tr>


@endforelse


</tbody>


</table>


</div>


</div>

<style>


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
   ALERT
========================= */


.alert{

padding:15px;

border-radius:16px;

margin-bottom:20px;

font-size:12px;

font-weight:700;

}


.alert.warning{

background:#fef3c7;

color:#92400e;

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


.summary-icon.pending{

background:#fef3c7;

}


.summary-icon.success{

background:#dcfce7;

}


.summary-icon.money{

background:#dbeafe;

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



.number{

color:#334155;

}



.employee{

font-weight:700;

}



.project{

font-weight:700;

}



small{

color:#94a3b8;

font-size:10px;

}



.nominal{

color:#166534;

}



.division{

background:#f1f5f9;

padding:5px 10px;

border-radius:999px;

font-size:10px;

font-weight:700;

}





/* =========================
   STATUS
========================= */


.status{

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

display:inline-flex;

}



.status.pending{

background:#fef3c7;

color:#92400e;

}


.status.approved{

background:#dcfce7;

color:#166534;

}


.status.rejected{

background:#fee2e2;

color:#991b1b;

}


.status.done{

background:#dbeafe;

color:#1d4ed8;

}





/* =========================
   ACTION
========================= */


.action-box{

width:180px;

display:flex;

flex-direction:column;

gap:8px;

}



.detail-btn,
.approve-btn,
.reject-btn,
.disburse-btn{

height:34px;

border:none;

border-radius:10px;

font-size:11px;

font-weight:800;

cursor:pointer;

display:flex;

align-items:center;

justify-content:center;

text-decoration:none;

}



.detail-btn{

background:#334155;

color:white;

}



.approval-action{

display:grid;

grid-template-columns:1fr 1fr;

gap:8px;

}



.approval-action form{

margin:0;

}



.approve-btn{

background:#16a34a;

color:white;

width:100%;

}



.reject-btn{

background:#dc2626;

color:white;

width:100%;

}



.disburse-form{

display:flex;

flex-direction:column;

gap:8px;

}



.bank-select{

height:34px;

border-radius:10px;

border:1px solid #cbd5e1;

padding:0 10px;

font-size:11px;

}



.disburse-btn{

background:#2563eb;

color:white;

}




.cancel-approve-btn{

    width:100%;

    height:34px;

    border:none;

    border-radius:10px;

    font-size:11px;

    font-weight:800;

    cursor:pointer;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    background:#f59e0b;

    color:white;

    transition:.2s ease;

    box-shadow:0 4px 12px rgba(245,158,11,.25);

}



.cancel-approve-btn:hover{

    background:#d97706;

    transform:translateY(-1px);

    box-shadow:0 6px 16px rgba(245,158,11,.35);

}


.empty{

text-align:center;

padding:30px;

color:#94a3b8;

font-size:13px;

}







/* =========================
   MODAL REJECT
========================= */


.modal{

display:none;

position:fixed;

inset:0;

background:rgba(15,23,42,.45);

align-items:center;

justify-content:center;

z-index:999;

}



.modal-box{

background:white;

width:400px;

padding:25px;

border-radius:20px;

}



.modal-box h3{

margin-top:0;

}



.modal-box textarea{

width:100%;

height:100px;

border-radius:12px;

border:1px solid #cbd5e1;

padding:10px;

resize:none;

}



.modal-action{

display:flex;

gap:10px;

margin-top:15px;

}



.modal-action button{

flex:1;

height:36px;

border:none;

border-radius:10px;

font-weight:700;

cursor:pointer;

}



.cancel-btn{

background:#e2e8f0;

}



.reject-submit-btn{

background:#dc2626;

color:white;

}





@media(max-width:1100px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:700px){


.summary-grid{

grid-template-columns:1fr;

}


.action-box{

width:150px;

}


}



</style>





{{-- MODAL REJECT --}}

<div class="modal" id="rejectModal">


<div class="modal-box">


<h3>
Alasan Penolakan
</h3>



<form method="POST"
id="rejectForm">

@csrf



<textarea
name="catatan_persetujuan"
placeholder="Masukkan alasan penolakan..."
required></textarea>



<div class="modal-action">


<button
type="button"
class="cancel-btn"
onclick="closeReject()">

Batal

</button>



<button
class="reject-submit-btn">

Tolak Pengajuan

</button>


</div>


</form>



</div>


</div>





<script>

function openReject(id)
{

    let modal = document.getElementById('rejectModal');

    let form = document.getElementById('rejectForm');


    form.action =
    "/expense/" + id + "/reject";


    modal.style.display="flex";

}



function closeReject()

{

    document.getElementById('rejectModal')
    .style.display="none";

}



</script>


@endsection