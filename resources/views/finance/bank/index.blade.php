@extends('layouts.dashboard')

@section('content')


<div class="finance-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


<div>

<div class="welcome-label">
REKENING BANK
</div>


<h1>
Manajemen Rekening Perusahaan
</h1>


<p>
Kelola seluruh rekening bank perusahaan,
pantau saldo aktif dan transaksi keuangan.
</p>


<div class="welcome-tags">

<span>
✓ Multi Bank
</span>


<span>
✓ Monitoring Saldo
</span>


<span>
✓ Finance Control
</span>

</div>


</div>


</div>






{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card bank-total">


<div class="summary-icon">
🏦
</div>


<div>

<label>
Total Rekening
</label>


<h2>
{{$totalBank}}
</h2>


<small>
Rekening perusahaan
</small>


</div>


</div>







<div class="summary-card saldo-total">


<div class="summary-icon">
💰
</div>


<div>

<label>
Total Saldo
</label>


<h2>
Rp {{number_format($totalSaldo,0,',','.')}}
</h2>


<small>
Dana tersedia
</small>


</div>


</div>







<div class="summary-card aktif-total">


<div class="summary-icon">
🟢
</div>


<div>

<label>
Bank Aktif
</label>


<h2>
{{$bankAktif}}
</h2>


<small>
Rekening aktif
</small>


</div>


</div>







<div class="summary-card nonaktif-total">


<div class="summary-icon">
🔴
</div>


<div>

<label>
Bank Nonaktif
</label>


<h2>
{{$bankNonAktif}}
</h2>


<small>
Tidak digunakan
</small>


</div>


</div>



</div>









{{-- BANK LIST --}}


<div class="glass-panel">


<div class="panel-header">


<div>

<div class="panel-title">
🏦 Daftar Rekening Bank
</div>


<small>
Rekening aktif perusahaan
</small>


</div>





<a href="{{route('finance.bank.create')}}"
class="add-btn">

+ Tambah Rekening

</a>


</div>









<div class="bank-grid">



@forelse($banks as $bank)



<div class="bank-card">





<div class="bank-top">


<div class="bank-icon">
🏦
</div>


<div>


<h3>
{{$bank->nama_bank}}
</h3>


<p>
{{$bank->nomor_rekening}}
</p>


</div>


</div>







<div class="bank-info">


<div>

<span>
Pemilik
</span>


<b>
{{$bank->nama_pemilik}}
</b>


</div>





<div>

<span>
Status
</span>


<b>
{{$bank->status ? 'Aktif':'Nonaktif'}}
</b>


</div>



</div>









<div class="saldo-box">


<label>
Saldo Rekening
</label>


<h2>
Rp {{number_format($bank->saldo,0,',','.')}}
</h2>


</div>









<div class="status">


@if($bank->status)


<span class="active">
Aktif
</span>


@else


<span class="inactive">
Nonaktif
</span>


@endif


</div>








<div class="action">


<a href="{{route('finance.bank.edit',$bank->id)}}">

Edit

</a>





<form method="POST"
action="{{route('finance.bank.destroy',$bank->id)}}">


@csrf

@method('DELETE')


<button onclick="return confirm('Hapus rekening ini?')">

Hapus

</button>


</form>


</div>





</div>



@empty


<div class="empty">

Belum ada rekening bank

</div>


@endforelse



</div>


</div>



</div>









<style>


.finance-wrapper{
width:100%;
}




/* HEADER */


.welcome-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:24px;

padding:25px;

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



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:#f1f5f9;

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

color:#334155;

}






/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:25px;

}



.summary-card{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:16px;

display:flex;

align-items:center;

gap:14px;

position:relative;

overflow:hidden;

transition:.25s ease;

box-shadow:
0 10px 30px rgba(15,23,42,.05);

}



.summary-card:hover{

transform:translateY(-4px);

}




.summary-card::before{

content:"";

position:absolute;

top:0;

left:0;

height:4px;

width:100%;

background:#334155;

}



.bank-total::before{
background:#3b82f6;
}


.saldo-total::before{
background:#22c55e;
}


.aktif-total::before{
background:#16a34a;
}


.nonaktif-total::before{
background:#ef4444;
}





.summary-icon{

width:42px;

height:42px;

border-radius:14px;

background:#eff6ff;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

}



.summary-card label{

font-size:11px;

color:#64748b;

}



.summary-card h2{

margin:5px 0;

font-size:18px;

font-weight:800;

color:#172033;

}





.summary-card small{

font-size:10px;

color:#94a3b8;

}






/* PANEL */


.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:18px;

box-shadow:

0 10px 30px rgba(15,23,42,.06);

}



.panel-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.panel-title{

font-size:16px;

font-weight:800;

color:#172033;

}



.panel-header small{

font-size:11px;

color:#94a3b8;

}





.add-btn{

background:#1e293b;

color:white;

padding:10px 18px;

border-radius:14px;

font-size:12px;

font-weight:700;

text-decoration:none;

}






/* BANK CARD */


.bank-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

}



.bank-card{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:18px;

transition:.25s ease;

}



.bank-card:hover{

transform:translateY(-5px);

box-shadow:
0 15px 35px rgba(15,23,42,.12);

}





.bank-top{

display:flex;

align-items:center;

gap:14px;

}



.bank-icon{

width:42px;

height:42px;

border-radius:14px;

background:#eff6ff;

display:flex;

align-items:center;

justify-content:center;

}





.bank-top h3{

margin:0;

font-size:15px;

}



.bank-top p{

margin-top:4px;

font-size:11px;

color:#94a3b8;

}





.bank-info{

margin-top:15px;

padding:12px;

background:#f8fafc;

border-radius:14px;

}



.bank-info div{

display:flex;

justify-content:space-between;

margin-bottom:8px;

font-size:11px;

}



.bank-info div:last-child{

margin-bottom:0;

}



.bank-info span{

color:#64748b;

}



.bank-info b{

color:#172033;

}





.saldo-box{

margin-top:15px;

}



.saldo-box label{

font-size:11px;

color:#94a3b8;

}



.saldo-box h2{

margin:5px 0;

font-size:22px;

font-weight:800;

color:#16a34a;

}





.active{

background:#dcfce7;

color:#166534;

}



.inactive{

background:#fee2e2;

color:#dc2626;

}



.active,
.inactive{

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}





.action{

display:flex;

gap:10px;

margin-top:15px;

}



.action a,
.action button{

background:#f1f5f9;

border:none;

padding:7px 12px;

border-radius:12px;

font-size:10px;

cursor:pointer;

text-decoration:none;

color:#334155;

}




.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}





/* ===============================
   RESPONSIVE
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .bank-grid{
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
        padding:14px;
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

    .summary-card label{
        font-size:9px;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }

    .summary-card small{
        font-size:8px;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel-header{
        align-items:flex-start;
        gap:12px;
    }

    .panel-title{
        font-size:14px;
        line-height:1.4;
    }

    .panel-header small{
        font-size:9px;
    }

    .add-btn{
        flex-shrink:0;
        padding:9px 13px;
        font-size:10px;
        white-space:nowrap;
    }


    .bank-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .bank-card{
        min-width:0;
        padding:15px;
        border-radius:18px;
    }

    .bank-top{
        align-items:flex-start;
        gap:10px;
    }

    .bank-icon{
        width:38px;
        height:38px;
        border-radius:11px;
        flex-shrink:0;
    }

    .bank-top > div:last-child{
        min-width:0;
    }

    .bank-top h3{
        font-size:13px;
        word-break:break-word;
    }

    .bank-top p{
        font-size:9px;
        line-height:1.5;
        word-break:break-word;
    }


    .bank-info{
        padding:10px;
        border-radius:12px;
    }

    .bank-info div{
        gap:8px;
        font-size:9px;
        line-height:1.5;
    }

    .bank-info b{
        max-width:60%;
        text-align:right;
        word-break:break-word;
    }


    .saldo-box{
        margin-top:13px;
    }

    .saldo-box label{
        font-size:9px;
    }

    .saldo-box h2{
        font-size:18px;
        line-height:1.4;
        word-break:break-word;
    }


    .active,
    .inactive{
        padding:5px 9px;
        font-size:8px;
    }


    .action{
        gap:7px;
        flex-wrap:wrap;
    }

    .action a,
    .action button{
        padding:7px 10px;
        font-size:9px;
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
        border-radius:17px;
    }

    .panel-header{
        flex-direction:column;
        align-items:stretch;
        gap:12px;
    }

    .panel-title{
        font-size:13px;
    }

    .panel-header small{
        font-size:8px;
    }

    .add-btn{
        width:100%;
        box-sizing:border-box;
        text-align:center;
        padding:11px 12px;
        font-size:10px;
    }


    .bank-grid{
        grid-template-columns:1fr;
        gap:10px;
    }

    .bank-card{
        padding:13px;
        border-radius:16px;
    }

    .bank-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .bank-top{
        gap:9px;
    }

    .bank-top h3{
        font-size:11px;
    }

    .bank-top p{
        font-size:8px;
    }


    .bank-info{
        padding:9px;
        border-radius:10px;
        margin-top:12px;
    }

    .bank-info div{
        font-size:8px;
        margin-bottom:6px;
    }

    .bank-info b{
        max-width:58%;
        font-size:8px;
    }


    .saldo-box{
        margin-top:12px;
    }

    .saldo-box label{
        font-size:8px;
    }

    .saldo-box h2{
        font-size:16px;
        margin:4px 0;
    }


    .active,
    .inactive{
        padding:5px 8px;
        font-size:7px;
    }


    .action{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:7px;
        margin-top:12px;
    }

    .action a,
    .action button{
        width:100%;
        box-sizing:border-box;
        text-align:center;
        padding:8px 6px;
        font-size:8px;
    }


    .empty{
        padding:25px 12px;
        font-size:9px;
    }

}
</style>


@endsection