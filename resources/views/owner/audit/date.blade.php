@extends('layouts.dashboard')

@section('content')


<div class="audit-container">



{{-- HEADER --}}

<div class="dashboard-header">


<div class="header-top">


<div>


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




<a href="{{route('owner.audit.history')}}"
class="btn-back">

← Kembali

</a>



</div>


</div>








{{-- PANEL --}}


<div class="panel">



<div class="panel-header">


<h3>
📝 Daftar Aktivitas
</h3>



<span>
Riwayat Sistem
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

Oleh :

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

Tidak ada aktivitas pada tanggal ini.

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



.header-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

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
BACK BUTTON
================================ */


.btn-back{

    display:flex;

    align-items:center;

    justify-content:center;

    padding:9px 16px;

    background:#0f172a;

    color:white;

    border-radius:10px;

    text-decoration:none;

    font-size:11px;

    font-weight:700;

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



.panel-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;

}



.panel-header h3{

    margin:0;

    font-size:16px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

}



.panel-header span{

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
ACTIVITY
================================ */


.activity{

    display:flex;

    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #f1f5f9;

}



.activity:last-child{

    border-bottom:none;

}





.activity-icon{

    width:38px;

    height:38px;

    border-radius:12px;

    background:#f8fafc;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:16px;

    flex-shrink:0;

}





.activity-content{

    flex:1;

}



.activity-content h4{

    margin:0 0 5px;

    font-size:13px;

    font-weight:800;

    color:#172033;

}



.activity-content small{

    font-size:11px;

    color:#64748b;

}



.activity-content p{

    margin:7px 0;

    font-size:12px;

    color:#64748b;

    line-height:1.5;

}






/* ===============================
FOOTER
================================ */


.activity-footer{

    display:flex;

    align-items:center;

    gap:10px;

    margin-top:8px;

}





.module{

    background:#e0f2fe;

    color:#0369a1;

    padding:5px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

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


@media(max-width:800px){


.header-top{

    flex-direction:column;

    align-items:flex-start;

}



.activity{

    flex-direction:column;

}



.panel-header{

    flex-direction:column;

    align-items:flex-start;

    gap:8px;

}


}

</style>


@endsection