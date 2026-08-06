@extends('layouts.dashboard')


@section('content')


<div class="audit-container">





{{-- HEADER --}}

<div class="page-header">


<span class="label">
AUDIT AKTIVITAS
</span>


<h1>
Aktivitas Terbaru Sistem
</h1>


<p>
Monitoring aktivitas pengguna perusahaan secara real-time.
</p>


</div>








{{-- FILTER --}}


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





<input 
type="date"
name="tanggal"
value="{{request('tanggal')}}"
>




<button type="submit">
Cari
</button>



<a href="{{route('owner.audit.history')}}"
class="history-btn">

📚 Semua Riwayat

</a>



</form>









{{-- PANEL --}}


<div class="panel">


<div class="panel-header">

<h3>
📝 5 Aktivitas Terbaru
</h3>


<span>
Monitoring Owner
</span>


</div>







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






<div class="activity-footer">


<span class="module">

{{$activity->modul}}

</span>



<span class="time">

{{$activity->created_at->format('d M Y H:i')}}

</span>


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

padding:30px;

border-radius:20px;

border:1px solid #e2e8f0;

margin-bottom:25px;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}




.label{

font-size:11px;

letter-spacing:2px;

font-weight:800;

color:#64748b;

}



.page-header h1{

margin:10px 0;

font-size:30px;

color:#1e293b;

}



.page-header p{

color:#64748b;

font-size:14px;

}







/* FILTER */


.filter-box{


background:white;

padding:20px;

border-radius:18px;

border:1px solid #e2e8f0;

display:flex;

gap:15px;

align-items:center;

margin-bottom:25px;

}




.filter-box select,
.filter-box input{


height:42px;

padding:0 15px;

border-radius:10px;

border:1px solid #e2e8f0;

font-size:13px;

}





.filter-box button{


height:42px;

padding:0 25px;

background:#334155;

color:white;

border:none;

border-radius:10px;

font-weight:700;

cursor:pointer;

}






.history-btn{


height:42px;

display:flex;

align-items:center;

padding:0 20px;

background:#f8fafc;

border:1px solid #e2e8f0;

color:#334155;

border-radius:10px;

text-decoration:none;

font-size:13px;

font-weight:700;

}







/* PANEL */


.panel{


background:white;

padding:30px;

border-radius:20px;

border:1px solid #e2e8f0;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.panel-header{


display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}



.panel-header h3{


color:#1e293b;

}



.panel-header span{


font-size:12px;

color:#94a3b8;

}







/* ACTIVITY */


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





.activity-content{


flex:1;

}




.activity-content h4{


font-size:15px;

color:#172033;

margin-bottom:5px;

}




.activity-content small{


color:#64748b;

font-size:12px;

}



.activity-content p{


margin-top:8px;

font-size:13px;

color:#64748b;

line-height:1.6;

}





.activity-footer{


display:flex;

align-items:center;

gap:15px;

margin-top:12px;

}




.module{


background:#f1f5f9;

padding:5px 12px;

border-radius:20px;

font-size:11px;

font-weight:700;

color:#475569;

}




.time{


font-size:12px;

color:#94a3b8;

}






.empty{


padding:40px;

text-align:center;

color:#94a3b8;

}






@media(max-width:800px){


.filter-box{

flex-direction:column;

align-items:stretch;

}



.activity{

flex-direction:column;

}


}


</style>



@endsection