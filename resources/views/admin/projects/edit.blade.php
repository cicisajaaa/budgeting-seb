@extends('layouts.dashboard')

@section('content')


<div class="page-wrapper">


{{-- ================= HEADER ================= --}}

<div class="page-header">


<div>

<div class="page-label">
PROJECT MANAGEMENT
</div>


<h1>
Edit Project
</h1>


<p>
Perbarui informasi project, anggaran, dan periode pelaksanaan.
</p>


</div>



<a href="{{route('admin.projects.index')}}" class="btn-back">
← Kembali
</a>


</div>





{{-- ================= ERROR ================= --}}


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







{{-- ================= FORM ================= --}}


<div class="form-card">


<div class="card-title">

📁 Informasi Project

</div>





<form method="POST"
action="{{route('admin.projects.update',$project->id)}}">


@csrf

@method('PUT')





<div class="form-grid">





{{-- NAMA PROJECT --}}

<div class="form-group">

<label>
Nama Project
</label>


<input

type="text"

name="nama_proyek"

value="{{old('nama_proyek',$project->nama_proyek)}}"

required

>


</div>







{{-- OWNER --}}


<div class="form-group">


<label>
Project Owner
</label>


<input

type="text"

name="pemilik_proyek"

value="{{old('pemilik_proyek',$project->pemilik_proyek)}}"

required

>


</div>









{{-- ANGGARAN --}}


<div class="form-group">


<label>
Total Anggaran
</label>


<div class="money-input">


<span>
Rp
</span>


<input

type="number"

name="total_anggaran"

value="{{old('total_anggaran',$project->total_anggaran)}}"

required

>


</div>


</div>









{{-- TANGGAL MULAI --}}


<div class="form-group">


<label>
Tanggal Mulai
</label>


<input

type="date"

name="tanggal_mulai"

value="{{old('tanggal_mulai',$project->tanggal_mulai)}}"

required

>


</div>









{{-- TANGGAL SELESAI --}}


<div class="form-group">


<label>
Tanggal Selesai
</label>


<input

type="date"

name="tanggal_selesai"

value="{{old('tanggal_selesai',$project->tanggal_selesai)}}"

required

>


</div>






</div>








<div class="form-action">


<button class="btn-update">

💾 Update Project

</button>


</div>





</form>



</div>





</div>





<style>


.page-wrapper{

width:100%;

}




/* HEADER */


.page-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.page-label{

font-size:11px;

letter-spacing:2px;

font-weight:800;

color:#94a3b8;

}



.page-header h1{

margin:5px 0;

font-size:28px;

color:#166534;

}



.page-header p{

margin:0;

font-size:13px;

color:#64748b;

}




.btn-back{

background:white;

padding:10px 18px;

border-radius:14px;

text-decoration:none;

color:#475569;

font-size:13px;

font-weight:700;

border:1px solid #e2e8f0;

}







/* ERROR */


.alert-error{

background:#fee2e2;

color:#991b1b;

padding:15px 20px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

}



.alert-error ul{

margin-bottom:0;

}








/* CARD */


.form-card{


background:white;


padding:28px;


border-radius:25px;


max-width:850px;


box-shadow:

0 15px 40px rgba(15,23,42,.08);


}



.card-title{


font-size:17px;

font-weight:800;

margin-bottom:25px;

color:#1e293b;

}








/* FORM */


.form-grid{


display:grid;


grid-template-columns:

repeat(2,1fr);


gap:20px;


}



.form-group{


display:flex;

flex-direction:column;


}



.form-group label{


font-size:12px;

font-weight:700;

color:#475569;

margin-bottom:8px;

}




.form-group input{


height:45px;


border-radius:12px;


border:1px solid #e2e8f0;


background:#f8fafc;


padding:0 14px;


font-size:13px;


outline:none;


}



.form-group input:focus{


background:white;


border-color:#22c55e;


box-shadow:

0 0 0 4px rgba(34,197,94,.15);


}








/* MONEY */


.money-input{


display:flex;


align-items:center;


height:45px;


border-radius:12px;


background:#f8fafc;


border:1px solid #e2e8f0;


overflow:hidden;


}



.money-input span{


padding:0 15px;


font-weight:800;


color:#166534;


}



.money-input input{


border:none;

height:100%;

flex:1;

}









/* BUTTON */


.form-action{


display:flex;


justify-content:flex-end;


margin-top:30px;


}



.btn-update{


border:none;


padding:13px 28px;


border-radius:15px;


background:

linear-gradient(

135deg,

#166534,

#22c55e

);


color:white;


font-weight:800;


cursor:pointer;


}



.btn-update:hover{

transform:translateY(-2px);

}







@media(max-width:800px){


.form-grid{

grid-template-columns:1fr;

}



.page-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}



</style>


@endsection