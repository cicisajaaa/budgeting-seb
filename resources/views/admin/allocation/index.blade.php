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

← Kembali Project

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







@if(session('success'))


<div class="success-alert">

✓ {{session('success')}}

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


<form method="POST"

action="{{route('admin.allocation.destroy',$allocation->id)}}">


@csrf

@method('DELETE')



<button

class="delete"

onclick="return confirm('Hapus pembagian dana ini?')">

Hapus

</button>



</form>


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

    font-size:14px;

    color:#64748b;

}






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
PROJECT SUMMARY
================================ */


.project-summary{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:25px;


    display:flex;


    justify-content:space-between;


    align-items:center;


    margin-bottom:22px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


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


    color:#64748b;


    font-size:12px;


}





.project-info h2{


    margin-top:5px;


    color:#172033;


    font-size:22px;


}








.budget-status{


    width:250px;


}





.budget-status h2{


    font-size:28px;


    margin:5px 0;


    color:#172033;


}








.progress-track{


    height:10px;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}





.progress-track div{


    height:100%;


    background:#22c55e;


    border-radius:20px;


}









/* ===============================
ALERT
================================ */


.success-alert,
.warning-alert,
.error-alert{


    padding:14px 18px;


    border-radius:16px;


    margin-bottom:18px;


    font-size:13px;


    font-weight:700;


}



.success-alert{


    background:#f0fdf4;


    border:1px solid #bbf7d0;


    color:#166534;


}



.warning-alert{


    background:#fffbeb;


    border:1px solid #fde68a;


    color:#92400e;


}



.error-alert{


    background:#fef2f2;


    border:1px solid #fecaca;


    color:#991b1b;


}









/* ===============================
PANEL CARD
================================ */


.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:25px;


    margin-bottom:22px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


}



.panel-title{


    font-size:17px;


    font-weight:800;


    color:#172033;


    margin-bottom:22px;


}









/* ===============================
FORM
================================ */


.allocation-form{


    display:grid;


    grid-template-columns:2fr 1fr auto;


    gap:18px;


    align-items:end;


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






select,
input{


    height:46px;


    border-radius:14px;


    border:1px solid #dbe1e8;


    background:#f8fafc;


    padding:0 14px;


    font-size:14px;


    outline:none;


}





select:focus,
input:focus{


    background:white;


    border-color:#2563eb;


    box-shadow:


    0 0 0 3px rgba(37,99,235,.12);


}









.percent-input{


    display:flex;


}





.percent-input input{


    flex:1;


    border-radius:14px 0 0 14px;


}





.percent-input span{


    display:flex;


    align-items:center;


    padding:0 16px;


    background:#f1f5f9;


    color:#475569;


    font-weight:800;


    border-radius:0 14px 14px 0;


}








.btn-save{


    height:46px;


    padding:0 25px;


    border:none;


    border-radius:14px;


    background:#1e293b;


    color:white;


    font-weight:800;


    cursor:pointer;


    transition:.2s;


}





.btn-save:hover{


    background:#2563eb;


}









/* ===============================
TABLE
================================ */


.table-header{


    display:flex;


    justify-content:space-between;


    align-items:center;


    margin-bottom:20px;


}





.table-header h3{


    margin:0;


    font-size:18px;


    color:#172033;


}





.table-header p{


    margin-top:5px;


    font-size:13px;


    color:#64748b;


}





.total-project{


    background:#f1f5f9;


    color:#334155;


    padding:8px 16px;


    border-radius:999px;


    font-size:12px;


    font-weight:700;


}








table{


    width:100%;


    border-collapse:collapse;


}





th{


    background:#f8fafc;


    padding:14px;


    text-align:left;


    color:#64748b;


    font-size:12px;


}





td{


    padding:15px;


    border-bottom:1px solid #e5e7eb;


    font-size:13px;


}






tr:hover{


    background:#fafafa;


}









.division-name{


    display:flex;


    align-items:center;


    gap:10px;


    color:#172033;


    font-weight:700;


}









.percentage{


    background:#dcfce7;


    color:#166534;


    padding:7px 14px;


    border-radius:999px;


    font-size:12px;


    font-weight:800;


}








.allocated{


    background:#dbeafe;


    color:#1d4ed8;


    padding:7px 14px;


    border-radius:999px;


    font-size:12px;


    font-weight:700;


}









.delete{


    border:none;


    background:#fee2e2;


    color:#dc2626;


    padding:8px 14px;


    border-radius:12px;


    font-size:12px;


    font-weight:700;


    cursor:pointer;


}



.delete:hover{


    background:#dc2626;


    color:white;


}








.empty{


    text-align:center;


    padding:30px;


    color:#94a3b8;


}









@media(max-width:900px){


.page-header-card{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}





.project-summary{


    flex-direction:column;


    align-items:flex-start;


    gap:20px;


}





.allocation-form{


    grid-template-columns:1fr;


}



}

</style>

@endsection