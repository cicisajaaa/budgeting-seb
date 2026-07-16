@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<div class="welcome-label">

EDIT REKENING BANK

</div>


<h1>

Perbarui Data Rekening

</h1>


<p>

Ubah informasi rekening bank perusahaan.

</p>



</div>





<div class="system-status">

<span></span>

Bank Update

</div>



</div>









<div class="glass-panel">


<div class="panel-title">

🏦 Form Edit Rekening

</div>






<form method="POST"
action="{{route('finance.bank.update',$bank->id)}}">


@csrf

@method('PUT')







<div class="form-grid">





<div>


<label>

Nama Bank

</label>


<input 
type="text"
name="nama_bank"
value="{{$bank->nama_bank}}"
required>


</div>








<div>


<label>

Nomor Rekening

</label>


<input 
type="text"
name="nomor_rekening"
value="{{$bank->nomor_rekening}}"
required>


</div>







<div>


<label>

Nama Pemilik

</label>


<input 
type="text"
name="nama_pemilik"
value="{{$bank->nama_pemilik}}"
required>


</div>





</div>








<div class="status-area">


<label>

Status Rekening

</label>



<select name="status">


<option value="1"
@if($bank->status)
selected
@endif
>

Aktif

</option>



<option value="0"
@if(!$bank->status)
selected
@endif
>

Nonaktif

</option>



</select>



</div>








<button class="btn-submit">

💾 Simpan Perubahan

</button>





<a href="{{route('finance.bank.index')}}"
class="btn-back">

Kembali

</a>






</form>



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


padding:25px;


border:

1px solid rgba(255,255,255,.8);


}







.panel-title{


font-size:17px;


font-weight:700;


margin-bottom:25px;


}







.form-grid{


display:grid;


grid-template-columns:repeat(3,1fr);


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


border-radius:14px;


border:1px solid #e2e8f0;


background:white;


}







.status-area{


width:33%;


margin-top:20px;


}







.btn-submit{


margin-top:25px;


padding:12px 22px;


border:none;


border-radius:14px;


background:#166534;


color:white;


font-weight:600;


cursor:pointer;


}





.btn-submit:hover{


background:#22c55e;


}







.btn-back{


display:inline-block;


margin-left:10px;


padding:12px 22px;


border-radius:14px;


background:#f1f5f9;


color:#334155;


text-decoration:none;


font-weight:600;


}






@media(max-width:900px){


.form-grid{


grid-template-columns:1fr;


}


.status-area{


width:100%;


}


}



</style>



@endsection