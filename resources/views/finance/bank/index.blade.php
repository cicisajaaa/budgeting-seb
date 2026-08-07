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
    <style>


.finance-wrapper{
    width:100%;
}



/* ================= WELCOME ================= */


.welcome-card{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

display:flex;

justify-content:space-between;

align-items:center;

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

margin-top:18px;

}




.welcome-tags span{

background:#fff7db;

color:#6b4f1d;

padding:7px 14px;

border-radius:20px;

font-size:11px;

font-weight:600;

}





/* ================= SUMMARY ================= */


.summary-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

margin-bottom:20px;

}



.summary-card{

background:white;

padding:20px;

border-radius:18px;

border:1px solid #e2e8f0;

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

margin-top:5px;

font-size:22px;

color:#6b4f1d;

}



.summary-card small{

color:#94a3b8;

}





/* ================= PANEL ================= */



.glass-panel{

background:white;

border-radius:18px;

padding:22px;

border:1px solid #e2e8f0;

margin-bottom:20px;

}




.panel-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.panel-title{

font-size:16px;

font-weight:700;

color:#1e293b;

}




.panel-header small{

color:#94a3b8;

font-size:12px;

}






/* ================= BUTTON ================= */


.add-btn{

background:#6b4f1d;

color:white;

padding:12px 18px;

border-radius:14px;

text-decoration:none;

font-size:13px;

font-weight:600;

}



.add-btn:hover{

background:#8b6b2e;

}







/* ================= BANK CARD ================= */


.bank-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

}




.bank-card{

background:#ffffff;

border-radius:20px;

padding:22px;

border:1px solid #f1f5f9;

box-shadow:0 10px 25px rgba(0,0,0,.05);

}





.bank-top{

display:flex;

align-items:center;

gap:15px;

}





.bank-icon{

width:52px;

height:52px;

border-radius:16px;

background:#fff7db;

display:flex;

justify-content:center;

align-items:center;

font-size:22px;

}




.bank-top h3{

font-size:18px;

color:#6b4f1d;

}



.bank-top p{

font-size:12px;

color:#64748b;

margin-top:3px;

}






.owner{

margin-top:15px;

font-size:13px;

font-weight:600;

color:#334155;

}








.bank-info{

margin-top:15px;

padding:12px;

background:#faf7ef;

border-radius:12px;

}



.bank-info div{

display:flex;

justify-content:space-between;

font-size:12px;

margin-bottom:8px;

}



.bank-info div:last-child{

margin-bottom:0;

}



.bank-info span{

color:#64748b;

}



.bank-info b{

color:#6b4f1d;

}







/* ================= SALDO ================= */


.saldo-box{

margin-top:20px;

}



.saldo-box label{

font-size:12px;

color:#94a3b8;

}



.saldo-box h2{

font-size:22px;

margin-top:5px;

color:#6b4f1d;

}







/* ================= STATUS ================= */


.status{

margin-top:15px;

}



.active{

background:#fff7db;

color:#6b4f1d;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:700;

}



.inactive{

background:#fee2e2;

color:#dc2626;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:700;

}







/* ================= ACTION ================= */


.action{

display:flex;

gap:10px;

margin-top:20px;

}



.action a,
.action button{

border:none;

padding:8px 15px;

border-radius:12px;

font-size:12px;

cursor:pointer;

text-decoration:none;

background:#f1f5f9;

color:#334155;

}




.action a:hover{

background:#fff7db;

color:#6b4f1d;

}



.action button:hover{

background:#fee2e2;

color:#dc2626;

}







/* ================= ALERT ================= */


.alert-success{

background:#fff7db;

color:#6b4f1d;

padding:15px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

font-weight:600;

}







.empty{

text-align:center;

padding:35px;

color:#94a3b8;

}







/* ================= RESPONSIVE ================= */


@media(max-width:1100px){


.bank-grid{

grid-template-columns:repeat(2,1fr);

}


}




@media(max-width:700px){


.bank-grid{

grid-template-columns:1fr;

}



.summary-grid{

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