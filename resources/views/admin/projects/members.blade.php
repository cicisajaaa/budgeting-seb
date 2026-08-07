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


.page-header-card{

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

font-weight:800;

letter-spacing:2px;

color:#94a3b8;

}



.page-header-card h1{

margin:10px 0;

font-size:30px;

color:#172033;

}



.page-header-card p{

color:#64748b;

}



.btn-back{

background:#f8fafc;

border:1px solid #e2e8f0;

padding:11px 20px;

border-radius:12px;

text-decoration:none;

color:#334155;

font-weight:700;

font-size:13px;

}





.success-alert{

background:#dcfce7;

color:#166534;

padding:15px;

border-radius:15px;

margin-bottom:20px;

font-weight:700;

}





.member-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:25px;

}





.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:22px;

padding:25px;

box-shadow:

0 10px 30px rgba(15,23,42,.05);

}



.glass-panel h3{

margin-bottom:20px;

color:#172033;

}





label{

font-size:12px;

font-weight:700;

color:#475569;

display:block;

margin-bottom:8px;

}





select{

width:100%;

height:45px;

border-radius:12px;

border:1px solid #e2e8f0;

padding:0 15px;

background:#f8fafc;

margin-bottom:20px;

}





.btn-save{

width:100%;

height:45px;

background:#1e293b;

color:white;

border:none;

border-radius:12px;

font-weight:700;

cursor:pointer;

}





.btn-save:hover{

background:#8b6b2e;

}





.member-item{

display:flex;

align-items:center;

justify-content:space-between;

padding:15px;

background:#f8fafc;

border-radius:15px;

margin-bottom:12px;

}





.member-profile{

display:flex;

align-items:center;

gap:12px;

}





.avatar{

width:42px;

height:42px;

border-radius:50%;

background:#1e293b;

color:white;

display:flex;

align-items:center;

justify-content:center;

font-weight:800;

}





.member-profile strong{

display:block;

color:#172033;

}





.member-profile span{

font-size:12px;

color:#64748b;

}





.btn-delete{

background:#fee2e2;

color:#dc2626;

border:none;

padding:8px 14px;

border-radius:10px;

font-size:12px;

font-weight:700;

cursor:pointer;

}





.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}




@media(max-width:900px){


.member-grid{

grid-template-columns:1fr;

}


.page-header-card{

flex-direction:column;

align-items:flex-start;

gap:20px;

}


}

</style>


@endsection