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


    <canvas id="cashFlowChart"></canvas>


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
}


/* ================= HEADER ================= */


.dashboard-title{

    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:26px;
    padding:25px;
    margin-bottom:25px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.06);

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

    grid-template-columns:repeat(3,1fr);

    gap:14px;

    margin-bottom:25px;

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


    transition:.25s ease;


    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}




.finance-card:hover{

    transform:translateY(-5px);

    box-shadow:

    0 18px 40px rgba(15,23,42,.12);

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

    font-size:18px;

    border-radius:16px;


    display:flex;

    justify-content:center;

    align-items:center;



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






.finance-card label{

    display:block;

    color:#64748b;

    font-size:12px;

}




.finance-card h2{

    margin:6px 0;

    color:#172033;

    font-size:17px;

    font-weight:800;

}



.finance-card small{

    color:#94a3b8;

}







/* ================= MAIN GRID ================= */


.dashboard-grid{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:15px;

}







/* ================= PANEL ================= */


.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:18px;


    margin-bottom:20px;


    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}





.panel-title{

    font-size:14px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}







/* ================= CHART ================= */


.chart-panel{

    min-height:280px;

}



.chart-panel canvas{

    width:100%!important;

    height:220px!important;

}








/* ================= SUMMARY ================= */



.finance-summary div{

    display:flex;

    justify-content:space-between;


    padding:14px 0;


    border-bottom:1px solid #f1f5f9;

}



.finance-summary span{

    color:#64748b;

    font-size:13px;

}



.finance-summary b{

    color:#172033;

}








/* ================= PROGRESS ================= */


.progress-head{

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;

}



.progress-head span{

    color:#64748b;

}



.progress-track{

    height:12px;

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







/* ================= TABLE ================= */


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

}



td{

    padding:14px;

    border-bottom:1px solid #e5e7eb;

    font-size:13px;

}



tr:hover{

    background:#fafafa;

}




.pending{

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


    padding:15px 0;


    border-bottom:1px solid #f1f5f9;

}




.health-item small{

    display:block;

    margin-top:5px;

    color:#94a3b8;

}




.badge-success{

    background:#dcfce7;

    color:#166534;

    padding:7px 12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.badge-warning{

    background:#fef3c7;

    color:#92400e;

    padding:7px 12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.badge-money{

    color:#166534;

    font-weight:800;

}







/* ================= ACTIVITY ================= */


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

    margin-top:7px;

}



.activity-content strong{

    color:#172033;

}



.activity-content p{

    margin:5px 0;

    color:#64748b;

    font-size:13px;

}



.activity-content small{

    color:#94a3b8;

}







/* ================= STATUS ================= */


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

    padding:30px;

    color:#94a3b8;

}







/* ================= RESPONSIVE ================= */

/* ================= RESPONSIVE ================= */

@media(max-width:1200px){

    .finance-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .dashboard-grid{
        grid-template-columns:1fr;
    }

}


@media(max-width:900px){

    .dashboard-title{
        padding:22px;
        border-radius:20px;
    }

    .dashboard-title h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .dashboard-title p{
        font-size:11px;
        line-height:1.5;
    }

    .finance-card{
        min-width:0;
        padding:15px;
        border-radius:18px;
    }

    .finance-card > div:last-child{
        min-width:0;
    }

    .finance-card label,
    .finance-card h2,
    .finance-card small{
        word-break:break-word;
    }

    .finance-icon{
        width:38px;
        height:38px;
        border-radius:13px;
        font-size:16px;
        flex-shrink:0;
    }

    .glass-panel{
        padding:18px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel-title{
        font-size:14px;
        margin-bottom:17px;
    }

    .finance-summary div{
        gap:15px;
    }

    .finance-summary span,
    .finance-summary b{
        min-width:0;
        word-break:break-word;
        line-height:1.5;
    }

    .finance-summary b{
        text-align:right;
    }

    .chart-panel{
        min-height:260px;
    }

    .chart-panel canvas{
        height:210px!important;
    }

    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    table{
        min-width:650px;
    }

    .health-item{
        gap:12px;
    }

    .health-item > div{
        min-width:0;
    }

    .health-item strong,
    .health-item small{
        word-break:break-word;
        line-height:1.5;
    }

    .health-item > span{
        flex-shrink:0;
    }

    .activity-item{
        align-items:flex-start;
    }

    .activity-item > div:last-child{
        min-width:0;
    }

    .activity-item strong,
    .activity-item p,
    .activity-item small{
        word-break:break-word;
        line-height:1.5;
    }

    .system-row{
        line-height:1.5;
    }

}


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
        font-size:19px;
        margin:7px 0;
    }

    .dashboard-title p{
        font-size:10px;
        line-height:1.5;
    }

    .finance-grid{

        grid-template-columns:1fr;

        gap:12px;

        margin-bottom:18px;

    }

    .finance-card{

        padding:15px;

        border-radius:16px;

        gap:12px;

        align-items:center;

    }


    .finance-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .finance-card label{
        font-size:8px;
        line-height:1.3;
    }

    .finance-card h2{
        font-size:14px;
        line-height:1.35;
        margin:4px 0;
    }

    .finance-card small{
        display:block;
        font-size:8px;
        line-height:1.3;
    }

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

    .chart-panel{
        min-height:235px;
    }

    .chart-panel canvas{
        height:180px!important;
    }

    .finance-summary div{
        padding:11px 0;
        gap:10px;
    }

    .finance-summary span{
        font-size:10px;
    }

    .finance-summary b{
        font-size:10px;
        text-align:right;
    }

    .progress-head{
        font-size:10px;
    }

    .progress-track{
        height:9px;
    }

    .description{
        font-size:10px;
        line-height:1.5;
    }

    .table-wrapper{
        width:100%;
        overflow-x:auto;
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

    .health-item{
        padding:12px 0;
        gap:8px;
    }

    .health-item strong{
        font-size:10px;
    }

    .health-item small{
        font-size:8px;
    }

    .badge-success,
    .badge-warning{
        padding:5px 8px;
        font-size:8px;
        flex-shrink:0;
    }

    .badge-money{
        font-size:9px;
        text-align:right;
        word-break:break-word;
    }

    .activity-item{
        gap:9px;
        padding:10px 0;
    }

    .activity-dot{
        width:8px;
        height:8px;
        margin-top:5px;
        flex-shrink:0;
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

    .system-row{
        font-size:10px;
        padding:8px 0;
    }

    .system-row span{
        width:7px;
        height:7px;
        flex-shrink:0;
    }

    .empty-data{
        padding:20px 10px;
        font-size:10px;
    }

}



@media(max-width:600px){

    .finance-card h2{

        font-size:13px;

        word-break:break-word;

    }


    .finance-card small{

        font-size:9px;

    }


    .dashboard-title h1{

        font-size:18px;

    }


    .dashboard-title p{

        font-size:11px;

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

