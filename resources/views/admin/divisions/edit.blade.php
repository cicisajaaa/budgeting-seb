@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->


<div class="page-header">


<div>


<div class="page-label">

ORGANIZATION MANAGEMENT

</div>


<h1>

Edit Divisi

</h1>


<p>

Perbarui informasi unit organisasi perusahaan.

</p>


</div>




<a href="{{route('admin.divisions.index')}}" class="btn-back">

← Kembali

</a>



</div>







@if($errors->any())


<div class="alert-error">


<strong>

Terjadi kesalahan:

</strong>


<ul>


@foreach($errors->all() as $error)


<li>

{{$error}}

</li>


@endforeach


</ul>


</div>


@endif









<!-- FORM -->


<div class="glass-panel form-card">


<div class="panel-title">

🏢 Informasi Divisi

</div>






<form method="POST"

action="{{route('admin.divisions.update',$division->id)}}">


@csrf

@method('PUT')







<div class="form-group">


<label>

Nama Divisi

</label>



<input

type="text"

name="nama_divisi"

value="{{old('nama_divisi',$division->nama_divisi)}}"

placeholder="Masukkan nama divisi"

required>



</div>








<div class="form-action">


<button class="btn-update">

💾 Update Divisi

</button>


</div>






</form>


</div>









<style>


/* HEADER */


.page-header{


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}



.page-label{


font-size:10px;


letter-spacing:2px;


font-weight:800;


color:#94a3b8;


}



.page-header h1{


font-size:26px;


color:#166534;


margin:5px 0;


}



.page-header p{


font-size:13px;


color:#64748b;


}







.btn-back{


background:white;


border:1px solid #e5e7eb;


padding:10px 18px;


border-radius:12px;


font-size:13px;


font-weight:600;


text-decoration:none;


color:#475569;


}









/* ERROR */


.alert-error{


background:#fee2e2;


color:#991b1b;


padding:15px 18px;


border-radius:15px;


margin-bottom:18px;


font-size:13px;


}



.alert-error ul{


margin-top:8px;


padding-left:20px;


}









/* CARD */


.form-card{


max-width:700px;


}



.glass-panel{


background:

rgba(255,255,255,.65);



backdrop-filter:

blur(15px);



border-radius:22px;


padding:25px;



border:

1px solid rgba(255,255,255,.8);



box-shadow:

0 15px 35px rgba(15,23,42,.06);


}





.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:22px;


color:#111827;


}








/* FORM */


.form-group{


display:flex;


flex-direction:column;


}



.form-group label{


font-size:12px;


font-weight:600;


color:#475569;


margin-bottom:8px;


}





.form-group input{


height:48px;


border-radius:12px;


border:1px solid #e2e8f0;


background:#f8fafc;


padding:0 15px;


font-size:13px;


outline:none;


transition:.25s;


}



.form-group input:focus{


background:white;


border-color:#22c55e;


box-shadow:

0 0 0 4px rgba(34,197,94,.12);


}









/* BUTTON */


.form-action{


margin-top:25px;


display:flex;


justify-content:flex-end;


}





.btn-update{


border:none;


padding:12px 25px;


border-radius:14px;


background:

linear-gradient(

135deg,

#166534,

#22c55e

);



color:white;


font-size:13px;


font-weight:700;


cursor:pointer;


box-shadow:

0 10px 25px rgba(34,197,94,.25);


}



.btn-update:hover{


transform:

translateY(-2px);


}








@media(max-width:800px){


.page-header{


flex-direction:column;


align-items:flex-start;


gap:15px;


}


}



</style>



@endsection