@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->

<div class="page-header-card">

<div>


<div class="page-label">
PENGATURAN PEMBAGIAN DANA
</div>


<h1>

Pengaturan Pembagian Dana

</h1>


<p>

Atur distribusi anggaran project berdasarkan kebutuhan divisi.

</p>


</div>




<a href="{{route('admin.projects.index')}}" class="btn-back">

← Kembali 

</a>


</div>








<!-- PROJECT SUMMARY -->


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

Total Pembagian

</span>


<h2>

{{$allocations->sum('persentase')}} %

</h2>


<div class="progress-track">


<div style="width:{{$allocations->sum('persentase')}}%">

</div>


</div>


</div>



</div>









@if($allocations->sum('persentase') == 100)


<div class="success-alert">

✓ Pembagian dana sudah lengkap (100%)

</div>



@else



<div class="warning-alert">

⚠ Pembagian dana belum mencapai 100%.

<br>

Saat ini:

<b>{{$allocations->sum('persentase')}}%</b>

</div>



@endif











@if(session('error'))


<div class="error-alert">

{{session('error')}}

</div>


@endif







<!-- FORM -->


<div class="glass-panel">


<div class="panel-title">

💰 Tambah Pembagian Dana

</div>





<form method="POST"

action="{{route('admin.allocation.store',$project->id)}}">


@csrf





<div class="allocation-form">





<div class="form-group">


<label>

Pilih Divisi

</label>


<select name="divisi_id" required>


<option value="">
-- Pilih Divisi --
</option>


@forelse($divisions as $division)


<option value="{{$division->id}}">

{{$division->nama_divisi}}

</option>


@empty


<option disabled>

Belum ada divisi

</option>


@endforelse


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

placeholder="Contoh 30"

max="100"

required>


<span>

%

</span>


</div>


</div>







<button class="btn-save">

＋ Tambahkan

</button>



</div>






</form>


</div>









<!-- TABLE -->


<div class="glass-panel">



<div class="table-header">


<div>


<h3>

Daftar Pembagian Dana

</h3>


<p>

Distribusi budget ke masing-masing divisi.

</p>


</div>



<div class="total-project">

{{$allocations->count()}} Divisi

</div>


</div>







<div class="table-wrapper">


<table>



<thead>


<tr>


<th>

Divisi

</th>


<th>

Persentase

</th>


<th>

Status

</th>


<th>

Aksi

</th>


</tr>


</thead>




<tbody>



@forelse($allocations as $allocation)



<tr>



<td>


<div class="division-name">


<div>

🏢

</div>

{{$allocation->divisi->nama_divisi ?? '-'}}


</div>


</td>






<td>


<span class="percentage">

{{$allocation->persentase}} %

</span>


</td>






<td>


<span class="allocated">

Teralokasi

</span>


</td>





<td>
<div class="action">


<a href="{{route('admin.allocation.edit',$allocation->id)}}"

class="action-edit"
title="Edit">

✏️

</a>




<form method="POST"

action="{{route('admin.allocation.destroy',$allocation->id)}}">


@csrf

@method('DELETE')


<button

class="action-delete"

onclick="return confirm('Hapus pembagian dana ini?')"

title="Hapus">

🗑️

</button>


</form>


</div>

</td>


</tr>



@empty


<tr>

<td colspan="4" class="empty">

Belum ada pembagian dana

</td>

</tr>


@endforelse



</tbody>



</table>


</div>


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

    font-size:24px;

    font-weight:800;

    color:#172033;

}


.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:12px;

}





.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    color:#334155;

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
PROJECT SUMMARY
================================ */


.project-summary{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px 25px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

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

    gap:14px;

}


.project-icon{

    width:48px;

    height:48px;

    border-radius:15px;

    background:#f1f5f9;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:22px;

}



.project-info span,
.budget-status span{

    color:#64748b;

    font-size:11px;

}



.project-info h2{

    margin:4px 0;

    font-size:19px;

    color:#172033;

}





.budget-status{

    width:240px;

}


.budget-status h2{

    margin:5px 0 10px;

    font-size:23px;

    color:#172033;

}







.progress-track{

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}


.progress-track div{

    height:100%;

    background:#334155;

    border-radius:20px;

}






/* ===============================
ALERT
================================ */

.success-alert,
.warning-alert,
.error-alert{

    padding:14px 16px;

    border-radius:14px;

    margin-bottom:18px;

    font-size:12px;

    font-weight:700;

}


.success-alert{

    background:#dcfce7;

    border:1px solid #bbf7d0;

    color:#166534;

}


.warning-alert{

    background:#fef3c7;

    border:1px solid #fde68a;

    color:#92400e;

}


.error-alert{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

}





/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    margin-bottom:20px;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:18px;

}







/* ===============================
FORM
================================ */


.allocation-form{

    display:grid;

    grid-template-columns:2fr 1fr auto;

    gap:15px;

    align-items:end;

}



.form-group{

    display:flex;

    flex-direction:column;

}



.form-group label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



.form-group select,
.form-group input{

    height:42px;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:0 14px;

    font-size:12px;

}



.form-group select:focus,
.form-group input:focus{

    outline:none;

    background:white;

    border-color:#334155;

}





.percent-input{

    display:flex;

}



.percent-input input{

    flex:1;

    border-radius:12px 0 0 12px;

}



.percent-input span{

    width:40px;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#f1f5f9;

    border-radius:0 12px 12px 0;

    font-size:12px;

    font-weight:800;

}





.btn-save{

    height:42px;

    padding:0 22px;

    background:#334155;

    color:white;

    border:none;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.btn-save:hover{

    background:#1e293b;

}







/* ===============================
TABLE
================================ */


.table-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

}



.table-header h3{

    margin:0;

    font-size:16px;

    color:#172033;

}



.table-header p{

    margin:5px 0;

    font-size:12px;

    color:#64748b;

}



.total-project{

    background:#f1f5f9;

    padding:6px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}





table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:12px;

    color:#64748b;

    font-size:11px;

    text-align:left;

}



td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

}



tr:hover{

    background:#fafafa;

}






.division-name{

    display:flex;

    align-items:center;

    gap:10px;

    font-weight:700;

    color:#172033;

}




.percentage,
.allocated{

    display:inline-flex;

    padding:6px 12px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.percentage{

    background:#dcfce7;

    color:#166534;

}



.allocated{

    background:#dbeafe;

    color:#1d4ed8;

}


/* ===============================
ACTION BUTTON
================================ */


.action{

    display:flex;

    gap:8px;

    align-items:center;

}



.action form{

    margin:0;

}



.action-edit,
.action-delete{


    width:34px;

    height:34px;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

    text-decoration:none;

    border:none;

    cursor:pointer;

    font-size:14px;

    transition:.2s;

}





.action-edit{

    background:#dbeafe;

    color:#2563eb;

}



.action-edit:hover{

    background:#2563eb;

    color:white;

}





.action-delete{

    background:#fee2e2;

    color:#dc2626;

}



.action-delete:hover{

    background:#dc2626;

    color:white;

}


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

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



.project-summary{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



.budget-status{

    width:100%;

}



.allocation-form{

    grid-template-columns:1fr;

}



.action{

    flex-direction:column;

}


}

</style>
@endsection