@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
APPROVAL DANA
</div>


<h1>
Persetujuan Pengajuan Dana
</h1>


<p>
Kelola pengajuan dana karyawan dan lakukan proses persetujuan keuangan perusahaan.
</p>


<div class="welcome-tags">

<span>
✓ Finance Control
</span>


<span>
✓ Audit Approval
</span>


<span>
✓ Monitoring Dana
</span>


</div>


</div>


</div>






@if(session('success'))

<div class="success-box">

{{session('success')}}

</div>

@endif



@if(session('error'))

<div class="error-box">
{{session('error')}}
</div>

@endif



@if($banks->count()==0)

<div class="error-box">

⚠ Belum ada rekening aktif untuk pencairan dana. 
Silakan tambahkan rekening bank terlebih dahulu.

</div>

@endif





{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">

<div class="summary-icon">
⏳
</div>


<div>

<label>
Menunggu Approval
</label>

<h2>
{{$requests->count()}}
</h2>

<small>
Pengajuan pending
</small>


</div>


</div>







<div class="summary-card">

<div class="summary-icon">
💰
</div>


<div>

<label>
Total Dana Diajukan
</label>

<h2>
Rp {{number_format($requests->sum('jumlah'),0,',','.')}}
</h2>

<small>
Nominal pending
</small>


</div>


</div>


</div>









<div class="glass-panel">


<div class="panel-title">

📋 Daftar Pengajuan Dana

</div>


<small class="subtitle">
Pengajuan yang membutuhkan keputusan keuangan
</small>







<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Pemohon
</th>

<th>
Perusahaan
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

<th>
Tanggal
</th>

<th>
Aksi
</th>


</tr>


</thead>




<tbody>


@forelse($requests as $request)



<tr>


<td>


<strong>
{{$request->pengguna->name ?? '-'}}
</strong>


<br>


<small>
{{$request->judul}}
</small>


</td>

<td>

<strong>
{{$request->proyek->perusahaan->nama_perusahaan ?? '-'}}
</strong>

<br>

<small>

{{$request->proyek->perusahaan->alamat ?? ''}}

</small>

</td>



<td>

<strong>
{{$request->proyek->nama_proyek ?? '-'}}
</strong>

<br>

<small>

Sisa Budget:
Rp {{number_format(
$request->proyek->sisa_budget ?? 0,
0,
',',
'.'
)}}

</small>

</td>




<td>

{{$request->divisi->nama_divisi ?? '-'}}

</td>





<td class="money">


Rp {{number_format($request->jumlah,0,',','.')}}

</td>





<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>







<td>



<div class="action-group-column">



<a href="{{route('expense.approval.detail',$request->id)}}"
class="detail-btn">

Detail

</a>





<form method="POST"
action="{{route('expense.approve',$request->id)}}">


@csrf


<select name="rekening_bank_id" required>

<option value="">
Pilih Rekening Pencairan
</option>


@foreach($banks as $bank)

<option value="{{$bank->id}}">

{{$bank->nama_bank}}
-
Rp {{number_format($bank->saldo,0,',','.')}}

</option>

@endforeach


</select>

@if(
$banks->count()>0 &&
$request->proyek->sisa_budget >= $request->jumlah
)

<button class="approve-btn"
onclick="return confirm('Setujui pengajuan ini?')">

Setujui

</button>


@else

<button class="reject-btn" disabled>

Tidak Bisa Approve

</button>

@endif

</form>







<form method="POST"
action="{{route('expense.reject',$request->id)}}">


@csrf


<input type="hidden"
name="catatan_persetujuan"
value="Ditolak oleh keuangan">



<button class="reject-btn"
onclick="return confirm('Tolak pengajuan ini?')">

Tolak

</button>


</form>




</div>



</td>




</tr>





@empty


<tr>

<td colspan="7"
class="empty">

Tidak ada pengajuan menunggu approval

</td>

</tr>


@endforelse



</tbody>


</table>


</div>



</div>








<style>

/* ===============================
HEADER
================================ */

.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

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




/* TAG */

.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}







/* ===============================
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

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

    box-shadow:
    0 10px 30px rgba(15,23,42,.05);

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



.summary-icon{

    width:45px;

    height:45px;

    border-radius:14px;

    background:#fef3c7;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

}



.summary-card label{

    font-size:11px;

    color:#64748b;

}



.summary-card h2{

    margin:4px 0;

    font-size:20px;

    color:#172033;

    font-weight:800;

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

    padding:25px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:6px;

}



.subtitle{

    color:#94a3b8;

    font-size:11px;

}







/* ===============================
TABLE
================================ */


.table-wrapper{

    margin-top:20px;

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:14px;

    text-align:left;

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



td{

    padding:14px;

    border-bottom:1px solid #f1f5f9;

    font-size:12px;

    color:#334155;

}



tbody tr:hover{

    background:#f8fafc;

}



small{

    font-size:10px;

    color:#94a3b8;

}



.money{

    font-weight:800;

    color:#16a34a;

}







/* ===============================
ACTION
================================ */


.action-group-column{

    display:flex;

    flex-direction:column;

    gap:10px;

}



.action-group-column form{

    display:flex;

    gap:8px;

    align-items:center;

}



.action-group-column select{

    height:34px;

    border-radius:10px;

    border:1px solid #e2e8f0;

    padding:0 8px;

    font-size:11px;

    background:#f8fafc;

}




.detail-btn,
.approve-btn,
.reject-btn{


    padding:8px 14px;

    border-radius:12px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

    border:none;

    cursor:pointer;

}



.detail-btn{

    background:#f1f5f9;

    color:#334155;

}



.approve-btn{

    background:#dcfce7;

    color:#166534;

}



.reject-btn{

    background:#fee2e2;

    color:#dc2626;

}



.approve-btn:hover{

    background:#bbf7d0;

}



.reject-btn:hover{

    background:#fecaca;

}








/* ===============================
ALERT
================================ */


.success-box{

    background:#dcfce7;

    color:#166534;

    padding:14px;

    border-radius:14px;

    margin-bottom:20px;

    font-size:13px;

}



.error-box{

    background:#fee2e2;

    color:#991b1b;

    padding:14px;

    border-radius:14px;

    margin-bottom:20px;

    font-size:13px;

}








/* EMPTY */

.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}








@media(max-width:900px){

.summary-grid{

    grid-template-columns:1fr;

}


}

</style>

@endsection