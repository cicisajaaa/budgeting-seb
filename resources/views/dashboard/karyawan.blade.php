@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

{{-- Wrapper dihapus agar margin/padding otomatis mengikuti bawaan layout (sama seperti Owner) --}}

<div class="welcome-card">
    <div>
        <div class="welcome-label">
            DASHBOARD KARYAWAN
        </div>

        <h1>
            Selamat Datang, {{auth()->user()->name}}
        </h1>

        <p>
            Monitoring aktivitas pekerjaan dan progress project.
        </p>

        <div class="welcome-tags">
            <span>✓ Project</span>
            <span>✓ Task</span>
            <span>✓ Daily Tracker</span>
        </div>
    </div>

    <div class="date-box">
        {{date('d M Y')}}
    </div>
</div>


{{-- ================= STATISTIC ================= --}}
<div class="finance-grid">

    <div class="finance-card">
        <div class="finance-icon green">📁</div>
        <div>
            <label>Total Task</label>
            <h2>{{$employeeTasks->count()}}</h2>
            <small>Task diberikan</small>
        </div>
    </div>

    <div class="finance-card">
        <div class="finance-icon blue">✔</div>
        <div>
            <label>Task Selesai</label>
            <h2>{{$employeeTasks->where('status','done')->count()}}</h2>
            <small>Selesai dikerjakan</small>
        </div>
    </div>

    <div class="finance-card">
        <div class="finance-icon orange">⚡</div>
        <div>
            <label>Sedang Progress</label>
            <h2>{{$employeeTasks->where('status','progress')->count()}}</h2>
            <small>Sedang berjalan</small>
        </div>
    </div>

    <div class="finance-card">
        <div class="finance-icon green">📝</div>
        <div>
            <label>Aktivitas</label>
            <h2>
                {{$employeeTasks->sum(function($task){
                    return $task->activities->count();
                })}}
            </h2>
            <small>Update pekerjaan</small>
        </div>
    </div>

</div>


{{-- ================= MAIN DASHBOARD ================= --}}
<div class="dashboard-grid">

    <div class="panel project-panel">
        <div class="panel-title">📊 Progress Project</div>
        
        @forelse($projectProgress as $project=>$progress)
            <div class="project-progress-card">
                <div class="project-header">
                    <strong>{{$project}}</strong>
                    <span>{{$progress}}%</span>
                </div>
                <div class="progress-number">{{$progress}}%</div>
                <div class="project-track">
                    <div class="project-value" style="width:{{$progress}}%"></div>
                </div>
            </div>
        @empty
            <p>Belum ada project.</p>
        @endforelse
    </div>

    <div class="panel chart-panel">
        <div class="panel-title">📈 Status Task</div>
        <div class="chart-wrapper">
            <canvas id="taskChart"></canvas>
        </div>
    </div>

</div>


{{-- ================= DEADLINE ================= --}}
<div class="panel">
    <div class="panel-title">⏰ Deadline Terdekat</div>
    
    @forelse($deadlineTasks as $task)
        <div class="deadline-item">
            <div>
                <strong>{{$task->nama_task}}</strong>
                <p>{{$task->project->nama_project ?? '-'}}</p>
            </div>
            
            @php
            $days = now()->diffInDays(\Carbon\Carbon::parse($task->deadline), false);
            @endphp

            <span class="deadline-status
                @if($days < 0) danger
                @elseif($days <=3) warning
                @else safe
                @endif ">
                {{$task->deadline}}
            </span>
        </div>
    @empty
        <p>Tidak ada deadline.</p>
    @endforelse
</div>

{{-- ================= ACCOUNT ================= --}}
<div class="panel">
    <div class="panel-title">👤 Informasi Akun</div>
    <div class="info-list">
        <div>
            <span>Nama</span>
            <b>{{auth()->user()->name}}</b>
        </div>
        <div>
            <span>Role</span>
            <b>{{ucfirst(auth()->user()->role)}}</b>
        </div>
        <div>
            <span>Status</span>
            <b class="active">Aktif</b>
        </div>
    </div>
</div>

{{-- ================= AKTIVITAS TERAKHIR ================= --}}
<div class="panel">
    <div class="panel-title">📝 Aktivitas Terakhir</div>
    
    @php
    $activities = $employeeTasks->flatMap(function($task){
        return $task->activities->map(function($activity) use($task){
            return [
                'task'=>$task->nama_task,
                'aktivitas'=>$activity->aktivitas,
                'progress'=>$activity->progress ?? 0,
                'tanggal'=>$activity->tanggal
            ];
        });
    })
    ->sortByDesc('tanggal')
    ->take(5);
    @endphp

    @forelse($activities as $activity)
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <strong>{{$activity['task']}}</strong>
                <p>{{$activity['aktivitas']}}</p>
                <small>{{\Carbon\Carbon::parse($activity['tanggal'])->format('d M Y H:i')}}</small>
            </div>
            <div class="timeline-progress">
                {{$activity['progress']}}%
            </div>
        </div>
    @empty
        <p>Belum ada aktivitas.</p>
    @endforelse
</div>


{{-- ================= CHART ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('taskChart');
new Chart(ctx,{
    type:'doughnut',
    data:{
        labels:['Selesai', 'Progress', 'Todo'],
        datasets:[{
            data:[
                {{$employeeTasks->where('status','done')->count()}},
                {{$employeeTasks->where('status','progress')->count()}},
                {{$employeeTasks->where('status','todo')->count()}}
            ],
            borderWidth:0
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        cutout:'70%',
        plugins:{
            legend:{ position:'bottom' }
        }
    }
});
</script>

<style>
/* ================= GLOBAL DASHBOARD ================= */

/* ================= HEADER (Di-copy persis dari Owner) ================= */
.welcome-card{
    background: linear-gradient(135deg, #166534, #22c55e);
    padding:28px;
    border-radius:24px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    box-shadow: 0 15px 40px rgba(34,197,94,.25);
}

.welcome-label{
    font-size:10px;
    letter-spacing:2px;
    font-weight:700;
    opacity:.8;
}

.welcome-card h1{
    font-size:26px;
    margin:8px 0;
}

.welcome-card p{
    font-size:13px;
    opacity:.9;
    margin:0; 
}

.welcome-tags{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.welcome-tags span{
    background: rgba(255,255,255,.18);
    padding:7px 12px;
    border-radius:20px;
    font-size:11px;
}

.date-box{
    background:white;
    color:#166534;
    padding:12px 18px;
    border-radius:30px;
    font-weight:700;
}

/* ================= CARD (Di-copy persis dari Owner) ================= */
.finance-grid{
    display:grid;
    grid-template-columns: repeat(4,1fr);
    gap:18px;
    margin-bottom:20px;
}

.finance-card{
    background: rgba(255,255,255,.75);
    backdrop-filter:blur(15px);
    padding:20px;
    border-radius:20px;
    box-shadow: 0 10px 30px rgba(15,23,42,.08);
    display:flex; /* Tambahan flex untuk layout icon + teks Karyawan */
    align-items:center;
    gap:15px;
}

.finance-icon{
    width:45px;
    height:45px;
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:20px;
}

.green{ background:#dcfce7; }
.blue{ background:#dbeafe; }
.orange{ background:#fef3c7; }

.finance-card h2{
    font-size:22px;
    color:#166534;
    margin:8px 0;
}

.finance-card label{
    font-size:12px;
    color:#64748b;
}

.finance-card small{
    font-size:11px;
    color:#94a3b8;
}

/* ================= MAIN GRID ================= */
.dashboard-grid{

    width:100%;

    display:grid;

    grid-template-columns:
    1fr 320px;

    gap:20px;

    align-items:start;

}

.dashboard-container{

    width:100%;

    max-width:100%;

    overflow:hidden;

}
.dashboard-container > *{
    max-width:100%;
}

/* ================= PANEL (Di-copy persis dari Owner) ================= */
.panel{
    background: rgba(255,255,255,.7);
    backdrop-filter:blur(15px);
    padding:22px;
    border-radius:22px;
    margin-bottom:20px;
    box-shadow: 0 10px 30px rgba(15,23,42,.08);
}

.panel-title{
    font-size:16px;
    font-weight:700;
    margin-bottom:18px;
}

/* ================= PROJECT ================= */
.project-progress-card{
    width:100%;
    margin-bottom:25px;
}

.project-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom: 10px;
}

.project-header strong{
    color:#166534;
    font-size:14px;
}

.project-header span{
    color:#166534;
    font-size:20px;
    font-weight:800;
}

.progress-number{
    font-size:34px;
    font-weight:800;
    color:#166534;
    margin:10px 0;
}

.project-track{
    width:100%;
    height:14px;
    background:#e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.project-value{
    height:100%;
    background: linear-gradient(90deg, #166534, #22c55e);
    border-radius:20px;
}

/* ================= CHART ================= */
.chart-panel{
    height:100%;
}

.chart-wrapper{
    width:100%;
    height:280px;
    display:flex;
    justify-content:center;
    align-items:center;
}

#taskChart{
    width:220px!important;
    height:220px!important;
}

/* ================= DEADLINE ================= */
.deadline-item{
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
    background:#f8fafc;
    border-radius:15px;
    margin-bottom:10px;
}

.deadline-status{
    padding:7px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

.safe{ background:#dcfce7; color:#166534; }
.warning{ background:#fef3c7; color:#92400e; }
.danger{ background:#fee2e2; color:#991b1b; }

/* ================= ACCOUNT ================= */
.info-list div{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #f1f5f9;
    font-size:13px;
}
.info-list span{ color:#64748b; }
.info-list b{ color:#166534; }
.active{ color:#16a34a!important; font-weight:700; }

/* ================= TIMELINE ================= */
.timeline-item{
    display:flex;
    gap:15px;
    align-items:flex-start;
    padding:18px 0;
    border-bottom:1px solid #f1f5f9;
}

.timeline-dot{
    width:12px;
    height:12px;
    margin-top:5px;
    background:#22c55e;
    border-radius:50%;
}

.timeline-content{ flex:1; }
.timeline-content strong{ color:#166534; font-size:14px; }
.timeline-content p{ margin:6px 0; color:#475569; font-size:13px; }

.timeline-progress{
    background:#dcfce7;
    color:#166534;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

/* ================= RESPONSIVE ================= */
@media(max-width:1200px){
    .dashboard-grid{ grid-template-columns:1fr; }
    .finance-grid{ grid-template-columns: repeat(2,1fr); }
}

@media(max-width:700px){
    .finance-grid{ grid-template-columns:1fr; }
    .welcome-card{ flex-direction:column; align-items:flex-start; gap:15px; }
    .deadline-item{ flex-direction:column; align-items:flex-start; gap:10px; }
}
.chart-panel{

    min-width:0;

}


.chart-wrapper{

    overflow:hidden;

}


canvas{

    max-width:100%!important;

}
</style>
</div>
@endsection