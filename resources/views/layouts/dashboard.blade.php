<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
Sahabat Eksplorasi Banua
</title>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>

:root{

--primary:#334155;
--primary-dark:#1e293b;
--gold:#64748b;
--cream:#f8fafc;
--sidebar:#0f172a;

}


*{

margin:0;
padding:0;
box-sizing:border-box;

}



body{

font-family:'Inter',sans-serif;

background:var(--background);

color:var(--text);

font-size:14px;

}



/* ================= SIDEBAR ================= */


.sidebar{

position:fixed;

top:0;

left:0;

bottom:0;

width:230px;

background:var(--sidebar);

padding:20px 15px;

z-index:1000;

}



.brand{

display:flex;

align-items:center;

gap:12px;

padding-bottom:20px;

border-bottom:1px solid rgba(255,255,255,.1);

}



.brand img{

width:42px;

height:42px;

background:white;

padding:5px;

border-radius:8px;

object-fit:contain;

}



.brand-text{

font-size:14px;

font-weight:700;

color:white;

line-height:1.3;

}



.brand-text span{

display:block;

font-size:11px;

color:#94a3b8;

}





.menu-title{

font-size:10px;

font-weight:700;

color:#94a3b8;

margin:25px 10px 10px;

letter-spacing:1px;

}





/* MENU SIDEBAR */

.sidebar a{

    display:flex;

    align-items:center;

    gap:10px;

    height:40px;

    padding:0 12px;

    margin-bottom:6px;

    border-radius:7px;

    text-decoration:none;

    color:#cbd5e1;

    font-size:13px;

    border:none;

    outline:none !important;

    box-shadow:none !important;

    transition:.2s;

    -webkit-tap-highlight-color:transparent;

}




.sidebar a:hover{

background:rgba(166,124,46,.15);

color:white;

}





/* MENU AKTIF */

.sidebar a.active{

    background:#2b2415;

    color:white;

    font-weight:600;

    border-left:4px solid #8b6b2e;

    outline:none !important;

    box-shadow:none !important;

}





/* HILANGKAN EFEK HIJAU BROWSER */

.sidebar a:focus,

.sidebar a:focus-visible,

.sidebar a:active{

    outline:none !important;

    box-shadow:none !important;

    border-color:transparent;

}





.sidebar a.active:focus,

.sidebar a.active:focus-visible{

    border-left:4px solid #8b6b2e;

}





.icon{

    width:25px;

    text-align:center;

}





.menu-badge{

    margin-left:auto;

    background:#dc2626;

    color:white;

    padding:3px 7px;

    border-radius:20px;

    font-size:10px;

}

.icon{

width:25px;

text-align:center;

}



.menu-badge{

margin-left:auto;

background:#dc2626;

color:white;

padding:3px 7px;

border-radius:20px;

font-size:10px;

}



/* STATUS */


.system-status{

position:fixed;

bottom:20px;

left:15px;

width:200px;

background:#111827;

padding:12px;

border-radius:10px;

border:1px solid rgba(255,255,255,.05);

z-index:1001;

}



.system-status-title{

font-size:10px;

color:#94a3b8;

}



.system-online{

display:flex;

align-items:center;

gap:8px;

margin-top:8px;

font-size:12px;

font-weight:600;

color:#d7b787;

}



.online-dot{

width:8px;

height:8px;

background:#22c55e;

box-shadow:0 0 8px #22c55e;

border-radius:50%;

}


</style>

</head>


<body>


<aside class="sidebar">


<div class="brand">

<img src="{{asset('images/logo-cv.png')}}">


<div class="brand-text">

Sahabat Eksplorasi Banua

<span>
Enterprise Management System
</span>

</div>


</div>


@if(auth()->user()->role!='owner')

<div class="menu-title">
MAIN
</div>


<a href="{{route('dashboard')}}"
class="{{request()->routeIs('dashboard')?'active':''}}">


<div class="icon">
⌂
</div>


Dashboard


</a>

@endif
@if(auth()->user()->role=='admin')


<div class="menu-title">
MANAGEMENT
</div>

<a href="{{route('admin.users.index')}}"
class="{{request()->routeIs('admin.users.*')?'active':''}}">

<div class="icon">
👥
</div>

Pengguna

</a>



<a href="{{route('admin.projects.index')}}"
class="{{request()->routeIs('admin.projects.*')?'active':''}}">

<div class="icon">
📁
</div>

Project

</a>


<a href="{{route('admin.divisions.index')}}"
class="{{request()->routeIs('admin.divisions.*')?'active':''}}">

<div class="icon">
🏢
</div>

Divisi

</a>


@endif
@if(auth()->user()->role=='owner')


<div class="menu-title">
PEMILIK
</div>


<a href="{{route('dashboard')}}"
class="{{request()->routeIs('dashboard')?'active':''}}">

<div class="icon">
⌂
</div>

Dashboard Utama

</a>




<a href="{{route('owner.projects')}}"
class="{{request()->routeIs('owner.projects')?'active':''}}">

<div class="icon">
📁
</div>

Pemantauan Proyek

</a>





<a href="{{route('owner.reports')}}"
class="{{request()->routeIs('owner.reports')?'active':''}}">

<div class="icon">
📊
</div>

Laporan Perusahaan

</a>





<a href="{{route('owner.approval')}}"
class="{{request()->routeIs('owner.approval')?'active':''}}">

<div class="icon">
✓
</div>

Persetujuan Dana

</a>





<a href="{{route('owner.audit')}}"
class="{{request()->routeIs('owner.audit')?'active':''}}">

<div class="icon">
📝
</div>

Riwayat Aktivitas

</a>


@endif
@if(auth()->user()->role=='keuangan')


<div class="menu-title">
FINANCE
</div>


<a href="{{route('finance.deposit')}}"
class="{{request()->routeIs('finance.deposit')?'active':''}}">

<div class="icon">
💰
</div>

Pembayaran Masuk

</a>



<a href="{{route('finance.bank.index')}}"
class="{{request()->routeIs('finance.bank.*')?'active':''}}">

<div class="icon">
🏦
</div>

Rekening Bank

</a>
<a href="{{route('finance.balance')}}"
class="{{request()->routeIs('finance.balance')?'active':''}}">

<div class="icon">
💳
</div>

Saldo Divisi

</a>



<a href="{{route('expense.approval')}}"
class="{{request()->routeIs('expense.approval')?'active':''}}">

<div class="icon">
✓
</div>

Approval Dana


@if(auth()->user()->unreadNotifications->count())

<span class="menu-badge">

{{auth()->user()->unreadNotifications->count()}}

</span>

@endif


</a>



<a href="{{route('finance.report')}}"
class="{{request()->routeIs('finance.report')?'active':''}}">

<div class="icon">
📊
</div>

Laporan

</a>

@endif
{{-- ================= KARYAWAN ================= --}}

@if(auth()->user()->role=='karyawan')


<div class="menu-title">
KARYAWAN
</div>


<a href="{{route('expense.create')}}"
class="{{request()->routeIs('expense.create')?'active':''}}">

<div class="icon">
＋
</div>

Pengajuan Dana

</a>



<a href="{{route('expense.myhistory')}}"
class="{{request()->routeIs('expense.myhistory')?'active':''}}">

<div class="icon">
📄
</div>

Riwayat Pengajuan

</a>



<a href="{{route('employee.project.index')}}"
class="{{request()->routeIs('employee.project.*')?'active':''}}">

<div class="icon">
📁
</div>

Proyek Saya

</a>



<a href="{{route('daily-tracker.index')}}"
class="{{request()->routeIs('daily-tracker.*')?'active':''}}">

<div class="icon">
📝
</div>

Aktivitas Harian

</a>


@endif





<div class="system-status">


<div class="system-status-title">

SYSTEM STATUS

</div>


<div class="system-online">

<div class="online-dot"></div>

System Online

</div>


</div>


</aside>






{{-- ================= HEADER ================= --}}



<header class="header">


<div>
<div class="system-name">
Sistem Manajemen Keuangan

</div>

<div class="header-sub">

@if(auth()->user()->role=='owner')

Dashboard

@elseif(auth()->user()->role=='keuangan')

Dashboard Keuangan

@elseif(auth()->user()->role=='admin')

Dashboard Administrator

@else

Dashboard Karyawan

@endif

</div>

</div>






<div class="profile-area">



<div class="notification">


<a href="#" class="notification-btn">

🔔

@if(auth()->user()->unreadNotifications->count())

<span class="badge">

{{auth()->user()->unreadNotifications->count()}}

</span>

@endif

</a>




<div class="notification-box">


@if(auth()->user()->unreadNotifications->count())


@foreach(auth()->user()->unreadNotifications->take(5) as $notification)


<a class="notification-item"
href="{{route('notification.read',$notification->id)}}">


<strong>

{{$notification->data['title']}}

</strong>


<p>

{{$notification->data['message']}}

</p>


</a>


@endforeach



@else


<div class="empty-notif">

Tidak ada notifikasi

</div>


@endif



</div>


</div>








<div class="profile">


<div class="avatar">

{{strtoupper(substr(auth()->user()->name,0,1))}}

</div>


<div class="profile-info">


<b>

{{auth()->user()->name}}

</b>


<span>

{{ucfirst(auth()->user()->role)}}

</span>


</div>


</div>






<form method="POST" action="{{route('logout')}}">

@csrf


<button class="logout">

Keluar

</button>


</form>



</div>


</header>









{{-- ================= CONTENT ================= --}}



<main class="content">


@if(session('success'))

<div class="alert-success">

{{session('success')}}

</div>

@endif




@if(session('error'))

<div class="alert-error">

{{session('error')}}

</div>

@endif



@yield('content')



</main>









<style>


/* HEADER */


.header{

position:fixed;

top:0;

left:230px;

right:0;

height:65px;

background:white;

border-bottom:1px solid #e2e8f0;

display:flex;

align-items:center;

justify-content:space-between;

padding:0 25px;

z-index:999;

}


.system-name{

font-size:18px;

font-weight:700;

color:#6b4f1d;

}


.system-name span{

color:#16a34a;

}



.header-sub{

font-size:11px;

color:#64748b;

}



.profile-area{

    display:flex;

    align-items:center;

    gap:18px;

    height:100%;

}



.profile{

display:flex;

align-items:center;

gap:10px;

}


.avatar{

width:38px;

height:38px;

border-radius:50%;

background:#6b4f1d;

display:flex;

align-items:center;

justify-content:center;

color:white;

font-weight:700;

}

.profile-info b{

display:block;

font-size:13px;

}



.profile-info span{

font-size:11px;

color:#64748b;


}



.profile-area form{

    margin:0;

    padding:0;

    width:auto;

    height:auto;

    background:none;

    display:flex;

    align-items:center;

}



.logout{

    border:none;

    background:#fee2e2;

    color:#dc2626;

    padding:9px 18px;

    border-radius:10px;

    font-size:13px;

    font-weight:700;

    cursor:pointer;

    width:auto;

    height:auto;

    line-height:normal;

    display:flex;

    align-items:center;

    justify-content:center;

}


.logout:hover{

    background:#fecaca;

}




/* CONTENT */
.content{

    margin-left:230px;

    width:auto;

    min-height:100vh;

    padding:90px 25px 30px;

    box-sizing:border-box;

    overflow-x:hidden;

}
html,
body{

    width:100%;

    overflow-x:hidden;

}


*{

    box-sizing:border-box;

}


/* NOTIFICATION */


.notification{

position:relative;

}



.notification-btn{

width:38px;

height:38px;

border-radius:12px;

background:#f8fafc;

display:flex;

justify-content:center;

align-items:center;

text-decoration:none;

}


.badge{

position:absolute;

right:-3px;

top:-3px;

background:#dc2626;

color:white;

width:18px;

height:18px;

font-size:10px;

display:flex;

align-items:center;

justify-content:center;

border-radius:50%;

}



.notification-box{

display:none;

position:absolute;

right:0;

top:45px;

width:300px;

background:white;

padding:10px;

box-shadow:0 10px 30px rgba(0,0,0,.15);

border-radius:8px;

}



.notification:hover .notification-box{

display:block;

}



.notification-item{

display:block;

background:#f8fafc;

padding:12px;

margin-bottom:8px;

border-radius:6px;

text-decoration:none;

color:#334155;

}



.notification-item strong{

color:#2563eb;

}



.notification-item p{

font-size:12px;

margin-top:5px;

}



.empty-notif{

text-align:center;

padding:20px;

color:#94a3b8;

}





.alert-success{

background:#dcfce7;

color:#166534;

padding:12px;

border-radius:6px;

margin-bottom:20px;

}



.alert-error{

background:#fee2e2;

color:#991b1b;

padding:12px;

border-radius:6px;

margin-bottom:20px;

}
@media(max-width:900px){

.sidebar{
    width:70px;
}


.header{
    left:70px;
}


.content{

    margin-left:70px !important;

    width:auto !important;

}

}


</style>


</body>

</html>