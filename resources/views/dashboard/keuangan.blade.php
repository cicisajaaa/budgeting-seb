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

    grid-template-columns:repeat(4,1fr);

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

