@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">

<div>

<div class="welcome-label">
PENGAJUAN DANA
</div>


<h1>
Ajukan Dana Project
</h1>


<p>
Isi form kebutuhan dana project untuk diproses oleh bagian keuangan.
</p>


</div>

</div>







@if($errors->any())

<div class="error-box">

<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif







<div class="glass-panel">


<div class="panel-title">

💰 Form Pengajuan Dana

</div>





<form method="POST"

action="{{route('expense.store')}}"

enctype="multipart/form-data">


@csrf





<div class="form-grid">





{{-- PROJECT --}}

<div>


<label>
Project
</label>


<select 

name="proyek_id"

id="proyek_id"

required>


<option value="">
-- Pilih Project --
</option>



@foreach($projects as $project)


<option

value="{{$project->id}}"

data-perusahaan="{{$project->perusahaan->nama_perusahaan ?? '-'}}"

data-budget="{{$project->total_anggaran}}"

data-sisa="{{$project->sisa_budget}}"

>


{{$project->nama_proyek}}


</option>


@endforeach


</select>


</div>









{{-- DIVISI --}}


<div>


<label>
Divisi
</label>



<select

name="divisi_id"

required>


<option value="">
-- Pilih Divisi --
</option>



@foreach($divisions as $division)


<option value="{{$division->id}}">

{{$division->nama_divisi}}

</option>


@endforeach



</select>


</div>








{{-- JUMLAH --}}


<div>


<label>
Jumlah Dana
</label>


<input

type="number"

id="jumlah"

name="jumlah"

value="{{old('jumlah')}}"

placeholder="Contoh: 1000000"

min="1000"

required>


<div id="budget-warning"></div>


</div>





</div>









{{-- INFO PROJECT --}}


<div id="project-info" class="project-info">


<div>

<label>
Perusahaan
</label>


<strong id="company-name">
-
</strong>


</div>





<div>

<label>
Total Budget Project
</label>


<strong id="project-budget">
-
</strong>


</div>





<div>

<label>
Sisa Budget
</label>


<strong id="project-balance">
-
</strong>


</div>



</div>









<div class="full-field">


<label>
Judul Pengeluaran
</label>



<input

type="text"

name="judul"

value="{{old('judul')}}"

placeholder="Contoh: Pembelian alat kerja"

required>


</div>









<div class="full-field">


<label>
Keterangan
</label>



<textarea

name="keterangan"

placeholder="Jelaskan kebutuhan dana">{{old('keterangan')}}</textarea>



</div>









{{-- UPLOAD --}}


<div class="upload-section">


<label>
Bukti Pengajuan
</label>



<div class="upload-box">


<input

type="file"

name="bukti_pengajuan"

id="bukti_pengajuan"

accept=".jpg,.jpeg,.png,.webp,.pdf"

required>



<label

for="bukti_pengajuan"

class="upload-button">


📎 Pilih File


</label>



<span id="file-name">

Belum ada file dipilih

</span>



</div>





<small class="upload-info">

Format JPG, PNG, WEBP, PDF maksimal 2MB.

</small>





<div id="file-message"
class="file-message">
</div>





<div id="preview-container"
class="preview-card">


<div class="preview-title">

Preview Bukti Pengajuan

</div>


<img

id="image-preview"

class="preview-image">


</div>




</div>








<div class="approval-info">


<p>

ℹ Pengajuan dana akan diperiksa finance sebelum dilakukan pencairan.

</p>


</div>








<button

type="submit"

class="btn-submit">


+ Kirim Pengajuan


</button>







</form>


</div>


<style>

/* =================================
GLOBAL
================================= */

*{
    box-sizing:border-box;
}


/* =================================
HEADER OWNER STYLE
================================= */


.welcome-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    font-weight:800;

    letter-spacing:2px;

    color:#64748b;

}



.welcome-card h1{

    margin:8px 0;

    font-size:24px;

    font-weight:800;

    color:#1e293b;

}



.welcome-card p{

    margin:0;

    font-size:12px;

    color:#64748b;

}





/* =================================
ERROR
================================= */


.error-box{

    background:#fee2e2;

    border:1px solid #fecaca;

    padding:15px;

    border-radius:18px;

    margin-bottom:20px;

    color:#991b1b;

    font-size:12px;

}





/* =================================
MAIN PANEL
================================= */


.glass-panel{

    background:white;

    padding:25px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.panel-title{

    font-size:16px;

    font-weight:800;

    color:#1e293b;

    margin-bottom:20px;

    padding-left:10px;

    border-left:4px solid #334155;

}





/* =================================
FORM
================================= */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}



label{

    display:block;

    margin-bottom:7px;

    font-size:11px;

    font-weight:700;

    color:#64748b;

}



input,
select,
textarea{


    width:100%;

    height:42px;

    padding:10px 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:12px;

    color:#334155;

}



textarea{

    height:110px;

}



input:focus,
select:focus,
textarea:focus{

    outline:none;

    border-color:#334155;

    background:white;

}





/* FULL FIELD */


.full-field{

    margin-top:20px;

}







/* =================================
PROJECT INFO
================================= */


.project-info{


    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:15px;

    margin-top:20px;

    padding:18px;

    border-radius:20px;

    background:#f8fafc;

    border:1px solid #e2e8f0;


}



.project-info div{

    background:white;

    padding:15px;

    border-radius:15px;

    border:1px solid #e2e8f0;

}



.project-info label{

    font-size:10px;

    color:#94a3b8;

}



.project-info strong{

    display:block;

    margin-top:5px;

    font-size:13px;

    color:#1e293b;

}





/* =================================
BUDGET STATUS
================================= */


.warning{

    margin-top:8px;

    color:#dc2626;

    font-size:11px;

    font-weight:700;

}



.safe{

    margin-top:8px;

    color:#16a34a;

    font-size:11px;

    font-weight:700;

}





/* =================================
UPLOAD
================================= */


.upload-section{

    margin-top:20px;

}



.upload-box{

    display:flex;

    align-items:center;

    gap:15px;

    background:#f8fafc;

    border:2px dashed #cbd5e1;

    padding:18px;

    border-radius:18px;

}



.upload-box input{

    display:none;

}



.upload-button{

    background:#334155;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    font-size:11px;

    font-weight:700;

    cursor:pointer;

}



#file-name{

    font-size:11px;

    color:#64748b;

}



.upload-info{

    font-size:10px;

    color:#94a3b8;

}





/* =================================
PREVIEW
================================= */


.preview-card{

    display:none;

    margin-top:15px;

    padding:15px;

    background:#f8fafc;

    border-radius:18px;

}



.preview-title{

    font-size:12px;

    font-weight:800;

    margin-bottom:10px;

}



.preview-image{

    width:220px;

    height:220px;

    object-fit:contain;

    background:white;

    border-radius:15px;

}







/* =================================
APPROVAL INFO
================================= */


.approval-info{

    margin-top:20px;

    padding:15px;

    background:#f8fafc;

    border-left:4px solid #334155;

    border-radius:12px;

    font-size:12px;

    color:#64748b;

}





/* =================================
BUTTON OWNER STYLE
================================= */


.btn-submit{


    margin-top:20px;

    background:#334155;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:12px;

    font-weight:800;

    cursor:pointer;

    transition:.2s;


}



.btn-submit:hover{

    background:#1e293b;

}





/* =================================
RESPONSIVE
================================= */


@media(max-width:1000px){


.form-grid,
.project-info{

    grid-template-columns:1fr;

}


.upload-box{

    flex-direction:column;

    align-items:flex-start;

}


}

</style>





<script>


/*
|--------------------------------------------------------------------------
| PROJECT BUDGET INFO
|--------------------------------------------------------------------------
*/


const projectSelect = 
document.getElementById('proyek_id');


const companyName =
document.getElementById('company-name');


const projectBudget =
document.getElementById('project-budget');


const projectBalance =
document.getElementById('project-balance');


const jumlahInput =
document.getElementById('jumlah');


const warning =
document.getElementById('budget-warning');




let maxBudget = 0;





projectSelect.addEventListener(
'change',
function(){


let option =
this.options[this.selectedIndex];



if(!option.value)
{

companyName.innerHTML='-';

projectBudget.innerHTML='-';

projectBalance.innerHTML='-';

maxBudget=0;

return;

}





companyName.innerHTML =
option.dataset.perusahaan;



projectBudget.innerHTML =
'Rp '+
Number(option.dataset.budget)
.toLocaleString('id-ID');



projectBalance.innerHTML =
'Rp '+
Number(option.dataset.sisa)
.toLocaleString('id-ID');



maxBudget =
Number(option.dataset.sisa);



});








jumlahInput.addEventListener(
'input',
function(){


let jumlah =
Number(this.value);



if(jumlah > maxBudget && maxBudget > 0)
{


warning.className="warning";


warning.innerHTML=

'⚠ Jumlah melebihi sisa budget project';



}

else if(jumlah > 0)
{


warning.className="safe";


warning.innerHTML=

'✓ Dana masih dalam batas budget';



}

else

{

warning.innerHTML='';

}



});








/*
|--------------------------------------------------------------------------
| UPLOAD PREVIEW
|--------------------------------------------------------------------------
*/


const fileInput =
document.getElementById('bukti_pengajuan');


const fileName =
document.getElementById('file-name');


const message =
document.getElementById('file-message');


const preview =
document.getElementById('preview-container');


const image =
document.getElementById('image-preview');





fileInput.addEventListener(
'change',
function(){


let file=this.files[0];



if(!file)
{

fileName.innerHTML=
'Belum ada file dipilih';

preview.style.display='none';

return;

}





let size =
file.size / 1024 / 1024;



if(size > 2)
{


message.className="warning";

message.innerHTML=
'⚠ File maksimal 2MB';


this.value='';

return;

}





fileName.innerHTML=file.name;


message.className="safe";


message.innerHTML=
'✓ File valid';





if(file.type.startsWith('image/'))
{


let reader =
new FileReader();



reader.onload=function(e){

image.src=e.target.result;

preview.style.display='block';

};



reader.readAsDataURL(file);



}

else

{

preview.style.display='none';

}



});



</script>


@endsection

