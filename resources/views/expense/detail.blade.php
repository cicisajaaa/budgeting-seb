@extends('layouts.dashboard')

@section('content')

<div class="detail-container detail-page">


{{-- ================= HEADER ================= --}}

<div class="detail-header">

<div class="header-left">


<div class="header-label">

PENGAJUAN DANA #{{ str_pad($request->id,4,'0',STR_PAD_LEFT) }}

</div>



<h1>

{{ $request->judul }}

</h1>



<p>

{{ $request->created_at->format('d M Y, H:i') }}

</p>



<div class="requester">

{{ $request->pengguna->name ?? 'Pengguna' }}

</div>


</div>




<div class="header-right">


<div class="amount-card">


<small>

Total Pengajuan

</small>


<strong>

Rp {{ number_format($request->jumlah,0,',','.') }}

</strong>


</div>




@if($request->status == 'pending')


<div class="status pending">

Menunggu Persetujuan

</div>


@elseif($request->status == 'approved')


<div class="status approved">

Dana Disetujui

</div>


@else


<div class="status rejected">

Pengajuan Ditolak

</div>


@endif


</div>


</div>









{{-- ================= TIMELINE ================= --}}


<div class="timeline-box">


<div class="timeline-step active">

✓ Pengajuan dibuat

</div>



<div class="timeline-step

{{ $request->status != 'pending' ? 'active':'' }}">

✓ Diproses Finance

</div>



<div class="timeline-step

{{ $request->status == 'approved' ? 'active':'' }}">

✓ Dana Disetujui

</div>


</div>









{{-- ================= DETAIL PENGAJUAN + BUDGET ================= --}}


<div class="card">


<div class="card-title">

Detail Pengajuan

</div>




<div class="info-grid">






{{-- PERUSAHAAN --}}


<div class="info-item">


<div class="detail-icon">

🏢

</div>


<div>


<label>

Perusahaan

</label>


<strong>

{{ $request->proyek->perusahaan->nama_perusahaan ?? '-' }}

</strong>


</div>


</div>







{{-- PROJECT --}}


<div class="info-item">


<div class="detail-icon">

📁

</div>


<div>


<label>

Project

</label>


<strong>

{{ $request->proyek->nama_proyek ?? '-' }}

</strong>


</div>


</div>








{{-- DIVISI --}}


<div class="info-item">


<div class="detail-icon">

🏬

</div>


<div>


<label>

Divisi

</label>


<strong>

{{ $request->divisi->nama_divisi ?? '-' }}

</strong>


</div>


</div>







{{-- JUMLAH PENGAJUAN --}}


<div class="info-item">


<div class="detail-icon">

💰

</div>


<div>


<label>

Jumlah Dana

</label>


<strong class="money">

Rp {{ number_format($request->jumlah,0,',','.') }}

</strong>


</div>


</div>








{{-- TOTAL BUDGET PROJECT --}}


<div class="info-item">


<div class="detail-icon">

💼

</div>


<div>


<label>

Total Budget Project

</label>


<strong>

Rp {{ number_format($request->proyek->total_anggaran ?? 0,0,',','.') }}

</strong>


</div>


</div>








{{-- REALISASI --}}


<div class="info-item">


<div class="detail-icon">

📊

</div>


<div>


<label>

Total Realisasi Dana

</label>


<strong>

Rp {{ number_format($request->proyek->total_realisasi ?? 0,0,',','.') }}

</strong>


</div>


</div>








{{-- SISA BUDGET --}}


<div class="info-item">


<div class="detail-icon">

💳

</div>


<div>


<label>

Sisa Budget

</label>


<strong class="money">
    

Rp {{ number_format($request->proyek->sisa_budget ?? 0,0,',','.') }}


</strong>


</div>


</div>








{{-- TANGGAL --}}


<div class="info-item">


<div class="detail-icon">

📅

</div>


<div>


<label>

Tanggal Pengajuan

</label>


<strong>

{{ $request->created_at->format('d M Y') }}

</strong>


</div>


</div>




</div>








<div class="description-box">


<label>

Keterangan

</label>


<p>

{{ $request->keterangan ?? '-' }}

</p>


</div>



</div>









{{-- ================= DOKUMEN ================= --}}


<div class="card">


<div class="card-title">

Dokumen Pendukung

</div>




@if($request->bukti_pengajuan)



@php

$filePath = public_path(
'uploads/pengajuan/'.$request->bukti_pengajuan
);


$fileSize = file_exists($filePath)

?

number_format(filesize($filePath)/1024,1).' KB'

:

'-';


@endphp






<div class="file-card">


<div class="file-detail">


<div class="file-icon">

FILE

</div>



<div>


<strong>

{{ $request->bukti_pengajuan }}

</strong>


<small>

Lampiran transaksi • {{ $fileSize }}

</small>


</div>


</div>




<button

onclick="openProof()"

class="btn-view">

Lihat Bukti

</button>



</div>




@else


<div class="empty">

Tidak ada dokumen pendukung

</div>


@endif



</div>
{{-- ================= MODAL BUKTI ================= --}}

@if($request->bukti_pengajuan)

<div id="modalProof" class="modal">


<div class="modal-content">


<div class="modal-head">


<strong>

Preview Bukti

</strong>




<button

onclick="closeProof()"

class="btn-close">

×

</button>



</div>




@if(Str::endsWith($request->bukti_pengajuan,'.pdf'))


<iframe

src="{{ asset('uploads/pengajuan/'.$request->bukti_pengajuan) }}"

width="100%"

height="600">

</iframe>



@else



<img

src="{{ asset('uploads/pengajuan/'.$request->bukti_pengajuan) }}">



@endif



</div>


</div>


@endif







{{-- ================= AUDIT TRAIL ================= --}}


<div class="card">


<div class="card-title">

Audit Trail Aktivitas

</div>



<div class="audit-list">



@forelse($request->auditLogs as $log)



<div class="audit-card">


<div class="audit-icon">

✓

</div>




<div class="audit-content">


<div class="audit-header">


<strong>

{{ $log->aksi }}

</strong>



<span>

{{ $log->modul }}

</span>



</div>




<p>

{{ $log->deskripsi }}

</p>




<div class="audit-meta">


{{ $log->pengguna->name ?? 'System' }}


•

{{ $log->created_at->format('d M Y H:i') }}



</div>



</div>


</div>



@empty



<div class="empty">

Belum ada aktivitas

</div>



@endforelse



</div>



</div>









{{-- ================= KEPUTUSAN FINANCE ================= --}}


@if($request->status != 'pending')


<div class="card decision-card">


<div class="card-title">

Keputusan Finance

</div>






<div class="decision-header">



@if($request->status == 'approved')



<div class="decision-icon success">

✓

</div>




<div>


<strong>

Pengajuan Disetujui

</strong>



<p>

Dana berhasil diverifikasi Finance

</p>



</div>




@else



<div class="decision-icon failed">

×

</div>




<div>


<strong>

Pengajuan Ditolak

</strong>



<p>

Pengajuan tidak dapat diproses

</p>



</div>




@endif



</div>









<div class="decision-note">


<label>

Catatan

</label>


<p>

{{ $request->catatan_persetujuan ?? 'Tidak ada catatan tambahan' }}

</p>


</div>








<div class="decision-info">


<div>


<label>

Diproses Oleh

</label>


<strong>

{{ $request->penyetuju->name ?? 'Finance' }}

</strong>


</div>





<div>


<label>

Tanggal

</label>


<strong>

{{ $request->disetujui_pada?->format('d M Y H:i') ?? '-' }}

</strong>


</div>



</div>



</div>



@endif







<a href="

@if(auth()->user()->role == 'karyawan')

{{ route('expense.myhistory') }}


@elseif(
auth()->user()->role == 'keuangan' ||
auth()->user()->role == 'bendahara'
)


{{ route('expense.approval') }}


@else


{{ route('dashboard') }}


@endif

"

class="back">


← Kembali


</a>



</div>









<script>


function openProof(){

    document
    .getElementById('modalProof')
    .style.display='flex';

}



function closeProof(){

    document
    .getElementById('modalProof')
    .style.display='none';

}


</script>



@endsection





<style>

/* =================================
GLOBAL
================================= */

*{
    box-sizing:border-box;
}

.detail-container{
    width:100%;
}



/* =================================
HEADER
================================= */


.detail-header{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:20px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.header-label{

    font-size:10px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.header-left h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.header-left p{

    margin:0;

    font-size:12px;

    color:#64748b;

}



.requester{

    margin-top:12px;

    display:inline-flex;

    padding:7px 14px;

    background:#f1f5f9;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

    color:#334155;

}




/* =================================
AMOUNT
================================= */


.header-right{

    text-align:right;

}



.amount-card{

    background:white;

    padding:18px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}



.amount-card small{

    display:block;

    font-size:11px;

    color:#64748b;

}



.amount-card strong{

    display:block;

    margin-top:8px;

    font-size:22px;

    color:#1e293b;

}





/* =================================
STATUS
================================= */


.status{

    display:inline-flex;

    padding:7px 14px;

    margin-top:12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

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

    color:#b91c1c;

}






/* =================================
TIMELINE
================================= */


.timeline-box{

    background:white;

    padding:18px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin-bottom:20px;

}



.timeline-step{

    text-align:center;

    padding:12px;

    border-radius:14px;

    background:#f8fafc;

    color:#94a3b8;

    font-size:11px;

    font-weight:700;

}



.timeline-step.active{

    background:#dcfce7;

    color:#166534;

}






/* =================================
CARD PANEL OWNER STYLE
================================= */


.card{

    background:white;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.card-title{

    font-size:16px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:20px;

}






/* =================================
INFO GRID
================================= */


.info-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:15px;

}



.info-item{

    display:flex;

    align-items:center;

    gap:12px;

    padding:15px;

    background:#f8fafc;

    border-radius:16px;

}



.detail-icon{

    width:42px;

    height:42px;

    border-radius:14px;

    background:white;

    display:flex;

    align-items:center;

    justify-content:center;

}



.info-item label{

    display:block;

    font-size:10px;

    color:#94a3b8;

}



.info-item strong{

    display:block;

    margin-top:4px;

    font-size:13px;

    color:#1e293b;

}



.money{

    color:#15803d!important;

}





/* =================================
DESCRIPTION
================================= */


.description-box{

    margin-top:20px;

    padding:16px;

    background:#f8fafc;

    border-radius:16px;

}



.description-box label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



.description-box p{

    margin:8px 0 0;

    font-size:13px;

    color:#334155;

}






/* =================================
DOCUMENT
================================= */


.file-card{

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.file-detail{

    display:flex;

    align-items:center;

    gap:12px;

}



.file-icon{

    width:42px;

    height:42px;

    background:white;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:11px;

    font-weight:800;

}



.file-detail small{

    display:block;

    color:#94a3b8;

}



.btn-view{

    background:#334155;

    color:white;

    border:none;

    padding:9px 18px;

    border-radius:10px;

    font-size:12px;

    font-weight:700;

}





/* =================================
AUDIT TRAIL
================================= */


.audit-list{

    position:relative;

    padding-left:35px;

}



.audit-list:before{

    content:"";

    position:absolute;

    left:13px;

    top:0;

    bottom:0;

    width:2px;

    background:#e2e8f0;

}



.audit-card{

    background:#f8fafc;

    padding:15px;

    border-radius:16px;

    margin-bottom:12px;

    position:relative;

}



.audit-icon{

    position:absolute;

    left:-35px;

    width:28px;

    height:28px;

    border-radius:50%;

    background:#16a34a;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:12px;

}



.audit-header{

    display:flex;

    justify-content:space-between;

}



.audit-header strong{

    font-size:13px;

}



.audit-header span{

    background:#dcfce7;

    color:#166534;

    padding:4px 10px;

    border-radius:999px;

    font-size:10px;

}



.audit-content p{

    margin:8px 0;

    font-size:12px;

    color:#475569;

}



.audit-meta{

    font-size:11px;

    color:#94a3b8;

}





/* =================================
DECISION FINANCE
================================= */


.decision-header{

    display:flex;

    align-items:center;

    gap:15px;

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

}



.decision-icon{

    width:42px;

    height:42px;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

}



.success{

    background:#dcfce7;

    color:#166534;

}



.failed{

    background:#fee2e2;

    color:#b91c1c;

}



.decision-note,
.decision-info div{

    margin-top:15px;

    background:#f8fafc;

    padding:15px;

    border-radius:16px;

}



.decision-info{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:15px;

}



.decision-info label{

    font-size:11px;

    color:#64748b;

}



.decision-info strong{

    display:block;

    margin-top:5px;

    font-size:13px;

}







/* =================================
BACK
================================= */


.back{

    display:inline-flex;

    padding:10px 20px;

    background:#334155;

    color:white;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}







/* =================================
MODAL
================================= */


.modal{

    display:none;

    position:fixed;

    inset:0;

    background:rgba(15,23,42,.6);

    align-items:center;

    justify-content:center;

    z-index:999;

}



.modal-content{

    background:white;

    padding:20px;

    border-radius:20px;

    width:80%;

}



.btn-close{

    background:#fee2e2;

    border:none;

    border-radius:10px;

    padding:5px 12px;

    color:#b91c1c;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:900px){


.detail-header{

    flex-direction:column;

    align-items:flex-start;

}


.info-grid,
.decision-info,
.timeline-box{

    grid-template-columns:1fr;

}


.file-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}

</style>