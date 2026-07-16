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

Kelola rekening bank yang digunakan untuk transaksi keuangan perusahaan.

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





<div class="system-status">

<span></span>

Bank Active

</div>



</div>









@if(session('success'))

<div class="alert-success">

{{session('success')}}

</div>

@endif









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

font-weight:700;

letter-spacing:2px;

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

font-weight:700;

display:flex;

gap:8px;

align-items:center;


}





.system-status span{


width:9px;

height:9px;

background:#22c55e;

border-radius:50%;


}







.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:blur(15px);


border-radius:22px;


padding:22px;


border:1px solid rgba(255,255,255,.8);


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


}





.add-btn{


background:#166534;

color:white;

padding:12px 18px;

border-radius:14px;

text-decoration:none;

font-size:13px;

font-weight:600;


}





.add-btn:hover{


background:#22c55e;


}







.bank-grid{


display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;


}







.bank-card{


background:white;

border-radius:22px;

padding:22px;

box-shadow:

0 10px 30px rgba(0,0,0,.06);


}







.bank-top{


display:flex;

align-items:center;

gap:15px;


}





.bank-icon{


width:50px;

height:50px;

border-radius:16px;

background:#dcfce7;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;


}





.bank-top h3{


color:#166534;

font-size:18px;


}





.bank-top p{


font-size:12px;

color:#64748b;


}






.owner{


margin-top:15px;

font-size:13px;

color:#64748b;


}







.saldo-box{


margin-top:20px;


}





.saldo-box label{


font-size:12px;

color:#94a3b8;


}





.saldo-box h2{


font-size:22px;

color:#166534;

margin-top:5px;


}







.status{


margin-top:15px;


}





.active{


background:#dcfce7;

color:#166534;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;


}




.inactive{


background:#fee2e2;

color:#dc2626;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;


}







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





.action button:hover{


background:#fee2e2;

color:#dc2626;


}







.alert-success{


background:#dcfce7;

color:#166534;

padding:15px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

font-weight:600;


}







.empty{


text-align:center;

padding:30px;

color:#94a3b8;


}





@media(max-width:1000px){


.bank-grid{


grid-template-columns:1fr;


}



}



</style>



@endsection