@extends('layouts.dashboard')

@section('content')


<div class="page-header-card">

<div>

<div class="page-label">
USER MANAGEMENT
</div>


<h1>
Kelola Pengguna
</h1>


<p>
Kelola akun pengguna, role, dan hak akses sistem perusahaan.
</p>


</div>


<a href="{{route('admin.users.create')}}" class="btn-primary">

＋ Tambah User

</a>


</div>





{{-- STATISTIC --}}

<div class="stat-grid">


<div class="stat-card">

<div class="stat-icon">
👥
</div>


<div>

<label>
Total User
</label>


<h2>
{{$totalUser}}
</h2>


<small>
Seluruh akun sistem
</small>


</div>

</div>






<div class="stat-card">

<div class="stat-icon">
🛡️
</div>


<div>

<label>
Administrator
</label>


<h2>
{{$totalAdmin}}
</h2>


<small>
Hak akses admin
</small>


</div>

</div>







<div class="stat-card">

<div class="stat-icon">
💼
</div>


<div>

<label>
Karyawan
</label>


<h2>
{{$totalKaryawan}}
</h2>


<small>
Pengguna operasional
</small>


</div>

</div>


</div>















{{-- TABLE --}}


<div class="glass-panel">


<div class="table-header">


<div>

<h3>
Daftar Pengguna
</h3>


<p>
Data akun yang memiliki akses ke sistem.
</p>


</div>



<div class="total-user">

{{$users->count()}} User

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
Pengguna
</th>


<th>
Email
</th>


<th>
Role
</th>


<th>
Divisi
</th>


<th>
Aksi
</th>


</tr>

</thead>







<tbody>


@forelse($users as $user)


<tr>


<td>

{{$loop->iteration}}

</td>







<td>


<div class="user-profile">


<div class="avatar">

{{strtoupper(substr($user->name,0,1))}}

</div>



<div>

<strong>
{{$user->name}}
</strong>


<small>
Akun Sistem
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


@if($user->karyawan)


{{$user->karyawan->divisi->nama_divisi ?? '-'}}


@else

-

@endif


</td>







<td>

<div class="action">


<a href="{{route('admin.users.show',$user->id)}}"

class="detail">

👁

</a>




<a href="{{route('admin.users.edit',$user->id)}}"

class="edit">

✏️ 

</a>





<form method="POST"

action="{{route('admin.users.destroy',$user->id)}}">


@csrf

@method('DELETE')


<button class="delete"

onclick="return confirm('Hapus user ini?')">

🗑️

</button>


</form>



</div>
</td>



</tr>



@empty


<tr>

<td colspan="6" class="empty">

Belum ada pengguna

</td>

</tr>


@endforelse



</tbody>


</table>


</div>


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

font-weight:800;

}



.page-header-card p{

color:#64748b;

font-size:14px;

margin:0;

}






.btn-primary{

background:#1e293b;

color:white;

padding:12px 22px;

border-radius:14px;

text-decoration:none;

font-size:13px;

font-weight:700;

}



.btn-primary:hover{

background:#b8863b;

}









.stat-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

margin-bottom:25px;

}





.stat-card{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:22px;

display:flex;

align-items:center;

gap:15px;

box-shadow:0 10px 30px rgba(15,23,42,.05);

}





.stat-icon{

width:50px;

height:50px;

border-radius:16px;

background:#f8f3ea;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

}



.stat-card label{

font-size:12px;

color:#64748b;

}



.stat-card h2{

font-size:28px;

margin:5px 0;

color:#172033;

}



.stat-card small{

font-size:11px;

color:#94a3b8;

}








.success-alert{

background:#f0fdf4;

border:1px solid #bbf7d0;

padding:15px;

border-radius:16px;

color:#166534;

font-size:13px;

font-weight:700;

margin-bottom:20px;

}








.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

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

font-size:13px;

color:#64748b;

}



.total-user{

background:#f1f5f9;

padding:8px 15px;

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

font-size:12px;

color:#64748b;

text-align:left;

}



td{

padding:15px;

border-bottom:1px solid #e5e7eb;

font-size:13px;

}








.user-profile{

display:flex;

align-items:center;

gap:12px;

}



.avatar{

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

}



.user-profile small{

color:#94a3b8;

}








.role{

padding:7px 14px;

border-radius:999px;

font-size:11px;

font-weight:700;

}



.role.admin{

background:#dbeafe;

color:#1d4ed8;

}



.role.owner{

background:#fef3c7;

color:#92400e;

}



.role.keuangan{

background:#dcfce7;

color:#166534;

}



.role.karyawan{

background:#f1f5f9;

color:#475569;

}







.action{

display:flex;

gap:8px;

}



.action form{

display:inline;

}


.detail,
.edit,
.delete{

padding:8px 12px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

border:none;

cursor:pointer;

display:flex;

align-items:center;

gap:5px;

}



.detail{

background:#dcfce7;

color:#166534;

}



.edit{

background:#dbeafe;

color:#1d4ed8;

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





.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}







@media(max-width:900px){


.stat-grid{

grid-template-columns:1fr;

}



.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:20px;

}


.table-wrapper{

overflow-x:auto;

}


}



</style>


@endsection