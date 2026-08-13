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
            Isi form berikut untuk mengajukan kebutuhan dana kepada keuangan.
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
action="{{ route('expense.store') }}"
enctype="multipart/form-data">

@csrf





<div class="form-grid">





<div>

<label>
Project
</label>



<select name="proyek_id" required>


<option value="">
-- Pilih Project --
</option>



@foreach($projects as $project)


<option value="{{ $project->id }}">

{{ $project->nama_proyek }}

</option>


@endforeach



</select>


</div>









<div>


<label>
Divisi
</label>



<select name="divisi_id" required>


<option value="">
-- Pilih Divisi --
</option>



@foreach($divisions as $division)


<option value="{{ $division->id }}">

{{ $division->nama_divisi }}

</option>


@endforeach



</select>


</div>








<div>


<label>
Jumlah Dana
</label>


<input 
type="number"
name="jumlah"
value="{{old('jumlah')}}"
placeholder="Contoh: 1000000"
min="1000"
required>


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
rows="5"
placeholder="Jelaskan kebutuhan dana">{{old('keterangan')}}</textarea>

</div>


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


<label for="bukti_pengajuan" class="upload-button">

📎 Pilih File

</label>


<span id="file-name">
Belum ada file dipilih
</span>


</div>


<small class="upload-info">

Format: JPG, PNG, WEBP, PDF. Maksimal 2MB.

</small>


<div id="file-message" class="file-message"></div>


<div id="preview-container" class="preview-card">

<div class="preview-title">
Preview Bukti Pengajuan
</div>


<img
id="image-preview"
class="preview-image"
>

</div>


</div>

<div class="approval-info">

<p>
ℹ Pengajuan dana akan diperiksa oleh bagian keuangan dan diteruskan kepada pemilik perusahaan untuk persetujuan.
</p>

</div>

<button type="submit" class="btn-submit">

+ Kirim Pengajuan

</button>





</form>


</div>








<style>

/* ===============================
GLOBAL
================================ */

.welcome-card{

    background:white;

    border:1px solid #e2e8f0;

    padding:32px;

    border-radius:24px;

    color:#172033;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:11px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    font-size:30px;

    margin:10px 0;

    color:#172033;

}



.welcome-card p{

    color:#64748b;

    font-size:14px;

}








/* ===============================
ALERT
================================ */


.success-box{

    background:#ecfdf5;

    border:1px solid #bbf7d0;

    color:#166534;

    padding:15px;

    border-radius:16px;

    margin-bottom:20px;

}



.error-box{

    background:#fef2f2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:15px;

    border-radius:16px;

    margin-bottom:20px;

}



.full-field{

    grid-column:1/-1;

}
/* ===============================
MAIN FORM CARD
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.05);

}





.panel-title{

    font-size:18px;

    font-weight:800;

    color:#172033;

    margin-bottom:25px;

}





/* ===============================
FORM
================================ */
.form-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:20px;

}

.form-grid input[type="number"]{

width:100%;

}


form > div:not(.form-grid){

margin-top:18px;

}
label{

    display:block;

    font-size:12px;

    font-weight:700;

    color:#475569;

    margin-bottom:8px;

}



input,
select,
textarea{

    width:100%;

    padding:13px 15px;

    border-radius:14px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:13px;

    transition:.2s;

}



input:focus,
select:focus,
textarea:focus{

    outline:none;

    border-color:#15803d;

    background:white;

    box-shadow:
    0 0 0 3px rgba(21,128,61,.1);

}

.full-field{

    grid-column:1/-1;

}

textarea{

    resize:none;

}





/* ===============================
UPLOAD
================================ */


.upload-section{

    margin-top:10px;

}


.upload-box{

    background:#f8fafc;

    border:2px dashed #94a3b8;

    padding:20px;

    border-radius:18px;

    display:flex;

    align-items:center;

    gap:15px;

    transition:.2s;

}


.upload-box:hover{

    border-color:#15803d;

    background:#f0fdf4;

}



.upload-box input{

    display:none;

}



.upload-button{

    background:#0f172a;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    cursor:pointer;

    font-size:12px;

    font-weight:700;

}



#file-name{

    color:#64748b;

    font-size:12px;

}





.upload-info{

    margin-top:8px;

    display:block;

    color:#94a3b8;

    font-size:11px;

}





.file-message{

    margin-top:10px;

    font-size:12px;

    font-weight:700;

}





/* ===============================
PREVIEW
================================ */


.preview-card{

    display:none;

    margin-top:20px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    padding:18px;

    border-radius:18px;

    width:360px;

}



.preview-title{

    font-size:13px;

    font-weight:800;

    color:#334155;

    margin-bottom:15px;

}



.preview-image{

    width:320px;

    height:360px;

    object-fit:contain;

    background:white;

    border-radius:15px;

    border:1px solid #e2e8f0;

}





/* ===============================
APPROVAL INFO
================================ */


.approval-info{

    margin-top:25px;

    background:#f8fafc;

    border-left:4px solid #15803d;

    padding:16px;

    border-radius:14px;

    color:#475569;

    font-size:13px;

}




/* ===============================
BUTTON
================================ */


.btn-submit{

    margin-top:20px;

    background:#0f172a;

    color:white;

    border:none;

    padding:14px 30px;

    border-radius:14px;

    font-weight:700;

    font-size:14px;

    cursor:pointer;

    transition:.2s;

}



.btn-submit:hover{

    background:#15803d;

    transform:translateY(-2px);

}





/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.form-grid{

    grid-template-columns:1fr;

}


.welcome-card{

    flex-direction:column;

    align-items:flex-start;

    gap:20px;

}



}

/* ===============================
FORM BALANCE FIX
================================ */


/* jumlah dana dibuat sejajar */

.form-grid > div:nth-child(3){

    width:100%;

}


/* field setelah grid */

.glass-panel form > div:not(.form-grid),
.glass-panel form > .upload-section,
.glass-panel form > .approval-info{

    margin-top:18px;

}




/* input lebih proporsional */

input,
select{

    height:46px;

}


textarea{

    min-height:120px;

    height:120px;

    resize:none;

}


/* jumlah dana jangan setengah */

.form-grid input[type="number"]{

    width:100%;

}


/* tombol */

.btn-submit{

    width:220px;

    height:48px;

}


</style>



<script>


const fileInput = document.getElementById('bukti_pengajuan');

const fileName = document.getElementById('file-name');

const message = document.getElementById('file-message');

const previewBox = document.getElementById('preview-container');

const previewImage = document.getElementById('image-preview');



fileInput.addEventListener('change', function(){


let file = this.files[0];



if(!file){

fileName.innerHTML="Belum ada file dipilih";

previewBox.style.display="none";

message.innerHTML="";

return;

}





let size = file.size / 1024 / 1024;




if(size > 2)

{

message.style.color="#dc2626";

message.innerHTML=
"⚠ File terlalu besar. Maksimal 2MB";


this.value="";

previewBox.style.display="none";

return;

}





let allowed = [

'image/jpeg',

'image/png',

'image/webp',

'application/pdf'

];




if(!allowed.includes(file.type))

{

message.style.color="#dc2626";

message.innerHTML=
"⚠ Format file tidak didukung";


this.value="";

previewBox.style.display="none";

return;

}





fileName.innerHTML=file.name;


message.style.color="#166534";


message.innerHTML=

"✓ File valid ("+

size.toFixed(2)

+" MB)";





if(file.type.startsWith('image/'))

{


let reader = new FileReader();



reader.onload=function(e){


previewImage.src=e.target.result;


previewBox.style.display="block";


}



reader.readAsDataURL(file);



}

else

{

previewBox.style.display="none";

}



});



</script>
@endsection