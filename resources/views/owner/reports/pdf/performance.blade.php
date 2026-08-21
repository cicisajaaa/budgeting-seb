<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">


<title>
Analisis Performa Perusahaan
</title>


<style>

body{

font-family: DejaVu Sans, sans-serif;

font-size:12px;

color:#1e293b;

}



.header{

text-align:center;

margin-bottom:30px;

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

.card-table{

width:100%;

border-collapse:separate;

border-spacing:10px 0;

margin-top:20px;

}



.card{

border:1px solid #ddd;

padding:15px;

border-radius:8px;

height:70px;

}



.label{

font-size:11px;

color:#64748b;

}



.value{

font-size:22px;

font-weight:bold;

margin-top:8px;

color:#1e293b;

}





.progress-box{

margin-top:25px;

}



.progress-bg{

height:18px;

width:100%;

background:#e5e7eb;

border-radius:20px;

}



.progress-fill{

height:18px;

background:#8B5E22;

border-radius:20px;

}


.danger{

background:#fee2e2;

color:#991b1b;

}




table{

width:100%;

border-collapse:collapse;

margin-top:25px;

}



td{

padding:10px;

border-bottom:1px solid #ddd;

}



td:first-child{

font-weight:bold;

}





.footer{

margin-top:30px;

text-align:right;

font-size:11px;

color:#64748b;

}


.status{

font-weight:bold;

padding:6px 12px;

border-radius:15px;

}


.good{

background:#dcfce7;

color:#166534;

}


.warning{

background:#fef3c7;

color:#92400e;

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

ANALISIS PERFORMA PERUSAHAAN

</div>



<div class="info">

Tanggal :
{{($tanggal ?? now())->format('d M Y')}}

</div>




</div>



<table class="card-table">

<tr>


<td class="card">


<div class="label">
Total Project
</div>


<div class="value">
{{$totalProject ?? 0}}
</div>


</td>



<td class="card">


<div class="label">
Project Aktif
</div>


<div class="value">
{{$projectAktif ?? 0}}
</div>


</td>




<td class="card">


<div class="label">
Rata-rata Progress Project
</div>


<div class="value">

{{number_format($progress ?? 0,1)}}%

</div>


</td>




<td class="card">


<div class="label">
Project Selesai
</div>


<div class="value">

{{$projectSelesai ?? 0}}

</div>


</td>


</tr>

</table>






<div class="progress-box">


<p>
Tingkat Penyelesaian Project :
<strong>
{{number_format($progress ?? 0,1)}}%
</strong>
</p>

<div class="progress-bg">


<div class="progress-fill"

style="width:
{{min($progress ?? 0,100)}}%"

</div>


</div>


</div>





<h3>
Ringkasan Evaluasi
</h3>

<table>


<tr>

<td>

Status Operasional

</td>
<td>
@if(($status ?? '') == 'Performa Sangat Baik')

<span class="status good">
{{ $status }}
</span>

@elseif(($status ?? '') == 'Performa Cukup Baik')

<span class="status warning">
{{ $status }}
</span>

@else

<span class="status danger">
{{ $status ?? 'Perlu Monitoring' }}
</span>

@endif

</td>
</tr>





<tr>

<td>

Jumlah Project Berjalan

</td>


<td>

{{$projectAktif ?? 0}} Project

</td>


</tr>





<tr>

<td>

Evaluasi Performa

</td>


<td>

Berdasarkan rata-rata progres 
{{number_format($progress ?? 0,1)}}%
dari seluruh project yang tercatat.

</td>


</tr>



</table>








<div class="footer">


Dicetak oleh sistem pada

{{$tanggal->format('d M Y H:i')}}


</div>




</body>

</html>