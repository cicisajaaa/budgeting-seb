<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
CV Sahabat Alam
</title>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<style>

:root{

--primary:#166534;
--green:#22c55e;
--light:#dcfce7;
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

min-height:100vh;

color:var(--text);

background:

linear-gradient(
135deg,
#ecfdf5,
#f8fafc 50%,
#dcfce7
);

overflow-x:hidden;

font-size:14px;

}





/* ================= SIDEBAR ================= */


.sidebar{

position:fixed;

top:20px;

left:20px;

bottom:20px;

width:220px;

background:white;

border-radius:20px;

padding:18px 12px;

box-shadow:

0 20px 50px rgba(15,23,42,.1);

z-index:1000;

overflow:hidden;

}





.brand{

display:flex;

align-items:center;

gap:12px;

padding-bottom:20px;

margin-bottom:20px;

border-bottom:

1px solid #e2e8f0;

}





.brand img{

width:45px;

height:45px;

padding:8px;

background:white;

border-radius:14px;

object-fit:contain;

}





.brand-text{

font-size:16px;

font-weight:800;

color:#166534;

}





.brand-text span{

display:block;

font-size:11px;

color:#22c55e;

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

height:38px;

display:flex;

align-items:center;

gap:10px;

padding:0 12px;

border-radius:13px;

margin-bottom:6px;

text-decoration:none;

color:#475569;

font-size:12px;

transition:.2s;

}





.sidebar a:hover{

background:#dcfce7;

color:#166534;

}





.sidebar a.active{

background:

linear-gradient(
135deg,
#166534,
#22c55e
);

color:white;

font-weight:700;

}





.icon{

width:25px;

height:25px;

display:flex;

align-items:center;

justify-content:center;

border-radius:8px;

}





.menu-badge{

margin-left:auto;

background:#dc2626;

color:white;

font-size:10px;

padding:

3px 7px;

border-radius:20px;

}





.system-status{

position:absolute;

bottom:15px;

left:15px;

right:15px;

padding:13px;

border-radius:15px;

background:#f8fafc;

}





.system-status-title{

font-size:10px;

font-weight:700;

color:#94a3b8;

}





.system-online{

display:flex;

align-items:center;

gap:8px;

font-size:12px;

font-weight:700;

color:#166534;

margin-top:5px;

}





.online-dot{

width:8px;

height:8px;

background:#22c55e;

border-radius:50%;

}



</style>


</head>


<body>


<aside class="sidebar">


<div class="brand">


<img src="{{asset('images/logo-cv.png')}}">



<div class="brand-text">

Sahabat Alam

<span>
Financial Management
</span>

</div>


</div>



<div class="menu-title">

MAIN

</div>
@if(auth()->user()->role == 'admin')


<a href="{{route('admin.dashboard')}}"
class="{{request()->routeIs('admin.dashboard')?'active':''}}">

<div class="icon">
⌂
</div>

<span>
Dashboard
</span>

</a>


@else


<a href="{{route('dashboard')}}"
class="{{request()->routeIs('dashboard')?'active':''}}">

<div class="icon">
⌂
</div>

<span>
Dashboard
</span>

</a>


@endif






{{-- ================= ADMIN ================= --}}


@if(auth()->user()->role=='admin')


<div class="menu-title">
MANAGEMENT
</div>



<a href="{{route('admin.users.index')}}"
class="{{request()->routeIs('admin.users.*')?'active':''}}">

<div class="icon">
👥
</div>

<span>
Kelola Pengguna
</span>

</a>





<a href="{{route('admin.projects.index')}}"
class="{{request()->routeIs('admin.projects.*')?'active':''}}">

<div class="icon">
📁
</div>

<span>
Kelola Proyek
</span>

</a>





<a href="{{route('admin.divisions.index')}}"
class="{{request()->routeIs('admin.divisions.*')?'active':''}}">

<div class="icon">
🏢
</div>

<span>
Kelola Divisi
</span>

</a>


@endif







{{-- ================= OWNER ================= --}}


@if(auth()->user()->role=='owner')


<div class="menu-title">
REPORT
</div>




<a href="{{route('finance.report')}}"
class="{{request()->routeIs('finance.report')?'active':''}}">


<div class="icon">
📊
</div>


<span>
Laporan Keuangan
</span>


</a>





<a href="{{route('finance.balance')}}"
class="{{request()->routeIs('finance.balance')?'active':''}}">


<div class="icon">
💳
</div>


<span>
Saldo Divisi
</span>


</a>


@endif








{{-- ================= KEUANGAN ================= --}}


@if(auth()->user()->role=='keuangan')


<div class="menu-title">
FINANCE
</div>





<a href="{{route('finance.deposit')}}"
class="{{request()->routeIs('finance.deposit')?'active':''}}">


<div class="icon">
💰
</div>


<span>
Pembayaran Masuk
</span>


</a>







<a href="{{route('finance.bank.index')}}"
class="{{request()->routeIs('finance.bank.*')?'active':''}}">


<div class="icon">
🏦
</div>


<span>
Rekening Bank
</span>


</a>







<a href="{{route('finance.distribution')}}"
class="{{request()->routeIs('finance.distribution')?'active':''}}">


<div class="icon">
📤
</div>


<span>
Distribusi Dana
</span>


</a>







<a href="{{route('finance.balance')}}"
class="{{request()->routeIs('finance.balance')?'active':''}}">


<div class="icon">
💳
</div>


<span>
Saldo Divisi
</span>


</a>







<a href="{{route('expense.approval')}}"
class="{{request()->routeIs('expense.approval')?'active':''}}">


<div class="icon">
✓
</div>


<span>
Persetujuan Pengeluaran
</span>


@if(auth()->user()->unreadNotifications->count()>0)

<span class="menu-badge">

{{auth()->user()->unreadNotifications->count()}}

</span>

@endif


</a>







<a href="{{route('finance.report')}}"
class="{{request()->routeIs('finance.report')?'active':''}}">


<div class="icon">
📈
</div>


<span>
Laporan Keuangan
</span>


</a>


@endif
{{-- ================= KARYAWAN ================= --}}


@if(auth()->user()->role=='karyawan')


<div class="menu-title">
EMPLOYEE
</div>





<a href="{{route('expense.create')}}"
class="{{request()->routeIs('expense.create')?'active':''}}">


<div class="icon">
＋
</div>


<span>
Pengajuan Dana
</span>


</a>







<a href="{{route('expense.myhistory')}}"
class="{{request()->routeIs('expense.myhistory')?'active':''}}">


<div class="icon">
📄
</div>


<span>
Riwayat Pengajuan
</span>


</a>







<a href="{{route('employee.project.index')}}"
class="{{request()->routeIs('employee.project.*')?'active':''}}">


<div class="icon">
📁
</div>


<span>
Project Saya
</span>


</a>







<a href="{{route('daily-tracker.index')}}"
class="{{request()->routeIs('daily-tracker.*')?'active':''}}">


<div class="icon">
📝
</div>


<span>
Daily Tracker
</span>


</a>


@endif








{{-- SYSTEM STATUS --}}


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

CV Sahabat <span>Alam</span>

</div>




<div class="header-sub">

Financial Management System

</div>


</div>







<div class="profile-area">







{{-- NOTIFICATION --}}


<div class="notification">


<a href="#" class="notification-btn">


🔔


@if(auth()->user()->unreadNotifications->count()>0)


<span class="badge">

{{auth()->user()->unreadNotifications->count()}}

</span>


@endif


</a>







<div class="notification-box">



@if(auth()->user()->unreadNotifications->count()>0)



@foreach(auth()->user()->unreadNotifications->take(5) as $notification)



<a href="{{route('notification.read',$notification->id)}}"
class="notification-item">



<strong>

{{$notification->data['title']}}

</strong>




<p>

{{$notification->data['message']}}

</p>




<small>

Klik untuk membuka

</small>



</a>



@endforeach




@else



<div class="empty-notif">

Tidak ada notifikasi

</div>



@endif



</div>



</div>









{{-- PROFILE --}}



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


/* ================= HEADER ================= */


.header{

position:fixed;

top:20px;

left:260px;

right:20px;

height:60px;

background:white;

border-radius:20px;

display:flex;

align-items:center;

justify-content:space-between;

padding:0 20px;

box-shadow:

0 15px 40px rgba(15,23,42,.08);

z-index:999;

}




.system-name{

font-size:17px;

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





.profile{

display:flex;

align-items:center;

gap:10px;

}





.avatar{

width:36px;

height:36px;

border-radius:12px;

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

font-weight:800;

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

border:none;

padding:8px 14px;

border-radius:14px;

background:#fee2e2;

color:#dc2626;

font-weight:700;

font-size:12px;

cursor:pointer;

}







/* ================= CONTENT ================= */



.content{

margin-left:260px;

padding:

105px 20px 40px;

width:

calc(100% - 280px);

min-height:100vh;

position:relative;

z-index:1;

}







/* ================= NOTIFICATION ================= */



.notification{

position:relative;

}





.notification-btn{

width:40px;

height:40px;

border-radius:14px;

background:#f8fafc;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

text-decoration:none;

}





.badge{

position:absolute;

top:-5px;

right:-5px;

width:18px;

height:18px;

background:#dc2626;

color:white;

border-radius:50%;

font-size:10px;

display:flex;

align-items:center;

justify-content:center;

}





.notification-box{

display:none;

position:absolute;

right:0;

top:45px;

width:300px;

background:white;

padding:12px;

border-radius:18px;

box-shadow:

0 20px 50px rgba(0,0,0,.15);

}





.notification:hover .notification-box{

display:block;

}





.notification-item{

display:block;

background:#f8fafc;

padding:12px;

margin-bottom:8px;

border-radius:12px;

text-decoration:none;

color:#334155;

}





.notification-item strong{

color:#166534;

}





.notification-item p{

font-size:12px;

margin-top:5px;

}





.notification-item small{

font-size:10px;

color:#94a3b8;

}





.empty-notif{

text-align:center;

padding:20px;

color:#94a3b8;

}








/* ================= ALERT ================= */



.alert-success{

background:#dcfce7;

color:#166534;

padding:12px 15px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

}





.alert-error{

background:#fee2e2;

color:#991b1b;

padding:12px 15px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

}









/* ================= RESPONSIVE ================= */


@media(max-width:1000px){



.sidebar{

width:80px;

}



.brand-text,

.menu-title,

.system-status,

.sidebar span{

display:none;

}



.header{

left:110px;

}



.content{

margin-left:110px;

width:auto;

padding-top:100px;

}



}





</style>