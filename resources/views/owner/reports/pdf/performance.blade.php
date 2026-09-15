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

    margin:35px;

}



/* HEADER */

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

    margin-top:8px;

    color:#64748b;

    font-size:11px;

}



.divider{

    margin-top:20px;

    border-bottom:2px solid #8B5E22;

}



/* SUMMARY */

.summary-table{

    width:100%;

    border-collapse:separate;

    border-spacing:10px;

    margin-top:20px;

}



.summary-card{

    border:1px solid #d1d5db;

    border-radius:10px;

    padding:15px;

    height:70px;

}



.label{

    font-size:10px;

    color:#64748b;

    text-transform:uppercase;

}



.value{

    font-size:22px;

    font-weight:bold;

    color:#1e293b;

    margin-top:8px;

}





/* SECTION */

.section-title{

    margin-top:25px;

    font-size:14px;

    font-weight:bold;

    color:#1e293b;

    border-left:4px solid #8B5E22;

    padding-left:8px;

}





/* PROGRESS */

.progress-box{

    margin-top:15px;

}



.progress-info{

    margin-bottom:8px;

}



.progress-bg{

    width:100%;

    height:18px;

    background:#e5e7eb;

    border-radius:20px;

    overflow:hidden;

}



.progress-fill{

    height:18px;

    background:#8B5E22;

}





/* EVALUATION */

table{

    width:100%;

    border-collapse:collapse;

    margin-top:15px;

}



td{

    padding:12px;

    border-bottom:1px solid #e2e8f0;

}



td:first-child{

    width:35%;

    font-weight:bold;

    color:#475569;

}



.status{

    display:inline-block;

    padding:6px 14px;

    border-radius:20px;

    font-weight:bold;

}



.good{

    background:#dcfce7;

    color:#166534;

}



.warning{

    background:#fef3c7;

    color:#92400e;

}



.danger{

    background:#fee2e2;

    color:#991b1b;

}





/* FOOTER */

.footer{

    margin-top:35px;

    text-align:right;

    font-size:10px;

    color:#64748b;

}



</style>


</head>



<body>


<div class="header">


<img

src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('images/logo-cv.png')))}}"

class="logo"


>


<div class="company">

CV SAHABAT EKSPLORASI BANUA

</div>



<div class="title">

ANALISIS PERFORMA PERUSAHAAN

</div>



<div class="info">

Tanggal Laporan :

{{($tanggal ?? now())->format('d M Y')}}

</div>


<div class="divider"></div>


</div>





<table class="summary-table">

<tr>


<td class="summary-card">

<div class="label">

Total Project

</div>


<div class="value">

{{$totalProject ?? 0}}

</div>


</td>





<td class="summary-card">


<div class="label">

Project Aktif

</div>


<div class="value">

{{$projectAktif ?? 0}}

</div>


</td>





<td class="summary-card">


<div class="label">

Rata-rata Progress

</div>


<div class="value">

{{number_format($progress ?? 0,1)}}%

</div>


</td>





<td class="summary-card">


<div class="label">

Project Selesai

</div>


<div class="value">

{{$projectSelesai ?? 0}}

</div>


</td>



</tr>

</table>






<div class="section-title">

Progress Penyelesaian Project

</div>



<div class="progress-box">


<div class="progress-info">

Total penyelesaian :

<strong>

{{number_format($progress ?? 0,1)}}%

</strong>


</div>



<div class="progress-bg">


<div class="progress-fill"

style="width:{{min($progress ?? 0,100)}}%">

</div>


</div>


</div>







<div class="section-title">

Ringkasan Evaluasi

</div>




<table>



<tr>


<td>

Status Operasional

</td>



<td>


@if(($status ?? '') == 'Performa Sangat Baik')


<span class="status good">

{{$status}}

</span>


@elseif(($status ?? '') == 'Performa Cukup Baik')


<span class="status warning">

{{$status}}

</span>


@else


<span class="status danger">

{{$status ?? 'Perlu Monitoring'}}

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

{{($tanggal ?? now())->format('d M Y H:i')}}

</div>




</body>

</html>