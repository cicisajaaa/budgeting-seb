@extends('layouts.dashboard')


@section('content')



<div class="page-header-card">


<div>


<div class="page-label">

PROJECT MANAGEMENT

</div>


<h1>

Tambah Project

</h1>


<p>

Buat project baru dan hubungkan dengan perusahaan.

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







<div class="glass-panel form-card">



<div class="panel-title">

📁 Informasi Project Baru

</div>





<form method="POST"
action="{{route('admin.projects.store')}}">

@csrf




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



@if($perusahaans->count())


@foreach($perusahaans as $perusahaan)


<option value="{{$perusahaan->id}}"

{{old('perusahaan_id')==$perusahaan->id?'selected':''}}

>

{{$perusahaan->nama_perusahaan}}

</option>


@endforeach



@else


<option value="">

Belum ada perusahaan aktif

</option>


@endif



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

value="{{old('nama_proyek')}}"

placeholder="Masukkan nama project"

required>


</div>








{{-- PEMILIK PROJECT --}}


<div class="form-group">


<label>

Project Owner

</label>



<input

type="text"

name="pemilik_proyek"

value="{{old('pemilik_proyek')}}"

placeholder="Nama pemilik project">


</div>








{{-- ANGGARAN --}}


<div class="form-group">


<label>

Total Anggaran *

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








{{-- TANGGAL MULAI --}}


<div class="form-group">


<label>

Tanggal Mulai *

</label>


<input

type="date"

name="tanggal_mulai"

value="{{old('tanggal_mulai')}}"

required>


</div>








{{-- TANGGAL SELESAI --}}


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

    padding:25px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

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

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

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

}







/* ===============================
ERROR
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

}







/* ===============================
FORM PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

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

    margin-bottom:8px;

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

    color:#172033;

    outline:none;

    transition:.2s;

}




.form-group input:focus,
.form-group select:focus{


    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.12);

}







/* ===============================
MONEY INPUT
================================ */


.input-money{


    height:44px;

    display:flex;

    align-items:center;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    overflow:hidden;

}



.input-money span{


    padding:0 14px;

    font-size:12px;

    font-weight:800;

    color:#475569;

}



.input-money input{


    flex:1;

    height:100%;

    border:none;

    background:transparent;

}



.input-money input:focus{


    box-shadow:none;

}







/* ===============================
BUTTON SAVE
================================ */


.form-action{


    margin-top:30px;

    padding-top:20px;

    border-top:1px solid #f1f5f9;

    display:flex;

    justify-content:flex-end;

}





.btn-save{


    background:#334155;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

    transition:.2s;

}



.btn-save:hover{


    background:#1e293b;

    transform:translateY(-2px);

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){



.page-header-card{


    flex-direction:column;


    align-items:flex-start;


    gap:15px;


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



</style>


@endsection