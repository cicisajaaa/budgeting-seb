<!DOCTYPE html>
<html>

<head>

<title>
Analisis Performa Perusahaan
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

margin-bottom:25px;

}



.card{

border:1px solid #ddd;

padding:15px;

margin-bottom:15px;

}



.card-title{

font-weight:bold;

font-size:14px;

margin-bottom:8px;

color:#6b4f1d;

}



.value{

font-size:22px;

font-weight:bold;

}



table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}



td{

padding:12px;

border-bottom:1px solid #ddd;

}



.label{

color:#64748b;

}



.right{

text-align:right;

font-weight:bold;

}



.good{

color:#166534;

}



.warning{

color:#92400e;

}


</style>


</head>



<body>


<div class="header">


<h1>
Analisis Performa Perusahaan
</h1>


<p>
Sahabat Eksplorasi Banua
</p>


</div>




<div class="info">

Tanggal Analisis :
{{now()->format('d M Y')}}

</div>







<div class="card">


<div class="card-title">

Total Proyek

</div>


<div class="value">

{{$totalProject}}

</div>


</div>







<div class="card">


<div class="card-title">

Project Aktif

</div>


<div class="value">

{{$projectAktif}}

</div>


</div>







<div class="card">


<div class="card-title">

Rata-rata Progress Proyek

</div>


<div class="value">

{{number_format($progress,1)}}%

</div>


</div>









<h3>
Ringkasan Performa
</h3>





<table>


<tr>


<td class="label">

Jumlah Seluruh Proyek

</td>


<td class="right">

{{$totalProject}} Proyek

</td>


</tr>





<tr>


<td class="label">

Proyek Sedang Berjalan

</td>


<td class="right good">

{{$projectAktif}} Proyek

</td>


</tr>





<tr>


<td class="label">

Rata-rata Penyelesaian

</td>


<td class="right">

{{number_format($progress,1)}}%

</td>


</tr>





<tr>


<td class="label">

Status Perusahaan

</td>


<td class="right">


@if($progress >= 75)

<span class="good">
Performa Baik
</span>


@elseif($progress >= 50)


<span class="warning">
Perlu Monitoring
</span>


@else

Perlu Evaluasi

@endif


</td>


</tr>



</table>






</body>

</html>