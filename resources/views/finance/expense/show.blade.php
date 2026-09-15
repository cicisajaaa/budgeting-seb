@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


    <div>


        <div class="welcome-label">
            FINANCE DETAIL
        </div>


        <h1>
            Detail Pengeluaran Dana
        </h1>


        <p>
            Informasi lengkap transaksi pencairan dana perusahaan.
        </p>



        <div class="welcome-tags">

            <span>
                ✓ Expense Tracking
            </span>


            <span>
                ✓ Audit Control
            </span>


            <span>
                ✓ Cash Flow
            </span>


        </div>


    </div>


</div>









{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">


<div class="summary-icon">
💸
</div>



<div>


<label>
Nominal Pencairan
</label>


<h2>
Rp {{number_format(
$transaction->jumlah,
0,
',',
'.'
)}}
</h2>


<small>
Dana keluar perusahaan
</small>


</div>



</div>








<div class="summary-card">


<div class="summary-icon">
📅
</div>



<div>


<label>
Tanggal Transaksi
</label>


<h2>

{{$transaction->tanggal->format('d M Y')}}

</h2>


<small>
Tanggal pencairan dana
</small>


</div>


</div>


</div>












{{-- INFORMASI TRANSAKSI --}}



<div class="glass-panel">


<div class="panel-header">


<div>


<div class="panel-title">
📄 Informasi Transaksi
</div>


<small>
Detail pencairan dana
</small>


</div>


</div>






<div class="detail-grid">



<div class="detail-box">

<label>
ID Transaksi
</label>

<h3>
#{{$transaction->id}}
</h3>

</div>





<div class="detail-box">

<label>
Status
</label>


<h3>

<span class="status active">

✓ Berhasil Dicairkan

</span>


</h3>


</div>




<div class="detail-box">

<label>
Rekening Bank
</label>

<h3>
{{$transaction->rekeningBank->nama_bank ?? '-'}}
<br>

<small>
{{$transaction->rekeningBank->nomor_rekening ?? '-'}}
</small>

</h3>

</div>







<div class="detail-box">

<label>
Disetujui Oleh
</label>


<h3>
{{$transaction->penyetuju->name ?? '-'}}
</h3>


</div>




</div>


</div>













{{-- DETAIL PENGAJUAN --}}



<div class="glass-panel">


<div class="panel-header">


<div>


<div class="panel-title">
🏢 Detail Pengajuan Dana
</div>


<small>
Informasi sumber transaksi
</small>


</div>


</div>





<div class="info-list">

<div>

<span>
Nomor Pengajuan
</span>

<b>
{{$transaction->pengajuanDana->nomor_pengajuan ?? '-'}}
</b>

</div>

<div>

<span>
Pemohon
</span>


<b>
{{$transaction->pengajuanDana->pengguna->name ?? '-'}}
</b>


</div>






<div>

<span>
Judul Pengajuan
</span>


<b>
{{$transaction->pengajuanDana->judul ?? '-'}}
</b>


</div>






<div>

<span>
Perusahaan
</span>


<b>
{{$transaction->pengajuanDana->proyek->perusahaan->nama_perusahaan ?? '-'}}
</b>


</div>






<div>

<span>
Project
</span>


<b>
{{$transaction->pengajuanDana->proyek->nama_proyek ?? '-'}}
</b>


</div>






<div>

<span>
Divisi
</span>


<b>
{{$transaction->pengajuanDana->divisi->nama_divisi ?? '-'}}
</b>


</div>

<div>

<span>
Bukti Pengajuan
</span>


<b>

@if($transaction->pengajuanDana->bukti_pengajuan)

<a href="{{asset('uploads/pengajuan/'.$transaction->pengajuanDana->bukti_pengajuan)}}"
target="_blank">

Lihat Dokumen

</a>

@else

-

@endif

</b>


</div>



<div>

<span>
Keterangan
</span>


<b>
{{$transaction->pengajuanDana->keterangan ?? '-'}}
</b>


</div>



</div>



</div>













{{-- APPROVAL --}}



<div class="glass-panel">


<div class="panel-title">
✅ Approval Information
</div>



<div class="approval-box">


<div>

<span>
Disetujui Pada
</span>


<b>

@if($transaction->pengajuanDana->disetujui_pada)

{{$transaction->pengajuanDana->disetujui_pada->format('d M Y H:i')}}

@else

-

@endif

</b>


</div>





<div>

<span>
Approval Oleh
</span>


<b>
{{$transaction->penyetuju->name ?? '-'}}
</b>


</div>



</div>



</div>









<a href="{{route('finance.expense.index')}}"
class="back-btn">

← Kembali ke Pengeluaran


</a>









<style>


/* HEADER */


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

font-size:24px;

font-weight:800;

color:#172033;

}



.welcome-card p{

margin:0;

font-size:13px;

color:#64748b;

}





.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:#f1f5f9;

color:#334155;

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}









/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

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

0 10px 30px rgba(15,23,42,.05);

}



.summary-card::before{

content:"";

position:absolute;

top:0;

left:0;

width:100%;

height:4px;

background:#334155;

}



.summary-icon{

width:48px;

height:48px;

border-radius:15px;

background:#dbeafe;

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

font-size:19px;

font-weight:800;

color:#172033;

}



.summary-card small{

font-size:10px;

color:#94a3b8;

}









/* PANEL */


.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

margin-bottom:20px;

box-shadow:

0 10px 30px rgba(15,23,42,.06);

}



.panel-header{

margin-bottom:20px;

}



.panel-title{

font-size:16px;

font-weight:800;

color:#172033;

}



.panel-header small{

font-size:11px;

color:#94a3b8;

}









/* DETAIL */


.detail-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:18px;

}



.detail-box{

background:#f8fafc;

padding:18px;

border-radius:16px;

}



.detail-box label{

font-size:11px;

color:#64748b;

}



.detail-box h3{

margin-top:8px;

font-size:14px;

color:#172033;

}







/* LIST */


.info-list div,
.approval-box div{

display:flex;

justify-content:space-between;

padding:14px 0;

border-bottom:1px solid #f1f5f9;

font-size:12px;

}



.info-list span,
.approval-box span{

color:#64748b;

}



.info-list b,
.approval-box b{

color:#172033;

}






.status{

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}



.status.active{

background:#dcfce7;

color:#166534;

}







.back-btn{

display:inline-flex;

padding:10px 18px;

border-radius:12px;

background:#334155;

color:white;

font-size:12px;

font-weight:700;

text-decoration:none;

}




/* ===============================
   RESPONSIVE
================================ */

@media(max-width:900px){

    .welcome-card{
        padding:22px;
        border-radius:20px;
    }

    .welcome-label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
    }

    .welcome-tags{
        flex-wrap:wrap;
        gap:7px;
    }

    .welcome-tags span{
        font-size:9px;
        padding:6px 9px;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        min-width:0;
        padding:14px;
        border-radius:18px;
        gap:10px;
    }

    .summary-icon{
        width:38px;
        height:38px;
        border-radius:11px;
        font-size:16px;
        flex-shrink:0;
    }

    .summary-card > div:last-child{
        min-width:0;
    }

    .summary-card label{
        font-size:9px;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }

    .summary-card small{
        font-size:8px;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
    }

    .panel-title{
        font-size:14px;
        line-height:1.4;
    }

    .panel-header small{
        font-size:9px;
    }


    .detail-grid{
        grid-template-columns:1fr;
        gap:12px;
    }

    .detail-box{
        padding:14px;
        border-radius:13px;
        min-width:0;
    }

    .detail-box label{
        font-size:9px;
    }

    .detail-box h3{
        margin-top:6px;
        font-size:12px;
        line-height:1.5;
        word-break:break-word;
    }

    .detail-box h3 small{
        font-size:9px;
        color:#94a3b8;
    }


    .status{
        display:inline-flex;
        align-items:center;
        padding:5px 9px;
        font-size:8px;
        white-space:nowrap;
    }


    .info-list div,
    .approval-box div{
        flex-direction:column;
        align-items:flex-start;
        gap:5px;
        padding:12px 0;
        font-size:10px;
    }

    .info-list span,
    .approval-box span{
        font-size:9px;
    }

    .info-list b,
    .approval-box b{
        font-size:10px;
        line-height:1.5;
        word-break:break-word;
        max-width:100%;
    }

    .info-list a{
        word-break:break-word;
    }


    .back-btn{
        width:100%;
        box-sizing:border-box;
        justify-content:center;
        text-align:center;
        padding:11px 15px;
        font-size:10px;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
    }

    .welcome-card p{
        font-size:10px;
        line-height:1.5;
    }

    .welcome-tags{
        gap:6px;
        margin-top:12px;
    }

    .welcome-tags span{
        font-size:8px;
        padding:5px 8px;
    }


    .summary-grid{
        grid-template-columns:1fr;
        gap:10px;
        margin-bottom:18px;
    }

    .summary-card{
        padding:12px;
        border-radius:15px;
    }

    .summary-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .summary-card label{
        font-size:8px;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0;
    }

    .summary-card small{
        font-size:7px;
    }


    .glass-panel{
        padding:14px;
        border-radius:17px;
        margin-bottom:14px;
    }

    .panel-title{
        font-size:13px;
    }

    .panel-header small{
        font-size:8px;
    }


    .detail-grid{
        gap:9px;
    }

    .detail-box{
        padding:12px;
        border-radius:12px;
    }

    .detail-box label{
        font-size:8px;
    }

    .detail-box h3{
        font-size:10px;
        line-height:1.5;
    }

    .detail-box h3 small{
        font-size:8px;
    }


    .status{
        padding:5px 8px;
        font-size:7px;
    }


    .info-list div,
    .approval-box div{
        padding:10px 0;
        gap:4px;
        font-size:9px;
    }

    .info-list span,
    .approval-box span{
        font-size:8px;
    }

    .info-list b,
    .approval-box b{
        font-size:9px;
    }


    .back-btn{
        padding:10px 12px;
        border-radius:11px;
        font-size:9px;
    }

}

</style>



@endsection