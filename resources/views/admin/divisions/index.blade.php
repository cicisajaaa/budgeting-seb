@extends('layouts.dashboard')


@section('content')



<!-- HEADER -->


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

{{count($divisions)}}

</h3>


<small>

Unit organisasi

</small>


</div>


</div>








<div class="division-stat">


<div class="stat-icon blue">

👥

</div>


<div>


<span>

Status

</span>


<h3>

Aktif

</h3>


<small>

Struktur berjalan

</small>


</div>


</div>








<div class="division-stat">


<div class="stat-icon orange">

📊

</div>


<div>


<span>

Alokasi Dana

</span>


<h3>

{{$divisions->count()}}

</h3>


<small>

Divisi tersedia

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

Manajemen unit organisasi perusahaan.

</p>


</div>




<div class="total-data">

{{count($divisions)}} Divisi

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

Unit perusahaan

</small>


</div>



</div>


</td>








<td>


<span class="status">


<span></span>

Aktif

</span>


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


Belum ada divisi


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




.btn-primary{


background:

linear-gradient(

135deg,

#166534,

#22c55e

);



color:white;


padding:

12px 20px;



border-radius:14px;


font-size:13px;


font-weight:700;


text-decoration:none;


box-shadow:

0 12px 30px rgba(34,197,94,.25);


}








/* STAT */


.division-stat-grid{


display:grid;


grid-template-columns:

repeat(3,1fr);



gap:18px;


margin-bottom:22px;


}





.division-stat{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);



border:

1px solid rgba(255,255,255,.8);



border-radius:20px;



padding:18px;



display:flex;


align-items:center;


gap:15px;


}




.stat-icon{


width:45px;


height:45px;


border-radius:15px;


display:flex;


align-items:center;


justify-content:center;


font-size:20px;


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


font-size:11px;


color:#64748b;


display:block;


}




.division-stat h3{


font-size:23px;


color:#166534;


margin-top:3px;


}





.division-stat small{


font-size:11px;


color:#94a3b8;


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



}



.table-header{


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:18px;


}



.table-header h3{


font-size:16px;


}



.table-header p{


font-size:12px;


color:#64748b;


}



.total-data{


background:#dcfce7;


color:#166534;


padding:

7px 15px;


border-radius:20px;


font-size:12px;


font-weight:700;


}









/* TABLE */


table{


width:100%;


border-collapse:collapse;


}



th{


padding:14px;


background:#f8fafc;


font-size:11px;


color:#64748b;


text-align:left;


}



td{


padding:14px;


font-size:13px;


border-bottom:

1px solid #f1f5f9;


}





tr:hover{


background:

rgba(220,252,231,.35);


}







/* DIVISION */


.division-name{


display:flex;


align-items:center;


gap:12px;


}



.division-icon{


width:38px;


height:38px;


border-radius:12px;


background:#dcfce7;


display:flex;


align-items:center;


justify-content:center;


}



.division-name strong{


display:block;


font-size:13px;


color:#166534;


}



.division-name small{


font-size:11px;


color:#94a3b8;


}









/* STATUS */


.status{


display:flex;


align-items:center;


gap:7px;


font-size:12px;


font-weight:600;


color:#166534;


}



.status span{


width:8px;


height:8px;


border-radius:50%;


background:#22c55e;


}








/* ACTION */


.action{


display:flex;


gap:8px;


}



.action form{


display:inline;


}



.edit,


.delete{


padding:

7px 13px;


border-radius:10px;


font-size:12px;


font-weight:600;


border:none;


cursor:pointer;


text-decoration:none;


}



.edit{


background:#dcfce7;


color:#166534;


}



.delete{


background:#fee2e2;


color:#dc2626;


}







.empty{


text-align:center;


padding:30px;


color:#64748b;


}







@media(max-width:900px){


.division-stat-grid{


grid-template-columns:1fr;


}



.page-header{


flex-direction:column;


align-items:flex-start;


gap:15px;


}



}


</style>



@endsection