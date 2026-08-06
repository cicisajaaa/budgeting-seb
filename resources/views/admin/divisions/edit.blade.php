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







@if(session('success'))


<div class="alert-success">

✓ {{session('success')}}

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
HEADER CARD
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








/* BACK BUTTON */


.btn-back{


background:#f8fafc;


border:1px solid #e2e8f0;


padding:11px 20px;


border-radius:14px;


text-decoration:none;


color:#475569;


font-size:13px;


font-weight:700;


transition:.2s;


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


max-width:720px;


box-shadow:


0 15px 40px rgba(15,23,42,.06);


}








/* FORM HEADER */


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


margin-top:5px;


font-size:13px;


color:#64748b;


}









/* FORM */


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





input{


height:50px;


border-radius:14px;


border:1px solid #dbe3ef;


background:#f8fafc;


padding:0 16px;


font-size:14px;


outline:none;


transition:.2s;


}





input:focus{


background:white;


border-color:#2563eb;


box-shadow:


0 0 0 4px rgba(37,99,235,.12);


}







textarea{

    min-height:120px;

    border-radius:14px;

    border:1px solid #dbe3ef;

    background:#f8fafc;

    padding:15px;

    font-size:14px;

    resize:none;

    outline:none;

}



textarea:focus{

    background:white;

    border-color:#2563eb;

    box-shadow:
    0 0 0 4px rgba(37,99,235,.12);

}



/* BUTTON */


.form-action{


margin-top:30px;


display:flex;


justify-content:flex-end;


}





.btn-update{


background:


linear-gradient(

135deg,

#2563eb,

#3b82f6

);



border:none;


color:white;


padding:13px 30px;


border-radius:14px;


font-size:13px;


font-weight:800;


cursor:pointer;


box-shadow:


0 10px 25px rgba(37,99,235,.25);


transition:.2s;


}





.btn-update:hover{


background:#1d4ed8;


transform:translateY(-2px);


}









/* INFORMATION */


.information-card{


margin-top:25px;


background:white;


border:1px solid #e5e7eb;


border-radius:22px;


padding:22px;


display:flex;


gap:15px;


align-items:center;


max-width:720px;


box-shadow:


0 10px 25px rgba(15,23,42,.05);


}





.information-icon{


width:45px;


height:45px;


border-radius:15px;


background:#eff6ff;


display:flex;


align-items:center;


justify-content:center;


font-size:20px;


}



.information-card h4{


margin:0;


font-size:15px;


color:#172033;


}



.information-card p{


font-size:12px;


color:#64748b;


line-height:1.6;


margin-top:6px;


}








/* ALERT */


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


font-size:13px;


font-weight:700;


}








@media(max-width:800px){


.page-header-card{


flex-direction:column;


align-items:flex-start;


gap:15px;


}



}

</style>



@endsection