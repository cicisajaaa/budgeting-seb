@extends('layouts.dashboard')


@section('content')

<div class="dashboard-header">

<span class="label">
PEMANTAUAN PROYEK
</span>


<h1>
Pemantauan Proyek Perusahaan
</h1>


<p>
Melihat perkembangan proyek, anggaran, tenggat waktu, dan kondisi pekerjaan perusahaan.
</p>


</div>







<div class="summary-grid">



<div class="summary-card">

<span>
Total Proyek
</span>


<h2>
{{ $totalProject ?? 0 }}
</h2>


<p>
Jumlah seluruh proyek
</p>


</div>





<div class="summary-card">

<span>
Total Anggaran
</span>


<h2>
Rp {{number_format(
$totalBudget ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Total nilai proyek
</p>


</div>





<div class="summary-card">

<span>
Proyek Berjalan
</span>


<h2>
{{ $projectBerjalan ?? 0 }}
</h2>


<p>
Sedang dalam pengerjaan
</p>


</div>





<div class="summary-card">

<span>
Proyek Selesai
</span>


<h2>
{{ $projectSelesai ?? 0 }}
</h2>


<p>
Telah diselesaikan
</p>


</div>

<div class="summary-card">

<span>
Progress Rata-rata
</span>


<h2>
{{number_format($averageProgress ?? 0,0)}}%
</h2>


<p>
Perkembangan seluruh proyek
</p>


</div>


</div>









<div class="panel">

<h3>
Daftar Pemantauan Proyek
</h3>

<form method="GET"
      action="{{ route('owner.projects') }}"
      class="project-search">

    <input
        type="text"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Cari nama proyek..."
    >

    <button type="submit">
        Cari
    </button>

    @if(!empty($search))
        <a href="{{ route('owner.projects') }}">
            Reset
        </a>
    @endif

</form>

<div class="search-info">

    @if(!empty($search))

        Hasil pencarian untuk
        <strong>"{{ $search }}"</strong>

    @else

        Menampilkan seluruh proyek perusahaan

    @endif

</div>

<div class="table-wrapper">

<table>


<thead>

<tr>

<th>
Nama Proyek
</th>


<th>
Pemilik Proyek
</th>


<th>
Anggaran
</th>



<th>
Realisasi
</th>


<th>
Sisa Budget
</th>


<th>
Kondisi
</th>


<th>
Progress
</th>


<th>
Deadline
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


@forelse($projects ?? [] as $project)



<tr>



<td>

<strong>
{{ $project->nama_proyek ?? '-' }}
</strong>

</td>





<td>

{{ $project->pemilik_proyek ?? '-' }}

</td>





<td>

Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}

</td>



<td>

Rp {{number_format(
$project->total_realisasi ?? 0,
0,
',',
'.'
)}}

</td>

<td>

Rp {{number_format(
$project->sisa_budget ?? 0,
0,
',',
'.'
)}}

</td>

{{-- KONDISI PROJECT --}}

<td>


@php
    $health = $project->health_status;
@endphp



<div class="health-card 

@if($health['label']=='Kritis')

health-critical

@elseif($health['label']=='Perhatian')

health-warning

@else

health-safe

@endif

">


<div class="health-icon">

@if($health['label']=='Kritis')

🔴

@elseif($health['label']=='Perhatian')

🟡

@else

🟢

@endif

</div>



<div class="health-info">


<strong>
{{$health['label']}}
</strong>


<span>

@if($health['label']=='Kritis')

Risiko Tinggi

@elseif($health['label']=='Perhatian')

Perlu Pantau
@else

Kondisi Stabil

@endif

</span>


</div>


</div>


</td>

{{-- PROGRESS --}}

<td>

@php
    $progress = $project->progres_keseluruhan ?? 0;
@endphp


<div class="progress-wrapper">

    <div class="progress-bar">

        <div class="progress-value

        @if($progress >= 80)
            green

        @elseif($progress >= 50)
            blue

        @else
            yellow

        @endif"

        style="width:{{$progress}}%">
        
        </div>

    </div>


    <span>
        {{$progress}}%
    </span>

</div>


</td>




<td>

@if($project->tanggal_selesai)

@php
$deadline = \Carbon\Carbon::parse($project->tanggal_selesai);
@endphp


<span class="deadline

@if($deadline->isPast())

deadline-danger

@elseif(now()->diffInDays($deadline) <= 7)

deadline-warning

@else

deadline-safe

@endif

">

{{$deadline->format('d M Y')}}

</span>


@else

-

@endif

</td>





<td>


@if(($project->progres_keseluruhan ?? 0) >= 100)

<span class="status selesai">
Selesai
</span>


@elseif(
$project->tanggal_selesai &&
\Carbon\Carbon::parse($project->tanggal_selesai)->isPast()
)

<span class="status terlambat">
Terlambat
</span>


@elseif(($project->progres_keseluruhan ?? 0) >= 50)

<span class="status berjalan">
Berjalan
</span>


@else

<span class="status awal">
Belum Mulai
</span>


@endif


</td>







<td>


<a href="{{ route('owner.project.detail',$project->id) }}"
class="btn-detail">

Detail

</a>


</td>




</tr>





@empty


<tr>

<td colspan="10" align="center">

Belum terdapat data proyek

</td>


</tr>



@endforelse



</tbody>



</table>

</div>
</div>





<style>

/* ===============================
   GLOBAL
================================ */

*{
    box-sizing:border-box;
}

body{
    font-family:Inter,system-ui,sans-serif;
}

/* ===============================
   HEADER
================================ */

.dashboard-header{
    background:#f8fafc;
    padding:20px 24px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    margin-bottom:16px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.label{
    font-size:9px;
    letter-spacing:1.8px;
    font-weight:800;
    color:#64748b;
}

.dashboard-header h1{
    margin:6px 0;
    font-size:21px;
    line-height:1.25;
    color:#172033;
    font-weight:800;
}

.dashboard-header p{
    margin:0;
    font-size:11px;
    color:#64748b;
}

/* ===============================
   SUMMARY
================================ */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:12px;
    margin-bottom:16px;
}

.summary-card{
    background:#fff;
    padding:14px 16px;
    min-height:92px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    position:relative;
    overflow:hidden;
}

.summary-card:nth-child(1){
    border-top:3px solid #334155;
}

.summary-card:nth-child(2){
    border-top:3px solid #2563eb;
}

.summary-card:nth-child(3){
    border-top:3px solid #16a34a;
}

.summary-card:nth-child(4){
    border-top:3px solid #f59e0b;
}

.summary-card:nth-child(5){
    border-top:3px solid #7c3aed;
}

.summary-card span{
    display:block;
    font-size:10px;
    color:#64748b;
    font-weight:600;
}

.summary-card h2{
    margin:5px 0;
    font-size:18px;
    line-height:1.2;
    color:#172033;
    font-weight:800;
    overflow-wrap:anywhere;
}

.summary-card p{
    margin:0;
    font-size:10px;
    color:#94a3b8;
}

/* ===============================
   PANEL
================================ */

.panel{
    background:#fff;
    padding:18px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    margin-bottom:16px;
}

.panel h3{
    font-size:14px;
    font-weight:800;
    color:#172033;
    margin:0 0 13px;
}

/* ===============================
   SEARCH
================================ */

.project-search{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:6px;
}

.project-search input{
    flex:1;
    min-width:0;
    height:36px;
    padding:0 12px;
    border:1px solid #e2e8f0;
    border-radius:9px;
    background:#fff;
    color:#334155;
    font-size:11px;
    outline:none;
}

.project-search input:focus{
    border-color:#94a3b8;
}

.project-search button{
    height:36px;
    padding:0 16px;
    border:none;
    border-radius:9px;
    background:#0f172a;
    color:#fff;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
}

.project-search button:hover{
    background:#334155;
}

.project-search a{
    height:36px;
    padding:0 13px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:#f1f5f9;
    color:#334155;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
}

.search-info{
    margin-bottom:10px;
    font-size:10px;
    color:#94a3b8;
}

.search-info strong{
    color:#475569;
}

/* ===============================
   TABLE
================================ */

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
}

.table-wrapper table{
    width:100%;
    min-width:950px;
    border-collapse:collapse;
}

th{
    padding:10px 11px;
    text-align:left;
    background:#f8fafc;
    color:#64748b;
    font-size:10px;
    font-weight:700;
    white-space:nowrap;
}

td{
    padding:10px 11px;
    border-bottom:1px solid #f1f5f9;
    font-size:10px;
    color:#334155;
    vertical-align:middle;
}

tbody tr:hover{
    background:#f8fafc;
}

td strong{
    color:#172033;
    font-size:11px;
}

/* ===============================
   PROGRESS
================================ */

.progress-wrapper{
    display:flex;
    align-items:center;
    gap:6px;
    min-width:105px;
}

.progress-bar{
    width:70px;
    height:6px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.progress-value{
    height:100%;
    border-radius:20px;
}

.progress-value.green{
    background:#16a34a;
}

.progress-value.blue{
    background:#2563eb;
}

.progress-value.yellow{
    background:#f59e0b;
}

.progress-wrapper span{
    font-size:10px;
    font-weight:700;
    white-space:nowrap;
}

/* ===============================
   HEALTH
================================ */

.health-card{
    display:flex;
    align-items:center;
    gap:5px;
    padding:4px 7px;
    border-radius:8px;
    min-width:88px;
}

.health-icon{
    width:15px;
    height:15px;
    font-size:9px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.health-info{
    display:flex;
    flex-direction:column;
}

.health-info strong{
    font-size:9px;
    line-height:1.1;
}

.health-info span{
    font-size:7px;
    line-height:1.1;
}

.health-safe{
    background:#dcfce7;
    color:#166534;
    border:1px solid #bbf7d0;
}

.health-warning{
    background:#fef3c7;
    color:#92400e;
    border:1px solid #fde68a;
}

.health-critical{
    background:#fee2e2;
    color:#991b1b;
    border:1px solid #fecaca;
}

/* ===============================
   STATUS
================================ */

.status{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 9px;
    border-radius:999px;
    font-size:9px;
    font-weight:700;
    white-space:nowrap;
}

.status::before{
    content:"●";
    font-size:7px;
}

.status.awal{
    background:#f1f5f9;
    color:#475569;
}

.status.selesai{
    background:#dbeafe;
    color:#1d4ed8;
}

.status.berjalan{
    background:#dcfce7;
    color:#166534;
}

.status.terlambat{
    background:#fee2e2;
    color:#b91c1c;
}

/* ===============================
   DEADLINE
================================ */

.deadline{
    font-size:10px;
    font-weight:600;
    white-space:nowrap;
}

/* ===============================
   BUTTON
================================ */

.btn-detail{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 12px;
    border-radius:9px;
    background:#0f172a;
    color:#fff;
    text-decoration:none;
    font-size:9px;
    font-weight:700;
    white-space:nowrap;
}

.btn-detail:hover{
    background:#334155;
}

/* ===============================
   TABLE SCROLL INDICATOR
================================ */

.table-wrapper::after{
    display:none;
}

/* ===============================
   1200px
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .table-wrapper table{
        min-width:950px;
    }
}

/* ===============================
   900px
================================ */

@media(max-width:900px){

    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .dashboard-header{
        padding:18px;
    }

    .dashboard-header h1{
        font-size:19px;
    }

    .panel{
        padding:15px;
        border-radius:16px;
    }

    .table-wrapper table{
        min-width:900px;
    }
}

/* ===============================
   MOBILE
================================ */

@media(max-width:600px){

    .dashboard-header{
        padding:16px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .dashboard-header h1{
        font-size:17px;
    }

    .dashboard-header p{
        font-size:10px;
        line-height:1.5;
    }

    .summary-grid{
        grid-template-columns:1fr 1fr;
        gap:9px;
        margin-bottom:12px;
    }

    .summary-card{
        min-height:82px;
        padding:12px;
        border-radius:14px;
    }

    .summary-card span{
        font-size:9px;
    }

    .summary-card h2{
        font-size:16px;
        margin:4px 0;
    }

    .summary-card p{
        font-size:9px;
    }

    .panel{
        padding:12px;
        border-radius:15px;
    }

    .panel h3{
        font-size:13px;
        margin-bottom:11px;
    }

    .project-search{
        display:grid;
        grid-template-columns:1fr auto;
        gap:7px;
    }

    .project-search input{
        width:100%;
        height:35px;
    }

    .project-search button{
        height:35px;
        padding:0 14px;
    }

    .project-search a{
        grid-column:1 / -1;
        height:32px;
    }

    .search-info{
        margin-bottom:9px;
        font-size:9px;
    }

    .table-wrapper{
        margin:0;
    }

    .table-wrapper table{
        min-width:850px;
    }

    th{
        padding:9px;
        font-size:9px;
    }

    td{
        padding:9px;
        font-size:9px;
    }

    td strong{
        font-size:10px;
    }

    .health-card{
        min-width:85px;
    }

    .progress-wrapper{
        min-width:95px;
    }

    .progress-bar{
        width:60px;
    }

    .btn-detail{
        padding:6px 10px;
        font-size:9px;
    }
}

/* ===============================
   SMALL MOBILE
================================ */

@media(max-width:380px){

    .summary-grid{
        grid-template-columns:1fr;
    }

    .summary-card{
        min-height:75px;
    }

    .project-search{
        grid-template-columns:1fr;
    }

    .project-search button{
        width:100%;
    }

    .project-search a{
        width:100%;
    }
}

</style>

@endsection