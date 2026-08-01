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





{{-- ================= DETAIL ================= --}}

<div class="card" style="overflow:visible;">

<div class="card-title">
    Detail Pengajuan
</div>


<div class="info-grid">


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




<div class="info-item">

<div class="detail-icon">
🏢
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
? number_format(filesize($filePath)/1024,1).' KB'
:'-';


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






{{-- ================= MODAL ================= --}}

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
Diproses oleh
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







<a href="{{ route('expense.myhistory') }}" class="back">

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
<style>

/* =========================
GLOBAL
========================= */

.detail-container{
    width:100%;
    max-width:100%;
}


*{
    box-sizing:border-box;
}


/* =========================
HEADER DETAIL
========================= */

.detail-header{

    width:100%;

    background:#ffffff;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:34px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:35px;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.06);

}



.header-left{

    flex:1;

    min-width:0;

}



.header-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:700;

    color:#64748b;

}



.header-left h1{

    margin:12px 0 8px;

    font-size:34px;

    line-height:1.2;

    color:#172033;

    font-weight:800;

}



.header-left p{

    font-size:13px;

    color:#64748b;

}



.requester{

    margin-top:16px;

    padding:8px 18px;

    display:inline-flex;

    background:#f1f5f9;

    border-radius:999px;

    color:#334155;

    font-size:12px;

    font-weight:600;

}





/* =========================
AMOUNT
========================= */


.header-right{

    width:260px;

    text-align:right;

}



.amount-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:20px;

    border-radius:20px;

}



.amount-card small{

    display:block;

    color:#64748b;

    font-size:12px;

}



.amount-card strong{

    display:block;

    margin-top:8px;

    color:#172033;

    font-size:30px;

}





/* =========================
STATUS
========================= */


.status{

    margin-top:14px;

    display:inline-flex;

    padding:10px 22px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}



.status.pending{

    background:#fef3c7;

    color:#92400e;

}



.status.approved{

    background:#dcfce7;

    color:#15803d;

}



.status.rejected{

    background:#fee2e2;

    color:#dc2626;

}





/* =========================
TIMELINE
========================= */


.timeline-box{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:20px;

    display:flex;

    gap:15px;

    margin-bottom:22px;

}



.timeline-step{

    flex:1;

    text-align:center;

    padding:13px;

    background:#f8fafc;

    border-radius:14px;

    border:1px solid #e2e8f0;

    color:#64748b;

    font-size:12px;

    font-weight:700;

}



.timeline-step.active{

    background:#ecfdf5;

    color:#15803d;

    border-color:#86efac;

}





/* =========================
CARD
========================= */


.card{

    width:100%;

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:28px;

    margin-bottom:22px;

    box-shadow:
    0 8px 20px rgba(15,23,42,.04);

}



.card-title{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin-bottom:22px;

}





/* =========================
DETAIL INFO
========================= */


.info-grid{

    display:grid;

    grid-template-columns:repeat(2,minmax(0,1fr));

    gap:18px;

}



.info-item{

    display:flex;

    align-items:center;

    gap:15px;

    padding:18px;

    background:#f8fafc;

    border-radius:18px;

}



.detail-icon{

    width:46px;

    height:46px;

    flex:none;

    background:white;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    box-shadow:
    0 4px 10px rgba(0,0,0,.05);

}



.info-item label{

    display:block;

    font-size:11px;

    color:#94a3b8;

}



.info-item strong{

    color:#172033;

    font-size:14px;

}



.money{

    color:#15803d!important;

}





/* =========================
DESCRIPTION
========================= */


.description-box{

    margin-top:20px;

    padding:18px;

    background:#f8fafc;

    border-radius:18px;

}



.description-box label{

    color:#64748b;

    font-size:12px;

    font-weight:700;

}





/* =========================
DOCUMENT
========================= */


.file-card{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

    background:#f8fafc;

    padding:18px;

    border-radius:18px;

}



.file-icon{

    width:45px;

    height:45px;

    background:white;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#334155;

    font-weight:700;

}



.file-detail{

    display:flex;

    align-items:center;

    gap:15px;

}



.file-detail small{

    display:block;

    margin-top:5px;

    color:#64748b;

}



.btn-view{

    background:#0f172a;

    color:white;

    padding:11px 22px;

    border:none;

    border-radius:12px;

    font-weight:700;

}





/* =========================
EMPTY
========================= */


.empty{

    min-height:130px;

    display:flex;

    justify-content:center;

    align-items:center;

    color:#94a3b8;

}





/* =========================
AUDIT TRAIL
========================= */


.audit-list{

    position:relative;

    padding-left:45px;

}



.audit-list:before{

    content:"";

    position:absolute;

    left:16px;

    top:10px;

    bottom:10px;

    width:2px;

    background:#e2e8f0;

}



.audit-card{

    position:relative;

    background:#f8fafc;

    padding:18px;

    border-radius:18px;

    margin-bottom:15px;

}



.audit-icon{

    position:absolute;

    left:-45px;

    top:20px;

    width:34px;

    height:34px;

    border-radius:50%;

    background:#16a34a;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:800;

}



.audit-header{

    display:flex;

    justify-content:space-between;

}



.audit-header span{

    background:#dcfce7;

    color:#15803d;

    padding:5px 12px;

    border-radius:999px;

    font-size:11px;

}



.audit-content p{

    margin:10px 0;

    color:#475569;

}



.audit-meta{

    color:#94a3b8;

    font-size:12px;

}





/* =========================
DECISION FINANCE
========================= */


.decision-header{

    display:flex;

    align-items:center;

    gap:18px;

    padding:20px;

    background:#f8fafc;

    border-radius:18px;

}



.decision-icon{

    width:48px;

    height:48px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    font-weight:800;

}



.failed{

    background:#fee2e2;

    color:#dc2626;

}



.success{

    background:#dcfce7;

    color:#16a34a;

}



.decision-header strong{

    font-size:16px;

    color:#172033;

}



.decision-header p{

    margin-top:5px;

    color:#64748b;

}





.decision-note{

    margin-top:18px;

    padding:18px;

    background:#f8fafc;

    border-radius:16px;

}



.decision-info{

    margin-top:18px;

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}



.decision-info div{

    padding:18px;

    background:#f8fafc;

    border-radius:16px;

}



.decision-info label{

    font-size:11px;

    color:#64748b;

}



.decision-info strong{

    display:block;

    margin-top:5px;

    color:#172033;

}





/* =========================
BACK
========================= */


.back{

    display:inline-flex;

    background:#0f172a;

    color:white;

    padding:12px 26px;

    border-radius:14px;

    text-decoration:none;

    font-weight:700;

}





/* =========================
RESPONSIVE
========================= */


@media(max-width:900px){


.detail-header{

    flex-direction:column;

    align-items:flex-start;

}



.header-right{

    width:100%;

    text-align:left;

}



.info-grid,

.decision-info{

    grid-template-columns:1fr;

}



.timeline-box{

    flex-direction:column;

}



.file-card{

    flex-direction:column;

    align-items:flex-start;

}


}

</style>

@endsection