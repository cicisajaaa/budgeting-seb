<!DOCTYPE html>
<html>
<head>

<title>
Laporan Keuangan
</title>


<style>

body{
font-family: Arial, sans-serif;
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


.summary{
width:100%;
border-collapse:collapse;
margin-bottom:25px;
}


.summary td{

border:1px solid #ddd;
padding:10px;

}



table{
width:100%;
border-collapse:collapse;
}


th{

background:#6b4f1d;
color:white;
padding:10px;

}


td{

padding:10px;
border-bottom:1px solid #ddd;

}



.right{

text-align:right;

}



</style>

</head>


<body>


<div class="header">

<h1>
Laporan Keuangan Perusahaan
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
Total Pendapatan
</td>


<td class="right">

Rp {{number_format($totalPendapatan,0,',','.')}}

</td>


</tr>



<tr>

<td>
Total Pengeluaran
</td>


<td class="right">

Rp {{number_format($totalPengeluaran,0,',','.')}}

</td>


</tr>



<tr>

<td>
Saldo Bersih
</td>


<td class="right">

Rp {{number_format($saldo,0,',','.')}}

</td>


</tr>



</table>







<h3>
Riwayat Pembayaran Masuk
</h3>



<table>


<thead>

<tr>

<th>
Tanggal
</th>

<th>
Project
</th>


<th>
Nominal
</th>


</tr>


</thead>


<tbody>


@forelse($transaksi as $item)


<tr>

<td>

{{$item->tanggal_setoran ?? '-'}}

</td>


<td>

{{$item->proyek->nama_proyek ?? '-'}}

</td>


<td class="right">

Rp {{number_format($item->jumlah_setoran,0,',','.')}}

</td>


</tr>


@empty


<tr>

<td colspan="3">

Tidak ada transaksi

</td>

</tr>


@endforelse


</tbody>


</table>



</body>

</html>