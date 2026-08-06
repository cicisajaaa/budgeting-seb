@extends('layouts.dashboard')

@section('content')


<div class="page-header-card">

    <div>

        <div class="page-label">
            USER MANAGEMENT
        </div>

        <h1>
            Detail Pengguna
        </h1>

        <p>
            Informasi lengkap akun, role, aktivitas, dan data pengguna sistem.
        </p>

    </div>


    <a href="{{route('admin.users.index')}}" class="btn-back">
        ← Kembali
    </a>


</div>





{{-- PROFILE --}}

<div class="profile-card">


    <div class="avatar">

        {{strtoupper(substr($user->name,0,1))}}

    </div>


    <div class="profile-info">

        <h2>
            {{$user->name}}
        </h2>


        <p>
            {{$user->email}}
        </p>
        <br>

        <span class="role-badge {{$user->role}}">

            {{ucfirst($user->role)}}

        </span>


    </div>


</div>







<div class="detail-grid">


{{-- INFORMASI AKUN --}}

<div class="glass-panel">

<div class="panel-title">
👤 Informasi Akun
</div>


<div class="info-item">
<span>
Nama Lengkap
</span>

<strong>
{{$user->name}}
</strong>
</div>



<div class="info-item">

<span>
Email
</span>

<strong>
{{$user->email}}
</strong>

</div>




<div class="info-item">

<span>
Role
</span>

<strong>
{{ucfirst($user->role)}}
</strong>

</div>




<div class="info-item">

<span>
Tanggal Registrasi
</span>

<strong>
{{$user->created_at->format('d M Y')}}
</strong>

</div>


</div>







{{-- DATA KARYAWAN --}}

<div class="glass-panel">


<div class="panel-title">
🏢 Data Karyawan
</div>



@if($user->karyawan)


<div class="info-item">

<span>
Nama Karyawan
</span>

<strong>
{{$user->karyawan->nama_karyawan}}
</strong>

</div>



<div class="info-item">

<span>
Divisi
</span>

<strong>
{{$user->karyawan->divisi->nama_divisi ?? '-'}}
</strong>

</div>




<div class="info-item">

<span>
Jumlah Task
</span>

<strong>
{{$totalTask}}
</strong>

</div>



<div class="info-item">

<span>
Status
</span>

<strong class="active">
Aktif
</strong>

</div>



@else


<div class="empty">

<div>
🏢
</div>

<p>
Tidak terdapat data karyawan pada akun ini.
</p>

</div>


@endif



</div>


</div>








{{-- STATISTIK USER --}}


<div class="glass-panel">


<div class="panel-title">

📊 Statistik Pengguna

</div>




<div class="stat-grid">



<div class="stat-box">

<span>
Total Task
</span>

<strong>
{{$totalTask ?? 0}}
</strong>

</div>




<div class="stat-box">

<span>
Task Selesai
</span>

<strong>
{{$taskSelesai ?? 0}}
</strong>

</div>




<div class="stat-box">

<span>
Pengajuan Dana
</span>

<strong>
{{$totalPengajuan ?? 0}}
</strong>

</div>



</div>


</div>









{{-- AKTIVITAS --}}


<div class="glass-panel">


<div class="panel-title">

📌 Aktivitas Terbaru

</div>



@if($user->logAudit->count())


@foreach($user->logAudit->take(5) as $audit)


<div class="activity-item">


<div>

<strong>
{{$audit->aksi}}
</strong>


<p>
{{$audit->deskripsi}}
</p>


<small>
{{$audit->created_at->format('d M Y H:i')}}
</small>


</div>


</div>



@endforeach


@else


<div class="empty">

Belum ada aktivitas pengguna.

</div>


@endif



</div>









{{-- ACTION --}}


<div class="action-card">


<div>

<h3>
Kelola Pengguna
</h3>


<p>
Perbarui informasi akun atau hapus pengguna dari sistem.
</p>


</div>




<div class="action">


<a href="{{route('admin.users.edit',$user->id)}}"
class="btn-edit">

✏️ Edit User

</a>



<form method="POST"
action="{{route('admin.users.destroy',$user->id)}}">


@csrf

@method('DELETE')


<button class="btn-delete"
onclick="return confirm('Hapus user ini?')">

🗑 Hapus User

</button>


</form>


</div>


</div>









<style>


.page-header-card,
.profile-card,
.glass-panel,
.action-card{

background:white;

border:1px solid #e5e7eb;

box-shadow:
0 10px 30px rgba(15,23,42,.06);

}



.page-header-card{

padding:30px;

border-radius:24px;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

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

}




.btn-back{

background:#f8fafc;

border:1px solid #e2e8f0;

padding:11px 20px;

border-radius:14px;

text-decoration:none;

color:#475569;

font-weight:700;

}





.profile-card{

padding:28px;

border-radius:24px;

display:flex;

align-items:center;

gap:20px;

margin-bottom:25px;

}



.avatar{

width:75px;

height:75px;

border-radius:22px;

background:#1e293b;

color:white;

display:flex;

align-items:center;

justify-content:center;

font-size:30px;

font-weight:800;

}



.profile-info h2{

margin:0;

font-size:25px;

color:#172033;

}



.profile-info p{

color:#64748b;

}



.role-badge{

padding:7px 15px;

border-radius:999px;

font-size:12px;

font-weight:800;

}



.role-badge.admin{

background:#e0e7ff;

color:#3730a3;

}


.role-badge.owner{

background:#fef3c7;

color:#92400e;

}


.role-badge.keuangan{

background:#dbeafe;

color:#1d4ed8;

}


.role-badge.karyawan{

background:#dcfce7;

color:#166534;

}




.detail-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

margin-bottom:15px;

}


.glass-panel{

padding:25px;

border-radius:24px;

margin-bottom:15px;

}


.panel-title{

font-size:18px;

font-weight:800;

margin-bottom:20px;

color:#172033;

}



.info-item{

display:flex;

justify-content:space-between;

background:#f8fafc;

padding:15px;

border-radius:14px;

margin-bottom:12px;

}



.info-item span{

color:#64748b;

font-size:13px;

}



.info-item strong{

color:#172033;

}



.active{

color:#16a34a!important;

}



.empty{

text-align:center;

padding:35px;

color:#94a3b8;

}



.empty div{

font-size:35px;

}





.stat-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

}



.stat-box{

background:#f8fafc;

padding:20px;

border-radius:18px;

}



.stat-box span{

color:#64748b;

font-size:13px;

}



.stat-box strong{

display:block;

font-size:30px;

margin-top:8px;

color:#172033;

}




.activity-item{

background:#f8fafc;

padding:15px;

border-radius:15px;

margin-bottom:10px;

}



.activity-item strong{

color:#172033;

}



.activity-item p{

font-size:13px;

color:#64748b;

}



.activity-item small{

color:#94a3b8;

}




.action-card{

padding:25px;

border-radius:24px;

display:flex;

justify-content:space-between;

align-items:center;

}



.action{

display:flex;

gap:10px;

}



.btn-edit,
.btn-delete{

padding:12px 18px;

border-radius:14px;

font-weight:800;

border:none;

cursor:pointer;

text-decoration:none;

}



.btn-edit{

background:#dbeafe;

color:#1d4ed8;

}



.btn-delete{

background:#fee2e2;

color:#dc2626;

}




@media(max-width:900px){

.detail-grid{

grid-template-columns:1fr;

}


.profile-card,
.action-card,
.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:20px;

}



.stat-grid{

grid-template-columns:1fr;

}


}


</style>


@endsection