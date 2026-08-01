@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->

<div class="page-header-card">


<div>


<div class="page-label">

PROJECT MANAGEMENT

</div>


<h1>

Tambah Project

</h1>


<p>

Buat project baru dan kelola informasi anggaran perusahaan.

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

📁 Informasi Project Baru

</div>





<form method="POST"

action="{{ route('admin.projects.store') }}">

@csrf



<div class="form-grid">





<div class="form-group">


<label>
Nama Project
</label>



<input

type="text"

name="nama_proyek"

value="{{old('nama_proyek')}}"

placeholder="Masukkan nama project"

required>


</div>








<div class="form-group">


<label>
Project Owner
</label>



<input

type="text"

name="pemilik_proyek"

value="{{old('pemilik_proyek')}}"

placeholder="Nama pemilik project"

required>


</div>








<div class="form-group">


<label>
Total Anggaran
</label>



<div class="input-money">


<span>
Rp
</span>



<input

type="number"

name="total_anggaran"

value="{{old('total_anggaran')}}"

placeholder="0"

required>


</div>


</div>








<div class="form-group">


<label>
Tanggal Mulai
</label>



<input

type="date"

name="tanggal_mulai"

value="{{old('tanggal_mulai')}}"

required>


</div>








<div class="form-group">


<label>
Tanggal Selesai
</label>



<input

type="date"

name="tanggal_selesai"

value="{{old('tanggal_selesai')}}">


</div>








</div>








<div class="form-action">


<button class="btn-save">

💾 Simpan Project

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

    padding:11px 20px;

    border-radius:14px;

    text-decoration:none;

    color:#334155;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.btn-back:hover{

    background:#1e293b;

    color:white;

}







/* ===============================
ERROR
================================ */


.alert-error{

    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:15px 18px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

}



.alert-error ul{

    margin-top:8px;

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


    padding:28px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


}





.panel-title{


    font-size:17px;


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


    gap:20px;


}





.form-group{


    display:flex;


    flex-direction:column;


}





.form-group label{


    font-size:12px;


    font-weight:700;


    color:#475569;


    margin-bottom:8px;


}








.form-group input{


    height:46px;


    border-radius:14px;


    border:1px solid #dbe1e8;


    background:#f8fafc;


    padding:0 15px;


    font-size:14px;


    outline:none;


    transition:.2s;


}





.form-group input:focus{


    background:white;


    border-color:#2563eb;


    box-shadow:


    0 0 0 3px rgba(37,99,235,.12);


}









/* ===============================
MONEY INPUT
================================ */


.input-money{


    height:46px;


    display:flex;


    align-items:center;


    border-radius:14px;


    border:1px solid #dbe1e8;


    background:#f8fafc;


    overflow:hidden;


}



.input-money span{


    padding:0 15px;


    font-size:13px;


    font-weight:800;


    color:#475569;


}



.input-money input{


    flex:1;


    border:none;


    height:100%;


    background:transparent;


}



.input-money input:focus{


    box-shadow:none;


}








/* ===============================
BUTTON
================================ */


.form-action{


    margin-top:30px;


    display:flex;


    justify-content:flex-end;


}



.btn-save{


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



.btn-save:hover{


    background:#2563eb;


    transform:translateY(-2px);


}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:800px){


.form-grid{


    grid-template-columns:1fr;


}



.page-header-card{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}



.form-action{


    justify-content:flex-start;


}



.btn-save{


    width:100%;


}


}

</style>



@endsection