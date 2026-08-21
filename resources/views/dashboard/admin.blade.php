@extends('layouts.dashboard')

@section('content')


{{-- HEADER --}}
<div class="dashboard-header">

<span class="label">
DASHBOARD ADMIN
</span>


<h1>
Dashboard Administrator
</h1>


<p>
Monitoring pengguna, project, keuangan, dan aktivitas sistem perusahaan.
</p>


</div>





{{-- KPI --}}
<div class="kpi-grid">


<div class="kpi-card">

<span>
Total Pengguna
</span>

<h2 class="blue">
{{$totalUser}}
</h2>

<small>
Akun terdaftar
</small>

</div>





<div class="kpi-card">

<span>
Total Project
</span>

<h2 class="gold">
{{$totalProject}}
</h2>

<small>
Project perusahaan
</small>

</div>





<div class="kpi-card">

<span>
Total Divisi
</span>

<h2 class="purple">
{{$totalDivision}}
</h2>

<small>
Unit organisasi
</small>

</div>





<div class="kpi-card">

<span>
Total Task
</span>

<h2 class="green">
{{$totalTask}}
</h2>

<small>
Aktivitas pekerjaan
</small>

</div>






<div class="kpi-card">

<span>
Total Budget
</span>

<h2>
Rp {{number_format($totalBudget,0,',','.')}}
</h2>

<small>
Seluruh project
</small>

</div>





<div class="kpi-card">

<span>
Realisasi Dana
</span>

<h2 class="red">
Rp {{number_format($totalRealisasi,0,',','.')}}
</h2>

<small>
Dana terpakai
</small>

</div>





<div class="kpi-card">

<span>
Sisa Budget
</span>

<h2 class="green">
Rp {{number_format($sisaBudget,0,',','.')}}
</h2>

<small>
Dana tersedia
</small>

</div>





<div class="kpi-card">

<span>
Pending Approval
</span>

<h2 class="orange">
{{$totalPendingExpense}}
</h2>

<small>
Menunggu verifikasi
</small>

</div>


</div>







{{-- GRID CONTENT --}}

<div class="dashboard-grid">



<div>



<div class="panel">


<h3>
💰 Monitoring Pengajuan Dana
</h3>



<div class="info-row">

<span>
Pending
</span>

<b>
{{$totalPendingExpense}}
</b>

</div>



<div class="info-row">

<span>
Disetujui
</span>

<b class="green-text">
{{$totalApprovedExpense}}
</b>

</div>



<div class="info-row">

<span>
Ditolak
</span>

<b class="red-text">
{{$totalRejectedExpense}}
</b>

</div>


</div>








<div class="panel">


<h3>
📁 Project Warning Budget
</h3>


@forelse($projectWarning as $project)


<div class="project-item">


<div>

<strong>
{{$project->nama_proyek}}
</strong>


<p>
{{$project->perusahaan->nama_perusahaan ?? '-'}}
</p>


</div>


<span>
{{$project->persentase_budget}}%
</span>


</div>


@empty

<div class="empty">
Semua budget project aman
</div>


@endforelse


</div>








<div class="panel">


<h3>
📁 Project Terbaru
</h3>


@forelse($recentProjects as $project)


<div class="project-item">


<div>

<strong>
{{$project->nama_proyek}}
</strong>


<p>
{{$project->created_at->format('d M Y')}}
</p>


</div>


<span>
Project
</span>


</div>


@empty

<div class="empty">
Belum ada project
</div>


@endforelse



</div>



</div>







<div>



<div class="panel">


<h3>
📌 Status Sistem
</h3>



<div class="system-item">

<div class="icon green-bg">
✓
</div>


<div>

<strong>
Sistem Aktif
</strong>

<p>
Seluruh layanan berjalan normal
</p>

</div>


</div>





<div class="system-item">

<div class="icon blue-bg">
👥
</div>


<div>

<strong>
{{$totalUser}} User
</strong>

<p>
Pengguna terdaftar
</p>

</div>


</div>





<div class="system-item">

<div class="icon orange-bg">
⏳
</div>


<div>

<strong>
{{$totalPendingExpense}} Pending
</strong>

<p>
Menunggu approval
</p>

</div>


</div>


</div>







<div class="panel">


<h3>
📝 Aktivitas Sistem Terbaru
</h3>



@forelse($recentAudit as $audit)


<div class="audit-item">


<div class="number">
{{$loop->iteration}}
</div>


<div>


<strong>
{{$audit->aksi}}
</strong>


<p>
{{$audit->deskripsi}}
</p>


<small>
{{$audit->pengguna->name ?? 'System'}}
•
{{$audit->created_at->format('d M Y H:i')}}
</small>


</div>



</div>



@empty

<div class="empty">
Belum ada aktivitas
</div>


@endforelse


</div>



</div>



</div>


<style>

/* =================================
GLOBAL
================================= */

*{
    box-sizing:border-box;
}


/* =================================
HEADER
================================= */

.dashboard-header{

    background:#f8fafc;

    padding:30px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}


.label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.dashboard-header h1{

    margin:10px 0;

    font-size:28px;

    color:#1e293b;

    font-weight:800;

}



.dashboard-header p{

    color:#64748b;

    font-size:14px;

    margin:0;

}





/* =================================
KPI
================================= */


.kpi-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;

    margin-bottom:25px;

}



.kpi-card{

    background:white;

    padding:22px;

    border-radius:18px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

}



.kpi-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.kpi-card span{

    font-size:12px;

    font-weight:700;

    color:#64748b;

}



.kpi-card h2{

    margin:10px 0;

    font-size:23px;

    font-weight:800;

    color:#1e293b;

}



.kpi-card small{

    font-size:11px;

    color:#94a3b8;

}



.blue{

    color:#2563eb!important;

}


.green{

    color:#16a34a!important;

}


.red{

    color:#dc2626!important;

}


.orange{

    color:#d97706!important;

}


.gold{

    color:#8b5e22!important;

}


.purple{

    color:#7c3aed!important;

}




/* =================================
LAYOUT
================================= */


.dashboard-grid{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:20px;

}






/* =================================
PANEL
================================= */


.panel{

    background:white;

    padding:25px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.panel h3{

    margin:0 0 20px;

    font-size:17px;

    color:#1e293b;

    font-weight:800;

}







/* =================================
INFO
================================= */


.info-row{

    display:flex;

    justify-content:space-between;

    padding:15px 0;

    border-bottom:1px solid #e2e8f0;

}



.info-row:last-child{

    border-bottom:none;

}



.info-row span{

    color:#64748b;

    font-size:13px;

}



.info-row b{

    color:#334155;

}



.green-text{

    color:#16a34a!important;

}



.red-text{

    color:#dc2626!important;

}





/* =================================
PROJECT ITEM
================================= */


.project-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    background:#f8fafc;

    padding:15px;

    border-radius:15px;

    margin-bottom:12px;

}



.project-item strong{

    font-size:13px;

    color:#1e293b;

}



.project-item p{

    margin:5px 0 0;

    font-size:11px;

    color:#94a3b8;

}



.project-item span{

    background:#fef3c7;

    color:#92400e;

    padding:6px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}





/* =================================
SYSTEM
================================= */


.system-item{

    display:flex;

    align-items:center;

    gap:15px;

    padding:15px;

    background:#f8fafc;

    border-radius:15px;

    margin-bottom:12px;

}



.icon{

    width:42px;

    height:42px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

}



.green-bg{

    background:#dcfce7;

    color:#166534;

}



.blue-bg{

    background:#dbeafe;

    color:#2563eb;

}



.orange-bg{

    background:#fef3c7;

    color:#92400e;

}



.system-item strong{

    font-size:13px;

    color:#1e293b;

}



.system-item p{

    margin:5px 0 0;

    font-size:11px;

    color:#64748b;

}





/* =================================
AUDIT
================================= */


.audit-item{

    display:flex;

    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #e2e8f0;

}



.audit-item:last-child{

    border-bottom:none;

}



.number{

    width:32px;

    height:32px;

    border-radius:50%;

    background:#f8f3ea;

    color:#8b5e22;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:12px;

    font-weight:800;

}



.audit-item strong{

    font-size:13px;

    color:#1e293b;

}



.audit-item p{

    margin:5px 0;

    font-size:12px;

    color:#64748b;

}



.audit-item small{

    font-size:11px;

    color:#94a3b8;

}





/* =================================
EMPTY
================================= */


.empty{

    text-align:center;

    padding:30px;

    color:#94a3b8;

    font-size:13px;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:1200px){


.kpi-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.dashboard-grid{

    grid-template-columns:1fr;

}



}



@media(max-width:600px){


.kpi-grid{

    grid-template-columns:1fr;

}


}

/* =================================
MATCH OWNER DASHBOARD SIZE
================================= */


/* HEADER */

.dashboard-header{

    padding:25px;

    border-radius:24px;

}



.label{

    font-size:10px;

}



.dashboard-header h1{

    font-size:24px;

    margin:8px 0;

}



.dashboard-header p{

    font-size:12px;

}



/* =================================
KPI CARD
================================= */


.kpi-grid{

    gap:15px;

}



.kpi-card{

    padding:18px;

    border-radius:22px;

}



.kpi-card span{

    font-size:11px;

}



.kpi-card h2{

    font-size:19px;

    margin:8px 0;

}



.kpi-card small{

    font-size:10px;

}





/* =================================
CONTENT PANEL
================================= */


.panel{

    padding:20px;

    border-radius:24px;

}



.panel h3{

    font-size:15px;

    margin-bottom:15px;

}





/* =================================
INFO ROW
================================= */


.info-row{

    padding:12px 0;

}



.info-row span{

    font-size:12px;

}



.info-row b{

    font-size:13px;

}





/* =================================
PROJECT WARNING
================================= */


.project-item{

    padding:12px;

    border-radius:14px;

    margin-bottom:10px;

}



.project-item strong{

    font-size:12px;

}



.project-item p{

    font-size:10px;

}



.project-item span{

    font-size:10px;

    padding:5px 10px;

}





/* =================================
SYSTEM STATUS
================================= */


.system-item{

    padding:12px;

    gap:12px;

}



.icon{

    width:38px;

    height:38px;

    font-size:14px;

}



.system-item strong{

    font-size:12px;

}



.system-item p{

    font-size:10px;

}





/* =================================
AUDIT
================================= */


.audit-item{

    gap:12px;

    padding:12px 0;

}



.number{

    width:28px;

    height:28px;

    font-size:11px;

}



.audit-item strong{

    font-size:12px;

}



.audit-item p{

    font-size:11px;

}



.audit-item small{

    font-size:10px;

}





/* =================================
EMPTY
================================= */


.empty{

    padding:25px;

    font-size:12px;

}



/* =================================
RESPONSIVE
================================= */


@media(max-width:1200px){

.kpi-grid{

    grid-template-columns:repeat(2,1fr);

}

}


@media(max-width:600px){

.kpi-grid{

    grid-template-columns:1fr;

}

}
</style>
@endsection