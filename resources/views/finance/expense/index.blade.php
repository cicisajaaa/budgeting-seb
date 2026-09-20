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



<form
    method="GET"
    action="{{ route('finance.expense.index') }}"
    class="expense-filter-form">

    <div class="expense-filter-grid">

        {{-- TANGGAL MULAI --}}
        <div class="expense-filter-field">

            <label for="start_date">
                Tanggal Mulai
            </label>

            <div class="expense-date-input">

                <i class="fas fa-calendar-alt"></i>

                <input
                    id="start_date"
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}">

            </div>

        </div>


        {{-- TANGGAL AKHIR --}}
        <div class="expense-filter-field">

            <label for="end_date">
                Tanggal Akhir
            </label>

            <div class="expense-date-input">

                <i class="fas fa-calendar-alt"></i>

                <input
                    id="end_date"
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}">

            </div>

        </div>


        {{-- ACTION --}}
        <div class="expense-filter-actions">

            <button
                type="submit"
                class="expense-filter-submit">

                <i class="fas fa-filter"></i>

                <span>Tampilkan</span>

            </button>


            @if(request('start_date') || request('end_date'))

                <a
                    href="{{ route('finance.expense.index') }}"
                    class="expense-filter-reset">

                    <i class="fas fa-rotate-left"></i>

                    <span>Reset</span>

                </a>

            @endif

        </div>

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


<a
    href="{{ route('finance.expense.export.excel', [
        'start_date' => $request->start_date,
        'end_date' => $request->end_date
    ]) }}"
    class="export-btn excel">

    Export Excel

</a>




<a
    href="{{ route('finance.expense.export.pdf', [
        'start_date' => $request->start_date,
        'end_date' => $request->end_date
    ]) }}"
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
        font-size:16px;
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

    .panel-title{
        font-size:14px;
    }

    .panel-desc{
        font-size:9px;
        line-height:1.5;
    }


    .filter-box{
        flex-direction:column;
        align-items:stretch;
        gap:12px;
    }

    .filter-box > div{
        width:100%;
    }

    .filter-box input{
        width:100%;
        box-sizing:border-box;
        height:42px;
        font-size:11px;
    }

    .filter-box button,
    .filter-box a{
        width:100%;
        height:42px;
        box-sizing:border-box;
        justify-content:center;
        text-align:center;
        font-size:10px;
    }


    .panel-header{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }

    .export-group{
        width:100%;
        display:flex;
        gap:8px;
    }

    .export-btn{
        flex:1;
        text-align:center;
        padding:9px 8px;
        font-size:9px;
    }


    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .table-wrapper table{
        min-width:950px;
    }

    th{
        padding:11px;
        font-size:9px;
        white-space:nowrap;
    }

    td{
        padding:11px;
        font-size:10px;
        white-space:nowrap;
    }

    td strong{
        font-size:10px;
    }

    td small{
        font-size:8px;
    }

    .expense-badge{
        padding:5px 9px;
        font-size:8px;
        white-space:nowrap;
    }

    .money{
        padding:7px;
        font-size:9px;
        white-space:nowrap;
    }

    .detail-btn{
        padding:6px 10px;
        font-size:8px;
        white-space:nowrap;
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

    .panel-desc{
        font-size:8px;
    }


    .filter-box{
        gap:10px;
        margin-top:14px;
    }

    .filter-box label{
        font-size:9px;
        margin-bottom:6px;
    }

    .filter-box input{
        height:40px;
        font-size:10px;
    }

    .filter-box button,
    .filter-box a{
        height:40px;
        font-size:9px;
    }


    .export-group{
        gap:7px;
    }

    .export-btn{
        padding:8px 6px;
        border-radius:10px;
        font-size:8px;
    }


    .table-wrapper table{
        min-width:900px;
    }

    th{
        padding:9px;
        font-size:8px;
    }

    td{
        padding:9px;
        font-size:8px;
    }

    td strong{
        font-size:9px;
    }

    td small{
        font-size:7px;
    }

    .expense-badge{
        padding:5px 8px;
        font-size:7px;
    }

    .money{
        padding:6px;
        font-size:8px;
    }

    .detail-btn{
        padding:6px 9px;
        font-size:7px;
    }


    .empty{
        padding:25px 10px;
        font-size:9px;
    }

}
/* =====================================================
   EXPENSE FILTER
===================================================== */

.expense-filter-form {
    width: 100%;
}

.expense-filter-grid {
    display: grid;
    grid-template-columns: minmax(220px, 1fr) minmax(220px, 1fr) auto;
    align-items: end;
    gap: 14px;

    width: 100%;
    padding: 18px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;

    box-sizing: border-box;
}

.expense-filter-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
    min-width: 0;
}

.expense-filter-field label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
}

/* DATE INPUT */

.expense-date-input {
    position: relative;
    width: 100%;
}

.expense-date-input > i {
    position: absolute;
    left: 13px;
    top: 50%;

    transform: translateY(-50%);

    color: #94a3b8;
    font-size: 13px;

    pointer-events: none;
    z-index: 1;
}

.expense-date-input input {
    width: 100%;
    height: 44px;

    padding: 0 13px 0 38px;

    border: 1px solid #dbe2ea;
    border-radius: 11px;

    background: #ffffff;
    color: #334155;

    font-size: 12px;
    font-family: inherit;

    box-sizing: border-box;

    transition: .2s;
    cursor: pointer;
}

.expense-date-input input:hover {
    border-color: #cbd5e1;
}

.expense-date-input input:focus {
    outline: none;

    border-color: #64748b;

    box-shadow:
        0 0 0 3px rgba(100,116,139,.08);
}

/* ACTION */

.expense-filter-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* TAMPILKAN */

.expense-filter-submit {
    height: 44px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 0 17px;

    border: none;
    border-radius: 11px;

    background: #334155;
    color: #ffffff;

    font-size: 12px;
    font-weight: 700;
    font-family: inherit;

    white-space: nowrap;

    cursor: pointer;

    transition: .2s;
}

.expense-filter-submit:hover {
    background: #1e293b;
    transform: translateY(-1px);
}

.expense-filter-submit:active {
    transform: translateY(0);
}

/* RESET */

.expense-filter-reset {
    height: 44px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 0 15px;

    border: 1px solid #e2e8f0;
    border-radius: 11px;

    background: #ffffff;
    color: #64748b;

    font-size: 12px;
    font-weight: 700;
    font-family: inherit;

    text-decoration: none;
    white-space: nowrap;

    transition: .2s;
}

.expense-filter-reset:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #334155;
}

/* =====================================================
   TABLET
===================================================== */

@media (max-width: 900px) {

    .expense-filter-grid {
        grid-template-columns: 1fr 1fr;
    }

    .expense-filter-actions {
        grid-column: 1 / -1;
        justify-content: flex-start;
    }

}

/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 600px) {

    .expense-filter-grid {
        grid-template-columns: 1fr;

        gap: 13px;
        padding: 15px;

        border-radius: 14px;
    }

    .expense-filter-actions {
        width: 100%;

        display: grid;
        grid-template-columns: 1fr 1fr;

        gap: 8px;
    }

    .expense-filter-submit,
    .expense-filter-reset {
        width: 100%;
    }

}
</style>

@endsection