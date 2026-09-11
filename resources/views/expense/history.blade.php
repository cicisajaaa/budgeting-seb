@extends('layouts.dashboard')

@section('content')

<div class="welcome-card">

    <div>

        <div class="welcome-label">
            EMPLOYEE FINANCE PORTAL
        </div>

        <h1>
            Riwayat Pengajuan Dana
        </h1>

        <p>
            Monitoring status permintaan dana project secara real-time.
        </p>

        <div class="welcome-tags">

            <span>
                ✓ Expense Tracking
            </span>

            <span>
                ✓ Approval Flow
            </span>

            <span>
                ✓ Budget Monitoring
            </span>

        </div>

    </div>


    <a href="{{route('expense.create')}}"
       class="create-btn">

        + Buat Pengajuan

    </a>


</div>






{{-- SUMMARY --}}


<div class="summary-grid">


<div class="summary-card">


<div class="summary-icon">
📄
</div>


<div>

<label>
Total Pengajuan
</label>


<h2>
{{$requests->count()}}
</h2>


<small>
Seluruh pengajuan dana
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
⏳
</div>


<div>

<label>
Menunggu Approval
</label>


<h2>
{{$requests->where('status','pending')->count()}}
</h2>


<small>
Sedang diproses finance
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
✅
</div>


<div>

<label>
Disetujui
</label>


<h2>
{{$requests->where('status','approved')->count()}}
</h2>


<small>
Pengajuan berhasil
</small>


</div>


</div>






<div class="summary-card">


<div class="summary-icon">
❌
</div>


<div>

<label>
Ditolak
</label>


<h2>
{{$requests->where('status','rejected')->count()}}
</h2>


<small>
Perlu diperiksa
</small>


</div>


</div>


</div>









{{-- FILTER --}}


<div class="glass-panel">


<div class="panel-title">
🔎 Filter Status Pengajuan
</div>




<form method="GET"
action="{{route('expense.myhistory')}}">


<div class="filter-box">


<div>


<label>
Status Pengajuan
</label>



<select name="status">


<option value="">
Semua Status
</option>



<option value="pending"
{{request('status')=='pending'?'selected':''}}>
Menunggu
</option>



<option value="approved"
{{request('status')=='approved'?'selected':''}}>
Disetujui
</option>



<option value="rejected"
{{request('status')=='rejected'?'selected':''}}>
Ditolak
</option>



</select>


</div>





<button type="submit">
Filter
</button>




<a href="{{route('expense.myhistory')}}">
Reset
</a>



</div>


</form>


</div>









{{-- TABLE --}}


<div class="glass-panel">


<div class="panel-header">


<div class="panel-title">
📋 Daftar Pengajuan Dana
</div>


<small>
Riwayat pengajuan kebutuhan project
</small>


</div>





<div class="table-wrapper">


<table>


<thead>

<tr>

<th>
Nomor Pengajuan
</th>


<th>
Tanggal
</th>


<th>
Kebutuhan
</th>


<th>
Project
</th>


<th>
Perusahaan
</th>


<th>
Nominal
</th>


<th>
Status
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
{{$request->nomor_pengajuan ?? '-'}}
</strong>

</td>




<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

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


<small>
{{$request->divisi->nama_divisi ?? '-'}}
</small>


</td>






<td>


{{$request->proyek->perusahaan->nama_perusahaan ?? '-'}}


</td>







<td class="money">


Rp {{number_format(
$request->jumlah ?? 0,
0,
',',
'.'
)}}


</td>






<td>



@if($request->status=='pending')


<span class="status pending">
● Menunggu
</span>



@elseif($request->status=='approved')


<span class="status approved">
● Disetujui
</span>



@elseif($request->status=='rejected')


<span class="status rejected">
● Ditolak
</span>


@endif



</td>







<td>


<a href="{{route('expense.detail',$request->id)}}"
class="detail-btn">

Detail

</a>


</td>



</tr>



@empty




<tr>

<td colspan="8" class="empty-cell">
<div class="empty">

<div class="empty-icon">
📄
</div>

<h3>
Belum Ada Pengajuan Dana
</h3>

<p>
Belum ada transaksi pengajuan dana untuk akun ini.
</p>

<a href="{{route('expense.create')}}"
class="create-mini">

+ Buat Pengajuan

</a>

</div>

</td>


</tr>



@endforelse



</tbody>



</table>



</div>



</div>









<style>


.welcome-card{

background:#f8fafc;

border:1px solid #e2e8f0;

border-radius:24px;

padding:35px;

margin-bottom:25px;

display:flex;

justify-content:space-between;

align-items:center;

box-shadow:0 8px 25px rgba(15,23,42,.05);

}


.welcome-label{

font-size:10px;

font-weight:800;

letter-spacing:2px;

color:#64748b;

}



.welcome-card h1{

margin:10px 0;

font-size:26px;

font-weight:800;

color:#172033;

}



.welcome-card p{

font-size:13px;

color:#64748b;

margin:0;

}



.welcome-tags{

display:flex;

gap:10px;

margin-top:15px;

}



.welcome-tags span{

background:#f1f5f9;

padding:7px 14px;

border-radius:999px;

font-size:10px;

font-weight:700;

color:#334155;

}



.create-btn{

background:#1e293b;

color:white;

padding:13px 26px;

border-radius:14px;

font-size:12px;

font-weight:700;

text-decoration:none;

box-shadow:0 8px 20px rgba(15,23,42,.15);

transition:.2s;

}


.create-btn:hover{

transform:translateY(-2px);

background:#0f172a;

}



.empty-cell{

padding:0;

}

.summary-grid{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:18px;

margin-bottom:25px;

}



.summary-card{

background:white;

border:1px solid #e5e7eb;

border-radius:18px;

padding:18px;

display:flex;

align-items:center;

gap:12px;

box-shadow:0 5px 20px rgba(15,23,42,.04);

min-height:90px;

position:relative;

overflow:hidden;

}


.summary-card:nth-child(1):before{
    background:#2563eb;
}

.summary-card:nth-child(2):before{
    background:#f59e0b;
}

.summary-card:nth-child(3):before{
    background:#16a34a;
}

.summary-card:nth-child(4):before{
    background:#dc2626;
}


.summary-card:nth-child(1) .summary-icon{
background:#dbeafe;
}

.summary-card:nth-child(2) .summary-icon{
background:#fef3c7;
}

.summary-card:nth-child(3) .summary-icon{
background:#dcfce7;
}

.summary-card:nth-child(4) .summary-icon{
background:#fee2e2;
}


.summary-card label{

font-size:11px;

color:#64748b;

}



.summary-card h2{

margin:5px 0;

font-size:24px;

font-weight:800;

color:#172033;

}



.summary-card small{

font-size:10px;

color:#94a3b8;

}







.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:25px;

margin-bottom:20px;

box-shadow:0 10px 30px rgba(15,23,42,.05);

}



.panel-header{

margin-bottom:20px;

}



.panel-title{

font-size:16px;

font-weight:800;

color:#172033;

border-left:4px solid #334155;

padding-left:10px;

}






.filter-box{

display:flex;

gap:15px;

align-items:end;

}



.filter-box label{

display:block;

font-size:11px;

font-weight:700;

color:#64748b;

margin-bottom:7px;

}



.filter-box select{

height:42px;

min-width:220px;

border-radius:12px;

border:1px solid #e2e8f0;

padding:0 12px;

}



.filter-box button,
.filter-box a{

height:42px;

padding:0 22px;

border-radius:12px;

background:#334155;

color:white;

border:none;

font-size:12px;

font-weight:700;

text-decoration:none;

display:flex;

align-items:center;

}



.filter-box a{

background:#f1f5f9;

color:#334155;

}






.table-wrapper{

overflow-x:auto;

border-radius:18px;

border:1px solid #e5e7eb;

}





th{

padding:14px;

background:#f8fafc;

font-size:11px;

color:#64748b;

text-align:left;

}



td{
padding:18px 16px;

border-bottom:1px solid #f1f5f9;

font-size:12px;

color:#334155;

vertical-align:middle;

}




tbody tr{

transition:.2s;

}

tbody tr:hover{

transform:translateY(-1px);

background:#f8fafc;

}


td strong{

color:#172033;

}



td small{

color:#94a3b8;

}




.money{

font-weight:800;

color:#166534;

text-align:right;

white-space:nowrap;

}

.status{

display:inline-flex;

align-items:center;

gap:5px;

padding:7px 15px;

border-radius:999px;

font-size:11px;

font-weight:700;

}

.pending{

background:#fef3c7;

color:#92400e;

}



.approved{

background:#dcfce7;

color:#166534;

}



.rejected{

background:#fee2e2;

color:#b91c1c;

}


.detail-btn{

background:#334155;

padding:8px 16px;

border-radius:10px;

font-size:11px;

font-weight:700;

}



.detail-btn:hover{

background:#0f172a;

}





.empty{

text-align:center;

padding:50px;

color:#94a3b8;

}


.empty-icon{

font-size:45px;

margin-bottom:10px;

}



.empty h3{

color:#172033;

margin-bottom:8px;

}



.empty p{

color:#94a3b8;

font-size:13px;

}


.create-mini{

display:inline-block;

margin-top:10px;

background:#334155;

color:white;

padding:10px 18px;

border-radius:12px;

text-decoration:none;

font-size:12px;

}




table{

width:100%;

border-collapse:separate;

border-spacing:0;

}


thead th{

background:#f1f5f9;

padding:15px 16px;

font-size:11px;

font-weight:800;

color:#475569;

text-transform:uppercase;

letter-spacing:.5px;

border-bottom:1px solid #e2e8f0;

}




tbody td{

padding:16px;

border-bottom:1px solid #f1f5f9;

vertical-align:middle;

}



tbody tr:hover{

background:#f8fafc;

transition:.2s;

}


@media(max-width:1000px){

.summary-grid{

grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:700px){


.summary-grid{

grid-template-columns:1fr;

}



.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:20px;

}



.filter-box{

flex-direction:column;

align-items:stretch;

}


}


</style>


@endsection