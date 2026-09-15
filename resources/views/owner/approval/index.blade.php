@extends('layouts.dashboard')

@section('content')


<div class="approval-container">


{{-- HEADER --}}

<div class="dashboard-header">


<span class="label">
MONITORING DANA
</span>


<h1>
Monitoring Pengajuan Dana
</h1>


<p>
Melihat perkembangan pengajuan dana yang telah diproses oleh bagian keuangan.
</p>


</div>






{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card waiting-card">

<span>
Menunggu Verifikasi
</span>


<h2>
{{ $requests->where('status','pending')->count() }}
</h2>


<p>
Pengajuan menunggu pemeriksaan
</p>


</div>





<div class="summary-card total-card">

<span>
Total Pengajuan
</span>


<h2>
{{ $requests->count() }}
</h2>


<p>
Seluruh pengajuan dana perusahaan
</p>


</div>





<div class="summary-card approved-card">

<span>
Total Dana Disetujui
</span>


<h2>

Rp {{number_format(
$requests->where('status','approved')->sum('jumlah'),
0,
',',
'.'
)}}

</h2>


<p>
Dana yang telah disetujui
</p>


</div>



</div>









{{-- TABLE --}}


<div class="panel">


<h3>
📋 Riwayat Pengajuan Dana
</h3>


<div class="table-wrapper">

<table>


<thead>

<tr>

<th>
Project
</th>


<th>
Keperluan
</th>


<th>
Pengaju
</th>


<th>
Nominal
</th>


<th>
Status
</th>


<th>
Aksi
</th>


</tr>


</thead>






<tbody>


@forelse($requests as $expense)



<tr>



<td>

<strong>
{{ $expense->proyek->nama_proyek ?? '-' }}
</strong>

</td>





<td>

{{ $expense->judul ?? '-' }}

</td>





<td>

{{ $expense->pengguna->name ?? '-' }}

</td>





<td class="nominal">

Rp {{number_format(
$expense->jumlah ?? 0,
0,
',',
'.'
)}}

</td>






<td>

@if($expense->status == 'pending')

    <span class="status waiting">
        Menunggu Persetujuan
    </span>

@elseif($expense->status == 'approved')

    <span class="status approved">
        Disetujui
    </span>

@elseif($expense->status == 'rejected')

    <span class="status rejected">
        Ditolak
    </span>

@elseif($expense->status == 'selesai')

    <span class="status selesai">
        Selesai
    </span>

@endif

</td>







<td>


<a href="{{route(
'owner.approval.detail',
$expense->id
)}}"

class="btn-detail">

Lihat Detail

</a>


</td>





</tr>





@empty


<tr>

<td colspan="6" align="center">

Belum ada pengajuan dana

</td>

</tr>



@endforelse



</tbody>


</table>

</div>
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
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:16px;

    margin-bottom:22px;

}



.summary-card{

    background:white;

    padding:20px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

}



.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    height:4px;

    width:100%;

    background:#334155;

}



.waiting-card::before{

    background:#f59e0b;

}



.total-card::before{

    background:#2563eb;

}



.approved-card::before{

    background:#16a34a;

}



.summary-card span{

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



.summary-card h2{

    font-size:20px;

    margin:8px 0;

    font-weight:800;

    color:#172033;

}



.summary-card p{

    font-size:11px;

    color:#94a3b8;

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
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:12px;

    text-align:left;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    background:#f8fafc;

}



td{

    padding:13px;

    font-size:12px;

    border-bottom:1px solid #f1f5f9;

    color:#334155;

}



tr:hover{

    background:#f8fafc;

}



td strong{

    font-size:13px;

    color:#172033;

}





.nominal{

    font-weight:800;

    white-space:nowrap;

    color:#15803d;

}








/* ===============================
STATUS
================================ */


.status{

    display:inline-flex;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.waiting{

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


.selesai{
    background:#dbeafe;
    color:#1d4ed8;
}




/* ===============================
BUTTON
================================ */


.btn-detail{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 15px;

    border-radius:10px;

    background:#0f172a;

    color:white;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.btn-detail:hover{

    background:#334155;

    color:white;

}







/* ===============================
RESPONSIVE
================================ */
/* ===============================
   RESPONSIVE
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(2,1fr);
    }

}


@media(max-width:900px){

    .dashboard-header{
        padding:22px;
        border-radius:20px;
    }

    .dashboard-header h1{
        font-size:22px;
        line-height:1.35;
    }

    .dashboard-header p{
        font-size:11px;
        line-height:1.5;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        padding:15px;
        border-radius:18px;
        min-width:0;
    }

    .summary-card span{
        font-size:9px;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }

    .summary-card p{
        font-size:9px;
        line-height:1.4;
    }


    .panel{
        padding:20px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel h3{
        font-size:14px;
        margin-bottom:15px;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .table-wrapper table{
        min-width:850px;
    }

    .table-wrapper th{
        padding:12px;
        font-size:10px;
        white-space:nowrap;
    }

    .table-wrapper td{
        padding:12px;
        font-size:10px;
        white-space:nowrap;
    }

    .table-wrapper td strong{
        font-size:11px;
    }

    .status{
        padding:5px 9px;
        font-size:8px;
        white-space:nowrap;
    }

    .btn-detail{
        padding:7px 11px;
        font-size:9px;
        white-space:nowrap;
    }

}


@media(max-width:600px){

    .dashboard-header{
        padding:18px;
        border-radius:18px;
        margin-bottom:16px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .dashboard-header h1{
        font-size:19px;
        margin:7px 0;
    }

    .dashboard-header p{
        font-size:10px;
    }


    .summary-grid{
        grid-template-columns:1fr;
        gap:10px;
        margin-bottom:16px;
    }

    .summary-card{
        padding:13px;
        border-radius:16px;
    }

    .summary-card span{
        font-size:8px;
    }

    .summary-card h2{
        font-size:16px;
        margin:5px 0;
    }

    .summary-card p{
        font-size:8px;
    }


    .panel{
        padding:14px;
        border-radius:17px;
    }

    .panel h3{
        font-size:12px;
        padding-left:8px;
        border-left-width:3px;
    }


    .table-wrapper{
        margin-top:8px;
    }

    .table-wrapper table{
        min-width:800px;
    }

    .table-wrapper th{
        padding:10px;
        font-size:8px;
    }

    .table-wrapper td{
        padding:10px;
        font-size:9px;
    }

    .table-wrapper td strong{
        font-size:10px;
    }

    .status{
        padding:5px 8px;
        font-size:7px;
    }

    .btn-detail{
        padding:6px 9px;
        font-size:8px;
    }

}
</style>



@endsection