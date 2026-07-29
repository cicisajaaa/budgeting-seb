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





<div>



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
{{ $project->created_at->format('d M Y') }}
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



<div class="glass-panel">


<div class="panel-title">

⚡ Akses Cepat

</div>



<a href="{{route('admin.users.index')}}" class="quick-menu">

👥

Kelola Pengguna

</a>



<a href="{{route('admin.projects.index')}}" class="quick-menu">

📁

Kelola Project

</a>



<a href="{{route('admin.divisions.index')}}" class="quick-menu">

🏢

Kelola Divisi

</a>



<a href="{{route('admin.tasks.index')}}" class="quick-menu">

📝

Kelola Task

</a>



</div>









<div class="glass-panel">


<div class="panel-title">

📌 Aktivitas Sistem Terbaru

</div>



@forelse($recentAudit as $audit)


<div class="activity">


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


<div class="empty">
Belum ada aktivitas
</div>


@endforelse



</div>



</div>





</div>



@endsection
<style>


/* ================= WELCOME ================= */


.welcome-card{

background:linear-gradient(
135deg,
#166534,
#22c55e
);

padding:22px 25px;

border-radius:20px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:18px;

box-shadow:
0 15px 35px rgba(34,197,94,.18);

}


.welcome-label{

font-size:10px;

letter-spacing:1.5px;

opacity:.8;

font-weight:700;

}



.welcome-card h1{

font-size:22px;

margin:7px 0;

}



.welcome-card p{

font-size:12px;

opacity:.9;

}



.welcome-tags{

display:flex;

gap:8px;

margin-top:12px;

}



.welcome-tags span{

background:rgba(255,255,255,.18);

padding:5px 12px;

border-radius:20px;

font-size:10px;

}



.welcome-status{

background:white;

color:#166534;

padding:9px 15px;

border-radius:30px;

font-size:12px;

font-weight:700;

display:flex;

align-items:center;

gap:8px;

}



.welcome-status span{

width:8px;

height:8px;

background:#22c55e;

border-radius:50%;

}






/* ================= STAT CARD ================= */


.stat-grid{

display:grid;

grid-template-columns:
repeat(6,1fr);

gap:12px;

margin-bottom:18px;

}



.stat-card{

background:white;

border-radius:16px;

padding:13px;

display:flex;

align-items:center;

gap:10px;

box-shadow:
0 8px 25px rgba(15,23,42,.05);

}



.stat-icon{

width:36px;

height:36px;

display:flex;

align-items:center;

justify-content:center;

border-radius:12px;

background:#dcfce7;

font-size:16px;

}



.stat-icon.money{

background:#fef3c7;

}



.stat-icon.pending{

background:#fee2e2;

}



.stat-card label{

font-size:10px;

color:#64748b;

display:block;

}



.stat-card h2{

font-size:19px;

margin:3px 0;

color:#166534;

}



.stat-card small{

font-size:10px;

color:#94a3b8;

}






/* ================= GRID ================= */


.dashboard-grid{

display:grid;

grid-template-columns:

2fr 1fr;

gap:15px;

}






.glass-panel{

background:white;

border-radius:18px;

padding:16px;

margin-bottom:15px;

box-shadow:

0 8px 25px rgba(15,23,42,.05);

border:1px solid #f1f5f9;

}



.panel-title{

font-size:14px;

font-weight:700;

margin-bottom:14px;

color:#1e293b;

}







/* ================= INFO ================= */


.info-row{

display:flex;

justify-content:space-between;

padding:10px 0;

border-bottom:

1px solid #f1f5f9;

font-size:12px;

}



.info-row span{

color:#64748b;

}



.info-row b{

color:#166534;

}







/* ================= PROJECT ================= */


.project-row{

display:flex;

justify-content:space-between;

align-items:center;

padding:12px;

background:#f8fafc;

border-radius:12px;

margin-bottom:8px;

}



.project-row strong{

font-size:12px;

}



.project-row p{

font-size:10px;

color:#94a3b8;

margin-top:3px;

}



.project-row span{

font-size:10px;

background:#dcfce7;

color:#166534;

padding:4px 9px;

border-radius:20px;

}







/* ================= QUICK MENU ================= */


.quick-menu{

display:flex;

align-items:center;

gap:10px;

padding:11px;

background:#f8fafc;

border-radius:12px;

margin-bottom:8px;

font-size:12px;

color:#334155;

text-decoration:none;

transition:.2s;

}



.quick-menu:hover{

background:#dcfce7;

color:#166534;

}







/* ================= AUDIT ================= */


.activity{

display:flex;

gap:10px;

padding:10px 0;

border-bottom:

1px solid #f1f5f9;

}



.activity-dot{

width:8px;

height:8px;

background:#22c55e;

border-radius:50%;

margin-top:5px;

}



.activity strong{

font-size:12px;

color:#166534;

}



.activity p{

font-size:11px;

color:#475569;

margin:3px 0;

}



.activity small{

font-size:10px;

color:#94a3b8;

}





.empty{

text-align:center;

padding:20px;

font-size:12px;

color:#94a3b8;

}







/* ================= RESPONSIVE ================= */


@media(max-width:1200px){


.stat-grid{

grid-template-columns:
repeat(3,1fr);

}


}



@media(max-width:900px){


.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}



.dashboard-grid{

grid-template-columns:1fr;

}



.stat-grid{

grid-template-columns:
repeat(2,1fr);

}


}



</style>