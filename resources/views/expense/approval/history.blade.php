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


<select name="proyek_id">


<option value="">
Semua Project
</option>



@foreach($projects as $project)


<option value="{{$project->id}}"

@if(request('proyek_id')==$project->id)
selected
@endif

>


{{$project->nama_proyek}}


</option>


@endforeach


</select>


</div>








<div>


<label>
Divisi
</label>


<select name="divisi_id">


<option value="">
Semua Divisi
</option>



@foreach($divisions as $division)


<option value="{{$division->id}}"

@if(request('divisi_id')==$division->id)
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

{{$request->created_at->format('d M Y')}}

</td>





<td>


<strong>

{{$request->pengguna?->name ?? '-'}}

</strong>


<br>


<small>

{{$request->judul}}

</small>


</td>





<td>


{{$request->proyek?->nama_proyek ?? '-'}}


<br>


<span class="divisi">

{{$request->divisi?->nama_divisi ?? '-'}}

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


{{$request->penyetuju->name ?? '-'}}


<br>


<small>


@if($request->disetujui_pada)

{{\Carbon\Carbon::parse($request->disetujui_pada)->format('d M Y H:i')}}

@endif





</small>


</td>






<td>

@if($request->catatan_persetujuan)

<div class="note-box">

{{ $request->catatan_persetujuan }}

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

/* ===============================
HEADER
================================ */

.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}





/* TAG */

.welcome-tags{

    display:flex;

    gap:10px;

    margin-top:15px;

}



.welcome-tags span{

    background:#f1f5f9;

    color:#334155;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}








/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    margin-bottom:20px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

}








/* ===============================
FILTER
================================ */


.filter-grid{

    display:grid;

    grid-template-columns:1.3fr 1fr 1fr 1.3fr;

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


    height:42px;

    width:100%;

    padding:0 12px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:12px;

}



.filter-grid input:focus,
.filter-grid select:focus{

    outline:none;

    border-color:#334155;

    background:white;

}







.status-action{

    display:flex;

    gap:8px;

}



.status-action button{


    height:42px;

    width:42px;

    border:none;

    border-radius:12px;

    background:#1e293b;

    color:white;

    cursor:pointer;

}



.status-action a{


    display:flex;

    align-items:center;

    padding:0 15px;

    background:#f1f5f9;

    border-radius:12px;

    text-decoration:none;

    font-size:12px;

    color:#475569;

}









/* ===============================
TABLE
================================ */


.table-wrapper{

    overflow-x:auto;

}



table{

    width:100%;

    border-collapse:collapse;

}



thead th{


    background:#f8fafc;

    padding:14px;

    font-size:11px;

    color:#64748b;

    font-weight:700;

    text-align:left;

}



tbody td{


    padding:14px;

    font-size:12px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

}



tbody tr:hover{

    background:#f8fafc;

}



small{

    font-size:10px;

    color:#94a3b8;

}






.money{

    color:#16a34a;

    font-weight:800;

}






.divisi{

    font-size:10px;

    color:#64748b;

}








/* ===============================
STATUS
================================ */


.approved,
.rejected{


    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

    display:inline-block;

}



.approved{

    background:#dcfce7;

    color:#166534;

}



.rejected{

    background:#fee2e2;

    color:#dc2626;

}








/* ===============================
NOTE
================================ */


.note-box{


    background:#f8fafc;

    color:#475569;

    padding:8px 12px;

    border-radius:12px;

    font-size:11px;

    max-width:200px;

}








/* ===============================
EMPTY
================================ */


.empty{

    text-align:center;

    padding:35px;

    color:#94a3b8;

}








/* RESPONSIVE */

@media(max-width:1100px){

.filter-grid{

    grid-template-columns:repeat(2,1fr);

}

}



@media(max-width:700px){

.filter-grid{

    grid-template-columns:1fr;

}


.welcome-card{

    padding:25px;

}

}

</style>


@endsection