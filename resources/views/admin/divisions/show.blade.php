@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>


<div class="page-label">
DETAIL DIVISI
</div>


<h1>
{{$division->nama_divisi}}
</h1>


<p>
Informasi lengkap struktur organisasi dan aktivitas divisi.
</p>


</div>



<a href="{{route('admin.divisions.index')}}" class="btn-back">

← Kembali

</a>


</div>







<div class="detail-grid">



{{-- INFORMASI DIVISI --}}

<div class="glass-panel">


<div class="panel-title">

🏢 Informasi Divisi

</div>



<div class="info-item">

<span>
Nama Divisi
</span>

<strong>
{{$division->nama_divisi}}
</strong>

</div>



<div class="info-item">

<span>
Deskripsi
</span>


<strong>

{{$division->deskripsi ?? 'Belum ada deskripsi'}}

</strong>


</div>



<div class="info-item">

<span>
Tanggal Dibuat
</span>


<strong>

{{$division->created_at->format('d M Y')}}

</strong>


</div>


</div>







{{-- STATISTIK --}}

<div class="glass-panel">


<div class="panel-title">

📊 Statistik Divisi

</div>



<div class="stat-box">


<div>

👥

</div>


<div>

<span>
Jumlah Karyawan
</span>


<h2>
{{$division->karyawan->count()}}
</h2>


</div>


</div>






<div class="stat-box">


<div>

📝

</div>


<div>

<span>
Total Task
</span>


<h2>
{{$division->tugas->count()}}
</h2>


</div>


</div>






<div class="stat-box">


<div>

💰

</div>


<div>

<span>
Jumlah Alokasi
</span>


<h2>
{{$division->alokasiProyekDivisi->count()}}
</h2>


</div>


</div>



</div>



</div>








{{-- DAFTAR KARYAWAN --}}


<div class="glass-panel">


<div class="panel-title">

👥 Daftar Karyawan Divisi

</div>




<table>


<thead>

<tr>

<th>
Nama
</th>


<th>
Email
</th>


<th>
Role
</th>


</tr>

</thead>




<tbody>


@forelse($division->karyawan as $karyawan)


<tr>


<td>

{{$karyawan->nama_karyawan}}

</td>



<td>

{{$karyawan->pengguna->email ?? '-'}}

</td>



<td>

Karyawan

</td>


</tr>



@empty


<tr>

<td colspan="3" class="empty">

Belum ada anggota divisi

</td>

</tr>


@endforelse



</tbody>


</table>



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

    font-size:26px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    color:#334155;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

}








/* ===============================
MAIN GRID
================================ */


.detail-grid{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:20px;

    margin-bottom:20px;

}








/* ===============================
CARD
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:22px;

    margin-bottom:20px;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}







.panel-title{

    font-size:16px;

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

    border-radius:14px;

    padding:14px;

    margin-bottom:10px;

}




.info-item span{

    font-size:12px;

    color:#64748b;

}




.info-item strong{

    font-size:13px;

    color:#172033;

    max-width:60%;

    text-align:right;

}






/* ===============================
STATISTIC COMPACT
================================ */

.stat-box{

    display:flex;

    align-items:center;

    gap:12px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:14px;

    padding:12px;

    margin-bottom:10px;

}



.stat-box div:first-child{

    width:36px;

    height:36px;

    border-radius:10px;

    background:#f1f5f9;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:16px;

}



.stat-box span{

    display:block;

    font-size:10px;

    color:#64748b;

}



.stat-box h2{

    margin:2px 0 0;

    font-size:20px;

    color:#172033;

    font-weight:800;

}





/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}




th{

    background:#f8fafc;

    padding:12px;

    text-align:left;

    font-size:11px;

    font-weight:700;

    color:#64748b;

}




td{

    padding:14px;

    font-size:13px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

}





tbody tr:hover{

    background:#fafafa;

}







/* ===============================
ROLE BADGE
================================ */


td:last-child{

    font-weight:700;

}






/* ===============================
EMPTY
================================ */


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

    font-size:13px;

}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.detail-grid{

    grid-template-columns:1fr;

}



.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.btn-back{

    width:100%;

    text-align:center;

}



.info-item{

    flex-direction:column;

    align-items:flex-start;

    gap:5px;

}



.info-item strong{

    max-width:100%;

    text-align:left;

}



table{

    min-width:600px;

}


}

</style>

@endsection