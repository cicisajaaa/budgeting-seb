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

@if(session('success'))

<div class="success-alert">

{{session('success')}}

</div>

@endif



@if($errors->any())

<div class="alert-error">

@foreach($errors->all() as $error)

{{$error}}

@endforeach

</div>

@endif



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
{{ $user->created_at?->format('d M Y') ?? '-' }}
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
{{ $user->karyawan->divisi?->nama_divisi ?? '-' }}
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
{{ $audit->created_at?->format('d M Y H:i') ?? '-' }}
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


@if($user->role != 'owner')

<form method="POST"
action="{{route('admin.users.destroy',$user->id)}}">

@csrf

@method('DELETE')


<button class="btn-delete"
onclick="return confirm('Hapus user ini?')">

🗑 Hapus User

</button>


</form>

@else

<button class="btn-delete" disabled>
🔒 Owner Tidak Dapat Dihapus
</button>

@endif
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
BACK
================================ */


.btn-back{

    display:flex;

    align-items:center;

    justify-content:center;

    background:white;

    border:1px solid #e2e8f0;

    color:#334155;

    padding:10px 18px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}



.btn-back:hover{

    background:#334155;

    color:white;

}






/* ===============================
ALERT
================================ */


.success-alert,
.alert-error{

    padding:14px;

    border-radius:15px;

    margin-bottom:20px;

    font-size:12px;

    font-weight:700;

}



.success-alert{

    background:#dcfce7;

    border:1px solid #bbf7d0;

    color:#166534;

}



.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

}







/* ===============================
PROFILE
================================ */


.profile-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    margin-bottom:20px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.avatar{

    width:55px;

    height:55px;

    border-radius:18px;

    background:#334155;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

    font-weight:800;

}



.profile-info h2{

    margin:0;

    font-size:20px;

    font-weight:800;

    color:#172033;

}



.profile-info p{

    margin:6px 0;

    font-size:12px;

    color:#64748b;

}



.role-badge{

    display:inline-flex;

    padding:5px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:800;

}






/* ===============================
GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;

}







/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:20px;

    margin-bottom:20px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.panel-title{

    font-size:15px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:18px;

}







/* ===============================
INFO ITEM
================================ */


.info-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:12px;

    border-radius:12px;

    margin-bottom:10px;

}



.info-item span{

    font-size:11px;

    color:#64748b;

}



.info-item strong{

    font-size:12px;

    color:#172033;

}



.active{

    color:#16a34a!important;

}







/* ===============================
STAT
================================ */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

}



.stat-box{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:16px;

    border-radius:16px;

}



.stat-box span{

    font-size:11px;

    color:#64748b;

}



.stat-box strong{

    display:block;

    margin-top:7px;

    font-size:22px;

    font-weight:800;

    color:#172033;

}







/* ===============================
ACTIVITY
================================ */


.activity-item{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:14px;

    border-radius:14px;

    margin-bottom:10px;

}



.activity-item strong{

    font-size:12px;

    color:#172033;

}



.activity-item p{

    margin:5px 0;

    font-size:12px;

    color:#64748b;

}



.activity-item small{

    font-size:10px;

    color:#94a3b8;

}







/* ===============================
ACTION
================================ */


.action-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:20px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.action-card h3{

    margin:0;

    font-size:15px;

    color:#172033;

}



.action-card p{

    margin:5px 0 0;

    font-size:12px;

    color:#64748b;

}



.action{

    display:flex;

    gap:10px;

}



.btn-edit,
.btn-delete{

    padding:10px 16px;

    border-radius:12px;

    font-size:11px;

    font-weight:700;

    border:none;

    cursor:pointer;

    text-decoration:none;

}



.btn-edit{

    background:#dbeafe;

    color:#2563eb;

}



.btn-delete{

    background:#fee2e2;

    color:#dc2626;

}







/* ===============================
RESPONSIVE
================================ */

@media(max-width:900px){

    .page-header-card{
        flex-direction:column;
        align-items:stretch;
        gap:15px;
        padding:20px;
    }

    .page-header-card h1{
        font-size:21px;
    }

    .page-header-card p{
        font-size:11px;
        line-height:1.5;
    }

    .btn-back{
        width:100%;
        min-height:42px;
    }

    .profile-card{
        padding:18px;
        gap:12px;
    }

    .profile-info{
        min-width:0;
    }

    .profile-info h2{
        font-size:18px;
        word-break:break-word;
    }

    .profile-info p{
        font-size:11px;
        word-break:break-word;
        line-height:1.5;
    }

    .detail-grid{
        grid-template-columns:1fr;
        gap:15px;
    }

    .glass-panel{
        padding:18px;
        border-radius:18px;
    }

    .panel-title{
        font-size:14px;
    }

    .info-item{
        flex-direction:column;
        align-items:flex-start;
        gap:5px;
    }

    .info-item span{
        font-size:10px;
    }

    .info-item strong{
        width:100%;
        font-size:11px;
        word-break:break-word;
        line-height:1.5;
    }

    .stat-grid{
        grid-template-columns:repeat(3,1fr);
        gap:12px;
    }

    .stat-box{
        padding:13px;
    }

    .stat-box span{
        font-size:10px;
    }

    .stat-box strong{
        font-size:19px;
    }

    .activity-item{
        padding:12px;
    }

    .activity-item strong{
        word-break:break-word;
    }

    .activity-item p{
        font-size:11px;
        line-height:1.5;
        word-break:break-word;
    }

    .action-card{
        flex-direction:column;
        align-items:stretch;
        gap:15px;
        padding:18px;
    }

    .action-card h3{
        font-size:14px;
    }

    .action-card p{
        font-size:11px;
        line-height:1.5;
    }

    .action{
        width:100%;
        flex-direction:column;
        gap:10px;
    }

    .btn-edit,
    .btn-delete{
        width:100%;
        min-height:42px;
        display:flex;
        align-items:center;
        justify-content:center;
        box-sizing:border-box;
    }

}


@media(max-width:600px){

    .page-header-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .page-label{
        font-size:9px;
    }

    .page-header-card h1{
        font-size:19px;
    }

    .page-header-card p{
        font-size:10px;
        line-height:1.5;
    }

    .btn-back{
        height:42px;
        font-size:12px;
    }

    .profile-card{
        padding:15px;
        border-radius:18px;
        align-items:flex-start;
    }

    .avatar{
        width:42px;
        height:42px;
        border-radius:14px;
        font-size:17px;
        flex-shrink:0;
    }

    .profile-info h2{
        font-size:16px;
    }

    .profile-info p{
        font-size:10px;
        margin:4px 0;
    }

    .role-badge{
        padding:4px 10px;
        font-size:9px;
    }

    .glass-panel{
        padding:15px;
        border-radius:18px;
    }

    .panel-title{
        font-size:14px;
        margin-bottom:15px;
    }

    .info-item{
        padding:11px;
    }

    .info-item span{
        font-size:9px;
    }

    .info-item strong{
        font-size:11px;
    }

    .stat-grid{
        grid-template-columns:repeat(3,1fr);
        gap:8px;
    }

    .stat-box{
        padding:11px 8px;
        border-radius:14px;
    }

    .stat-box span{
        font-size:8px;
        line-height:1.3;
    }

    .stat-box strong{
        margin-top:5px;
        font-size:16px;
    }

    .activity-item{
        padding:11px;
        border-radius:12px;
    }

    .activity-item strong{
        font-size:11px;
    }

    .activity-item p{
        font-size:10px;
        line-height:1.5;
    }

    .activity-item small{
        font-size:8px;
    }

    .action-card{
        padding:15px;
        border-radius:18px;
    }

    .action-card h3{
        font-size:14px;
    }

    .action-card p{
        font-size:10px;
        line-height:1.5;
    }

    .btn-edit,
    .btn-delete{
        height:42px;
        font-size:11px;
    }

}

</style>


@endsection