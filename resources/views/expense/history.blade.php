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





<div class="system-status">


<span></span>


Employee Active


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


Rp {{number_format($request->jumlah,0,',','.')}}


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


<td colspan="6" class="empty">


Belum ada riwayat pengajuan dana


</td>


</tr>



@endforelse



</tbody>



</table>





</div>








<style>



.welcome-card{


background:

linear-gradient(
135deg,
#166534,
#22c55e
);


padding:30px;


border-radius:24px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}





.welcome-label{


font-size:10px;


letter-spacing:2px;


font-weight:700;


opacity:.8;


}




.welcome-card h1{


font-size:28px;


margin:8px 0;


}





.welcome-card p{


font-size:13px;


opacity:.9;


}






.welcome-tags{


display:flex;


gap:10px;


margin-top:18px;


}



.welcome-tags span{


background:rgba(255,255,255,.15);


padding:7px 12px;


border-radius:20px;


font-size:11px;


}







.system-status{


background:white;


color:#166534;


padding:12px 18px;


border-radius:30px;


font-weight:700;


font-size:13px;


display:flex;


align-items:center;


gap:8px;


}





.system-status span{


width:9px;


height:9px;


background:#22c55e;


border-radius:50%;


}








.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:blur(15px);


border-radius:22px;


padding:22px;


border:1px solid rgba(255,255,255,.8);


margin-bottom:20px;


}





.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:18px;


}






.filter-box{


display:flex;


gap:15px;


align-items:end;


}




.filter-box label{


display:block;


font-size:12px;


color:#64748b;


margin-bottom:5px;


}




.filter-box select{


padding:10px 15px;


border-radius:10px;


border:1px solid #e2e8f0;


}





.filter-box button{


background:#166534;


color:white;


border:none;


padding:10px 20px;


border-radius:12px;


font-weight:700;


cursor:pointer;


}






table{


width:100%;


border-collapse:collapse;


}






th{


padding:14px;


text-align:left;


font-size:12px;


color:#64748b;


background:#f8fafc;


}






td{


padding:14px;


font-size:13px;


border-bottom:1px solid #f1f5f9;


}





td strong{


color:#334155;


}





td small{


color:#94a3b8;


font-size:11px;


}





.money{


font-weight:700;


color:#166534;


}





.status{


padding:6px 12px;


border-radius:20px;


font-size:11px;


font-weight:700;


}





.pending{


background:#fef3c7;


color:#92400e;


}





.approved{


background:#dcfce7;


color:#166534;


}





.rejected{


background:#fee2e2;


color:#dc2626;


}





.empty{


text-align:center;


padding:30px;


color:#94a3b8;


}







@media(max-width:900px){


table{


display:block;


overflow-x:auto;


}



.filter-box{


flex-direction:column;


align-items:flex-start;


}


}
.timeline{

margin-top:15px;

padding-left:5px;

}


.step{

display:flex;

align-items:center;

gap:8px;

font-size:11px;

color:#94a3b8;

margin-bottom:8px;

}



.step span{

width:20px;

height:20px;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

background:#e2e8f0;

font-size:11px;

font-weight:bold;

}



.step.active{

color:#166534;

font-weight:600;

}



.step.active span{

background:#22c55e;

color:white;

}
.approval-note{

margin-top:15px;

background:#f8fafc;

border-left:4px solid #166534;

padding:12px;

border-radius:12px;

font-size:12px;

}



.approval-note strong{

display:block;

color:#166534;

margin-bottom:5px;

}



.approval-note p{

margin:0;

color:#475569;

line-height:1.5;

}
.detail-btn{

background:#166534;

color:white;

padding:8px 15px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

display:inline-block;

}


.detail-btn:hover{

background:#22c55e;

}
</style>



@endsection