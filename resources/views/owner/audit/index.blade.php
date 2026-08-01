@extends('layouts.dashboard')


@section('content')


<div class="audit-container">



<div class="page-header">


<span class="label">
AUDIT AKTIVITAS
</span>


<h1>
Riwayat Aktivitas Sistem
</h1>


<p>
Pantau seluruh aktivitas pengguna dalam sistem perusahaan.
</p>


</div>




<form method="GET"
action="{{route('owner.audit')}}"
class="filter-box">


<select name="modul">


<option value="">
Semua Modul
</option>


<option value="Keuangan"
{{request('modul')=='Keuangan'?'selected':''}}>
Keuangan
</option>



<option value="Project"
{{request('modul')=='Project'?'selected':''}}>
Project
</option>



<option value="Pengajuan Dana"
{{request('modul')=='Pengajuan Dana'?'selected':''}}>
Pengajuan Dana
</option>



<option value="Approval Dana"
{{request('modul')=='Approval Dana'?'selected':''}}>
Approval Dana
</option>


</select>





<input type="date"
name="tanggal"
value="{{request('tanggal')}}">





<button type="submit">

Cari

</button>


</form>






<div class="panel">


<h3>
📝 Aktivitas Terbaru
</h3>


 @forelse($activities ?? [] as $activity)

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

{{ $activity->aksi }}

</h4>



<small>
Oleh:
{{ $activity->pengguna->name ?? 'System' }}
</small>
<p>

{{ $activity->deskripsi }}

</p>




<span class="module">

{{ $activity->modul }}

</span>




<div class="activity-time">

{{ $activity->created_at->format('d M Y H:i') }}

</div>



</div>



</div>


@empty


<div class="empty">

Belum ada aktivitas tercatat.

</div>


@endforelse


</div>






</div>








<style>


.audit-container{

margin-top:10px;

}





.page-header{


background:white;

padding:28px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

margin-bottom:25px;


}




.label{


font-size:11px;

letter-spacing:2px;

font-weight:700;

color:#64748b;


}





.page-header h1{


margin:10px 0;

font-size:28px;

color:#1e293b;


}





.page-header p{


color:#64748b;

font-size:14px;


}








.filter-box{


background:white;

padding:20px;

border-radius:18px;

display:flex;

gap:15px;

margin-bottom:25px;

border:1px solid #e2e8f0;


}



.filter-box select,
.filter-box input{


height:42px;

padding:0 15px;

border-radius:10px;

border:1px solid #ddd;

font-size:13px;


}




.filter-box button{


background:#6b4f1d;

color:white;

border:none;

padding:0 25px;

border-radius:10px;

font-weight:600;

cursor:pointer;


}








.panel{


background:white;

padding:25px;

border-radius:18px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);


}





.panel h3{


margin-bottom:20px;

color:#1e293b;


}








.activity{


display:flex;

gap:20px;

padding:20px 0;

border-bottom:1px solid #eee;


}





.activity:last-child{


border-bottom:none;


}







.activity-icon{


width:45px;

height:45px;

border-radius:50%;

background:#f8f3e8;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;


}








.activity-content h4{


font-size:15px;

color:#172033;


}





.activity-content p{


font-size:13px;

color:#64748b;

margin-top:6px;

line-height:1.6;


}







.activity-time{


font-size:12px;

color:#94a3b8;

margin-top:8px;


}








.module{


display:inline-block;

margin-top:8px;

padding:5px 12px;

border-radius:20px;

background:#f1f5f9;

font-size:11px;

font-weight:700;

color:#475569;


}






.empty{


padding:40px;

text-align:center;

color:#94a3b8;


}





@media(max-width:700px){


.filter-box{


flex-direction:column;


}



}

</style>



@endsection