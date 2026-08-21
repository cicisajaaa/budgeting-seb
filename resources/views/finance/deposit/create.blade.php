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
{{$bank->nama_bank}} 
- 
{{$bank->nomor_rekening}}
(Rp {{number_format($bank->saldo,0,',','.')}})
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







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:11px 20px;

    border-radius:14px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.btn-back:hover{

    background:#1e293b;

    color:white;

}







/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}





.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}







/* ===============================
FORM
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}



label{

    display:block;

    margin-bottom:8px;

    font-size:12px;

    font-weight:800;

    color:#475569;

}




input,
select{


    width:100%;


    height:46px;


    padding:0 14px;


    border-radius:14px;


    border:1px solid #dbe3ef;


    background:#f8fafc;


    font-size:13px;


    color:#172033;


    outline:none;


    transition:.2s;


}



input:focus,
select:focus{


    background:white;


    border-color:#334155;


    box-shadow:

    0 0 0 3px rgba(51,65,85,.12);


}








/* ===============================
BUTTON
================================ */


.btn-submit{


    margin-top:25px;


    background:#1e293b;


    color:white;


    border:none;


    padding:13px 28px;


    border-radius:14px;


    font-size:12px;


    font-weight:800;


    cursor:pointer;


}



.btn-submit:hover{


    background:#334155;


}









/* ===============================
ALERT
================================ */


.success-box{


    background:#dcfce7;


    color:#166534;


    padding:12px 15px;


    border-radius:14px;


    margin-bottom:20px;


    font-size:13px;


}




.error-box{


    background:#fee2e2;


    color:#991b1b;


    padding:12px 15px;


    border-radius:14px;


    margin-bottom:20px;


    font-size:13px;


}





.error-box ul{


    margin:0;

    padding-left:20px;

}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.form-grid{


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