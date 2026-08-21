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


<select name="role" id="role">


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
Keuangan
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






<div id="employee-field">


<div class="form-group">

<label>
Nama Karyawan
</label>


<input
type="text"
name="nama_karyawan"

value="{{old(
'nama_karyawan',
$user->karyawan->nama_karyawan ?? $user->name
)}}">

</div>





<div class="form-group">

<label>
Divisi
</label>


<select name="divisi_id">


<option value="">
-- Pilih Divisi --
</option>


@foreach($divisi as $item)


<option value="{{$item->id}}"

{{old(
'divisi_id',
$user->karyawan->divisi_id ?? ''
)==$item->id?'selected':''}}

>

{{$item->nama_divisi}}

</option>


@endforeach


</select>


</div>


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
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


/* ===============================
HEADER
================================ */


.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}



.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    font-size:24px;

    margin:8px 0;

    color:#1e293b;

    font-weight:800;

}



.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:12px;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    display:flex;

    align-items:center;

    justify-content:center;

    background:white;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.btn-back:hover{

    background:#334155;

    color:white;

}







/* ===============================
ALERT
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:14px;

    border-radius:14px;

    margin-bottom:20px;

    font-size:12px;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:22px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}







/* ===============================
TITLE
================================ */


.panel-title{

    font-size:15px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

    padding-left:10px;

    border-left:4px solid #334155;

}








/* ===============================
FORM
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}





.form-group{

    display:flex;

    flex-direction:column;

    gap:7px;

}



.form-group label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



.form-group input,
.form-group select{

    height:42px;

    width:100%;

    padding:0 13px;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    font-size:12px;

    color:#172033;

}



.form-group input:focus,
.form-group select:focus{

    outline:none;

    background:white;

    border-color:#334155;

}







/* ===============================
EMPLOYEE SECTION
================================ */


#employee-field{

    grid-column:1/-1;

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

    background:#f8fafc;

    padding:18px;

    border-radius:18px;

    border:1px solid #e2e8f0;

}







/* ===============================
ACTION
================================ */


.form-action{

    margin-top:25px;

    padding-top:18px;

    border-top:1px solid #e2e8f0;

    display:flex;

    justify-content:flex-end;

}



.btn-update{

    background:#334155;

    color:white;

    border:none;

    padding:11px 24px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.btn-update:hover{

    background:#1e293b;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.form-grid{

    grid-template-columns:1fr;

}



#employee-field{

    display:block;

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



.btn-update{

    width:100%;

}


}

</style>



<script>

document.addEventListener(
'DOMContentLoaded',
function(){


const role = document.getElementById('role');

const employeeField = document.getElementById('employee-field');



function checkRole(){


    if(role.value === 'owner'){


        employeeField.style.display = 'none';


    }else{


        employeeField.style.display = 'grid';


    }


}



role.addEventListener(
'change',
checkRole
);



checkRole();


});

</script>

@endsection