@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
PROJECT MANAGEMENT
</div>


<h1>
Anggota Project
</h1>


<p>
Kelola karyawan yang terlibat dalam project {{ $project->nama_proyek }}.
</p>


</div>



<a href="{{route('admin.projects.index')}}"
class="btn-back">

← Kembali

</a>


</div>












<div class="member-grid">



{{-- TAMBAH ANGGOTA --}}


<div class="glass-panel">


<h3>
👥 Tambahkan Karyawan
</h3>


<form method="POST"

action="{{route(
'admin.members.store',
$project->id
)}}">


@csrf



<label>
Pilih Karyawan
</label>


<select name="user_id" required>


<option value="">
-- Pilih Karyawan --
</option>



@foreach($employees as $employee)


<option value="{{$employee->id}}">

{{$employee->name}}

-

{{ucfirst($employee->role)}}

</option>


@endforeach


</select>





<button class="btn-save">

＋ Tambahkan Anggota

</button>



</form>


</div>







{{-- LIST ANGGOTA --}}



<div class="glass-panel">


<h3>
📋 Anggota Saat Ini
</h3>



@if($members->count())


@foreach($members as $member)



<div class="member-item">



<div class="member-profile">


<div class="avatar">

{{strtoupper(substr(
$member->name,
0,
1
))}}

</div>



<div>

<strong>

{{$member->name}}

</strong>


<span>

{{$member->email}}

</span>


</div>


</div>





<form method="POST"

action="{{route(
'admin.members.destroy',
[
$project->id,
$member->id
]
)}}">


@csrf

@method('DELETE')



<button class="btn-delete">

Hapus

</button>



</form>



</div>



@endforeach



@else


<div class="empty">

Belum ada anggota project.

</div>


@endif



</div>




</div>





<style>

/* ===============================
GLOBAL
================================ */

.page-header-card,
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

    padding:25px 30px;

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

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    color:#334155;

    font-size:12px;

    font-weight:700;

}





/* ===============================
LAYOUT
================================ */


.member-grid{

    display:grid;

    grid-template-columns:0.8fr 1.2fr;

    gap:20px;

}







/* ===============================
CARD
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:22px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.glass-panel h3{

    margin:0 0 18px;

    font-size:16px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

}







/* ===============================
FORM
================================ */


label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



select{

    width:100%;

    height:42px;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:0 14px;

    font-size:12px;

    margin-bottom:15px;

}



select:focus{

    outline:none;

    background:white;

    border-color:#334155;

}







.btn-save{

    width:100%;

    height:42px;

    background:#334155;

    color:white;

    border:none;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.btn-save:hover{

    background:#1e293b;

}








/* ===============================
MEMBER ITEM
================================ */


.member-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:13px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:15px;

    margin-bottom:10px;

}



.member-profile{

    display:flex;

    align-items:center;

    gap:12px;

}





.avatar{

    width:40px;

    height:40px;

    border-radius:50%;

    background:#334155;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:13px;

    font-weight:800;

}





.member-profile strong{

    display:block;

    font-size:13px;

    color:#172033;

}



.member-profile span{

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
DELETE ICON
================================ */


.btn-delete{

    width:34px;

    height:34px;

    border-radius:10px;

    border:none;

    background:#fee2e2;

    color:#dc2626;

    font-size:0;

    cursor:pointer;

}



.btn-delete::after{

    content:"🗑";

    font-size:14px;

}



.btn-delete:hover{

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


@media(max-width:900px){


.member-grid{

    grid-template-columns:1fr;

}



.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}


}

</style>


@endsection