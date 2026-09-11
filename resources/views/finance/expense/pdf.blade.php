<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>
Laporan Pengeluaran Dana
</title>


<style>

@page{
    size:A4 landscape;
    margin:25px;
}


body{
    font-family: Arial, sans-serif;
    color:#1e293b;
    font-size:12px;
}


.header{
    text-align:center;
    margin-bottom:20px;
}


.company{
    font-size:18px;
    font-weight:bold;
    letter-spacing:1px;
}


.title{
    font-size:15px;
    font-weight:bold;
    margin-top:8px;
}


.subtitle{
    font-size:11px;
    color:#64748b;
    margin-top:5px;
}


.info-table{
    width:100%;
    margin-bottom:20px;
    border-collapse:collapse;
}


.info-table td{
    border:1px solid #cbd5e1;
    padding:8px;
}


.info-label{
    background:#e2e8f0;
    font-weight:bold;
    width:20%;
}



.data-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    font-size:10px;
}


.data-table th{
    background:#1e293b;
    color:white;
    padding:10px;
    text-align:center;
}


.data-table td{
    border:1px solid #cbd5e1;
    padding:8px;
}


.data-table tr:nth-child(even){
    background:#f8fafc;
}


.center{
    text-align:center;
}


.right{
    text-align:right;
}



.total-table{
    width:100%;
    margin-top:15px;
    border-collapse:collapse;
}


.total-table td{
    border:1px solid #cbd5e1;
    padding:10px;
    font-weight:bold;
}


.total-label{
    text-align:right;
    background:#e2e8f0;
}



.signature{
    width:100%;
    margin-top:50px;
}


.signature td{
    text-align:center;
    width:50%;
}


.space{
    height:50px;
}



.footer{
    margin-top:30px;
    text-align:center;
    font-size:10px;
    color:#64748b;
}


</style>


</head>


<body>


<div class="header">

<div class="company">

{{strtoupper($companyName)}}

</div>


<div class="title">

LAPORAN PENGELUARAN DANA

</div>


<div class="subtitle">

Finance & Accounting Department

</div>

</div>





<table class="info-table">

<tr>

<td class="info-label">
Jumlah Transaksi
</td>

<td>
{{$totalTransaction}} transaksi
</td>


<td class="info-label">
Tanggal Cetak
</td>

<td>
{{now()->format('d F Y')}}
</td>

</tr>


<tr>

<td class="info-label">
Periode
</td>

<td colspan="3">
{{$period}}
</td>

</tr>

</table>






<table class="data-table">

<thead>

<tr>

<th width="4%">
No
</th>


<th width="10%">
Tanggal
</th>


<th width="15%">
No Pengajuan
</th>


<th>
Pemohon
</th>


<th>
Project
</th>


<th>
Divisi
</th>


<th>
Bank
</th>


<th>
No Rekening
</th>


<th>
Nominal
</th>


</tr>

</thead>



<tbody>


@forelse($transactions as $index=>$transaction)


<tr>


<td class="center">
{{$index+1}}
</td>


<td class="center">

{{$transaction->tanggal
?
$transaction->tanggal->format('d-m-Y')
:
'-'}}

</td>


<td>

{{$transaction->pengajuanDana->nomor_pengajuan ?? '-'}}

</td>



<td>

{{$transaction->pengajuanDana->pengguna->name ?? '-'}}

</td>



<td>

{{$transaction->pengajuanDana->proyek->nama_proyek ?? '-'}}

</td>



<td>

{{$transaction->pengajuanDana->divisi->nama_divisi ?? '-'}}

</td>



<td>

{{$transaction->rekeningBank->nama_bank ?? '-'}}

</td>



<td>

{{$transaction->rekeningBank->nomor_rekening ?? '-'}}

</td>



<td class="right">

Rp {{number_format(
$transaction->jumlah,
0,
',',
'.'
)}}

</td>



</tr>


@empty


<tr>

<td colspan="9" class="center">

Belum ada transaksi

</td>

</tr>


@endforelse


</tbody>


</table>






<table class="total-table">

<tr>

<td class="total-label">

TOTAL PENGELUARAN

</td>


<td width="20%" class="right">

Rp {{number_format(
$totalExpense,
0,
',',
'.'
)}}

</td>


</tr>

</table>







<table class="signature">

<tr>

<td>
Disusun Oleh
</td>


<td>
Disetujui Oleh
</td>

</tr>



<tr>

<td class="space">
</td>


<td class="space">
</td>


</tr>



<tr>

<td>

Finance

</td>


<td>

{{$transactions->first()->penyetuju->name ?? 'Manager'}}

</td>


</tr>


</table>






<div class="footer">

Dokumen ini dibuat otomatis oleh sistem keuangan perusahaan.

</div>



</body>
</html>