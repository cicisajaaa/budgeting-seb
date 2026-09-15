@extends('layouts.dashboard')


@section('content')


<div class="glass-panel">


<h2>
Semua Notifikasi
</h2>



@forelse($notifications as $notification)


<a href="{{route(
'notification.read',
$notification->id
)}}"
style="
display:block;
padding:15px;
background:#f8fafc;
border-radius:15px;
margin-top:10px;
text-decoration:none;
color:#334155;
">


<strong>

{{$notification->data['title']}}

</strong>


<p>

{{$notification->data['message']}}

</p>



<small>

{{$notification->created_at->diffForHumans()}}

</small>



</a>



@empty


<p>
Belum ada notifikasi
</p>


@endforelse



</div>

<style>

/* ===============================
   NOTIFICATION
================================ */

.glass-panel{
    width:100%;
    box-sizing:border-box;
}

.glass-panel h2{
    margin:0 0 15px;
    font-size:20px;
    color:#172033;
}

.glass-panel a{
    box-sizing:border-box;
}

.glass-panel a strong{
    display:block;
    font-size:13px;
    color:#172033;
    line-height:1.4;
}

.glass-panel a p{
    margin:6px 0;
    font-size:12px;
    line-height:1.5;
    color:#475569;
    word-break:break-word;
}

.glass-panel a small{
    font-size:10px;
    color:#94a3b8;
}


@media(max-width:900px){

    .glass-panel{
        padding:20px;
        border-radius:20px;
    }

    .glass-panel h2{
        font-size:18px;
        margin-bottom:12px;
    }

    .glass-panel a{
        padding:13px !important;
        border-radius:13px !important;
    }

    .glass-panel a strong{
        font-size:12px;
    }

    .glass-panel a p{
        font-size:11px;
    }

    .glass-panel a small{
        font-size:9px;
    }

}


@media(max-width:600px){

    .glass-panel{
        padding:14px;
        border-radius:17px;
    }

    .glass-panel h2{
        font-size:16px;
        margin-bottom:10px;
    }

    .glass-panel a{
        padding:12px !important;
        margin-top:8px !important;
        border-radius:12px !important;
    }

    .glass-panel a strong{
        font-size:11px;
        line-height:1.4;
    }

    .glass-panel a p{
        font-size:10px;
        line-height:1.5;
        margin:5px 0;
    }

    .glass-panel a small{
        font-size:8px;
    }

}

</style>



@endsection