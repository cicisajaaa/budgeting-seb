@extends('layouts.dashboard')


@section('content')


<div class="page-header">


<span class="label">
DETAIL PROYEK
</span>


<h1>
{{ $project->nama_proyek }}
</h1>


<p>
Informasi lengkap perkembangan proyek perusahaan.
</p>


</div>





<a href="{{route('owner.projects')}}" class="btn-back">

← Kembali Pemantauan Proyek

</a>









<div class="summary-grid">



<div class="summary-card">

<span>
Total Anggaran
</span>


<h2>
Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Nilai proyek
</p>

</div>







<div class="summary-card">

<span>
Progress Proyek
</span>


<h2>
{{$project->progres_keseluruhan ?? 0}}%
</h2>


<p>
Tingkat penyelesaian
</p>

</div>







<div class="summary-card">

<span>
Total Pekerjaan
</span>


<h2>
{{$totalTask ?? 0}}
</h2>


<p>
Jumlah seluruh tugas
</p>

</div>







<div class="summary-card">

<span>
Pekerjaan Selesai
</span>


<h2>
{{$taskSelesai ?? 0}}
</h2>


<p>
Tugas telah selesai
</p>

</div>



</div>









<div class="panel">


<h3>
📁 Informasi Proyek
</h3>



<table>


<tr>

<td>
Nama Proyek
</td>


<td>
{{$project->nama_proyek}}
</td>


</tr>



<tr>

<td>
Pemilik Proyek
</td>


<td>
{{$project->pemilik_proyek ?? '-'}}
</td>


</tr>




<tr>

<td>
Tanggal Mulai
</td>


<td>

@if($project->tanggal_mulai)

{{\Carbon\Carbon::parse(
$project->tanggal_mulai
)->format('d M Y')}}

@else

-

@endif

</td>


</tr>




<tr>

<td>
Tanggal Selesai
</td>


<td>

@if($project->tanggal_selesai)

{{\Carbon\Carbon::parse(
$project->tanggal_selesai
)->format('d M Y')}}

@else

-

@endif

</td>


</tr>




<tr>

<td>
Status
</td>


<td>


@if(($project->progres_keseluruhan ?? 0) >= 100)


<span class="status selesai">
Selesai
</span>


@elseif(($project->progres_keseluruhan ?? 0) > 0)


<span class="status berjalan">
Berjalan
</span>


@else


<span class="status todo">
Belum Mulai
</span>


@endif


</td>


</tr>



</table>



</div>









<div class="panel">


<h3>
📌 Daftar Pekerjaan Proyek
</h3>





<table>


<thead>


<tr>

<th>
Nama Tugas
</th>


<th>
PIC
</th>


<th>
Divisi
</th>


<th>
Status
</th>


<th>
Progress
</th>


<th>
Update Terakhir
</th>


</tr>


</thead>





<tbody>



@forelse($project->tugas ?? [] as $task)



<tr>



<td>

<strong>

{{$task->nama_tugas ?? '-'}}

</strong>


<br>


<small>

{{$task->aktivitas ?? '-'}}

</small>


</td>







<td>

{{$task->karyawan->nama_karyawan ?? '-'}}

</td>







<td>

{{$task->divisi->nama_divisi ?? '-'}}

</td>







<td>


@if($task->status=='selesai')


<span class="status selesai">

Selesai

</span>



@elseif($task->status=='sedang_dikerjakan')


<span class="status berjalan">

Berjalan

</span>



@else


<span class="status todo">

Belum Mulai

</span>



@endif


</td>








<td>



<div class="progress">


<div class="progress-fill"

style="width:{{$task->progres_persen ?? 0}}%">

</div>


</div>



{{$task->progres_persen ?? 0}}%



</td>








<td>



@if($task->aktivitasTugas->count())



<strong>

{{\Carbon\Carbon::parse(
$task->aktivitasTugas->last()->tanggal
)->format('d M Y')}}

</strong>



<br>



<small>

{{$task->aktivitasTugas->last()->aktivitas}}

</small>



@else


Belum ada update



@endif



</td>





</tr>




@empty



<tr>

<td colspan="6" align="center">

Belum terdapat pekerjaan

</td>


</tr>



@endforelse



</tbody>



</table>



</div>









<style>


.page-header{

background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

margin-bottom:20px;

}



.label{

font-size:11px;

font-weight:700;

letter-spacing:2px;

color:#64748b;

}



.page-header h1{

font-size:28px;

margin:10px 0;

color:#1e293b;

}



.page-header p{

color:#64748b;

}






.btn-back{

display:inline-block;

margin-bottom:20px;

padding:10px 20px;

background:#6b4f1d;

color:white;

border-radius:12px;

text-decoration:none;

font-size:13px;

font-weight:600;

}



.btn-back:hover{

background:#a67c2e;

color:white;

}






.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:25px;

}





.summary-card{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.summary-card span{

font-size:12px;

color:#64748b;

}



.summary-card h2{

margin-top:10px;

color:#6b4f1d;

}







.panel{

background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.panel h3{

margin-bottom:20px;

}






table{

width:100%;

border-collapse:collapse;

}



td,th{

padding:15px;

border-bottom:1px solid #eee;

text-align:left;

font-size:13px;

}







.progress{

height:8px;

width:160px;

background:#e2e8f0;

border-radius:20px;

overflow:hidden;

display:inline-block;

margin-right:10px;

}



.progress-fill{

height:100%;

background:#a67c2e;

}







.status{

padding:6px 14px;

border-radius:20px;

font-size:12px;

font-weight:700;

}



.berjalan{

background:#dcfce7;

color:#166534;

}



.selesai{

background:#dbeafe;

color:#1d4ed8;

}



.todo{

background:#f1f5f9;

color:#475569;

}






small{

color:#64748b;

font-size:12px;

}






@media(max-width:1000px){


.summary-grid{

grid-template-columns:repeat(2,1fr);

}


table{

min-width:900px;

}



.panel{

overflow-x:auto;

}


}


</style>



@endsection