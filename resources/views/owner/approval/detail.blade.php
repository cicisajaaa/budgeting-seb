@extends('layouts.dashboard')

@section('content')


<div class="detail-container">


<div class="detail-header">

<span>
MONITORING PENGAJUAN DANA
</span>


<h1>
Detail Pengajuan Dana
</h1>


<p>
Melihat informasi dan status pengajuan dana yang telah diproses oleh bagian keuangan.
</p>


</div>





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
{{ $expense->judul }}
</b>


</div>






<div class="detail-item">

<label>
Jumlah Dana
</label>


<b>
Rp {{number_format(
$expense->jumlah,
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





<div class="monitoring-box">


<h3>
📊 Monitoring Keputusan Pengajuan
</h3>




<div class="monitoring-content">



@if($expense->status == 'pending')


<div class="waiting">


<span>
⏳ Menunggu Verifikasi Keuangan
</span>



<p>
Pengajuan dana masih menunggu proses verifikasi dari bagian keuangan.
Owner hanya memiliki akses untuk melihat perkembangan pengajuan.
</p>



</div>





@elseif($expense->status == 'approved')



<div class="approved-info">


<span>
✓ Pengajuan Disetujui
</span>



<p>
Pengajuan dana telah disetujui oleh bagian keuangan dan dapat diproses sesuai prosedur perusahaan.
</p>



</div>





@else



<div class="rejected-info">


<span>
✕ Pengajuan Ditolak
</span>



<p>
Pengajuan dana tidak disetujui oleh bagian keuangan.
</p>





@if($expense->catatan)


<div class="reason">


<strong>
Alasan Penolakan:
</strong>


<br>


{{ $expense->catatan }}



</div>



@endif




</div>



@endif



</div>


</div>








<a href="{{route('owner.approval')}}"
class="back-btn">


← Kembali


</a>




</div>


</div>


<style>


.detail-container{

    margin-top:10px;

}



/* ================= HEADER ================= */


.detail-header{

    background:white;

    padding:30px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}



.detail-header span{

    font-size:11px;

    letter-spacing:2px;

    font-weight:700;

    color:#a67c2e;

}



.detail-header h1{

    margin:12px 0 8px;

    font-size:30px;

    color:#1e293b;

    font-weight:800;

}



.detail-header p{

    color:#64748b;

    font-size:14px;

}





/* ================= PANEL ================= */


.panel{

    background:white;

    padding:30px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}



.panel h3{

    color:#1e293b;

    margin-bottom:25px;

    font-size:18px;

    font-weight:800;

}





/* ================= DETAIL GRID ================= */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}



.detail-item{

    background:#f8fafc;

    padding:20px;

    border-radius:15px;

    border:1px solid #e2e8f0;

}



.detail-item.full{

    grid-column:span 2;

}



.detail-item label{

    display:block;

    font-size:12px;

    color:#64748b;

    margin-bottom:10px;

    font-weight:600;

}



.detail-item b{

    color:#1e293b;

    font-size:15px;

}



.detail-item:nth-child(4) b{

    color:#6b4f1d;

    font-size:22px;

}





/* ================= STATUS ================= */


.status{

    display:inline-flex;

    padding:8px 16px;

    border-radius:30px;

    font-size:12px;

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





/* ================= MONITORING ================= */


.monitoring-box{

    margin-top:35px;

    padding-top:30px;

    border-top:1px solid #e2e8f0;

}



.monitoring-box h3{

    margin-bottom:20px;

}



.monitoring-content{

    background:#f8fafc;

    padding:25px;

    border-radius:15px;

    border:1px solid #e2e8f0;

}





.waiting span,
.approved-info span,
.rejected-info span{


    display:inline-block;

    padding:10px 18px;

    border-radius:20px;

    font-size:13px;

    font-weight:700;


}



.waiting span{

    background:#fef3c7;

    color:#92400e;

}



.approved-info span{

    background:#dcfce7;

    color:#166534;

}



.rejected-info span{

    background:#fee2e2;

    color:#991b1b;

}




.monitoring-content p{

    margin-top:15px;

    color:#64748b;

    font-size:14px;

    line-height:1.6;

}



.reason{


    margin-top:15px;

    padding:15px;

    background:white;

    border-radius:12px;

    border:1px solid #fecaca;

    color:#991b1b;

    font-size:13px;

}





/* ================= BACK BUTTON ================= */


.back-btn{


    display:inline-flex;

    margin-top:25px;

    padding:12px 22px;

    background:#334155;

    color:white;

    border-radius:12px;

    text-decoration:none;

    font-size:13px;

    font-weight:600;


}



.back-btn:hover{


    background:#1e293b;


}





/* ================= RESPONSIVE ================= */


@media(max-width:900px){


    .detail-grid{


        grid-template-columns:1fr;


    }



    .detail-item.full{


        grid-column:auto;


    }


}



</style>
@endsection