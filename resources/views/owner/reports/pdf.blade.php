<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>
Laporan Perusahaan
</title>


<style>

body{

    font-family: DejaVu Sans, sans-serif;

    font-size:12px;

    color:#1e293b;

}



.header{

    text-align:center;

    margin-bottom:15px;

}



.logo{

    width:75px;

}



.company{

    font-size:18px;

    font-weight:bold;

    color:#8B5E22;

    margin-top:8px;

}



.title{

    font-size:16px;

    font-weight:bold;

    margin-top:5px;

}



.date{

    color:#64748b;

    margin-top:5px;

}



.company-line{

    width:100%;

    height:4px;

    background:#8B5E22;

    margin-top:12px;

    margin-bottom:15px;

}







.report-info{

    width:100%;

    border-collapse:collapse;

    margin-bottom:15px;

}



.report-info td{

    padding:4px;

}



.report-info td:first-child{

    font-weight:bold;

    width:150px;

}







.section-title{

    font-size:14px;

    font-weight:bold;

    margin-top:15px;

    margin-bottom:8px;

}







.summary-table{

    width:100%;

    border-collapse:collapse;

}



.summary-table td{

    border:1px solid #ddd;

    padding:8px;

}



.summary-label{

    background:#f8fafc;

    font-weight:bold;

}







.project-table{

    width:100%;

    border-collapse:collapse;

    margin-top:8px;

    page-break-inside:auto;

}



.project-table tr{

    page-break-inside:avoid;

}



.project-table th{

    background:#8B5E22;

    color:white;

    padding:7px;

    text-align:center;

}



.project-table td{

    padding:7px;

    border:1px solid #ddd;

}







.badge{

    padding:4px 8px;

    border-radius:15px;

    font-size:10px;

}



.selesai{

    background:#dbeafe;

    color:#1d4ed8;

}



.berjalan{

    background:#dcfce7;

    color:#166534;

}







.signature{

    width:100%;

    margin-top:20px;

    page-break-inside:avoid;

}



.signature td{

    text-align:center;

}



.signature-space{

    height:35px;

}







.footer{

    margin-top:15px;

    text-align:right;

    font-size:10px;

    color:#64748b;

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

LAPORAN PERUSAHAAN

</div>



<div class="date">

Tanggal Cetak :

{{now()->format('d M Y')}}

</div>



<div class="company-line"></div>


</div>







<table class="report-info">


<tr>

<td>

Periode Laporan

</td>


<td>

: Semua Periode

</td>


</tr>



<tr>

<td>

Jenis Laporan

</td>


<td>

: Laporan Keseluruhan Perusahaan

</td>


</tr>



<tr>

<td>

Status Sistem

</td>


<td>

: Aktif

</td>


</tr>


</table>









<div class="section-title">

Ringkasan Keuangan

</div>



<table class="summary-table">


<tr>

<td class="summary-label">

Total Pendapatan

</td>


<td>

Rp {{number_format(
$totalPendapatan ?? 0,
0,
',',
'.'
)}}

</td>

</tr>




<tr>

<td class="summary-label">

Total Pengeluaran

</td>


<td>

Rp {{number_format(
$totalPengeluaran ?? 0,
0,
',',
'.'
)}}

</td>

</tr>




<tr>

<td class="summary-label">

Profit Bersih

</td>


<td>

Rp {{number_format(
$profit ?? 0,
0,
',',
'.'
)}}

</td>

</tr>




<tr>

<td class="summary-label">

Saldo Perusahaan

</td>


<td>

Rp {{number_format(
$saldo ?? 0,
0,
',',
'.'
)}}

</td>

</tr>


</table>









<div class="section-title">

Ringkasan Project

</div>



<table class="summary-table">


<tr>

<td class="summary-label">

Total Project

</td>


<td>

{{$totalProject ?? 0}} Project

</td>

</tr>




<tr>

<td class="summary-label">

Project Aktif

</td>


<td>

{{$projectAktif ?? 0}} Project

</td>

</tr>




<tr>

<td class="summary-label">

Rata-rata Progress

</td>


<td>

{{number_format(
$progressProject ?? 0,
1
)}}%

</td>

</tr>


</table>









<div class="section-title">

Monitoring Project

</div>





<table class="project-table">


<thead>

<tr>

<th>
Nama Project
</th>


<th>
Anggaran
</th>


<th>
Progress
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

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>




<td>

{{$project->progres_keseluruhan ?? 0}}%

</td>




<td>


@if(($project->progres_keseluruhan ?? 0)>=100)


<span class="badge selesai">

Selesai

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

<td colspan="4">

Belum ada project

</td>

</tr>


@endforelse



</tbody>


</table>









<table class="signature">


<tr>


<td>


Mengetahui,

<br>

Owner Perusahaan


<div class="signature-space"></div>


(........................)


</td>




<td>


Dibuat Oleh,

<br>

Sistem Manajemen Keuangan


<div class="signature-space"></div>


(........................)


</td>


</tr>


</table>








<div class="footer">


Dicetak oleh sistem pada

{{now()->format('d M Y H:i')}}


</div>




</body>

</html>