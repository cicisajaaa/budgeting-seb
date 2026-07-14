@extends('layouts.dashboard')


@section('content')


<h2>
Pengajuan Dana
</h2>



<form method="POST"
action="{{route('expense.store')}}">

@csrf


<select name="project_id">

@foreach($projects as $project)

<option value="{{$project->id}}">
{{$project->nama_project}}
</option>

@endforeach

</select>


<br><br>


<select name="division_id">

@foreach($divisions as $division)

<option value="{{$division->id}}">
{{$division->nama_divisi}}
</option>

@endforeach

</select>


<br><br>


<input
name="judul"
placeholder="Keperluan">


<br><br>


<textarea
name="keterangan"
placeholder="Keterangan">
</textarea>


<br><br>


<input
type="number"
name="jumlah"
placeholder="Jumlah">


<br><br>


<button>
Ajukan
</button>


</form>


@endsection