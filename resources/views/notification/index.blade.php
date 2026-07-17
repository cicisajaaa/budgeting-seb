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


@endsection