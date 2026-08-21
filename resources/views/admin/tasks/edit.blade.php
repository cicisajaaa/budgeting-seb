@extends('layouts.dashboard')

@section('content')


<div class="page-header-card">

    <div>

        <div class="page-label">
            TASK MANAGEMENT
        </div>

        <h1>
            Edit Task
        </h1>

        <p>
            Perbarui informasi pekerjaan dan progres tugas.
        </p>

    </div>


    <a href="{{route('admin.tasks.show',$task->id)}}" class="btn-back">
        ← Kembali
    </a>


</div>





@if($errors->any())

<div class="alert-error">

<ul>

@foreach($errors->all() as $error)

<li>{{$error}}</li>

@endforeach

</ul>

</div>

@endif






<div class="glass-panel">


<div class="panel-title">
📝 Informasi Task
</div>



<form method="POST"
action="{{route('admin.tasks.update',$task->id)}}">


@csrf
@method('PUT')



<div class="form-grid">



<div class="form-group">

<label>
Nama Task
</label>

<input
type="text"
name="nama_tugas"
value="{{old('nama_tugas',$task->nama_tugas)}}"
required>

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

<option value="{{$item->id}}"

{{old('divisi_id',$task->divisi_id)==$item->id?'selected':''}}

>

{{$item->nama_divisi}}

</option>

@endforeach


</select>


</div>







<div class="form-group">

<label>
Karyawan
</label>


<select name="karyawan_id">

<option value="">
-- Pilih Karyawan --
</option>


@foreach($karyawan as $item)

<option value="{{$item->id}}"

{{old('karyawan_id',$task->karyawan_id)==$item->id?'selected':''}}

>

{{$item->nama_karyawan}}

</option>


@endforeach


</select>


</div>







<div class="form-group">

<label>
Tanggal
</label>


<input
type="date"
name="tanggal"

value="{{old('tanggal',$task->tanggal ? $task->tanggal->format('Y-m-d') : '')}}"

required>

</div>







<div class="form-group">

<label>
Deadline
</label>


<input
type="date"
name="deadline"

value="{{old('deadline',$task->deadline ? $task->deadline->format('Y-m-d') : '')}}"

>

</div>







<div class="form-group">

<label>
Prioritas
</label>


<select name="prioritas">


<option value="Low"
{{old('prioritas',$task->prioritas)=='Low'?'selected':''}}>
Low
</option>


<option value="Medium"
{{old('prioritas',$task->prioritas)=='Medium'?'selected':''}}>
Medium
</option>


<option value="High"
{{old('prioritas',$task->prioritas)=='High'?'selected':''}}>
High
</option>


</select>


</div>







<div class="form-group">

<label>
Status
</label>

<select name="status">

<option value="belum_dikerjakan"
{{$task->status=='belum_dikerjakan'?'selected':''}}>
Belum Dikerjakan
</option>


<option value="sedang_dikerjakan"
{{$task->status=='sedang_dikerjakan'?'selected':''}}>
Sedang Dikerjakan
</option>


<option value="selesai"
{{$task->status=='selesai'?'selected':''}}>
Selesai
</option>


</select>
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

value="{{old('progres_persen',$task->progres_persen)}}"

required>


</div>


</div>








<div class="form-group">

<label>
Aktivitas
</label>


<textarea

name="aktivitas"

rows="5"

required>{{old('aktivitas',$task->aktivitas)}}</textarea>


</div>








<div class="form-group">

<label>
Catatan
</label>


<textarea

name="catatan"

rows="4">{{old('catatan',$task->catatan)}}</textarea>


</div>








<div class="form-action">


<button class="btn-save">

💾 Update Task

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

    border-radius:20px;

    padding:22px 28px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    box-shadow:
    0 5px 18px rgba(15,23,42,.05);

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
BUTTON BACK
================================ */


.btn-back{

    background:white;

    border:1px solid #e2e8f0;

    padding:8px 16px;

    border-radius:11px;

    text-decoration:none;

    color:#334155;

    font-size:11px;

    font-weight:700;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

}








/* ===============================
ERROR
================================ */


.alert-error{

    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:12px 15px;

    border-radius:14px;

    margin-bottom:18px;

    font-size:11px;

}







/* ===============================
MAIN CARD
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:20px;

    padding:20px;

    box-shadow:

    0 6px 20px rgba(15,23,42,.04);

}






.panel-title{

    font-size:15px;

    font-weight:800;

    color:#172033;

    margin-bottom:18px;

    padding-left:10px;

    border-left:4px solid #334155;

}









/* ===============================
FORM GRID
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:14px;

}






.form-group{

    display:flex;

    flex-direction:column;

    gap:6px;

    margin-bottom:12px;

}




.form-group label{

    font-size:10px;

    font-weight:800;

    color:#64748b;

}







.form-group input,
.form-group select,
.form-group textarea{

    width:100%;

    border-radius:11px;

    border:1px solid #dbe1e8;

    background:#f8fafc;

    padding:9px 12px;

    font-size:11px;

    color:#172033;

}






.form-group input,
.form-group select{

    height:38px;

}





.form-group textarea{

    min-height:80px;

    resize:none;

}





.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{

    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.08);

}







/* textarea full */

.form-group:has(textarea){

    grid-column:1/-1;

}









/* ===============================
ACTION
================================ */


.form-action{

    margin-top:20px;

    padding-top:15px;

    border-top:1px solid #e5e7eb;

    display:flex;

    justify-content:flex-end;

}





.btn-save{

    background:#334155;

    color:white;

    border:none;

    padding:10px 22px;

    border-radius:11px;

    font-size:11px;

    font-weight:800;

    cursor:pointer;

    transition:.2s;

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