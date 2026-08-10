<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">


<title>
Laporan Project
</title>


<style>

body{

font-family: DejaVu Sans, sans-serif;

font-size:12px;

color:#1e293b;

}


.header{

text-align:center;

margin-bottom:25px;

}


.logo{

width:80px;

}



.company{

font-size:18px;

font-weight:bold;

color:#8B5E22;

margin-top:10px;

}



.title{

font-size:16px;

font-weight:bold;

margin-top:5px;

}



.info{

color:#64748b;

margin-top:8px;

}





table{

width:100%;

border-collapse:collapse;

margin-top:25px;

}



th{

background:#8B5E22;

color:white;

padding:9px;

text-align:center;

}



td{

padding:8px;

border:1px solid #ddd;

}



td,th{

font-size:11px;

}

th:last-child,
td:last-child{

width:90px;

}

.status{

display:inline-block;

min-width:85px;

text-align:center;

padding:5px 10px;

border-radius:15px;

font-size:10px;

font-weight:bold;

white-space:nowrap;

}

.selesai{

background:#dbeafe;

color:#1d4ed8;

}



.berjalan{

background:#dcfce7;

color:#166534;

}



.belum{

background:#fef3c7;

color:#92400e;

}

.footer{

margin-top:30px;

text-align:right;

font-size:11px;

color:#64748b;

}

.progress-bg{

width:100px;

height:8px;

background:#e5e7eb;

border-radius:20px;

margin-top:5px;

}


.progress-fill{

height:8px;

background:#8B5E22;

border-radius:20px;

}

</style>


</head>



<body>



<div class="header">


<img 
src="{{public_path('images/logo-cv.png')}}"
class="logo"
>


<div class="company">

CV SAHABAT EKSPLORASI BANUA

</div>



<div class="title">

LAPORAN MONITORING PROJECT

</div>



<div class="info">

Tanggal :
{{now()->format('d M Y')}}

</div>


</div>









<table>


<thead>


<tr>


<th>
Nama Project
</th>


<th>
Pemilik
</th>


<th>
Anggaran
</th>


<th>
Progress
</th>



<th>
Jumlah Tugas
</th>


<th>
Deadline
</th>

<th>
Status
</th>


</tr>


</thead>


<tbody>

@forelse($projects as $project)

<tr>

<td>

{{$project->nama_proyek ?? '-'}}

</td>


<td>

{{$project->pemilik_proyek ?? '-'}}

</td>


<td>
    
Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>


<td align="center">

{{$project->progres_keseluruhan ?? 0}}%

<div class="progress-bg">

<div class="progress-fill"

style="
width:{{$project->progres_keseluruhan ?? 0}}%
">

</div>

</div>

</td>



<td align="center">

{{$project->tugas->count()}}

</td>




<td align="center">

@if($project->tanggal_selesai)

{{\Carbon\Carbon::parse(
$project->tanggal_selesai
)->format('d M Y')}}

@else

-

@endif

</td>
<td align="center">

@if(($project->progres_keseluruhan ?? 0)>=100)

<span class="status selesai">
Selesai
</span>


@elseif(($project->progres_keseluruhan ?? 0)>0)

<span class="status berjalan">
Berjalan
</span>


@else

<span class="status belum">
Belum
<br>
Dimulai
</span>


@endif


</td>


</tr>


@empty


<tr>

<td colspan="7" align="center">

Belum ada data project

</td>

</tr>


@endforelse


</tbody>



</table>








<div class="footer">


Dicetak oleh sistem pada

{{now()->format('d M Y H:i')}}


</div>




</body>

</html>