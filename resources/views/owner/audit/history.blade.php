@extends('layouts.dashboard')


@section('content')


<div class="panel">


<h2>
📅 Riwayat Aktivitas
</h2>



@foreach($activities as $item)


<div class="date-card">


<div>


<h3>

{{\Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y')}}

</h3>


<p>

{{$item->total}} aktivitas tercatat

</p>


</div>



<a href="{{route('owner.audit.date',$item->tanggal)}}">

Lihat Detail →

</a>


</div>



@endforeach



</div>


<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
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



.panel h2{

    margin:0 0 20px;

    font-size:18px;

    font-weight:800;

    color:#172033;

    padding-left:12px;

    border-left:4px solid #334155;

}







/* ===============================
DATE CARD
================================ */


.date-card{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:16px;

    margin-bottom:12px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:18px;

    transition:.2s;

}



.date-card:hover{

    background:white;

    transform:translateY(-2px);

    box-shadow:

    0 5px 15px rgba(15,23,42,.05);

}





.date-card h3{

    margin:0 0 5px;

    font-size:15px;

    font-weight:800;

    color:#172033;

}



.date-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* ===============================
BUTTON
================================ */


.date-card a{

    background:#0f172a;

    color:white;

    padding:9px 16px;

    border-radius:10px;

    text-decoration:none;

    font-size:11px;

    font-weight:700;

    transition:.2s;

}



.date-card a:hover{

    background:#334155;

}







/* ===============================
RESPONSIVE
================================ */

/* ===============================
   RESPONSIVE
================================ */

@media(max-width:900px){

    .panel{
        padding:20px;
        border-radius:20px;
    }

    .panel h2{
        font-size:16px;
        margin-bottom:15px;
    }

    .date-card{
        padding:14px;
        border-radius:16px;
        gap:12px;
    }

    .date-card h3{
        font-size:13px;
        line-height:1.4;
    }

    .date-card p{
        font-size:10px;
        line-height:1.5;
    }

    .date-card a{
        padding:8px 13px;
        font-size:10px;
        white-space:nowrap;
    }

}


@media(max-width:600px){

    .panel{
        padding:14px;
        border-radius:17px;
    }

    .panel h2{
        font-size:14px;
        padding-left:9px;
        border-left-width:3px;
        margin-bottom:12px;
    }

    .date-card{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
        padding:12px;
        margin-bottom:9px;
        border-radius:13px;
    }

    .date-card h3{
        font-size:11px;
        margin-bottom:4px;
    }

    .date-card p{
        font-size:9px;
    }

    .date-card a{
        width:100%;
        box-sizing:border-box;
        text-align:center;
        padding:9px 10px;
        border-radius:9px;
        font-size:9px;
    }

}

</style>



@endsection