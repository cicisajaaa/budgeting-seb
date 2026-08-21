@extends('layouts.dashboard')

@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
ORGANIZATION MANAGEMENT
</div>


<h1>
Manajemen Divisi
</h1>


<p>
Kelola struktur organisasi, anggota, tugas, dan aktivitas setiap unit perusahaan.
</p>


</div>



<a href="{{route('admin.divisions.create')}}" 
class="btn-primary">

＋ Tambah Divisi

</a>


</div>





@if(session('success'))

<div class="success-alert">

{{session('success')}}

</div>

@endif





{{-- STATISTIC --}}


<div class="stat-grid">



<div class="stat-card">


<div class="stat-icon">
🏢
</div>


<div>

<label>
Total Divisi
</label>


<h2>
{{$divisions->count()}}
</h2>


<small>
Unit organisasi aktif
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon">
👥
</div>


<div>

<label>
Total Anggota
</label>


<h2>

{{$divisions->sum(function($item){
return $item->karyawan->count();
})}}

</h2>


<small>
Karyawan terdaftar
</small>


</div>


</div>







<div class="stat-card">


<div class="stat-icon">
📝
</div>


<div>

<label>
Total Task
</label>


<h2>

{{$divisions->sum(function($item){
return $item->tugas->count();
})}}

</h2>


<small>
Aktivitas pekerjaan
</small>


</div>


</div>



</div>









<div class="glass-panel">


<div class="table-header">


<div>

<h3>
Daftar Divisi Perusahaan
</h3>


<p>
Monitoring unit organisasi dan aktivitas kerja.
</p>


</div>



<div class="total-user">

{{$divisions->count()}} Divisi

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
Informasi Divisi
</th>


<th>
Anggota
</th>


<th>
Task
</th>


<th>
Project
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


@forelse($divisions as $division)



<tr>


<td>

{{$loop->iteration}}

</td>





<td>


<div class="user-profile">


<div class="avatar">

🏢

</div>



<div>

<strong>

{{$division->nama_divisi}}

</strong>


<small>

{{$division->deskripsi ?? 'Unit organisasi perusahaan'}}

</small>


</div>


</div>


</td>





<td>

<div class="mini-info">

👥

{{$division->karyawan->count()}}

Orang

</div>

</td>





<td>

<div class="mini-info">

📝

{{$division->tugas->count()}}

Task

</div>

</td>





<td>

<div class="mini-info">

📁

{{$division->alokasiProyekDivisi->count()}}

Project

</div>

</td>





<td>

<span class="role karyawan">

Aktif

</span>

</td>





<td>


<div class="action">


<a href="{{route('admin.divisions.show',$division->id)}}"

class="detail">

👁

</a>




<a href="{{route('admin.divisions.edit',$division->id)}}"

class="edit">

✏️

</a>




<form method="POST"

action="{{route('admin.divisions.destroy',$division->id)}}">


@csrf

@method('DELETE')


<button class="delete"

onclick="return confirm('Hapus divisi ini?')">

🗑

</button>


</form>


</div>


</td>


</tr>




@empty


<tr>

<td colspan="7" class="empty">

Belum ada divisi

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

*{
    box-sizing:border-box;
}


.page-header-card,
.stat-grid,
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

    padding:24px 28px;

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

    font-size:25px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* ===============================
BUTTON
================================ */


.btn-primary{

    background:#1e293b;

    color:white;

    padding:11px 20px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    transition:.2s;

}



.btn-primary:hover{

    background:#334155;

    transform:translateY(-2px);

}







/* ===============================
STATISTIC
================================ */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin-bottom:20px;

}




.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:12px;

    position:relative;

    overflow:hidden;

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:3px;

    background:#334155;

}




.stat-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

}



.stat-card label{

    font-size:10px;

    color:#64748b;

    font-weight:700;

}



.stat-card h2{

    margin:4px 0;

    font-size:23px;

    color:#172033;

    font-weight:800;

}



.stat-card small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
ALERT
================================ */


.success-alert{

    background:#f0fdf4;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:13px 16px;

    border-radius:14px;

    margin-bottom:18px;

    font-size:12px;

    font-weight:700;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}







.table-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;

}



.table-header h3{

    margin:0;

    padding-left:10px;

    border-left:4px solid #334155;

    font-size:16px;

    font-weight:800;

    color:#172033;

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







/* ===============================
TABLE
================================ */


.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:12px;

    text-align:left;

    font-size:10px;

    color:#64748b;

}



td{

    padding:13px;

    font-size:12px;

    border-bottom:1px solid #f1f5f9;

}



tbody tr:hover{

    background:#fafafa;

}







/* ===============================
PROFILE
================================ */


.user-profile{

    display:flex;

    align-items:center;

    gap:10px;

}



.avatar{

    width:38px;

    height:38px;

    border-radius:12px;

    background:#334155;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:16px;

    font-weight:800;

}



.user-profile strong{

    display:block;

    font-size:12px;

    color:#172033;

}



.user-profile small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
MINI INFO
================================ */


.mini-info{

    background:#f8fafc;

    padding:6px 10px;

    border-radius:10px;

    font-size:11px;

    color:#475569;

    width:max-content;

}







/* ===============================
STATUS
================================ */


.role{

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.role.karyawan{

    background:#dcfce7;

    color:#166534;

}







/* ===============================
ACTION BUTTON
================================ */


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

    font-size:13px;

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



.detail:hover{

    background:#16a34a;

    color:white;

}



.edit:hover{

    background:#2563eb;

    color:white;

}



.delete:hover{

    background:#dc2626;

    color:white;

}







/* ===============================
EMPTY
================================ */


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

    font-size:12px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){

.stat-grid{

    grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:700px){


.stat-grid{

    grid-template-columns:1fr;

}


.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.btn-primary{

    width:100%;

    text-align:center;

}


.table-header{

    flex-direction:column;

    align-items:flex-start;

    gap:12px;

}


}

</style>


@endsection