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
$requests->whereIn('status',['approved','selesai'])->sum('jumlah'),
0,
',',
'.'
)}}
</h2>

<p>
Total nominal pengajuan yang telah disetujui
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

*{
    box-sizing:border-box;
}

body{
    font-family:Inter,system-ui,sans-serif;
    color:#334155;
}

/* ===============================
   HEADER
================================ */

.dashboard-header{
    background:#f8fafc;
    padding:18px 22px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    margin-bottom:15px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.label{
    font-size:9px;
    letter-spacing:1.7px;
    font-weight:800;
    color:#64748b;
}

.dashboard-header h1{
    margin:6px 0;
    font-size:21px;
    line-height:1.3;
    font-weight:800;
    color:#172033;
}

.dashboard-header p{
    margin:0;
    font-size:10px;
    line-height:1.5;
    color:#64748b;
}

/* ===============================
   SUMMARY
================================ */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:10px;
    margin-bottom:15px;
}

.summary-card{
    background:#fff;
    padding:14px 15px;
    min-height:82px;
    border-radius:15px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 15px rgba(15,23,42,.035);
    position:relative;
    overflow:hidden;
}

.summary-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:3px;
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
    display:block;
    font-size:9px;
    font-weight:600;
    color:#64748b;
}

.summary-card h2{
    margin:5px 0;
    font-size:18px;
    line-height:1.25;
    font-weight:800;
    color:#172033;
    overflow-wrap:anywhere;
}

.summary-card p{
    margin:0;
    font-size:8px;
    line-height:1.4;
    color:#94a3b8;
}

/* ===============================
   PANEL
================================ */

.panel{
    background:#fff;
    padding:17px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    margin-bottom:15px;
    min-width:0;
}

.panel h3{
    font-size:14px;
    font-weight:800;
    color:#172033;
    margin:0 0 12px;
    padding-left:8px;
    border-left:3px solid #334155;
}

/* ===============================
   TABLE
================================ */

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    position:relative;
}

.table-wrapper table{
    width:100%;
    min-width:800px;
    border-collapse:collapse;
}

th{
    padding:10px 11px;
    text-align:left;
    font-size:9px;
    font-weight:700;
    color:#64748b;
    background:#f8fafc;
    white-space:nowrap;
}

td{
    padding:10px 11px;
    font-size:10px;
    color:#334155;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

tbody tr{
    transition:.15s ease;
}

tbody tr:hover{
    background:#f8fafc;
}

td strong{
    font-size:10px;
    color:#172033;
}

/* ===============================
   NOMINAL
================================ */

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
    align-items:center;
    padding:5px 9px;
    border-radius:999px;
    font-size:8px;
    font-weight:700;
    white-space:nowrap;
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
    padding:6px 11px;
    border-radius:8px;
    background:#0f172a;
    color:#fff;
    font-size:9px;
    font-weight:700;
    text-decoration:none;
    white-space:nowrap;
}

.btn-detail:hover{
    background:#334155;
    color:#fff;
}

/* ===============================
   1200px
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

/* ===============================
   900px
================================ */

@media(max-width:900px){

    .dashboard-header{
        padding:17px;
    }

    .dashboard-header h1{
        font-size:19px;
    }

    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:9px;
    }

    .summary-card{
        padding:13px;
    }

    .panel{
        padding:15px;
    }

    .table-wrapper table{
        min-width:800px;
    }
}

/* ===============================
   MOBILE
================================ */
@media(max-width:600px){

    /* HEADER */

    .dashboard-header{
        padding:16px;
        border-radius:16px;
        margin-bottom:13px;
    }

    .label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .dashboard-header h1{
        font-size:19px;
        margin:6px 0;
    }

    .dashboard-header p{
        font-size:10px;
        line-height:1.5;
    }

    /* SUMMARY */

    .summary-grid{
        grid-template-columns:1fr 1fr;
        gap:9px;
        margin-bottom:13px;
    }

    .summary-card{
        min-height:76px;
        padding:11px;
        border-radius:14px;
    }

    .summary-card span{
        font-size:8px;
    }

    .summary-card h2{
        font-size:15px;
        margin:4px 0;
    }

    .summary-card p{
        font-size:8px;
    }

    /* PANEL */

    .panel{
        padding:13px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .panel h3{
        font-size:12px;
        padding-left:7px;
        margin-bottom:10px;
    }

    /* TABLE */

    .table-wrapper{
        width:100%;
        overflow-x:auto;
        overflow-y:hidden;
        -webkit-overflow-scrolling:touch;
    }

    .table-wrapper table{
        min-width:800px;
    }

    th{
        padding:9px;
        font-size:8px;
    }

    td{
        padding:9px;
        font-size:9px;
    }

    td strong{
        font-size:10px;
    }

    .nominal{
        font-size:9px;
    }

    .status{
        padding:5px 8px;
        font-size:8px;
    }

    .btn-detail{
        padding:6px 10px;
        font-size:8px;
    }

    /* SCROLL INDICATOR */

    .table-wrapper::after{
        content:"Geser →";
        display:block;
        position:absolute;
        right:8px;
        bottom:4px;
        font-size:8px;
        color:#94a3b8;
        pointer-events:none;
    }
}
/* ===============================
   SMALL MOBILE
================================ */

@media(max-width:380px){

    .summary-grid{
        grid-template-columns:1fr;
    }

    .summary-card{
        min-height:68px;
    }
}

</style>



@endsection