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


{{$request->project->nama_project ?? '-'}}


</td>







<td>


{{$request->division->nama_divisi ?? '-'}}


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


}





.panel-title{


font-size:16px;


font-weight:700;


margin-bottom:18px;


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


}



</style>



@endsection