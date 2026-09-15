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
{{ $expense->user->name ?? '-' }}
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


.detail-page{

max-width:900px;

margin:auto;

}

.page-header{

background:#f8fafc;

padding:18px 22px;

border-radius:12px;

border:1px solid #e2e8f0;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.label{

font-size:10px;

letter-spacing:2px;

font-weight:700;

color:#64748b;

}


.page-header h1{

margin:6px 0;

font-size:22px;

color:#172033;

}



.page-header p{

margin:0;

color:#64748b;

font-size:13px;

}



.back-btn{

background:#0f172a;

color:white;

padding:10px 18px;

border-radius:10px;

text-decoration:none;

font-weight:700;

font-size:12px;

}




.status-card{

padding:16px 20px;

border-radius:12px;

margin-bottom:15px;

}



.status-left{

display:flex;

align-items:center;

gap:15px;

}



.status-icon{

width:38px;

height:38px;

font-size:18px;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

font-weight:bold;

}



.status-card span{

font-size:10px;

font-weight:700;

letter-spacing:1px;

}



.status-card h2{

margin:5px 0;

font-size:18px;

}



.status-card p{

margin:0;

font-size:12px;

}



.approved-bg{

background:#f0fdf4;

}



.approved-bg .status-icon{

background:#dcfce7;

color:#166534;

}



.pending-bg{

background:#fffbeb;

}



.pending-bg .status-icon{

background:#fef3c7;

color:#92400e;

}



.rejected-bg{

background:#fef2f2;

}



.rejected-bg .status-icon{

background:#fee2e2;

color:#991b1b;

}




.section{

background:white;

border:1px solid #e2e8f0;

border-radius:12px;

padding:18px;

margin-bottom:15px;

}



.section-title{

font-size:14px;

font-weight:800;

border-left:4px solid #8B5E22;

padding-left:10px;

margin-bottom:15px;

}



.table-detail .row{

display:flex;

justify-content:space-between;

padding:14px 0;

border-bottom:1px solid #f1f5f9;

}



.row span{

color:#64748b;

font-size:12px;

}



.row strong{

color:#172033;
font-size:12px;

}



.money{

color:#15803d!important;

font-size:18px;

}



.description{

background:#f8fafc;

padding:18px;

border-radius:12px;

color:#334155;

line-height:1.6;

}





.timeline-item{

display:flex;

gap:15px;

padding-bottom:20px;

}



.dot{

width:28px;

height:28px;

border-radius:50%;

background:#e2e8f0;

display:flex;

align-items:center;

justify-content:center;

font-weight:bold;

}



.timeline-item.active .dot{

background:#dcfce7;

color:#166534;

}



.timeline-item p{

margin:5px 0;

font-size:12px;

color:#64748b;

}





.note{

background:#fff7ed;

border:1px solid #fed7aa;

padding:15px;

border-radius:12px;

color:#9a3412;

}



.document{

display:inline-block;

padding:10px 15px;

background:#334155;

color:white;

border-radius:8px;

font-size:12px;

font-weight:bold;

text-decoration:none;

}




@media(max-width:700px){

.page-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


.table-detail .row{

flex-direction:column;

gap:5px;

}


}



@media(max-width:480px){


.detail-page{

width:100%;

}


.page-header{

padding:15px;

}



.page-header h1{

font-size:19px;

}



.page-header p{

font-size:11px;

}



.back-btn{

width:100%;

text-align:center;

}



.status-card{

padding:14px;

}



.status-card h2{

font-size:16px;

}



.status-card p{

font-size:11px;

line-height:1.5;

}



.section{

padding:14px;

}



.section-title{

font-size:13px;

}



.row span,
.row strong{

font-size:11px;

}



.money{

font-size:15px!important;

}



.description{

font-size:11px;

padding:12px;

}



.document{

width:100%;

text-align:center;

}



.timeline-item{

gap:10px;

}



}

</style>



@endsection