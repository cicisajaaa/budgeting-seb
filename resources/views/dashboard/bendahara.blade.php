@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

    <div>

        <div class="welcome-label">
            DASHBOARD BENDAHARA
        </div>


        <h1>
            Selamat Datang, {{auth()->user()->name}}
        </h1>


        <p>
            Kelola transaksi, pengeluaran, dan saldo keuangan perusahaan.
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







<!-- STATISTIC -->


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
Rp {{number_format($totalDeposit,0,',','.')}}
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
Rp {{number_format($totalExpense,0,',','.')}}
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
Rp {{number_format($sisaDana,0,',','.')}}
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
Rp {{number_format($totalSaldoDivisi,0,',','.')}}
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







<div class="dashboard-grid">


<div>


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
Rp {{number_format($totalBudget,0,',','.')}}
</b>

</div>



<div>

<span>
Jumlah Project
</span>

<b>
{{$totalProject}} Project
</b>

</div>



<div>

<span>
Progress Project
</span>

<b>
{{$totalProjectProgress}}%
</b>

</div>


</div>



</div>
<div class="glass-panel">


<div class="panel-title">

📈 Kondisi Dana

</div>




<div class="money-progress">


<div class="progress-label">


<span>

Dana Terpakai

</span>



<b>


@if($totalDeposit > 0)

{{round(($totalExpense/$totalDeposit)*100)}}%

@else

0%

@endif


</b>



</div>






<div class="progress-track">


<div style="width:

@if($totalDeposit > 0)

{{min(($totalExpense/$totalDeposit)*100,100)}}

@else

0

@endif

%">

</div>


</div>



</div>






<p class="description">

Persentase penggunaan dana berdasarkan transaksi pengeluaran perusahaan.

</p>



</div>









<!-- APPROVAL -->


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



@forelse($recentApproval as $approval)



<tr>


<td>

{{$approval->user->name ?? '-'}}

</td>



<td>

{{$approval->project->nama_project ?? '-'}}

</td>



<td>

Rp {{number_format($approval->jumlah,0,',','.')}}

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

Tidak ada pengajuan menunggu approval

</td>

</tr>



@endforelse



</tbody>


</table>



</div>









<!-- TRANSAKSI -->


<div class="glass-panel">


<div class="panel-title">

🧾 Transaksi Terbaru

</div>





<div class="transaction-grid">






<div>


<h4 class="expense-title">

💸 Pengeluaran Terakhir

</h4>





@forelse($recentExpenses as $expense)



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

- Rp {{number_format($expense->jumlah,0,',','.')}}

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





@forelse($recentDeposits as $deposit)



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

+ Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

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









<!-- RIGHT SIDE -->


<div>



<div class="glass-panel">


<div class="panel-title">

⚡ Menu Keuangan

</div>





<a href="{{route('finance.deposit')}}" class="quick-menu">

💰 Pembayaran Masuk

</a>





<a href="{{route('expense.approval')}}" class="quick-menu">

✓ Persetujuan Pengeluaran

</a>




<a href="{{route('finance.distribution')}}" class="quick-menu">

📤 Distribusi Dana

</a>





<a href="{{route('finance.balance')}}" class="quick-menu">

🏦 Saldo Divisi

</a>





<a href="{{route('finance.report')}}" class="quick-menu">

📄 Laporan Keuangan

</a>

<a href="{{route('expense.approval.history')}}" class="quick-menu">

📋 History Approval

</a>

<a href="{{route('expense.approval')}}" 
class="quick-menu">

🔔 Approval Pengeluaran

</a>


</div>









<div class="glass-panel">


<div class="panel-title">

🔔 Status Sistem

</div>




<div class="status-item">

<span></span>

Sistem Keuangan Berjalan

</div>



<div class="status-item">

<span></span>

Data Transaksi Terintegrasi

</div>



<div class="status-item">

<span></span>

Monitoring Aktif

</div>



</div>





</div>



</div>
<style>


/* =========================
WELCOME
========================= */


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:28px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:22px;

box-shadow:

0 15px 40px rgba(34,197,94,.25);

}




.welcome-label{

font-size:10px;

font-weight:700;

letter-spacing:2px;

opacity:.8;

}



.welcome-card h1{

font-size:28px;

margin:8px 0;

}



.welcome-card p{

font-size:13px;

opacity:.9;

}



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:

rgba(255,255,255,.18);

padding:7px 14px;

border-radius:20px;

font-size:11px;

}





.system-status{

background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-size:13px;

font-weight:700;

display:flex;

align-items:center;

gap:8px;

}




.system-status span{

width:9px;

height:9px;

border-radius:50%;

background:#22c55e;

}








/* =========================
STATISTIC CARD
========================= */



.finance-grid{

display:grid;

grid-template-columns:

repeat(3,1fr);

gap:18px;

margin-bottom:22px;

}





.finance-card{

background:

rgba(255,255,255,.75);

backdrop-filter:

blur(15px);

border-radius:20px;

padding:20px;

display:flex;

align-items:center;

gap:15px;

box-shadow:

0 10px 30px rgba(15,23,42,.06);

border:

1px solid rgba(255,255,255,.7);

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






.finance-card label{

font-size:12px;

color:#64748b;

}



.finance-card h2{

font-size:19px;

color:#166534;

margin-top:5px;

}



.finance-card small{

font-size:11px;

color:#94a3b8;

}









/* =========================
MAIN GRID
========================= */


.dashboard-grid{


display:grid;


grid-template-columns:

2fr 1fr;


gap:20px;


}








.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);


border-radius:22px;


padding:22px;


margin-bottom:20px;


border:

1px solid rgba(255,255,255,.8);


}





.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:18px;


color:#1e293b;


}








/* =========================
SUMMARY
========================= */


.finance-summary div{


display:flex;


justify-content:space-between;


padding:14px 0;


border-bottom:

1px solid #f1f5f9;


font-size:13px;


}



.finance-summary span{

color:#64748b;

}



.finance-summary b{

color:#166534;

}







/* =========================
PROGRESS
========================= */


.money-progress{

margin-top:10px;

}



.progress-label{

display:flex;

justify-content:space-between;

font-size:13px;

margin-bottom:8px;

}



.progress-track{

height:10px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

}



.progress-track div{

height:100%;

background:

linear-gradient(
90deg,
#166534,
#22c55e
);

}





.description{

font-size:12px;

color:#64748b;

margin-top:12px;

}








/* =========================
TABLE
========================= */


table{

width:100%;

border-collapse:collapse;

}



th{

text-align:left;

padding:13px;

font-size:12px;

color:#64748b;

background:#f8fafc;

}



td{

padding:13px;

font-size:13px;

border-bottom:

1px solid #f1f5f9;

}




.pending{

color:#d97706;

font-weight:700;

}



.empty-data{

text-align:center;

color:#94a3b8;

font-size:12px;

padding:20px;

}








/* =========================
TRANSACTION
========================= */


.transaction-grid{

display:grid;

grid-template-columns:

repeat(2,1fr);

gap:25px;

}



.expense-title{

color:#dc2626;

font-size:13px;

margin-bottom:12px;

}



.income-title{

color:#16a34a;

font-size:13px;

margin-bottom:12px;

}




.transaction-item{

display:flex;

justify-content:space-between;

align-items:center;

padding:12px 0;

border-bottom:

1px solid #f1f5f9;

}



.transaction-item strong{

font-size:13px;

color:#334155;

}



.transaction-item small{

font-size:11px;

color:#94a3b8;

}



.expense-value{

color:#dc2626;

font-weight:700;

font-size:12px;

}



.income-value{

color:#16a34a;

font-weight:700;

font-size:12px;

}







/* =========================
MENU
========================= */


.quick-menu{


display:block;


padding:14px;


border-radius:14px;


background:#f8fafc;


margin-bottom:10px;


text-decoration:none;


font-size:13px;


font-weight:600;


color:#475569;


transition:.3s;


}




.quick-menu:hover{

background:#dcfce7;

color:#166534;

transform:translateX(5px);

}





.status-item{

display:flex;

align-items:center;

gap:10px;

font-size:13px;

padding:10px 0;

color:#475569;

}



.status-item span{

width:8px;

height:8px;

border-radius:50%;

background:#22c55e;

}







/* =========================
RESPONSIVE
========================= */



@media(max-width:1200px){


.finance-grid{

grid-template-columns:

repeat(2,1fr);

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

align-items:flex-start;

gap:20px;

}



.welcome-tags{

flex-wrap:wrap;

}



}


</style>
@endsection