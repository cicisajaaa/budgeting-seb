@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->

<div class="page-header">


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




<option value="bendahara"

{{$user->role=='bendahara'?'selected':''}}>

Bendahara

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


/* HEADER */


.page-header{


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:20px;


}



.page-label{


font-size:10px;


letter-spacing:2px;


font-weight:700;


color:#94a3b8;


}



.page-header h1{


font-size:24px;


color:#166534;


margin:5px 0;


}



.page-header p{


font-size:13px;


color:#64748b;


}







.btn-back{


background:white;


border:

1px solid #e5e7eb;



padding:

10px 18px;



border-radius:12px;



text-decoration:none;



font-size:13px;



font-weight:600;



color:#475569;



}








/* ERROR */


.alert-error{


background:#fee2e2;


color:#991b1b;


padding:14px 18px;


border-radius:14px;


margin-bottom:18px;


font-size:13px;


}



.alert-error ul{


padding-left:20px;


margin-top:8px;


}








/* CARD */


.form-card{


max-width:850px;


}



.glass-panel{


background:

rgba(255,255,255,.65);



backdrop-filter:

blur(15px);



border-radius:20px;



padding:25px;



border:

1px solid rgba(255,255,255,.8);



box-shadow:

0 15px 35px rgba(15,23,42,.06);



}



.panel-title{


font-size:15px;


font-weight:700;


margin-bottom:20px;


color:#111827;


}








/* FORM */


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



.form-group input,


.form-group select{


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



.form-group input:focus,


.form-group select:focus{


border-color:#22c55e;


background:white;



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



font-weight:600;



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