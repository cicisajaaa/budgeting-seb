@extends('layouts.dashboard')

@section('content')


<div class="finance-wrapper">


{{-- HEADER --}}

<div class="welcome-card">


<div class="welcome-content">


<div class="welcome-label">
DISTRIBUSI DANA
</div>


<h1>
Monitoring Distribusi Keuangan
</h1>


<p>
Melihat penyebaran dana project ke setiap divisi perusahaan.
</p>



<div class="welcome-tags">

<span>
✓ Project Allocation
</span>


<span>
✓ Finance Flow
</span>


<span>
✓ Division Control
</span>


</div>


</div>


</div>









{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card distribution-card">


<div class="summary-icon green">
💰
</div>


<div>

<label>
Total Distribusi
</label>


<h2>
Rp {{number_format($totalDistribution,0,',','.')}}
</h2>


<small>
Dana tersalurkan
</small>


</div>


</div>







<div class="summary-card transaction-card">


<div class="summary-icon blue">
📄
</div>


<div>

<label>
Total Transaksi
</label>


<h2>
{{$totalTransaction}}
</h2>


<small>
Distribusi dana
</small>


</div>


</div>







<div class="summary-card division-card">


<div class="summary-icon purple">
🏢
</div>


<div>

<label>
Jumlah Divisi
</label>


<h2>
{{$totalDivision}}
</h2>


<small>
Penerima dana
</small>


</div>


</div>







<div class="summary-card project-card">


<div class="summary-icon orange">
📁
</div>


<div>

<label>
Project Terdistribusi
</label>


<h2>
{{$totalProject}}
</h2>


<small>
Project aktif
</small>


</div>


</div>





</div>









{{-- TABLE --}}


<div class="glass-panel">



<div class="panel-header">


<div>
<div class="panel-header distribution-header">

    <div>

        <div class="panel-title">
            Riwayat Distribusi Dana
        </div>

        <small>
            Detail pembagian dana project ke setiap divisi
        </small>

    </div>


    <form
        method="GET"
        action="{{ route('finance.distribution') }}"
        class="distribution-search-form">

        <div class="distribution-search">

            <i class="fas fa-search"></i>

            <input
                type="text"
                name="search"
                value="{{ $request->search ?? '' }}"
                placeholder="Cari project atau divisi...">

        </div>


        @if($request->filled('search'))

            <a
                href="{{ route('finance.distribution') }}"
                class="distribution-reset">

                Reset

            </a>

        @endif


        <button
            type="submit"
            class="distribution-search-btn">

            Cari

        </button>

    </form>

</div>







<div class="table-wrapper">

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
Divisi
</th>


<th>
Nominal
</th>


</tr>

</thead>





<tbody>


@forelse($distributions as $distribution)



<tr>


<td>

<div class="date-box">

{{\Carbon\Carbon::parse(
$distribution->created_at
)->format('d M Y')}}

</div>


</td>






<td>

<strong>

{{$distribution->setoranProyek?->proyek?->nama_proyek ?? '-'}}

</strong>

</td>






<td>

<span class="division-badge">

{{$distribution->divisi?->nama_divisi ?? '-'}}

</span>

</td>






<td class="money">


Rp {{number_format(
$distribution->nominal_diterima,
0,
',',
'.'
)}}


</td>



</tr>



@empty



<tr>

<td colspan="4" class="empty">

Belum ada distribusi dana

</td>

</tr>


@endforelse



</tbody>



</table>
<div>





<div class="total-footer">


<span>
Total Dana Tersalurkan
</span>


<strong>

Rp {{number_format(
$totalDistribution,
0,
',',
'.'
)}}

</strong>


</div>





</div>






</div>









<style>


.finance-wrapper{

width:100%;

}




/* HEADER */


.welcome-card{


background:#f8fafc;


border:1px solid #e2e8f0;


border-radius:24px;


padding:28px;


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

margin:12px 0;

font-size:25px;

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

margin-top:18px;

}



.welcome-tags span{

background:white;

border:1px solid #e2e8f0;

padding:7px 13px;

border-radius:999px;

font-size:10px;

font-weight:700;

color:#334155;

}









/* SUMMARY */


.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:16px;

margin-bottom:25px;

}



.summary-card{


background:white;


border:1px solid #e5e7eb;


border-radius:22px;


padding:18px;


display:flex;


align-items:center;


gap:15px;


position:relative;


overflow:hidden;


transition:.25s;


box-shadow:

0 10px 30px rgba(15,23,42,.05);


}



.summary-card:hover{

transform:translateY(-5px);

}





.summary-card::before{

content:"";

position:absolute;

top:0;

left:0;

width:100%;

height:4px;

}



.distribution-card::before{

background:#22c55e;

}



.transaction-card::before{

background:#3b82f6;

}



.division-card::before{

background:#8b5cf6;

}



.project-card::before{

background:#f59e0b;

}





.summary-icon{

width:45px;

height:45px;

border-radius:15px;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}



.green{

background:#dcfce7;

}



.blue{

background:#dbeafe;

}



.purple{

background:#ede9fe;

}



.orange{

background:#fef3c7;

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









/* PANEL */


.glass-panel{


background:white;


border:1px solid #e5e7eb;


border-radius:24px;


padding:20px;


box-shadow:

0 10px 30px rgba(15,23,42,.06);


}



.panel-header{

margin-bottom:18px;

}



.panel-title{

font-size:16px;

font-weight:800;

color:#172033;

}



.panel-header small{

font-size:11px;

color:#94a3b8;

}









/* TABLE */


table{

width:100%;

border-collapse:collapse;

}



th{

background:#f8fafc;

padding:14px;

font-size:11px;

color:#64748b;

text-align:left;

}



td{

padding:15px;

font-size:12px;

border-bottom:1px solid #f1f5f9;

color:#334155;

}



tbody tr{

transition:.2s;

}



tbody tr:hover{

background:#f8fafc;

transform:scale(1.005);

}



td strong{

color:#172033;

}





.date-box{

font-size:12px;

color:#64748b;

}





.division-badge{

background:#ede9fe;

color:#6d28d9;

padding:6px 12px;

border-radius:999px;

font-size:10px;

font-weight:700;

}





.money{

text-align:right;

font-weight:800;

color:#16a34a;

}





.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}









.total-footer{


margin-top:20px;


background:#f8fafc;


border:1px solid #e2e8f0;


border-radius:18px;


padding:18px;


display:flex;


justify-content:space-between;


align-items:center;


}



.total-footer span{

font-size:12px;

color:#64748b;

}



.total-footer strong{

font-size:20px;

color:#16a34a;

}





/* ===============================
   TABLE WRAPPER
================================ */

.table-wrapper{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.table-wrapper table{
    min-width:650px;
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

    .welcome-card{
        padding:22px;
        border-radius:20px;
    }

    .welcome-label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
    }

    .welcome-tags{
        flex-wrap:wrap;
        gap:7px;
    }

    .welcome-tags span{
        font-size:9px;
        padding:6px 9px;
    }


    .summary-grid{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .summary-card{
        min-width:0;
        padding:14px;
        border-radius:18px;
        gap:10px;
    }

    .summary-icon{
        width:38px;
        height:38px;
        border-radius:11px;
        font-size:17px;
        flex-shrink:0;
    }

    .summary-card > div:last-child{
        min-width:0;
    }

    .summary-card label{
        font-size:9px;
    }

    .summary-card h2{
        font-size:17px;
        line-height:1.4;
        word-break:break-word;
    }

    .summary-card small{
        font-size:8px;
    }


    .glass-panel{
        padding:15px;
        border-radius:20px;
        overflow:hidden;
    }

    .panel-header{
        margin-bottom:15px;
    }

    .panel-title{
        font-size:14px;
        line-height:1.4;
    }

    .panel-header small{
        font-size:9px;
        line-height:1.4;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        margin-top:5px;
    }

    .table-wrapper table{
        min-width:650px;
    }

    th{
        padding:11px;
        font-size:9px;
        white-space:nowrap;
    }

    td{
        padding:12px 11px;
        font-size:10px;
        white-space:nowrap;
    }

    td strong{
        font-size:11px;
    }

    .date-box{
        font-size:9px;
    }

    .division-badge{
        padding:5px 9px;
        font-size:8px;
        white-space:nowrap;
    }

    .money{
        font-size:10px;
    }


    .total-footer{
        margin-top:15px;
        padding:14px;
        border-radius:15px;
        gap:10px;
    }

    .total-footer span{
        font-size:9px;
    }

    .total-footer strong{
        font-size:17px;
        word-break:break-word;
        text-align:right;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
        line-height:1.35;
    }

    .welcome-card p{
        font-size:10px;
        line-height:1.5;
    }

    .welcome-tags{
        gap:6px;
        margin-top:12px;
    }

    .welcome-tags span{
        font-size:8px;
        padding:5px 8px;
    }


    .summary-grid{
        grid-template-columns:1fr;
        gap:10px;
        margin-bottom:18px;
    }

    .summary-card{
        padding:12px;
        border-radius:15px;
        gap:8px;
    }

    .summary-icon{
        width:34px;
        height:34px;
        border-radius:10px;
        font-size:14px;
    }

    .summary-card label{
        font-size:8px;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0;
    }

    .summary-card small{
        font-size:7px;
    }


    .glass-panel{
        padding:12px;
        border-radius:17px;
    }

    .panel-title{
        font-size:13px;
    }

    .panel-header small{
        font-size:8px;
    }


    .table-wrapper{
        margin-left:0;
        margin-right:0;
    }

    .table-wrapper table{
        min-width:600px;
    }

    th{
        padding:9px;
        font-size:8px;
    }

    td{
        padding:10px 9px;
        font-size:9px;
    }

    td strong{
        font-size:10px;
    }

    .date-box{
        font-size:8px;
    }

    .division-badge{
        padding:5px 8px;
        font-size:7px;
    }

    .money{
        font-size:9px;
    }


    .total-footer{
        flex-direction:column;
        align-items:flex-start;
        padding:12px;
        gap:5px;
    }

    .total-footer span{
        font-size:8px;
    }

    .total-footer strong{
        font-size:16px;
        text-align:left;
    }

}
/* =====================================================
DISTRIBUTION SEARCH
===================================================== */

.distribution-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}


.distribution-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}


.distribution-search {
    position: relative;
    width: 280px;
}


.distribution-search i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    pointer-events: none;
}


.distribution-search input {
    width: 100%;
    height: 42px;

    padding: 0 14px 0 38px;

    border: 1px solid #e2e8f0;
    border-radius: 11px;

    background: #f8fafc;
    color: #334155;

    font-size: 12px;

    transition: .2s;
}


.distribution-search input::placeholder {
    color: #94a3b8;
}


.distribution-search input:focus {
    outline: none;

    background: white;

    border-color: #64748b;

    box-shadow:
        0 0 0 3px rgba(100,116,139,.08);
}


.distribution-search-btn,
.distribution-reset {

    height: 42px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0 16px;

    border-radius: 11px;

    font-size: 12px;
    font-weight: 700;

    text-decoration: none;

    cursor: pointer;
}


.distribution-search-btn {

    border: none;

    background: #334155;
    color: white;

    transition: .2s;
}


.distribution-search-btn:hover {
    background: #1e293b;
}


.distribution-reset {

    background: #f8fafc;

    color: #64748b;

    border: 1px solid #e2e8f0;
}


.distribution-reset:hover {

    background: #f1f5f9;

    color: #334155;
}


@media(max-width:900px) {

    .distribution-header {
        align-items: stretch;
    }

    .distribution-search-form {
        width: 100%;
    }

    .distribution-search {
        flex: 1;
        min-width: 200px;
    }

}


@media(max-width:600px) {

    .distribution-search-form {
        display: grid;
        grid-template-columns: 1fr auto;
        width: 100%;
    }

    .distribution-search {
        width: 100%;
        min-width: 0;
    }

    .distribution-search-btn,
    .distribution-reset {
        width: 100%;
    }

    .distribution-search-btn {
        grid-column: 2;
    }

    .distribution-reset {
        grid-column: 1;
        grid-row: 2;
    }

}
</style>


@endsection