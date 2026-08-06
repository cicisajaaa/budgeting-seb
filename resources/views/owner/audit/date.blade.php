@extends('layouts.dashboard')


@section('content')


<div class="audit-container">



<div class="page-header">


<span class="label">
DETAIL RIWAYAT AUDIT
</span>


<h1>
Aktivitas {{\Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')}}
</h1>


<p>
Daftar aktivitas sistem pada tanggal tersebut.
</p>


</div>






<div class="panel">



<h3>
📝 Daftar Aktivitas
</h3>





@forelse($activities as $activity)



<div class="activity">


<div class="activity-icon">


@if($activity->modul == 'Keuangan')

💰

@elseif($activity->modul == 'Project')

📁

@elseif($activity->modul == 'Pengajuan Dana')

💸

@elseif($activity->modul == 'Approval Dana')

✅

@else

📝

@endif


</div>





<div class="activity-content">


<h4>

{{$activity->aksi}}

</h4>



<small>

Oleh:
<strong>
{{$activity->pengguna->name ?? 'System'}}
</strong>

</small>




<p>

{{$activity->deskripsi}}

</p>




<div class="info">


<span class="module">

{{$activity->modul}}

</span>


<span class="time">

{{$activity->created_at->format('H:i')}}

</span>


</div>



</div>



</div>




@empty


<div class="empty">

Tidak ada aktivitas pada tanggal ini.

</div>


@endforelse





<a href="{{route('owner.audit.history')}}"
class="back-btn">

← Kembali Riwayat

</a>



</div>




</div>









<style>


.audit-container{

margin-top:10px;

}




.page-header{

background:white;

padding:30px;

border-radius:20px;

border:1px solid #e2e8f0;

margin-bottom:25px;

}



.label{

font-size:11px;

font-weight:800;

letter-spacing:2px;

color:#64748b;

}



.page-header h1{

margin:10px 0;

font-size:28px;

color:#1e293b;

}



.page-header p{

color:#64748b;

}




.panel{

background:white;

padding:30px;

border-radius:20px;

border:1px solid #e2e8f0;

}



.panel h3{

margin-bottom:20px;

}





.activity{

display:flex;

gap:20px;

padding:20px 0;

border-bottom:1px solid #f1f5f9;

}




.activity:last-child{

border-bottom:none;

}





.activity-icon{

width:45px;

height:45px;

border-radius:50%;

background:#f8fafc;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

}





.activity-content h4{

color:#172033;

font-size:15px;

}



.activity-content p{

margin-top:8px;

font-size:13px;

color:#64748b;

}



.info{

display:flex;

gap:15px;

margin-top:10px;

}



.module{

background:#f1f5f9;

padding:5px 12px;

border-radius:20px;

font-size:11px;

font-weight:700;

}



.time{

font-size:12px;

color:#94a3b8;

}





.back-btn{

display:inline-flex;

margin-top:25px;

background:#334155;

color:white;

padding:10px 18px;

border-radius:10px;

text-decoration:none;

font-size:13px;

font-weight:700;

}



.empty{

text-align:center;

padding:40px;

color:#94a3b8;

}


</style>



@endsection