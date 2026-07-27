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



    <div class="system-status">

        <span></span>

        Employee

    </div>


</div>





@if(session('success'))

<div class="success-box">

    {{ session('success') }}

</div>

@endif






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
placeholder="Masukkan nominal"
required>


</div>




</div>









<div>


<label>
Judul Pengeluaran
</label>



<input 

type="text"

name="judul"

placeholder="Contoh: Pembelian alat kerja"

required>


</div>








<div>


<label>
Keterangan
</label>



<textarea

name="keterangan"

rows="4"

placeholder="Jelaskan kebutuhan dana"></textarea>


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

>



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

class="preview-image"

>



</div>



</div>




<button class="btn-submit">

+ Kirim Pengajuan

</button>





</form>


</div>









<style>


.welcome-card{

background:
linear-gradient(
135deg,
#166534,
#22c55e
);

padding:30px;

border-radius:24px;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:22px;

}



.welcome-label{

font-size:10px;

letter-spacing:2px;

font-weight:700;

opacity:.8;

}




.welcome-card h1{

font-size:28px;

margin:8px 0;

}




.welcome-card p{

font-size:13px;

opacity:.9;

}




.system-status{

background:white;

color:#166534;

padding:12px 18px;

border-radius:30px;

font-weight:700;

display:flex;

align-items:center;

gap:8px;

}




.system-status span{

width:9px;

height:9px;

background:#22c55e;

border-radius:50%;

}




.success-box{

background:#dcfce7;

color:#166534;

padding:15px;

border-radius:14px;

margin-bottom:20px;

font-weight:600;

}




.error-box{

background:#fee2e2;

color:#991b1b;

padding:15px;

border-radius:14px;

margin-bottom:20px;

}





.glass-panel{

background:
rgba(255,255,255,.65);

backdrop-filter:blur(15px);

border-radius:22px;

padding:22px;

border:1px solid rgba(255,255,255,.8);

}





.panel-title{

font-size:16px;

font-weight:700;

margin-bottom:20px;

}





.form-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

}





label{

display:block;

font-size:12px;

font-weight:600;

color:#475569;

margin-bottom:8px;

}




input,
select,
textarea{


width:100%;

padding:12px;

border-radius:12px;

border:1px solid #e2e8f0;

background:white;

margin-bottom:15px;

}



textarea{

resize:none;

}





.btn-submit{


margin-top:10px;

background:#166534;

color:white;

border:none;

padding:12px 25px;

border-radius:14px;

font-weight:600;

cursor:pointer;


}




.btn-submit:hover{

background:#22c55e;

}





@media(max-width:900px){


.form-grid{

grid-template-columns:1fr;

}



.welcome-card{

flex-direction:column;

align-items:flex-start;

gap:15px;

}


}


#file-info{

padding:8px 0;

}


#preview-container{

animation:fade .3s ease;

}



@keyframes fade{

from{

opacity:0;

transform:translateY(5px);

}


to{

opacity:1;

transform:translateY(0);

}

}



.upload-section{

margin-top:15px;

}



.upload-box{

display:flex;

align-items:center;

gap:12px;

background:white;

border:1px solid #e2e8f0;

padding:10px;

border-radius:12px;

}



.upload-box input[type="file"]{

display:none;

}



.upload-button{

background:#166534;

color:white;

padding:8px 15px;

border-radius:10px;

font-size:12px;

font-weight:700;

cursor:pointer;

}



#file-name{

font-size:12px;

color:#64748b;

}




.upload-info{

display:block;

margin-top:8px;

color:#64748b;

font-size:11px;

}




.file-message{

margin-top:10px;

font-size:12px;

font-weight:700;

}





.preview-card{

display:none;

margin-top:15px;

background:#f8fafc;

padding:15px;

border-radius:18px;

width:340px;

border:1px solid #e2e8f0;

}





.preview-title{

font-size:12px;

font-weight:700;

color:#475569;

margin-bottom:12px;

}




.preview-image{

width:300px;

height:380px;

object-fit:contain;

background:white;

padding:10px;

border-radius:15px;

border:1px solid #e2e8f0;

box-shadow:0 5px 15px rgba(0,0,0,.08);

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