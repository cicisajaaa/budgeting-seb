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

font-weight:800;

letter-spacing:2px;

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

color:#334155;

font-weight:700;

font-size:13px;

}






.detail-grid{

display:grid;

grid-template-columns:2fr 1fr;

gap:20px;

margin-bottom:20px;

}




.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

margin-bottom:20px;

}




.panel-title{

font-size:17px;

font-weight:800;

color:#172033;

margin-bottom:20px;

}





.info-item{

background:#f8fafc;

padding:15px;

border-radius:14px;

margin-bottom:12px;

}



.info-item span{

display:block;

font-size:12px;

color:#64748b;

margin-bottom:5px;

}



.info-item strong{

color:#172033;

font-size:14px;

}






.stat-box{

display:flex;

align-items:center;

gap:15px;

background:#f8fafc;

padding:15px;

border-radius:16px;

margin-bottom:12px;

}



.stat-box div:first-child{

font-size:25px;

}



.stat-box span{

font-size:12px;

color:#64748b;

}



.stat-box h2{

margin:3px 0;

color:#172033;

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

font-size:13px;

}





.empty{

text-align:center;

padding:30px;

color:#94a3b8;

}




@media(max-width:900px){

.detail-grid{

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