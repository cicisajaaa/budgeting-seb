<!DOCTYPE html>
<html>

<head>

<title>
Project Tracker System
</title>


<style>

body{

    font-family: Arial, sans-serif;

    background:#f5f5f5;

    margin:0;

}


/* HEADER */

.header{

    background:white;

    padding:20px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:0 2px 8px rgba(0,0,0,0.1);

}



.user-info{

    font-size:14px;

}



/* BUTTON */

button{

    padding:8px 15px;

    border:none;

    border-radius:8px;

    cursor:pointer;

}



.logout{

    background:#dc3545;

    color:white;

}





/* LAYOUT */

.wrapper{

    display:flex;

}





.sidebar{

    width:220px;

    background:white;

    min-height:calc(100vh - 100px);

    padding:20px;

}



.sidebar a{

    display:block;

    text-decoration:none;

    color:#333;

    padding:12px;

    border-radius:8px;

    margin-bottom:5px;

}



.sidebar a:hover{

    background:#f0f0f0;

}





.content{

    flex:1;

    padding:25px;

}





.card{

    background:white;

    padding:20px;

    margin:10px 0;

    border-radius:10px;

    box-shadow:0 2px 5px rgba(0,0,0,0.05);

}





/* NOTIFICATION */

.notification{

    position:relative;

}



.notification a{

    text-decoration:none;

}



.badge{

    background:red;

    color:white;

    border-radius:50%;

    padding:3px 8px;

    font-size:12px;

}



.dropdown{

    position:absolute;

    right:0;

    top:40px;

    background:white;

    width:320px;

    border-radius:10px;

    box-shadow:0 3px 10px rgba(0,0,0,0.2);

    padding:10px;

    z-index:10;

}



.notif-item{

    padding:10px;

    border-bottom:1px solid #ddd;

}



.notif-item a{

    color:#0066cc;

}



</style>


</head>



<body>



<div class="header">


<div>


<h2>
Project Tracker System
</h2>


<span class="user-info">

Login sebagai:

<b>
{{ auth()->user()->name }}
</b>

|

{{ auth()->user()->role }}


</span>


</div>





<div>


{{-- NOTIFICATION --}}


<div class="notification">



@if(auth()->user()->unreadNotifications->count() > 0)


<a href="#">

🔔

<span class="badge">

{{ auth()->user()->unreadNotifications->count() }}

</span>

</a>




<div class="dropdown">


@foreach(auth()->user()->unreadNotifications as $notification)


<div class="notif-item">


<b>

{{ $notification->data['title'] }}

</b>


<br>


{{ $notification->data['message'] }}


<br><br>


<a href="{{ route('notification.read',$notification->id) }}">

Lihat Pengajuan

</a>


</div>


@endforeach


</div>



@endif



</div>






<form method="POST"
action="{{ route('logout') }}"
style="display:inline;">


@csrf


<button 
type="submit"
class="logout">

Logout

</button>


</form>



</div>



</div>








<div class="wrapper">



{{-- SIDEBAR MENU --}}


<div class="sidebar">





@if(auth()->user()->role == 'owner')

<h4>
Owner
</h4>


<a href="{{route('dashboard')}}">
Dashboard
</a>


<a href="{{route('finance.report')}}">
Laporan Keuangan
</a>



@endif







@if(auth()->user()->role == 'bendahara')

<h4>
Bendahara
</h4>


<a href="{{route('dashboard')}}">
Dashboard
</a>


<a href="{{route('finance.deposit')}}">
Input Pembayaran
</a>


<a href="{{route('finance.distribution')}}">
Distribusi Dana
</a>


<a href="{{route('finance.balance')}}">
Saldo Divisi
</a>


<a href="{{route('expense.approval')}}">
Approval Pengeluaran
</a>


<a href="{{route('finance.report')}}">
Laporan Keuangan
</a>



@endif







@if(auth()->user()->role == 'karyawan')


<h4>
Karyawan
</h4>


<a href="{{route('dashboard')}}">
Dashboard
</a>


<a href="{{route('expense.create')}}">
Pengajuan Dana
</a>


<a href="{{route('expense.history')}}">
Riwayat Pengajuan
</a>



@endif






@if(auth()->user()->role == 'admin')


<h4>
Admin
</h4>


<a href="{{route('dashboard')}}">
Dashboard
</a>


@endif




</div>







<div class="content">


@yield('content')


</div>



</div>



</body>


</html>