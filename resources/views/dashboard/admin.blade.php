<style>

:root{

--primary:#166534;
--green:#22c55e;
--soft:#dcfce7;

--bg:#f8fafc;

--text:#1e293b;

--muted:#64748b;

}



*{

margin:0;
padding:0;
box-sizing:border-box;

}



body{

font-family:'Inter',sans-serif;

background:

linear-gradient(
135deg,
#ecfdf5,
#f8fafc 50%,
#dcfce7
);

color:var(--text);

}




body::before{


content:"";


position:fixed;


width:450px;


height:450px;


background:

rgba(34,197,94,.15);



border-radius:50%;



filter:blur(100px);



top:-150px;


right:-100px;



z-index:-1;


}







/* =========================
SIDEBAR
========================= */


.sidebar{


position:fixed;


top:20px;


left:20px;


bottom:20px;



width:235px;



background:

rgba(255,255,255,.65);



backdrop-filter:

blur(20px);



border:

1px solid rgba(255,255,255,.8);



border-radius:25px;



padding:22px 15px;



box-shadow:


0 20px 50px rgba(15,23,42,.1);



z-index:50;



}




.brand{


display:flex;


align-items:center;


gap:12px;



padding-bottom:20px;


border-bottom:

1px solid rgba(148,163,184,.2);



margin-bottom:20px;


}




.brand img{


width:52px;


height:52px;



padding:6px;



background:white;



border-radius:15px;



box-shadow:

0 8px 20px rgba(34,197,94,.15);



}




.brand-text{


font-size:15px;


font-weight:800;


color:#166534;


}



.brand-text span{


display:block;


font-size:11px;


color:#22c55e;


margin-top:3px;


}






.menu-title{


font-size:10px;


font-weight:700;


letter-spacing:1px;


color:#94a3b8;


margin:

20px 10px 10px;


}





.sidebar a{


height:40px;


display:flex;


align-items:center;


gap:10px;



padding:

0 12px;



border-radius:12px;



margin-bottom:5px;



font-size:13px;



font-weight:500;



text-decoration:none;



color:#475569;



transition:.3s;



}




.sidebar a:hover{


background:#f0fdf4;


color:#166534;


transform:translateX(4px);


}



.sidebar a.active{


background:

linear-gradient(
135deg,
#166534,
#22c55e
);



color:white;



font-weight:600;



box-shadow:


0 10px 25px rgba(34,197,94,.25);


}




.icon{


width:24px;


height:24px;



display:flex;


align-items:center;


justify-content:center;



background:

rgba(255,255,255,.25);



border-radius:8px;



}







.system-status{


position:absolute;


bottom:18px;


left:15px;


right:15px;



padding:12px;



border-radius:15px;



background:

rgba(255,255,255,.6);



}




.system-status-title{


font-size:10px;


color:#94a3b8;


font-weight:700;


}




.system-online{


display:flex;


align-items:center;


gap:8px;


font-size:12px;


font-weight:600;


color:#166534;


margin-top:5px;


}




.online-dot{


width:8px;


height:8px;


border-radius:50%;


background:#22c55e;


box-shadow:

0 0 12px #22c55e;


}







/* =========================
HEADER
========================= */


.header{


position:fixed;


top:20px;


left:275px;


right:20px;



height:65px;



background:

rgba(255,255,255,.7);



backdrop-filter:

blur(20px);



border:

1px solid rgba(255,255,255,.8);



border-radius:20px;



display:flex;


align-items:center;



justify-content:space-between;



padding:

0 25px;



box-shadow:


0 15px 40px rgba(15,23,42,.08);



z-index:40;



}



.system-name{


font-size:18px;


font-weight:800;


color:#166534;


}



.system-name span{


color:#22c55e;


}




.header-sub{


font-size:11px;


color:#64748b;


}






.profile-area{


display:flex;


align-items:center;


gap:15px;


}



.avatar{


width:40px;


height:40px;


border-radius:14px;



background:

linear-gradient(
135deg,
#166534,
#22c55e
);



display:flex;


align-items:center;


justify-content:center;



color:white;


font-weight:700;


}





.profile-info b{


display:block;


font-size:13px;


color:#166534;


}




.profile-info span{


font-size:11px;


color:#64748b;


}






.logout{


padding:

8px 16px;



border-radius:12px;



border:none;



background:#fee2e2;



color:#dc2626;



font-size:12px;



font-weight:600;



cursor:pointer;


}





.logout:hover{


background:#dc2626;


color:white;


}







/* =========================
CONTENT
========================= */


.content{


margin-left:275px;


padding:

100px 25px 25px;


min-height:100vh;


}




@media(max-width:900px){


.sidebar{


width:75px;


}


.brand-text,

.menu-title,

.system-status{


display:none;


}



.header{


left:110px;


}



.content{


margin-left:110px;


}


}


</style>

@extends('layouts.dashboard')


@section('content')



<!-- ================= WELCOME ================= -->


<div class="welcome-card">


<div class="welcome-content">


<div class="welcome-label">

DASHBOARD ADMIN

</div>



<h1>

Selamat Datang, {{auth()->user()->name}}

</h1>



<p>

Kelola pengguna, proyek, keuangan, dan aktivitas operasional perusahaan secara terintegrasi.

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


<div class="status-dot"></div>


Sistem Aktif


</div>




</div>









<!-- ================= STATISTIC ================= -->


<div class="stat-grid">



<div class="stat-card">


<div class="stat-icon user">

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


<div class="stat-icon project">

📁

</div>



<div>

<label>
Total Proyek
</label>


<h2>
{{$totalProject}}
</h2>


<small>
Proyek berjalan
</small>


</div>


</div>






<div class="stat-card">


<div class="stat-icon division">

🏢

</div>



<div>

<label>
Jumlah Divisi
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


<div class="stat-icon money">

Rp

</div>



<div>

<label>
Total Anggaran
</label>


<h2 class="budget">

Rp {{number_format($totalBudget ?? 0,0,',','.')}}

</h2>


<small>
Nilai proyek
</small>


</div>


</div>





</div>









<!-- ================= GRID ================= -->


<div class="dashboard-grid">





<div>



<div class="glass-panel">


<div class="panel-title">

📌 Ringkasan Sistem

</div>





<div class="info-row">


<span>

Nama Sistem

</span>


<b>

Sahabat Alam Financial System

</b>


</div>






<div class="info-row">


<span>

Pengguna Aktif

</span>


<b>

{{auth()->user()->name}}

</b>


</div>






<div class="info-row">


<span>

Hak Akses

</span>


<b>

{{ucfirst(auth()->user()->role)}}

</b>


</div>






<div class="info-row">


<span>

Status Sistem

</span>


<b class="online">

Aktif

</b>


</div>





</div>









<div class="glass-panel">


<div class="panel-title">

📊 Monitoring Proyek

</div>






<div class="project-item">


<div class="project-head">

<span>
Website Perusahaan
</span>


<b>
80%
</b>


</div>



<div class="project-bar">

<div style="width:80%"></div>

</div>



</div>








<div class="project-item">


<div class="project-head">

<span>
Renovasi Kantor
</span>


<b>
55%
</b>


</div>



<div class="project-bar">

<div style="width:55%"></div>

</div>



</div>







<div class="project-item">


<div class="project-head">

<span>
Pengembangan Sistem Tracker
</span>


<b>
70%
</b>


</div>



<div class="project-bar">

<div style="width:70%"></div>

</div>



</div>







</div>




</div>









<div>




<div class="glass-panel">


<div class="panel-title">

⚡ Akses Cepat

</div>






<a class="quick-menu">


<div>
👥
</div>


Pengelolaan Pengguna


</a>







<a class="quick-menu">


<div>
📁
</div>


Pengelolaan Proyek


</a>








<a class="quick-menu">


<div>
🏢
</div>


Pengelolaan Divisi


</a>








<a class="quick-menu">


<div>
💰
</div>


Alokasi Anggaran


</a>





</div>









<div class="glass-panel">


<div class="panel-title">

🔔 Aktivitas Terbaru

</div>






<div class="activity">


<div class="activity-dot"></div>


<div>

<b>
Pengguna Masuk
</b>


<p>
Admin mengakses sistem
</p>


</div>


</div>






<div class="activity">


<div class="activity-dot"></div>


<div>

<b>
Pembaruan Proyek
</b>


<p>
Data proyek diperbarui
</p>


</div>


</div>






<div class="activity">


<div class="activity-dot"></div>


<div>

<b>
Sistem Berjalan
</b>


<p>
Seluruh layanan tersedia
</p>


</div>


</div>






</div>




</div>







</div>









<style>


/* =========================
WELCOME
========================= */


.welcome-card{


display:flex;


justify-content:space-between;


align-items:center;



padding:20px 26px;



margin-bottom:18px;



border-radius:22px;



background:

linear-gradient(

135deg,

#166534,

#22c55e

);



color:white;



box-shadow:

0 18px 45px rgba(34,197,94,.25);



overflow:hidden;



position:relative;



}



.welcome-card::after{


content:"";


position:absolute;


width:200px;


height:200px;


right:-70px;


top:-70px;


background:

rgba(255,255,255,.12);



border-radius:50%;


}





.welcome-content{


position:relative;


z-index:2;


}



.welcome-label{


font-size:10px;


letter-spacing:1.5px;


font-weight:700;


opacity:.8;


}





.welcome-card h1{


font-size:22px;


margin:

7px 0;



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


background:

rgba(255,255,255,.18);



padding:

5px 12px;



border-radius:20px;



font-size:10px;


}





.welcome-status{


background:white;


color:#166534;



padding:

8px 15px;



border-radius:30px;


font-size:12px;


font-weight:700;



display:flex;


align-items:center;


gap:7px;


z-index:2;



}




.status-dot{


width:8px;


height:8px;


background:#22c55e;


border-radius:50%;


}








/* =========================
STAT
========================= */


.stat-grid{


display:grid;


grid-template-columns:

repeat(4,1fr);



gap:14px;


margin-bottom:18px;


}





.stat-card{


background:

rgba(255,255,255,.7);



backdrop-filter:

blur(15px);



border-radius:18px;


padding:15px;



display:flex;


align-items:center;


gap:12px;



box-shadow:

0 10px 30px rgba(15,23,42,.06);



}



.stat-icon{


width:38px;


height:38px;



display:flex;


align-items:center;


justify-content:center;


border-radius:12px;


background:#dcfce7;



font-size:17px;


}



.stat-icon.project{

background:#dbeafe;

}



.stat-icon.division{

background:#ede9fe;

}



.stat-icon.money{

background:#fef3c7;

}





.stat-card label{


font-size:11px;


color:#64748b;


}



.stat-card h2{


font-size:20px;


color:#166534;


margin:3px 0;


}



.budget{


font-size:15px!important;


}



.stat-card small{


font-size:10px;


color:#94a3b8;


}







/* =========================
PANEL
========================= */


.dashboard-grid{


display:grid;


grid-template-columns:

2fr 1fr;



gap:16px;


}




.glass-panel{


background:

rgba(255,255,255,.65);



backdrop-filter:

blur(15px);



border-radius:20px;



padding:18px;



margin-bottom:16px;



box-shadow:

0 15px 35px rgba(15,23,42,.06);



}



.panel-title{


font-size:14px;


font-weight:700;


margin-bottom:15px;


}






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



.online{


color:#16a34a;


}







/* =========================
PROJECT
========================= */


.project-item{


margin-bottom:15px;


}


.project-head{


display:flex;


justify-content:space-between;


font-size:12px;


margin-bottom:6px;


}



.project-head b{


color:#166534;


}



.project-bar{


height:6px;


background:#e2e8f0;


border-radius:20px;


overflow:hidden;


}



.project-bar div{


height:100%;


background:

linear-gradient(
90deg,
#166534,
#22c55e
);


}







/* QUICK */


.quick-menu{


display:flex;


align-items:center;


gap:10px;



padding:10px;


border-radius:12px;


background:#f8fafc;


margin-bottom:8px;


text-decoration:none;


font-size:12px;


color:#475569;


}





.quick-menu div{


width:30px;


height:30px;


background:#dcfce7;


border-radius:8px;



display:flex;


align-items:center;


justify-content:center;


}





.quick-menu:hover{


background:#dcfce7;


}






/* ACTIVITY */


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



.activity b{


font-size:12px;


}



.activity p{


font-size:11px;


color:#64748b;


}






@media(max-width:1100px){


.stat-grid{


grid-template-columns:

repeat(2,1fr);


}


.dashboard-grid{


grid-template-columns:1fr;


}


}



</style>



@endsection