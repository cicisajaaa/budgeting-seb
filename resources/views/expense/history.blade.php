@extends('layouts.dashboard')

@section('content')

<div class="welcome-card">

    <div>

        <div class="welcome-label">
            EMPLOYEE FINANCE PORTAL
        </div>

        <h1>
            Riwayat Pengajuan Dana
        </h1>

        <p>
            Monitoring status permintaan dana project secara real-time.
        </p>

        <div class="welcome-tags">

            <span>
                ✓ Expense Tracking
            </span>

            <span>
                ✓ Approval Flow
            </span>

            <span>
                ✓ Budget Monitoring
            </span>

        </div>

    </div>


    <a href="{{route('expense.create')}}"
       class="create-btn">

        + Buat Pengajuan

    </a>


</div>






{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">


<div class="summary-icon">
📄
</div>


<div>

<label>
Total Pengajuan
</label>


<h2>
{{$requests->count()}}
</h2>


<small>
Seluruh pengajuan dana
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
⏳
</div>


<div>

<label>
Menunggu Approval
</label>


<h2>
{{$requests->where('status','pending')->count()}}
</h2>


<small>
Sedang diproses finance
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
✅
</div>


<div>

<label>
Disetujui
</label>


<h2>
{{$requests->where('status','approved')->count()}}
</h2>


<small>
Pengajuan berhasil
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
❌
</div>


<div>

<label>
Ditolak
</label>


<h2>
{{$requests->where('status','rejected')->count()}}
</h2>


<small>
Perlu diperiksa
</small>


</div>


</div>


</div>









{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">
🔎 Filter Status Pengajuan
</div>




<form method="GET"
action="{{route('expense.myhistory')}}">


<div class="filter-box">


<div>


<label>
Status Pengajuan
</label>



<select name="status">


<option value="">
Semua Status
</option>



<option value="pending"
{{request('status')=='pending'?'selected':''}}>
Menunggu
</option>



<option value="approved"
{{request('status')=='approved'?'selected':''}}>
Disetujui
</option>



<option value="rejected"
{{request('status')=='rejected'?'selected':''}}>
Ditolak
</option>



</select>


</div>





<button type="submit">
Filter
</button>




<a href="{{route('expense.myhistory')}}">
Reset
</a>



</div>


</form>


</div>









{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">


<div class="panel-title">
📋 Daftar Pengajuan Dana
</div>


<small>
Riwayat pengajuan kebutuhan project
</small>


</div>





<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Nomor Pengajuan
</th>


<th>
Tanggal
</th>


<th>
Kebutuhan
</th>


<th>
Project
</th>


<th>
Perusahaan
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



@forelse($requests as $request)



<tr>


<td>

<strong>
{{$request->nomor_pengajuan ?? '-'}}
</strong>

</td>




<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>




<td>


<strong>
{{$request->judul}}
</strong>


<br>


<small>
{{$request->keterangan ?? '-'}}
</small>


</td>






<td>


<strong>
{{$request->proyek->nama_proyek ?? '-'}}
</strong>


<br>


<small>
{{$request->divisi->nama_divisi ?? '-'}}
</small>


</td>






<td>


{{$request->proyek->perusahaan->nama_perusahaan ?? '-'}}


</td>







<td class="money">


Rp {{number_format(
$request->jumlah ?? 0,
0,
',',
'.'
)}}


</td>






<td>


@if($request->status == 'pending')

    <span class="status pending">
        ● Menunggu
    </span>

@elseif($request->status == 'approved')

    <span class="status approved">
        ● Disetujui
    </span>

@elseif($request->status == 'rejected')

    <span class="status rejected">
        ● Ditolak
    </span>

@elseif($request->status == 'selesai')

    <span class="status selesai">
        ● Selesai
    </span>

@endif



</td>







<td>


<a href="{{route('expense.detail',$request->id)}}"
class="detail-btn">

Detail

</a>


</td>



</tr>



@empty




<tr>

<td colspan="8" class="empty-cell">
<div class="empty">

<div class="empty-icon">
📄
</div>

<h3>
Belum Ada Pengajuan Dana
</h3>

<p>
Belum ada transaksi pengajuan dana untuk akun ini.
</p>

<a href="{{route('expense.create')}}"
class="create-mini">

+ Buat Pengajuan

</a>

</div>

</td>


</tr>



@endforelse



</tbody>



</table>



</div>



</div>







<style>

* {
    box-sizing: border-box;
}

/* =========================
   WELCOME
========================= */

.welcome-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 22px;
    padding: 30px;
    margin-bottom: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
}

.welcome-label {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    color: #64748b;
}

.welcome-card h1 {
    margin: 8px 0;
    font-size: 25px;
    font-weight: 800;
    color: #172033;
}

.welcome-card p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.welcome-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
}

.welcome-tags span {
    background: #eef2f7;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    color: #475569;
}

.create-btn {
    flex-shrink: 0;
    background: #1e293b;
    color: #fff;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 6px 15px rgba(15, 23, 42, .12);
    transition: .2s;
}

.create-btn:hover {
    background: #0f172a;
    transform: translateY(-1px);
}


/* =========================
   SUMMARY
========================= */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}

.summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 17px;
    padding: 17px;
    display: flex;
    align-items: center;
    gap: 13px;
    min-height: 88px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
}

.summary-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.summary-card:nth-child(1)::before {
    background: #2563eb;
}

.summary-card:nth-child(2)::before {
    background: #f59e0b;
}

.summary-card:nth-child(3)::before {
    background: #16a34a;
}

.summary-card:nth-child(4)::before {
    background: #dc2626;
}

.summary-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
}

.summary-card:nth-child(1) .summary-icon {
    background: #dbeafe;
}

.summary-card:nth-child(2) .summary-icon {
    background: #fef3c7;
}

.summary-card:nth-child(3) .summary-icon {
    background: #dcfce7;
}

.summary-card:nth-child(4) .summary-icon {
    background: #fee2e2;
}

.summary-card label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
}

.summary-card h2 {
    margin: 4px 0 2px;
    font-size: 22px;
    font-weight: 800;
    color: #172033;
}

.summary-card small {
    font-size: 9px;
    color: #94a3b8;
}


/* =========================
   PANEL
========================= */

.glass-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 22px;
    margin-bottom: 18px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .04);
}

.panel-header {
    margin-bottom: 18px;
}

.panel-title {
    font-size: 15px;
    font-weight: 800;
    color: #172033;
    border-left: 4px solid #334155;
    padding-left: 10px;
}

.panel-header small {
    display: block;
    margin-top: 5px;
    margin-left: 14px;
    font-size: 11px;
    color: #94a3b8;
}


/* =========================
   FILTER
========================= */

.filter-box {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 16px;
}

.filter-box > div {
    min-width: 220px;
}

.filter-box label {
    display: block;
    margin-bottom: 6px;
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
}

.filter-box select {
    width: 100%;
    height: 40px;
    border-radius: 10px;
    border: 1px solid #dbe2ea;
    background: #fff;
    padding: 0 12px;
    font-size: 11px;
    color: #334155;
    outline: none;
}

.filter-box select:focus {
    border-color: #94a3b8;
}

.filter-box button,
.filter-box a {
    height: 40px;
    padding: 0 18px;
    border-radius: 10px;
    border: none;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.filter-box button {
    background: #334155;
    color: #fff;
}

.filter-box button:hover {
    background: #1e293b;
}

.filter-box a {
    background: #f1f5f9;
    color: #475569;
}

.filter-box a:hover {
    background: #e2e8f0;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    overflow-x: auto;
    border: 1px solid #e5e7eb;
    border-radius: 15px;
}

table {
    width: 100%;
    min-width: 1050px;
    border-collapse: separate;
    border-spacing: 0;
}

thead th {
    background: #f8fafc;
    padding: 13px 14px;
    font-size: 10px;
    font-weight: 800;
    color: #64748b;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}

tbody td {
    padding: 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 11px;
    color: #475569;
    vertical-align: middle;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr {
    transition: background .15s ease;
}

tbody tr:hover {
    background: #fafbfc;
}

td strong {
    color: #172033;
    font-weight: 700;
}

td small {
    display: inline-block;
    margin-top: 3px;
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.4;
}


/* =========================
   TABLE COLUMN
========================= */

td:nth-child(1) {
    min-width: 145px;
}

td:nth-child(2) {
    white-space: nowrap;
}

td:nth-child(3) {
    min-width: 190px;
    max-width: 230px;
}

td:nth-child(4) {
    min-width: 160px;
}

td:nth-child(5) {
    min-width: 150px;
}

td:nth-child(6) {
    text-align: right;
    white-space: nowrap;
}

td:nth-child(7) {
    min-width: 115px;
}

td:nth-child(8) {
    text-align: center;
    white-space: nowrap;
}


/* =========================
   MONEY
========================= */

.money {
    font-weight: 800;
    color: #166534;
}


/* =========================
   STATUS
========================= */

.status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

.pending {
    background: #fef3c7;
    color: #92400e;
}

.approved {
    background: #dcfce7;
    color: #166534;
}

.rejected {
    background: #fee2e2;
    color: #b91c1c;
}

.selesai {
    background: #dbeafe;
    color: #1d4ed8;
}


/* =========================
   DETAIL BUTTON
========================= */

.detail-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #334155;
    color: #fff;
    padding: 7px 13px;
    border-radius: 9px;
    font-size: 10px;
    font-weight: 700;
    text-decoration: none;
    transition: .2s;
}

.detail-btn:hover {
    background: #0f172a;
    transform: translateY(-1px);
}


/* =========================
   EMPTY
========================= */

.empty-cell {
    padding: 0 !important;
}

.empty {
    text-align: center;
    padding: 50px 20px;
    color: #94a3b8;
}

.empty-icon {
    font-size: 38px;
    margin-bottom: 10px;
}

.empty h3 {
    margin: 0 0 6px;
    font-size: 15px;
    color: #172033;
}

.empty p {
    margin: 0;
    font-size: 11px;
    color: #94a3b8;
}

.create-mini {
    display: inline-block;
    margin-top: 12px;
    background: #334155;
    color: #fff;
    padding: 9px 15px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 10px;
    font-weight: 700;
}


/* =========================
   RESPONSIVE
========================= */
/* =========================
   RESPONSIVE
========================= */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(2,1fr);
    }

}


@media(max-width:900px){

    .welcome-card{
        flex-direction:column;
        align-items:stretch;
        gap:15px;
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
        word-break:break-word;
    }

    .welcome-tags{
        flex-wrap:wrap;
        gap:7px;
    }

    .welcome-tags span{
        font-size:9px;
        padding:6px 9px;
    }

    .create-btn{
        width:100%;
        min-height:42px;
        display:flex;
        align-items:center;
        justify-content:center;
        box-sizing:border-box;
        font-size:11px;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        min-width:0;
        padding:15px;
        border-radius:17px;
        gap:10px;
    }

    .summary-icon{
        width:38px;
        height:38px;
        font-size:16px;
        flex-shrink:0;
    }

    .summary-card > div:last-child{
        min-width:0;
    }

    .summary-card label,
    .summary-card h2,
    .summary-card small{
        word-break:break-word;
    }

    .summary-card label{
        font-size:9px;
    }

    .summary-card h2{
        font-size:19px;
    }

    .summary-card small{
        font-size:8px;
        line-height:1.4;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel-title{
        font-size:14px;
        line-height:1.4;
    }

    .panel-header small{
        font-size:9px;
        line-height:1.5;
    }


    .filter-box{
        flex-direction:column;
        align-items:stretch;
        gap:10px;
    }

    .filter-box > div{
        min-width:100%;
        width:100%;
    }

    .filter-box label{
        font-size:9px;
    }

    .filter-box select{
        width:100%;
        height:42px;
        box-sizing:border-box;
        font-size:10px;
    }

    .filter-box button,
    .filter-box a{
        width:100%;
        height:42px;
        font-size:10px;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    table{
        min-width:1050px;
    }

    thead th{
        padding:11px 9px;
        font-size:9px;
    }

    tbody td{
        padding:11px 9px;
        font-size:10px;
    }

    td strong{
        font-size:10px;
    }

    td small{
        font-size:8px;
        line-height:1.4;
    }

    .status{
        padding:5px 9px;
        font-size:8px;
    }

    .detail-btn{
        min-height:36px;
        padding:7px 11px;
        font-size:9px;
        box-sizing:border-box;
    }


    .empty{
        padding:35px 15px;
    }

    .empty-icon{
        font-size:32px;
    }

    .empty h3{
        font-size:13px;
    }

    .empty p{
        font-size:9px;
        line-height:1.5;
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
    }

    .welcome-tags{
        gap:6px;
        margin-top:12px;
    }

    .welcome-tags span{
        font-size:8px;
        padding:5px 8px;
    }

    .create-btn{
        height:42px;
        font-size:10px;
        border-radius:10px;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:10px;
        margin-bottom:18px;
    }

    .summary-card{
        padding:12px;
        border-radius:15px;
        gap:8px;
        min-height:82px;
    }

    .summary-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .summary-card label{
        font-size:8px;
        line-height:1.3;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0 2px;
    }

    .summary-card small{
        font-size:7px;
        line-height:1.3;
    }


    .glass-panel{
        padding:15px;
        border-radius:18px;
        margin-bottom:15px;
    }

    .panel-title{
        font-size:13px;
    }

    .panel-header{
        margin-bottom:14px;
    }

    .panel-header small{
        font-size:8px;
    }


    .filter-box{
        gap:8px;
        margin-top:13px;
    }

    .filter-box label{
        font-size:8px;
        margin-bottom:5px;
    }

    .filter-box select{
        height:40px;
        padding:0 10px;
        font-size:9px;
        border-radius:9px;
    }

    .filter-box button,
    .filter-box a{
        height:40px;
        font-size:9px;
        border-radius:9px;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    table{
        min-width:1050px;
    }

    thead th{
        padding:10px 8px;
        font-size:8px;
    }

    tbody td{
        padding:10px 8px;
        font-size:9px;
    }

    td strong{
        font-size:9px;
    }

    td small{
        font-size:7px;
        line-height:1.4;
    }

    .status{
        padding:5px 8px;
        font-size:7px;
    }

    .detail-btn{
        min-height:36px;
        padding:7px 10px;
        font-size:8px;
        border-radius:8px;
    }


    .empty{
        padding:25px 12px;
    }

    .empty-icon{
        font-size:30px;
    }

    .empty h3{
        font-size:11px;
    }

    .empty p{
        font-size:8px;
        line-height:1.4;
    }

    .create-mini{
        margin-top:10px;
        padding:8px 12px;
        font-size:8px;
    }

}

</style>


@endsection