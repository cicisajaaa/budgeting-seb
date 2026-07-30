@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
REKENING BANK
</div>


<h1>
Tambah Rekening Perusahaan
</h1>


<p>
Tambahkan rekening bank yang digunakan untuk transaksi keuangan perusahaan.
</p>


</div>


</div>







@if($errors->any())

<div class="alert-error">

<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>

</div>

@endif







<div class="glass-panel">


<div class="panel-title">

🏦 Form Rekening Bank Baru

</div>





<form method="POST"
action="{{route('finance.bank.store')}}">


@csrf




<div class="form-grid">





<div>

<label>
Nama Bank
</label>


<input

type="text"

name="nama_bank"

placeholder="Contoh: Bank BCA"

required>


</div>








<div>

<label>
Nomor Rekening
</label>


<input

type="text"

name="nomor_rekening"

placeholder="Masukkan nomor rekening"

required>


</div>








<div>

<label>
Nama Pemilik
</label>


<input

type="text"

name="nama_pemilik"

placeholder="Nama pemilik rekening"

required>


</div>








<div>

<label>
Saldo Awal
</label>


<input

type="number"

name="saldo"

placeholder="0"

required>


</div>







<div>

<label>
Status Rekening
</label>


<select name="status" required>


<option value="1">
Aktif
</option>


<option value="0">
Nonaktif
</option>


</select>


</div>





</div>







<div class="button-area">


<a href="{{route('finance.bank.index')}}"
class="back-btn">

Kembali

</a>




<button class="save-btn">

+ Simpan Rekening

</button>


</div>





</form>



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

color:#6b4f1d;

margin:8px 0;

}



.welcome-card p{

font-size:13px;

color:#64748b;

}





.glass-panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

}






.panel-title{

font-size:17px;

font-weight:700;

color:#1e293b;

margin-bottom:20px;

}







.form-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}





label{

display:block;

font-size:12px;

font-weight:600;

color:#475569;

margin-bottom:8px;

}




input,
select{

width:100%;

padding:13px;

border-radius:12px;

border:1px solid #e2e8f0;

font-size:13px;

background:white;

}





input:focus,
select:focus{

outline:none;

border-color:#8b6b2e;

}






.button-area{

display:flex;

justify-content:flex-end;

gap:12px;

margin-top:25px;

}




.save-btn{

background:#6b4f1d;

color:white;

border:none;

padding:12px 22px;

border-radius:14px;

font-weight:600;

cursor:pointer;

}





.save-btn:hover{

background:#8b6b2e;

}





.back-btn{

background:#f1f5f9;

color:#334155;

padding:12px 22px;

border-radius:14px;

text-decoration:none;

font-size:13px;

font-weight:600;

}





.back-btn:hover{

background:#e2e8f0;

}





.alert-error{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:14px;

margin-bottom:20px;

font-size:13px;

}





@media(max-width:800px){


.form-grid{

grid-template-columns:1fr;

}


.button-area{

flex-direction:column;

}


}



</style>



@endsection