@extends('layouts.dashboard')


@section('content')


<!-- HEADER -->

<div class="page-header">


<div>

<div class="page-label">
USER MANAGEMENT
</div>


<h1>
Kelola Pengguna
</h1>


<p>
Manajemen akun, role, dan hak akses pengguna sistem.
</p>


</div>



<a href="{{route('admin.users.create')}}" class="btn-primary">

<span>＋</span>
Tambah User

</a>


</div>







<!-- STATISTIC -->


<div class="user-stat-grid">



<div class="user-stat">

<div class="stat-icon green">

👥

</div>


<div>

<span>
Total Pengguna
</span>


<h3>
{{count($users)}}
</h3>


<small>
Akun sistem
</small>


</div>

</div>







<div class="user-stat">


<div class="stat-icon blue">

🛡️

</div>


<div>

<span>
Administrator
</span>


<h3>
{{$users->where('role','admin')->count()}}
</h3>


<small>
Hak akses penuh
</small>


</div>


</div>







<div class="user-stat">


<div class="stat-icon orange">

💼

</div>


<div>

<span>
Karyawan
</span>


<h3>
{{$users->where('role','karyawan')->count()}}
</h3>


<small>
Pengguna operasional
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







<!-- TABLE CARD -->


<div class="glass-panel">


<div class="table-header">


<div>


<h3>
Daftar Pengguna
</h3>


<p>
Kelola akun yang memiliki akses ke sistem.
</p>


</div>



<div class="total-user">

{{count($users)}} User

</div>


</div>






<div class="table-wrapper">


<table>


<thead>


<tr>

<th>
Pengguna
</th>


<th>
Email
</th>


<th>
Role
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


@foreach($users as $user)


<tr>


<td>


<div class="user-profile">


<div class="avatar-user">

{{strtoupper(substr($user->name,0,1))}}

</div>



<div>

<strong>
{{$user->name}}
</strong>


<small>
User Sistem
</small>


</div>


</div>



</td>






<td>

{{$user->email}}

</td>







<td>


<span class="role {{$user->role}}">

{{ucfirst($user->role)}}

</span>


</td>






<td>


<span class="status">


<span></span>

Aktif


</span>


</td>







<td>


<div class="action">



<a href="{{route('admin.users.edit',$user->id)}}"

class="edit">


Edit

</a>







<form method="POST"

action="{{route('admin.users.destroy',$user->id)}}">


@csrf

@method('DELETE')


<button

onclick="return confirm('Hapus user ini?')"

class="delete">

Hapus

</button>


</form>



</div>


</td>




</tr>



@endforeach



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


display:flex;


align-items:center;


gap:8px;


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


.user-stat-grid{


display:grid;


grid-template-columns:

repeat(3,1fr);


gap:18px;


margin-bottom:22px;


}



.user-stat{


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


box-shadow:

0 12px 30px rgba(15,23,42,.05);


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




.user-stat span{


font-size:11px;


color:#64748b;


display:block;


}




.user-stat h3{


font-size:24px;


color:#166534;


margin-top:3px;


}




.user-stat small{


font-size:11px;


color:#94a3b8;


}







/* ALERT */


.success-alert{


display:flex;


align-items:center;


gap:10px;


background:#dcfce7;


color:#166534;


padding:13px 16px;


border-radius:15px;


margin-bottom:18px;


font-size:13px;


font-weight:600;


}









/* TABLE */


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


color:#111827;


}



.table-header p{


font-size:12px;


color:#64748b;


}



.total-user{


background:#dcfce7;


color:#166534;


padding:

7px 15px;


border-radius:20px;


font-size:12px;


font-weight:700;


}






table{


width:100%;


border-collapse:collapse;


}



th{


padding:14px;


text-align:left;


font-size:11px;


color:#64748b;


background:#f8fafc;


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








/* USER */


.user-profile{


display:flex;


align-items:center;


gap:12px;


}



.avatar-user{


width:38px;


height:38px;


border-radius:12px;


background:

linear-gradient(
135deg,
#166534,
#22c55e
);


display:flex;


align-items:center;


justify-content:center;


color:white;


font-weight:700;


}



.user-profile strong{


display:block;


font-size:13px;


color:#166534;


}



.user-profile small{


font-size:11px;


color:#94a3b8;


}








/* ROLE */


.role{


padding:

6px 13px;


border-radius:20px;


font-size:11px;


font-weight:700;


}



.role.admin{


background:#dcfce7;


color:#166534;


}



.role.owner{


background:#ede9fe;


color:#6d28d9;


}



.role.bendahara{


background:#fef3c7;


color:#92400e;


}



.role.karyawan{


background:#dbeafe;


color:#1d4ed8;


}







/* STATUS */


.status{


display:flex;


align-items:center;


gap:7px;


font-size:12px;


color:#166534;


font-weight:600;


}



.status span{


width:8px;


height:8px;


background:#22c55e;


border-radius:50%;


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


border:none;


padding:

7px 13px;


border-radius:10px;


font-size:12px;


font-weight:600;


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




@media(max-width:900px){


.user-stat-grid{


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