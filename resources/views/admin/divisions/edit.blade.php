@extends('layouts.dashboard')


@section('content')



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






@if(session('success'))


<div class="alert-success">

✓ {{session('success')}}

</div>


@endif







<div class="glass-panel">



<div class="info-box">


<div class="info-icon">

🏢

</div>


<div>

<strong>
Edit Data Divisi
</strong>


<p>
Perubahan nama divisi akan mempengaruhi data alokasi dana,
pengajuan biaya, dan laporan perusahaan.
</p>


</div>


</div>








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

💾 Simpan Perubahan

</button>


</div>






</form>


</div>









<style>


.page-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.page-label{

font-size:10px;

letter-spacing:2px;

font-weight:800;

color:#94a3b8;

}



.page-header h1{

font-size:28px;

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

padding:12px 18px;

border-radius:14px;

text-decoration:none;

color:#475569;

font-size:13px;

font-weight:600;

}









.glass-panel{

background:white;

border-radius:22px;

padding:30px;

max-width:700px;

box-shadow:

0 10px 30px rgba(15,23,42,.08);

}







.info-box{

display:flex;

align-items:center;

gap:15px;

background:#f0fdf4;

padding:18px;

border-radius:18px;

margin-bottom:25px;

}



.info-icon{

width:45px;

height:45px;

border-radius:15px;

background:#dcfce7;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}



.info-box strong{

font-size:14px;

color:#166534;

}



.info-box p{

font-size:12px;

color:#64748b;

margin-top:5px;

}







.panel-title{

font-size:18px;

font-weight:700;

color:#166534;

margin-bottom:25px;

}







.form-group{

display:flex;

flex-direction:column;

gap:8px;

}



.form-group label{

font-size:13px;

font-weight:700;

color:#475569;

}



input{

height:50px;

border-radius:14px;

border:1px solid #e2e8f0;

background:#f8fafc;

padding:0 15px;

font-size:14px;

}



input:focus{

outline:none;

background:white;

border-color:#22c55e;

box-shadow:

0 0 0 4px rgba(34,197,94,.12);

}







.form-action{

margin-top:25px;

display:flex;

justify-content:flex-end;

}







.btn-update{

border:none;

padding:13px 25px;

border-radius:14px;

background:

linear-gradient(
135deg,
#166534,
#22c55e
);

color:white;

font-weight:700;

cursor:pointer;

}



.btn-update:hover{

transform:translateY(-2px);

}







.alert-error{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

}



.alert-error ul{

padding-left:20px;

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







@media(max-width:800px){

.page-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}

}

</style>



@endsection