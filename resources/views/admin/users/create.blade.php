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


<option value="admin"
{{old('role')=='admin'?'selected':''}}>
Admin
</option>


<option value="owner"
{{old('role')=='owner'?'selected':''}}>
Owner
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






</div>







<div class="form-action">


<button class="btn-save">

💾 Simpan User

</button>


</div>




</form>


</div>









<style>


.employee-field{

display:flex;

}



</style>







<script>

document.addEventListener(
'DOMContentLoaded',
function(){


const role = document.getElementById('role');

const fields = document.querySelectorAll('.employee-field');



function toggleEmployee(){


if(role.value === 'owner'){


fields.forEach(function(field){

field.style.display='none';


field.querySelectorAll('input,select')
.forEach(function(input){

input.disabled=true;

});


});


}else{


fields.forEach(function(field){

field.style.display='flex';


field.querySelectorAll('input,select')
.forEach(function(input){

input.disabled=false;

});


});


}


}




role.addEventListener(
'change',
toggleEmployee
);


toggleEmployee();


});

</script>


<style>

/* ===============================
GLOBAL HEADER CARD
================================ */


.page-header-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:30px 32px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}



.page-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#94a3b8;

}



.page-header-card h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

    font-weight:800;

}



.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:14px;

}





/* ===============================
BACK BUTTON
================================ */


.btn-back{


    background:#f8fafc;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:11px 22px;

    border-radius:14px;

    font-size:13px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;


}



.btn-back:hover{


    background:#ffffff;

    border-color:#b8863b;

    color:#8b5e22;


}







/* ===============================
ERROR ALERT
================================ */


.alert-error{


    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:16px 18px;

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
FORM CARD
================================ */


.form-card{


    max-width:900px;


}



.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:30px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


}





.panel-title{


    font-size:18px;


    font-weight:800;


    color:#172033;


    margin-bottom:25px;


}







/* ===============================
FORM GRID
================================ */


.form-grid{


    display:grid;


    grid-template-columns:repeat(2,1fr);


    gap:22px;


}





.form-group{


    display:flex;


    flex-direction:column;


}





.form-group label{


    font-size:12px;


    font-weight:800;


    color:#475569;


    margin-bottom:8px;


}







.form-group input,
.form-group select{


    width:100%;


    height:46px;


    padding:0 15px;


    border-radius:14px;


    border:1px solid #e2e8f0;


    background:#f8fafc;


    color:#172033;


    font-size:13px;


    transition:.2s;


}







.form-group input:focus,
.form-group select:focus{


    outline:none;


    background:white;


    border-color:#b8863b;


    box-shadow:


    0 0 0 3px rgba(184,134,59,.12);


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


    background:#1e293b;


    color:white;


    border:none;


    padding:13px 28px;


    border-radius:14px;


    font-size:13px;


    font-weight:800;


    cursor:pointer;


    transition:.2s;


}





.btn-save:hover{


    background:#b8863b;


    transform:translateY(-2px);


}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.page-header-card{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}



.form-grid{


    grid-template-columns:1fr;


}



.form-action{


    justify-content:stretch;


}



.btn-save{


    width:100%;


}


}

.employee-field.hidden{
display:none!important;
}

</style>




@endsection