@extends('layouts.dashboard')

@section('content')


<div class="detail-container">


<div class="detail-header">

<span>
DETAIL PENGAJUAN DANA
</span>

<h1>
Persetujuan Dana
</h1>

<p>
Informasi lengkap pengajuan dana dari karyawan.
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
Status
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







@if($expense->status == 'pending')


<div class="approval-box">


<h3>
Keputusan Pengajuan
</h3>

<div class="approval-action">

<form method="POST"
class="approve-form"
action="{{route('owner.approval.approve',$expense->id)}}">

@csrf

<button class="approve">
✓ Setujui Pengajuan
</button>

</form>



<form method="POST"
action="{{route('owner.approval.reject',$expense->id)}}"
class="reject-form">

@csrf


<label>
Alasan Penolakan
</label>


<textarea 
name="catatan"
placeholder="Masukkan alasan penolakan">
</textarea>



<button class="reject">
✕ Tolak Pengajuan
</button>


</form>


</div>

</div>


@endif








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


/* HEADER */

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

}



.detail-header p{

    color:#64748b;
    font-size:14px;

}






/* PANEL */

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

}





/* DETAIL */

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

}



.detail-item b{

    color:#1e293b;
    font-size:15px;

}




/* JUMLAH */

.detail-item:nth-child(4) b{

    color:#6b4f1d;
    font-size:22px;

}






/* STATUS */


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





/* APPROVAL */

.approval-box{

    margin-top:35px;
    padding-top:30px;
    border-top:1px solid #e2e8f0;

}



.approval-box h3{

    margin-bottom:20px;

}





.approval-action{

    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;

}





.approve-form{

    display:flex;
    align-items:center;

}




.approve{

    width:100%;
    height:50px;
    border:none;
    border-radius:12px;
    background:#15803d;
    color:white;
    font-weight:700;
    font-size:14px;
    cursor:pointer;

}



.approve:hover{

    background:#166534;

}




.reject-form{

    background:#fff7ed;
    padding:20px;
    border-radius:15px;
    border:1px solid #fed7aa;

}



.reject-form label{

    display:block;
    font-size:13px;
    font-weight:700;
    color:#9a3412;
    margin-bottom:10px;

}



textarea{

    width:100%;
    height:100px;
    resize:none;

    padding:12px;

    border-radius:12px;

    border:1px solid #fdba74;

    font-size:13px;

    margin-bottom:12px;

}





.reject{

    width:100%;
    height:45px;

    background:#dc2626;
    color:white;

    border:none;

    border-radius:12px;

    font-weight:700;

    cursor:pointer;

}



.reject:hover{

    background:#b91c1c;

}






/* BACK */

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





@media(max-width:900px){

.detail-grid,
.approval-action{

    grid-template-columns:1fr;

}



.detail-item.full{

    grid-column:auto;

}

}

</style>

@endsection