@extends('layouts.dashboard')

@section('content')


<div class="page-wrapper">


<div class="page-header-card">


<div>

<div class="page-label">
PROJECT MANAGEMENT
</div>


<h1>
Edit Project
</h1>


<p>
Perbarui informasi project, perusahaan, anggaran, dan periode pelaksanaan.
</p>


</div>



<a href="{{route('admin.projects.index')}}"
class="btn-back">

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







<div class="form-card">


<div class="card-title">

📁 Informasi Project

</div>





<form method="POST"
action="{{route('admin.projects.update',$project->id)}}">


@csrf

@method('PUT')






<div class="form-grid">






{{-- PERUSAHAAN --}}


<div class="form-group">


<label>
Perusahaan *
</label>


<select name="perusahaan_id"
required>


<option value="">
-- Pilih Perusahaan --
</option>



@foreach($perusahaans as $perusahaan)


<option

value="{{$perusahaan->id}}"

{{old('perusahaan_id',$project->perusahaan_id)==$perusahaan->id?'selected':''}}

>

{{$perusahaan->nama_perusahaan}}

</option>



@endforeach


</select>


</div>








{{-- NAMA PROJECT --}}


<div class="form-group">


<label>
Nama Project *
</label>


<input

type="text"

name="nama_proyek"

value="{{old('nama_proyek',$project->nama_proyek)}}"

placeholder="Nama project"

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

placeholder="Nama pemilik project"

>


</div>







{{-- ANGGARAN --}}


<div class="form-group">


<label>
Total Anggaran *
</label>


<div class="money-input">


<span>
Rp
</span>


<input

type="number"

name="total_anggaran"

value="{{old('total_anggaran',$project->total_anggaran)}}"

placeholder="0"

required

>


</div>


</div>







{{-- TANGGAL MULAI --}}


<div class="form-group">


<label>
Tanggal Mulai *
</label>


<input

type="date"

name="tanggal_mulai"

value="{{old(
'tanggal_mulai',
$project->tanggal_mulai?->format('Y-m-d')
)}}"

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

value="{{old(
'tanggal_selesai',
$project->tanggal_selesai?->format('Y-m-d')
)}}"

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




.page-header-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:24px;

padding:25px 30px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:0 8px 25px rgba(15,23,42,.05);

}



.page-label{

font-size:10px;

letter-spacing:2px;

font-weight:800;

color:#64748b;

}



.page-header-card h1{

margin:8px 0;

font-size:24px;

font-weight:800;

color:#1e293b;

}



.page-header-card p{

margin:0;

font-size:12px;

color:#64748b;

}





.btn-back{

display:flex;

align-items:center;

justify-content:center;

background:white;

border:1px solid #e2e8f0;

color:#334155;

padding:10px 20px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

}



.btn-back:hover{

background:#334155;

color:white;

}





.alert-error{

background:#fee2e2;

border:1px solid #fecaca;

color:#991b1b;

padding:14px;

border-radius:15px;

margin-bottom:20px;

font-size:12px;

}





.form-card{

background:white;

border:1px solid #e2e8f0;

border-radius:22px;

padding:25px;

box-shadow:0 5px 20px rgba(15,23,42,.05);

}




.card-title{

font-size:16px;

font-weight:800;

color:#172033;

padding-left:10px;

border-left:4px solid #334155;

margin-bottom:20px;

}





.form-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:18px;

}





.form-group{

display:flex;

flex-direction:column;

}




.form-group label{

font-size:11px;

font-weight:800;

color:#64748b;

margin-bottom:7px;

}




.form-group input,
.form-group select{


height:44px;

width:100%;

padding:0 14px;

border-radius:12px;

border:1px solid #dbe1e8;

background:#f8fafc;

font-size:12px;

}



.form-group input:focus,
.form-group select:focus{

outline:none;

background:white;

border-color:#334155;

box-shadow:0 0 0 3px rgba(51,65,85,.12);

}





.money-input{

height:44px;

display:flex;

align-items:center;

border-radius:12px;

border:1px solid #dbe1e8;

background:#f8fafc;

overflow:hidden;

}




.money-input span{

padding:0 14px;

font-size:12px;

font-weight:800;

color:#475569;

}




.money-input input{

flex:1;

height:100%;

border:none;

background:transparent;

}




.form-action{

margin-top:25px;

padding-top:20px;

border-top:1px solid #f1f5f9;

display:flex;

justify-content:flex-end;

}




.btn-update{


background:#334155;

color:white;

border:none;

padding:12px 25px;

border-radius:12px;

font-size:12px;

font-weight:800;

cursor:pointer;

}



.btn-update:hover{

background:#1e293b;

}





@media(max-width:900px){


.form-grid{

grid-template-columns:1fr;

}


.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


.btn-update{

width:100%;

}


}


</style>



@endsection