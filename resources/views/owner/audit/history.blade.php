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


@media(max-width:700px){


.date-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.date-card a{

    width:100%;

    text-align:center;

}


}

</style>



@endsection