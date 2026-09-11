@extends('layouts.dashboard')

@section('content')


<div class="finance-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


<div>


<div class="welcome-label">
FINANCE MONITORING
</div>



<h1>
Riwayat Pengeluaran Dana
</h1>



<p>
Monitoring seluruh transaksi dana perusahaan yang sudah berhasil dicairkan.
</p>



<div class="welcome-tags">

<span>
Expense Control
</span>


<span>
Cash Flow Monitoring
</span>


<span>
Audit Tracking
</span>


</div>


</div>


</div>









{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card expense-card">


<div class="summary-icon">
💰
</div>


<div>

<label>
Total Pengeluaran
</label>


<h2>
Rp {{number_format($totalExpense,0,',','.')}}
</h2>


<small>
Dana telah dicairkan
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
📄
</div>


<div>

<label>
Jumlah Transaksi
</label>


<h2>
{{$totalTransaction}}
</h2>


<small>
Transaksi dana
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
📁
</div>


<div>

<label>
Total Project
</label>


<h2>
{{$totalProject}}
</h2>


<small>
Project terkait
</small>


</div>


</div>







<div class="summary-card">


<div class="summary-icon">
🏦
</div>


<div>

<label>
Bank Digunakan
</label>


<h2>
{{$totalBank}}
</h2>


<small>
Rekening pencairan
</small>


</div>


</div>





</div>









{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">
Filter Pengeluaran
</div>


<small class="panel-desc">
Pilih periode transaksi dana
</small>





<form method="GET"
action="{{route('finance.expense.index')}}">


<div class="filter-box">



<div>

<label>
Tanggal Mulai
</label>


<input

type="date"

name="start_date"

value="{{$request->start_date ?? ''}}"

>


</div>





<div>

<label>
Tanggal Akhir
</label>


<input

type="date"

name="end_date"

value="{{$request->end_date ?? ''}}"

>


</div>






<button>
Filter
</button>





<a href="{{route('finance.expense.index')}}">
Reset
</a>



</div>


</form>


</div>









{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">


<div>

<div class="panel-title">
Detail Pengeluaran Dana
</div>


<small class="panel-desc">
Riwayat transaksi dana yang sudah berhasil dicairkan
</small>


</div>





<div class="export-group">


<a href="{{route('finance.expense.export.excel')}}"
class="export-btn excel">

Export Excel

</a>





<a href="{{route('finance.expense.export.pdf')}}"
class="export-btn pdf">

Export PDF

</a>



</div>


</div>







<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
Tanggal
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
Nominal
</th>


<th>
Aksi
</th>


</tr>


</thead>





<tbody>


@forelse($transactions as $transaction)



<tr>



<td>

<strong>

{{$transaction->tanggal->format('d M Y')}}

</strong>

</td>





<td>


<strong>

{{$transaction->pengajuanDana->pengguna->name ?? '-'}}

</strong>


<br>


<small>

{{$transaction->pengajuanDana->judul ?? '-'}}

</small>


</td>





<td>


<strong>

{{$transaction->pengajuanDana->proyek->nama_proyek ?? '-'}}

</strong>


<br>


<small>

{{$transaction->pengajuanDana->proyek->perusahaan->nama_perusahaan ?? '-'}}

</small>


</td>






<td>

<span class="expense-badge">
    {{$transaction->pengajuanDana->divisi->nama_divisi ?? '-'}}
</span>

</td>






<td>

<span class="expense-badge">
    {{$transaction->rekeningBank->nama_bank ?? '-'}}
</span>

</td>






<td class="money">


Rp {{number_format(
$transaction->jumlah,
0,
',',
'.'
)}}


</td>






<td>


<a href="{{route(
'finance.expense.show',
$transaction->id
)}}"

class="detail-btn">

Detail

</a>


</td>




</tr>



@empty


<tr>


<td colspan="7"
class="empty">

Belum ada transaksi pencairan dana

</td>


</tr>


@endforelse



</tbody>


</table>


</div>



</div>



</div>

<style>


.finance-wrapper{
    width:100%;
}


/* ===============================
HEADER
================================ */


.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}





.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:white;

    border:1px solid #e2e8f0;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    color:#334155;

}









/* ===============================
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:25px;

}




.summary-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:22px;

    padding:16px;

    display:flex;

    align-items:center;

    gap:14px;

    position:relative;

    overflow:hidden;

    transition:.25s ease;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}




.summary-card:hover{

    transform:translateY(-4px);

    box-shadow:

    0 15px 35px rgba(15,23,42,.10);

}





.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

    background:#334155;

}



.expense-card::before{

    background:#ef4444;

}



.summary-icon{

    width:42px;

    height:42px;

    border-radius:14px;

    background:#fee2e2;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:18px;

}





.summary-card label{

    font-size:11px;

    color:#64748b;

}





.summary-card h2{

    margin:5px 0;

    font-size:18px;

    font-weight:800;

    color:#172033;

}





.summary-card small{

    font-size:10px;

    color:#94a3b8;

}









/* ===============================
PANEL
================================ */


.glass-panel{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:24px;


    padding:20px;


    margin-bottom:20px;


    box-shadow:


    0 10px 30px rgba(15,23,42,.06);


}




.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

}



.panel-desc{

    font-size:11px;

    color:#94a3b8;

}









/* ===============================
FILTER
================================ */


.filter-box{

    display:flex;

    gap:15px;

    align-items:end;

    margin-top:18px;

}



.filter-box label{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



.filter-box input{

    height:40px;

    padding:0 12px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:12px;

}



.filter-box button{

    height:40px;

    padding:0 22px;

    border:none;

    border-radius:12px;

    background:#1e293b;

    color:white;

    font-size:12px;

    font-weight:700;

    cursor:pointer;

}



.filter-box a{

    height:40px;

    display:flex;

    align-items:center;

    padding:0 20px;

    border-radius:12px;

    background:#f1f5f9;

    color:#334155;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

}









/* ===============================
HEADER TABLE
================================ */


.panel-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    margin-bottom:20px;

}



.export-group{

    display:flex;

    gap:10px;

}



.export-btn{

    padding:9px 15px;

    border-radius:12px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.export-btn.excel{

    background:#dcfce7;

    color:#166534;

}



.export-btn.pdf{

    background:#fee2e2;

    color:#dc2626;

}









/* ===============================
TABLE
================================ */


.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:13px;

    text-align:left;

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr{

    transition:.2s;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    color:#172033;

    font-size:13px;

}



td small{

    color:#94a3b8;

    font-size:10px;

}








/* ===============================
BADGE
================================ */


.badge{
    display:inline-block;

    background:#f1f5f9;

    color:#334155 !important;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    line-height:1.4;
    
}

.expense-badge{
    display:inline-block;

    background:#f1f5f9;

    color:#334155;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;
    
    line-height:1.4;
}





/* ===============================
MONEY
================================ */


.money{

    background:#f0fdf4;

    color:#166534;

    padding:8px;

    border-radius:10px;

    font-weight:800;

}








/* ===============================
BUTTON DETAIL
================================ */


.detail-btn{

    background:#1e293b;

    color:white;

    padding:7px 14px;

    border-radius:12px;

    font-size:10px;

    font-weight:700;

    text-decoration:none;

}









.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

}









/* ===============================
RESPONSIVE
================================ */


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:repeat(2,1fr);

}


}




@media(max-width:900px){


.summary-grid{

    grid-template-columns:1fr;

}



.filter-box{

    flex-direction:column;

    align-items:stretch;

}



.panel-header{

    flex-direction:column;

    align-items:flex-start;

}



.export-group{

    width:100%;

}



.export-btn{

    flex:1;

    text-align:center;

}



}


</style>

@endsection