@extends('layouts.dashboard')

@section('content')

<div class="detail-container detail-page">


{{-- ================= HEADER ================= --}}

<div class="detail-header">

<div class="header-left">

<div class="header-label">
    PENGAJUAN DANA
</div>

<div class="request-number">
    {{ $request->nomor_pengajuan ?? 'REQ-'.$request->id }}
</div>


<h1>

{{ $request->judul }}

</h1>



<p>

{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y, H:i') }}

</p>



<div class="requester">

{{ $request->pengguna?->name ?? 'Pengguna' }}

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



</div>


</div>









{{-- ================= TIMELINE ================= --}}


<div class="timeline-box">


<div class="timeline-step active">

✓ Pengajuan dibuat

</div>



<div class="timeline-step
{{ $request->status != 'pending' ? 'active':'' }}>

✓ Diproses Finance

</div>


@if($request->status == 'approved')

<div class="timeline-step active">
✓ Disetujui Finance
</div>


@elseif($request->status == 'selesai')

<div class="timeline-step active">
✓ Disetujui Finance
</div>

<div class="timeline-step active">
💰 Dana Dicairkan
</div>


@elseif($request->status == 'rejected')

<div class="timeline-step rejected-step">
✕ Pengajuan Ditolak
</div>


@else

<div class="timeline-step">
○ Menunggu Keputusan
</div>

@endif

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

{{ $request->proyek?->perusahaan?->nama_perusahaan ?? '-' }}

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

 {{ $request->proyek?->nama_proyek ?? '-' }}

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

{{ $request->divisi?->nama_divisi ?? '-' }}

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

Rp {{number_format($request->jumlah ?? 0,0,',','.')}}

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

Rp {{ number_format($request->proyek?->total_anggaran ?? 0,0,',','.') }}

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

Rp {{number_format($request->proyek?->total_realisasi ?? 0,0,',','.')}}
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
    

Rp {{ number_format($request->proyek?->sisa_budget ?? 0,0,',','.') }}


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

{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y') }}

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

<a 
href="{{url('uploads/pengajuan/'.$request->bukti_pengajuan)}}"
target="_blank">
{{ $request->bukti_pengajuan }}

</a>


<small>

Lampiran transaksi • {{ $fileSize }}

</small>


</div>


</div>


<div class="file-actions">

<button
onclick="openProof()"
class="btn-view">

Lihat Bukti

</button>

<a 
href="{{url('uploads/pengajuan/'.$request->bukti_pengajuan)}}"
download
class="btn-download">

Download

</a>


</div>

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
class="proof-frame"
src="{{ url('uploads/pengajuan/'.$request->bukti_pengajuan) }}">
</iframe>


@else


<img 
class="proof-image"
src="{{ url('uploads/pengajuan/'.$request->bukti_pengajuan) }}">



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

@if(str_contains(strtolower($log->aksi),'create'))

+

@elseif(str_contains(strtolower($log->aksi),'approve'))

✓

@else

!

@endif

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

{{ $log->pengguna?->name ?? 'System' }}


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



@if(
$request->status == 'approved'
||
$request->status == 'selesai'
)



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

{{ $request->penyetuju?->name ?? 'Finance' }}

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



@if($request->transaksiDana && $request->transaksiDana->count())

<div class="card">

<div class="card-title">
💰 Informasi Pencairan Dana
</div>


<div class="info-grid">


<div class="info-item">

<div class="detail-icon">
🏦
</div>

<div>

<label>
Bank
</label>

<strong>
{{$request->transaksiDana->first()->rekeningBank->nama_bank ?? '-'}}
</strong>

</div>

</div>



<div class="info-item">

<div class="detail-icon">
💳
</div>

<div>

<label>
Nomor Rekening
</label>

<strong>
{{$request->transaksiDana->first()->rekeningBank->nomor_rekening ?? '-'}}
</strong>

</div>

</div>



<div class="info-item">

<div class="detail-icon">
📅
</div>

<div>

<label>
Tanggal Cair
</label>

<strong>
{{$request->transaksiDana->first()->tanggal->format('d M Y H:i')}}
</strong>

</div>

</div>



<div class="info-item">

<div class="detail-icon">
💰
</div>

<div>

<label>
Nominal Cair
</label>

<strong class="money">
Rp {{number_format(
$request->transaksiDana->first()->jumlah,
0,
',',
'.'
)}}
</strong>

</div>

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


window.onclick=function(e){

let modal=document.getElementById('modalProof');

if(e.target == modal){

modal.style.display='none';

}

}

</script>




<style>

/* =========================================================
   DETAIL PENGAJUAN DANA
   CORPORATE FINANCE
========================================================= */

.detail-container {
    width: 100%;
    max-width: 1320px;
    margin: 0 auto;
    padding: 0 4px 30px;
    color: #1e293b;
}

.detail-container *,
.detail-container *::before,
.detail-container *::after {
    box-sizing: border-box;
}


/* =========================================================
   HEADER
========================================================= */

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;

    width: 100%;
    gap: 30px;

    padding: 24px 28px;
    margin-bottom: 16px;

    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
}

.header-left {
    flex: 1;
    min-width: 0;
}

.header-label {
    margin-bottom: 7px;

    font-size: 10px;
    line-height: 1.4;
    font-weight: 800;

    letter-spacing: 1.8px;
    color: #64748b;
}

.request-number {
    margin-bottom: 7px;

    font-size: 14px;
    line-height: 1.4;
    font-weight: 800;

    color: #334155;
}

.header-left h1 {
    margin: 0;

    font-size: 23px;
    line-height: 1.35;
    font-weight: 800;

    color: #0f172a;

    word-break: break-word;
}

.header-left p {
    margin: 8px 0 0;

    font-size: 11px;
    line-height: 1.5;

    color: #64748b;
}

.requester {
    display: inline-flex;
    align-items: center;

    margin-top: 12px;
    padding: 6px 11px;

    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 7px;

    font-size: 11px;
    line-height: 1.4;
    font-weight: 700;

    color: #475569;
}

.header-right {
    width: 250px;
    flex-shrink: 0;
}


/* =========================================================
   AMOUNT
========================================================= */

.amount-card {
    padding: 14px 16px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
}

.amount-card small {
    display: block;

    margin-bottom: 5px;

    font-size: 10px;
    line-height: 1.4;

    color: #64748b;
}

.amount-card strong {
    display: block;

    font-size: 20px;
    line-height: 1.3;
    font-weight: 800;

    color: #0f172a;

    word-break: break-word;
}


/* =========================================================
   STATUS
========================================================= */

.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    margin-top: 10px;
    padding: 6px 11px;

    border-radius: 7px;

    font-size: 10px;
    line-height: 1.4;
    font-weight: 800;
}

.status.pending {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c;
}

.status.approved {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.status.selesai {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
}

.status.rejected {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}


/* =========================================================
   TIMELINE
========================================================= */

.timeline-box {
    display: grid;
    grid-template-columns: repeat(4, 1fr);

    width: 100%;
    gap: 8px;

    padding: 10px;
    margin-bottom: 16px;

    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}

.timeline-step {
    display: flex;
    align-items: center;
    justify-content: center;

    min-height: 38px;
    padding: 9px 8px;

    text-align: center;

    background: #f8fafc;
    border-radius: 8px;

    color: #94a3b8;

    font-size: 10px;
    line-height: 1.4;
    font-weight: 700;
}

.timeline-step.active {
    background: #f0fdf4;
    color: #166534;
}

.timeline-step.rejected-step {
    background: #fef2f2;
    color: #b91c1c;
}


/* =========================================================
   CARD
========================================================= */

.card {
    width: 100%;

    padding: 20px;
    margin-bottom: 16px;

    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
}

.card-title {
    display: flex;
    align-items: center;

    margin-bottom: 16px;
    padding-bottom: 11px;

    border-bottom: 1px solid #e2e8f0;

    font-size: 14px;
    line-height: 1.4;
    font-weight: 800;

    color: #0f172a;
}


/* =========================================================
   INFORMATION GRID
========================================================= */

.info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);

    gap: 10px;
}

.info-item {
    display: flex;
    align-items: center;

    min-width: 0;
    gap: 10px;

    padding: 12px;

    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 10px;
}

.detail-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 36px;
    height: 36px;
    flex-shrink: 0;

    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 9px;

    font-size: 15px;
}

.info-item > div:last-child {
    min-width: 0;
}

.info-item label {
    display: block;

    margin-bottom: 3px;

    font-size: 9px;
    line-height: 1.4;
    font-weight: 600;

    color: #94a3b8;
}

.info-item strong {
    display: block;

    font-size: 11px;
    line-height: 1.45;
    font-weight: 700;

    color: #334155;

    word-break: break-word;
}

.money {
    color: #15803d !important;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.description-box {
    margin-top: 14px;
    padding: 13px;

    background: #f8fafc;
    border-left: 3px solid #64748b;
    border-radius: 8px;
}

.description-box label {
    display: block;

    margin-bottom: 5px;

    font-size: 10px;
    line-height: 1.4;
    font-weight: 800;

    color: #64748b;
}

.description-box p {
    margin: 0;

    font-size: 11px;
    line-height: 1.6;

    color: #475569;

    white-space: pre-line;
    word-break: break-word;
}


/* =========================================================
   DOCUMENT
========================================================= */

.file-card {
    display: flex;
    justify-content: space-between;
    align-items: center;

    width: 100%;
    gap: 20px;

    padding: 13px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}

.file-detail {
    display: flex;
    align-items: center;

    min-width: 0;
    gap: 11px;
}

.file-detail > div:last-child {
    min-width: 0;
}

.file-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 38px;
    height: 38px;
    flex-shrink: 0;

    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;

    font-size: 9px;
    line-height: 1;
    font-weight: 800;

    color: #475569;
}

.file-detail a {
    display: block;

    font-size: 11px;
    line-height: 1.5;
    font-weight: 700;

    color: #334155;

    text-decoration: none;
    word-break: break-all;
}

.file-detail a:hover {
    text-decoration: underline;
}

.file-detail small {
    display: block;

    margin-top: 3px;

    font-size: 9px;
    line-height: 1.4;

    color: #94a3b8;
}

.file-actions {
    display: flex;
    gap: 7px;

    flex-shrink: 0;
}

.btn-view,
.btn-download {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 34px;
    padding: 7px 13px;

    border-radius: 7px;

    font-size: 10px;
    line-height: 1;
    font-weight: 700;

    cursor: pointer;
    text-decoration: none;
}

.btn-view {
    background: #334155;
    border: 1px solid #334155;

    color: #ffffff;
}

.btn-view:hover {
    background: #1e293b;
    border-color: #1e293b;
}

.btn-download {
    background: #ffffff;
    border: 1px solid #cbd5e1;

    color: #334155;
}

.btn-download:hover {
    background: #f1f5f9;
}


/* =========================================================
   EMPTY
========================================================= */

.empty {
    width: 100%;

    padding: 18px;

    text-align: center;

    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 9px;

    font-size: 11px;
    line-height: 1.5;

    color: #94a3b8;
}


/* =========================================================
   AUDIT TRAIL
========================================================= */

.audit-list {
    position: relative;

    padding-left: 28px;
}

.audit-list::before {
    content: "";

    position: absolute;

    top: 4px;
    bottom: 4px;
    left: 9px;

    width: 1px;

    background: #cbd5e1;
}

.audit-card {
    position: relative;

    padding: 12px 13px;
    margin-bottom: 9px;

    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 9px;
}

.audit-icon {
    position: absolute;

    top: 12px;
    left: -28px;

    display: flex;
    align-items: center;
    justify-content: center;

    width: 20px;
    height: 20px;

    background: #334155;
    border-radius: 50%;

    color: #ffffff;

    font-size: 9px;
    line-height: 1;
    font-weight: 800;
}

.audit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;
}

.audit-header strong {
    font-size: 11px;
    line-height: 1.4;
    color: #334155;
}

.audit-header span {
    flex-shrink: 0;

    padding: 3px 7px;

    background: #e2e8f0;
    border-radius: 5px;

    font-size: 8px;
    line-height: 1.3;
    font-weight: 700;

    color: #475569;
}

.audit-content p {
    margin: 6px 0;

    font-size: 10px;
    line-height: 1.5;

    color: #64748b;

    word-break: break-word;
}

.audit-meta {
    font-size: 9px;
    line-height: 1.5;

    color: #94a3b8;
}


/* =========================================================
   DECISION FINANCE
========================================================= */

.decision-header {
    display: flex;
    align-items: center;

    gap: 12px;
    padding: 13px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}

.decision-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 38px;
    height: 38px;
    flex-shrink: 0;

    border-radius: 9px;

    font-weight: 800;
}

.decision-icon.success {
    background: #dcfce7;
    color: #166534;
}

.decision-icon.failed {
    background: #fee2e2;
    color: #b91c1c;
}

.decision-header strong {
    font-size: 12px;
    line-height: 1.4;

    color: #1e293b;
}

.decision-header p {
    margin: 3px 0 0;

    font-size: 10px;
    line-height: 1.5;

    color: #64748b;
}

.decision-note,
.decision-info div {
    padding: 12px;
    margin-top: 10px;

    background: #f8fafc;
    border-radius: 9px;
}

.decision-note label,
.decision-info label {
    display: block;

    margin-bottom: 4px;

    font-size: 9px;
    line-height: 1.4;
    font-weight: 600;

    color: #94a3b8;
}

.decision-note p {
    margin: 0;

    font-size: 10px;
    line-height: 1.5;

    color: #475569;

    word-break: break-word;
}

.decision-info {
    display: grid;
    grid-template-columns: repeat(2, 1fr);

    gap: 10px;
}

.decision-info div {
    margin-top: 0;
}

.decision-info strong {
    display: block;

    font-size: 11px;
    line-height: 1.5;

    color: #334155;

    word-break: break-word;
}


/* =========================================================
   BACK BUTTON
========================================================= */

.back {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 36px;
    padding: 8px 15px;
    margin-top: 2px;
    margin-bottom: 20px;

    background: #334155;
    border-radius: 7px;

    color: #ffffff;

    font-size: 10px;
    line-height: 1;
    font-weight: 700;

    text-decoration: none;
}

.back:hover {
    background: #1e293b;
}


/* =========================================================
   MODAL
========================================================= */

.modal {
    display: none;
    align-items: center;
    justify-content: center;

    position: fixed;
    inset: 0;
    z-index: 9999;

    padding: 20px;

    background: rgba(15, 23, 42, .65);
}

.modal-content {
    width: 100%;
    max-width: 900px;
    max-height: 90vh;

    padding: 16px;

    overflow: auto;

    background: #ffffff;
    border-radius: 12px;
}

.modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 12px;
}

.modal-head strong {
    font-size: 13px;
    line-height: 1.4;
    color: #1e293b;
}

.btn-close {
    padding: 5px 10px;

    background: #f1f5f9;
    border: 0;
    border-radius: 7px;

    color: #475569;

    font-size: 16px;
    line-height: 1;

    cursor: pointer;
}

.btn-close:hover {
    background: #e2e8f0;
}

.proof-frame {
    display: block;

    width: 100%;
    height: 600px;

    border: 0;
    border-radius: 8px;
}

.proof-image {
    display: block;

    max-width: 100%;
    max-height: 70vh;

    margin: auto;

    object-fit: contain;
    border-radius: 8px;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .detail-header {
        padding: 21px;
    }

    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .detail-container {
        padding: 0 0 20px;
    }


    /* HEADER */

    .detail-header {
        flex-direction: column;
        align-items: stretch;

        gap: 15px;

        padding: 18px;

        border-radius: 11px;
    }

    .header-right {
        width: 100%;
    }

    .header-label {
        font-size: 9px;
        letter-spacing: 1.4px;
    }

    .request-number {
        font-size: 12px;
    }

    .header-left h1 {
        font-size: 19px;
        line-height: 1.4;
    }

    .header-left p {
        font-size: 10px;
    }

    .requester {
        font-size: 9px;
    }


    /* AMOUNT */

    .amount-card {
        padding: 12px;

        border-radius: 9px;
    }

    .amount-card small {
        font-size: 9px;
    }

    .amount-card strong {
        font-size: 17px;
    }

    .status {
        font-size: 9px;
    }


    /* TIMELINE */

    .timeline-box {
        grid-template-columns: 1fr 1fr;

        gap: 6px;
        padding: 8px;

        border-radius: 10px;
    }

    .timeline-step {
        min-height: 40px;

        padding: 8px 5px;

        font-size: 9px;
    }


    /* CARD */

    .card {
        padding: 15px;

        border-radius: 11px;
    }

    .card-title {
        font-size: 12px;
        margin-bottom: 13px;
    }


    /* INFORMATION */

    .info-grid {
        grid-template-columns: 1fr;

        gap: 7px;
    }

    .info-item {
        padding: 10px;
    }

    .detail-icon {
        width: 34px;
        height: 34px;

        font-size: 14px;
    }

    .info-item label {
        font-size: 8px;
    }

    .info-item strong {
        font-size: 10px;
    }


    /* DESCRIPTION */

    .description-box {
        padding: 11px;
    }

    .description-box label {
        font-size: 9px;
    }

    .description-box p {
        font-size: 10px;
    }


    /* DOCUMENT */

    .file-card {
        flex-direction: column;
        align-items: stretch;

        gap: 11px;
    }

    .file-detail {
        align-items: flex-start;
    }

    .file-detail a {
        font-size: 10px;
    }

    .file-detail small {
        font-size: 8px;
    }

    .file-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;

        width: 100%;
        gap: 7px;
    }

    .btn-view,
    .btn-download {
        width: 100%;
        min-height: 38px;

        font-size: 9px;
    }


    /* AUDIT */

    .audit-list {
        padding-left: 25px;
    }

    .audit-list::before {
        left: 8px;
    }

    .audit-card {
        padding: 11px;
    }

    .audit-icon {
        left: -25px;

        width: 20px;
        height: 20px;

        font-size: 8px;
    }

    .audit-header {
        align-items: flex-start;
    }

    .audit-header strong {
        font-size: 10px;
    }

    .audit-header span {
        font-size: 7px;
    }

    .audit-content p {
        font-size: 9px;
    }

    .audit-meta {
        font-size: 8px;
    }


    /* DECISION */

    .decision-header {
        padding: 11px;
    }

    .decision-icon {
        width: 34px;
        height: 34px;
    }

    .decision-header strong {
        font-size: 10px;
    }

    .decision-header p {
        font-size: 8px;
    }

    .decision-note,
    .decision-info div {
        padding: 11px;
    }

    .decision-note label,
    .decision-info label {
        font-size: 8px;
    }

    .decision-note p {
        font-size: 9px;
    }

    .decision-info {
        grid-template-columns: 1fr;

        gap: 8px;
    }

    .decision-info strong {
        font-size: 9px;
    }


    /* BACK */

    .back {
        width: 100%;
        min-height: 40px;

        font-size: 10px;
    }


    /* MODAL */

    .modal {
        padding: 10px;
    }

    .modal-content {
        max-height: 92vh;

        padding: 12px;

        border-radius: 10px;
    }

    .modal-head strong {
        font-size: 11px;
    }

    .proof-frame {
        height: 65vh;
    }

    .proof-image {
        max-height: 65vh;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 400px) {

    .detail-header {
        padding: 15px;
    }

    .header-left h1 {
        font-size: 17px;
    }

    .amount-card strong {
        font-size: 15px;
    }

    .timeline-step {
        font-size: 8px;
    }

    .card {
        padding: 13px;
    }

    .file-actions {
        grid-template-columns: 1fr;
    }

}

</style>



@endsection
