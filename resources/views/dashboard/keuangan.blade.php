@extends('layouts.dashboard')

@section('content')

<div class="finance-wrapper">


{{-- ================= WELCOME ================= --}}
<div class="dashboard-title">

<div>

<div class="welcome-label">
DASHBOARD KEUANGAN
</div>

<h1>
Selamat Datang, 
<span>{{auth()->user()->name}}</span>
</h1>

<p>
Kelola transaksi, saldo, approval dan laporan keuangan perusahaan.
</p>

</div>

</div>






{{-- ================= STATISTIK ================= --}}


<div class="finance-grid">


<div class="finance-card">

<div class="finance-icon green">
💰
</div>

<div>

<label>
Total Dana Masuk
</label>


<h2>
Rp {{number_format($totalDeposit ?? 0,0,',','.')}}
</h2>


<small>
Pembayaran project
</small>


</div>

</div>





<div class="finance-card">

<div class="finance-icon red">
💸
</div>


<div>

<label>
Total Pengeluaran
</label>


<h2>
Rp {{number_format($totalExpense ?? 0,0,',','.')}}
</h2>


<small>
Dana digunakan
</small>


</div>

</div>





<div class="finance-card">

<div class="finance-icon blue">
🏦
</div>


<div>

<label>
Saldo Perusahaan
</label>


<h2>
Rp {{number_format($sisaDana ?? 0,0,',','.')}}
</h2>


<small>
Dana tersedia
</small>


</div>

</div>





<div class="finance-card">

<div class="finance-icon orange">
🏢
</div>


<div>

<label>
Saldo Divisi
</label>


<h2>
Rp {{number_format($totalSaldoDivisi ?? 0,0,',','.')}}
</h2>


<small>
Distribusi anggaran
</small>


</div>

</div>





<div class="finance-card">

<div class="finance-icon purple">
🏧
</div>


<div>

<label>
Saldo Rekening
</label>


<h2>
Rp {{number_format($totalSaldoBank ?? 0,0,',','.')}}
</h2>


<small>
Bank aktif
</small>


</div>

</div>




<div class="finance-card">

<div class="finance-icon yellow">
⏳
</div>


<div>

<label>
Pending Approval
</label>


<h2 class="pending-number">
{{$totalApprovalPending ?? 0}}
</h2>


<small>
Menunggu proses
</small>


</div>

</div>




<div class="finance-card">

<div class="finance-icon green">
✓
</div>


<div>

<label>
Approved
</label>


<h2>
{{$totalApprovalApproved ?? 0}}
</h2>


<small>
Disetujui
</small>


</div>

</div>





<div class="finance-card">

<div class="finance-icon red">
✕
</div>


<div>

<label>
Rejected
</label>


<h2>
{{$totalApprovalRejected ?? 0}}
</h2>


<small>
Ditolak
</small>


</div>

</div>


</div>
{{-- ================= MAIN DASHBOARD ================= --}}

<div class="dashboard-grid">


{{-- ================= LEFT ================= --}}

<div class="finance-left">





{{-- RINGKASAN KEUANGAN --}}


<div class="glass-panel">


<div class="panel-title">
📊 Ringkasan Keuangan
</div>




<div class="finance-summary">


<div>

<span>
Total Budget Project
</span>


<b>
Rp {{number_format($totalBudget ?? 0,0,',','.')}}
</b>


</div>





<div>

<span>
Jumlah Project
</span>


<b>
{{$totalProject ?? 0}} Project
</b>


</div>





<div>

<span>
Progress Project
</span>


<b>
{{$totalProjectProgress ?? 0}}%
</b>


</div>





<div>

<span>
Pengeluaran Bulan Ini
</span>


<b>
Rp {{number_format($expenseThisMonth ?? 0,0,',','.')}}
</b>


</div>


</div>


</div>








{{-- KONDISI DANA --}}


<div class="glass-panel">


<div class="panel-title">

📈 Kondisi Dana

</div>





<div class="progress-head">


<span>
Dana Terpakai
</span>



<b>
{{$budgetUsage ?? 0}}%
</b>


</div>




<div class="progress-track">


<div class="progress-fill"

style="width:{{$budgetUsage ?? 0}}%">

</div>


</div>




<p class="description">

Persentase penggunaan dana berdasarkan transaksi keuangan.

</p>



</div>









{{-- APPROVAL TERBARU --}}


<div class="glass-panel">


<div class="panel-title">

🔔 Pengajuan Menunggu Approval

</div>





<table>


<thead>

<tr>

<th>
Pemohon
</th>


<th>
Project
</th>


<th>
Nominal
</th>


<th>
Status
</th>


</tr>

</thead>




<tbody>


@forelse($recentApproval ?? [] as $approval)


<tr>


<td>

{{$approval->pengguna->name ?? '-'}}

</td>



<td>

{{$approval->proyek->nama_proyek ?? '-'}}

</td>



<td>

Rp {{number_format($approval->jumlah ?? 0,0,',','.')}}

</td>



<td>

<span class="pending">

Pending

</span>

</td>


</tr>



@empty


<tr>

<td colspan="4" class="empty-data">

Tidak ada pengajuan

</td>

</tr>


@endforelse



</tbody>


</table>



</div>









{{-- TRANSAKSI TERBARU --}}


<div class="glass-panel">


<div class="panel-title">

🧾 Transaksi Terbaru

</div>





<div class="transaction-grid">



{{-- PENGELUARAN --}}


<div>


<h4>
💸 Pengeluaran
</h4>



@forelse($recentExpenses ?? [] as $expense)



<div class="transaction-item">


<div>

<strong>
{{$expense->pengajuanDana->judul ?? 'Pengeluaran Dana'}}
</strong>



<small>

{{\Carbon\Carbon::parse($expense->tanggal)->format('d M Y')}}

</small>


</div>




<b class="expense-value">

- Rp {{number_format($expense->jumlah ?? 0,0,',','.')}}

</b>



</div>



@empty


<div class="empty-data">

Belum ada transaksi

</div>


@endforelse



</div>








{{-- PEMASUKAN --}}


<div>


<h4>
💰 Dana Masuk
</h4>




@forelse($recentDeposits ?? [] as $deposit)



<div class="transaction-item">


<div>


<strong>
Setoran Project
</strong>



<small>

{{\Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y')}}

</small>


</div>




<b class="income-value">

+ Rp {{number_format($deposit->jumlah_setoran ?? 0,0,',','.')}}

</b>



</div>



@empty


<div class="empty-data">

Belum ada pemasukan

</div>


@endforelse



</div>



</div>



</div>





</div>
{{-- END FINANCE LEFT --}}
{{-- ================= RIGHT ================= --}}


<div class="finance-right">





{{-- FINANCIAL HEALTH --}}


<div class="glass-panel">


<div class="panel-title">

📊 Financial Health

</div>





<div class="health-item">


<div>

<strong>
Arus Dana
</strong>


<small>
Pemasukan dan pengeluaran perusahaan
</small>


</div>


<span class="badge-success">

Stabil

</span>


</div>







<div class="health-item">


<div>

<strong>
Approval Dana
</strong>


<small>
Pengajuan menunggu keputusan
</small>


</div>


<span class="badge-warning">

{{$totalApprovalPending ?? 0}} Pending

</span>


</div>







<div class="health-item">


<div>

<strong>
Saldo Aktif
</strong>


<small>
Dana tersedia perusahaan
</small>


</div>



<span class="badge-money">

Rp {{number_format($sisaDana ?? 0,0,',','.')}}

</span>


</div>



</div>









{{-- AUDIT TRAIL --}}


<div class="glass-panel">


<div class="panel-title">

📌 Aktivitas Sistem Terbaru

</div>





@forelse($recentAudit ?? [] as $audit)



<div class="activity-item">


<div class="activity-dot"></div>



<div class="activity-content">


<strong>

{{$audit->aksi}}

</strong>



<p>

{{$audit->deskripsi}}

</p>



<small>

{{$audit->pengguna->name ?? 'System'}}

-

{{$audit->created_at->format('d M Y H:i')}}

</small>



</div>



</div>




@empty


<div class="empty-data">

Belum ada aktivitas sistem

</div>


@endforelse



</div>









{{-- RINGKASAN CEPAT --}}


<div class="glass-panel">


<div class="panel-title">

📅 Ringkasan Cepat

</div>




<div class="quick-summary">


<div>


<span>
Pending Approval
</span>


<b>
{{$totalApprovalPending ?? 0}}
</b>


</div>





<div>


<span>
Project Aktif
</span>


<b>
{{$totalProject ?? 0}}
</b>


</div>





<div>


<span>
Saldo Tersedia
</span>


<b>

Rp {{number_format($sisaDana ?? 0,0,',','.')}}

</b>


</div>



</div>



</div>









{{-- STATUS SISTEM --}}


<div class="glass-panel">


<div class="panel-title">

⚡ Status Sistem

</div>





<div class="system-row">


<span></span>

Database Keuangan Aktif


</div>





<div class="system-row">


<span></span>

Transaksi Terintegrasi


</div>





<div class="system-row">


<span></span>

Audit Monitoring Berjalan


</div>



</div>






</div>
{{-- END FINANCE RIGHT --}}




</div>
{{-- END DASHBOARD GRID --}}






</div>
{{-- END FINANCE WRAPPER --}}



<style>

/* ===============================
GLOBAL
================================ */

.finance-wrapper{
    width:100%;
}


/* ===============================
HEADER
================================ */

.dashboard-title{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.dashboard-title h1{

    margin:10px 0;

    font-size:30px;

    font-weight:800;

    color:#172033;

}



.dashboard-title h1 span{

    color:#1e293b;

}



.dashboard-title p{

    margin:0;

    color:#64748b;

    font-size:14px;

}





/* ===============================
STATISTIC CARD
================================ */


.finance-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;

    margin-bottom:25px;

}




.finance-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:15px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

}




.finance-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.finance-icon{

    width:52px;

    height:52px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:23px;

}



.finance-icon.green{

    background:#dcfce7;

}



.finance-icon.red{

    background:#fee2e2;

}



.finance-icon.blue{

    background:#dbeafe;

}



.finance-icon.orange{

    background:#fef3c7;

}



.finance-icon.purple{

    background:#ede9fe;

}



.finance-icon.yellow{

    background:#fef3c7;

}



.finance-card label{

    display:block;

    font-size:12px;

    color:#64748b;

}



.finance-card h2{

    margin:5px 0;

    font-size:22px;

    color:#172033;

    font-weight:800;

}



.finance-card small{

    color:#94a3b8;

    font-size:11px;

}





.pending-number{

    color:#92400e!important;

}







/* ===============================
MAIN GRID
================================ */


.dashboard-grid{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:20px;

}






/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}





.panel-title{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}








/* ===============================
SUMMARY
================================ */


.finance-summary div,
.quick-summary div{

    display:flex;

    justify-content:space-between;

    padding:14px 0;

    border-bottom:1px solid #f1f5f9;

}



.finance-summary span,
.quick-summary span{

    color:#64748b;

    font-size:13px;

}



.finance-summary b,
.quick-summary b{

    color:#172033;

    font-size:14px;

}









/* ===============================
PROGRESS
================================ */


.progress-head{

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;

}



.progress-head span{

    color:#64748b;

    font-size:13px;

}



.progress-head b{

    color:#172033;

}



.progress-track{

    height:10px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}



.progress-fill{

    height:100%;

    background:#334155;

    border-radius:20px;

}



.description{

    margin-top:15px;

    color:#64748b;

    font-size:13px;

}








/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:14px;

    text-align:left;

    color:#64748b;

    font-size:12px;

}



td{

    padding:15px;

    border-bottom:1px solid #e5e7eb;

    font-size:13px;

    color:#334155;

}



tr:hover{

    background:#fafafa;

}





.pending{

    background:#fef3c7;

    color:#92400e;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}








/* ===============================
TRANSACTION
================================ */


.transaction-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:20px;

}



.transaction-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:14px 0;

    border-bottom:1px solid #f1f5f9;

}



.transaction-item strong{

    color:#172033;

    display:block;

}



.transaction-item small{

    color:#94a3b8;

}



.expense-value{

    color:#dc2626;

}



.income-value{

    color:#16a34a;

}







/* ===============================
HEALTH
================================ */


.health-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:14px 0;

    border-bottom:1px solid #f1f5f9;

}



.health-item small{

    display:block;

    color:#94a3b8;

    margin-top:4px;

}





.badge-success{

    background:#dcfce7;

    color:#166534;

    padding:7px 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}



.badge-warning{

    background:#fef3c7;

    color:#92400e;

    padding:7px 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}



.badge-money{

    color:#166534;

    font-weight:800;

}









/* ===============================
ACTIVITY
================================ */


.activity-item{

    display:flex;

    gap:12px;

    padding:14px 0;

    border-bottom:1px solid #f1f5f9;

}



.activity-dot{

    width:10px;

    height:10px;

    background:#334155;

    border-radius:50%;

    margin-top:6px;

}



.activity-content strong{

    color:#172033;

}



.activity-content p{

    margin:5px 0;

    font-size:13px;

    color:#64748b;

}



.activity-content small{

    color:#94a3b8;

}








/* ===============================
SYSTEM STATUS
================================ */


.system-row{

    display:flex;

    align-items:center;

    gap:10px;

    padding:10px 0;

    color:#334155;

    font-size:13px;

}



.system-row span{

    width:9px;

    height:9px;

    background:#22c55e;

    border-radius:50%;

}







.empty-data{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.finance-grid{

    grid-template-columns:repeat(2,1fr);

}



.dashboard-grid{

    grid-template-columns:1fr;

}


}



@media(max-width:800px){


.finance-grid{

    grid-template-columns:1fr;

}



.transaction-grid{

    grid-template-columns:1fr;

}



.dashboard-title{

    padding:25px;

}


}

/* ===============================
FONT COMPACT MODE
================================ */


.dashboard-title h1{
    font-size:24px;
}


.dashboard-title p{
    font-size:12px;
}



.welcome-label{

    font-size:10px;

}





.finance-card{

    padding:16px;

}



.finance-icon{

    width:42px;

    height:42px;

    font-size:18px;

}



.finance-card label{

    font-size:10px;

}



.finance-card h2{

    font-size:17px;

}



.finance-card small{

    font-size:10px;

}





.panel-title{

    font-size:15px;

    margin-bottom:15px;

}



.glass-panel{

    padding:20px;

}





.finance-summary span,
.quick-summary span{

    font-size:12px;

}



.finance-summary b,
.quick-summary b{

    font-size:13px;

}






th{

    font-size:11px;

    padding:12px;

}



td{

    font-size:12px;

    padding:12px;

}





.transaction-item strong{

    font-size:13px;

}



.transaction-item small{

    font-size:11px;

}



.health-item strong{

    font-size:13px;

}



.health-item small{

    font-size:11px;

}





.badge-success,
.badge-warning{

    font-size:10px;

    padding:6px 12px;

}





.system-row{

    font-size:12px;

}



.description{

    font-size:12px;

}


/* =================================
FINANCE DASHBOARD COMPACT MODE
MATCH OWNER STYLE
================================= */


/* HEADER */

.dashboard-title{

    padding:25px;

    border-radius:24px;

}



.welcome-label{

    font-size:10px;

}



.dashboard-title h1{

    font-size:24px;

    margin:8px 0;

}



.dashboard-title p{

    font-size:12px;

}







/* =================================
STAT CARD
================================= */


.finance-grid{

    gap:15px;

}



.finance-card{

    padding:18px;

    border-radius:22px;

}



.finance-icon{

    width:40px;

    height:40px;

    font-size:16px;

    border-radius:14px;

}



.finance-card label{

    font-size:10px;

}



.finance-card h2{

    font-size:17px;

    margin:6px 0;

}



.finance-card small{

    font-size:10px;

}







/* =================================
PANEL
================================= */


.glass-panel{

    padding:20px;

    border-radius:24px;

}



.panel-title{

    font-size:15px;

    margin-bottom:15px;

}







/* =================================
SUMMARY
================================= */


.finance-summary div,
.quick-summary div{

    padding:10px 0;

}



.finance-summary span,
.quick-summary span{

    font-size:11px;

}



.finance-summary b,
.quick-summary b{

    font-size:12px;

}








/* =================================
PROGRESS
================================= */


.progress-head span{

    font-size:11px;

}



.progress-head b{

    font-size:12px;

}



.progress-track{

    height:8px;

}



.description{

    font-size:11px;

}








/* =================================
TABLE
================================= */


th{

    padding:12px;

    font-size:11px;

}



td{

    padding:12px;

    font-size:12px;

}



.pending{

    font-size:10px;

    padding:5px 10px;

}







/* =================================
TRANSACTION
================================= */


.transaction-grid{

    gap:15px;

}



.transaction-item{

    padding:10px 0;

}



.transaction-item strong{

    font-size:12px;

}



.transaction-item small{

    font-size:10px;

}



.expense-value,
.income-value{

    font-size:12px;

}







/* =================================
HEALTH
================================= */


.health-item{

    padding:10px 0;

}



.health-item strong{

    font-size:12px;

}



.health-item small{

    font-size:10px;

}



.badge-success,
.badge-warning{

    font-size:10px;

    padding:5px 10px;

}





.badge-money{

    font-size:12px;

}







/* =================================
ACTIVITY
================================= */


.activity-item{

    padding:10px 0;

}



.activity-dot{

    width:8px;

    height:8px;

}



.activity-content strong{

    font-size:12px;

}



.activity-content p{

    font-size:11px;

}



.activity-content small{

    font-size:10px;

}







/* =================================
SYSTEM
================================= */


.system-row{

    font-size:11px;

}



.system-row span{

    width:8px;

    height:8px;

}






.empty-data{

    padding:25px;

    font-size:11px;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:1200px){

.finance-grid{

    grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:800px){

.finance-grid{

    grid-template-columns:1fr;

}

}

</style>

@endsection