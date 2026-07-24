@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->


<div class="page-header">


<div>


<div class="page-label">

FINANCIAL MANAGEMENT

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


/* HEADER */


.page-header{


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}



.page-label{


font-size:10px;


letter-spacing:2px;


font-weight:800;


color:#94a3b8;


}



.page-header h1{


font-size:26px;


color:#166534;


margin:5px 0;


}



.page-header p{


font-size:13px;


color:#64748b;


}





.btn-back{


background:white;


border:1px solid #e5e7eb;


padding:10px 18px;


border-radius:12px;


font-size:13px;


font-weight:600;


text-decoration:none;


color:#475569;


}








/* SUMMARY */


.project-summary{


background:

linear-gradient(

135deg,

#166534,

#22c55e

);



border-radius:22px;


padding:25px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:20px;


}





.project-info{


display:flex;


align-items:center;


gap:15px;


}




.project-icon{


width:50px;


height:50px;


background:white;


color:#166534;


border-radius:15px;


display:flex;


align-items:center;


justify-content:center;


font-size:22px;


}





.project-info span,


.budget-status span{


font-size:12px;


opacity:.8;


}



.project-info h2{


font-size:22px;


}







.budget-status{


width:250px;


}



.budget-status h2{


font-size:28px;


margin:5px 0;


}



.progress-track{


height:8px;


background:rgba(255,255,255,.3);


border-radius:20px;


overflow:hidden;


}



.progress-track div{


height:100%;


background:white;


border-radius:20px;


}








/* ALERT */


.success-alert,


.warning-alert,


.error-alert{


padding:14px 18px;


border-radius:15px;


margin-bottom:18px;


font-size:13px;


font-weight:600;


}



.success-alert{


background:#dcfce7;


color:#166534;


}



.warning-alert{


background:#fef3c7;


color:#92400e;


}



.error-alert{


background:#fee2e2;


color:#991b1b;


}









/* CARD */


.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);


border-radius:22px;


padding:22px;


border:

1px solid rgba(255,255,255,.8);


box-shadow:

0 15px 35px rgba(15,23,42,.06);


margin-bottom:20px;


}



.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:20px;


}







/* FORM */


.allocation-form{


display:grid;


grid-template-columns:

2fr 1fr auto;


gap:15px;


align-items:end;


}




.form-group{


display:flex;


flex-direction:column;


}



.form-group label{


font-size:12px;


font-weight:600;


margin-bottom:7px;


color:#475569;


}





select,


input{


height:45px;


border-radius:12px;


border:1px solid #e2e8f0;


background:#f8fafc;


padding:0 14px;


font-size:13px;


}



.percent-input{


display:flex;


}



.percent-input input{


width:100%;


border-radius:12px 0 0 12px;


}



.percent-input span{


display:flex;


align-items:center;


padding:0 14px;


background:#dcfce7;


color:#166534;


font-weight:700;


border-radius:0 12px 12px 0;


}







.btn-save{


height:45px;


padding:0 22px;


border:none;


border-radius:12px;


background:

linear-gradient(

135deg,

#166534,

#22c55e

);



color:white;


font-weight:700;


cursor:pointer;


}







/* TABLE */


table{


width:100%;


border-collapse:collapse;


}



th{


background:#f8fafc;


padding:14px;


font-size:11px;


color:#64748b;


text-align:left;


}



td{


padding:14px;


font-size:13px;


border-bottom:1px solid #f1f5f9;


}



tr:hover{


background:#f0fdf4;


}






.division-name{


display:flex;


align-items:center;


gap:10px;


font-weight:600;


color:#166534;


}




.percentage{


background:#dcfce7;


color:#166534;


padding:6px 14px;


border-radius:20px;


font-weight:700;


font-size:12px;


}



.allocated{


background:#dbeafe;


color:#1d4ed8;


padding:6px 12px;


border-radius:20px;


font-size:11px;


font-weight:600;


}




.delete{


border:none;


background:#fee2e2;


color:#dc2626;


padding:8px 13px;


border-radius:10px;


font-size:12px;


font-weight:600;


cursor:pointer;


}



.empty{


text-align:center;


padding:30px;


color:#64748b;


}





@media(max-width:900px){


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