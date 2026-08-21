@extends('layouts.dashboard')

@section('content')


<div class="audit-container">



{{-- HEADER --}}

<div class="dashboard-header">


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



<div class="panel-title">

<h3>
📝 Riwayat Aktivitas Sistem
</h3>


<span>
Monitoring Owner
</span>


</div>








@forelse($activities as $activity)



<div class="activity-row">





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







<div class="activity-body">


<h4>
{{$activity->aksi}}
</h4>




<div class="user">

Oleh :

<strong>
{{$activity->pengguna->name ?? 'System'}}
</strong>

</div>





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

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


.audit-container{

    width:100%;

}



/* ===============================
HEADER
================================ */


.dashboard-header{

    background:#f8fafc;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

    text-transform:uppercase;

}



.dashboard-header h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.dashboard-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}







/* ===============================
FILTER
================================ */


.filter-box{

    background:white;

    padding:18px;

    border-radius:20px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

    display:flex;

    gap:12px;

    align-items:center;

    margin-bottom:22px;

}



.filter-box select,
.filter-box input{

    height:38px;

    padding:0 12px;

    min-width:180px;

    border-radius:10px;

    border:1px solid #cbd5e1;

    font-size:12px;

    color:#334155;

}



.filter-box button{

    height:38px;

    padding:0 22px;

    border:none;

    border-radius:10px;

    background:#0f172a;

    color:white;

    font-size:12px;

    font-weight:700;

    cursor:pointer;

}



.history-btn{

    height:38px;

    padding:0 16px;

    display:flex;

    align-items:center;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:10px;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    color:#334155;

}







/* ===============================
PANEL
================================ */


.panel{

    background:white;

    padding:22px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

}



.panel-title{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;

}



.panel-title h3{

    margin:0;

    font-size:16px;

    font-weight:800;

    color:#172033;

}



.panel-title span{

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
ACTIVITY
================================ */


.activity-row{

    display:flex;

    gap:15px;

    padding:15px 8px;

    border-bottom:1px solid #f1f5f9;

}



.activity-row:last-child{

    border-bottom:none;

}



.activity-icon{

    width:38px;

    height:38px;

    border-radius:12px;

    background:#f8fafc;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:16px;

    flex-shrink:0;

}





.activity-body{

    flex:1;

}



.activity-body h4{

    margin:0 0 5px;

    font-size:13px;

    font-weight:800;

    color:#172033;

}



.user{

    font-size:11px;

    color:#64748b;

}



.activity-body p{

    margin:7px 0;

    font-size:12px;

    color:#64748b;

    line-height:1.5;

}





.activity-footer{

    display:flex;

    align-items:center;

    gap:10px;

    margin-top:8px;

}





.module{

    padding:5px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    background:#e0f2fe;

    color:#0369a1;

}



.time{

    font-size:11px;

    color:#94a3b8;

}






/* ===============================
EMPTY
================================ */


.empty{

    padding:35px;

    text-align:center;

    color:#94a3b8;

    font-size:12px;

}







/* ===============================
RESPONSIVE
================================ */


@media(max-width:900px){


.filter-box{

    flex-direction:column;

    align-items:stretch;

}



.filter-box select,
.filter-box input,
.filter-box button,
.history-btn{

    width:100%;

}



.activity-row{

    flex-direction:column;

}



.panel-title{

    flex-direction:column;

    align-items:flex-start;

    gap:8px;

}



}

</style>


@endsection