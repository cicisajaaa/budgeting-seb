@extends('layouts.dashboard')


@section('content')


<div class="page-header">


<div class="header-top">


<div>

<span class="label">
PROJECT DETAIL
</span>


<h1>
{{ $project->nama_proyek }}
</h1>


<p>
Informasi lengkap perkembangan proyek perusahaan.
</p>


</div>


<a href="{{route('owner.projects')}}" class="btn-back">

Kembali ke Daftar Proyek

</a>


</div>


</div>






{{-- SUMMARY --}}


<div class="summary-grid">



<div class="summary-card">

<span>
Total Anggaran
</span>


<h2>
Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Nilai proyek
</p>


</div>





<div class="summary-card">

<span>
Progress Proyek
</span>


<h2>
{{$project->progres_keseluruhan ?? 0}}%
</h2>


<p>
Tingkat penyelesaian
</p>


</div>





<div class="summary-card">

<span>
Total Pekerjaan
</span>


<h2>
{{$totalTask ?? 0}}
</h2>


<p>
Jumlah task proyek
</p>


</div>





<div class="summary-card">

<span>
Task Selesai
</span>


<h2>
{{$taskSelesai ?? 0}}
</h2>


<p>
Pekerjaan selesai
</p>


</div>





<div class="summary-card">

<span>
Sisa Budget
</span>


<h2>
Rp {{number_format(
$project->sisa_budget ?? 0,
0,
',',
'.'
)}}
</h2>


<p>
Dana tersedia
</p>


</div>


</div>










{{-- INFORMASI PROJECT --}}


<div class="panel">


<h3>
Informasi Proyek
</h3>




<table>



<tr>

<td>
Nama Proyek
</td>


<td>
{{$project->nama_proyek}}
</td>

</tr>





<tr>

<td>
Pemilik Proyek
</td>


<td>
{{$project->pemilik_proyek ?? '-'}}
</td>

</tr>





<tr>

<td>
Tanggal Mulai
</td>


<td>

{{$project->tanggal_mulai
? $project->tanggal_mulai->format('d M Y')
:'-'}}

</td>

</tr>





<tr>

<td>
Tanggal Selesai
</td>


<td>

{{$project->tanggal_selesai
? $project->tanggal_selesai->format('d M Y')
:'-'}}

</td>

</tr>





<tr>

<td>
Status Proyek
</td>


<td>


@if(($project->progres_keseluruhan ?? 0) >= 100)

<span class="status success">
Selesai
</span>


@elseif(($project->progres_keseluruhan ?? 0) > 0)

<span class="status warning">
Berjalan
</span>


@else

<span class="status normal">
Belum Mulai
</span>


@endif


</td>


</tr>



</table>


</div>









{{-- HEALTH PROJECT --}}



<div class="health-grid">



<div class="health-card">


<h3>
Keuangan Proyek
</h3>



<div>

<span>
Total Anggaran
</span>


<strong>
Rp {{number_format(
$project->total_anggaran ?? 0,
0,
',',
'.'
)}}
</strong>


</div>





<div>

<span>
Dana Terpakai
</span>


<strong>
Rp {{number_format(
($project->total_anggaran ?? 0)-($project->sisa_budget ?? 0),
0,
',',
'.'
)}}
</strong>


</div>





<div>

<span>
Budget Terpakai
</span>


<strong>
{{$project->persentase_budget ?? 0}}%
</strong>


</div>





<div>

<span>
Penggunaan Budget
</span>


<div class="budget-progress">

<div style="
width:{{min($project->persentase_budget ?? 0,100)}}%
">
</div>

</div>


</div>





<div>

<span>
Sisa Budget
</span>


<strong>
Rp {{number_format(
$project->sisa_budget ?? 0,
0,
',',
'.'
)}}
</strong>


</div>


</div>







<div class="health-card">



<h3>
Kondisi Proyek
</h3>



<div>

<span>
Kondisi
</span>


<strong>


@if(($project->health_status['label'] ?? '') == 'Kritis')

🔴 Kritis


@elseif(($project->health_status['label'] ?? '') == 'Perhatian')

🟡 Perhatian


@else

🟢 Aman


@endif


</strong>


</div>





<div>

<span>
Progress
</span>


<strong>
{{$project->progres_keseluruhan ?? 0}}%
</strong>


</div>





<div>

<span>
Deadline
</span>


<strong>

{{$project->tanggal_selesai
? $project->tanggal_selesai->format('d M Y')
:'-'}}

</strong>


</div>





<div>

<span>
Risiko Budget
</span>


<strong>


@if(($project->persentase_budget ?? 0) >= 80)

<span class="danger">
Tinggi
</span>


@elseif(($project->persentase_budget ?? 0) >= 50)

<span class="warning">
Sedang
</span>


@else

<span class="success">
Rendah
</span>


@endif


</strong>


</div>



</div>


</div>


{{-- TASK --}}


<div class="panel">


<h3>
📌 Daftar Pekerjaan Proyek
</h3>

<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
Nama Tugas
</th>


<th>
PIC
</th>


<th>
Divisi
</th>


<th>
Prioritas
</th>


<th>
Status
</th>


<th>
Progress
</th>


<th>
Update
</th>


</tr>


</thead>



<tbody>


@forelse($project->tugas ?? [] as $task)


<tr>


<td>


<strong>
{{$task->nama_tugas ?? '-'}}
</strong>


<br>


<small>
{{$task->aktivitas ?? '-'}}
</small>


</td>





<td>

{{$task->karyawan->nama_karyawan ?? '-'}}

</td>





<td>

{{$task->divisi->nama_divisi ?? '-'}}

</td>





<td>


@if(($task->prioritas ?? '') == 'High')


<span class="priority high">
High
</span>


@elseif(($task->prioritas ?? '') == 'Medium')


<span class="priority medium">
Medium
</span>


@else


<span class="priority low">
Low
</span>


@endif


</td>





<td>


@if(in_array($task->status,['selesai','done']))


<span class="status success">
Selesai
</span>



@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))


<span class="status warning">
Berjalan
</span>



@else


<span class="status normal">
Belum Mulai
</span>


@endif


</td>





<td>


<div class="progress">


<div class="progress-fill

@if(($task->progres_persen ?? 0)>=80)

progress-green

@elseif(($task->progres_persen ?? 0)>=50)

progress-blue

@else

progress-yellow

@endif"

style="
width:{{min($task->progres_persen ?? 0,100)}}%
">

</div>


</div>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>


</td>





<td>


@if($task->aktivitasTugas && $task->aktivitasTugas->count())


<strong>

{{$task->aktivitasTugas->last()->tanggal
? $task->aktivitasTugas->last()->tanggal->format('d M Y')
:'-'}}

</strong>


<br>


<small>

{{$task->aktivitasTugas->last()->aktivitas}}

</small>


@else

Belum ada update


@endif


</td>


</tr>




@empty


<tr>

<td colspan="7" align="center">

Belum terdapat pekerjaan

</td>


</tr>



@endforelse


</tbody>


</table>

</div>

</div>
<style>

*{
    box-sizing:border-box;
}

body{
    font-family:Inter,system-ui,sans-serif;
    color:#334155;
}

/* ===============================
   HEADER
================================ */

.page-header{
    background:#fff;
    padding:18px 22px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    margin-bottom:15px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.header-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
}

.label{
    font-size:9px;
    letter-spacing:1.7px;
    font-weight:800;
    color:#64748b;
}

.page-header h1{
    margin:6px 0;
    font-size:21px;
    line-height:1.3;
    font-weight:800;
    color:#172033;
}

.page-header p{
    margin:0;
    font-size:10px;
    color:#64748b;
}

.btn-back{
    background:#0f172a;
    color:#fff;
    padding:8px 14px;
    border-radius:9px;
    font-size:10px;
    font-weight:700;
    text-decoration:none;
    white-space:nowrap;
}

.btn-back:hover{
    background:#334155;
}

/* ===============================
   SUMMARY
================================ */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:10px;
    margin-bottom:15px;
}

.summary-card{
    background:#fff;
    padding:13px 14px;
    min-width:0;
    min-height:82px;
    border-radius:15px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 15px rgba(15,23,42,.035);
    position:relative;
    overflow:hidden;
}

.summary-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:3px;
    background:#334155;
}

.summary-card:nth-child(1)::before{
    background:#334155;
}

.summary-card:nth-child(2)::before{
    background:#2563eb;
}

.summary-card:nth-child(3)::before{
    background:#16a34a;
}

.summary-card:nth-child(4)::before{
    background:#f59e0b;
}

.summary-card:nth-child(5)::before{
    background:#7c3aed;
}

.summary-card span{
    display:block;
    font-size:9px;
    color:#64748b;
    font-weight:600;
}

.summary-card h2{
    margin:5px 0;
    font-size:17px;
    line-height:1.25;
    font-weight:800;
    color:#172033;
    overflow-wrap:anywhere;
}

.summary-card p{
    margin:0;
    font-size:8px;
    color:#94a3b8;
}

/* ===============================
   PANEL
================================ */

.panel{
    background:#fff;
    padding:17px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    margin-bottom:15px;
    min-width:0;
}

.panel h3{
    font-size:14px;
    font-weight:800;
    color:#172033;
    padding-left:8px;
    border-left:3px solid #334155;
    margin:0 0 12px;
}

/* ===============================
   INFO TABLE
================================ */

.panel > table{
    width:100%;
    border-collapse:collapse;
}

.panel > table tr{
    border-bottom:1px solid #f1f5f9;
}

.panel > table tr:last-child{
    border-bottom:none;
}

.panel > table td{
    padding:9px 5px;
    font-size:10px;
}

.panel > table td:first-child{
    width:35%;
    color:#64748b;
    font-weight:600;
}

.panel > table td:last-child{
    color:#172033;
    font-weight:700;
}

/* ===============================
   HEALTH
================================ */

.health-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
    margin-bottom:15px;
}

.health-card{
    background:#fff;
    padding:15px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    min-width:0;
}

.health-card h3{
    margin:0 0 10px;
    font-size:13px;
    font-weight:800;
    color:#172033;
}

.health-card > div{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    padding:9px 0;
    border-bottom:1px solid #f1f5f9;
}

.health-card > div:last-child{
    border-bottom:none;
}

.health-card span{
    font-size:9px;
    color:#64748b;
}

.health-card strong{
    font-size:10px;
    color:#172033;
    text-align:right;
    overflow-wrap:anywhere;
}

.budget-progress{
    width:100px;
    height:7px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.budget-progress div{
    height:100%;
    background:#2563eb;
    border-radius:20px;
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
    font-size:8px;
    font-weight:700;
    white-space:nowrap;
}

.status::before{
    content:"●";
    font-size:6px;
}

.success{
    background:#dcfce7;
    color:#166534;
}

.warning{
    background:#fef3c7;
    color:#92400e;
}

.danger{
    background:#fee2e2;
    color:#b91c1c;
}

.normal{
    background:#e0f2fe;
    color:#0369a1;
}

/* ===============================
   PRIORITY
================================ */

.priority{
    display:inline-flex;
    padding:4px 8px;
    border-radius:999px;
    font-size:8px;
    font-weight:700;
    white-space:nowrap;
}

.priority.high{
    background:#fee2e2;
    color:#b91c1c;
}

.priority.medium{
    background:#fef3c7;
    color:#92400e;
}

.priority.low{
    background:#dcfce7;
    color:#166534;
}

/* ===============================
   TASK TABLE
================================ */

.table-wrapper{
    width:100%;
    max-width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    position:relative;
}

.table-wrapper table{
    width:100%;
    min-width:850px;
    border-collapse:collapse;
}

.table-wrapper th{
    background:#f8fafc;
    padding:9px 10px;
    text-align:left;
    font-size:9px;
    font-weight:700;
    color:#64748b;
    white-space:nowrap;
}

.table-wrapper td{
    padding:9px 10px;
    font-size:9px;
    color:#334155;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

.table-wrapper tbody tr:hover{
    background:#f8fafc;
}

.table-wrapper td strong{
    font-size:10px;
    color:#172033;
}

.table-wrapper small{
    font-size:8px;
    color:#64748b;
}

/* ===============================
   TASK PROGRESS
================================ */

.progress{
    width:85px;
    height:6px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
    display:inline-block;
    vertical-align:middle;
    margin-right:5px;
}

.progress-fill{
    height:100%;
    border-radius:20px;
}

.progress-green{
    background:#16a34a;
}

.progress-blue{
    background:#2563eb;
}

.progress-yellow{
    background:#f59e0b;
}

/* ===============================
   1200px
================================ */

@media(max-width:1200px){

    .summary-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

/* ===============================
   900px
================================ */

@media(max-width:900px){

    .page-header{
        padding:17px;
    }

    .page-header h1{
        font-size:19px;
    }

    .header-top{
        align-items:flex-start;
    }

    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .health-grid{
        grid-template-columns:1fr;
    }

    .panel{
        padding:15px;
    }

    .table-wrapper table{
        min-width:850px;
    }
}

/* ===============================
   MOBILE
================================ */

@media(max-width:600px){

    .page-header{
        padding:15px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .header-top{
        flex-direction:column;
        gap:10px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.4px;
    }

    .page-header h1{
        font-size:17px;
        margin:5px 0;
    }

    .page-header p{
        font-size:9px;
        line-height:1.5;
    }

    .btn-back{
        width:100%;
        text-align:center;
        padding:9px;
        font-size:9px;
        border-radius:9px;
    }

    /* SUMMARY */

    .summary-grid{
        grid-template-columns:1fr 1fr;
        gap:8px;
        margin-bottom:12px;
    }

    .summary-card{
        min-height:72px;
        padding:10px;
        border-radius:13px;
    }

    .summary-card span{
        font-size:8px;
    }

    .summary-card h2{
        font-size:14px;
        margin:4px 0;
    }

    .summary-card p{
        font-size:7px;
    }

    /* PANEL */

    .panel{
        padding:12px;
        border-radius:14px;
        margin-bottom:12px;
    }

    .panel h3{
        font-size:11px;
        padding-left:7px;
        margin-bottom:9px;
    }

    /* INFO */

    .panel > table td{
        padding:8px 3px;
        font-size:8px;
    }

    .panel > table td:first-child{
        width:38%;
    }

    /* HEALTH */

    .health-grid{
        gap:9px;
        margin-bottom:12px;
    }

    .health-card{
        padding:12px;
        border-radius:14px;
    }

    .health-card h3{
        font-size:11px;
        margin-bottom:8px;
    }

    .health-card > div{
        padding:8px 0;
    }

    .health-card span{
        font-size:8px;
    }

    .health-card strong{
        font-size:8px;
    }

    .budget-progress{
        width:75px;
        height:6px;
    }

    /* TASK TABLE */

    .table-wrapper table{
        min-width:820px;
    }

    .table-wrapper th{
        padding:8px;
        font-size:8px;
    }

    .table-wrapper td{
        padding:8px;
        font-size:8px;
    }

    .table-wrapper td strong{
        font-size:9px;
    }

    .table-wrapper small{
        font-size:7px;
    }

    .status{
        padding:4px 7px;
        font-size:7px;
    }

    .priority{
        padding:4px 7px;
        font-size:7px;
    }

    .progress{
        width:70px;
        height:6px;
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
        min-height:68px;
    }

    .health-grid{
        grid-template-columns:1fr;
    }

    .table-wrapper table{
        min-width:800px;
    }
}

/* ===============================
   MOBILE SCROLL INDICATOR
================================ */

.table-wrapper::after{
    display:none;
}

@media(max-width:600px){

    .table-wrapper::after{
        content:"Geser →";
        display:block;
        position:absolute;
        right:8px;
        bottom:4px;
        font-size:9px;
        color:#94a3b8;
        pointer-events:none;
    }
}

</style>

@endsection