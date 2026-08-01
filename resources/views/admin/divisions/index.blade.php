@extends('layouts.dashboard')


@section('content')



<div class="page-header">


<div>


<div class="page-label">
ORGANIZATION MANAGEMENT
</div>


<h1>
Kelola Divisi
</h1>


<p>
Kelola struktur organisasi dan unit kerja perusahaan.
</p>


</div>




<a href="{{route('admin.divisions.create')}}" class="btn-primary">

＋ Tambah Divisi

</a>



</div>









<!-- STATISTIC -->


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
Unit organisasi
</small>


</div>


</div>








<div class="division-stat">


<div class="stat-icon blue">

📁

</div>


<div>


<span>
Penggunaan
</span>


<h3>
Project
</h3>


<small>
Terhubung dengan project perusahaan
</small>


</div>


</div>








<div class="division-stat">


<div class="stat-icon orange">

💰

</div>


<div>


<span>
Fungsi
</span>


<h3>
Dana
</h3>


<small>
Digunakan untuk alokasi keuangan
</small>


</div>


</div>



</div>









@if(session('success'))


<div class="success-alert">

<div>
✓
</div>


{{session('success')}}


</div>


@endif







<!-- TABLE -->


<div class="glass-panel">



<div class="table-header">


<div>


<h3>
Daftar Divisi
</h3>


<p>
Daftar unit organisasi perusahaan.
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
Nama Divisi
</th>


<th>
Dibuat
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
Unit perusahaan
</small>


</div>



</div>


</td>








<td>


{{\Carbon\Carbon::parse($division->created_at)->format('d M Y')}}


</td>








<td>


<div class="action">



<a href="{{route('admin.divisions.edit',$division->id)}}"

class="edit">


Edit

</a>







<form method="POST"

action="{{route('admin.divisions.destroy',$division->id)}}">


@csrf

@method('DELETE')



<button

class="delete"

onclick="return confirm('Hapus divisi ini?')">


Hapus


</button>


</form>



</div>


</td>




</tr>





@empty


<tr>


<td colspan="4" class="empty">


<div class="empty-icon">
🏢
</div>


Belum ada divisi


<br>


<small>
Tambahkan unit organisasi baru.
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
GLOBAL WIDTH
================================ */

.page-header,
.division-stat-grid,
.glass-panel{

    width:100%;

}



/* ===============================
HEADER CARD
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
STATISTIC
================================ */


.division-stat-grid{


    display:grid;


    grid-template-columns:
    repeat(3,1fr);


    gap:18px;


    margin-bottom:25px;


}






.division-stat{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:22px;


    padding:22px;


    min-height:105px;


    display:flex;


    align-items:center;


    gap:16px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.05);


}






.stat-icon{


    width:50px;


    height:50px;


    border-radius:16px;


    display:flex;


    align-items:center;


    justify-content:center;


    font-size:22px;


    flex-shrink:0;


}



.stat-icon.green{

    background:#dcfce7;

}



.stat-icon.blue{

    background:#dbeafe;

}



.stat-icon.orange{

    background:#ede9fe;

}





.division-stat span{


    font-size:12px;


    color:#64748b;


}



.division-stat h3{


    margin:5px 0;


    font-size:25px;


    color:#172033;


}



.division-stat small{


    font-size:11px;


    color:#94a3b8;


}








/* ===============================
TABLE CARD
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


    width:100%;


    overflow-x:auto;


}



table{


    width:100%;


    border-collapse:collapse;


    table-layout:fixed;


}





th{


    padding:16px 18px;


    background:#f8fafc;


    color:#64748b;


    font-size:12px;


    text-align:left;


}



td{


    padding:18px;


    font-size:13px;


    color:#334155;


    border-bottom:1px solid #f1f5f9;


}





tr:hover{


    background:#f8fafc;


}








/* ===============================
COLUMN WIDTH
================================ */


th:nth-child(1),
td:nth-child(1){

    width:8%;

}



th:nth-child(2),
td:nth-child(2){

    width:45%;

}



th:nth-child(3),
td:nth-child(3){

    width:25%;

}



th:nth-child(4),
td:nth-child(4){

    width:22%;

}









/* ===============================
DIVISION PROFILE
================================ */


.division-name{


    display:flex;


    align-items:center;


    gap:15px;


}



.division-icon{


    width:42px;


    height:42px;


    border-radius:14px;


    background:#eff6ff;


    display:flex;


    align-items:center;


    justify-content:center;


    flex-shrink:0;


}





.division-name strong{


    display:block;


    color:#172033;


    font-size:14px;


}



.division-name small{


    color:#94a3b8;


    font-size:11px;


}










/* ===============================
ACTION
================================ */


.action{


    display:flex;


    gap:10px;


    justify-content:flex-start;


}



.action form{


    display:inline;


}





.edit,
.delete{


    padding:8px 15px;


    border-radius:12px;


    font-size:12px;


    font-weight:700;


    border:none;


    cursor:pointer;


    text-decoration:none;


}





.edit{


    background:#dbeafe;


    color:#2563eb;


}



.edit:hover{


    background:#2563eb;


    color:white;


}





.delete{


    background:#fee2e2;


    color:#dc2626;


}



.delete:hover{


    background:#dc2626;


    color:white;


}









/* ===============================
SUCCESS
================================ */


.success-alert{


    background:#f0fdf4;


    border:1px solid #bbf7d0;


    color:#166534;


    padding:15px 18px;


    border-radius:16px;


    margin-bottom:20px;


    display:flex;


    gap:10px;


    font-size:13px;


    font-weight:700;


}









/* ===============================
EMPTY
================================ */


.empty{


    text-align:center;


    padding:45px;


    color:#64748b;


}



.empty-icon{


    font-size:35px;


    margin-bottom:10px;


}



.empty small{


    color:#94a3b8;


}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.division-stat-grid{


    grid-template-columns:1fr;


}



.page-header{


    flex-direction:column;


    align-items:flex-start;


    gap:15px;


}



table{


    table-layout:auto;


}



}

</style>
@endsection