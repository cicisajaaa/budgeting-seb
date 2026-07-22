@extends('layouts.dashboard')

@section('content')

<div class="finance-wrapper">


{{-- ================= WELCOME ================= --}}

<div class="welcome-card">

<div>

<div class="welcome-label">
DASHBOARD KEUANGAN
</div>


<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>


<p>
Kelola transaksi, pengeluaran, saldo, dan laporan keuangan perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Monitoring Dana
</span>

<span>
✓ Approval Pengeluaran
</span>

<span>
✓ Laporan Keuangan
</span>

</div>


</div>



<div class="system-status">

<span></span>

Keuangan Aktif

</div>


</div>





{{-- ================= CARD ================= --}}


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
Pembayaran client
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
Distribusi divisi
</small>

</div>

</div>





<div class="finance-card">

<div class="finance-icon purple">
🏧
</div>

<div>

<label>
Saldo Rekening Bank
</label>

<h2>
Rp {{number_format($totalSaldoBank ?? 0,0,',','.')}}
</h2>

<small>
Rekening aktif
</small>

</div>

</div>





<div class="finance-card">

<div class="finance-icon green">
✓
</div>

<div>

<label>
Approval Pending
</label>

<h2>
{{$totalApprovalPending ?? 0}}
</h2>

<small>
Menunggu persetujuan
</small>

</div>

</div>


</div>

</div>





{{-- ================= MAIN DASHBOARD ================= --}}


<div class="dashboard-grid">





{{-- ================= LEFT ================= --}}


<div class="finance-left">





{{-- RINGKASAN --}}


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

@if(($totalDeposit ?? 0)>0)

{{round(($totalExpense/$totalDeposit)*100)}}%

@else

0%

@endif

</b>


</div>




<div class="progress-track">


<div class="progress-fill"

style="width:

@if(($totalDeposit ?? 0)>0)

{{min(($totalExpense/$totalDeposit)*100,100)}}

@else

0

@endif

%">

</div>


</div>




<p class="description">

Persentase penggunaan dana berdasarkan transaksi pengeluaran perusahaan.

</p>



</div>










{{-- APPROVAL --}}


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

Menunggu

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










{{-- TRANSAKSI --}}


<div class="glass-panel">


<div class="panel-title">

🧾 Transaksi Terbaru

</div>





<div class="transaction-grid">



<div>


<h4 class="expense-title">

💸 Pengeluaran Terakhir

</h4>



@forelse($recentExpenses ?? [] as $expense)


<div class="transaction-item">


<div>


<strong>

Pengeluaran Dana

</strong>


<br>


<small>

{{\Carbon\Carbon::parse($expense->tanggal)->format('d M Y')}}

</small>


</div>



<div class="expense-value">

- Rp {{number_format($expense->jumlah ?? 0,0,',','.')}}

</div>


</div>


@empty


<div class="empty-data">

Belum ada pengeluaran

</div>


@endforelse



</div>








<div>


<h4 class="income-title">

💰 Dana Masuk Terbaru

</h4>




@forelse($recentDeposits ?? [] as $deposit)


<div class="transaction-item">


<div>


<strong>

Pembayaran Project

</strong>


<br>


<small>

{{\Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y')}}

</small>


</div>



<div class="income-value">

+ Rp {{number_format($deposit->jumlah_setoran ?? 0,0,',','.')}}

</div>



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







{{-- ================= RIGHT ================= --}}


<div class="finance-right">






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
{{-- ================= AKTIVITAS ================= --}}


<div class="glass-panel">


<div class="panel-title">

🔔 Aktivitas Terbaru

</div>




@forelse($recentExpenses ?? [] as $expense)


<div class="activity-item">


<div class="activity-dot"></div>



<div class="activity-content">


<strong>
Pengeluaran Dana
</strong>


<p>

{{\Carbon\Carbon::parse($expense->tanggal)->format('d M Y')}}

</p>


</div>



<div class="activity-money">

- Rp {{number_format($expense->jumlah ?? 0,0,',','.')}}

</div>



</div>



@empty


<div class="empty-data">

Belum ada aktivitas

</div>


@endforelse



</div>








{{-- ================= RINGKASAN CEPAT ================= --}}


<div class="glass-panel">


<div class="panel-title">

📅 Ringkasan Hari Ini

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









{{-- ================= STATUS SISTEM ================= --}}


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

Monitoring Berjalan

</div>



</div>





</div>
{{-- END FINANCE RIGHT --}}




</div>
{{-- END DASHBOARD GRID --}}



</div>
{{-- END FINANCE WRAPPER --}}









<style>


.finance-wrapper{

    width:100%;

}





.welcome-card{

    background:linear-gradient(
        135deg,
        #166534,
        #22c55e
    );

    padding:30px;

    border-radius:24px;

    color:white;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

}





.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:700;

}





.welcome-card h1{

    margin:10px 0;

    font-size:28px;

}





.welcome-card p{

    font-size:13px;

}





.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}





.welcome-tags span{

    background:rgba(255,255,255,.2);

    padding:8px 14px;

    border-radius:20px;

    font-size:11px;

}





.system-status{

    background:white;

    color:#166534;

    padding:12px 18px;

    border-radius:30px;

    display:flex;

    align-items:center;

    gap:8px;

    font-weight:700;

}





.system-status span{

    width:9px;

    height:9px;

    background:#22c55e;

    border-radius:50%;

}








/* CARD */


.finance-grid{

    display:grid;

    grid-template-columns:

    repeat(3,minmax(0,1fr));

    gap:18px;

    margin-bottom:22px;

}





.finance-card{

    background:white;

    padding:20px;

    border-radius:20px;

    display:flex;

    align-items:center;

    gap:15px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.08);

}





.finance-icon{

    width:48px;

    height:48px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

}





.green{
background:#dcfce7;
}


.red{
background:#fee2e2;
}


.blue{
background:#dbeafe;
}


.orange{
background:#fef3c7;
}


.purple{
background:#ede9fe;
}







/* GRID */


.dashboard-grid{

    display:grid;

    grid-template-columns:

    minmax(0,2fr)

    minmax(300px,1fr);

    gap:20px;

}





.finance-left,
.finance-right{

    min-width:0;

}







/* PANEL */


.glass-panel{

    background:white;

    border-radius:22px;

    padding:22px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.08);

}





.panel-title{

    font-size:16px;

    font-weight:700;

    margin-bottom:18px;

}







/* SUMMARY */


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

}





.finance-summary b,
.quick-summary b{

    color:#166534;

}








/* PROGRESS */


.progress-head{

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;

}





.progress-track{

    height:12px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}





.progress-fill{

    height:100%;

    background:linear-gradient(
        90deg,
        #166534,
        #22c55e
    );

}








/* TABLE */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    padding:12px;

    background:#f8fafc;

    font-size:12px;

}



td{

    padding:12px;

    font-size:13px;

    border-bottom:1px solid #f1f5f9;

}





.pending{

    color:#d97706;

    font-weight:700;

}







/* TRANSAKSI */


.transaction-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:25px;

}





.transaction-item{

    display:flex;

    justify-content:space-between;

    padding:12px 0;

    border-bottom:1px solid #f1f5f9;

}





.expense-value,
.activity-money{

    color:#dc2626;

    font-weight:700;

}





.income-value{

    color:#16a34a;

    font-weight:700;

}








/* HEALTH */


.health-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:15px 0;

    border-bottom:1px solid #f1f5f9;

}





.health-item strong{

    display:block;

}





.health-item small{

    color:#94a3b8;

}





.badge-success{

    background:#dcfce7;

    color:#166534;

    padding:7px 12px;

    border-radius:20px;

}





.badge-warning{

    background:#fef3c7;

    color:#92400e;

    padding:7px 12px;

    border-radius:20px;

}





.badge-money{

    color:#166534;

    font-weight:700;

}








/* ACTIVITY */


.activity-item{

    display:flex;

    align-items:center;

    gap:12px;

    padding:12px 0;

    border-bottom:1px solid #f1f5f9;

}





.activity-dot{

    width:9px;

    height:9px;

    background:#22c55e;

    border-radius:50%;

}





.activity-content{

    flex:1;

}





.activity-content p{

    margin:3px 0;

    color:#94a3b8;

    font-size:11px;

}








/* STATUS */


.system-row{

    display:flex;

    align-items:center;

    gap:10px;

    padding:10px 0;

    color:#475569;

}





.system-row span{

    width:8px;

    height:8px;

    background:#22c55e;

    border-radius:50%;

}





.empty-data{

    text-align:center;

    padding:20px;

    color:#94a3b8;

}








@media(max-width:1200px){


.dashboard-grid{

    grid-template-columns:1fr;

}



.finance-grid{

    grid-template-columns:repeat(2,1fr);

}


}





@media(max-width:700px){


.finance-grid{

    grid-template-columns:1fr;

}



.transaction-grid{

    grid-template-columns:1fr;

}



.welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}


}



</style>


@endsection