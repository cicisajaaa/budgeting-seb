@extends('layouts.dashboard')

@section('content')


<div class="audit-container">



{{-- HEADER --}}

<div class="dashboard-header">


<span class="label">
AUDIT AKTIVITAS
</span>


<h1>
Aktivitas Terbaru Sistem
</h1>


<p>
Monitoring aktivitas pengguna perusahaan secara real-time.
</p>


</div>









{{-- FILTER --}}

<form
    method="GET"
    action="{{ route('owner.audit') }}"
    class="audit-filter-box">

    <div class="audit-filter-field">

        <label for="modul">
            Modul
        </label>

        <select name="modul" id="modul">

            <option value="">
                Semua Modul
            </option>

            <option
                value="Keuangan"
                {{ request('modul') == 'Keuangan' ? 'selected' : '' }}>
                Keuangan
            </option>

            <option
                value="Project"
                {{ request('modul') == 'Project' ? 'selected' : '' }}>
                Project
            </option>

            <option
                value="Pengajuan Dana"
                {{ request('modul') == 'Pengajuan Dana' ? 'selected' : '' }}>
                Pengajuan Dana
            </option>

            <option
                value="Approval Dana"
                {{ request('modul') == 'Approval Dana' ? 'selected' : '' }}>
                Approval Dana
            </option>

        </select>

    </div>


    <div class="audit-filter-field">

        <label for="tanggal">
            Tanggal
        </label>

        <input
            id="tanggal"
            type="date"
            name="tanggal"
            value="{{ request('tanggal') }}">

    </div>


    <div class="audit-filter-actions">

        <button
            type="submit"
            class="audit-filter-btn">

            <i class="fas fa-filter"></i>

            <span>Filter</span>

        </button>


        @if(request('modul') || request('tanggal'))

            <a
                href="{{ route('owner.audit') }}"
                class="audit-reset-btn">

                <i class="fas fa-rotate-left"></i>

                <span>Reset</span>

            </a>

        @endif


        <a
            href="{{ route('owner.audit.history') }}"
            class="history-btn">

            <i class="fas fa-book-open"></i>

            <span>Semua Riwayat</span>

        </a>

    </div>

</form>









{{-- PANEL --}}


<div class="panel">



<div class="panel-title">

<h3>
📝 Riwayat Aktivitas Sistem
</h3>


<span>
Monitoring Owner
</span>


</div>








@forelse($activities as $activity)



<div class="activity-row">





<div class="activity-icon">


@if($activity->modul == 'Keuangan')

💰


@elseif($activity->modul == 'Project')

📁


@elseif($activity->modul == 'Pengajuan Dana')

💸


@elseif($activity->modul == 'Approval Dana')

✅


@else

📝

@endif



</div>







<div class="activity-body">


<h4>
{{$activity->aksi}}
</h4>




<div class="user">

Oleh :

<strong>
{{$activity->pengguna->name ?? 'System'}}
</strong>

</div>





<p>

{{$activity->deskripsi}}

</p>







<div class="activity-footer">


<span class="module">

{{$activity->modul}}

</span>



<span class="time">

{{$activity->created_at->format('d M Y H:i')}}

</span>


</div>





</div>





</div>





@empty


<div class="empty">

Belum ada aktivitas tercatat.

</div>


@endforelse





</div>





</div>






<style>

*{
    box-sizing:border-box;
}

.audit-container{
    width:100%;
    max-width:100%;
    min-width:0;
}

/* ===============================
   HEADER
================================ */

.dashboard-header{
    background:#f8fafc;
    padding:22px 24px;
    border-radius:20px;
    border:1px solid #e2e8f0;
    margin-bottom:18px;
    box-shadow:0 6px 20px rgba(15,23,42,.045);
}

.label{
    display:block;
    font-size:10px;
    letter-spacing:1.8px;
    font-weight:800;
    color:#64748b;
    text-transform:uppercase;
}

.dashboard-header h1{
    margin:7px 0;
    font-size:23px;
    line-height:1.3;
    font-weight:800;
    color:#172033;
}

.dashboard-header p{
    margin:0;
    font-size:11px;
    line-height:1.5;
    color:#64748b;
}

/* ===============================
   FILTER
================================ */


.history-btn{
    height:40px;
    padding:0 15px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:10px;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
    color:#334155;
    white-space:nowrap;
}

.history-btn:hover{
    background:#f1f5f9;
}

/* ===============================
   PANEL
================================ */

.panel{
    width:100%;
    background:#fff;
    padding:20px;
    border-radius:20px;
    border:1px solid #e2e8f0;
    box-shadow:0 6px 20px rgba(15,23,42,.045);
    min-width:0;
}

.panel-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:14px;
}

.panel-title h3{
    margin:0;
    padding-left:9px;
    border-left:4px solid #334155;
    font-size:15px;
    line-height:1.4;
    font-weight:800;
    color:#172033;
}

.panel-title span{
    font-size:10px;
    color:#94a3b8;
    white-space:nowrap;
}

/* ===============================
   ACTIVITY
================================ */
.activity-row {

    display: flex;

    align-items: flex-start;

    gap: 13px;

    padding: 15px 6px;

    border-bottom: 1px solid #f1f5f9;

    min-width: 0;
}


.activity-row:last-child {

    border-bottom: none;
}


.activity-icon {

    width: 38px;

    height: 38px;

    flex: 0 0 38px;

    border-radius: 11px;

    background: #f8fafc;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 15px;
}


.activity-body {

    flex: 1;

    min-width: 0;
}


.activity-body h4 {

    margin: 0 0 5px;

    font-size: 12px;

    line-height: 1.45;

    font-weight: 800;

    color: #172033;

    overflow-wrap: anywhere;

    word-break: break-word;
}


.user {

    font-size: 10px;

    line-height: 1.4;

    color: #64748b;

}


.user strong {

    color: #334155;

    overflow-wrap: anywhere;
}


.activity-body p {

    margin: 7px 0;

    font-size: 11px;

    line-height: 1.55;

    color: #64748b;

    overflow-wrap: anywhere;

    word-break: break-word;
}


.activity-footer {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 7px;

    margin-top: 9px;
}

/* ===============================
   EMPTY
================================ */

.empty{
    padding:35px 15px;
    text-align:center;
    color:#94a3b8;
    font-size:11px;
}

/* ===============================
   TABLET
================================ */
@media(max-width:900px) {

    .audit-filter-box {

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 10px;

    }


    .audit-filter-field {

        width: 100%;

        flex: none;

    }


    .audit-filter-actions {

        grid-column: 1 / -1;

        width: 100%;

    }

}

/* ===============================
   MOBILE
================================ */
@media(max-width:600px) {

    .audit-filter-box {

        display: flex;

        flex-direction: column;

        align-items: stretch;

        gap: 9px;

        padding: 13px;

        margin-bottom: 14px;

        border-radius: 15px;

    }


    .audit-filter-field {

        width: 100%;

        flex: none;

    }


    .audit-filter-field label {

        font-size: 9px;

    }


    .audit-filter-field select,
    .audit-filter-field input {

        width: 100%;

        height: 40px;

        font-size: 10px;

    }


    .audit-filter-actions {

        width: 100%;

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 8px;

    }


    .audit-filter-btn,
    .audit-reset-btn {

        width: 100%;

        height: 40px;

    }


    .history-btn {

        width: 100%;

        height: 40px;

        grid-column: 1 / -1;

    }

}
/* ===============================
   SMALL MOBILE
================================ */

@media(max-width:380px){

    .dashboard-header h1{
        font-size:18px;
    }

    .activity-body h4{
        font-size:10px;
    }

    .activity-body p{
        font-size:9px;
    }
}
/* ===============================
   AUDIT FILTER
================================ */

.audit-filter-box {

    display: flex;

    align-items: flex-end;

    gap: 12px;

    width: 100%;

    padding: 16px;

    margin-bottom: 18px;

    background: #ffffff;

    border: 1px solid #e2e8f0;

    border-radius: 17px;

    box-shadow:
        0 5px 18px rgba(15,23,42,.04);

    box-sizing: border-box;
}


.audit-filter-field {

    width: 240px;

    flex: 0 0 240px;

    display: flex;

    flex-direction: column;

    gap: 7px;
}


.audit-filter-field label {

    font-size: 10px;

    font-weight: 700;

    color: #64748b;

    line-height: 1.3;
}


.audit-filter-field select,
.audit-filter-field input {

    width: 100%;

    height: 40px;

    padding: 0 12px;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    background: #ffffff;

    color: #334155;

    font-size: 11px;

    font-family: inherit;

    outline: none;

    box-sizing: border-box;

    transition: .2s;
}


.audit-filter-field select:focus,
.audit-filter-field input:focus {

    border-color: #64748b;

    box-shadow:
        0 0 0 3px rgba(100,116,139,.08);
}


/* ACTION */

.audit-filter-actions {

    display: flex;

    align-items: center;

    gap: 8px;

    flex: 0 0 auto;
}


/* FILTER BUTTON */

.audit-filter-btn {

    height: 40px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding: 0 17px;

    border: none;

    border-radius: 10px;

    background: #0f172a;

    color: #ffffff;

    font-size: 11px;

    font-weight: 700;

    font-family: inherit;

    white-space: nowrap;

    cursor: pointer;

    transition: .2s;
}


.audit-filter-btn:hover {

    background: #334155;
}


/* RESET */

.audit-reset-btn {

    height: 40px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding: 0 15px;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    background: #ffffff;

    color: #64748b;

    font-size: 11px;

    font-weight: 700;

    text-decoration: none;

    white-space: nowrap;

    transition: .2s;
}


.audit-reset-btn:hover {

    background: #f1f5f9;

    color: #334155;
}


/* HISTORY */

.history-btn {

    height: 40px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding: 0 15px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    text-decoration: none;

    font-size: 11px;

    font-weight: 700;

    color: #334155;

    white-space: nowrap;

    transition: .2s;
}


.history-btn:hover {

    background: #f1f5f9;

    border-color: #cbd5e1;
}

@media(max-width:600px){

    .audit-filter-box{
        display:flex !important;
        flex-direction:column !important;
        align-items:stretch !important;
        justify-content:flex-start !important;
        gap:9px !important;
        padding:13px !important;
        margin-bottom:14px !important;
        height:auto !important;
        min-height:0 !important;
    }

    .audit-filter-field{
        width:100% !important;
        flex:none !important;
        gap:7px !important;
    }

    .audit-filter-field label{
        font-size:9px !important;
    }

    .audit-filter-field select,
    .audit-filter-field input{
        width:100% !important;
        height:40px !important;
        font-size:10px !important;
    }

    .audit-filter-actions{
        width:100% !important;
        display:grid !important;
        grid-template-columns:1fr 1fr !important;
        gap:8px !important;
        align-items:stretch !important;
    }

    .audit-filter-btn,
    .audit-reset-btn{
        width:100% !important;
        height:40px !important;
    }

    .history-btn{
        width:100% !important;
        height:40px !important;
        grid-column:1 / -1 !important;
    }

}
</style>


@endsection