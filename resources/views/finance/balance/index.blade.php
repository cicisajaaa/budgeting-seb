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
{{$balances->pluck('divisi_id')->unique()->count()}}
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




<div>

<span>
Distribusi
</span>


<b>
{{$balance->jumlah_distribusi}} transaksi
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

/* ===============================
HEADER
================================ */

.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}





/* TAG */

.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}








/* ===============================
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

    margin-bottom:25px;

}


.summary-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

}



.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}
.summary-card{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:22px;


    padding:20px;


    display:flex;


    align-items:center;


    gap:15px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.05);


}



.summary-icon{


    width:48px;


    height:48px;


    border-radius:15px;


    background:#dbeafe;


    display:flex;


    align-items:center;


    justify-content:center;


    font-size:20px;


}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{


    margin:5px 0;


    font-size:19px;


    font-weight:800;


    color:#172033;


}



.summary-card small{

    font-size:10px;

    color:#94a3b8;

}








/* ===============================
PANEL
================================ */


.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:25px;


    margin-bottom:20px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


}




.panel-header{

    margin-bottom:20px;

}



.panel-title{


    font-size:16px;


    font-weight:800;


    color:#172033;


}



.panel-header small{


    color:#94a3b8;


    font-size:11px;


}









/* ===============================
BALANCE GRID
================================ */


.balance-grid{


    display:grid;


    grid-template-columns:repeat(3,1fr);


    gap:18px;


}






.balance-card{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:22px;


    padding:22px;


    box-shadow:


    0 10px 25px rgba(15,23,42,.05);


}







.balance-header{


    display:flex;


    align-items:center;


    gap:14px;


}





.division-icon{


    width:45px;


    height:45px;


    border-radius:14px;


    background:#dbeafe;


    display:flex;


    align-items:center;


    justify-content:center;


    font-size:18px;


}






.balance-header h3{


    margin:0;


    font-size:15px;


    color:#172033;


}





.balance-header p{


    margin-top:4px;


    font-size:11px;


    color:#94a3b8;


}








/* ===============================
SALDO
================================ */


.saldo-box{


    margin-top:18px;


}



.saldo-box label{


    font-size:11px;


    color:#94a3b8;


}



.saldo-box h2{


    margin-top:5px;


    font-size:20px;


    color:#166534;


    font-weight:800;


}








/* ===============================
INFO BOX
================================ */


.info-box{


    background:#f8fafc;


    padding:14px;


    border-radius:14px;


    margin-top:15px;


}



.info-box div{


    display:flex;


    justify-content:space-between;


    font-size:11px;


    margin-bottom:8px;


}



.info-box div:last-child{

    margin-bottom:0;

}



.info-box span{

    color:#64748b;

}



.info-box b{

    color:#172033;

}









/* ===============================
STATUS
================================ */


.active{


    background:#dcfce7;


    color:#166534;


    padding:6px 12px;


    border-radius:999px;


    font-size:10px;


    font-weight:700;


    border:1px solid #bbf7d0;


}








/* ===============================
EMPTY
================================ */


.empty{


    text-align:center;


    padding:40px;


    color:#94a3b8;


}








/* ===============================
RESPONSIVE
================================ */
/* =================================
   RESPONSIVE
================================= */

@media(max-width:1200px){

    .balance-grid{
        grid-template-columns:repeat(2,1fr);
    }

}


@media(max-width:900px){

    .welcome-card{
        padding:22px;
        border-radius:20px;
    }

    .welcome-label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
        word-break:break-word;
    }

    .welcome-tags{
        flex-wrap:wrap;
        gap:7px;
    }

    .welcome-tags span{
        font-size:9px;
        padding:6px 9px;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        min-width:0;
        padding:15px;
        border-radius:18px;
        gap:10px;
    }

    .summary-icon{
        width:38px;
        height:38px;
        border-radius:11px;
        font-size:16px;
        flex-shrink:0;
    }

    .summary-card > div:last-child{
        min-width:0;
    }

    .summary-card label,
    .summary-card h2,
    .summary-card small{
        word-break:break-word;
    }

    .summary-card label{
        font-size:9px;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
    }

    .summary-card small{
        font-size:8px;
        line-height:1.4;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel-title{
        font-size:14px;
        line-height:1.4;
    }

    .panel-header small{
        font-size:9px;
    }


    .balance-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .balance-card{
        min-width:0;
        padding:16px;
        border-radius:18px;
    }

    .balance-header{
        align-items:flex-start;
        gap:10px;
    }

    .division-icon{
        width:38px;
        height:38px;
        border-radius:11px;
        font-size:16px;
        flex-shrink:0;
    }

    .balance-header > div:last-child{
        min-width:0;
    }

    .balance-header h3{
        font-size:13px;
        line-height:1.4;
        word-break:break-word;
    }

    .balance-header p{
        font-size:9px;
        line-height:1.5;
        word-break:break-word;
    }


    .saldo-box{
        margin-top:15px;
    }

    .saldo-box label{
        font-size:9px;
    }

    .saldo-box h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }


    .info-box{
        padding:12px;
        border-radius:12px;
    }

    .info-box div{
        gap:10px;
        font-size:9px;
        line-height:1.5;
    }

    .info-box b{
        min-width:0;
        max-width:65%;
        text-align:right;
        word-break:break-word;
    }


    .active{
        display:inline-flex;
        align-items:center;
        padding:5px 9px;
        font-size:8px;
    }


    .empty{
        padding:30px 15px;
        font-size:10px;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
    }

    .welcome-card p{
        font-size:10px;
        line-height:1.5;
    }

    .welcome-tags{
        gap:6px;
        margin-top:12px;
    }

    .welcome-tags span{
        font-size:8px;
        padding:5px 8px;
    }


    .summary-grid{
        grid-template-columns:1fr;
        gap:10px;
        margin-bottom:18px;
    }

    .summary-card{
        padding:12px;
        border-radius:15px;
        gap:8px;
    }

    .summary-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .summary-card label{
        font-size:8px;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0;
    }

    .summary-card small{
        font-size:7px;
    }


    .glass-panel{
        padding:15px;
        border-radius:18px;
        margin-bottom:15px;
    }

    .panel-title{
        font-size:13px;
    }

    .panel-header{
        margin-bottom:14px;
    }

    .panel-header small{
        font-size:8px;
    }


    .balance-grid{
        grid-template-columns:1fr;
        gap:10px;
    }

    .balance-card{
        padding:13px;
        border-radius:16px;
    }

    .balance-header{
        gap:9px;
    }

    .division-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .balance-header h3{
        font-size:11px;
        line-height:1.4;
    }

    .balance-header p{
        font-size:8px;
        line-height:1.4;
    }


    .saldo-box{
        margin-top:13px;
    }

    .saldo-box label{
        font-size:8px;
    }

    .saldo-box h2{
        font-size:16px;
        margin-top:4px;
    }


    .info-box{
        padding:10px;
        border-radius:11px;
        margin-top:12px;
    }

    .info-box div{
        font-size:8px;
        gap:8px;
        margin-bottom:7px;
    }

    .info-box b{
        max-width:60%;
        font-size:8px;
        line-height:1.4;
    }


    .active{
        padding:5px 8px;
        font-size:7px;
    }


    .empty{
        padding:25px 12px;
        font-size:9px;
    }

}

</style>

@endsection