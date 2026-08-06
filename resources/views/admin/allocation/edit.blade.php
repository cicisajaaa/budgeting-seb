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


.page-header-card{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:30px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

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

}



.page-header-card p{

color:#64748b;

font-size:14px;

margin:0;

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

}





.project-summary{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

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

align-items:center;

justify-content:center;

font-size:25px;

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

font-size:28px;

margin:5px 0;

color:#166534;

}





.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:30px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

max-width:700px;

}



.panel-title{

font-size:18px;

font-weight:800;

margin-bottom:25px;

color:#172033;

}





.form-group{

display:flex;

flex-direction:column;

margin-bottom:20px;

}



.form-group label{

font-size:13px;

font-weight:700;

color:#475569;

margin-bottom:8px;

}





select,
input{

height:48px;

border-radius:14px;

border:1px solid #dbe1e8;

background:#f8fafc;

padding:0 15px;

font-size:14px;

}





select:focus,
input:focus{

outline:none;

border-color:#2563eb;

background:white;

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

padding:0 18px;

background:#f1f5f9;

border-radius:0 14px 14px 0;

font-weight:700;

}





.form-action{

display:flex;

justify-content:flex-end;

margin-top:25px;

}





.btn-save{

border:none;

background:#1e293b;

color:white;

padding:13px 25px;

border-radius:14px;

font-weight:800;

cursor:pointer;

}



.btn-save:hover{

background:#2563eb;

}





@media(max-width:800px){


.page-header-card,
.project-summary{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}

</style>


@endsection