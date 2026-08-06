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


.panel{

background:white;

padding:30px;

border-radius:20px;

border:1px solid #e2e8f0;

}



.date-card{

display:flex;

justify-content:space-between;

align-items:center;

padding:20px;

border-bottom:1px solid #e2e8f0;

}



.date-card h3{

color:#1e293b;

}



.date-card p{

color:#64748b;

font-size:13px;

}



.date-card a{

background:#334155;

color:white;

padding:10px 18px;

border-radius:10px;

text-decoration:none;

font-size:13px;

}



</style>



@endsection