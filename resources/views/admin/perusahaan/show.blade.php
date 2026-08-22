@extends('layouts.dashboard')

@section('content')


{{-- ================= HEADER ================= --}}

<div class="page-header-card">

    <div>

        <div class="page-label">
            ADMINISTRASI
        </div>


        <h1>
            Detail Perusahaan
        </h1>


        <p>
            Informasi lengkap perusahaan dan project yang terhubung.
        </p>

    </div>



    <div class="header-action">


        <a href="{{route('admin.perusahaan.edit',$perusahaan->id)}}"
        class="btn-edit">

            ✏️ Edit

        </a>



        <a href="{{route('admin.perusahaan.index')}}"
        class="btn-secondary">

            ← Kembali

        </a>


    </div>


</div>






{{-- ================= STATISTIK ================= --}}


<div class="stat-grid">



<div class="stat-card">


    <div class="stat-icon">

        🏢

    </div>


    <div>

        <label>
            Nama Perusahaan
        </label>


        <h2 class="company-title">

            {{$perusahaan->nama_perusahaan}}

        </h2>


        <small>
            Data perusahaan
        </small>


    </div>


</div>







<div class="stat-card">


    <div class="stat-icon green">

        📁

    </div>


    <div>

        <label>
            Total Project
        </label>


        <h2>

            {{$perusahaan->proyek->count()}}

        </h2>


        <small>
            Project terhubung
        </small>


    </div>


</div>







<div class="stat-card">


    <div class="stat-icon blue">

        💰

    </div>


    <div>

        <label>
            Total Anggaran
        </label>


        <h2 class="budget-title">

            Rp {{number_format(
            $perusahaan->proyek->sum('total_anggaran'),
            0,
            ',',
            '.'
            )}}

        </h2>


        <small>
            Nilai seluruh project
        </small>


    </div>


</div>








<div class="stat-card">


    <div class="stat-icon gold">

        ✓

    </div>


    <div>

        <label>
            Status
        </label>



        <div class="company-status">


            @if($perusahaan->status=='aktif')


            <span class="company-active">
                Aktif
            </span>


            @else


            <span class="company-nonactive">
                Nonaktif
            </span>


            @endif


        </div>



        <small>
            Status perusahaan
        </small>


    </div>


</div>



</div>




{{-- ================= PROFIL ================= --}}


<div class="glass-panel">


<div class="table-header">

<div>

<h3>
Informasi Perusahaan
</h3>


<p>
Detail data perusahaan.
</p>


</div>

</div>





<div class="info-grid">


<div>

<label>
Alamat
</label>


<p>
{{$perusahaan->alamat ?? '-'}}
</p>


</div>



<div>

<label>
Kontak
</label>


<p>
{{$perusahaan->kontak ?? '-'}}
</p>


</div>



<div>

<label>
Email
</label>


<p>
{{$perusahaan->email ?? '-'}}
</p>


</div>



<div>

<label>
Status
</label>


<div class="company-status">


@if($perusahaan->status=='aktif')


<span class="company-active">
Aktif
</span>


@else


<span class="company-nonactive">
Nonaktif
</span>


@endif


</div>


</div>


</div>



</div>









{{-- ================= PROJECT ================= --}}


<div class="glass-panel">



<div class="table-header">


<div>

<h3>
Daftar Project Perusahaan
</h3>


<p>
Project yang dimiliki perusahaan ini.
</p>


</div>



<div class="total-user">

{{$perusahaan->proyek->count()}}

Project

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
Project
</th>


<th>
Budget
</th>


<th>
Tanggal Mulai
</th>


<th class="center">
Status
</th>


<th class="center">
Aksi
</th>


</tr>


</thead>






<tbody>



@forelse($perusahaan->proyek as $project)



<tr>


<td>

{{$loop->iteration}}

</td>






<td>


<strong>
{{$project->nama_proyek}}
</strong>


<br>


<small>
{{$project->pemilik_proyek ?? '-'}}
</small>


</td>







<td>


Rp {{number_format(
$project->total_anggaran,
0,
',',
'.'
)}}


</td>







<td>


{{$project->tanggal_mulai
?
$project->tanggal_mulai->format('d M Y')
:'-'}}


</td>





<td class="status-column">

@php
    $progress = (int) $project->progres_keseluruhan;
@endphp


<span 
class="
@if($progress >= 100)
status-selesai

@elseif($progress > 0)
status-berjalan

@else
status-belum

@endif
">


@if($progress >= 100)

Selesai


@elseif($progress > 0)

Berjalan


@else

Belum Dimulai


@endif


</span>


</td>







<td class="action-column">



<a href="{{route(
'admin.projects.show',
$project->id
)}}"

class="detail-btn">


👁


</a>



</td>





</tr>






@empty


<tr>


<td colspan="6" class="empty">


<div class="empty-icon">

📁

</div>


Belum ada project


</td>


</tr>



@endforelse




</tbody>


</table>


</div>


</div>


<style>

*{
    box-sizing:border-box;
}


/* ================= HEADER ================= */


.page-header-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.page-label{

    font-size:10px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.page-header-card h1{

    font-size:24px;

    font-weight:800;

    margin:8px 0;

    color:#1e293b;

}



.page-header-card p{

    font-size:12px;

    color:#64748b;

    margin:0;

}




.header-action{

    display:flex;

    gap:10px;

}



.btn-edit,
.btn-secondary{

    padding:10px 18px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    display:flex;

    align-items:center;

}



.btn-edit{

    background:#dbeafe;

    color:#1d4ed8;

}



.btn-secondary{

    background:#f1f5f9;

    color:#334155;

}







/* ================= STAT CARD ================= */


.stat-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}



.stat-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:18px;

    min-height:100px;

    display:flex;

    align-items:center;

    gap:14px;

    position:relative;

    overflow:hidden;

}



.stat-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.stat-card:nth-child(2)::before{

    background:#16a34a;

}



.stat-card:nth-child(3)::before{

    background:#2563eb;

}



.stat-card:nth-child(4)::before{

    background:#f59e0b;

}




.stat-icon{

    width:42px;

    height:42px;

    border-radius:13px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    flex-shrink:0;

    background:#dbeafe;

}



.green{

    background:#dcfce7!important;

}



.blue{

    background:#dbeafe!important;

}



.gold{

    background:#fef3c7!important;

}



.stat-card label{

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.stat-card h2{

    margin:5px 0;

    font-size:18px;

    font-weight:800;

    color:#1e293b;

}



.company-title{

    font-size:15px!important;

}



.budget-title{

    font-size:15px!important;

}



.stat-card small{

    font-size:10px;

    color:#94a3b8;

}






/* ================= PANEL ================= */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    margin-bottom:20px;

}





.table-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}



.table-header h3{

    margin:0;

    font-size:15px;

    font-weight:800;

    color:#1e293b;

    border-left:4px solid #334155;

    padding-left:10px;

}



.table-header p{

    font-size:11px;

    color:#64748b;

    margin:5px 0;

}



.total-user{

    background:#f1f5f9;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}






/* ================= INFO ================= */


.info-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px 50px;

}



.info-grid > div{

    border-bottom:1px solid #f1f5f9;

    padding-bottom:12px;

}



.info-grid label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



.info-grid p{

    margin:6px 0 0;

    font-size:13px;

    font-weight:700;

    color:#172033;

}







/* ================= TABLE ================= */


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

    font-size:11px;

    color:#64748b;

}



td{

    padding:13px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

    vertical-align:middle;

}



tbody tr:hover{

    background:#f8fafc;

}



.center{

    text-align:center;

}






/* ================= STATUS BADGE ================= */





.badge{

    display:inline-flex;

    justify-content:center;

    align-items:center;

    min-width:100px;

    height:28px;

    padding:0 15px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}


 .status-column{
    text-align:center;
    vertical-align:middle;
}


.status-selesai,
.status-berjalan,
.status-belum{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:100px;

    height:28px;

    padding:0 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.status-selesai{

    background:#dcfce7;

    color:#166534;

}



.status-berjalan{

    background:#dbeafe;

    color:#1d4ed8;

}



.status-belum{

    background:#f1f5f9;

    color:#64748b;

}




/* ================= COMPANY STATUS ================= */


.company-status{

    margin-top:8px;

    display:flex;

}



.company-active,
.company-nonactive{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    height:24px;

    padding:0 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.company-active{

    background:#dcfce7;

    color:#166534;

}



.company-nonactive{

    background:#fee2e2;

    color:#991b1b;

}







/* ================= ACTION ================= */


.action-column{

    width:90px;

    text-align:center;

}



.detail-btn{

    width:34px;

    height:34px;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    background:#dcfce7;

    border-radius:10px;

    text-decoration:none;

    font-size:15px;

}



.detail-btn:hover{

    background:#16a34a;

    color:white;

}







/* ================= EMPTY ================= */


.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

}



.empty-icon{

    font-size:30px;

    margin-bottom:10px;

}







@media(max-width:900px){


.stat-grid{

    grid-template-columns:1fr;

}



.info-grid{

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