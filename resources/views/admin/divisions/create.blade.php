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
HEADER
================================ */


.page-header-card{


background:white;


border:1px solid #e5e7eb;


border-radius:24px;


padding:30px;


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


font-size:14px;


color:#64748b;


margin:0;


}








/* ===============================
BUTTON BACK
================================ */


.btn-back{


background:#f8fafc;


border:1px solid #e2e8f0;


padding:11px 20px;


border-radius:14px;


text-decoration:none;


color:#475569;


font-size:13px;


font-weight:700;


}



.btn-back:hover{


background:#1e293b;


color:white;


}








/* ===============================
FORM CARD
================================ */


.form-card{


background:white;


border:1px solid #e5e7eb;


border-radius:26px;


padding:35px;


box-shadow:


0 15px 40px rgba(15,23,42,.06);


}









/* ===============================
FORM HEADER
================================ */


.form-heading{


display:flex;


align-items:center;


gap:15px;


padding-bottom:22px;


margin-bottom:30px;


border-bottom:1px solid #f1f5f9;


}



.form-icon{


width:50px;


height:50px;


border-radius:16px;


background:#dbeafe;


display:flex;


align-items:center;


justify-content:center;


font-size:22px;


}





.form-heading h3{


margin:0;


font-size:18px;


font-weight:800;


color:#172033;


}





.form-heading p{


margin:5px 0 0;


font-size:13px;


color:#64748b;


}









/* ===============================
FORM
================================ */


.form-grid{


display:grid;


grid-template-columns:1fr 1fr;


gap:20px;


}



.form-group.full{


grid-column:span 2;


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






input,
select,
textarea{


border-radius:14px;


border:1px solid #dbe3ef;


background:#f8fafc;


padding:0 15px;


font-size:14px;


outline:none;


transition:.2s;


}




input,
select{


height:50px;


}



textarea{


height:120px;


padding:15px;


resize:none;


}






input:focus,
select:focus,
textarea:focus{


background:white;


border-color:#2563eb;


box-shadow:


0 0 0 4px rgba(37,99,235,.12);


}










/* ===============================
SAVE BUTTON
================================ */


.form-action{


margin-top:30px;


display:flex;


justify-content:flex-end;


}



.btn-save{


background:


linear-gradient(

135deg,

#2563eb,

#3b82f6

);



color:white;


border:none;


padding:13px 30px;


border-radius:14px;


font-size:13px;


font-weight:800;


cursor:pointer;


box-shadow:


0 10px 25px rgba(37,99,235,.25);


}



.btn-save:hover{


background:#1d4ed8;


transform:translateY(-2px);


}









/* ===============================
INFORMATION CARD
================================ */


.information-grid{


display:grid;


grid-template-columns:1fr 1fr;


gap:20px;


margin-top:25px;


}



.information-card{


background:white;


border:1px solid #e5e7eb;


border-radius:22px;


padding:22px;


display:flex;


gap:15px;


box-shadow:


0 10px 25px rgba(15,23,42,.05);


}



.information-icon{


width:45px;


height:45px;


border-radius:15px;


background:#dcfce7;


display:flex;


align-items:center;


justify-content:center;


font-size:20px;


}



.information-icon.blue{


background:#dbeafe;


}



.information-card h4{


margin:0;


font-size:15px;


color:#172033;


}



.information-card p{


margin-top:7px;


font-size:12px;


line-height:1.6;


color:#64748b;


}









/* ===============================
ALERT
================================ */


.alert-error{


background:#fef2f2;


border:1px solid #fecaca;


color:#991b1b;


padding:15px;


border-radius:16px;


margin-bottom:20px;


font-size:13px;


}



.alert-error ul{


padding-left:20px;


}





.alert-success{


background:#f0fdf4;


border:1px solid #bbf7d0;


color:#166534;


padding:15px;


border-radius:16px;


margin-bottom:20px;


font-weight:700;


}









@media(max-width:800px){


.page-header-card{


flex-direction:column;


align-items:flex-start;


gap:15px;


}



.form-grid{


grid-template-columns:1fr;


}



.form-group.full{


grid-column:auto;


}



.information-grid{


grid-template-columns:1fr;


}


}



</style>



@endsection
