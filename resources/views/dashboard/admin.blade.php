@extends('layouts.dashboard')


@section('content')


{{-- ================= WELCOME ================= --}}

<div class="welcome-card">

    <div>

        <div class="welcome-label">
            DASHBOARD ADMIN
        </div>


        <h1>
            Selamat Datang, {{auth()->user()->name}}
        </h1>


        <p>
            Monitoring pengguna, proyek, pengajuan dana, dan aktivitas sistem perusahaan.
        </p>


        <div class="welcome-tags">

            <span>
                ✓ User Management
            </span>

            <span>
                ✓ Project Monitoring
            </span>

            <span>
                ✓ Financial Control
            </span>

        </div>


    </div>




    <div class="welcome-status">

        <span></span>

        Sistem Aktif

    </div>


</div>





{{-- ================= STATISTIK ================= --}}


<div class="stat-grid">



<div class="stat-card">

    <div class="stat-icon">
        👥
    </div>

    <div>

        <label>
            Total Pengguna
        </label>

        <h2>
            {{$totalUser}}
        </h2>

        <small>
            Akun terdaftar
        </small>

    </div>

</div>





<div class="stat-card">

    <div class="stat-icon">
        📁
    </div>

    <div>

        <label>
            Total Project
        </label>

        <h2>
            {{$totalProject}}
        </h2>

        <small>
            Project sistem
        </small>

    </div>

</div>





<div class="stat-card">

    <div class="stat-icon">
        🏢
    </div>

    <div>

        <label>
            Total Divisi
        </label>

        <h2>
            {{$totalDivision}}
        </h2>

        <small>
            Unit organisasi
        </small>

    </div>

</div>





<div class="stat-card">

    <div class="stat-icon">
        📝
    </div>

    <div>

        <label>
            Total Task
        </label>

        <h2>
            {{$totalTask}}
        </h2>

        <small>
            Pekerjaan sistem
        </small>

    </div>

</div>





<div class="stat-card">

    <div class="stat-icon money">
        💰
    </div>

    <div>

        <label>
            Pengajuan Dana
        </label>

        <h2>
            {{$totalExpenseRequest}}
        </h2>

        <small>
            Total pengajuan
        </small>

    </div>

</div>





<div class="stat-card">

    <div class="stat-icon pending">
        ⏳
    </div>

    <div>

        <label>
            Pending Approval
        </label>

        <h2>
            {{$totalPendingExpense}}
        </h2>

        <small>
            Menunggu finance
        </small>

    </div>

</div>



</div>




{{-- ================= CONTENT GRID ================= --}}

<div class="dashboard-grid">


{{-- ================= LEFT SIDE ================= --}}

<div>


{{-- MONITORING DANA --}}

<div class="glass-panel">


<div class="panel-title">
📊 Monitoring Pengajuan Dana
</div>



<div class="info-row">

<span>
Menunggu Approval
</span>


<b>
{{$totalPendingExpense}}
</b>

</div>




<div class="info-row">

<span>
Disetujui
</span>


<b>
{{$totalApprovedExpense}}
</b>

</div>




<div class="info-row">

<span>
Ditolak
</span>


<b>
{{$totalRejectedExpense}}
</b>

</div>



</div>







{{-- PROJECT TERBARU --}}


<div class="glass-panel">


<div class="panel-title">

📁 Project Terbaru

</div>



@forelse($recentProjects as $project)


<div class="project-row">


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








{{-- RINGKASAN SISTEM --}}


<div class="glass-panel">


<div class="panel-title">

📊 Ringkasan Sistem

</div>



<div class="system-summary">



<div class="summary-item">


<div class="summary-icon">

👥

</div>



<div>

<span>
Pengguna
</span>


<strong>
{{$totalUser}}
</strong>


<small>
Akun terdaftar
</small>


</div>



</div>






<div class="summary-item">


<div class="summary-icon blue">

📁

</div>



<div>

<span>
Project
</span>


<strong>
{{$totalProject}}
</strong>


<small>
Project perusahaan
</small>


</div>



</div>







<div class="summary-item">


<div class="summary-icon green">

📝

</div>



<div>

<span>
Task
</span>


<strong>
{{$totalTask}}
</strong>


<small>
Aktivitas pekerjaan
</small>


</div>



</div>







<div class="summary-item">


<div class="summary-icon gold">

🏢

</div>



<div>

<span>
Divisi
</span>


<strong>
{{$totalDivision}}
</strong>


<small>
Unit organisasi
</small>


</div>



</div>




</div>


</div>



</div>









{{-- ================= RIGHT SIDE ================= --}}


<div>



{{-- STATUS OPERASIONAL --}}



<div class="glass-panel">


<div class="panel-title">

📌 Status Operasional Sistem

</div>



<div class="monitor-box">





<div class="monitor-item">


<div class="monitor-icon green">

✓

</div>


<div>

<strong>

Sistem Berjalan Normal

</strong>


<p>

Seluruh layanan utama aktif

</p>


</div>


</div>






<div class="monitor-item">


<div class="monitor-icon blue">

📊

</div>


<div>

<strong>

{{$totalProject}} Project

</strong>


<p>

Project sedang dimonitor

</p>


</div>


</div>






<div class="monitor-item">


<div class="monitor-icon orange">

⏳

</div>


<div>

<strong>

{{$totalPendingExpense}} Pending

</strong>


<p>

Menunggu approval dana

</p>


</div>


</div>






<div class="monitor-item">


<div class="monitor-icon purple">

📝

</div>


<div>

<strong>

{{$totalTask}} Task

</strong>


<p>

Aktivitas pekerjaan sistem

</p>


</div>


</div>



</div>



</div>








{{-- AKTIVITAS SISTEM --}}



<div class="glass-panel">


<div class="panel-title">

📌 Aktivitas Sistem Terbaru

</div>





@forelse($recentAudit->take(5) as $audit)



<div class="activity">


<div class="activity-number">

{{$loop->iteration}}

</div>



<div class="activity-content">


<strong>

{{$audit->aksi}}

</strong>



<p>

{{$audit->deskripsi}}

</p>




<div class="activity-meta">


<span>

👤 {{$audit->pengguna->name ?? 'System'}}

</span>


<span>

🕒 {{$audit->created_at->format('d M Y H:i')}}

</span>



</div>


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

/* ===============================
GLOBAL
================================ */

.welcome-card,
.stat-card,
.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    box-shadow:
    0 10px 30px rgba(15,23,42,.06);

}


/* ===============================
WELCOME
================================ */


.welcome-card{

    padding:30px;

    border-radius:24px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    color:#172033;

    position:relative;

    overflow:hidden;

}



.welcome-card::before{

    content:none;

}



.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    font-size:28px;

    margin:10px 0;

    color:#172033;

}



.welcome-card p{

    color:#64748b;

    font-size:14px;

}



.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f8f3ea;

    color:#8b5e22;

    padding:6px 14px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}





.welcome-status{

    background:#f8fafc;

    color:#334155;

    padding:12px 18px;

    border-radius:999px;

    font-weight:700;

    display:flex;

    gap:8px;

    align-items:center;

    font-size:13px;

}



.welcome-status span{

    width:8px;

    height:8px;

    background:#22c55e;

    border-radius:50%;

}






/* ===============================
STATISTIC
================================ */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;

}




.stat-card{

    padding:20px;

    border-radius:20px;

    display:flex;

    align-items:center;

    gap:15px;

}



.stat-icon{

    width:45px;

    height:45px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:14px;

    background:#f8f3ea;

    font-size:20px;

}



.stat-icon.money{

    background:#fef3c7;

}



.stat-icon.pending{

    background:#fee2e2;

}



.stat-card label{

    font-size:12px;

    color:#64748b;

}



.stat-card h2{

    margin:5px 0;

    font-size:24px;

    color:#172033;

}



.stat-card small{

    font-size:11px;

    color:#94a3b8;

}






/* ===============================
CONTENT
================================ */


.dashboard-grid{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:20px;

}





.glass-panel{

    border-radius:24px;

    padding:25px;

    margin-bottom:20px;

}





.panel-title{

    font-size:17px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}






/* ===============================
FINANCE MONITOR
================================ */


.info-row{

    display:flex;

    justify-content:space-between;

    padding:14px 0;

    border-bottom:1px solid #e5e7eb;

}



.info-row span{

    color:#64748b;

    font-size:13px;

}



.info-row b{

    color:#8b5e22;

}





/* ===============================
PROJECT LIST
================================ */


.project-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    background:#f8fafc;

    padding:15px;

    border-radius:16px;

    margin-bottom:10px;

}



.project-row strong{

    font-size:13px;

    color:#172033;

}



.project-row p{

    margin-top:5px;

    font-size:11px;

    color:#94a3b8;

}



.project-row span{

    background:#f8f3ea;

    color:#8b5e22;

    padding:5px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

}



/* ===============================
SYSTEM MONITOR
================================ */


.monitor-box{

display:flex;

flex-direction:column;

gap:12px;

}



.monitor-item{

display:flex;

align-items:center;

gap:15px;

background:#f8fafc;

padding:15px;

border-radius:16px;

}



.monitor-icon{

width:42px;

height:42px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

font-weight:800;

}



.monitor-icon.green{

background:#dcfce7;

color:#166534;

}



.monitor-icon.blue{

background:#dbeafe;

color:#2563eb;

}



.monitor-icon.orange{

background:#fef3c7;

color:#92400e;

}



.monitor-icon.purple{

background:#ede9fe;

color:#7c3aed;

}




.monitor-item strong{

font-size:13px;

color:#172033;

display:block;

}



.monitor-item p{

margin-top:4px;

font-size:11px;

color:#64748b;

}

/* ===============================
SYSTEM SUMMARY
================================ */


.system-summary{

display:flex;

flex-direction:column;

gap:12px;

}





.summary-item{

display:flex;

align-items:center;

gap:12px;

padding:14px;

background:#f8fafc;

border-radius:16px;

border:1px solid #f1f5f9;

}





.summary-icon{

width:40px;

height:40px;

border-radius:12px;

background:#f8f3ea;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

}



.summary-icon.blue{

background:#dbeafe;

}



.summary-icon.green{

background:#dcfce7;

}



.summary-icon.gold{

background:#fef3c7;

}




.summary-item span{

display:block;

font-size:11px;

color:#64748b;

}




.summary-item strong{

display:block;

font-size:20px;

color:#172033;

line-height:1.2;

}




.summary-item small{

font-size:10px;

color:#94a3b8;

}



/* ===============================
AUDIT
================================ */


.activity{

    display:flex;

    gap:12px;

    padding:14px 0;

    border-bottom:1px solid #e5e7eb;

}

.activity{

display:flex;

gap:15px;

padding:15px 0;

border-bottom:1px solid #e5e7eb;

}



.activity-number{

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

flex-shrink:0;

}



.activity-content strong{

font-size:13px;

color:#172033;

}



.activity-content p{

margin:5px 0;

font-size:12px;

color:#64748b;

line-height:1.5;

}



.activity-meta{

display:flex;

gap:15px;

font-size:11px;

color:#94a3b8;

}

.activity-dot{

    width:9px;

    height:9px;

    background:#b8863b;

    border-radius:50%;

    margin-top:5px;

}



.activity strong{

    color:#172033;

    font-size:13px;

}



.activity p{

    color:#64748b;

    font-size:12px;

    margin:5px 0;

}



.activity small{

    color:#94a3b8;

    font-size:11px;

}





.empty{

    text-align:center;

    padding:25px;

    color:#94a3b8;

    font-size:13px;

}





/* ===============================
RESPONSIVE
================================ */


@media(max-width:1100px){


.stat-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.dashboard-grid{

    grid-template-columns:1fr;

}



.welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



}



@media(max-width:600px){


.stat-grid{

    grid-template-columns:1fr;

}


}


</style>
@endsection
