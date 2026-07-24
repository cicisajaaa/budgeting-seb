@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

    <div>

        <div class="welcome-label">
            RIWAYAT APPROVAL
        </div>


        <h1>
            History Pengeluaran Dana
        </h1>


        <p>
            Monitoring seluruh pengajuan dana yang telah diproses.
        </p>


        <div class="welcome-tags">

            <span>
                ✓ Approved
            </span>


            <span>
                ✓ Rejected
            </span>


            <span>
                ✓ Audit Keuangan
            </span>

        </div>


    </div>



    <div class="system-status">

        <span></span>

        History Aktif

    </div>


</div>









<!-- FILTER -->

<div class="glass-panel">


<div class="panel-title">

🔎 Filter Riwayat Approval

</div>




<form method="GET"

action="{{route('expense.approval.history')}}"

class="filter-grid">






<div>


<label>
Cari Pemohon
</label>


<input

type="text"

name="search"

placeholder="Nama karyawan..."

value="{{request('search')}}"

>


</div>








<div>


<label>
Project
</label>


<select name="project_id">


<option value="">
Semua Project
</option>



@foreach($projects as $project)


<option value="{{$project->id}}"

@if(request('project_id')==$project->id)

selected

@endif

>


{{$project->nama_project}}


</option>


@endforeach


</select>


</div>








<div>


<label>
Divisi
</label>


<select name="division_id">


<option value="">
Semua Divisi
</option>



@foreach($divisions as $division)


<option value="{{$division->id}}"

@if(request('division_id')==$division->id)

selected

@endif

>


{{$division->nama_divisi}}


</option>


@endforeach


</select>


</div>








<div>


<label>
Status
</label>



<div class="status-action">


<select name="status">


<option value="">
Semua Status
</option>



<option value="approved"

@if(request('status')=='approved')

selected

@endif

>

Approved

</option>




<option value="rejected"

@if(request('status')=='rejected')

selected

@endif

>

Rejected

</option>



</select>





<button type="submit">

🔎

</button>





<a href="{{route('expense.approval.history')}}">

Reset

</a>


</div>


</div>






</form>



</div>







<!-- TABLE -->

<div class="glass-panel">


<div class="panel-title">

📄 Riwayat Pengajuan Pengeluaran

</div>





<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
Tanggal
</th>


<th>
Pemohon
</th>


<th>
Project
</th>


<th>
Jumlah
</th>


<th>
Status
</th>


<th>
Disetujui Oleh
</th>


<th>
Catatan
</th>


</tr>


</thead>



<tbody>


@forelse($requests as $request)



<tr>



<td>

{{\Carbon\Carbon::parse($request->created_at)->format('d M Y')}}

</td>





<td>


<strong>

{{$request->user->name ?? '-'}}

</strong>


<br>


<small>

{{$request->judul}}

</small>


</td>





<td>


{{$request->proyek->nama_proyek ?? '-'}}


<br>


<span class="divisi">

{{$request->divisi->nama_divisi ?? '-'}}

</span>


</td>





<td class="money">


Rp {{number_format($request->jumlah,0,',','.')}}


</td>





<td>


@if($request->status=='approved')


<span class="approved">

✓ Approved

</span>



@else


<span class="rejected">

✕ Rejected

</span>



@endif


</td>





<td>


{{$request->approver->name ?? '-'}}


<br>


<small>


@if($request->approved_at)


{{\Carbon\Carbon::parse($request->approved_at)->format('d M Y H:i')}}


@endif


</small>


</td>






<td>

@if($request->approval_note)

<div class="note-box">

{{ $request->approval_note }}

</div>

@else

-

@endif

</td>




</tr>



@empty



<tr>


<td colspan="7" class="empty">

Belum ada riwayat approval

</td>


</tr>



@endforelse


</tbody>


</table>


</div>


</div>
<style>


/* =========================
WELCOME CARD
========================= */


.welcome-card{

background:

linear-gradient(
135deg,
#166534,
#22c55e
);


padding:28px 32px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;


box-shadow:

0 15px 40px rgba(34,197,94,.2);


}





.welcome-label{


font-size:10px;

letter-spacing:2px;

font-weight:800;

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


padding:7px 14px;

border-radius:20px;

font-size:11px;


}






.system-status{


background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

display:flex;

align-items:center;

gap:8px;

font-weight:700;

font-size:12px;


}





.system-status span{


width:9px;

height:9px;

background:#22c55e;

border-radius:50%;


}







/* =========================
GLASS PANEL
========================= */


.glass-panel{


background:

rgba(255,255,255,.7);


backdrop-filter:

blur(18px);


border-radius:22px;


padding:22px;


margin-bottom:20px;


border:

1px solid rgba(255,255,255,.8);



box-shadow:

0 15px 35px rgba(15,23,42,.05);


}







.panel-title{


font-size:16px;

font-weight:800;

color:#1e293b;

margin-bottom:18px;


}








/* =========================
FILTER ONE ROW
========================= */


.filter-grid{


display:grid;


grid-template-columns:


1.3fr 1fr 1fr 1.4fr;


gap:15px;


align-items:end;


}




.filter-grid label{


display:block;


font-size:11px;


font-weight:700;


color:#64748b;


margin-bottom:7px;


}




.filter-grid input,
.filter-grid select{


width:100%;


height:42px;


padding:0 12px;


border-radius:12px;


border:

1px solid #e2e8f0;


background:white;


font-size:12px;


outline:none;


}





.filter-grid input:focus,
.filter-grid select:focus{


border-color:#22c55e;


}







.status-action{


display:flex;


gap:8px;


}



.status-action select{


flex:1;


}





.status-action button{


height:42px;


width:45px;


border:none;


border-radius:12px;


background:#166534;


color:white;


font-weight:700;


cursor:pointer;


}



.status-action button:hover{


background:#22c55e;


}





.status-action a{


height:42px;


padding:0 16px;


background:#f1f5f9;


border-radius:12px;


display:flex;


align-items:center;


text-decoration:none;


font-size:12px;


font-weight:600;


color:#475569;


}







/* =========================
TABLE
========================= */


.table-wrapper{


overflow-x:auto;


}




table{


width:100%;


border-collapse:collapse;


table-layout:fixed;


}





th{


padding:13px;


background:#f8fafc;


font-size:11px;


text-align:left;


color:#64748b;


white-space:nowrap;


}





td{


padding:14px 12px;


font-size:12px;


border-bottom:

1px solid #f1f5f9;


vertical-align:middle;


}





th:nth-child(1),
td:nth-child(1){

width:12%;

}



th:nth-child(2),
td:nth-child(2){

width:17%;

}



th:nth-child(3),
td:nth-child(3){

width:18%;

}



th:nth-child(4),
td:nth-child(4){

width:15%;

}



th:nth-child(5),
td:nth-child(5){

width:12%;

}



th:nth-child(6),
td:nth-child(6){

width:13%;

}



th:nth-child(7),
td:nth-child(7){

width:13%;

}





small{


font-size:11px;

color:#94a3b8;


}





.division{


font-size:11px;

color:#16a34a;


}





.money{


font-weight:700;

color:#dc2626;


}





.approved,
.rejected{


display:inline-block;


padding:6px 12px;


border-radius:20px;


font-size:10px;


font-weight:700;


white-space:nowrap;


}





.approved{


background:#dcfce7;

color:#166534;


}





.rejected{


background:#fee2e2;

color:#dc2626;


}





.empty{


text-align:center;


padding:35px;


color:#94a3b8;


}









/* =========================
RESPONSIVE
========================= */


@media(max-width:1100px){


.filter-grid{


grid-template-columns:

repeat(2,1fr);


}



}



@media(max-width:700px){


.welcome-card{


flex-direction:column;


align-items:flex-start;


gap:20px;


}




.filter-grid{


grid-template-columns:

1fr;


}



table{


display:block;


overflow-x:auto;


}



}


.note-box{

background:#dcfce7;

color:#166534;

padding:8px 12px;

border-radius:10px;

font-size:12px;

font-weight:600;

line-height:1.4;

max-width:200px;

word-wrap:break-word;

}

</style>
@endsection