<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>
Laporan Keuangan
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

margin-bottom:10px;

}


.company{

font-size:18px;

font-weight:bold;

color:#8B5E22;

}


.title{

font-size:16px;

font-weight:bold;

margin-top:5px;

}


.info{

margin-top:10px;

color:#64748b;

}



/* SUMMARY CARD */




.summary{

width:100%;

margin-top:20px;

}

.summary-table{

    width:100%;

    border-collapse:separate;

    border-spacing:10px 0;

}



.summary-card{

    border:1px solid #ddd;

    border-radius:8px;

    padding:15px;

    height:65px;

    vertical-align:middle;

}



.label{

    font-size:10px;

    color:#64748b;

    margin-bottom:8px;

}



.value{

    font-size:15px;

    font-weight:bold;

    white-space:nowrap;

    color:#1e293b;

}

/* TABLE */

table{

width:100%;

border-collapse:collapse;

margin-top:25px;

}



th{

background:#8B5E22;

color:white;

padding:8px;

text-align:center;

font-size:11px;

}



td{

padding:9px 8px;

line-height:1.4;

border:1px solid #ddd;

font-size:11px;

vertical-align:middle;

word-wrap:break-word;

}





/* KOLOM */
th:nth-child(1),
td:nth-child(1){
width:5%;
text-align:center;
}


th:nth-child(2),
td:nth-child(2){
width:15%;
text-align:center;
white-space:nowrap;
}


th:nth-child(3),
td:nth-child(3){
width:22%;
}


th:nth-child(4),
td:nth-child(4){
width:22%;
}


th:nth-child(5),
td:nth-child(5){
width:18%;
text-align:center;
white-space:nowrap;
}


th:nth-child(6),
td:nth-child(6){
width:18%;
text-align:center;
}



thead{

display:table-header-group;

}



tr{

page-break-inside:avoid;

}





/* STATUS NOMINAL */

.income,
.expense{

font-weight:bold;

font-size:11px;

}


.income{

color:#15803d;

}


.expense{

color:#dc2626;

}





/* FOOTER */

.footer{

margin-top:30px;

text-align:right;

font-size:11px;

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

LAPORAN KEUANGAN PERUSAHAAN

</div>



<div class="info">

Tanggal :
{{now()->format('d M Y')}}

</div>


</div>




<table class="summary-table">

<tr>


<td class="summary-card">

<div class="label">
Total Pendapatan
</div>

<div class="value">
Rp {{number_format($totalPendapatan ?? 0,0,',','.')}}
</div>

</td>




<td class="summary-card">

<div class="label">
Total Pengeluaran
</div>

<div class="value">
Rp {{number_format($totalPengeluaran ?? 0,0,',','.')}}
</div>

</td>




<td class="summary-card">

<div class="label">
Saldo Bersih
</div>

<div class="value">
Rp {{number_format($saldo ?? 0,0,',','.')}}
</div>

</td>




<td class="summary-card">

<div class="label">
Total Transaksi
</div>

<div class="value">
{{$totalTransaksi ?? 0}}
</div>

</td>



</tr>

</table>






<h3>

Detail Transaksi

</h3>





<table>


<thead>

<tr>

<th>

    No

</th>    

<th>

Tanggal

</th>



<th>

Keterangan

</th>



<th>

Project

</th>



<th>

Nominal

</th>



<th>

Jenis

</th>



</tr>


</thead>





<tbody>



@forelse($transaksi as $index => $item)



<tr>

<td>

{{$loop->iteration}}

</td>



<td>

{{\Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y')}}

</td>




<td>

{{$item['keterangan']}}

</td>





<td>

{{$item['project']}}

</td>





<td>



@if($item['jenis']=="Pemasukan")



<span class="income">

+ Rp&nbsp;{{number_format(
$item['nominal'],
0,
',',
'.'
)}}
</span>



@else


<span class="expense">

- Rp&nbsp;{{number_format(
$item['nominal'],
0,
',',
'.'
)}}


</span>



@endif



</td>




<td align="center">


@if($item['jenis']=="Pemasukan")

<span class="income">

Pemasukan

</span>


@else

<span class="expense">

Pengeluaran

</span>


@endif


</td>


</tr>





@empty


<tr>


<td colspan="6" align="center">

Belum ada transaksi

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