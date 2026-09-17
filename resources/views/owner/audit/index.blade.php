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

*{
    box-sizing:border-box;
}

.audit-container{
    width:100%;
    max-width:100%;
    min-width:0;
}

/* ===============================
   HEADER
================================ */

.dashboard-header{
    background:#f8fafc;
    padding:22px 24px;
    border-radius:20px;
    border:1px solid #e2e8f0;
    margin-bottom:18px;
    box-shadow:0 6px 20px rgba(15,23,42,.045);
}

.label{
    display:block;
    font-size:10px;
    letter-spacing:1.8px;
    font-weight:800;
    color:#64748b;
    text-transform:uppercase;
}

.dashboard-header h1{
    margin:7px 0;
    font-size:23px;
    line-height:1.3;
    font-weight:800;
    color:#172033;
}

.dashboard-header p{
    margin:0;
    font-size:11px;
    line-height:1.5;
    color:#64748b;
}

/* ===============================
   FILTER
================================ */

.filter-box{
    width:100%;
    background:#fff;
    padding:15px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:18px;
    min-width:0;
}

.filter-box select,
.filter-box input{
    height:40px;
    padding:0 12px;
    min-width:170px;
    border:1px solid #cbd5e1;
    border-radius:10px;
    background:#fff;
    color:#334155;
    font-size:11px;
    outline:none;
}

.filter-box select:focus,
.filter-box input:focus{
    border-color:#94a3b8;
}

.filter-box button{
    height:40px;
    padding:0 20px;
    border:none;
    border-radius:10px;
    background:#0f172a;
    color:#fff;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
}

.filter-box button:hover{
    background:#334155;
}

.history-btn{
    height:40px;
    padding:0 15px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:10px;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
    color:#334155;
    white-space:nowrap;
}

.history-btn:hover{
    background:#f1f5f9;
}

/* ===============================
   PANEL
================================ */

.panel{
    width:100%;
    background:#fff;
    padding:20px;
    border-radius:20px;
    border:1px solid #e2e8f0;
    box-shadow:0 6px 20px rgba(15,23,42,.045);
    min-width:0;
}

.panel-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:14px;
}

.panel-title h3{
    margin:0;
    padding-left:9px;
    border-left:4px solid #334155;
    font-size:15px;
    line-height:1.4;
    font-weight:800;
    color:#172033;
}

.panel-title span{
    font-size:10px;
    color:#94a3b8;
    white-space:nowrap;
}

/* ===============================
   ACTIVITY
================================ */

.activity-row{
    display:flex;
    align-items:flex-start;
    gap:13px;
    padding:14px 6px;
    border-bottom:1px solid #f1f5f9;
    min-width:0;
}

.activity-row:last-child{
    border-bottom:none;
}

.activity-icon{
    width:36px;
    height:36px;
    border-radius:10px;
    background:#f8fafc;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
    flex-shrink:0;
}

.activity-body{
    flex:1;
    min-width:0;
}

.activity-body h4{
    margin:0 0 5px;
    font-size:12px;
    line-height:1.4;
    font-weight:800;
    color:#172033;
    overflow-wrap:anywhere;
}

.user{
    font-size:10px;
    line-height:1.4;
    color:#64748b;
}

.user strong{
    color:#334155;
}

.activity-body p{
    margin:7px 0;
    font-size:11px;
    line-height:1.55;
    color:#64748b;
    overflow-wrap:anywhere;
}

.activity-footer{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:7px;
    margin-top:8px;
}

.module{
    padding:5px 10px;
    border-radius:999px;
    font-size:9px;
    line-height:1.3;
    font-weight:700;
    background:#e0f2fe;
    color:#0369a1;
}

.time{
    font-size:9px;
    color:#94a3b8;
    white-space:nowrap;
}

/* ===============================
   EMPTY
================================ */

.empty{
    padding:35px 15px;
    text-align:center;
    color:#94a3b8;
    font-size:11px;
}

/* ===============================
   TABLET
================================ */

@media(max-width:900px){

    .dashboard-header{
        padding:20px;
    }

    .dashboard-header h1{
        font-size:21px;
    }

    .filter-box{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:9px;
    }

    .filter-box select,
    .filter-box input,
    .filter-box button,
    .history-btn{
        width:100%;
        min-width:0;
    }

    .panel{
        padding:18px;
    }

    .panel-title{
        align-items:flex-start;
    }
}

/* ===============================
   MOBILE
================================ */

@media(max-width:600px){

    .dashboard-header{
        padding:18px;
        border-radius:17px;
        margin-bottom:14px;
    }

    .label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .dashboard-header h1{
        font-size:19px;
        margin:6px 0;
    }

    .dashboard-header p{
        font-size:10px;
        line-height:1.5;
    }

    /* FILTER */

    .filter-box{
        grid-template-columns:1fr;
        padding:13px;
        border-radius:15px;
        gap:8px;
        margin-bottom:14px;
    }

    .filter-box select,
    .filter-box input{
        height:40px;
        font-size:10px;
    }

    .filter-box button,
    .history-btn{
        height:40px;
        font-size:10px;
    }

    /* PANEL */

    .panel{
        padding:15px;
        border-radius:17px;
    }

    .panel-title{
        flex-direction:column;
        align-items:flex-start;
        gap:5px;
        margin-bottom:9px;
    }

    .panel-title h3{
        font-size:13px;
        padding-left:8px;
        border-left-width:3px;
    }

    .panel-title span{
        font-size:9px;
    }

    /* ACTIVITY */

    .activity-row{
        gap:10px;
        padding:13px 3px;
    }

    .activity-icon{
        width:33px;
        height:33px;
        border-radius:9px;
        font-size:14px;
    }

    .activity-body h4{
        font-size:11px;
        line-height:1.45;
    }

    .user{
        font-size:9px;
    }

    .activity-body p{
        font-size:10px;
        line-height:1.55;
        margin:6px 0;
    }

    .activity-footer{
        gap:6px;
    }

    .module{
        padding:4px 9px;
        font-size:8px;
    }

    .time{
        font-size:8px;
    }

    .empty{
        padding:28px 10px;
        font-size:10px;
    }
}

/* ===============================
   SMALL MOBILE
================================ */

@media(max-width:380px){

    .dashboard-header h1{
        font-size:18px;
    }

    .activity-body h4{
        font-size:10px;
    }

    .activity-body p{
        font-size:9px;
    }
}

</style>


@endsection