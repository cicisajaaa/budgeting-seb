@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->

<div class="page-header-card">

<div>


<div class="page-label">

ADMINISTRASI

</div>


<h1>

Edit User

</h1>


<p>

Perbarui informasi akun dan hak akses pengguna.

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

{{ $error }}

</li>


@endforeach


</ul>


</div>


@endif







<!-- FORM -->


<div class="glass-panel form-card">



<div class="panel-title">

✏️ Informasi Pengguna

</div>





<form method="POST"

action="{{ route('admin.users.update',$user->id) }}">


@csrf

@method('PUT')






<div class="form-grid">





<div class="form-group">


<label>

Nama Lengkap

</label>



<input

type="text"

name="name"

value="{{old('name',$user->name)}}"

required>



</div>







<div class="form-group">


<label>

Email

</label>



<input

type="email"

name="email"

value="{{old('email',$user->email)}}"

required>



</div>








<div class="form-group">


<label>

Role Pengguna

</label>



<select name="role">


<option value="admin"

{{$user->role=='admin'?'selected':''}}>

Admin

</option>




<option value="owner"

{{$user->role=='owner'?'selected':''}}>

Owner

</option>




<option value="keuangan"

{{$user->role=='keuangan'?'selected':''}}>

keuangan

</option>




<option value="karyawan"

{{$user->role=='karyawan'?'selected':''}}>

Karyawan

</option>



</select>



</div>






<div class="form-group">


<label>

Password Baru

</label>



<input

type="password"

name="password"

placeholder="Kosongkan jika tidak diganti">



</div>






</div>







<div class="form-action">


<button class="btn-update">

💾 Update User

</button>


</div>





</form>




</div>








<style>

/* ===============================
HEADER CARD
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

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.btn-back:hover{

    background:white;

    border-color:#b8863b;

    color:#8b5e22;

}








/* ===============================
ERROR
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
FORM
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




.btn-update{


    border:none;

    background:#1e293b;

    color:white;

    padding:13px 28px;

    border-radius:14px;

    font-size:13px;

    font-weight:800;

    cursor:pointer;

    transition:.2s;

}





.btn-update:hover{


    background:#b8863b;

    transform:translateY(-2px);


}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:800px){


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



.btn-update{


    width:100%;


}


}

</style>



@endsection