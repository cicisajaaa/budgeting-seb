@extends('layouts.dashboard')

@section('content')


<div class="detail-container">


{{-- HEADER --}}

<div class="dashboard-header">


<div class="header-content">


<div>


<span class="label">
MONITORING DANA
</span>


<h1>
Detail Pengajuan Dana
</h1>


<p>
Melihat informasi dan status pengajuan dana yang telah diproses oleh bagian keuangan.
</p>


</div>




<a href="{{route('owner.approval')}}"
class="back-btn">

← Kembali

</a>



</div>


</div>









{{-- INFORMASI --}}


<div class="panel">


<h3>
📄 Informasi Pengajuan
</h3>




<div class="detail-grid">



<div class="detail-item">

<label>
Project
</label>

<b>
{{ $expense->proyek->nama_proyek ?? '-' }}
</b>

</div>







<div class="detail-item">

<label>
Pengaju
</label>

<b>
{{ $expense->user->name ?? '-' }}
</b>

</div>







<div class="detail-item">

<label>
Judul Pengajuan
</label>

<b>
{{ $expense->judul ?? '-' }}
</b>

</div>







<div class="detail-item">

<label>
Jumlah Dana
</label>

<b class="amount">

Rp {{number_format(
$expense->jumlah ?? 0,
0,
',',
'.'
)}}

</b>

</div>







<div class="detail-item full">

<label>
Keterangan
</label>

<b>
{{ $expense->keterangan ?? '-' }}
</b>

</div>








<div class="detail-item">

<label>
Status Pengajuan
</label>



@if($expense->status == 'pending')


<span class="status pending">
Menunggu
</span>



@elseif($expense->status == 'approved')


<span class="status approved">
Disetujui
</span>



@else


<span class="status rejected">
Ditolak
</span>



@endif



</div>







</div>


</div>









{{-- MONITORING --}}


<div class="panel">


<h3>
📊 Monitoring Keputusan Pengajuan
</h3>




@if($expense->status == 'pending')



<div class="info-box waiting-box">


<span>
⏳ Menunggu Verifikasi Keuangan
</span>


<p>
Pengajuan dana masih menunggu proses verifikasi dari bagian keuangan.
Owner hanya memiliki akses untuk melihat perkembangan pengajuan.
</p>


</div>







@elseif($expense->status == 'approved')



<div class="info-box approved-box">


<span>
✓ Pengajuan Disetujui
</span>


<p>
Pengajuan dana telah disetujui oleh bagian keuangan dan dapat diproses sesuai prosedur perusahaan.
</p>


</div>







@else



<div class="info-box rejected-box">


<span>
✕ Pengajuan Ditolak
</span>


<p>
Pengajuan dana tidak disetujui oleh bagian keuangan.
</p>





@if($expense->catatan)


<div class="reason">


<strong>
Alasan Penolakan
</strong>


<p>
{{ $expense->catatan }}
</p>


</div>



@endif



</div>



@endif





</div>






</div>







<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


/* ===============================
HEADER
================================ */


.dashboard-header{

    background:#f8fafc;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.header-content{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.dashboard-header h1{

    font-size:24px;

    margin:8px 0;

    font-weight:800;

    color:#172033;

}



.dashboard-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}






/* ===============================
BACK BUTTON
================================ */


.back-btn{

    display:inline-flex;

    align-items:center;

    padding:10px 18px;

    border-radius:12px;

    background:#0f172a;

    color:white;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}






/* ===============================
PANEL
================================ */


.panel{

    background:white;

    padding:22px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

    margin-bottom:22px;

}



.panel h3{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

    padding-left:10px;

    border-left:4px solid #334155;

}







/* ===============================
DETAIL GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:15px;

}



.detail-item{

    background:#f8fafc;

    padding:16px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}



.detail-item:hover{

    background:white;

}



.detail-item.full{

    grid-column:span 2;

}



.detail-item label{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



.detail-item b{

    font-size:13px;

    color:#172033;

}



.amount{

    font-size:18px!important;

    color:#15803d!important;

}






/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    padding:6px 13px;

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

    color:#991b1b;

}







/* ===============================
MONITORING BOX
================================ */


.info-box{

    padding:20px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}



.info-box span{

    display:inline-flex;

    padding:7px 13px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.info-box p{

    margin-top:12px;

    font-size:12px;

    line-height:1.6;

    color:#64748b;

}



.waiting-box{

    background:#fffbeb;

}



.waiting-box span{

    background:#fef3c7;

    color:#92400e;

}



.approved-box{

    background:#f0fdf4;

}



.approved-box span{

    background:#dcfce7;

    color:#166534;

}



.rejected-box{

    background:#fef2f2;

}



.rejected-box span{

    background:#fee2e2;

    color:#991b1b;

}







/* ===============================
REASON
================================ */


.reason{

    margin-top:15px;

    padding:14px;

    background:white;

    border-radius:12px;

    border:1px solid #fecaca;

}



.reason strong{

    font-size:12px;

}



.reason p{

    margin:7px 0 0;

    color:#991b1b;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.header-content{

    flex-direction:column;

    align-items:flex-start;

}



.detail-grid{

    grid-template-columns:1fr;

}



.detail-item.full{

    grid-column:auto;

}


}

</style>


@endsection