<style>


:root{

--primary:#166534;
--green:#22c55e;
--green-light:#4ade80;

--glass:rgba(255,255,255,.72);

--border:rgba(255,255,255,.5);

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

#f8fafc 45%,

#dcfce7

);



overflow-x:hidden;



}






/* ===========================
BACKGROUND GLOW
=========================== */


body::before{


content:"";


position:fixed;


width:450px;


height:450px;



background:

radial-gradient(

circle,

rgba(34,197,94,.35),

transparent 70%

);



top:-150px;


right:-100px;



filter:blur(60px);



z-index:-1;



animation:

floatingGlow 10s infinite alternate;



}



body::after{


content:"";


position:fixed;


width:400px;


height:400px;



background:

radial-gradient(

circle,

rgba(22,101,52,.18),

transparent 70%

);



bottom:-150px;


left:180px;



filter:blur(70px);



z-index:-1;


}





@keyframes floatingGlow{


from{

transform:translate(0,0);

}


to{

transform:translate(-60px,40px);

}


}







/* ===========================
SIDEBAR GLASS
=========================== */


.sidebar{


position:fixed;



top:20px;


left:20px;


bottom:20px;



width:240px;



background:


rgba(255,255,255,.65);



backdrop-filter:


blur(20px);



-webkit-backdrop-filter:


blur(20px);



border:


1px solid rgba(255,255,255,.7);



border-radius:


28px;



padding:


25px 16px;



box-shadow:


0 25px 70px rgba(15,23,42,.12);



z-index:50;



overflow:hidden;


}





.sidebar::before{


content:"";


position:absolute;


top:0;


left:0;


right:0;



height:120px;



background:


linear-gradient(

135deg,

rgba(34,197,94,.15),

transparent

);



z-index:-1;


}





/* BRAND */


.brand{


display:flex;


align-items:center;


gap:12px;



padding-bottom:25px;



margin-bottom:25px;



border-bottom:


1px solid rgba(148,163,184,.2);



}





.brand img{


width:55px;


height:55px;


object-fit:contain;



padding:8px;



border-radius:18px;



background:white;



box-shadow:


0 10px 25px rgba(34,197,94,.18);



}





.brand-text{


font-size:16px;


font-weight:800;


color:#166534;



line-height:1.2;


}



.brand-text span{


display:block;


font-size:12px;



margin-top:4px;


color:#22c55e;


}





/* MENU */


.menu-title{


font-size:10px;


font-weight:700;



letter-spacing:1.3px;



color:#94a3b8;



margin:

22px 10px 12px;


}





.sidebar a{


height:44px;



display:flex;



align-items:center;



gap:12px;



padding:

0 14px;



border-radius:14px;



margin-bottom:7px;



font-size:13px;



font-weight:500;



color:#475569;



text-decoration:none;



transition:.3s;



position:relative;



}





.sidebar a:hover{


background:


rgba(34,197,94,.12);



color:#166534;



transform:


translateX(5px);


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


0 15px 35px rgba(34,197,94,.35);



}





.icon{


width:25px;


height:25px;



display:flex;


align-items:center;


justify-content:center;



border-radius:8px;



background:

rgba(255,255,255,.25);



font-size:14px;



}






/* SYSTEM STATUS */


.system-status{


position:absolute;



bottom:18px;



left:16px;



right:16px;



padding:14px;



border-radius:18px;



background:


rgba(255,255,255,.55);



border:


1px solid rgba(255,255,255,.7);



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


margin-top:8px;


font-size:12px;


font-weight:600;


color:#166534;



}



.online-dot{


width:9px;


height:9px;


border-radius:50%;


background:#22c55e;


box-shadow:


0 0 15px #22c55e;


}







/* ===========================
HEADER
=========================== */


.header{


position:fixed;



top:20px;


left:285px;


right:20px;



height:70px;



background:


rgba(255,255,255,.65);



backdrop-filter:


blur(20px);



border:


1px solid rgba(255,255,255,.7);



border-radius:


22px;



display:flex;



align-items:center;



justify-content:space-between;



padding:

0 25px;



box-shadow:


0 20px 50px rgba(15,23,42,.08);



z-index:40;



}




.system-name{


font-size:20px;


font-weight:800;


color:#166534;


}



.system-name span{


color:#22c55e;


}



.header-sub{


font-size:11px;


color:#64748b;


margin-top:3px;


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



padding:

6px 12px;



border-radius:16px;



transition:.3s;



}



.profile:hover{


background:


rgba(255,255,255,.8);


}




.avatar{


width:42px;


height:42px;



border-radius:15px;



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


font-size:13px;


display:block;


color:#166534;


}



.profile-info span{


font-size:11px;


color:#64748b;


}







.logout{


padding:

10px 18px;



border-radius:14px;



border:none;



background:


rgba(254,226,226,.8);



color:#dc2626;



font-weight:600;



cursor:pointer;



transition:.3s;



}



.logout:hover{


background:#dc2626;


color:white;


}







/* ===========================
CONTENT
=========================== */


.content{


margin-left:285px;


padding:

110px 25px 30px;



min-height:100vh;


}






.card{


background:


rgba(255,255,255,.75);



backdrop-filter:


blur(15px);



border:


1px solid rgba(255,255,255,.8);



border-radius:25px;



box-shadow:


0 20px 50px rgba(15,23,42,.08);



}





@media(max-width:900px){


.sidebar{


width:80px;


left:10px;


}



.brand-text,

.menu-title,

.system-status{


display:none;


}



.sidebar a{


justify-content:center;


}



.header{


left:110px;


}



.content{


margin-left:110px;


}



}

.notification{

position:relative;

}



.notification-btn{

width:42px;

height:42px;

border-radius:15px;

background:white;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

text-decoration:none;

position:relative;

box-shadow:0 10px 25px rgba(0,0,0,.08);

}



.badge{


position:absolute;

top:-5px;

right:-5px;


background:#dc2626;


color:white;


width:20px;

height:20px;


border-radius:50%;


font-size:11px;


display:flex;

align-items:center;

justify-content:center;


font-weight:700;


}





.notification-box{


position:absolute;


right:0;


top:55px;


width:320px;


background:white;


border-radius:18px;


padding:12px;


box-shadow:0 20px 50px rgba(0,0,0,.15);


display:none;


z-index:100;



}





.notification:hover .notification-box{


display:block;


}





.notification-item{


display:block;


padding:12px;


border-radius:12px;


text-decoration:none;


color:#334155;


margin-bottom:8px;


background:#f8fafc;


}





.notification-item:hover{


background:#dcfce7;


}



.notification-item strong{


font-size:13px;


color:#166534;


}




.notification-item p{


font-size:12px;


margin:5px 0;


}




.notification-item small{


font-size:11px;


color:#94a3b8;


}




.empty-notif{


padding:20px;


text-align:center;


font-size:12px;


color:#94a3b8;


}

</style>

<body>


<!-- ================= SIDEBAR ================= -->


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



@endif







@if(auth()->user()->role=='bendahara')



<div class="menu-title">

FINANCE

</div>





<a href="{{route('finance.deposit')}}"
class="{{request()->routeIs('finance.deposit')?'active':''}}">


<div class="icon">

💰

</div>


<span>

Pembayaran

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







<a href="{{route('expense.history')}}"
class="{{request()->routeIs('expense.history')?'active':''}}">


<div class="icon">

📄

</div>


<span>

Riwayat Pengajuan

</span>


</a>



@endif







<!-- STATUS -->


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









<!-- ================= HEADER ================= -->


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


<!-- NOTIFICATION -->

<div class="notification">


<a href="#"
class="notification-btn">

🔔


@if(auth()->user()->unreadNotifications->count() > 0)

<span class="badge">

{{auth()->user()->unreadNotifications->count()}}

</span>

@endif


</a>



<div class="notification-box">


@if(auth()->user()->unreadNotifications->count() > 0)


@foreach(auth()->user()->unreadNotifications as $notification)



<a href="{{route(
'notification.read',
$notification->id
)}}"
class="notification-item">


<strong>

{{$notification->data['title']}}

</strong>


<p>

{{$notification->data['message']}}

</p>


<small>

Klik untuk melihat

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









<!-- ================= CONTENT ================= -->


<main class="content">


@yield('content')


</main>





</body>

</html>