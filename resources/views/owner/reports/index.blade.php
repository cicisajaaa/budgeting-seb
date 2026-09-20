@extends('layouts.dashboard')

@section('content')


{{-- HEADER --}}

<div class="dashboard-header">

<span class="label">
LAPORAN PERUSAHAAN
</span>


<h1>
Laporan Perusahaan
</h1>


<p>
Ringkasan kondisi keuangan, proyek, dan performa bisnis perusahaan.
</p>


</div>



{{-- FILTER --}}
<form method="GET"
      action="{{ route('owner.reports') }}"
      class="report-filter">

    <div>
        <label>Periode</label>

        <select name="periode" id="periode">

            <option value=""
                {{ request('periode') == '' ? 'selected' : '' }}>
                Semua Periode
            </option>

            <option value="bulan"
                {{ request('periode') == 'bulan' ? 'selected' : '' }}>
                Bulanan
            </option>

            <option value="tahun"
                {{ request('periode') == 'tahun' ? 'selected' : '' }}>
                Tahunan
            </option>

        </select>
    </div>


    <div id="bulan-field">

        <label>Bulan</label>

        <select name="bulan">

            <option value="">Pilih Bulan</option>

            <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>
                Januari
            </option>

            <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>
                Februari
            </option>

            <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>
                Maret
            </option>

            <option value="4" {{ request('bulan') == '4' ? 'selected' : '' }}>
                April
            </option>

            <option value="5" {{ request('bulan') == '5' ? 'selected' : '' }}>
                Mei
            </option>

            <option value="6" {{ request('bulan') == '6' ? 'selected' : '' }}>
                Juni
            </option>

            <option value="7" {{ request('bulan') == '7' ? 'selected' : '' }}>
                Juli
            </option>

            <option value="8" {{ request('bulan') == '8' ? 'selected' : '' }}>
                Agustus
            </option>

            <option value="9" {{ request('bulan') == '9' ? 'selected' : '' }}>
                September
            </option>

            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>
                Oktober
            </option>

            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>
                November
            </option>

            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>
                Desember
            </option>

        </select>

    </div>


    <div id="tahun-field">

        <label>Tahun</label>

        <select name="tahun">

            <option value="">Pilih Tahun</option>

            @for($tahun = now()->year; $tahun >= now()->year - 5; $tahun--)

                <option value="{{ $tahun }}"
                    {{ request('tahun') == $tahun ? 'selected' : '' }}>
                    {{ $tahun }}
                </option>

            @endfor

        </select>

    </div>


    <button type="submit">
        Tampilkan
    </button>

</form>






{{-- KPI --}}


<div class="kpi-grid">



<div class="kpi-card income">

<span>
Total Pendapatan
</span>


<h2 class="green">

Rp {{number_format(
$totalPendapatan ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Pemasukan perusahaan
</small>

</div>




<div class="kpi-card expense">

<span>
Total Pengeluaran
</span>


<h2 class="red">

Rp {{number_format(
$totalPengeluaran ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Dana digunakan
</small>

</div>





<div class="kpi-card profit">

<span>
Profit Bersih
</span>


<h2 class="green">

Rp {{number_format(
$profit ?? 0,
0,
',',
'.'
)}}

</h2>


<small>
Keuntungan perusahaan
</small>

</div>




<div class="kpi-card project">

<span>
Project Aktif
</span>


<h2 class="blue">

{{$projectAktif ?? 0}}

</h2>


<small>
Project berjalan
</small>

</div>






<div class="kpi-card selesai-card">
<span>
Project Selesai
</span>


<h2 class="green">

{{$totalProjectSelesai ?? 0}}

</h2>


<small>
Project selesai
</small>

</div>




<div class="kpi-card warning-card">

<span>
Project Terlambat
</span>


<h2 class="red">

{{$totalProjectTerlambat ?? 0}}

</h2>


<small>
Melewati deadline
</small>

</div>





<div class="kpi-card progress-card">

<span>
Rata-rata Progress
</span>


<h2 class="blue">

{{number_format(
$rataProgress ?? 0,
1
)}}%

</h2>


<small>
Perkembangan project
</small>

</div>




<div class="kpi-card transaction-card">
<span>
Total Transaksi
</span>


<h2 class="purple">

{{$totalTransaksi ?? 0}}

</h2>


<small>
Jumlah transaksi
</small>

</div>


</div>







{{-- ANALISIS --}}


<div class="panel">


<h3>
Analisis Performa Perusahaan
</h3>



<div class="summary-grid">



<div class="summary-card">

<span>
Total Anggaran Project
</span>


<h2>

Rp {{number_format(
$totalAnggaranProject ?? 0,
0,
',',
'.'
)}}

</h2>

<small>
Nilai seluruh project
</small>

</div>





<div class="summary-card">

<span>
Project Berjalan
</span>


<h2>

{{$totalProjectBerjalan ?? 0}}

</h2>

<small>
Sedang dikerjakan
</small>

</div>





<div class="summary-card">

<span>
Efisiensi Dana
</span>


<h2>

{{number_format(
$efisiensiDana ?? 0,
1
)}}%

</h2>

<small>
Efisiensi penggunaan dana
</small>

</div>





<div class="summary-card">

<span>
Saldo Perusahaan
</span>


<h2>

Rp {{number_format(
$saldo ?? 0,
0,
',',
'.'
)}}

</h2>

<small>
Saldo akhir
</small>

</div>



</div>


</div>





{{-- PUSAT LAPORAN --}}

<h2 class="section-title">
    Pusat Laporan
</h2>


<div class="report-grid">


{{-- LAPORAN KEUANGAN --}}

<div class="report-card">

<div class="report-icon">
💰
</div>


<h3>
Laporan Keuangan
</h3>


<p>
Rekap pemasukan, pengeluaran, saldo, dan transaksi perusahaan.
</p>


<div class="button-group">


<a href="{{route('owner.report.finance.pdf')}}"
class="pdf">
PDF
</a>


<a href="{{route('owner.report.finance.excel')}}"
class="excel">
Excel
</a>


</div>


</div>





{{-- LAPORAN PROJECT --}}

<div class="report-card">

<div class="report-icon">
📁
</div>


<h3>
Laporan Proyek
</h3>


<p>
Detail progress proyek, anggaran, dan perkembangan pekerjaan.
</p>


<div class="button-group">


<a href="{{route('owner.report.project.pdf')}}"
class="pdf">
PDF
</a>


<a href="{{route('owner.report.project.excel')}}"
class="excel">
Excel
</a>


</div>


</div>





{{-- ANALISIS PERFORMA --}}

<div class="report-card">

<div class="report-icon">
📊
</div>


<h3>
Analisis Performa
</h3>


<p>
Evaluasi perkembangan bisnis dan performa perusahaan.
</p>


<div class="button-group">


<a href="{{route('owner.report.performance.pdf')}}"
class="pdf">
PDF
</a>


<a href="{{route('owner.report.performance.excel')}}"
class="excel">
Excel
</a>


</div>


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

.dashboard-header{
    background:#f8fafc;
    padding:18px 22px;
    border-radius:18px;
    border:1px solid #e2e8f0;
    margin-bottom:15px;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
}

.label{
    font-size:9px;
    letter-spacing:1.7px;
    font-weight:800;
    color:#64748b;
}

.dashboard-header h1{
    margin:6px 0;
    font-size:21px;
    line-height:1.3;
    color:#172033;
    font-weight:800;
}

.dashboard-header p{
    margin:0;
    font-size:10px;
    line-height:1.5;
    color:#64748b;
}

/* ===============================
   FILTER
================================ */

.report-filter{
    background:#fff;
    padding:14px;
    border-radius:16px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    display:flex;
    gap:10px;
    align-items:end;
    margin-bottom:15px;
}

.report-filter div{
    flex:1;
    min-width:0;
}

.report-filter label{
    display:block;
    font-size:9px;
    font-weight:700;
    color:#64748b;
    margin-bottom:5px;
}

.report-filter input,
.report-filter select{
    width:100%;
    height:36px;
    border-radius:9px;
    border:1px solid #e2e8f0;
    padding:0 10px;
    font-size:10px;
    color:#334155;
    background:#fff;
}

.report-filter button{
    height:36px;
    padding:0 17px;
    border:none;
    border-radius:9px;
    background:#0f172a;
    color:#fff;
    font-size:10px;
    font-weight:700;
    cursor:pointer;
}

/* ===============================
   KPI
================================ */

.kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:10px;
    margin-bottom:15px;
}

.kpi-card{
    background:#fff;
    padding:13px 14px;
    min-height:82px;
    border-radius:15px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 15px rgba(15,23,42,.035);
    position:relative;
    overflow:hidden;
}

.kpi-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:3px;
    background:#334155;
}

.income::before{
    background:#16a34a;
}

.expense::before{
    background:#dc2626;
}

.profit::before{
    background:#2563eb;
}

.project::before{
    background:#f59e0b;
}

.selesai-card::before{
    background:#16a34a;
}

.warning-card::before{
    background:#dc2626;
}

.progress-card::before{
    background:#2563eb;
}

.transaction-card::before{
    background:#7c3aed;
}

.kpi-card span{
    display:block;
    font-size:9px;
    color:#64748b;
    font-weight:600;
}

.kpi-card h2{
    margin:5px 0;
    font-size:17px;
    line-height:1.25;
    font-weight:800;
    color:#172033;
    overflow-wrap:anywhere;
}

.kpi-card small{
    font-size:8px;
    color:#94a3b8;
}

/* ===============================
   PANEL
================================ */

.panel{
    background:#fff;
    padding:16px;
    border-radius:17px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 18px rgba(15,23,42,.04);
    margin-bottom:15px;
    min-width:0;
}

.panel h3{
    margin:0 0 12px;
    font-size:14px;
    font-weight:800;
    color:#172033;
    padding-left:8px;
    border-left:3px solid #334155;
}

/* ===============================
   ANALYSIS
================================ */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:10px;
}

.summary-card{
    background:#f8fafc;
    padding:13px;
    min-width:0;
    border-radius:14px;
    border:1px solid #e2e8f0;
}

.summary-card span{
    display:block;
    font-size:9px;
    color:#64748b;
    font-weight:600;
}

.summary-card h2{
    margin:5px 0;
    font-size:16px;
    line-height:1.25;
    color:#172033;
    font-weight:800;
    overflow-wrap:anywhere;
}

.summary-card small{
    font-size:8px;
    color:#94a3b8;
}

/* ===============================
   REPORT CENTER
================================ */

.section-title{
    font-size:16px;
    font-weight:800;
    color:#172033;
    margin:18px 0 11px;
}

.report-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:10px;
}

.report-card{
    background:#fff;
    padding:15px;
    border-radius:16px;
    border:1px solid #e2e8f0;
    box-shadow:0 5px 16px rgba(15,23,42,.035);
    min-height:175px;
    display:flex;
    flex-direction:column;
}

.report-icon{
    width:36px;
    height:36px;
    background:#f8fafc;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:17px;
    margin-bottom:10px;
}

.report-card h3{
    margin:0 0 6px;
    padding:0;
    border:none;
    font-size:13px;
    color:#172033;
}

.report-card p{
    margin:0;
    font-size:10px;
    line-height:1.5;
    color:#64748b;
    flex:1;
}

/* ===============================
   BUTTON
================================ */

.button-group{
    display:flex;
    gap:6px;
}

.button-group a{
    padding:7px 12px;
    border-radius:8px;
    font-size:9px;
    font-weight:700;
    text-decoration:none;
    text-align:center;
}

.pdf{
    background:#fee2e2;
    color:#b91c1c;
}

.excel{
    background:#dcfce7;
    color:#166534;
}

/* ===============================
   COLOR
================================ */

.green{
    color:#16a34a!important;
}

.red{
    color:#dc2626!important;
}

.blue{
    color:#2563eb!important;
}

.purple{
    color:#7c3aed!important;
}

/* ===============================
   RESPONSIVE
================================ */

@media(max-width:1200px){

    .kpi-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .report-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

@media(max-width:900px){

    .dashboard-header{
        padding:17px;
    }

    .dashboard-header h1{
        font-size:19px;
    }

    .report-filter{
        flex-wrap:wrap;
    }

    .report-filter div{
        min-width:calc(50% - 6px);
    }

    .report-filter button{
        width:100%;
    }

    .kpi-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .report-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:600px){

    .dashboard-header{
        padding:15px;
        border-radius:15px;
        margin-bottom:12px;
    }

    .label{
        font-size:8px;
        letter-spacing:1.4px;
    }

    .dashboard-header h1{
        font-size:17px;
        margin:5px 0;
    }

    .dashboard-header p{
        font-size:9px;
        line-height:1.5;
    }

    /* FILTER */

    .report-filter{
        padding:12px;
        border-radius:14px;
        gap:9px;
        margin-bottom:12px;
    }

    .report-filter div{
        min-width:100%;
    }

    .report-filter label{
        font-size:8px;
    }

    .report-filter input,
    .report-filter select,
    .report-filter button{
        height:36px;
        font-size:9px;
    }

    /* KPI */

    .kpi-grid{
        grid-template-columns:1fr 1fr;
        gap:8px;
        margin-bottom:12px;
    }

    .kpi-card{
        min-height:72px;
        padding:10px;
        border-radius:13px;
    }

    .kpi-card span{
        font-size:8px;
    }

    .kpi-card h2{
        font-size:13px;
        margin:4px 0;
    }

    .kpi-card small{
        font-size:7px;
    }

    /* PANEL */

    .panel{
        padding:12px;
        border-radius:14px;
        margin-bottom:12px;
    }

    .panel h3{
        font-size:12px;
        margin-bottom:10px;
    }

    /* ANALYSIS */

    .summary-grid{
        grid-template-columns:1fr 1fr;
        gap:8px;
    }

    .summary-card{
        padding:10px;
        border-radius:12px;
    }

    .summary-card span{
        font-size:8px;
    }

    .summary-card h2{
        font-size:13px;
    }

    .summary-card small{
        font-size:7px;
    }

    /* REPORT */

    .section-title{
        font-size:14px;
        margin:15px 0 9px;
    }

    .report-grid{
        grid-template-columns:1fr;
        gap:9px;
    }

    .report-card{
        min-height:150px;
        padding:13px;
        border-radius:14px;
    }

    .report-icon{
        width:32px;
        height:32px;
        font-size:15px;
        border-radius:9px;
        margin-bottom:8px;
    }

    .report-card h3{
        font-size:12px;
    }

    .report-card p{
        font-size:9px;
    }

    .button-group a{
        flex:1;
        padding:7px 8px;
        font-size:8px;
    }
}

@media(max-width:380px){

    .kpi-grid,
    .summary-grid{
        grid-template-columns:1fr;
    }

    .kpi-card{
        min-height:68px;
    }

    .summary-card{
        min-height:65px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const periode = document.getElementById('periode');
    const bulanField = document.getElementById('bulan-field');
    const tahunField = document.getElementById('tahun-field');

    function updateFilter() {

        if (periode.value === 'bulan') {

            bulanField.style.display = 'block';
            tahunField.style.display = 'block';

        } else if (periode.value === 'tahun') {

            bulanField.style.display = 'none';
            tahunField.style.display = 'block';

        } else {

            bulanField.style.display = 'none';
            tahunField.style.display = 'none';

        }
    }

    periode.addEventListener('change', updateFilter);

    updateFilter();

});
</script>
@endsection