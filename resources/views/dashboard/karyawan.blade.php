@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<div class="welcome-label">
DASHBOARD KARYAWAN
</div>



<h1>
Selamat Datang, {{auth()->user()->name}}
</h1>



<p>
Kelola aktivitas project dan pengajuan dana melalui sistem.
</p>



<div class="welcome-tags">


<span>
✓ Pengajuan Dana
</span>


<span>
✓ Monitoring Status
</span>


<span>
✓ Riwayat Transaksi
</span>


</div>



</div>





<div class="system-status">

<span></span>

{{date('d M Y')}}

</div>



</div>








<!-- STATISTIC -->


<div class="finance-grid">



<div class="finance-card">


<div class="finance-icon green">

📁

</div>



<div>


<label>
Project Aktif
</label>


<h2>
0
</h2>


<small>
Project yang sedang dikerjakan
</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon blue">

💰

</div>



<div>


<label>
Pengajuan Dana
</label>


<h2>
-
</h2>


<small>
Total pengajuan dana
</small>


</div>


</div>








<div class="finance-card">


<div class="finance-icon orange">

⚡

</div>



<div>


<label>
Status Akun
</label>


<h2 style="color:#16a34a">

Aktif

</h2>


<small>
Akun dapat digunakan
</small>


</div>


</div>







<div class="finance-card">


<div class="finance-icon green">

👤

</div>



<div>


<label>
Role

</label>


<h2>

Karyawan

</h2>


<small>
User Project Tracker
</small>


</div>


</div>




</div>









<div class="dashboard-grid">





<!-- MENU -->


<div class="glass-panel">


<div class="panel-title">

📌 Menu Saya

</div>




<a href="{{route('expense.create')}}"
class="quick-menu">

💰 Pengajuan Dana

</a>






<a href="{{route('expense.history')}}"
class="quick-menu">

📄 Riwayat Pengajuan

</a>






<a href="#"
class="quick-menu">

📁 Project Saya

</a>





</div>








<!-- INFORMASI -->


<div class="glass-panel">


<div class="panel-title">

👤 Informasi Akun

</div>




<div class="info-list">



<div>

<span>
Nama
</span>

<b>
{{auth()->user()->name}}
</b>

</div>





<div>

<span>
Role
</span>

<b>
{{ucfirst(auth()->user()->role)}}
</b>

</div>






<div>

<span>
Status
</span>

<b class="active">

Aktif

</b>

</div>



</div>





</div>







</div>









<style>


.welcome-card{


background:

linear-gradient(
135deg,
#166534,
#22c55e
);


padding:30px;


border-radius:24px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}



.welcome-label{


font-size:10px;


letter-spacing:2px;


font-weight:700;


opacity:.8;


}



.welcome-card h1{


font-size:28px;


margin:8px 0;


}



.welcome-card p{


font-size:13px;


opacity:.9;


}



.welcome-tags{


display:flex;


gap:10px;


margin-top:18px;


}



.welcome-tags span{


background:rgba(255,255,255,.15);


padding:7px 12px;


border-radius:20px;


font-size:11px;


}





.system-status{


background:white;


color:#166534;


padding:12px 18px;


border-radius:30px;


display:flex;


align-items:center;


gap:8px;


font-weight:700;


font-size:13px;


}



.system-status span{


width:9px;


height:9px;


background:#22c55e;


border-radius:50%;


}






.finance-grid{


display:grid;


grid-template-columns:repeat(4,1fr);


gap:18px;


margin-bottom:22px;


}





.finance-card{


background:white;


border-radius:20px;


padding:18px;


display:flex;


align-items:center;


gap:15px;


box-shadow:0 10px 30px rgba(15,23,42,.06);


}





.finance-icon{


width:45px;


height:45px;


border-radius:15px;


display:flex;


align-items:center;


justify-content:center;


font-size:20px;


}





.green{

background:#dcfce7;

}



.blue{

background:#dbeafe;

}



.orange{

background:#fef3c7;

}







.finance-card label{


font-size:12px;


color:#64748b;


}



.finance-card h2{


font-size:18px;


color:#166534;


margin-top:5px;


}



.finance-card small{


font-size:11px;


color:#94a3b8;


}







.dashboard-grid{


display:grid;


grid-template-columns:2fr 1fr;


gap:20px;


}





.glass-panel{


background:rgba(255,255,255,.65);


backdrop-filter:blur(15px);


border-radius:22px;


padding:22px;


border:1px solid rgba(255,255,255,.8);


}




.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:18px;


}





.quick-menu{


display:block;


padding:14px;


background:#f8fafc;


border-radius:14px;


margin-bottom:10px;


text-decoration:none;


color:#475569;


font-weight:600;


font-size:13px;


}



.quick-menu:hover{


background:#dcfce7;


color:#166534;


}





.info-list div{


display:flex;


justify-content:space-between;


padding:14px 0;


border-bottom:1px solid #f1f5f9;


font-size:13px;


}



.info-list span{


color:#64748b;


}



.info-list b{


color:#166534;


}



.info-list .active{


color:#16a34a;


}





@media(max-width:1100px){


.finance-grid{


grid-template-columns:repeat(2,1fr);


}



.dashboard-grid{


grid-template-columns:1fr;


}



}


</style>




@endsection