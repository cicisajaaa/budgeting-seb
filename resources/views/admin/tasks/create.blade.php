@extends('layouts.dashboard')


@section('content')


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
            {{ $project->nama_proyek }}
        </p>

    </div>


</div>





<div class="glass-panel">


<form method="POST"

action="{{ route(
'admin.tasks.store',
$project->id
) }}">


@csrf




<label>
Nama Tugas
</label>


<input 
type="text"
name="nama_tugas"
placeholder="Masukkan nama tugas"
required>







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








<label>
Tanggal Mulai
</label>


<input 
type="date"
name="tanggal"
required>








<label>
Aktivitas
</label>


<textarea
name="aktivitas"
rows="4"
placeholder="Deskripsi aktivitas tugas"
required></textarea>








<label>
Prioritas
</label>


<select name="prioritas">


<option value="Low">
Low
</option>


<option value="Medium">
Medium
</option>


<option value="High">
High
</option>


</select>








<label>
Deadline
</label>


<input
type="date"
name="deadline">







<label>
Status
</label>


<select name="status">


<option value="belum_dikerjakan">
Belum Dikerjakan
</option>


<option value="sedang_dikerjakan">
Sedang Dikerjakan
</option>


<option value="selesai">
Selesai
</option>


</select>








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







<button class="btn-save">

+ Simpan Tugas

</button>




</form>


</div>






<style>


.page-header-card{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:30px;

margin-bottom:25px;

box-shadow:0 10px 30px rgba(15,23,42,.06);

}


.page-label{

font-size:11px;

font-weight:800;

letter-spacing:2px;

color:#94a3b8;

}



h1{

color:#172033;

}



p{

color:#64748b;

}





.glass-panel{

background:white;

border:1px solid #e5e7eb;

border-radius:24px;

padding:30px;

box-shadow:0 10px 30px rgba(15,23,42,.05);

}




label{

display:block;

margin-top:15px;

margin-bottom:8px;

font-size:13px;

font-weight:700;

color:#334155;

}





input,
select,
textarea{


width:100%;

padding:12px 15px;

border-radius:12px;

border:1px solid #e2e8f0;

background:#f8fafc;

font-size:14px;


}





textarea{

resize:none;

}





.btn-save{


margin-top:25px;

background:#1e293b;

color:white;

border:none;

padding:14px 25px;

border-radius:14px;

font-weight:700;

cursor:pointer;


}


.btn-save:hover{

background:#334155;

}



</style>


@endsection