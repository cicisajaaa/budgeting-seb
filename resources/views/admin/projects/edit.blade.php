@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->


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









@if($errors->any())


<div class="alert-error">


<strong>

Terjadi kesalahan:

</strong>


<ul>


@foreach($errors->all() as $error)


<li>

{{ $error }}

</li>


@endforeach


</ul>


</div>


@endif







<!-- FORM -->


<div class="glass-panel form-card">



<div class="panel-title">

📁 Informasi Project

</div>






<form method="POST"

action="{{ route('admin.projects.update',$project->id) }}">


@csrf

@method('PUT')





<div class="form-grid">







<div class="form-group">


<label>

Nama Project

</label>



<input

type="text"

name="nama_project"

value="{{old('nama_project',$project->nama_project)}}"

required>



</div>








<div class="form-group">


<label>

Project Owner

</label>



<input

type="text"

name="project_owner"

value="{{old('project_owner',$project->project_owner)}}"

required>



</div>








<div class="form-group">


<label>

Total Budget

</label>



<div class="input-money">


<span>

Rp

</span>



<input

type="number"

name="total_budget"

value="{{old('total_budget',$project->total_budget)}}"

required>



</div>



</div>








<div class="form-group">


<label>

Tanggal Mulai

</label>



<input

type="date"

name="start_date"

value="{{old('start_date',$project->start_date)}}"

required>



</div>








<div class="form-group">


<label>

Tanggal Selesai

</label>



<input

type="date"

name="end_date"

value="{{old('end_date',$project->end_date)}}"

required>



</div>







</div>








<div class="form-action">


<button class="btn-update">

💾 Update Project

</button>


</div>





</form>



</div>









<style>


/* =========================
HEADER
========================= */


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


padding:

10px 18px;


border-radius:12px;


font-size:13px;


font-weight:600;


text-decoration:none;


color:#475569;


}









/* =========================
ERROR
========================= */


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








/* =========================
FORM CARD
========================= */


.form-card{


max-width:900px;


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









/* =========================
FORM
========================= */


.form-grid{


display:grid;


grid-template-columns:

repeat(2,1fr);



gap:18px;


}



.form-group{


display:flex;


flex-direction:column;


}



.form-group label{


font-size:12px;


font-weight:600;


color:#475569;


margin-bottom:7px;


}





.form-group input{


height:45px;


border-radius:12px;


border:

1px solid #e2e8f0;


background:#f8fafc;


padding:

0 14px;


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







/* MONEY INPUT */


.input-money{


display:flex;


align-items:center;


height:45px;


border-radius:12px;


border:

1px solid #e2e8f0;


background:#f8fafc;


overflow:hidden;


}



.input-money span{


padding:

0 12px;


color:#166534;


font-weight:700;


font-size:13px;


}



.input-money input{


border:none;


height:100%;


flex:1;


}







/* BUTTON */


.form-action{


margin-top:25px;


display:flex;


justify-content:flex-end;


}




.btn-update{


border:none;


padding:

12px 25px;


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