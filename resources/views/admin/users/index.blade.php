@extends('layouts.dashboard')


@section('content')


<!-- HEADER -->
<div class="page-header-card">


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

/* ===============================
GLOBAL HEADER CARD
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

    color:#64748b;

    font-size:14px;

}





/* ===============================
BUTTON TAMBAH
================================ */


.btn-primary{

    display:flex;

    align-items:center;

    gap:8px;

    background:#1e293b;

    color:white;

    padding:12px 22px;

    border-radius:14px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.2s;

}



.btn-primary:hover{

    background:#b8863b;

    transform:translateY(-2px);

}








/* ===============================
STATISTIC CARD
================================ */


.user-stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;

}



.user-stat{

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

    width:48px;

    height:48px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

}



.stat-icon.green{

    background:#f1f5f9;

}



.stat-icon.blue{

    background:#dbeafe;

}



.stat-icon.orange{

    background:#fef3c7;

}



.user-stat span{

    font-size:12px;

    color:#64748b;

}



.user-stat h3{

    margin:5px 0;

    font-size:26px;

    color:#172033;

}



.user-stat small{

    color:#94a3b8;

    font-size:11px;

}








/* ===============================
SUCCESS ALERT
================================ */


.success-alert{


    display:flex;

    align-items:center;

    gap:10px;

    background:#f0fdf4;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:14px 18px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

    font-weight:600;


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


    font-size:18px;

    color:#172033;

    margin:0 0 5px;


}



.table-header p{


    color:#64748b;

    font-size:13px;

    margin:0;


}





.total-user{


    background:#f8fafc;

    border:1px solid #e2e8f0;

    color:#334155;

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

    padding:14px;

    text-align:left;

    font-size:12px;

    color:#64748b;

}



td{


    padding:15px;

    border-bottom:1px solid #e5e7eb;

    color:#334155;

    font-size:13px;


}



tr:hover{


    background:#fafafa;


}








/* ===============================
USER PROFILE
================================ */


.user-profile{


    display:flex;

    align-items:center;

    gap:12px;


}





.avatar-user{


    width:40px;

    height:40px;

    border-radius:50%;

    background:#1e293b;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;


}



.user-profile strong{


    display:block;

    color:#172033;

    font-size:13px;


}



.user-profile small{


    color:#94a3b8;

    font-size:11px;


}








/* ===============================
ROLE BADGE
================================ */


.role{


    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;


}



.role.admin{


    background:#e0e7ff;

    color:#3730a3;


}



.role.owner{


    background:#fef3c7;

    color:#92400e;


}



.role.keuangan{


    background:#dbeafe;

    color:#1d4ed8;


}



.role.karyawan{


    background:#f1f5f9;

    color:#475569;


}








/* ===============================
STATUS
================================ */


.status{


    display:flex;

    align-items:center;

    gap:8px;

    color:#166534;

    font-size:12px;

    font-weight:700;


}



.status span{


    width:8px;

    height:8px;

    background:#22c55e;

    border-radius:50%;


}








/* ===============================
ACTION BUTTON
================================ */


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

    padding:8px 15px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    cursor:pointer;

    text-decoration:none;


}



.edit{


    background:#dbeafe;

    color:#1d4ed8;


}



.delete{


    background:#fee2e2;

    color:#dc2626;


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
RESPONSIVE
================================ */


@media(max-width:900px){


.user-stat-grid{


    grid-template-columns:1fr;


}



.page-header-card{


    flex-direction:column;

    align-items:flex-start;

    gap:20px;


}



.table-header{


    flex-direction:column;

    align-items:flex-start;

    gap:15px;


}



}


</style>


@endsection