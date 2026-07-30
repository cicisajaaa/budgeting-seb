@extends('layouts.dashboard')

@section('content')

<div class="welcome-card">


<div>

<div class="welcome-label">
PEMBAYARAN MASUK
</div>


<h1>
Tambah Pembayaran Client
</h1>


<p>
Input pembayaran project dan sistem akan memperbarui saldo bank serta distribusi divisi.
</p>

</div>


<a href="{{route('finance.deposit')}}" class="btn-back">
← Kembali
</a>


</div>





@if(session('success'))

<div class="success-box">
{{session('success')}}
</div>

@endif




@if($errors->any())

<div class="error-box">

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
💰 Form Pembayaran Baru
</div>




<form method="POST" action="{{route('finance.deposit.store')}}">

@csrf



<div class="form-grid">



<div>

<label>
Project
</label>


<select name="proyek_id" required>

<option value="">
-- Pilih Project --
</option>


@foreach($projects as $project)

<option value="{{$project->id}}">
{{$project->nama_proyek}}
</option>


@endforeach


</select>


</div>






<div>

<label>
Rekening Bank
</label>


<select name="rekening_bank_id" required>

<option value="">
-- Pilih Bank --
</option>


@foreach($banks as $bank)

<option value="{{$bank->id}}">
{{$bank->nama_bank}} -
{{$bank->nomor_rekening}}
</option>


@endforeach


</select>


</div>






<div>

<label>
Jumlah Pembayaran
</label>


<input 
type="number"
name="jumlah_setoran"
placeholder="Masukkan nominal"
required>


</div>






<div>

<label>
Tanggal Pembayaran
</label>


<input 
type="date"
name="tanggal_setoran"
value="{{date('Y-m-d')}}"
required>


</div>




</div>




<button class="btn-submit">
+ Simpan Pembayaran
</button>



</form>


</div>






<style>


.welcome-card{

background:white;
padding:25px;
border-radius:12px;
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

color:#4b2e05;
font-size:26px;
margin:8px 0;

}



.welcome-card p{

color:#64748b;
font-size:13px;

}



.btn-back{

background:#fef3c7;
color:#92400e;
padding:10px 18px;
border-radius:8px;
text-decoration:none;
font-weight:600;

}




.glass-panel{

background:white;
padding:25px;
border-radius:12px;
border:1px solid #e2e8f0;

}



.panel-title{

font-size:17px;
font-weight:700;
margin-bottom:20px;

}



.form-grid{

display:grid;
grid-template-columns:repeat(2,1fr);
gap:20px;

}



label{

display:block;
font-size:13px;
font-weight:600;
color:#475569;
margin-bottom:8px;

}



input,
select{

width:100%;
padding:12px;
border-radius:10px;
border:1px solid #e2e8f0;
background:white;

}



.btn-submit{

margin-top:25px;
background:#6b4f1d;
color:white;
border:none;
padding:12px 25px;
border-radius:10px;
font-weight:600;
cursor:pointer;

}


.btn-submit:hover{

background:#8b6914;

}



.success-box{

background:#dcfce7;
color:#166534;
padding:12px;
border-radius:10px;
margin-bottom:15px;

}



.error-box{

background:#fee2e2;
color:#991b1b;
padding:12px;
border-radius:10px;
margin-bottom:15px;

}



@media(max-width:900px){

.form-grid{

grid-template-columns:1fr;

}

}


</style>


@endsection