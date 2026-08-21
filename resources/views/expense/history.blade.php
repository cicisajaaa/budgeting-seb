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

/* =================================
GLOBAL
================================= */

*{
    box-sizing:border-box;
}



/* =================================
HEADER OWNER STYLE
================================= */


.welcome-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.welcome-card h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.welcome-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}



.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:7px 14px;

    border-radius:999px;

    font-size:11px;

    font-weight:700;

}







/* =================================
PANEL
================================= */


.glass-panel{

    background:white;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    margin-bottom:20px;

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#1e293b;

    margin-bottom:20px;

    padding-left:10px;

    border-left:4px solid #334155;

}






/* =================================
FILTER
================================= */


.filter-box{

    display:flex;

    align-items:end;

    gap:15px;

}



.filter-box label{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}



.filter-box select{

    height:42px;

    min-width:220px;

    padding:0 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:12px;

}



.filter-box button{


    height:42px;

    padding:0 25px;

    border:none;

    border-radius:12px;

    background:#334155;

    color:white;

    font-size:12px;

    font-weight:700;

    cursor:pointer;

}







/* =================================
TABLE
================================= */


table{

    width:100%;

    border-collapse:collapse;

}



thead th{

    padding:14px;

    text-align:left;

    font-size:11px;

    color:#64748b;

    background:#f8fafc;

}



tbody td{

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

    color:#1e293b;

    font-size:13px;

}



td small{

    color:#94a3b8;

}







/* =================================
MONEY
================================= */


.money{

    color:#15803d;

    font-weight:800;

}






/* =================================
STATUS
================================= */


.status{

    display:inline-flex;

    padding:6px 14px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.status.pending{

    background:#fef3c7;

    color:#92400e;

}



.status.approved{

    background:#dcfce7;

    color:#166534;

}



.status.rejected{

    background:#fee2e2;

    color:#b91c1c;

}







/* =================================
TIMELINE
================================= */


.timeline{

    margin-top:12px;

}



.step{

    display:flex;

    align-items:center;

    gap:8px;

    margin-bottom:7px;

    font-size:10px;

    color:#94a3b8;

}



.step span{

    width:18px;

    height:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:50%;

    background:#e2e8f0;

    font-size:9px;

}



.step.active{

    color:#15803d;

    font-weight:700;

}



.step.active span{

    background:#16a34a;

    color:white;

}







/* =================================
NOTE
================================= */


.approval-note{

    margin-top:12px;

    padding:12px;

    background:#fff7ed;

    border-left:4px solid #f97316;

    border-radius:12px;

}



.approval-note strong{

    font-size:11px;

    color:#c2410c;

}



.approval-note p{

    margin:5px 0 0;

    font-size:11px;

    color:#475569;

}







/* =================================
BUTTON
================================= */


.detail-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    background:#334155;

    color:white;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

    text-decoration:none;

}



.detail-btn:hover{

    background:#1e293b;

    color:white;

}







/* =================================
EMPTY
================================= */


.empty{

    text-align:center;

    padding:40px;

    color:#94a3b8;

}







/* =================================
RESPONSIVE
================================= */


@media(max-width:900px){


.filter-box{

    flex-direction:column;

    align-items:stretch;

}


.filter-box select,
.filter-box button{

    width:100%;

}


table{

    display:block;

    overflow-x:auto;

}


.welcome-tags{

    flex-wrap:wrap;

}


}

</style>



@endsection