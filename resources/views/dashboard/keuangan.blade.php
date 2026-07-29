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
            Kelola transaksi, saldo, approval, dan aktivitas keuangan perusahaan.
        </p>



        <div class="welcome-tags">

            <span>
                ✓ Monitoring Dana
            </span>

            <span>
                ✓ Approval
            </span>

            <span>
                ✓ Audit Trail
            </span>

        </div>


    </div>




    <div class="system-status">

        <span></span>

        Keuangan Aktif

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

<div class="finance-icon green">
⏳
</div>


<div>

<label>
Pending Approval
</label>


<h2>
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
Pengeluaran Dana
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

.finance-wrapper{
width:100%;
}


/* WELCOME */

.welcome-card{

background:linear-gradient(
135deg,
#166534,
#22c55e
);

padding:25px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}


.welcome-label{

font-size:11px;

letter-spacing:2px;

font-weight:700;

}


.welcome-card h1{

font-size:26px;

margin:8px 0;

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

padding:7px 14px;

border-radius:20px;

font-size:11px;

}



.system-status{

background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-weight:700;

display:flex;

gap:8px;

align-items:center;

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

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:20px;

}



.finance-card{

background:white;

padding:18px;

border-radius:18px;

display:flex;

gap:12px;

align-items:center;

box-shadow:
0 10px 30px rgba(0,0,0,.06);

}



.finance-icon{

width:45px;

height:45px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}


.green{background:#dcfce7;}
.red{background:#fee2e2;}
.blue{background:#dbeafe;}
.orange{background:#fef3c7;}
.purple{background:#ede9fe;}



.finance-card label{

font-size:11px;

color:#64748b;

}



.finance-card h2{

font-size:18px;

color:#166534;

margin:4px 0;

}



.finance-card small{

font-size:10px;

color:#94a3b8;

}



/* MAIN */


.dashboard-grid{

display:grid;

grid-template-columns:2fr 1fr;

gap:20px;

}



.glass-panel{

background:white;

padding:20px;

border-radius:22px;

margin-bottom:18px;

box-shadow:

0 10px 30px rgba(15,23,42,.08);

}



.panel-title{

font-weight:700;

font-size:15px;

margin-bottom:15px;

}



/* SUMMARY */


.finance-summary div,
.quick-summary div{

display:flex;

justify-content:space-between;

padding:12px 0;

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

margin-bottom:8px;

}



.progress-track{

height:10px;

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

font-size:12px;

background:#f8fafc;

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




/* TRANSACTION */


.transaction-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

}



.transaction-item{

display:flex;

justify-content:space-between;

padding:12px 0;

border-bottom:1px solid #f1f5f9;

}



.expense-value{

color:#dc2626;

}



.income-value{

color:#16a34a;

}





/* HEALTH */


.health-item{

display:flex;

justify-content:space-between;

align-items:center;

padding:12px 0;

border-bottom:1px solid #f1f5f9;

}



.health-item small{

display:block;

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

font-weight:700;

color:#166534;

}




/* AUDIT */


.activity-item{

display:flex;

gap:12px;

padding:12px 0;

border-bottom:1px solid #f1f5f9;

}



.activity-dot{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

margin-top:5px;

}



.activity-content{

flex:1;

}



.activity-content p{

font-size:12px;

color:#64748b;

}



.activity-content small{

font-size:11px;

color:#94a3b8;

}




.system-row{

display:flex;

align-items:center;

gap:10px;

padding:10px 0;

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

.finance-grid{

grid-template-columns:repeat(2,1fr);

}


.dashboard-grid{

grid-template-columns:1fr;

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

gap:20px;

align-items:flex-start;

}

}

</style>


@endsection