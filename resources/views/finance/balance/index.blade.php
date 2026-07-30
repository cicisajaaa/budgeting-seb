@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
SALDO DIVISI
</div>


<h1>
Monitoring Saldo Keuangan Divisi
</h1>


<p>
Melihat distribusi dana dan saldo yang diterima setiap divisi perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Distribusi Otomatis
</span>


<span>
✓ Monitoring Dana
</span>


<span>
✓ Finance Control
</span>


</div>


</div>


</div>







{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">


<div class="summary-icon">
💰
</div>


<div>


<label>
Total Saldo Divisi
</label>


<h2>
Rp {{number_format($balances->sum('saldo'),0,',','.')}}
</h2>


<small>
Dana seluruh divisi
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
🏢
</div>


<div>


<label>
Jumlah Divisi
</label>


<h2>
{{$balances->count()}}
</h2>


<small>
Divisi menerima dana
</small>


</div>


</div>


</div>









<div class="glass-panel">


<div class="panel-header">


<div>


<div class="panel-title">

🏢 Detail Saldo Divisi

</div>


<small>

Distribusi dana project

</small>


</div>


</div>









<div class="balance-grid">



@forelse($balances as $balance)



<div class="balance-card">





<div class="balance-header">


<div class="division-icon">
🏢
</div>


<div>


<h3>

{{$balance->divisi->nama_divisi ?? '-'}}

</h3>


<p>

{{$balance->proyek->nama_proyek ?? '-'}}

</p>


</div>


</div>







<div class="saldo-box">


<label>
Saldo Diterima
</label>


<h2>

Rp {{number_format($balance->saldo,0,',','.')}}

</h2>


</div>







<div class="info-box">


<div>

<span>
Project
</span>


<b>
{{$balance->proyek->nama_proyek ?? '-'}}
</b>


</div>





<div>

<span>
Divisi
</span>


<b>
{{$balance->divisi->nama_divisi ?? '-'}}
</b>


</div>



</div>





<br>

<div class="status">

<span class="active">

● Aktif

</span>
</div>






</div>



@empty


<div class="empty">

Belum ada saldo divisi

</div>



@endforelse



</div>



</div>









<style>


.welcome-card{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:20px;

}



.welcome-label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#64748b;

}



.welcome-card h1{

font-size:28px;

margin:8px 0;

color:#6b4f1d;

}



.welcome-card p{

font-size:13px;

color:#64748b;

}





.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:#fff7db;

color:#6b4f1d;

padding:7px 14px;

border-radius:20px;

font-size:11px;

font-weight:600;

}







.summary-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

margin-bottom:20px;

}



.summary-card{

background:white;

border:1px solid #e2e8f0;

padding:20px;

border-radius:18px;

display:flex;

align-items:center;

gap:15px;

}



.summary-icon{

width:50px;

height:50px;

border-radius:15px;

background:#fff7db;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

}




.summary-card label{

font-size:12px;

color:#64748b;

}



.summary-card h2{

color:#6b4f1d;

margin-top:5px;

}







.glass-panel{

background:white;

padding:22px;

border-radius:18px;

border:1px solid #e2e8f0;

}





.panel-header{

margin-bottom:20px;

}



.panel-title{

font-size:16px;

font-weight:700;

color:#1e293b;

}







.balance-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

}







.balance-card{

background:white;

padding:22px;

border-radius:20px;

border:1px solid #f1f5f9;

box-shadow:0 10px 25px rgba(0,0,0,.05);

}







.balance-header{

display:flex;

gap:15px;

align-items:center;

}





.division-icon{

width:50px;

height:50px;

background:#fff7db;

border-radius:15px;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

}



.balance-header h3{

font-size:17px;

color:#6b4f1d;

}



.balance-header p{

font-size:12px;

color:#64748b;

margin-top:5px;

}







.saldo-box{

margin-top:20px;

}



.saldo-box label{

font-size:12px;

color:#94a3b8;

}



.saldo-box h2{

color:#6b4f1d;

font-size:22px;

margin-top:5px;

}







.info-box{

background:#faf7ef;

padding:12px;

border-radius:12px;

margin-top:15px;

}



.info-box div{

display:flex;

justify-content:space-between;

font-size:12px;

margin-bottom:8px;

}



.info-box div:last-child{

margin-bottom:0;

}



.info-box span{

color:#64748b;

}



.info-box b{

color:#6b4f1d;

}






.active{

background:#dcfce7;

color:#166534;

padding:6px 14px;

border-radius:20px;

font-size:12px;

font-weight:700;

display:inline-flex;

align-items:center;

gap:6px;

border:1px solid #bbf7d0;

}





.empty{

text-align:center;

padding:35px;

color:#94a3b8;

}







@media(max-width:1000px){


.balance-grid{

grid-template-columns:1fr;

}



.summary-grid{

grid-template-columns:1fr;

}


}



</style>



@endsection