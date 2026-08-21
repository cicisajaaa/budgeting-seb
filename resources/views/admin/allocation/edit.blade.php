@extends('layouts.dashboard')


@section('content')



<div class="page-header-card">


<div>

<div class="page-label">
PENGATURAN PEMBAGIAN DANA
</div>


<h1>
Edit Pembagian Dana
</h1>


<p>
Perbarui distribusi anggaran project berdasarkan kebutuhan divisi.
</p>


</div>



<a href="{{route('admin.allocation.index',$project->id)}}" 
class="btn-back">

← Kembali

</a>


</div>







<div class="project-summary">


<div class="project-info">


<div class="project-icon">

📁

</div>


<div>

<span>
Project
</span>


<h2>
{{$project->nama_proyek}}
</h2>


</div>


</div>





<div class="budget-status">


<span>
Alokasi Saat Ini
</span>


<h2>
{{$allocation->persentase}} %
</h2>


</div>



</div>









<div class="glass-panel">


<div class="panel-title">

✏️ Edit Pembagian Dana

</div>





<form method="POST"

action="{{route('admin.allocation.update',$allocation->id)}}">


@csrf

@method('PUT')





<div class="form-group">


<label>
Pilih Divisi
</label>



<select name="divisi_id" required>


<option value="">
-- Pilih Divisi --
</option>



@foreach($divisions as $division)


<option value="{{$division->id}}"

{{$allocation->divisi_id == $division->id ? 'selected':''}}

>

{{$division->nama_divisi}}

</option>


@endforeach


</select>


</div>








<div class="form-group">


<label>
Persentase Dana
</label>



<div class="percent-input">


<input

type="number"

name="persentase"

value="{{$allocation->persentase}}"

min="1"

max="100"

required>


<span>
%
</span>


</div>


</div>









<div class="form-action">


<button class="btn-save">

💾 Simpan Perubahan

</button>


</div>







</form>


</div>








<style>

/* ===============================
GLOBAL
================================ */

.page-header-card,
.project-summary,
.glass-panel{

    width:100%;

}


/* ===============================
HEADER
================================ */


.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px 32px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.page-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    font-size:30px;

    margin:10px 0;

    color:#1e293b;

    font-weight:800;

}



.page-header-card p{

    margin:0;

    font-size:14px;

    color:#64748b;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:11px 22px;

    border-radius:14px;

    color:#334155;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

}








/* ===============================
PROJECT SUMMARY
================================ */


.project-summary{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:28px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

    position:relative;

    overflow:hidden;

}



.project-summary::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}





.project-info{

    display:flex;

    align-items:center;

    gap:15px;

}





.project-icon{

    width:55px;

    height:55px;

    border-radius:16px;

    background:#f1f5f9;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:24px;

}






.project-info span,
.budget-status span{

    font-size:12px;

    color:#64748b;

}





.project-info h2{

    margin:5px 0;

    font-size:22px;

    color:#172033;

}







.budget-status h2{

    margin-top:5px;

    font-size:28px;

    color:#334155;

}







/* ===============================
FORM CARD
================================ */


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


.form-group{

    display:flex;

    flex-direction:column;

    margin-bottom:22px;

}





.form-group label{

    font-size:12px;

    font-weight:800;

    color:#475569;

    margin-bottom:8px;

}





.form-group select,
.form-group input{


    height:46px;

    width:100%;

    border-radius:14px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:0 15px;

    font-size:13px;

    color:#172033;

    transition:.2s;

}




.form-group select:focus,
.form-group input:focus{


    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.12);

}








/* ===============================
PERCENT INPUT
================================ */


.percent-input{

    display:flex;

}



.percent-input input{

    flex:1;

    border-radius:14px 0 0 14px;

}





.percent-input span{

    width:55px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#f1f5f9;

    border:1px solid #dbe1e8;

    border-left:none;

    border-radius:0 14px 14px 0;

    font-weight:800;

    color:#475569;

}








/* ===============================
BUTTON
================================ */


.form-action{

    margin-top:30px;

    padding-top:20px;

    border-top:1px solid #e2e8f0;

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


@media(max-width:800px){


.page-header-card,
.project-summary{


    flex-direction:column;

    align-items:flex-start;

    gap:20px;

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