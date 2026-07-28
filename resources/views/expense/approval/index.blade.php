@extends('layouts.dashboard')


@section('content')


@if(session('success'))

<div class="alert success">
✓ {{session('success')}}
</div>

@endif



@if(session('error'))

<div class="alert error">
✕ {{session('error')}}
</div>

@endif







<div class="welcome-card">


<div>


<div class="welcome-label">

APPROVAL PENGELUARAN

</div>



<h1>

Persetujuan Dana Karyawan

</h1>



<p>

Verifikasi pengajuan dana dan kontrol penggunaan anggaran perusahaan.

</p>




<div class="welcome-tags">

<span>
✓ Validasi Dana
</span>


<span>
✓ Approval
</span>


<span>
✓ Update Saldo
</span>


</div>


</div>





<div class="system-status">

<span></span>

Approval Aktif

</div>



</div>









<div class="glass-panel">


<div class="panel-title">

🔔 Pengajuan Menunggu Persetujuan

</div>





<table>


<thead>


<tr>


<th>
Pemohon
</th>


<th>
Detail
</th>


<th>
Project
</th>


<th>
Nominal
</th>


<th>
Bukti
</th>


<th>
Aksi
</th>


</tr>


</thead>







<tbody>



@forelse($requests as $request)


<tr>




<td>


<strong>

{{$request->pengguna->name ?? '-'}}

</strong>


<br>


<small>

Karyawan

</small>


</td>







<td>


<strong>

{{$request->judul}}

</strong>


<br>


<small>

{{$request->keterangan ?? '-'}}

</small>


</td>







<td>


<strong>

{{$request->proyek->nama_proyek ?? '-'}}

</strong>


<br>


<span class="division">

{{$request->divisi->nama_divisi ?? '-'}}

</span>


</td>







<td class="money">

Rp {{number_format($request->jumlah,0,',','.')}}

</td>







<td>


@if($request->bukti_pengajuan)


@php

$extension = strtolower(
pathinfo(
$request->bukti_pengajuan,
PATHINFO_EXTENSION
)
);

@endphp





@if(
in_array(
$extension,
[
'jpg',
'jpeg',
'png',
'webp'
]
)
)


<a

href="{{asset('uploads/pengajuan/'.$request->bukti_pengajuan)}}"

target="_blank"

>


<img

src="{{asset('uploads/pengajuan/'.$request->bukti_pengajuan)}}"

class="preview-image"

>


</a>



@else



<a

href="{{asset('uploads/pengajuan/'.$request->bukti_pengajuan)}}"

target="_blank"

class="btn-file"

>

📄 Lihat PDF

</a>



@endif



@else


<span class="no-file">

Tidak ada

</span>


@endif



</td>
<td>


<div class="action">



<a 
href="{{ route('expense.approval.detail',$request->id) }}"
class="detail-btn">

👁 Lihat Detail

</a>





<!-- APPROVE -->

<form method="POST"

action="{{route('expense.approve',$request->id)}}">


@csrf





<select name="rekening_bank_id"

required>


<option value="">

Pilih Rekening

</option>



@foreach($banks as $bank)


<option value="{{$bank->id}}">


{{$bank->nama_bank}}

-

{{$bank->nomor_rekening}}


(Saldo:

Rp {{number_format($bank->saldo,0,',','.')}}

)


</option>


@endforeach



</select>






<textarea

name="catatan_persetujuan"

placeholder="Catatan approval..."

></textarea>






<button

class="approve"

onclick="return confirm('Setujui pengeluaran ini?')">

✓ Setujui

</button>



</form>









<!-- REJECT -->


<form method="POST"

action="{{route('expense.reject',$request->id)}}">


@csrf




<textarea

name="catatan_persetujuan"

placeholder="Alasan penolakan..."

required

></textarea>





<button

class="reject"

onclick="return confirm('Tolak pengajuan ini?')">

✕ Tolak

</button>



</form>







</div>



</td>




</tr>





@empty



<tr>


<td colspan="6" class="empty">

Tidak ada pengajuan menunggu approval

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



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:
rgba(255,255,255,.15);

padding:7px 12px;

border-radius:20px;

font-size:11px;

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





.glass-panel{

background:
rgba(255,255,255,.65);

backdrop-filter:blur(15px);

border-radius:22px;

padding:22px;

border:
1px solid rgba(255,255,255,.8);

}





.panel-title{

font-size:16px;

font-weight:700;

margin-bottom:18px;

}





table{

width:100%;

border-collapse:collapse;

}



th{

padding:15px;

text-align:left;

font-size:12px;

background:#f8fafc;

color:#64748b;

}



td{

padding:15px;

border-bottom:
1px solid #f1f5f9;

font-size:13px;

vertical-align:top;

}



td small{

color:#94a3b8;

font-size:11px;

}



.division{

font-size:11px;

color:#16a34a;

}



.money{

font-weight:700;

color:#dc2626;

}







.action{

display:grid;

grid-template-columns:1fr;

gap:12px;

min-width:300px;

}



.action form{

background:#f8fafc;

padding:15px;

border-radius:15px;

}



select,
textarea{

padding:10px;

border-radius:12px;

border:1px solid #e2e8f0;

font-size:12px;

background:white;

width:100%;

}



textarea{

height:70px;

resize:none;

}





.action button{

border:none;

padding:10px;

border-radius:12px;

font-weight:700;

cursor:pointer;

color:white;

width:100%;

}



.approve{

background:#16a34a;

}



.reject{

background:#dc2626;

}



.approve:hover{

background:#15803d;

}



.reject:hover{

background:#b91c1c;

}





.detail-btn{

background:#2563eb;

color:white;

padding:10px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

display:flex;

align-items:center;

justify-content:center;

}



.detail-btn:hover{

background:#1d4ed8;

}





.preview-image{

width:80px;

height:80px;

object-fit:cover;

border-radius:12px;

border:1px solid #e2e8f0;

cursor:pointer;

}



.preview-image:hover{

transform:scale(1.05);

}




.btn-file{

background:#166534;

color:white;

padding:8px 14px;

border-radius:12px;

font-size:12px;

font-weight:700;

text-decoration:none;

display:inline-block;

}



.no-file{

color:#94a3b8;

font-size:12px;

}





.empty{

text-align:center;

padding:35px;

color:#94a3b8;

}





.alert{

padding:15px 20px;

border-radius:15px;

margin-bottom:20px;

font-size:13px;

font-weight:600;

}



.alert.success{

background:#dcfce7;

color:#166534;

}



.alert.error{

background:#fee2e2;

color:#dc2626;

}



@media(max-width:1000px){


table{

display:block;

overflow-x:auto;

}



.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:20px;

}


}


</style>



@endsection