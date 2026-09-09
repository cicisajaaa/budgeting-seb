@extends('layouts.dashboard')

@section('content')

<div class="page-header-card">

    <div>

        <div class="page-label">
            MONITORING TUGAS
        </div>


        <h1>
            Monitoring Tugas
        </h1>


        <p>
            Pantau aktivitas pekerjaan, progress, dan penyelesaian task setiap project.
        </p>

    </div>

</div>


<div class="task-stat-grid">


    <div class="task-stat">

        <div class="icon-box green">
            📝
        </div>


        <div>

            <span>
                Total Tugas
            </span>


            <h3>
                {{$tasks->count()}}
            </h3>


<small>
    Sesuai filter
</small>

        </div>

    </div>





    <div class="task-stat">

        <div class="icon-box blue">
            ⏳
        </div>


        <div>

            <span>
                Berjalan
            </span>


            <h3>
                {{$tasks->where('status','sedang_dikerjakan')->count()}}
            </h3>


            <small>
                Sedang dikerjakan
            </small>

        </div>

    </div>





    <div class="task-stat">

        <div class="icon-box orange">
            ✓
        </div>


        <div>

            <span>
                Selesai
            </span>


            <h3>
                {{$tasks->where('status','selesai')->count()}}
            </h3>


            <small>
                Task selesai
            </small>

        </div>

    </div>





    <div class="task-stat">

        <div class="icon-box orange">
            ⚠️
        </div>


        <div>

            <span>
                Terlambat
            </span>


            <h3>
                {{
                    $tasks->filter(function($task){

                        return $task->deadline
                        && now()->gt($task->deadline)
                        && $task->status != 'selesai'
                        && $task->status != 'dibatalkan';

                    })->count()
                }}
            </h3>


            <small>
                Melewati deadline
            </small>


        </div>

    </div>





    <div class="task-stat">

        <div class="icon-box red">
            ❌
        </div>


        <div>

            <span>
                Dibatalkan
            </span>


            <h3>
                {{$tasks->where('status','dibatalkan')->count()}}
            </h3>


            <small>
                Task dibatalkan
            </small>


        </div>
    </div>
    <!-- PROGRESS RATA-RATA -->
  <div class="task-stat">

    <div class="icon-box purple">
        📊
    </div>

    <div class="average-progress-content">

        <span>
            Progress Rata-rata
        </span>

        <h3>
            {{ $averageProgress }}%
        </h3>

        <div class="average-progress-bar">
            <div
                class="average-progress-fill"
                style="width: {{ min(max($averageProgress, 0), 100) }}%;"
            ></div>
        </div>

        <small>
            Rata-rata seluruh task
        </small>

    </div>

</div>

</div>
@php
    $today = now()->startOfDay();

    $lateTasks = $tasks->filter(function ($task) use ($today) {
        return $task->deadline
            && \Carbon\Carbon::parse($task->deadline)->startOfDay()->lt($today)
            && $task->status !== 'selesai'
            && $task->status !== 'dibatalkan';
    });

    $soonTasks = $tasks->filter(function ($task) use ($today) {
        if (!$task->deadline) {
            return false;
        }

        $deadline = \Carbon\Carbon::parse($task->deadline)->startOfDay();

        return $deadline->gte($today)
            && $deadline->lte($today->copy()->addDays(7))
            && $task->status !== 'selesai'
            && $task->status !== 'dibatalkan';
    });

    $noDeadlineTasks = $tasks->filter(function ($task) {
        return !$task->deadline
            && $task->status !== 'selesai'
            && $task->status !== 'dibatalkan';
    });
@endphp

<div class="priority-monitor">

    <div class="priority-header">
        <div>
            <span class="priority-label">PRIORITAS MONITORING</span>
            <h3>Monitoring Deadline</h3>
            <p>Ringkasan task yang membutuhkan perhatian.</p>
        </div>
    </div>

    <div class="priority-grid">

        <!-- TERLAMBAT -->
        <div class="priority-card late">

            <div class="priority-icon">
                ⚠️
            </div>

            <div class="priority-info">
                <span>Task Terlambat</span>

                <strong>
                    {{ $lateTasks->count() }}
                </strong>

                <small>
                    Melewati deadline
                </small>
            </div>

        </div>

        <!-- SEGERA DEADLINE -->
        <div class="priority-card soon">

            <div class="priority-icon">
                ⏰
            </div>

            <div class="priority-info">
                <span>Deadline 7 Hari</span>

                <strong>
                    {{ $soonTasks->count() }}
                </strong>

                <small>
                    Perlu segera dipantau
                </small>
            </div>

        </div>

        <!-- TANPA DEADLINE -->
        <div class="priority-card nodate">

            <div class="priority-icon">
                📅
            </div>

            <div class="priority-info">
                <span>Tanpa Deadline</span>

                <strong>
                    {{ $noDeadlineTasks->count() }}
                </strong>

                <small>
                    Belum memiliki deadline
                </small>
            </div>

        </div>

    </div>

</div>

<div class="division-monitor">

    <div class="division-header">

        <span class="division-label">
            ANALISIS PROGRESS
        </span>

        <h3>
            Progress Berdasarkan Divisi
        </h3>

        <p>
            Rata-rata progress pekerjaan setiap divisi.
        </p>

    </div>


    <div class="division-list">

        @forelse($progressByDivision as $namaDivisi => $data)

            <div class="division-row">

                <div class="division-name">

                    <strong>
                        {{ $namaDivisi }}
                    </strong>

                    <small>
                        {{ $data['total'] }} Task
                    </small>

                </div>


                <div class="division-progress">

                    <div class="division-progress-track">

                        <div
                            class="division-progress-fill"
                            style="width: {{ $data['progress'] }}%"
                        ></div>

                    </div>


                    <span>
                        {{ $data['progress'] }}%
                    </span>

                </div>


            </div>


        @empty

            <div class="division-empty">
                Belum ada data divisi.
            </div>

        @endforelse


    </div>

</div>


<div class="pic-monitor">

    <div class="pic-header">

        <span class="pic-label">
            ANALISIS BEBAN KERJA
        </span>

        <h3>
            Progress Berdasarkan PIC
        </h3>

        <p>
            Monitoring jumlah task dan rata-rata progress setiap PIC.
        </p>

    </div>


    <div class="pic-list">

        @forelse($progressByPIC as $namaPIC => $data)

            <div class="pic-row">


               <div class="pic-name">

    <strong>
        {{ $namaPIC }}
    </strong>

    <small>
        {{ $data['total'] }} Task

        @if(($data['level'] ?? 'Normal') == 'Tinggi')

            <span class="load-high">
                ⚠ Beban Tinggi
            </span>

        @elseif(($data['level'] ?? 'Normal') == 'Sedang')

            <span class="load-medium">
                Beban Sedang
            </span>

        @else

            <span class="load-normal">
                Normal
            </span>

        @endif

    </small>

</div>


                <div class="pic-progress">


                    <div class="pic-progress-track">

                        <div
                            class="pic-progress-fill"
                            style="width:{{ $data['progress'] }}%"
                        ></div>

                    </div>


                    <span>
                        {{ $data['progress'] }}%
                    </span>


                </div>


            </div>


        @empty

            <div class="pic-empty">
                Belum ada data PIC.
            </div>

        @endforelse


    </div>

</div>
<div class="glass-panel">

<div class="table-header">

    <div class="table-title">
        <h3>Daftar Aktivitas Task</h3>
        <p>Monitoring seluruh pekerjaan perusahaan.</p>
    </div>

    <div class="table-actions">

        {{-- IMPORT EXCEL --}}
        <form
            action="{{ route('admin.tasks.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <label class="import-button">
                📥 Import Excel

                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls"
                    required
                    onchange="this.form.submit()"
                    style="display:none;"
                >
            </label>
        </form>

        {{-- TOTAL DATA --}}
        <div class="total-data">
            {{ $tasks->count() }} Task
        </div>

    </div>

</div>


{{-- FILTER --}}
<div class="task-filter-box">

    <form
        method="GET"
        action="{{ route('admin.tasks.index') }}"
        class="task-filter-form"
    >

        {{-- SEARCH --}}
        <div class="filter-item search-item">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari task / project..."
                class="filter-search"
            >
        </div>


        {{-- PERUSAHAAN --}}
        <div class="filter-item">
            <select name="perusahaan_id" class="filter-status">
                <option value="">Semua Perusahaan</option>

                @foreach($perusahaan as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ request('perusahaan_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- PROJECT --}}
        <div class="filter-item">
           <select name="project_id" id="project_id" class="filter-status">
    <option value="">Semua Project</option>

    @foreach($projects as $item)
        <option
            value="{{ $item->id }}"
            data-perusahaan="{{ $item->perusahaan_id }}"
            {{ request('project_id') == $item->id ? 'selected' : '' }}
        >
            {{ $item->nama_proyek }}
        </option>
    @endforeach
</select>
        </div>


        {{-- STATUS --}}
        <div class="filter-item">
            <select name="status" class="filter-status">
                <option value="all">
                    Semua Status
                </option>

                <option
                    value="selesai"
                    {{ request('status') == 'selesai' ? 'selected' : '' }}
                >
                    Selesai
                </option>

                <option
                    value="sedang_dikerjakan"
                    {{ request('status') == 'sedang_dikerjakan' ? 'selected' : '' }}
                >
                    Sedang Dikerjakan
                </option>

                <option
                    value="belum_dikerjakan"
                    {{ request('status') == 'belum_dikerjakan' ? 'selected' : '' }}
                >
                    Belum Dikerjakan
                </option>

                <option
                    value="dibatalkan"
                    {{ request('status') == 'dibatalkan' ? 'selected' : '' }}
                >
                    Dibatalkan
                </option>
            </select>
        </div>


        {{-- DIVISI --}}
        <div class="filter-item">
            <select name="divisi_id" class="filter-status">
                <option value="">
                    Semua Divisi
                </option>

                @foreach($divisi as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ request('divisi_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_divisi }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- PIC --}}
        <div class="filter-item">
            <select name="karyawan_id" class="filter-status">
                <option value="">
                    Semua PIC
                </option>

                @foreach($karyawan as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ request('karyawan_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- BUTTON --}}
        <button
            type="submit"
            class="filter-button"
        >
            Filter
        </button>


        {{-- RESET --}}
        @if(
            request('search')
            || request('status')
            || request('divisi_id')
            || request('karyawan_id')
            || request('perusahaan_id')
            || request('project_id')
        )
            <a
                href="{{ route('admin.tasks.index') }}"
                class="reset-button"
            >
                Reset
            </a>
        @endif

    </form>

</div>





<table>


<thead>

<tr>

<th>
Task
</th>


<th>
Project
</th>


<th>
PIC
</th>


<th>
Divisi
</th>


<th>
Deadline
</th>


<th>
Progress
</th>


<th>
Status
</th>


<th>
Detail
</th>


</tr>

</thead>





<tbody>


@forelse($tasks as $task)


<tr data-status="{{$task->status}}">



<td>

<strong>

{{$task->nama_tugas}}

</strong>


<br>


<small>

{{$task->aktivitas ?? '-'}}

</small>


</td>







<td>

<strong>

{{$task->proyek->nama_proyek ?? '-'}}

</strong>


<br>


<small>

Project ID : {{$task->proyek_id}}

</small>


</td>







<td>

{{$task->karyawan->nama_karyawan ?? '-'}}

</td>







<td>

{{$task->divisi->nama_divisi ?? '-'}}

</td>





<td>

    @if($task->deadline)

        @php
            $deadline = \Carbon\Carbon::parse($task->deadline);
            $terlambat =
                now()->startOfDay()->gt($deadline->startOfDay())
                && $task->status !== 'selesai'
                && $task->status !== 'dibatalkan';
        @endphp

        <div class="deadline-info">

            <span class="
                deadline-date
                @if($terlambat)
                    deadline-late
                @endif
            ">
                {{ $deadline->format('d M Y') }}
            </span>

            @if($terlambat)

                <span class="deadline-label late">
                    Terlambat
                </span>

            @elseif($deadline->isToday())

                <span class="deadline-label today">
                    Hari ini
                </span>

            @elseif($deadline->isTomorrow())

                <span class="deadline-label tomorrow">
                    Besok
                </span>

            @endif

        </div>

    @else

        <span class="deadline-empty">
            -
        </span>

    @endif

</td>





<td>

    @php
        $progress = min(
            max((float) ($task->progres_persen ?? 0), 0),
            100
        );
    @endphp

    <div class="progress-wrapper">

        <div class="progress">

            <div
                class="progress-bar
                @if($progress >= 100)
                    progress-complete
                @elseif($progress > 0)
                    progress-running
                @else
                    progress-empty
                @endif"
                style="width: {{ $progress }}%"
            ></div>

        </div>

        <div class="progress-info">

            <span class="progress-text">
                {{ number_format($progress, 0) }}%
            </span>

            @if($progress >= 100)
                <span class="progress-label complete">
                    Selesai
                </span>
            @elseif($progress > 0)
                <span class="progress-label running">
                    Berjalan
                </span>
            @else
                <span class="progress-label empty">
                    Belum mulai
                </span>
            @endif

        </div>

    </div>

</td>



<td>

    @php

        $terlambat =
            $task->deadline
            && now()->gt($task->deadline)
            && $task->status !== 'selesai'
            && $task->status !== 'dibatalkan';

    @endphp


    @if($task->status === 'dibatalkan')

        <span class="badge-status cancelled">
            Dibatalkan
        </span>

    @elseif($terlambat)

        <span class="badge-status danger">
            Terlambat
        </span>

    @elseif($task->status === 'selesai')

        <span class="badge-status success">
            Selesai
        </span>

    @elseif($task->status === 'sedang_dikerjakan')

        <span class="badge-status warning">
            Sedang Dikerjakan
        </span>

    @else

        <span class="badge-status pending">
            Belum Dikerjakan
        </span>

    @endif

</td>



<td>


<a href="{{route('admin.tasks.show',$task->id)}}"

class="btn-detail">

Lihat

</a>


</td>



</tr>






@empty


<tr>

<td colspan="8">

Belum ada task

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



/* ===============================
HEADER
================================ */


.page-header-card{

    width:100%;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:20px;

    padding:22px 28px;

    margin-bottom:20px;

    box-shadow:
    0 5px 18px rgba(15,23,42,.04);

}



.page-label{

    font-size:9px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:7px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}



.page-header-card p{

    margin:0;

    font-size:11px;

    color:#64748b;

}







/* ===============================
STAT CARD
================================ */

.task-stat-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:16px;
    margin-bottom:20px;
}






.task-stat{


    background:white;


    border:1px solid #e5e7eb;


    border-radius:18px;


    padding:16px;


    display:flex;


    align-items:center;


    gap:12px;


    position:relative;


    overflow:hidden;


    box-shadow:


    0 6px 20px rgba(15,23,42,.04);


}





.task-stat::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:100%;

    height:3px;

    background:#334155;

}





.icon-box{


    width:40px;


    height:40px;


    border-radius:12px;


    display:flex;


    align-items:center;


    justify-content:center;


    font-size:17px;


}





.icon-box.green{

    background:#dcfce7;

}



.icon-box.blue{

    background:#dbeafe;

}



.icon-box.orange{

    background:#fef3c7;

}


.icon-box.red{

    background:#fee2e2;

}

.icon-box.purple{
    background:#ede9fe;
}


.task-stat span{

    font-size:10px;

    color:#64748b;

}





.task-stat h3{

    margin:3px 0;

    font-size:22px;

    font-weight:800;

    color:#172033;

}





.task-stat small{

    font-size:9px;

    color:#94a3b8;

}









/* ===============================
TABLE CARD
================================ */


.glass-panel{


    width:100%;


    background:white;


    border:1px solid #e5e7eb;


    border-radius:20px;


    padding:18px;


    box-shadow:


    0 6px 20px rgba(15,23,42,.04);


}






/* ===============================
   TABLE HEADER
================================ */

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 18px;
}

.table-title h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
    color: #172033;
}

.table-title p {
    margin: 5px 0 0;
    font-size: 10px;
    color: #64748b;
}

.table-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}


/* ===============================
   IMPORT BUTTON
================================ */

.import-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 13px;
    border-radius: 10px;
    background: #16a34a;
    color: white;
    font-size: 10px;
    font-weight: 800;
    cursor: pointer;
    transition: .2s ease;
}

.import-button:hover {
    background: #15803d;
}


/* ===============================
   TOTAL DATA
================================ */

.total-data {
    background: #f1f5f9;
    padding: 7px 12px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    color: #334155;
    white-space: nowrap;
}


/* ===============================
   FILTER BOX
================================ */

.task-filter-box {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
}


/* ===============================
   FILTER FORM
================================ */

.task-filter-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-item {
    display: flex;
}


/* ===============================
   SEARCH
================================ */

.filter-search {
    width: 200px;
    height: 34px;

    padding: 7px 11px;

    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 9px;

    font-size: 10px;
    color: #334155;

    outline: none;
}

.filter-search:focus {
    border-color: #94a3b8;
    box-shadow: 0 0 0 3px rgba(148, 163, 184, .12);
}

.filter-search::placeholder {
    color: #94a3b8;
}


/* ===============================
   SELECT
================================ */

.filter-status {
    height: 34px;
    min-width: 145px;

    border: 1px solid #e2e8f0;
    background: white;

    padding: 7px 11px;
    border-radius: 9px;

    font-size: 10px;
    color: #334155;
    font-weight: 700;

    outline: none;
    cursor: pointer;
}

.filter-status:focus {
    border-color: #94a3b8;
}


/* ===============================
   FILTER BUTTON
================================ */

.filter-button {
    height: 34px;

    border: none;
    padding: 7px 14px;

    border-radius: 9px;

    background: #334155;
    color: white;

    font-size: 10px;
    font-weight: 800;

    cursor: pointer;
    transition: .2s ease;
}

.filter-button:hover {
    background: #1e293b;
}


/* ===============================
   RESET BUTTON
================================ */

.reset-button {
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 7px 13px;

    border-radius: 9px;

    background: #e2e8f0;
    color: #475569;

    text-decoration: none;

    font-size: 10px;
    font-weight: 800;

    transition: .2s ease;
}

.reset-button:hover {
    background: #cbd5e1;
}


/* ===============================
   CANCELLED BADGE
================================ */

.badge-status.cancelled {
    background: #fee2e2;
    color: #b91c1c;
}



.average-progress-content{
    flex:1;
    min-width:0;
}

.average-progress-bar{
    width:100%;
    max-width:110px;
    height:5px;
    margin:5px 0 4px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.average-progress-fill{
    height:100%;
    background:#7c3aed;
    border-radius:20px;
    transition:width .3s ease;
}



/* ===============================
   PRIORITY MONITORING
================================ */

.priority-monitor{
    width:100%;
    background:#ffffff;
    border:1px solid #e5e7eb;
    border-radius:20px;
    padding:18px;
    margin-bottom:20px;
    box-shadow:0 6px 20px rgba(15,23,42,.04);
}

.priority-header{
    margin-bottom:14px;
}

.priority-label{
    font-size:9px;
    letter-spacing:2px;
    font-weight:800;
    color:#64748b;
}

.priority-header h3{
    margin:5px 0 2px;
    font-size:15px;
    font-weight:800;
    color:#172033;
}

.priority-header p{
    margin:0;
    font-size:10px;
    color:#64748b;
}

.priority-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px;
}

.priority-card{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    background:#f8fafc;
}

.priority-icon{
    width:38px;
    height:38px;
    flex:0 0 38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:11px;
    font-size:16px;
}

.priority-card.late .priority-icon{
    background:#fee2e2;
}

.priority-card.soon .priority-icon{
    background:#fef3c7;
}

.priority-card.nodate .priority-icon{
    background:#e2e8f0;
}

.priority-info{
    display:flex;
    flex-direction:column;
    min-width:0;
}

.priority-info span{
    font-size:9px;
    font-weight:700;
    color:#64748b;
}

.priority-info strong{
    margin:2px 0;
    font-size:20px;
    line-height:1.1;
    font-weight:800;
    color:#172033;
}

.priority-info small{
    font-size:8px;
    color:#94a3b8;
}






/* ===============================
PIC MONITOR
================================ */

.pic-monitor{

    width:100%;

    background:white;

    border:1px solid #e5e7eb;

    border-radius:20px;

    padding:18px;

    margin-bottom:20px;

    box-shadow:
    0 6px 20px rgba(15,23,42,.04);

}


.pic-label{

    font-size:9px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}


.pic-header h3{

    margin:5px 0;

    font-size:15px;

    font-weight:800;

    color:#172033;

}


.pic-header p{

    margin:0 0 15px;

    font-size:10px;

    color:#64748b;

}


.pic-list{

    display:flex;

    flex-direction:column;

    gap:12px;

}


.pic-row{

    display:flex;

    align-items:center;

    gap:20px;

}


.pic-name{

    width:180px;

    display:flex;

    flex-direction:column;

}


.pic-name strong{

    font-size:11px;

    color:#172033;

}


.pic-name small{

    font-size:9px;

    color:#94a3b8;

}


.pic-progress{

    flex:1;

    display:flex;

    align-items:center;

    gap:10px;

}


.pic-progress-track{

    flex:1;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}


.pic-progress-fill{

    height:100%;

    background:#16a34a;

    border-radius:20px;

}


.pic-progress span{

    width:40px;

    font-size:10px;

    font-weight:800;

}


.pic-empty{

    text-align:center;

    padding:20px;

    color:#94a3b8;

    font-size:11px;

}


.load-high{

    color:#dc2626;
    font-weight:800;

}


.load-medium{

    color:#d97706;
    font-weight:700;

}


.load-normal{

    color:#16a34a;
    font-weight:700;

}



@media(max-width:700px){

    .priority-grid{
        grid-template-columns:1fr;
    }

}




/* ===============================
DIVISION MONITOR
================================ */

.division-monitor{

    width:100%;

    background:white;

    border:1px solid #e5e7eb;

    border-radius:20px;

    padding:18px;

    margin-bottom:20px;

    box-shadow:
    0 6px 20px rgba(15,23,42,.04);

}


.division-label{

    font-size:9px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}


.division-header h3{

    margin:5px 0;

    font-size:15px;

    font-weight:800;

    color:#172033;

}


.division-header p{

    margin:0 0 15px;

    font-size:10px;

    color:#64748b;

}


.division-list{

    display:flex;

    flex-direction:column;

    gap:12px;

}


.division-row{

    display:flex;

    align-items:center;

    gap:20px;

}


.division-name{

    width:180px;

    display:flex;

    flex-direction:column;

}


.division-name strong{

    font-size:11px;

    color:#172033;

}


.division-name small{

    font-size:9px;

    color:#94a3b8;

}


.division-progress{

    flex:1;

    display:flex;

    align-items:center;

    gap:10px;

}


.division-progress-track{

    flex:1;

    height:8px;

    background:#e2e8f0;

    border-radius:20px;

    overflow:hidden;

}


.division-progress-fill{

    height:100%;

    background:#2563eb;

    border-radius:20px;

}


.division-progress span{

    width:40px;

    font-size:10px;

    font-weight:800;

}


.division-empty{

    text-align:center;

    padding:20px;

    font-size:11px;

    color:#94a3b8;

}


/* ===============================
   RESPONSIVE
================================ */

@media (max-width: 1100px) {

    .table-header {
        flex-direction: column;
        align-items: stretch;
    }

    .table-actions {
        justify-content: space-between;
    }

    .filter-search {
        width: 100%;
    }

    .filter-item {
        flex: 1;
        min-width: 150px;
    }

    .filter-status {
        width: 100%;
    }
}


@media (max-width: 600px) {

    .table-actions {
        flex-direction: column;
        align-items: stretch;
    }

.task-filter-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
    width: 100%;
}
.filter-item {
    flex: 0 0 auto;
}

    .filter-search,
    .filter-status,
    .filter-button,
    .reset-button {
        width: 100%;
    }

}


.table-header h3{


    margin:0;


    font-size:15px;


    font-weight:800;


    color:#172033;


}







.table-header p{


    margin:4px 0 0;


    font-size:10px;


    color:#64748b;


}







.total-data{


    background:#f1f5f9;


    padding:6px 12px;


    border-radius:999px;


    font-size:10px;


    font-weight:700;


    color:#334155;


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


    padding:10px;


    font-size:10px;


    color:#64748b;


    font-weight:800;


    text-align:left;


}






tbody td{


    padding:11px 10px;


    border-bottom:1px solid #f1f5f9;


    font-size:11px;


    color:#334155;


}







tbody tr:hover{


    background:#fafafa;


}







td strong{


    font-size:12px;


    color:#172033;


}





td small{


    display:block;


    margin-top:3px;


    font-size:9px;


    color:#94a3b8;


}









/* ===============================
PROGRESS
================================ */


.progress-wrapper{


    width:95px;


}



.progress{


    width:95px;


    height:6px;


    background:#e2e8f0;


    border-radius:20px;


    overflow:hidden;


}


.progress-bar{
    height:100%;
    border-radius:20px;
    transition:width .3s ease;
}

.progress-complete{
    background:#16a34a;
}

.progress-running{
    background:#2563eb;
}

.progress-empty{
    background:#cbd5e1;
}

.progress-info{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:6px;
    margin-top:4px;
}

.progress-text{
    margin:0;
    font-size:9px;
    font-weight:800;
    color:#334155;
}

.progress-label{
    font-size:8px;
    font-weight:700;
}

.progress-label.complete{
    color:#16a34a;
}

.progress-label.running{
    color:#2563eb;
}

.progress-label.empty{
    color:#94a3b8;
}





.progress-text{


    margin-top:4px;


    font-size:9px;


    font-weight:700;


    color:#64748b;


}









/* ===============================
STATUS BADGE
================================ */


.badge-status{


    display:inline-flex;


    padding:5px 10px;


    border-radius:999px;


    font-size:9px;


    font-weight:800;


    white-space:nowrap;


}





.badge-status.success{


    background:#dcfce7;


    color:#166534;


}





.badge-status.warning{


    background:#fef3c7;


    color:#92400e;


}





.badge-status.pending{


    background:#dbeafe;


    color:#1d4ed8;


}


.badge-status.danger{

    background:#fee2e2;

    color:#b91c1c;

}






/* ===============================
DETAIL BUTTON
================================ */


.btn-detail{


    display:inline-flex;


    align-items:center;


    justify-content:center;


    padding:6px 12px;


    border-radius:10px;


    background:#dbeafe;


    color:#2563eb;


    text-decoration:none;


    font-size:10px;


    font-weight:800;


}





.btn-detail:hover{


    background:#2563eb;


    color:white;


}









/* ===============================
EMPTY
================================ */


td[colspan="8"]{


    text-align:center;


    padding:30px;


    color:#94a3b8;


}


.import-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:7px 12px;
    border-radius:10px;
    background:#16a34a;
    color:white;
    font-size:10px;
    font-weight:800;
    cursor:pointer;
}

.import-button:hover{
    background:#15803d;
}


.filter-status {
    width: 145px;
    height: 34px;

    border: 1px solid #e2e8f0;
    background: #ffffff;

    padding: 7px 10px;
    border-radius: 9px;

    font-size: 10px;
    color: #334155;
    font-weight: 700;

    outline: none;
    cursor: pointer;
}

/* ===============================
FILTER TASK
================================ */

.task-filter-form{

    display:flex;

    align-items:center;

    gap:8px;

    flex-wrap:wrap;

}


.filter-search{
    width: 180px;

    height: 34px;

    padding:7px 11px;

    border:1px solid #e2e8f0;

    background:white;

    border-radius:10px;

    font-size:10px;

    color:#334155;

    outline:none;

}


.filter-search:focus{

    border-color:#94a3b8;

    box-shadow:0 0 0 3px rgba(148,163,184,.12);

}


.filter-search::placeholder{

    color:#94a3b8;

}


.filter-button{

    border:none;

    padding:7px 12px;

    border-radius:10px;

    background:#334155;

    color:white;

    font-size:10px;

    font-weight:800;

    cursor:pointer;

}


.filter-button:hover{

    background:#1e293b;

}


.reset-button{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:7px 12px;

    border-radius:10px;

    background:#f1f5f9;

    color:#475569;

    text-decoration:none;

    font-size:10px;

    font-weight:800;

}


.reset-button:hover{

    background:#e2e8f0;

}





/* ===============================
DEADLINE
================================ */

.deadline-info{
    display:flex;
    flex-direction:column;
    gap:3px;
}

.deadline-date{
    font-size:10px;
    font-weight:700;
    color:#334155;
}

.deadline-late{
    color:#b91c1c;
}

.deadline-label{
    display:inline-flex;
    width:max-content;
    padding:2px 6px;
    border-radius:999px;
    font-size:7px;
    font-weight:800;
}

.deadline-label.late{
    background:#fee2e2;
    color:#b91c1c;
}

.deadline-label.today{
    background:#fef3c7;
    color:#92400e;
}

.deadline-label.tomorrow{
    background:#dbeafe;
    color:#1d4ed8;
}

.deadline-empty{
    color:#94a3b8;
}

/* ===============================
RESPONSIVE
================================ */

@media(max-width:1100px){


.task-stat-grid{

    grid-template-columns:repeat(2,1fr);

}

}


@media(max-width:600px){


.task-stat-grid{

    grid-template-columns:1fr;

}

}


table{

    min-width:900px;

}


}



</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const perusahaanSelect = document.querySelector(
        'select[name="perusahaan_id"]'
    );

    const projectSelect = document.querySelector(
        'select[name="project_id"]'
    );

    if (!perusahaanSelect || !projectSelect) {
        return;
    }

    // Simpan semua project dari Blade
    const allProjects = Array.from(
        projectSelect.querySelectorAll('option[data-perusahaan]')
    ).map(function (option) {
        return {
            id: option.value,
            nama: option.textContent.trim(),
            perusahaan_id: option.getAttribute('data-perusahaan')
        };
    });

    function updateProjectDropdown() {

        const perusahaanId = perusahaanSelect.value;

        // Kosongkan dropdown project
        projectSelect.innerHTML = '';

        // Default
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Semua Project';

        projectSelect.appendChild(defaultOption);

        // Masukkan project sesuai perusahaan
        allProjects.forEach(function (item) {

            if (
                perusahaanId === '' ||
                item.perusahaan_id === perusahaanId
            ) {

                const option = document.createElement('option');

                option.value = item.id;
                option.textContent = item.nama;

                projectSelect.appendChild(option);
            }

        });
    }

    // Saat perusahaan berubah
    perusahaanSelect.addEventListener('change', function () {
        updateProjectDropdown();
    });

    // Jalankan saat halaman pertama kali dibuka
    updateProjectDropdown();

});
</script>


@endsection