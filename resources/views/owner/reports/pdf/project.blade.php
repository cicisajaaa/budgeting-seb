<!DOCTYPE html>
<html>
<head>

<title>
Laporan Proyek
</title>


<style>

body{

font-family:Arial,sans-serif;
font-size:12px;
color:#333;

}


.header{

text-align:center;
margin-bottom:30px;

}


.header h1{

font-size:22px;

}



.info{

margin-bottom:20px;

}



table{

width:100%;
border-collapse:collapse;

}



th{

background:#6b4f1d;
color:white;
padding:10px;
text-align:left;

}



td{

padding:10px;
border-bottom:1px solid #ddd;

}



.center{

text-align:center;

}



.right{

text-align:right;

}



.badge{

padding:5px 10px;
border-radius:10px;
font-size:11px;

}


.selesai{

background:#dbeafe;
color:#1d4ed8;

}



.berjalan{

background:#dcfce7;
color:#166534;

}



.terlambat{

background:#fee2e2;
color:#991b1b;

}


.summary{

margin-bottom:25px;

}


.summary td{

border:1px solid #ddd;

}


</style>


</head>



<body>



<div class="header">


<h1>
Laporan Monitoring Proyek
</h1>


<p>
Sahabat Eksplorasi Banua
</p>


</div>





<div class="info">

Tanggal Cetak :
{{now()->format('d M Y')}}

</div>







<table class="summary">


<tr>

<td>
Total Proyek
</td>


<td class="center">

{{count($projects)}}

</td>


</tr>


<tr>

<td>
Total Anggaran
</td>


<td class="right">

Rp {{number_format(
$projects->sum('total_anggaran'),
0,
',',
'.'
)}}

</td>


</tr>


</table>









<h3>
Daftar Proyek
</h3>





<table>


<thead>

<tr>

<th>
Nama Proyek
</th>


<th>
Pemilik / Client
</th>


<th>
Anggaran
</th>


<th>
Progress
</th>


<th>
Tanggal Selesai
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

{{$project->nama_proyek}}

</td>



<td>

{{$project->pemilik_proyek ?? '-'}}

</td>




<td class="right">

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>




<td class="center">

{{$project->progres_keseluruhan ?? 0}}%

</td>





<td>

{{$project->tanggal_selesai ?? '-'}}

</td>





<td class="center">


@if(($project->progres_keseluruhan ?? 0)>=100)


<span class="badge selesai">
Selesai
</span>


@elseif(
$project->tanggal_selesai &&
$project->tanggal_selesai < now()
)


<span class="badge terlambat">
Terlambat
</span>


@else


<span class="badge berjalan">
Berjalan
</span>


@endif


</td>




</tr>



@empty


<tr>

<td colspan="6" class="center">

Belum ada proyek

</td>

</tr>



@endforelse



</tbody>


</table>



</body>

</html>