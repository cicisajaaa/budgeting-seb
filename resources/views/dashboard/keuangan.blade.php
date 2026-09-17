@extends('layouts.dashboard')

@section('content')

<div class="finance-wrapper">


{{-- HEADER --}}

<div class="dashboard-title">

    <span class="welcome-label">
        DASHBOARD KEUANGAN
    </span>


    <h1>
        Selamat Datang,
        <span>{{auth()->user()->name}}</span>
    </h1>


    <p>
        Kelola transaksi, saldo, approval dan laporan keuangan perusahaan.
    </p>

</div>





{{-- KPI CARDS --}}

<div class="finance-grid">


<div class="finance-card income-card">

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
            Total pemasukan
        </small>

    </div>

</div>





<div class="finance-card expense-card">

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







<div class="finance-card balance-card">

    <div class="finance-icon blue">
        🏦
    </div>


    <div>

        <label>
            Saldo Aktif
        </label>


        <h2>
            Rp {{number_format($sisaDana ?? 0,0,',','.')}}
        </h2>


        <small>
            Dana tersedia
        </small>

    </div>

</div>



<div class="finance-card balance-card">

    <div class="finance-icon blue">
        📊
    </div>

    <div>
        <label>
            Saldo Sistem
        </label>

        <h2>
            Rp {{number_format($totalSaldoSistem ?? 0,0,',','.')}}
        </h2>

        <small>
            Berdasarkan transaksi
        </small>
    </div>

</div>



<div class="finance-card approval-card">

    <div class="finance-icon orange">
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


<div class="finance-card approval-card">

    <div class="finance-icon orange">
        📄
    </div>

    <div>

        <label>
            Total Transaksi
        </label>

        <h2>
            {{$totalTransaction ?? 0}}
        </h2>

        <small>
            Aktivitas keuangan
        </small>

    </div>

</div>

</div>







{{-- MAIN GRID --}}


<div class="dashboard-grid">


<div class="finance-left">





{{-- CASH FLOW --}}

<div class="glass-panel chart-panel">

    <div class="panel-title">
        📈 Cash Flow Perusahaan
    </div>

    <div class="chart-scroll">
        <div class="chart-inner">
            <canvas id="cashFlowChart"></canvas>
        </div>
    </div>

</div>








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
{{ $totalDeposit > 0 ? round(($totalExpense/$totalDeposit)*100) : 0 }}%
</b>


</div>



<div class="progress-track">


<div class="progress-fill"

style="width:{{ $totalDeposit > 0 ? round(($totalExpense/$totalDeposit)*100) : 0 }}%">

</div>


</div>



<p class="description">

Persentase penggunaan dana perusahaan.

</p>


</div>








{{-- APPROVAL --}}


<div class="glass-panel">


<div class="panel-title">
🔔 Approval Terbaru
</div>


<div class="table-wrapper">
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


</div>





</div>





<div class="finance-right">





{{-- HEALTH --}}


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
Pemasukan dan pengeluaran
</small>


</div>


<span class="badge-success">
Stabil
</span>


</div>





<div class="health-item">


<div>

<strong>
Approval
</strong>


<small>
Menunggu keputusan
</small>


</div>


<span class="badge-warning">

{{$totalApprovalPending ?? 0}} Pending

</span>


</div>





<div class="health-item">


<div>

<strong>
Saldo
</strong>


<small>
Dana tersedia
</small>


</div>


<span class="badge-money">

Rp {{number_format($sisaDana ?? 0,0,',','.')}}
</span>


</div>



</div>







{{-- AUDIT --}}


<div class="glass-panel">


<div class="panel-title">
📌 Aktivitas Sistem
</div>



@forelse($recentAudit ?? [] as $audit)


<div class="activity-item">


<div class="activity-dot"></div>


<div>

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
Belum ada aktivitas
</div>

@endforelse



</div>





{{-- STATUS --}}


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



</div>


</div>

<style>

.finance-wrapper{
    width:100%;
    max-width:100%;
    min-width:0;
}

/* ================= HEADER ================= */

.dashboard-title{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:26px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.welcome-label{
    font-size:10px;
    letter-spacing:2px;
    font-weight:800;
    color:#64748b;
}

.dashboard-title h1{
    margin:10px 0;
    font-size:24px;
    font-weight:800;
    color:#172033;
}

.dashboard-title h1 span{
    color:#334155;
}

.dashboard-title p{
    margin:0;
    color:#64748b;
    font-size:13px;
}

/* ================= KPI ================= */

.finance-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:14px;
    margin-bottom:25px;
    min-width:0;
}

.finance-card{
    background:white;
    border:1px solid #e5e7eb;
    border-radius:24px;
    padding:16px;
    display:flex;
    align-items:center;
    gap:15px;
    position:relative;
    overflow:hidden;
    min-width:0;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
    transition:.25s ease;
}

.finance-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 40px rgba(15,23,42,.12);
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

.income-card::before{
    background:#22c55e;
}

.expense-card::before{
    background:#ef4444;
}

.balance-card::before{
    background:#3b82f6;
}

.approval-card::before{
    background:#f59e0b;
}

.finance-icon{
    width:42px;
    height:42px;
    min-width:42px;
    font-size:18px;
    border-radius:16px;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-shrink:0;
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

.finance-card > div:last-child{
    min-width:0;
    flex:1;
}

.finance-card label{
    display:block;
    color:#64748b;
    font-size:12px;
    line-height:1.3;
}

.finance-card h2{
    margin:6px 0;
    color:#172033;
    font-size:17px;
    font-weight:800;
    line-height:1.35;
    overflow-wrap:anywhere;
}

.finance-card small{
    display:block;
    color:#94a3b8;
    font-size:11px;
    line-height:1.3;
}

/* ================= MAIN GRID ================= */

.dashboard-grid{
    display:grid;
    grid-template-columns:minmax(0,2fr) minmax(280px,1fr);
    gap:15px;
    min-width:0;
}

.finance-left,
.finance-right{
    min-width:0;
}

/* ================= PANEL ================= */

.glass-panel{
    background:white;
    border:1px solid #e5e7eb;
    border-radius:24px;
    padding:18px;
    margin-bottom:20px;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
    min-width:0;
}

.panel-title{
    font-size:14px;
    font-weight:800;
    color:#172033;
    margin-bottom:20px;
}

/* ================= CHART ================= */



.chart-panel{
    position:relative;
    height:300px;
    min-height:300px;
    overflow:hidden;
}

.chart-scroll{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:thin;
}

.chart-inner{
    position:relative;
    width:100%;
    min-width:0;
    height:225px;
}

.chart-inner canvas{
    display:block;
    width:100%!important;
    height:225px!important;
}

/* ================= SUMMARY ================= */

.finance-summary{
    width:100%;
    min-width:0;
}

.finance-summary div{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;
    min-width:0;
}

.finance-summary span{
    color:#64748b;
    font-size:13px;
    min-width:0;
    overflow-wrap:anywhere;
}

.finance-summary b{
    color:#172033;
    text-align:right;
    min-width:0;
    overflow-wrap:anywhere;
}

/* ================= PROGRESS ================= */

.progress-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin-bottom:10px;
}

.progress-head span,
.progress-head b{
    min-width:0;
    overflow-wrap:anywhere;
}

.progress-head span{
    color:#64748b;
}

.progress-track{
    width:100%;
    height:12px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.progress-fill{
    height:100%;
    background:#334155;
    border-radius:20px;
    max-width:100%;
}

.description{
    margin-top:15px;
    color:#64748b;
    font-size:13px;
    line-height:1.5;
}

/* ================= TABLE ================= */

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:thin;
}

.table-wrapper table{
    width:100%;
    min-width:650px;
    border-collapse:collapse;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f8fafc;
    padding:14px;
    text-align:left;
    font-size:12px;
    color:#64748b;
    white-space:nowrap;
}

td{
    padding:14px;
    border-bottom:1px solid #e5e7eb;
    font-size:13px;
    white-space:nowrap;
}

tr:hover{
    background:#fafafa;
}

.pending{
    display:inline-block;
    background:#fef3c7;
    color:#92400e;
    padding:6px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

/* ================= HEALTH ================= */

.health-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    padding:15px 0;
    border-bottom:1px solid #f1f5f9;
    min-width:0;
}

.health-item > div{
    min-width:0;
    flex:1;
}

.health-item strong{
    display:block;
    color:#172033;
    overflow-wrap:anywhere;
}

.health-item small{
    display:block;
    margin-top:5px;
    color:#94a3b8;
    line-height:1.4;
    overflow-wrap:anywhere;
}

.health-item > span{
    flex-shrink:0;
}

.badge-success{
    background:#dcfce7;
    color:#166534;
    padding:7px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
    white-space:nowrap;
}

.badge-warning{
    background:#fef3c7;
    color:#92400e;
    padding:7px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
    white-space:nowrap;
}

.badge-money{
    color:#166534;
    font-weight:800;
    text-align:right;
    overflow-wrap:anywhere;
}

/* ================= ACTIVITY ================= */

.activity-item{
    display:flex;
    gap:12px;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;
    min-width:0;
}

.activity-dot{
    width:10px;
    height:10px;
    background:#334155;
    border-radius:50%;
    margin-top:7px;
    flex-shrink:0;
}

.activity-item > div:last-child{
    min-width:0;
    flex:1;
}

.activity-item strong{
    display:block;
    color:#172033;
    overflow-wrap:anywhere;
}

.activity-item p{
    margin:5px 0;
    color:#64748b;
    font-size:13px;
    line-height:1.5;
    overflow-wrap:anywhere;
}

.activity-item small{
    color:#94a3b8;
    line-height:1.4;
    overflow-wrap:anywhere;
}

/* ================= STATUS ================= */

.system-row{
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 0;
    color:#334155;
    font-size:13px;
    line-height:1.5;
}

.system-row span{
    width:9px;
    height:9px;
    background:#22c55e;
    border-radius:50%;
    flex-shrink:0;
}

.empty-data{
    text-align:center;
    padding:30px;
    color:#94a3b8;
}

/* ================= TABLET ================= */

@media(max-width:1200px){

    .finance-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .dashboard-grid{
        grid-template-columns:1fr;
    }

}

/* ================= MOBILE ================= */

@media(max-width:600px){

    .dashboard-title{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .dashboard-title h1{
        font-size:18px;
        line-height:1.35;
        margin:7px 0;
        overflow-wrap:anywhere;
    }

    .dashboard-title p{
        font-size:11px;
        line-height:1.5;
    }

    /* KPI 2 KOLOM */

    .finance-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:10px;
        margin-bottom:18px;
    }

    .finance-card{
        padding:13px;
        border-radius:16px;
        gap:9px;
        align-items:center;
    }

    .finance-icon{
        width:34px;
        height:34px;
        min-width:34px;
        border-radius:10px;
        font-size:14px;
    }

    .finance-card label{
        font-size:8px;
        line-height:1.3;
    }

    .finance-card h2{
        font-size:12px;
        line-height:1.35;
        margin:4px 0;
    }

    .finance-card small{
        font-size:8px;
        line-height:1.3;
    }

    /* MAIN */

    .dashboard-grid{
        grid-template-columns:1fr;
        gap:0;
    }

    .glass-panel{
        padding:15px;
        border-radius:18px;
        margin-bottom:15px;
    }

    .panel-title{
        font-size:13px;
        margin-bottom:15px;
    }

    /* CHART */

.chart-panel{
    height:270px;
    min-height:270px;
    overflow:hidden;
}

.chart-scroll{
    width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
}

.chart-inner{
    width:100%;
    min-width:600px;
    height:205px;
}

.chart-inner canvas{
    width:600px!important;
    min-width:600px!important;
    height:205px!important;
}

    /* SUMMARY */

    .finance-summary div{
        padding:11px 0;
        gap:12px;
        align-items:flex-start;
    }

    .finance-summary span{
        font-size:10px;
        line-height:1.5;
        flex:1;
    }

    .finance-summary b{
        font-size:10px;
        line-height:1.5;
        max-width:55%;
    }

    /* PROGRESS */

    .progress-head{
        font-size:10px;
        gap:10px;
    }

    .progress-track{
        height:9px;
    }

    .description{
        font-size:10px;
        line-height:1.5;
    }

    /* APPROVAL TABLE */

    .table-wrapper{
        width:100%;
        max-width:100%;
        overflow-x:auto;
        overflow-y:hidden;
        -webkit-overflow-scrolling:touch;
    }

    .table-wrapper table{
        min-width:650px;
    }

    th{
        padding:11px 9px;
        font-size:9px;
    }

    td{
        padding:11px 9px;
        font-size:10px;
    }

    .pending{
        padding:5px 9px;
        font-size:8px;
    }

    /* HEALTH */

    .health-item{
        padding:12px 0;
        gap:8px;
    }

    .health-item strong{
        font-size:10px;
    }

    .health-item small{
        font-size:8px;
        line-height:1.4;
    }

    .badge-success,
    .badge-warning{
        padding:5px 8px;
        font-size:8px;
    }

    .badge-money{
        font-size:9px;
        max-width:45%;
    }

    /* ACTIVITY */

    .activity-item{
        gap:9px;
        padding:10px 0;
    }

    .activity-dot{
        width:8px;
        height:8px;
        margin-top:5px;
    }

    .activity-item strong{
        font-size:10px;
    }

    .activity-item p{
        font-size:9px;
        line-height:1.5;
        margin:4px 0;
    }

    .activity-item small{
        font-size:8px;
        line-height:1.4;
    }

    /* STATUS */

    .system-row{
        font-size:10px;
        padding:8px 0;
    }

    .system-row span{
        width:7px;
        height:7px;
    }

    .empty-data{
        padding:20px 10px;
        font-size:10px;
    }

}

/* ================= EXTRA SMALL ================= */

@media(max-width:380px){

    .finance-grid{
        grid-template-columns:1fr;
    }

    .finance-card h2{
        font-size:13px;
    }

    .finance-card small{
        font-size:9px;
    }

    .dashboard-title h1{
        font-size:17px;
    }

    .dashboard-title p{
        font-size:10px;
    }

.chart-panel{
    height:260px;
    min-height:260px;
}

.chart-inner{
    min-width:600px;
    height:195px;
}

.chart-inner canvas{
    width:600px!important;
    min-width:600px!important;
    height:195px!important;
}

}

</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const chartElement = document.getElementById('cashFlowChart');


if(chartElement){


new Chart(chartElement, {


type:'line',


data:{


labels:@json($cashFlowChart['labels']),


datasets:[


{

label:'Dana Masuk',

data:@json($cashFlowChart['income']),


borderWidth:3,


tension:.4,


fill:true

},



{

label:'Pengeluaran',

data:@json($cashFlowChart['expense']),


borderWidth:3,


tension:.4,


fill:true

}


]


},



options:{


responsive:true,


maintainAspectRatio:false,


interaction:{


intersect:false,


mode:'index'


},



plugins:{


legend:{


position:'bottom',


labels:{


padding:20,


font:{


size:12


}


}


},



tooltip:{


callbacks:{


label:function(context){


return 'Rp ' +

new Intl.NumberFormat('id-ID')
.format(context.raw);


}


}


}


},



scales:{


y:{


ticks:{


callback:function(value){


return 'Rp ' +

new Intl.NumberFormat('id-ID')
.format(value);


}


}


}


}



}



});


}


</script>
@endsection

