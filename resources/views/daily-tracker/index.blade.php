@extends('layouts.dashboard')

@section('content')


<div class="daily-wrapper">


{{-- HEADER --}}

<div class="daily-header">


<div>

<span class="daily-label">
EMPLOYEE WORK TRACKING
</span>


<h1>
Aktivitas Harian
</h1>


<p>
Pantau progres pekerjaan, deadline, dan aktivitas tugas kamu dalam satu sistem.
</p>


</div>



<div class="date-card">

<div>
📅
</div>

<span>
{{date('d M Y')}}
</span>

</div>


</div>



{{-- FILTER PERIODE --}}

<div class="period-filter">

    <form
        method="GET"
        action="{{ route('daily-tracker.index') }}"
    >

        <div class="period-filter-field">

            <label>
                Dari Tanggal
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ $startDate ?? '' }}"
            >

        </div>


        <div class="period-filter-field">

            <label>
                Sampai Tanggal
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ $endDate ?? '' }}"
            >

        </div>


        <div class="period-filter-actions">

            <button type="submit">
                Terapkan
            </button>

            @if(!empty($startDate) || !empty($endDate))

                <a href="{{ route('daily-tracker.index') }}">
                    Reset
                </a>

            @endif

        </div>

    </form>

</div>

{{-- SUMMARY --}}

<div class="summary-grid">



<div class="summary-card">

<div class="summary-icon blue">
📋
</div>


<div>

<label>
Total Tugas
</label>

<h2>
{{$tasks->count()}}
</h2>

<p>
Task diberikan
</p>

</div>


</div>





<div class="summary-card">

<div class="summary-icon green">
⚡
</div>


<div>

<label>
Total Aktivitas
</label>


<h2>

{{$tasks->sum(function($task){

return $task->aktivitasTugas->count();

})}}

</h2>


<p>
Update pekerjaan
</p>


</div>


</div>







<div class="summary-card">

<div class="summary-icon orange">
📊
</div>


<div>


<label>
Progress Rata-rata
</label>


<h2>

{{number_format(
$tasks->avg('progres_persen') ?? 0,
0
)}}%

</h2>


<p>
Keseluruhan task
</p>


</div>


</div>







<div class="summary-card">

<div class="summary-icon purple">
💰
</div>


<div>


<label>
Anggaran Aktivitas
</label>


<h2>

Rp {{number_format(

$tasks->sum(function($task){

return $task->aktivitasTugas
->sum('anggaran_aktivitas');

}),

0,

',',

'.'

)}}

</h2>


<p>
Penggunaan dana
</p>


</div>


</div>



</div>









{{-- TASK MONITORING --}}


<div class="content-panel">


<div class="panel-header">

<div>

<h3>
📌 Pemantauan Tugas
</h3>

<span>
Daftar pekerjaan yang sedang kamu kerjakan
</span>

</div>


</div>





<div class="task-grid">


@forelse($tasks as $task)



<div class="task-card">


<div class="task-header">


<div>

<h4>
{{$task->nama_tugas}}
</h4>


<p>
📁 {{$task->proyek->nama_proyek ?? '-'}}
</p>


</div>




<span class="status-badge

@if(in_array($task->status,['selesai','done']))

success

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

warning

@else

neutral

@endif

">


@if(in_array($task->status,['selesai','done']))

Selesai

@elseif(in_array($task->status,['sedang_dikerjakan','berjalan','progress']))

Berjalan

@else

Belum Dikerjakan

@endif


</span>



</div>






<div class="task-detail">


<div>

<label>
Deadline
</label>


<strong>

@if($task->deadline)

{{Carbon\Carbon::parse($task->deadline)->format('d M Y')}}

@else

-

@endif

</strong>


</div>




<div>

<label>
Progress
</label>


<strong>
{{$task->progres_persen ?? 0}}%
</strong>


</div>




<div>

<label>
Aktivitas
</label>


<strong>
{{$task->aktivitasTugas->count()}}
Update
</strong>


</div>


</div>







<div class="progress-bar">


<div

style="
width:{{min($task->progres_persen ?? 0,100)}}%
"

class="progress-fill">

</div>


</div>







<a href="{{route(
'daily-tracker.show',
$task->id
)}}"

class="update-button">

+ Update Aktivitas

</a>



</div>



@empty


<div class="empty">

Belum ada task.

</div>


@endforelse



</div>


</div>

{{-- TIMELINE AKTIVITAS --}}


<div class="content-panel">


<div class="panel-header">

<div>

<h3>
📝 Timeline Aktivitas
</h3>


<span>
Riwayat update pekerjaan terbaru
</span>


</div>

</div>





@php

$activities = collect();


foreach($tasks as $task){

    foreach($task->aktivitasTugas as $activity){

        $activities->push([

            'task'=>$task->nama_tugas,

            'project'=>$task->proyek->nama_proyek ?? '-',

            'activity'=>$activity

        ]);

    }

}


$activities = $activities->sortByDesc(function($item){

return $item['activity']->tanggal;

});


@endphp






<div class="timeline">


@forelse($activities as $item)



<div class="timeline-item">


<div class="timeline-dot"></div>



<div class="timeline-card">


<div class="timeline-header">


<div>

<h4>
{{$item['task']}}
</h4>


<span>
📁 {{$item['project']}}
</span>


</div>



<div class="progress-badge">

{{$item['activity']->progres ?? 0}}%

</div>


</div>






<p>
{{$item['activity']->aktivitas}}
</p>






<div class="timeline-info">


<span>
👤 {{$item['activity']->karyawan->nama_karyawan ?? '-'}}
</span>


<span>
📅 {{Carbon\Carbon::parse(
$item['activity']->tanggal
)->format('d M Y')}}
</span>


</div>







@if($item['activity']->anggaran_aktivitas > 0)


<div class="budget">

💰 Rp {{number_format(
$item['activity']->anggaran_aktivitas,
0,
',',
'.'
)}}

</div>


@endif





@if($item['activity']->catatan)


<div class="note">

📝 {{$item['activity']->catatan}}

</div>


@endif



</div>


</div>




@empty


<div class="empty">

Belum ada aktivitas tercatat.

</div>


@endforelse



</div>


</div>



</div>




<style>

.daily-wrapper {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}


/* =====================================================
   HEADER
===================================================== */

.daily-header {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
    box-sizing: border-box;
}

.daily-label {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    color: #64748b;
}

.daily-header h1 {
    margin: 9px 0;
    font-size: 28px;
    line-height: 1.3;
    font-weight: 800;
    color: #172033;
}

.daily-header p {
    margin: 0;
    font-size: 13px;
    line-height: 1.5;
    color: #64748b;
}

.date-card {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 12px 18px;
    border-radius: 14px;
    background: #1e293b;
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}


/* =====================================================
   SUMMARY
===================================================== */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    width: 100%;
    margin-bottom: 20px;
}

.summary-card {
    min-width: 0;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 17px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 6px 20px rgba(15, 23, 42, .04);
    box-sizing: border-box;
}

.summary-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.summary-icon.blue {
    background: #dbeafe;
}

.summary-icon.green {
    background: #dcfce7;
}

.summary-icon.orange {
    background: #fef3c7;
}

.summary-icon.purple {
    background: #ede9fe;
}

.summary-card > div:last-child {
    min-width: 0;
}

.summary-card label {
    display: block;
    font-size: 10px;
    color: #64748b;
}

.summary-card h2 {
    margin: 4px 0;
    font-size: 18px;
    line-height: 1.3;
    color: #172033;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.summary-card p {
    margin: 0;
    font-size: 9px;
    line-height: 1.3;
    color: #94a3b8;
}


/* =====================================================
   PANEL
===================================================== */

.content-panel {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 22px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
    box-sizing: border-box;
    min-width: 0;
}

.panel-header {
    margin-bottom: 18px;
}

.panel-header h3 {
    margin: 0;
    font-size: 16px;
    line-height: 1.4;
    font-weight: 800;
    color: #172033;
}

.panel-header span {
    display: block;
    margin-top: 4px;
    font-size: 11px;
    line-height: 1.5;
    color: #94a3b8;
}


/* =====================================================
   TASK MONITORING
===================================================== */

.task-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.task-card {
    min-width: 0;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 17px;
    padding: 18px;
    box-sizing: border-box;
    transition: .2s;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.task-header > div {
    min-width: 0;
}

.task-header h4 {
    margin: 0 0 5px;
    font-size: 14px;
    line-height: 1.45;
    color: #172033;
    overflow-wrap: anywhere;
}

.task-header p {
    margin: 0;
    font-size: 11px;
    line-height: 1.4;
    color: #64748b;
    overflow-wrap: anywhere;
}

.status-badge {
    flex: 0 0 auto;
    padding: 6px 11px;
    border-radius: 999px;
    font-size: 9px;
    line-height: 1.2;
    font-weight: 800;
    white-space: nowrap;
}

.status-badge.success {
    background: #dcfce7;
    color: #166534;
}

.status-badge.warning {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.neutral {
    background: #e2e8f0;
    color: #475569;
}


/* =====================================================
   TASK DETAIL
===================================================== */

.task-detail {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    margin: 17px 0;
}

.task-detail div {
    min-width: 0;
    background: #ffffff;
    border: 1px solid #eef2f7;
    padding: 10px;
    border-radius: 12px;
    box-sizing: border-box;
}

.task-detail label {
    display: block;
    margin-bottom: 4px;
    font-size: 9px;
    color: #94a3b8;
}

.task-detail strong {
    display: block;
    font-size: 11px;
    line-height: 1.4;
    color: #172033;
    overflow-wrap: anywhere;
}


/* =====================================================
   PROGRESS
===================================================== */

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e2e8f0;
    border-radius: 999px;
    overflow: hidden;
    margin-bottom: 14px;
}

.progress-fill {
    height: 100%;
    max-width: 100%;
    background: #334155;
    border-radius: 999px;
}


/* =====================================================
   UPDATE BUTTON
===================================================== */

.update-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 40px;
    padding: 9px 12px;
    background: #1e293b;
    color: #ffffff;
    border-radius: 11px;
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
    box-sizing: border-box;
    transition: .2s;
}

.update-button:hover {
    background: #334155;
}


/* =====================================================
   TIMELINE
===================================================== */

.timeline {
    position: relative;
    width: 100%;
    padding-left: 0;
    box-sizing: border-box;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    min-width: 0;
}

.timeline-dot {
    width: 10px;
    height: 10px;
    min-width: 10px;
    margin-top: 21px;
    background: #334155;
    border-radius: 50%;
}

.timeline-card {
    flex: 1;
    min-width: 0;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 15px;
    box-sizing: border-box;
}

.timeline-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.timeline-header > div:first-child {
    min-width: 0;
}

.timeline-header h4 {
    margin: 0 0 4px;
    font-size: 13px;
    line-height: 1.4;
    color: #172033;
    overflow-wrap: anywhere;
}

.timeline-header span {
    display: block;
    font-size: 10px;
    line-height: 1.4;
    color: #64748b;
    overflow-wrap: anywhere;
}

.progress-badge {
    flex: 0 0 auto;
    padding: 5px 9px;
    background: #dbeafe;
    color: #1d4ed8;
    border-radius: 999px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}

.timeline-card p {
    margin: 10px 0;
    font-size: 11px;
    line-height: 1.6;
    color: #475569;
    overflow-wrap: anywhere;
}

.timeline-info {
    display: flex;
    flex-wrap: wrap;
    gap: 6px 15px;
    font-size: 10px;
    line-height: 1.4;
    color: #64748b;
}

.timeline-info span {
    overflow-wrap: anywhere;
}

.budget {
    margin-top: 10px;
    padding: 9px 10px;
    background: #dcfce7;
    color: #166534;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 700;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.note {
    margin-top: 8px;
    padding: 9px 10px;
    background: #fef3c7;
    color: #92400e;
    border-radius: 10px;
    font-size: 10px;
    line-height: 1.5;
    overflow-wrap: anywhere;
}


/* =====================================================
   EMPTY
===================================================== */

.empty {
    width: 100%;
    padding: 28px 15px;
    text-align: center;
    color: #94a3b8;
    font-size: 11px;
    box-sizing: border-box;
}


/* =====================================================
   TABLET
===================================================== */

@media (max-width: 1100px) {

    .summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .task-grid {
        grid-template-columns: 1fr;
    }
}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 600px) {

    .daily-header {
        flex-direction: column;
        align-items: stretch;
        padding: 17px;
        gap: 13px;
        border-radius: 17px;
        margin-bottom: 15px;
    }

    .daily-label {
        font-size: 8px;
        letter-spacing: 1.5px;
    }

    .daily-header h1 {
        font-size: 19px;
        margin: 6px 0;
    }

    .daily-header p {
        font-size: 10px;
        line-height: 1.5;
    }

    .date-card {
        width: 100%;
        min-height: 38px;
        padding: 9px 12px;
        border-radius: 11px;
        font-size: 10px;
        box-sizing: border-box;
    }


    /* SUMMARY */

    .summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
        margin-bottom: 15px;
    }

    .summary-card {
        padding: 11px;
        gap: 8px;
        border-radius: 14px;
    }

    .summary-icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 9px;
        font-size: 14px;
    }

    .summary-card label {
        font-size: 7px;
    }

    .summary-card h2 {
        font-size: 15px;
        margin: 3px 0;
    }

    .summary-card p {
        font-size: 7px;
    }


    /* PANEL */

    .content-panel {
        padding: 13px;
        border-radius: 15px;
        margin-bottom: 14px;
    }

    .panel-header {
        margin-bottom: 13px;
    }

    .panel-header h3 {
        font-size: 12px;
    }

    .panel-header span {
        font-size: 9px;
    }


    /* TASK */

    .task-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .task-card {
        padding: 12px;
        border-radius: 14px;
    }

    .task-header {
        flex-direction: column;
        gap: 8px;
    }

    .task-header h4 {
        font-size: 12px;
    }

    .task-header p {
        font-size: 9px;
    }

    .status-badge {
        align-self: flex-start;
        font-size: 8px;
        padding: 5px 9px;
    }

    .task-detail {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 6px;
        margin: 12px 0;
    }

    .task-detail div {
        padding: 8px 6px;
        border-radius: 9px;
    }

    .task-detail label {
        font-size: 7px;
    }

    .task-detail strong {
        font-size: 9px;
    }

    .progress-bar {
        height: 7px;
        margin-bottom: 11px;
    }

    .update-button {
        min-height: 37px;
        padding: 8px;
        border-radius: 10px;
        font-size: 9px;
    }


    /* TIMELINE */

    .timeline-item {
        gap: 8px;
        margin-bottom: 10px;
    }

    .timeline-dot {
        width: 8px;
        height: 8px;
        min-width: 8px;
        margin-top: 18px;
    }

    .timeline-card {
        padding: 11px;
        border-radius: 12px;
    }

    .timeline-header {
        flex-direction: column;
        gap: 7px;
    }

    .timeline-header h4 {
        font-size: 10px;
    }

    .timeline-header span {
        font-size: 8px;
    }

    .progress-badge {
        align-self: flex-start;
        font-size: 8px;
        padding: 4px 8px;
    }

    .timeline-card p {
        font-size: 9px;
        line-height: 1.5;
        margin: 8px 0;
    }

    .timeline-info {
        flex-direction: column;
        gap: 4px;
        font-size: 8px;
    }

    .budget,
    .note {
        padding: 8px;
        font-size: 8px;
    }

    .empty {
        padding: 22px 12px;
        font-size: 9px;
    }
}


/* =====================================================
   SMALL PHONE
===================================================== */

@media (max-width: 380px) {

    .summary-card {
        padding: 9px;
    }

    .summary-icon {
        width: 29px;
        height: 29px;
        min-width: 29px;
        font-size: 12px;
    }

    .summary-card h2 {
        font-size: 14px;
    }

    .task-detail label {
        font-size: 6.5px;
    }

    .task-detail strong {
        font-size: 8px;
    }

    .timeline-card {
        padding: 9px;
    }
}
/* =====================================================
   FILTER PERIODE
===================================================== */

.period-filter {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 17px;
    margin-bottom: 20px;
    box-shadow: 0 6px 20px rgba(15, 23, 42, .04);
    box-sizing: border-box;
}

.period-filter form {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    width: 100%;
}

.period-filter-field {
    flex: 1;
    min-width: 0;
}

.period-filter-field label {
    display: block;
    margin-bottom: 6px;
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
}

.period-filter-field input {
    width: 100%;
    height: 40px;
    padding: 0 11px;
    border: 1px solid #dbe1e8;
    border-radius: 10px;
    background: #f8fafc;
    color: #172033;
    font-size: 11px;
    box-sizing: border-box;
    outline: none;
}

.period-filter-field input:focus {
    border-color: #94a3b8;
    background: #ffffff;
}

.period-filter-actions {
    display: flex;
    align-items: center;
    gap: 7px;
    flex: 0 0 auto;
}

.period-filter-actions button,
.period-filter-actions a {
    height: 40px;
    padding: 0 15px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}

.period-filter-actions button {
    border: none;
    background: #1e293b;
    color: #ffffff;
    cursor: pointer;
}

.period-filter-actions button:hover {
    background: #334155;
}

.period-filter-actions a {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.period-filter-actions a:hover {
    background: #e2e8f0;
}


/* =====================================================
   MOBILE FILTER
===================================================== */

@media (max-width: 600px) {

    .period-filter {
        padding: 12px;
        border-radius: 14px;
        margin-bottom: 15px;
    }

    .period-filter form {
        flex-direction: column;
        align-items: stretch;
        gap: 9px;
    }

    .period-filter-field {
        width: 100%;
    }

    .period-filter-field label {
        font-size: 8px;
        margin-bottom: 4px;
    }

    .period-filter-field input {
        height: 37px;
        font-size: 10px;
        border-radius: 9px;
    }

    .period-filter-actions {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
    }

    .period-filter-actions button,
    .period-filter-actions a {
        width: 100%;
        height: 37px;
        font-size: 9px;
    }

}
</style>


@endsection