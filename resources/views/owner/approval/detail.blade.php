@extends('layouts.dashboard')

@section('content')


<div class="detail-page">


{{-- HEADER --}}

<div class="page-header">

<div>

<span class="label">
MONITORING DANA
</span>


<h1>
Detail Pengajuan Dana
</h1>


<p>
Informasi lengkap proses pengajuan dana dan keputusan bagian keuangan.
</p>


</div>


<a href="{{route('owner.approval')}}" class="back-btn">
← Kembali
</a>


</div>






{{-- STATUS UTAMA --}}


@php

$isApproved = in_array($expense->status,['approved','selesai']);

$isPending = $expense->status == 'pending';

@endphp



<div class="status-card 
@if($isApproved)
approved-bg
@elseif($isPending)
pending-bg
@else
rejected-bg
@endif
">


<div class="status-left">


<div class="status-icon">

@if($isApproved)

✓

@elseif($isPending)

⏳

@else

✕

@endif


</div>



<div>

<span>

STATUS PENGAJUAN

</span>


<h2>


@if($isApproved)

Disetujui

@elseif($isPending)

Menunggu Verifikasi

@else

Ditolak

@endif


</h2>



<p>


@if($isApproved)

Pengajuan telah diverifikasi dan disetujui oleh bagian keuangan.

@elseif($isPending)

Pengajuan masih menunggu proses verifikasi.

@else

Pengajuan tidak disetujui oleh bagian keuangan.

@endif


</p>


</div>


</div>


</div>








{{-- INFORMASI --}}



<div class="section">


<div class="section-title">

Informasi Pengajuan

</div>



<div class="table-detail">


<div class="row">

<span>
Nomor Pengajuan
</span>

<strong>
{{ $expense->nomor_pengajuan ?? '-' }}
</strong>

</div>



<div class="row">

<span>
Project
</span>

<strong>
{{ $expense->proyek->nama_proyek ?? '-' }}
</strong>

</div>




<div class="row">

<span>
Pengaju
</span>

<strong>
{{ $expense->pengguna->name ?? '-' }}
</strong>

</div>




<div class="row">

<span>
Judul Pengajuan
</span>

<strong>
{{ $expense->judul ?? '-' }}
</strong>

</div>



<div class="row">

<span>
Jumlah Dana
</span>

<strong class="money">

Rp {{number_format(
$expense->jumlah ?? 0,
0,
',',
'.'
)}}

</strong>

</div>



<div class="row">

<span>
Tanggal Pengajuan
</span>

<strong>

{{optional($expense->created_at)->format('d M Y H:i') ?? '-'}}

</strong>

</div>


</div>


</div>









{{-- KETERANGAN --}}



<div class="section">


<div class="section-title">

Keterangan Pengajuan

</div>



<div class="description">

{{ $expense->keterangan ?? $expense->judul ?? '-' }}

</div>


</div>








{{-- TIMELINE --}}



<div class="section">


<div class="section-title">

Riwayat Proses

</div>



<div class="timeline">


<div class="timeline-item active">

<div class="dot">
✓
</div>


<div>

<strong>
Pengajuan Dibuat
</strong>


<p>
Pengajuan dana telah dibuat oleh pemohon.
</p>

</div>

</div>





<div class="timeline-item 
@if(!$isPending)
active
@endif
">


<div class="dot">

@if(!$isPending)

✓

@else

•

@endif


</div>



<div>

<strong>
Verifikasi Keuangan
</strong>


<p>

@if($isPending)

Menunggu pemeriksaan keuangan.

@else

Telah diproses oleh bagian keuangan.

@endif


</p>


</div>


</div>







<div class="timeline-item 
@if($isApproved)
active
@endif
">


<div class="dot">

@if($isApproved)

✓

@else

•

@endif

</div>



<div>

<strong>
Keputusan Akhir
</strong>


<p>


@if($isApproved)

Dana disetujui.

@elseif(!$isPending)

Dana ditolak.

@else

Menunggu keputusan.

@endif


</p>


</div>


</div>



</div>


</div>









{{-- CATATAN --}}


@if($expense->catatan)


<div class="section">


<div class="section-title">

Catatan Keuangan

</div>



<div class="note">

{{ $expense->catatan }}

</div>


</div>


@endif







{{-- DOKUMEN --}}

@if($expense->bukti_pengajuan)

<div class="section">

<div class="section-title">

Lampiran Dokumen

</div>


<a href="{{asset('uploads/pengajuan/'.$expense->bukti_pengajuan)}}"
target="_blank"
class="document">

📎 Buka Dokumen Pengajuan

</a>


</div>

@endif


</div>







<style>

*{
    box-sizing:border-box;
}

.detail-page{
    width:100%;
    max-width:1000px;
    margin:0 auto;
    min-width:0;
}

/* ===============================
   HEADER
================================ */

.page-header{
    background:#f8fafc;
    padding:20px 24px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    margin-bottom:16px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.label{
    display:block;
    font-size:9px;
    letter-spacing:1.8px;
    font-weight:800;
    color:#64748b;
}

.page-header h1{
    margin:6px 0;
    font-size:22px;
    line-height:1.3;
    font-weight:800;
    color:#172033;
}

.page-header p{
    margin:0;
    font-size:11px;
    line-height:1.5;
    color:#64748b;
}

.back-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:9px 15px;
    border-radius:9px;
    background:#0f172a;
    color:#fff;
    text-decoration:none;
    font-size:10px;
    font-weight:700;
    white-space:nowrap;
}

.back-btn:hover{
    background:#334155;
    color:#fff;
}

/* ===============================
   STATUS
================================ */

.status-card{
    padding:17px 20px;
    border-radius:17px;
    margin-bottom:14px;
    border:1px solid transparent;
}

.status-left{
    display:flex;
    align-items:center;
    gap:13px;
}

.status-icon{
    width:40px;
    height:40px;
    flex-shrink:0;
    font-size:18px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
}

.status-card span{
    display:block;
    font-size:9px;
    font-weight:800;
    letter-spacing:1.2px;
}

.status-card h2{
    margin:4px 0;
    font-size:18px;
    line-height:1.3;
    font-weight:800;
}

.status-card p{
    margin:0;
    font-size:10px;
    line-height:1.5;
}

/* STATUS COLORS */

.approved-bg{
    background:#f0fdf4;
    border-color:#bbf7d0;
}

.approved-bg .status-icon{
    background:#dcfce7;
    color:#166534;
}

.approved-bg span,
.approved-bg h2{
    color:#166534;
}

.pending-bg{
    background:#fffbeb;
    border-color:#fde68a;
}

.pending-bg .status-icon{
    background:#fef3c7;
    color:#92400e;
}

.pending-bg span,
.pending-bg h2{
    color:#92400e;
}

.rejected-bg{
    background:#fef2f2;
    border-color:#fecaca;
}

.rejected-bg .status-icon{
    background:#fee2e2;
    color:#991b1b;
}

.rejected-bg span,
.rejected-bg h2{
    color:#991b1b;
}

/* ===============================
   SECTION
================================ */

.section{
    width:100%;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:17px;
    padding:18px;
    margin-bottom:14px;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    min-width:0;
}

.section-title{
    font-size:14px;
    line-height:1.4;
    font-weight:800;
    color:#172033;
    border-left:4px solid #8B5E22;
    padding-left:9px;
    margin-bottom:12px;
}

/* ===============================
   INFORMATION
================================ */

.table-detail{
    width:100%;
}

.table-detail .row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:11px 0;
    border-bottom:1px solid #f1f5f9;
}

.table-detail .row:last-child{
    border-bottom:none;
}

.row span{
    color:#64748b;
    font-size:10px;
}

.row strong{
    color:#172033;
    font-size:11px;
    font-weight:700;
    text-align:right;
    overflow-wrap:anywhere;
}

.money{
    color:#15803d!important;
    font-size:17px!important;
    font-weight:800!important;
}

/* ===============================
   DESCRIPTION
================================ */

.description{
    background:#f8fafc;
    padding:14px;
    border-radius:11px;
    border:1px solid #f1f5f9;
    color:#334155;
    font-size:11px;
    line-height:1.65;
    overflow-wrap:anywhere;
}

/* ===============================
   TIMELINE
================================ */

.timeline{
    position:relative;
}

.timeline-item{
    display:flex;
    align-items:flex-start;
    gap:12px;
    padding-bottom:18px;
    position:relative;
}

.timeline-item:last-child{
    padding-bottom:0;
}

.timeline-item:not(:last-child)::after{
    content:"";
    position:absolute;
    left:13px;
    top:28px;
    width:1px;
    height:calc(100% - 12px);
    background:#e2e8f0;
}

.dot{
    width:28px;
    height:28px;
    flex-shrink:0;
    border-radius:50%;
    background:#e2e8f0;
    color:#64748b;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:800;
    position:relative;
    z-index:1;
}

.timeline-item.active .dot{
    background:#dcfce7;
    color:#166534;
}

.timeline-item strong{
    display:block;
    font-size:11px;
    color:#172033;
    line-height:1.4;
}

.timeline-item p{
    margin:4px 0 0;
    font-size:10px;
    line-height:1.5;
    color:#64748b;
}

/* ===============================
   NOTE
================================ */

.note{
    background:#fff7ed;
    border:1px solid #fed7aa;
    padding:13px;
    border-radius:11px;
    color:#9a3412;
    font-size:11px;
    line-height:1.6;
    overflow-wrap:anywhere;
}

/* ===============================
   DOCUMENT
================================ */

.document{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:9px 14px;
    background:#334155;
    color:#fff;
    border-radius:9px;
    font-size:10px;
    font-weight:700;
    text-decoration:none;
}

.document:hover{
    background:#475569;
    color:#fff;
}

/* ===============================
   TABLET
================================ */

@media(max-width:900px){

    .page-header{
        padding:18px 20px;
    }

    .page-header h1{
        font-size:20px;
    }

    .page-header p{
        font-size:10px;
    }

    .status-card{
        padding:15px 17px;
    }

    .section{
        padding:16px;
    }
}

/* ===============================
   MOBILE
================================ */

@media(max-width:600px){

    .detail-page{
        width:100%;
        max-width:100%;
    }

    .page-header{
        padding:16px;
        border-radius:15px;
        flex-direction:column;
        align-items:stretch;
        gap:12px;
        margin-bottom:12px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .page-header h1{
        font-size:19px;
        margin:5px 0;
    }

    .page-header p{
        font-size:10px;
        line-height:1.5;
    }

    .back-btn{
        width:100%;
        height:38px;
        font-size:10px;
    }

    /* STATUS */

    .status-card{
        padding:14px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .status-left{
        gap:10px;
    }

    .status-icon{
        width:36px;
        height:36px;
        font-size:16px;
    }

    .status-card span{
        font-size:8px;
    }

    .status-card h2{
        font-size:16px;
        margin:3px 0;
    }

    .status-card p{
        font-size:9px;
        line-height:1.5;
    }

    /* SECTION */

    .section{
        padding:14px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .section-title{
        font-size:13px;
        padding-left:8px;
        border-left-width:3px;
        margin-bottom:10px;
    }

    /* INFORMATION */

    .table-detail .row{
        flex-direction:column;
        align-items:flex-start;
        gap:4px;
        padding:10px 0;
    }

    .row span{
        font-size:9px;
    }

    .row strong{
        font-size:10px;
        text-align:left;
    }

    .money{
        font-size:15px!important;
    }

    /* DESCRIPTION */

    .description{
        padding:12px;
        border-radius:10px;
        font-size:10px;
        line-height:1.6;
    }

    /* TIMELINE */

    .timeline-item{
        gap:9px;
        padding-bottom:16px;
    }

    .timeline-item:not(:last-child)::after{
        left:12px;
        top:26px;
    }

    .dot{
        width:26px;
        height:26px;
        font-size:10px;
    }

    .timeline-item strong{
        font-size:10px;
    }

    .timeline-item p{
        font-size:9px;
        line-height:1.5;
    }

    /* NOTE */

    .note{
        padding:11px;
        font-size:10px;
    }

    /* DOCUMENT */

    .document{
        width:100%;
        min-height:38px;
        font-size:10px;
    }
}

/* ===============================
   SMALL MOBILE
================================ */

@media(max-width:380px){

    .page-header h1{
        font-size:18px;
    }

    .status-card h2{
        font-size:15px;
    }

    .section-title{
        font-size:12px;
    }

    .row span{
        font-size:8px;
    }

    .row strong{
        font-size:9px;
    }
}

</style>



@endsection