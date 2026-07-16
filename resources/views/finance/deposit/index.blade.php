@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
PEMBAYARAN MASUK
</div>


<h1>
Kelola Pembayaran Client
</h1>


<p>
Input pembayaran project dan distribusi dana otomatis ke divisi.
</p>


</div>


<div class="system-status">

<span></span>

Finance Active

</div>


</div>







<!-- FORM INPUT -->


<div class="glass-panel">


<div class="panel-title">

💰 Input Pembayaran Baru

</div>





<form method="POST"
action="{{route('finance.deposit.store')}}">

@csrf






<div class="form-grid">







<div>


<label>
Project
</label>



<select name="project_id"
required>


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
Rekening Bank
</label>



<select name="bank_account_id"
required>


<option value="">
-- Pilih Bank --
</option>



@foreach($banks as $bank)


<option value="{{$bank->id}}">


{{$bank->nama_bank}}

-

{{$bank->nomor_rekening}}


</option>


@endforeach



</select>


</div>








<div>


<label>
Jumlah Pembayaran
</label>


<input 
type="number"
name="jumlah_setoran"
placeholder="Masukkan nominal"
required>


</div>







<div>


<label>
Tanggal Pembayaran
</label>


<input
type="date"
name="tanggal_setoran"
required>


</div>



</div>






<button class="btn-submit">

+ Simpan Pembayaran

</button>



</form>



</div>









<!-- RIWAYAT -->



<div class="glass-panel">


<div class="panel-title">

📄 Riwayat Pembayaran

</div>





<table>


<thead>

<tr>


<th>
Tanggal
</th>



<th>
Project
</th>



<th>
Bank
</th>



<th>
Nominal
</th>



</tr>


</thead>





<tbody>


@forelse($deposits as $deposit)



<tr>


<td>

{{\Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y')}}

</td>





<td>

{{$deposit->project->nama_project ?? '-'}}

</td>





<td>

{{$deposit->bank->nama_bank ?? '-'}}

</td>





<td class="income">

+
Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

</td>



</tr>



@empty


<tr>

<td colspan="4">

Belum ada pembayaran

</td>


</tr>


@endforelse



</tbody>


</table>



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

font-size:13px;

display:flex;

gap:8px;

align-items:center;

}



.system-status span{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

}







.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:

blur(15px);


border-radius:22px;


padding:22px;


margin-bottom:20px;


border:

1px solid rgba(255,255,255,.8);


}






.panel-title{

font-size:16px;

font-weight:700;

margin-bottom:18px;

}





.form-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

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
select{


width:100%;


padding:12px;


border-radius:12px;


border:1px solid #e2e8f0;


background:white;


}





.btn-submit{


margin-top:20px;


padding:12px 25px;


border:none;


border-radius:14px;


background:#166534;


color:white;


font-weight:600;


cursor:pointer;


}




.btn-submit:hover{

background:#22c55e;

}







table{


width:100%;


border-collapse:collapse;


}





th{


text-align:left;


padding:14px;


font-size:12px;


color:#64748b;


background:#f8fafc;


}





td{


padding:14px;


border-top:1px solid #f1f5f9;


font-size:13px;


}





.income{


color:#16a34a;


font-weight:700;


}







@media(max-width:1100px){


.form-grid{

grid-template-columns:repeat(2,1fr);

}


}





@media(max-width:700px){


.form-grid{

grid-template-columns:1fr;

}


}



</style>



@endsection