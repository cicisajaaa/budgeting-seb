@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">

PENGAJUAN DANA

</div>


<h1>

Ajukan Dana Project

</h1>


<p>

Isi form berikut untuk mengajukan kebutuhan dana kepada bendahara.

</p>


</div>



<div class="system-status">

<span></span>

Employee

</div>



</div>








@if(session('success'))

<div class="success-box">

{{session('success')}}

</div>

@endif







<div class="glass-panel">


<div class="panel-title">

💰 Form Pengajuan Dana

</div>






<form method="POST"
action="{{route('expense.store')}}">


@csrf



<div class="form-grid">





<div>


<label>

Project

</label>



<select name="project_id" required>


<option value="">

-- Pilih Project --

</option>



@foreach($projects as $project)


<option value="{{$project->id}}">

{{$project->nama_project}}

</option>


@endforeach



</select>


</div>








<div>


<label>

Divisi

</label>



<select name="division_id" required>


<option value="">

-- Pilih Divisi --

</option>



@foreach($divisions as $division)


<option value="{{$division->id}}">

{{$division->nama_divisi}}

</option>


@endforeach



</select>


</div>







<div>


<label>

Jumlah Dana

</label>



<input type="number"
name="jumlah"
placeholder="Masukkan nominal"
required>


</div>






</div>







<div>


<label>

Judul Pengeluaran

</label>


<input type="text"
name="judul"
placeholder="Contoh: Pembelian alat kerja"
required>


</div>








<div>


<label>

Keterangan

</label>


<textarea
name="keterangan"
rows="4"
placeholder="Jelaskan kebutuhan dana"></textarea>


</div>








<button class="btn-submit">

+ Kirim Pengajuan

</button>





</form>



</div>










<style>


.welcome-card{


background:
linear-gradient(
135deg,
#166534,
#22c55e
);


padding:30px;


border-radius:24px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}



.welcome-label{

font-size:10px;

letter-spacing:2px;

font-weight:700;

opacity:.8;

}



.welcome-card h1{

font-size:28px;

margin:8px 0;

}



.welcome-card p{

font-size:13px;

opacity:.9;

}



.system-status{


background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-weight:700;

display:flex;

align-items:center;

gap:8px;

}



.system-status span{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

}





.success-box{


background:#dcfce7;

color:#166534;

padding:15px;

border-radius:14px;

margin-bottom:20px;

font-size:13px;

font-weight:600;


}





.glass-panel{


background:rgba(255,255,255,.65);

backdrop-filter:blur(15px);

border-radius:22px;

padding:22px;

border:1px solid rgba(255,255,255,.8);


}



.panel-title{


font-size:16px;

font-weight:700;

margin-bottom:20px;


}




.form-grid{


display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;


}





label{


display:block;

font-size:12px;

font-weight:600;

color:#475569;

margin-bottom:8px;


}





input,
select,
textarea{


width:100%;

padding:12px;

border-radius:12px;

border:1px solid #e2e8f0;

background:white;

margin-bottom:15px;


}





textarea{

resize:none;

}



.btn-submit{


margin-top:10px;

background:#166534;

color:white;

border:none;

padding:12px 25px;

border-radius:14px;

font-weight:600;

cursor:pointer;

}



.btn-submit:hover{

background:#22c55e;

}



@media(max-width:900px){

.form-grid{

grid-template-columns:1fr;

}

}


</style>



@endsection