@extends('layouts.dashboard')

@section('content')


{{-- ================= HEADER ================= --}}

<div class="page-header-card">

    <div>

        <div class="page-label">
            PROJECT MANAGEMENT
        </div>


        <h1>
            Tambah Tugas Project
        </h1>


        <p>
            Tambahkan pekerjaan untuk project 
            <b>{{ $project->nama_proyek }}</b>
        </p>


    </div>



    <a href="{{ url()->previous() }}" class="btn-back">
        ← Kembali
    </a>


</div>






{{-- ================= FORM ================= --}}

<div class="glass-panel">


<div class="panel-title">

📝 Informasi Tugas Project

</div>



<form method="POST"
action="{{ route('admin.tasks.store',$project->id) }}">


@csrf





<div class="form-grid">



<div class="form-group">

<label>
Nama Tugas
</label>

<input 
type="text"
name="nama_tugas"
placeholder="Masukkan nama tugas"
required>

</div>







<div class="form-group">

<label>
Karyawan PIC
</label>


<select name="karyawan_id">


<option value="">
-- Pilih Karyawan --
</option>


@foreach($karyawan as $item)

<option value="{{ $item->id }}">

{{ $item->nama_karyawan }}

</option>

@endforeach


</select>

</div>









<div class="form-group">

<label>
Divisi
</label>


<select name="divisi_id">


<option value="">
-- Pilih Divisi --
</option>


@foreach($divisi as $item)

<option value="{{ $item->id }}">

{{ $item->nama_divisi }}

</option>

@endforeach


</select>

</div>









<div class="form-group">

<label>
Tanggal Mulai
</label>


<input 
type="date"
name="tanggal"
required>

</div>









<div class="form-group full">

<label>
Aktivitas
</label>


<textarea

name="aktivitas"

placeholder="Deskripsi aktivitas tugas"

required></textarea>


</div>









<div class="form-group">

<label>
Prioritas
</label>

<select name="prioritas">

<option value="Low">
Rendah
</option>

<option value="Medium">
Sedang
</option>

<option value="High">
Tinggi
</option>

</select>


</div>









<div class="form-group">

<label>
Deadline
</label>


<input
type="date"
name="deadline">

</div>







<div class="form-group">

<label>
Status
</label>

<input
type="text"
value="Otomatis berdasarkan Progress"
readonly>

</div>







<div class="form-group">

<label>
Progress (%)
</label>


<input

type="number"

name="progres_persen"

min="0"

max="100"

value="0"

required>


</div>




</div>









<div class="form-action">


<button class="btn-save">

💾 Simpan Tugas

</button>


</div>






</form>


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

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:25px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.page-header-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* ===============================
BACK BUTTON
================================ */

.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:10px 18px;

    border-radius:12px;

    color:#334155;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

}



.btn-back:hover{

    background:#334155;

    color:white;

}







/* ===============================
MAIN PANEL
================================ */

.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:20px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}




.panel-title{

    font-size:15px;

    font-weight:800;

    color:#1e293b;

    margin-bottom:20px;

    padding-left:10px;

    border-left:4px solid #334155;

}








/* ===============================
FORM GRID
================================ */

.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:16px;

}



.form-group{

    display:flex;

    flex-direction:column;

}



.form-group.full{

    grid-column:1/-1;

}





.form-group label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}





.form-group input,
.form-group select,
.form-group textarea{

    width:100%;

    border-radius:12px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:10px 13px;

    font-size:12px;

    color:#172033;

}



.form-group input,
.form-group select{

    height:40px;

}



.form-group textarea{

    min-height:100px;

    resize:none;

}





.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{

    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.1);

}







/* ===============================
ACTION
================================ */


.form-action{

    margin-top:25px;

    padding-top:18px;

    border-top:1px solid #e5e7eb;

    display:flex;

    justify-content:flex-end;

}



.btn-save{

    background:#334155;

    color:white;

    border:none;

    padding:11px 24px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

}



.btn-save:hover{

    background:#1e293b;

}








/* ===============================
RESPONSIVE
================================ */

@media(max-width:900px){


.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.form-grid{

    grid-template-columns:1fr;

}



.form-action{

    justify-content:stretch;

}



.btn-save{

    width:100%;

}


}

</style>

@endsection