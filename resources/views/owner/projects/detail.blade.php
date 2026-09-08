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


</div>l


{{-- TASK --}}


<div class="panel">


<h3>
📌 Daftar Pekerjaan Proyek
</h3>



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

<style>

/* ===============================
GLOBAL
================================ */

*{
    box-sizing:border-box;
}


body{

    font-family:Inter, system-ui, sans-serif;

    color:#334155;

}



/* ===============================
HEADER
================================ */


.page-header{

    background:white;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.header-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

}



.label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header h1{

    margin:8px 0;

    font-size:26px;

    font-weight:800;

    color:#172033;

}



.page-header p{

    margin:0;

    font-size:12px;

    color:#64748b;

}




.btn-back{

    background:#0f172a;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

}







/* ===============================
SUMMARY
================================ */


.summary-grid{

    display:grid;

    grid-template-columns:repeat(5,1fr);

    gap:15px;

    margin-bottom:22px;

}



.summary-card{

    background:white;

    padding:18px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

    position:relative;

    overflow:hidden;

}



.summary-card::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:4px;

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

    font-size:11px;

    color:#64748b;

    font-weight:700;

}



.summary-card h2{

    margin:8px 0;

    font-size:20px;

    font-weight:800;

    color:#172033;

}



.summary-card p{

    margin:0;

    font-size:11px;

    color:#94a3b8;

}







/* ===============================
PANEL
================================ */


.panel{

    background:white;

    padding:22px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 25px rgba(15,23,42,.05);

    margin-bottom:22px;

}



.panel h3{

    font-size:16px;

    font-weight:800;

    color:#172033;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:18px;

}







/* ===============================
TABLE
================================ */


table{

    width:100%;

    border-collapse:collapse;

}



th{

    background:#f8fafc;

    padding:13px;

    text-align:left;

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



td{

    padding:13px;

    font-size:12px;

    color:#334155;

    border-bottom:1px solid #f1f5f9;

}



tbody tr:hover{

    background:#f8fafc;

}



td strong{

    font-size:13px;

    color:#172033;

}



small{

    font-size:11px;

    color:#64748b;

}







/* ===============================
HEALTH GRID
================================ */


.health-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:18px;

    margin-bottom:22px;

}



.health-card{

    background:white;

    padding:20px;

    border-radius:22px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 8px 20px rgba(15,23,42,.04);

}



.health-card h3{

    margin:0 0 15px;

    font-size:15px;

    font-weight:800;

    color:#172033;

}



.health-card > div{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:12px 0;

    border-bottom:1px solid #f1f5f9;

}



.health-card > div:last-child{

    border-bottom:none;

}



.health-card span{

    font-size:12px;

    color:#64748b;

}



.health-card strong{

    font-size:12px;

    color:#172033;

}







/* ===============================
BUDGET PROGRESS
================================ */


.budget-progress{

    width:120px;

    height:8px;

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

    gap:6px;

    padding:6px 12px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

}



.status::before{

    content:"●";

    font-size:8px;

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

    padding:5px 10px;

    border-radius:999px;

    font-size:10px;

    font-weight:700;

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
TASK PROGRESS
================================ */


.progress{

    width:120px;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

    display:inline-block;

    vertical-align:middle;

    margin-right:8px;

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
RESPONSIVE
================================ */


@media(max-width:1200px){


.summary-grid{

    grid-template-columns:repeat(3,1fr);

}


}



@media(max-width:900px){


.header-top{

    flex-direction:column;

    align-items:flex-start;

}



.summary-grid{

    grid-template-columns:repeat(2,1fr);

}



.health-grid{

    grid-template-columns:1fr;

}


}



@media(max-width:700px){


.summary-grid{

    grid-template-columns:1fr;

}



.panel{

    overflow-x:auto;

}



table{

    min-width:900px;

}


}



</style>

@endsection