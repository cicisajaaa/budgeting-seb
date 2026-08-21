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


@if($errors->any())

<div class="alert-error">

<strong>
Terjadi kesalahan:
</strong>

<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif


{{-- STATISTIC --}}
<div class="stat-grid">


<div class="stat-card">

<div class="stat-icon">
👥
</div>

<div>
<label>Total User</label>
<h2>{{$totalUser}}</h2>
<small>Seluruh akun sistem</small>
</div>

</div>




<div class="stat-card">

<div class="stat-icon">
🛡️
</div>

<div>
<label>Administrator</label>
<h2>{{$totalAdmin}}</h2>
<small>Hak akses admin</small>
</div>

</div>




<div class="stat-card">

<div class="stat-icon">
💼
</div>

<div>
<label>Karyawan</label>
<h2>{{$totalKaryawan}}</h2>
<small>Pengguna operasional</small>
</div>

</div>




<div class="stat-card">

<div class="stat-icon">
👑
</div>

<div>
<label>Owner</label>
<h2>{{$totalOwner}}</h2>
<small>Pemilik sistem</small>
</div>

</div>




<div class="stat-card">

<div class="stat-icon">
💰
</div>

<div>
<label>Keuangan</label>
<h2>{{$totalKeuangan}}</h2>
<small>Pengelola dana</small>
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




<form method="GET" style="margin-bottom:20px;display:flex;gap:10px;">


<input 
type="text"
name="search"
placeholder="Cari nama atau email..."
value="{{request('search')}}"
style="
padding:10px 15px;
border:1px solid #e5e7eb;
border-radius:12px;
width:250px;
">


<select 
name="role"
style="
padding:10px 15px;
border:1px solid #e5e7eb;
border-radius:12px;
">


<option value="">
Semua Role
</option>


<option value="owner"
{{request('role')=='owner'?'selected':''}}>
Owner
</option>


<option value="admin"
{{request('role')=='admin'?'selected':''}}>
Admin
</option>


<option value="keuangan"
{{request('role')=='keuangan'?'selected':''}}>
Keuangan
</option>


<option value="karyawan"
{{request('role')=='karyawan'?'selected':''}}>
Karyawan
</option>


</select>


<button 
type="submit"
class="btn-primary"
>
Cari
</button>


</form>



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

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


/* ===============================
HEADER
================================ */


.page-header-card{

    background:#f8fafc;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

    display:flex;

    justify-content:space-between;

    align-items:center;

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





/* ===============================
BUTTON
================================ */


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

    border:none;

}



.btn-primary:hover{

    background:#1e293b;

}







/* ===============================
STAT CARD
================================ */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(5,1fr);

    gap:15px;

    margin-bottom:25px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:12px;

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

    height:4px;

    width:100%;

    background:#334155;

}



.stat-card:nth-child(2)::before{

    background:#2563eb;

}


.stat-card:nth-child(3)::before{

    background:#16a34a;

}


.stat-card:nth-child(4)::before{

    background:#f59e0b;

}


.stat-card:nth-child(5)::before{

    background:#7c3aed;

}



.stat-icon{

    width:42px;

    height:42px;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    flex-shrink:0;

    background:#f8fafc;

}

.stat-card:nth-child(1) .stat-icon{
    background:#dbeafe;
}


.stat-card:nth-child(2) .stat-icon{
    background:#fee2e2;
}


.stat-card:nth-child(3) .stat-icon{
    background:#dcfce7;
}


.stat-card:nth-child(4) .stat-icon{
    background:#fef3c7;
}


.stat-card:nth-child(5) .stat-icon{
    background:#ede9fe;
}


.stat-card label{

    font-size:10px;

    color:#64748b;

    font-weight:700;

}



.stat-card h2{

    margin:5px 0;

    font-size:19px;

    color:#1e293b;

    font-weight:800;

}



.stat-card small{

    font-size:10px;

    color:#94a3b8;

}






/* ===============================
ERROR
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:14px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:12px;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:20px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}







/* ===============================
TABLE HEADER
================================ */


.table-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

}



.table-header h3{

    margin:0;

    padding-left:10px;

    border-left:4px solid #334155;

    font-size:15px;

    color:#1e293b;

}



.table-header p{

    margin:5px 0 0;

    font-size:11px;

    color:#64748b;

}



.total-user{

    background:#f1f5f9;

    padding:6px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}







/* ===============================
FILTER
================================ */


form[method="GET"] input,
form[method="GET"] select{

    height:38px!important;

    padding:0 12px!important;

    border-radius:12px!important;

    background:#f8fafc;

    font-size:11px;

}



form[method="GET"] button{

    height:38px;

    padding:0 18px;

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

    padding:12px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr:hover{

    background:#f8fafc;

}







/* ===============================
USER PROFILE
================================ */


.user-profile{

    display:flex;

    align-items:center;

    gap:10px;

}



.avatar{

    width:36px;

    height:36px;

    border-radius:50%;

    background:#334155;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:12px;

    font-weight:800;

}



.user-profile strong{

    font-size:12px;

    display:block;

}



.user-profile small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
ROLE
================================ */


.role{

    display:inline-flex;

    padding:5px 10px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.role.owner{

    background:#fef3c7;

    color:#92400e;

}



.role.admin{

    background:#dbeafe;

    color:#1d4ed8;

}



.role.keuangan{

    background:#dcfce7;

    color:#166534;

}



.role.karyawan{

    background:#f1f5f9;

    color:#475569;

}








/* ===============================
ACTION
================================ */

.action{

    display:flex;

    align-items:center;

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

    padding:0;

    line-height:1;

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

    padding:30px;

    color:#94a3b8;

    font-size:12px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:1300px){

.stat-grid{

grid-template-columns:repeat(3,1fr);

}

}



@media(max-width:900px){

.stat-grid{

grid-template-columns:repeat(2,1fr);

}


.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}

}



@media(max-width:600px){

.stat-grid{

grid-template-columns:1fr;

}

}


</style>


@endsection