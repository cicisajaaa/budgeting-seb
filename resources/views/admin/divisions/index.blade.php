@extends('layouts.dashboard')


@section('content')


<div class="page-header">


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



<a href="{{route('admin.divisions.create')}}" class="btn-primary">

＋ Tambah Divisi

</a>


</div>





{{-- ================= STATISTIC ================= --}}


<div class="division-stat-grid">



<div class="division-stat">


<div class="stat-icon green">

🏢

</div>


<div>

<span>
Total Divisi
</span>


<h3>
{{$divisions->count()}}
</h3>


<small>
Unit organisasi aktif
</small>


</div>


</div>







<div class="division-stat">


<div class="stat-icon blue">

👥

</div>


<div>

<span>
Total Anggota
</span>


<h3>

{{$divisions->sum(function($item){
return $item->karyawan->count();
})}}

</h3>


<small>
Karyawan terdaftar
</small>


</div>


</div>







<div class="division-stat">


<div class="stat-icon orange">

📝

</div>


<div>

<span>
Total Task
</span>


<h3>

{{$divisions->sum(function($item){
return $item->tugas->count();
})}}

</h3>


<small>
Aktivitas pekerjaan
</small>


</div>


</div>



</div>









@if(session('success'))

<div class="success-alert">

✓ {{session('success')}}

</div>

@endif









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



<div class="total-data">

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


<div class="division-name">


<div class="division-icon">

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


<span class="status-active">

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

@endsection

<style>

/* ===============================
GLOBAL
================================ */

.page-header,
.division-stat-grid,
.glass-panel{

    width:100%;

}






/* ===============================
HEADER
================================ */


.page-header{

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



.page-header h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

}



.page-header p{

    margin:0;

    color:#64748b;

    font-size:14px;

}







/* ===============================
BUTTON
================================ */


.btn-primary{


    background:#1e293b;

    color:white;

    padding:13px 22px;

    border-radius:14px;

    font-size:13px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;


}



.btn-primary:hover{

    background:#334155;

    transform:translateY(-2px);

}







/* ===============================
STAT CARD
================================ */


.division-stat-grid{


    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;


}




.division-stat{


    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:16px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);


}



.stat-icon{


    width:52px;

    height:52px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:23px;

}



.stat-icon.green{

    background:#dcfce7;

}



.stat-icon.blue{

    background:#dbeafe;

}



.stat-icon.orange{

    background:#fef3c7;

}




.division-stat span{

    font-size:12px;

    color:#64748b;

}



.division-stat h3{

    margin:5px 0;

    font-size:26px;

    color:#172033;

}



.division-stat small{

    color:#94a3b8;

    font-size:11px;

}







/* ===============================
ALERT
================================ */


.success-alert{


    background:#f0fdf4;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:15px 18px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:700;

}







/* ===============================
TABLE PANEL
================================ */


.glass-panel{


    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);


}



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





.total-data{


    background:#eff6ff;

    color:#2563eb;

    padding:8px 16px;

    border-radius:999px;

    font-size:12px;

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

    padding:15px;

    text-align:left;

    font-size:12px;

    color:#64748b;


}



td{


    padding:18px 15px;

    border-bottom:1px solid #f1f5f9;

    font-size:13px;

    color:#334155;


}




tr:hover{


    background:#fafafa;


}









/* ===============================
DIVISION INFO
================================ */


.division-name{


    display:flex;

    align-items:center;

    gap:14px;


}



.division-icon{


    width:45px;

    height:45px;

    border-radius:15px;

    background:#eff6ff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:20px;


}



.division-name strong{


    display:block;

    font-size:14px;

    color:#172033;


}



.division-name small{


    display:block;

    margin-top:5px;

    color:#94a3b8;

    font-size:11px;

    max-width:220px;


}






/* ===============================
MINI INFO
================================ */


.mini-info{


    background:#f8fafc;

    padding:8px 12px;

    border-radius:12px;

    font-size:12px;

    color:#475569;

    width:max-content;


}









/* ===============================
STATUS
================================ */


.status-active{


    background:#dcfce7;

    color:#166534;

    padding:7px 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;


}








/* ===============================
ACTION
================================ */


.action{


    display:flex;

    gap:8px;


}



.action form{

    margin:0;

}




.detail,
.edit,
.delete{


    width:38px;

    height:36px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    border:none;

    cursor:pointer;

    text-decoration:none;

    font-size:15px;


}



.detail{


    background:#dcfce7;

    color:#166534;


}




.edit{


    background:#dbeafe;

    color:#2563eb;


}





.delete{


    background:#fee2e2;

    color:#dc2626;


}





.detail:hover{

    background:#166534;

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

    padding:40px;

    color:#94a3b8;


}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:1100px){


.division-stat-grid{

    grid-template-columns:repeat(2,1fr);

}


}



@media(max-width:900px){


.page-header{


    flex-direction:column;

    align-items:flex-start;

    gap:15px;


}



.division-stat-grid{


    grid-template-columns:1fr;


}


}



</style>