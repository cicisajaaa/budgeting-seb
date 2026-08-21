@extends('layouts.dashboard')


@section('content')



{{-- ================= HEADER ================= --}}


<div class="page-header-card">


<div>


<div class="page-label">

MANAJEMEN DIVISI

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












{{-- ================= FORM ================= --}}



<div class="form-card">





<div class="form-heading">


<div class="form-icon">

✏️

</div>




<div>


<h3>

Informasi Divisi

</h3>


<p>

Perbarui data divisi yang sudah terdaftar pada sistem.

</p>


</div>



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




<div class="form-group">

<label>
Deskripsi Divisi
</label>


<textarea
name="deskripsi"
placeholder="Masukkan deskripsi divisi">{{old('deskripsi',$division->deskripsi)}}</textarea>


</div>









<div class="form-action">


<button class="btn-update">

💾 Simpan Perubahan

</button>


</div>






</form>



</div>









{{-- ================= INFORMATION ================= --}}



<div class="information-card">



<div class="information-icon">

🏢

</div>




<div>


<h4>

Catatan Perubahan Divisi

</h4>


<p>

Perubahan nama divisi dapat mempengaruhi relasi data project, alokasi dana, dan laporan sistem perusahaan.

</p>


</div>


</div>




<style>

/* ===============================
HEADER
================================ */

.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:8px 0;

    font-size:26px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
BACK
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    color:#334155;

    font-size:12px;

    font-weight:700;

}



.btn-back:hover{

    background:#334155;

    color:white;

}







/* ===============================
FORM CARD
================================ */


.form-card{

    width:100%;

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}







/* ===============================
FORM HEADER
================================ */


.form-heading{

    display:flex;

    align-items:center;

    gap:12px;

    padding-bottom:18px;

    margin-bottom:20px;

    border-bottom:1px solid #f1f5f9;

}



.form-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.form-heading h3{

    margin:0;

    font-size:16px;

    font-weight:800;

    color:#172033;

}



.form-heading p{

    margin:4px 0 0;

    font-size:11px;

    color:#64748b;

}







/* ===============================
FORM
================================ */


.form-group{

    display:flex;

    flex-direction:column;

    margin-bottom:18px;

}



.form-group label{

    font-size:11px;

    font-weight:800;

    color:#475569;

    margin-bottom:7px;

}



input,
textarea{

    width:100%;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:12px 14px;

    font-size:13px;

    color:#172033;

}



input{

    height:44px;

}



textarea{

    min-height:100px;

    resize:none;

}



input:focus,
textarea:focus{

    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.12);

}







/* ===============================
BUTTON
================================ */


.form-action{

    margin-top:20px;

    padding-top:18px;

    border-top:1px solid #f1f5f9;

    display:flex;

    justify-content:flex-end;

}



.btn-update{

    background:#1e293b;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.btn-update:hover{

    background:#334155;

}







/* ===============================
INFO CARD
================================ */


.information-card{

    margin-top:20px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:12px;

}





.information-icon{

    width:38px;

    height:38px;

    border-radius:11px;

    background:#dbeafe;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:17px;

}



.information-card h4{

    margin:0;

    font-size:14px;

    color:#172033;

}



.information-card p{

    margin:5px 0 0;

    font-size:11px;

    color:#64748b;

    line-height:1.5;

}







/* ===============================
ALERT
================================ */


.alert-error{

    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:13px;

    border-radius:14px;

    margin-bottom:18px;

    font-size:12px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:800px){


.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.btn-back{

    width:100%;

    text-align:center;

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