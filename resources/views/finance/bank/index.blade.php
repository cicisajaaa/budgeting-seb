@extends('layouts.dashboard')

@section('content')


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


<div class="summary-card">


<div class="summary-icon">
🏦
</div>


<div>

<label>
Total Rekening
</label>


<h2>
{{count($banks)}}
</h2>


<small>
Rekening perusahaan
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
💰
</div>


<div>

<label>
Total Saldo Bank
</label>


<h2>
Rp {{number_format($banks->sum('saldo'),0,',','.')}}
</h2>


<small>
Dana tersedia perusahaan
</small>


</div>


</div>



</div>








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







<div class="owner">

{{$bank->nama_pemilik}}

</div>







<div class="bank-info">


<div>

<span>
Nomor Rekening
</span>


<b>
{{$bank->nomor_rekening}}
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




<style>

/* ===============================
GLOBAL
================================ */

.finance-wrapper{
    width:100%;
}



/* ===============================
HEADER
================================ */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

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

    padding:22px;

    display:flex;

    align-items:center;

    gap:18px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.05);

    position:relative;

    overflow:hidden;

    min-height:105px;

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



.summary-icon{

    width:52px;

    height:52px;

    border-radius:16px;

    background:#dbeafe;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:22px;

    flex-shrink:0;

}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:5px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}



.summary-card small{

    font-size:11px;

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







/* ===============================
BUTTON
================================ */


.add-btn{

    background:#1e293b;

    color:white;

    padding:12px 20px;

    border-radius:14px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}



.add-btn:hover{

    background:#334155;

}







/* ===============================
BANK CARD
================================ */


.bank-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

}




.bank-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}




.bank-top{

    display:flex;

    align-items:center;

    gap:14px;

}



.bank-icon{

    width:45px;

    height:45px;

    border-radius:14px;

    background:#dbeafe;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.bank-top h3{

    margin:0;

    font-size:15px;

    color:#172033;

}



.bank-top p{

    margin-top:4px;

    font-size:11px;

    color:#94a3b8;

}





.owner{

    margin-top:15px;

    font-size:12px;

    font-weight:700;

    color:#475569;

}







.bank-info{

    margin-top:15px;

    padding:14px;

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

    margin:5px 0;

    font-size:20px;

    color:#166534;

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

}



.inactive{

    background:#fee2e2;

    color:#dc2626;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}








/* ===============================
ACTION
================================ */


.action{

    display:flex;

    gap:10px;

    margin-top:18px;

}



.action a,
.action button{


    background:#f1f5f9;

    border:none;

    padding:8px 14px;

    border-radius:12px;

    font-size:11px;

    color:#334155;

    text-decoration:none;

    cursor:pointer;

}



.action a:hover{

    background:#dbeafe;

    color:#2563eb;

}



.action button:hover{

    background:#fee2e2;

    color:#dc2626;

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



@media(max-width:800px){


.summary-grid,
.bank-grid{

    grid-template-columns:1fr;

}



.welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}

</style>

@endsection