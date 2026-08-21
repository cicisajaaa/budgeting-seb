@extends('layouts.dashboard')


@section('content')


{{-- ================= HEADER ================= --}}

<div class="page-header-card">


<div>


<div class="page-label">
MANAJEMEN DIVISI
</div>



<h1>
Tambah Divisi
</h1>



<p>
Tambahkan unit organisasi baru perusahaan.
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

🏢

</div>




<div>


<h3>
Informasi Divisi
</h3>


<p>
Kelola data unit organisasi yang digunakan dalam sistem perusahaan.
</p>


</div>



</div>







<form method="POST"

action="{{route('admin.divisions.store')}}">


@csrf







<div class="form-grid">





<div class="form-group">


<label>

Nama Divisi

</label>


<input

type="text"

name="nama_divisi"

value="{{old('nama_divisi')}}"

placeholder="Contoh: IT, Keuangan, Marketing"

required>


</div>









<div class="form-group">


<label>

Kepala Divisi

</label>


<input

type="text"

name="kepala_divisi"

value="{{old('kepala_divisi')}}"

placeholder="Nama kepala divisi">


</div>









<div class="form-group full">


<label>

Deskripsi Divisi

</label>


<textarea

name="deskripsi"

placeholder="Masukkan deskripsi divisi...">{{old('deskripsi')}}</textarea>


</div>









<div class="form-group">


<label>

Status Divisi

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





</div>









<div class="form-action">


<button class="btn-save">

💾 Simpan Divisi

</button>


</div>






</form>



</div>










{{-- ================= INFORMATION ================= --}}



<div class="information-grid">





<div class="information-card">



<div class="information-icon">

🏢

</div>




<div>


<h4>

Fungsi Divisi

</h4>


<p>

Data divisi digunakan untuk pengelolaan project, pembagian dana, dan monitoring aktivitas pekerjaan.

</p>


</div>


</div>







<div class="information-card">



<div class="information-icon blue">

💰

</div>




<div>


<h4>

Integrasi Sistem

</h4>


<p>

Informasi divisi terhubung dengan alokasi dana, pengajuan biaya, dan laporan keuangan perusahaan.

</p>


</div>


</div>





</div>





<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


.page-header-card,
.form-card,
.information-grid{

    width:100%;

}



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
BACK BUTTON
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    color:#334155;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

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

    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:13px 16px;

    border-radius:14px;

    margin-bottom:18px;

    font-size:12px;

}



.alert-error ul{

    margin:8px 0 0;

    padding-left:18px;

}







/* ===============================
FORM CARD
================================ */


.form-card{

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
FORM GRID
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}





.form-group.full{

    grid-column:1/-1;

}




.form-group{

    display:flex;

    flex-direction:column;

}



.form-group label{

    font-size:11px;

    font-weight:800;

    color:#475569;

    margin-bottom:7px;

}






input,
select,
textarea{


    width:100%;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    color:#172033;

    font-size:13px;

    transition:.2s;

}





input,
select{

    height:44px;

    padding:0 14px;

}



textarea{

    min-height:100px;

    padding:12px 14px;

    resize:none;

}






input:focus,
select:focus,
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

    margin-top:25px;

    padding-top:18px;

    border-top:1px solid #f1f5f9;

    display:flex;

    justify-content:flex-end;

}





.btn-save{

    background:#1e293b;

    color:white;

    border:none;

    padding:12px 26px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

    transition:.2s;

}





.btn-save:hover{

    background:#334155;

    transform:translateY(-2px);

}







/* ===============================
INFORMATION
================================ */


.information-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

    margin-top:20px;

}




.information-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    display:flex;

    gap:12px;

    align-items:center;

}




.information-icon{

    width:40px;

    height:40px;

    border-radius:12px;

    background:#dcfce7;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

}



.information-icon.blue{

    background:#dbeafe;

}




.information-card h4{

    margin:0;

    font-size:14px;

    color:#172033;

}




.information-card p{

    margin:5px 0 0;

    font-size:11px;

    line-height:1.5;

    color:#64748b;

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



.form-grid{

    grid-template-columns:1fr;

}



.information-grid{

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
