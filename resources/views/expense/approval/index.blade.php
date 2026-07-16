@extends('layouts.dashboard')


@section('content')



<div class="welcome-card">


<div>


<div class="welcome-label">

APPROVAL PENGELUARAN

</div>



<h1>

Persetujuan Dana Karyawan

</h1>



<p>

Kelola permintaan dana dan verifikasi pengeluaran perusahaan.

</p>




<div class="welcome-tags">


<span>
✓ Verifikasi Dana
</span>


<span>
✓ Kontrol Pengeluaran
</span>


<span>
✓ Update Saldo
</span>


</div>


</div>





<div class="system-status">

<span></span>

Approval Aktif

</div>




</div>









<div class="glass-panel">


<div class="panel-title">

🔔 Pengajuan Menunggu Persetujuan

</div>






<table>


<thead>


<tr>


<th>
Pemohon
</th>



<th>
Detail Pengajuan
</th>



<th>
Project
</th>



<th>
Jumlah
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

{{$request->user->name ?? '-'}}

</strong>


<br>


<span class="role">

Karyawan

</span>


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


<strong>

{{$request->project->nama_project ?? '-' }}

</strong>


<br>


<span class="division">

{{$request->division->nama_divisi ?? '-'}}

</span>


</td>







<td class="money">


Rp {{number_format($request->jumlah,0,',','.')}}


</td>







<td>


{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}


</td>








<td>



<div class="action">





<form method="POST"
action="{{route('expense.approve',$request->id)}}"
onsubmit="return confirm('Apakah yakin ingin menyetujui pengajuan ini?')">


@csrf


<button class="approve">


✓ Setujui


</button>


</form>








<form method="POST"
action="{{route('expense.reject',$request->id)}}"
onsubmit="return confirm('Apakah yakin ingin menolak pengajuan ini?')">


@csrf


<button class="reject">


✕ Tolak


</button>


</form>





</div>



</td>




</tr>






@empty



<tr>


<td colspan="6" class="empty">


Tidak ada pengajuan menunggu approval


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


border:

1px solid rgba(255,255,255,.8);


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


padding:15px;


text-align:left;


font-size:12px;


color:#64748b;


background:#f8fafc;


}





td{


padding:15px;


border-bottom:1px solid #f1f5f9;


font-size:13px;


}





td strong{


color:#334155;


}




.role{


font-size:11px;


color:#94a3b8;


}





.division{


font-size:11px;


color:#16a34a;


}







td small{


font-size:11px;


color:#94a3b8;


}








.money{


font-weight:700;


color:#dc2626;


}








.action{


display:flex;


gap:8px;


}







.action button{


border:none;


padding:9px 14px;


border-radius:12px;


font-size:12px;


font-weight:700;


cursor:pointer;


color:white;


transition:.3s;


}







.approve{


background:#16a34a;


}





.approve:hover{


background:#15803d;


transform:translateY(-2px);


}







.reject{


background:#dc2626;


}





.reject:hover{


background:#b91c1c;


transform:translateY(-2px);


}









.empty{


text-align:center;


padding:35px;


color:#94a3b8;


}







@media(max-width:900px){


table{


display:block;


overflow-x:auto;


}



.welcome-card{


flex-direction:column;


align-items:flex-start;


gap:20px;


}



}



</style>





@endsection