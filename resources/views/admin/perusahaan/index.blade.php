@extends('layouts.dashboard')


@section('content')


{{-- ================= HEADER ================= --}}


<div class="page-header-card">


<div>

<div class="page-label">
ADMINISTRASI
</div>


<h1>
Kelola Perusahaan
</h1>


<p>
Kelola data perusahaan, informasi kontak, dan project yang terhubung.
</p>


</div>



<a href="{{route('admin.perusahaan.create')}}"
class="btn-primary">

＋ Tambah Perusahaan

</a>


</div>






@if(session('success'))

<div class="success-alert">

{{session('success')}}

</div>

@endif



@if($errors->any())

<div class="alert-error">

<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>

</div>

@endif







{{-- ================= STATISTIK ================= --}}


<div class="stat-grid">



<div class="stat-card">


<div class="stat-icon">

🏢

</div>


<div>

<label>
Total Perusahaan
</label>


<h2>

{{$perusahaans->count()}}

</h2>


<small>
Perusahaan terdaftar
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon green">

✓

</div>


<div>

<label>
Perusahaan Aktif
</label>


<h2>

{{$perusahaans->where('status','aktif')->count()}}

</h2>


<small>
Status aktif
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon blue">

🏭

</div>


<div>

<label>
Perusahaan Nonaktif
</label>


<h2>

{{$perusahaans->where('status','nonaktif')->count()}}

</h2>


<small>
Status nonaktif
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon gold">

📁

</div>


<div>

<label>
Total Project
</label>


<h2>

{{$perusahaans->sum(function($item){

return $item->proyek->count();

})}}

</h2>


<small>
Project terhubung
</small>


</div>


</div>



</div>









{{-- ================= TABLE ================= --}}



<div class="glass-panel">



<div class="table-header">


<div>


<h3>
Daftar Perusahaan
</h3>


<p>
Monitoring seluruh perusahaan dalam sistem.
</p>


</div>




<div class="total-user">


{{$perusahaans->count()}}

Perusahaan


</div>


</div>








<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
No
</th>


<th>
Perusahaan
</th>


<th>
Kontak
</th>


<th>
Email
</th>


<th>
Status
</th>


<th>
Project
</th>


<th>
Aksi
</th>


</tr>


</thead>






<tbody>



@forelse($perusahaans as $perusahaan)



<tr>



<td>

{{$loop->iteration}}

</td>







<td>


<div class="user-profile">


<div class="avatar project-avatar">

🏢

</div>




<div>


<strong>

{{$perusahaan->nama_perusahaan}}

</strong>


<small>
Informasi perusahaan
</small>



</div>


</div>


</td>








<td>

{{$perusahaan->kontak ?? '-'}}

</td>







<td>

{{$perusahaan->email ?? '-'}}

</td>







<td>



@if($perusahaan->status=='aktif')


<span class="status-badge status-active">

Aktif

</span>


@else


<span class="status-badge status-nonactive">

Nonaktif

</span>


@endif



</td>







<td>


<span style="
font-weight:700;
color:#334155;
">

{{$perusahaan->proyek->count()}}

</span>

Project


</td>







<td>



<div class="action">





<a href="{{route(
'admin.perusahaan.show',
$perusahaan->id
)}}"

class="detail"

title="Detail">


👁


</a>







<a href="{{route(
'admin.perusahaan.edit',
$perusahaan->id
)}}"

class="edit"

title="Edit">


✏️


</a>








<form method="POST"

action="{{route(
'admin.perusahaan.destroy',
$perusahaan->id
)}}">


@csrf

@method('DELETE')



<button

class="delete"

onclick="
return confirm('Hapus perusahaan ini?')
"

title="Hapus">


🗑


</button>


</form>





</div>



</td>






</tr>






@empty




<tr>


<td colspan="7" class="empty">



<div class="empty-icon">

🏢

</div>



Belum ada perusahaan


<br>


<small>

Tambahkan perusahaan baru untuk memulai.

</small>



</td>


</tr>




@endforelse





</tbody>


</table>


</div>


</div>







<style>


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






/* BUTTON */


.btn-primary{

    display:flex;

    align-items:center;

    justify-content:center;

    background:#334155;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}







/* ALERT */


.success-alert{

    background:#dcfce7;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

}



.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

}








/* STAT */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    min-height:95px;

    display:flex;

    align-items:center;

    gap:14px;

    position:relative;

    overflow:hidden;

    box-shadow:
    0 5px 20px rgba(15,23,42,.05);

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.stat-card:nth-child(2)::before{

background:#16a34a;

}



.stat-card:nth-child(3)::before{

background:#2563eb;

}



.stat-card:nth-child(4)::before{

background:#f59e0b;

}



.stat-icon{

width:42px;

height:42px;

border-radius:13px;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

background:#dbeafe;

}



.stat-card:nth-child(2) .stat-icon{

background:#dcfce7;

}



.stat-card:nth-child(3) .stat-icon{

background:#ede9fe;

}



.stat-card:nth-child(4) .stat-icon{

background:#fef3c7;

}



.stat-card label{

font-size:11px;

color:#64748b;

font-weight:700;

}



.stat-card h2{

font-size:20px;

margin:5px 0;

font-weight:800;

color:#1e293b;

}



.stat-card small{

font-size:10px;

color:#94a3b8;

}








/* PANEL */


.glass-panel{

background:white;

border:1px solid #e2e8f0;

border-radius:22px;

padding:25px;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}







.table-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.table-header h3{

margin:0;

padding-left:10px;

border-left:4px solid #334155;

font-size:15px;

font-weight:800;

color:#1e293b;

}



.table-header p{

margin:5px 0;

font-size:11px;

color:#64748b;

}



.total-user{

background:#f1f5f9;

padding:7px 14px;

border-radius:999px;

font-size:11px;

font-weight:700;

}







/* TABLE */


.table-wrapper{

overflow-x:auto;

}



table{

width:100%;

border-collapse:collapse;

}



th{

padding:12px;

background:#f8fafc;

color:#64748b;

font-size:11px;

text-align:left;

}



td{

padding:13px;

border-bottom:1px solid #f1f5f9;

font-size:12px;

color:#334155;

}



tbody tr:hover{

background:#f8fafc;

}







.user-profile{

display:flex;

align-items:center;

gap:12px;

}



.avatar{

width:36px;

height:36px;

border-radius:12px;

display:flex;

justify-content:center;

align-items:center;

}



.project-avatar{

background:#dbeafe;

font-size:15px;

}



.user-profile strong{

display:block;

font-size:12px;

color:#1e293b;

}



.user-profile small{

font-size:10px;

color:#94a3b8;

}







/* BADGE */

.status-badge{

padding:5px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

display:inline-flex;

align-items:center;

}



.status-active{

background:#dcfce7;

color:#166534;

}



.status-nonactive{

background:#fee2e2;

color:#991b1b;

}




/* ACTION */


.action{

display:flex;

gap:6px;

}



.action form{

margin:0;

}



.detail,
.edit,
.delete{

width:32px;

height:32px;

border-radius:10px;

display:flex;

align-items:center;

justify-content:center;

border:none;

cursor:pointer;

text-decoration:none;

}



.detail{

background:#dcfce7;

}



.edit{

background:#dbeafe;

}



.delete{

background:#fee2e2;

}






.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}



.empty-icon{

font-size:30px;

margin-bottom:10px;

}



@media(max-width:1200px){

.stat-grid{

grid-template-columns:repeat(2,1fr);

}

}


</style>



@endsection