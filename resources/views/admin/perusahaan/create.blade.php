@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
ADMINISTRASI
</div>


<h1>
Tambah Perusahaan
</h1>


<p>
Tambahkan data perusahaan baru ke sistem.
</p>


</div>



<a href="{{route('admin.perusahaan.index')}}"
class="btn-secondary">

← Kembali

</a>


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



<form method="POST"
action="{{route('admin.perusahaan.store')}}">


@csrf





<div class="form-grid">



<div class="form-group">

<label>
Nama Perusahaan
</label>


<input type="text"
name="nama_perusahaan"
value="{{old('nama_perusahaan')}}"
placeholder="Masukkan nama perusahaan">


</div>







<div class="form-group">

<label>
Kontak
</label>


<input type="text"
name="kontak"
value="{{old('kontak')}}"
placeholder="Nomor kontak perusahaan">


</div>








<div class="form-group">

<label>
Email
</label>


<input type="email"
name="email"
value="{{old('email')}}"
placeholder="Email perusahaan">


</div>








<div class="form-group">

<label>
Status
</label>



<select name="status">


<option value="aktif">
Aktif
</option>


<option value="nonaktif">
Nonaktif
</option>


</select>


</div>







<div class="form-group full">

<label>
Alamat
</label>


<textarea
name="alamat"
rows="4"
placeholder="Alamat perusahaan">{{old('alamat')}}</textarea>


</div>



</div>








<div class="form-action">


<button type="submit"
class="btn-primary">

💾 Simpan Perusahaan

</button>


</div>



</form>



</div>








<style>


.page-header-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:24px;

padding:25px 30px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.page-label{

font-size:10px;

font-weight:800;

letter-spacing:2px;

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






.btn-primary{

background:#334155;

color:white;

padding:11px 18px;

border-radius:12px;

border:none;

font-size:12px;

font-weight:700;

cursor:pointer;

text-decoration:none;

}



.btn-secondary{

background:#f1f5f9;

color:#334155;

padding:11px 18px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

}







.glass-panel{

background:white;

border:1px solid #e2e8f0;

border-radius:22px;

padding:30px;

box-shadow:

0 5px 20px rgba(15,23,42,.05);

}





.form-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}




.form-group{

display:flex;

flex-direction:column;

gap:8px;

}




.form-group.full{

grid-column:1/-1;

}




.form-group label{

font-size:12px;

font-weight:700;

color:#334155;

}




input,
select,
textarea{


border:1px solid #e2e8f0;

border-radius:12px;

padding:12px;

font-size:13px;

outline:none;

font-family:inherit;

}




input:focus,
select:focus,
textarea:focus{

border-color:#334155;

}




textarea{

resize:none;

}





.form-action{

margin-top:25px;

display:flex;

justify-content:flex-end;

}





.alert-error{

background:#fee2e2;

border:1px solid #fecaca;

padding:15px;

border-radius:15px;

color:#991b1b;

font-size:12px;

margin-bottom:20px;

}





@media(max-width:800px){


.form-grid{

grid-template-columns:1fr;

}


.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}


</style>



@endsection