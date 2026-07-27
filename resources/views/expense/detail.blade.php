@extends('layouts.dashboard')

@section('content')

<div class="detail-container">


<!-- HEADER -->

<div class="detail-header">

    <div class="header-left">

        <div class="header-label">
            PENGAJUAN DANA #{{ str_pad($request->id,4,'0',STR_PAD_LEFT) }}
        </div>


        <h1>
            {{ $request->judul }}
        </h1>


        <p>
            {{ \Carbon\Carbon::parse($request->created_at)->format('d M Y, H:i') }}
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






<!-- INFORMASI -->

<div class="card">


<div class="card-title">
    Detail Pengajuan
</div>



<div class="info-grid">


<div class="info-item">

<label>
Project
</label>

<strong>
{{ $request->proyek->nama_proyek ?? '-' }}
</strong>

</div>



<div class="info-item">

<label>
Divisi
</label>

<strong>
{{ $request->divisi->nama_divisi ?? '-' }}
</strong>

</div>




<div class="info-item">

<label>
Jumlah Dana
</label>

<strong class="money">
Rp {{ number_format($request->jumlah,0,',','.') }}
</strong>

</div>




<div class="info-item">

<label>
Tanggal Pengajuan
</label>

<strong>
{{ $request->created_at->format('d M Y') }}
</strong>

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







<!-- FILE -->

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
: '-';

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
type="button"
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









<!-- MODAL -->

@if($request->bukti_pengajuan)

<div id="modalProof" class="modal">


<div class="modal-content">


<div class="modal-head">


<strong>
Preview Bukti
</strong>


<div>


<a 
href="{{ asset('uploads/pengajuan/'.$request->bukti_pengajuan) }}"
download
class="btn-download">

Download

</a>


<button 
onclick="closeProof()"
class="btn-close">

×


</button>


</div>


</div>



<img 
id="proofImage"
src="{{ asset('uploads/pengajuan/'.$request->bukti_pengajuan) }}"
>



<button 
onclick="zoomProof()"
class="btn-zoom">

Zoom Gambar

</button>


</div>


</div>


@endif







<!-- AUDIT TRAIL -->


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







<!-- KEPUTUSAN FINANCE -->


@if($request->catatan_persetujuan)


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
{{ $request->catatan_persetujuan }}
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
{{ $request->disetujui_pada?->format('d M Y H:i') }}
</strong>


</div>


</div>


</div>


@endif





<a href="{{ route('expense.myhistory') }}" class="back">
← Kembali
</a>


</div>






<style>

.detail-container{
    width:100%;
    max-width:1200px;
    margin:auto;
    padding-bottom:40px;
}


/* HEADER */

.detail-header{

    background:
    linear-gradient(
        135deg,
        #14532d,
        #22c55e
    );

    color:white;

    padding:32px;

    border-radius:24px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

    box-shadow:
    0 15px 35px rgba(22,101,52,.25);

}



.header-label{

    font-size:11px;

    letter-spacing:2px;

    opacity:.8;

}



.detail-header h1{

    margin:10px 0 5px;

    font-size:30px;

    font-weight:800;

}



.detail-header p{

    margin:0;

    opacity:.85;

    font-size:13px;

}



.requester{

    margin-top:15px;

    display:inline-block;

    background:rgba(255,255,255,.15);

    padding:7px 15px;

    border-radius:30px;

    font-size:12px;

}





.header-right{

    text-align:right;

}



.amount-card{

    background:rgba(255,255,255,.15);

    padding:15px 20px;

    border-radius:18px;

}



.amount-card small{

    display:block;

    font-size:11px;

    opacity:.8;

    text-transform:uppercase;

}



.amount-card strong{

    font-size:27px;

}





.status{

    margin-top:12px;

    display:inline-block;

    background:white;

    padding:10px 18px;

    border-radius:30px;

    font-size:12px;

    font-weight:700;

}



.status.pending{
    color:#92400e;
}


.status.approved{
    color:#166534;
}


.status.rejected{
    color:#dc2626;
}







/* CARD */


.card{

    background:white;

    border-radius:22px;

    padding:24px;

    margin-bottom:20px;

    border:1px solid #e5e7eb;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.card-title{

    font-size:16px;

    font-weight:800;

    margin-bottom:20px;

    color:#0f172a;

}







/* INFO */


.info-grid{

    display:grid;

    grid-template-columns:
    repeat(2,1fr);

    gap:15px;

}



.info-item{

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

}



.info-item label{

    display:block;

    font-size:11px;

    color:#64748b;

    margin-bottom:6px;

}



.info-item strong{

    font-size:14px;

    color:#1e293b;

}



.money{

    color:#15803d!important;

    font-size:18px!important;

}




.description-box{

    margin-top:18px;

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

}



.description-box label{

    font-size:11px;

    color:#64748b;

}



.description-box p{

    margin:8px 0 0;

    font-size:14px;

    color:#334155;

}








/* FILE */


.file-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:15px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.file-detail{

    display:flex;

    align-items:center;

    gap:14px;

}



.file-icon{

    width:45px;

    height:45px;

    background:#dcfce7;

    color:#166534;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:11px;

    font-weight:800;

}



.file-detail strong{

    display:block;

    font-size:13px;

}



.file-detail small{

    color:#64748b;

    font-size:11px;

}




.btn-view{

    background:#166534;

    color:white;

    border:none;

    padding:10px 16px;

    border-radius:12px;

    font-weight:700;

    font-size:12px;

    cursor:pointer;

}



.btn-view:hover{

    background:#14532d;

}







/* MODAL */


.modal{

    display:none;

    position:fixed;

    inset:0;

    background:
    rgba(15,23,42,.75);

    backdrop-filter:blur(5px);

    z-index:9999;

    align-items:center;

    justify-content:center;

    padding:20px;

}



.modal-content{

    background:white;

    border-radius:22px;

    padding:20px;

    max-width:850px;

    width:100%;

}



.modal-head{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

}



.btn-download,
.btn-close,
.btn-zoom{

    border:none;

    padding:9px 14px;

    border-radius:12px;

    cursor:pointer;

    font-weight:700;

    font-size:12px;

}



.btn-download{

    background:#166534;

    color:white;

    text-decoration:none;

}



.btn-close{

    background:#dc2626;

    color:white;

}



.modal img{

    width:100%;

    max-height:70vh;

    object-fit:contain;

    border-radius:15px;

    transition:.3s;

}



.modal img.zoomed{

    transform:scale(1.5);

}



.btn-zoom{

    margin-top:15px;

    background:#f1f5f9;

}







/* AUDIT */


.audit-list{

    position:relative;

}



.audit-list:before{

    content:"";

    position:absolute;

    left:20px;

    top:10px;

    bottom:10px;

    width:2px;

    background:#bbf7d0;

}



.audit-card{

    display:flex;

    gap:15px;

    position:relative;

    margin-bottom:18px;

}



.audit-icon{

    width:40px;

    height:40px;

    border-radius:50%;

    background:#22c55e;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

    z-index:2;

}



.audit-content{

    flex:1;

    background:#f8fafc;

    border-radius:16px;

    padding:15px;

}



.audit-header{

    display:flex;

    gap:10px;

    align-items:center;

}



.audit-header strong{

    color:#166534;

}



.audit-header span{

    background:#dcfce7;

    color:#166534;

    padding:3px 10px;

    border-radius:20px;

    font-size:11px;

}



.audit-content p{

    margin:8px 0;

    font-size:13px;

}



.audit-meta{

    color:#64748b;

    font-size:12px;

}







/* DECISION */


.decision-card{

    border-left:5px solid #22c55e;

}



.decision-header{

    display:flex;

    align-items:center;

    gap:15px;

}



.decision-icon{

    width:45px;

    height:45px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-weight:800;

}



.success{

    background:#22c55e;

}



.failed{

    background:#dc2626;

}



.decision-header p{

    margin:5px 0;

    color:#64748b;

    font-size:13px;

}



.decision-note{

    margin-top:20px;

    background:#f8fafc;

    padding:15px;

    border-radius:15px;

}



.decision-note label,
.decision-info label{

    font-size:11px;

    color:#64748b;

    display:block;

}



.decision-note p{

    margin:6px 0;

}



.decision-info{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:15px;

    margin-top:15px;

}



.decision-info div{

    background:#f8fafc;

    padding:14px;

    border-radius:14px;

}






.empty{

    text-align:center;

    color:#94a3b8;

    padding:25px;

}





.back{

    display:inline-block;

    background:#166534;

    color:white;

    text-decoration:none;

    padding:11px 20px;

    border-radius:12px;

    font-weight:700;

}







@media(max-width:900px){


.detail-header{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



.header-right{

    text-align:left;

}



.info-grid{

    grid-template-columns:1fr;

}



.file-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.decision-info{

    grid-template-columns:1fr;

}


}
/* COMPACT DETAIL OVERRIDE */

.detail-container{
    max-width:1000px;
    padding-bottom:20px;
}


.card{
    padding:16px;
    border-radius:16px;
    margin-bottom:14px;
}


.card-title{
    font-size:14px;
    margin-bottom:12px;
}


/* AUDIT COMPACT */

.audit-card{
    gap:10px;
    margin-bottom:10px;
}


.audit-icon{
    width:28px;
    height:28px;
    font-size:12px;
}


.audit-list:before{
    left:13px;
}


.audit-content{

    padding:10px 12px;

    border-radius:12px;

}


.audit-header strong{

    font-size:13px;

}


.audit-header span{

    font-size:10px;

    padding:2px 8px;

}


.audit-content p{

    font-size:12px;

    margin:4px 0;

}


.audit-meta{

    font-size:11px;

}





/* KEPUTUSAN FINANCE */

.decision-header{

    gap:10px;

}


.decision-icon{

    width:32px;

    height:32px;

    font-size:13px;

}


.decision-header strong{

    font-size:14px;

}


.decision-header p{

    font-size:12px;

    margin:2px 0;

}


.decision-note{

    margin-top:12px;

    padding:12px;

}


.decision-info{

    margin-top:10px;

    gap:10px;

}


.decision-info div{

    padding:10px;

}


.back{

    padding:9px 16px;

    font-size:13px;

}

/* SMALL HEADER VERSION */

.detail-header{

    padding:20px 24px;

    border-radius:18px;

    margin-bottom:15px;

}


.detail-header h1{

    font-size:22px;

    margin:6px 0;

}


.header-label{

    font-size:10px;

}


.detail-header p{

    font-size:12px;

}



.requester{

    margin-top:8px;

    padding:5px 12px;

    font-size:11px;

}



.amount-card{

    padding:10px 16px;

    border-radius:14px;

}



.amount-card small{

    font-size:9px;

}



.amount-card strong{

    font-size:20px;

}



.status{

    padding:8px 15px;

    font-size:11px;

    margin-top:8px;

}
.card{

    padding:16px;

    margin-bottom:12px;

}


.card-title{

    font-size:14px;

    margin-bottom:12px;

}









</style>






<script>

function openProof(){

document.getElementById('modalProof').style.display='flex';

}


function closeProof(){

document.getElementById('modalProof').style.display='none';

}



function zoomProof(){

document
.getElementById('proofImage')
.classList.toggle('zoomed');

}

</script>

@endsection