@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>


<div class="welcome-label">

RIWAYAT PENGAJUAN DANA

</div>




<h1>

Monitoring Pengajuan Dana

</h1>




<p>

Lihat status seluruh pengajuan dana yang telah kamu ajukan.

</p>



<div class="welcome-tags">


<span>
✓ Tracking Pengajuan
</span>


<span>
✓ Status Approval
</span>


<span>
✓ Riwayat Dana
</span>


</div>



</div>








</div>









<!-- FILTER -->

<div class="glass-panel filter-panel">



<div class="panel-title">

🔎 Filter Pengajuan Dana

</div>




<form method="GET" action="{{ route('expense.myhistory') }}">



<div class="filter-box">


<div>


<label>

Status Pengajuan

</label>



<select name="status">


<option value="">

Semua Status

</option>



<option value="pending"
{{ request('status') == 'pending' ? 'selected' : '' }}>

Menunggu

</option>



<option value="approved"
{{ request('status') == 'approved' ? 'selected' : '' }}>

Disetujui

</option>



<option value="rejected"
{{ request('status') == 'rejected' ? 'selected' : '' }}>

Ditolak

</option>



</select>



</div>





<button type="submit">

Filter

</button>



</div>



</form>



</div>









<div class="glass-panel">



<div class="panel-title">

📄 Daftar Pengajuan Dana

</div>





<table>


<thead>


<tr>


<th>

Tanggal

</th>



<th>

Judul

</th>



<th>

Project

</th>



<th>

Divisi

</th>



<th>

Jumlah

</th>


<th>
Status
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


{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}


</td>





<td>


<strong>

{{$request->judul}}

</strong>


<br>


<small>

{{$request->keterangan ?? '-'}}

</small>


</td>






<td>


{{$request->proyek->nama_proyek ?? '-'}}


</td>







<td>


{{$request->divisi->nama_divisi ?? '-'}}


</td>







<td class="money">


Rp {{number_format($request->jumlah ?? 0,0,',','.')}}


</td>
<td>

@if($request->status == 'pending')

<span class="status pending">
Menunggu
</span>


@elseif($request->status == 'approved')

<span class="status approved">
Disetujui
</span>


@else

<span class="status rejected">
Ditolak
</span>


@endif



<div class="timeline">


<div class="step active">

<span>
✓
</span>

Diajukan

</div>



<div class="step 
{{in_array($request->status,['approved','rejected'])?'active':''}}">


<span>
✓
</span>

Diproses

</div>




<div class="step 
{{$request->status=='approved'?'active':''}}">


<span>
✓
</span>

Selesai

</div>


</div>




@if($request->status == 'rejected' && $request->catatan_persetujuan)

<div class="approval-note">

<strong>
Alasan Penolakan
</strong>


<p>
{{$request->catatan_persetujuan}}
</p>


</div>

@endif


</td>



<td>

<a href="{{ route('expense.detail',$request->id) }}"
class="detail-btn">

Lihat Detail

</a>

</td>

</tr>



@empty



<tr>


<td colspan="7" class="empty">


Belum ada riwayat pengajuan dana


</td>


</tr>



@endforelse



</tbody>



</table>





</div>








<style>

/* =========================
GLOBAL
========================= */

.welcome-card{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:32px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    color:#64748b;

    font-weight:700;

}



.welcome-card h1{

    margin:10px 0;

    font-size:30px;

    color:#172033;

    font-weight:800;

}



.welcome-card p{

    color:#64748b;

    font-size:13px;

}





.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:18px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:8px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:600;

}









/* =========================
PANEL
========================= */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:26px;

    margin-bottom:22px;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

}



.panel-title{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin-bottom:20px;

}





/* =========================
FILTER
========================= */


.filter-box{

    display:flex;

    align-items:end;

    gap:15px;

}



.filter-box label{

    display:block;

    font-size:12px;

    color:#64748b;

    margin-bottom:6px;

}



.filter-box select{

    padding:11px 16px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:white;

}



.filter-box button{

    background:#0f172a;

    color:white;

    border:none;

    padding:11px 22px;

    border-radius:12px;

    font-weight:700;

}





/* =========================
TABLE
========================= */


table{

    width:100%;

    border-collapse:collapse;

}



thead th{

    background:#f8fafc;

    color:#64748b;

    font-size:12px;

    font-weight:700;

    padding:15px;

    text-align:left;

}



tbody td{

    padding:16px;

    border-bottom:1px solid #f1f5f9;

    color:#334155;

    font-size:13px;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    color:#172033;

}



td small{

    color:#94a3b8;

}





/* =========================
MONEY
========================= */


.money{

    color:#15803d;

    font-weight:800;

}





/* =========================
STATUS
========================= */


.status{

    display:inline-flex;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}



.status.pending{

    background:#fef3c7;

    color:#92400e;

}



.status.approved{

    background:#dcfce7;

    color:#15803d;

}



.status.rejected{

    background:#fee2e2;

    color:#dc2626;

}





/* =========================
TIMELINE
========================= */


.timeline{

    margin-top:14px;

}



.step{

    display:flex;

    align-items:center;

    gap:8px;

    margin-bottom:8px;

    color:#94a3b8;

    font-size:11px;

}



.step span{

    width:20px;

    height:20px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#e2e8f0;

    font-size:10px;

}



.step.active{

    color:#15803d;

    font-weight:700;

}



.step.active span{

    background:#16a34a;

    color:white;

}





/* =========================
REJECTION NOTE
========================= */


.approval-note{

    margin-top:15px;

    background:#fff7ed;

    border-left:4px solid #f97316;

    padding:12px;

    border-radius:12px;

}



.approval-note strong{

    color:#c2410c;

    font-size:12px;

}



.approval-note p{

    margin-top:5px;

    color:#475569;

    font-size:12px;

}





/* =========================
DETAIL BUTTON
========================= */


.detail-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    background:#0f172a;

    color:white;

    padding:9px 18px;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.detail-btn:hover{

    background:#334155;

}





/* =========================
EMPTY
========================= */


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}





/* =========================
RESPONSIVE
========================= */


@media(max-width:900px){


.welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



.welcome-tags{

    flex-wrap:wrap;

}



.filter-box{

    flex-direction:column;

    align-items:flex-start;

}



table{

    display:block;

    overflow-x:auto;

}


}


</style>



@endsection