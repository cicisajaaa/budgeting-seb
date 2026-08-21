@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
ADMINISTRASI
</div>


<h1>
Tambah User
</h1>


<p>
Buat akun pengguna baru dan atur hak akses sistem.
</p>


</div>



<a href="{{route('admin.users.index')}}" class="btn-back">

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







<div class="glass-panel form-card">


<div class="panel-title">

👤 Informasi Pengguna

</div>





<form method="POST"

action="{{route('admin.users.store')}}">


@csrf





<div class="form-grid">






<div class="form-group">

<label>
Nama Lengkap
</label>


<input

type="text"

name="name"

value="{{old('name')}}"

placeholder="Masukkan nama pengguna"

required>

</div>







<div class="form-group">

<label>
Email
</label>


<input

type="email"

name="email"

value="{{old('email')}}"

placeholder="nama@email.com"

required>

</div>








<div class="form-group">

<label>
Role Pengguna
</label>

<select name="role" id="role">

<option value="">
-- Pilih Role --
</option>


<option value="owner"
{{old('role')=='owner'?'selected':''}}>
Owner
</option>


<option value="admin"
{{old('role')=='admin'?'selected':''}}>
Admin
</option>


<option value="keuangan"
{{old('role')=='keuangan'?'selected':''}}>
Keuangan
</option>


<option value="karyawan"
{{old('role')=='karyawan'?'selected':''}}>
Karyawan
</option>


</select>


</div>








<div class="form-group employee-field">


<label>
Nama Karyawan
</label>


<input

type="text"

name="nama_karyawan"

value="{{old('nama_karyawan')}}"

placeholder="Masukkan nama karyawan">


</div>








<div class="form-group employee-field">


<label>
Divisi
</label>


<select name="divisi_id" id="divisi_id">

<option value="">
-- Pilih Divisi --
</option>



@foreach($divisi as $item)


<option value="{{$item->id}}"

{{old('divisi_id')==$item->id?'selected':''}}

>

{{$item->nama_divisi}}

</option>


@endforeach



</select>


</div>








<div class="form-group">


<label>
Password
</label>


<input

type="password"

name="password"

placeholder="Masukkan password"

required>



</div>

<div class="form-group">


<label>
Konfirmasi Password
</label>


<input

type="password"

name="password_confirmation"

placeholder="Ulangi password"

required>


</div>





</div>







<div class="form-action">


<button class="btn-save">

💾 Simpan User

</button>


</div>




</form>


</div>






<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}



/* ===============================
HEADER OWNER STYLE
================================ */


.page-header-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    display:flex;

    align-items:center;

    justify-content:center;

    background:white;

    color:#334155;

    border:1px solid #e2e8f0;

    padding:10px 20px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

    border-color:#334155;

}







/* ===============================
ERROR
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:15px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

}



.alert-error strong{

    display:block;

    margin-bottom:8px;

}



.alert-error ul{

    margin:0;

    padding-left:20px;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.form-card{

    width:100%;

}





.panel-title{

    display:flex;

    align-items:center;

    gap:10px;

    font-size:17px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:25px;

}







/* ===============================
FORM GRID
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}



.form-group{

    display:flex;

    flex-direction:column;

}





.form-group label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}







.form-group input,
.form-group select{


    height:44px;

    padding:0 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:13px;

    color:#334155;

    transition:.2s;

}





.form-group input::placeholder{

    color:#94a3b8;

}






.form-group input:focus,
.form-group select:focus{


    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.08);

}








/* ===============================
EMPLOYEE FIELD
================================ */


.employee-field.hidden{

    display:none!important;

}







/* ===============================
PASSWORD STYLE
================================ */


input[type=password]{

    letter-spacing:1px;

}







/* ===============================
ACTION BUTTON
================================ */


.form-action{

    margin-top:30px;

    display:flex;

    justify-content:flex-end;

}





.btn-save{


    display:flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    background:#334155;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:13px;

    font-weight:700;

    cursor:pointer;

    transition:.2s;

}



.btn-save:hover{

    background:#1e293b;

}







/* ===============================
DISABLED
================================ */


input:disabled,
select:disabled{

    background:#f1f5f9;

    cursor:not-allowed;

}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.form-grid{

    grid-template-columns:1fr;

}


}





@media(max-width:700px){



.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.btn-back{

    width:100%;

}



.form-action{

    justify-content:stretch;

}



.btn-save{

    width:100%;

}



.glass-panel{

    padding:20px;

}


}

</style>


@endsection