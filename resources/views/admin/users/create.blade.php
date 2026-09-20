@extends('layouts.dashboard')


@section('content')


<div class="page-header-card">


<div>

<div class="page-label">
ADMINISTRASI
</div>


<h1>
Tambah User
</h1>


<p>
Buat akun pengguna baru dan atur hak akses sistem.
</p>


</div>



<a href="{{route('admin.users.index')}}" class="btn-back">

← Kembali

</a>


</div>





@if($errors->any())


<div class="alert-error">


<strong>
Terjadi kesalahan:
</strong>


<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>


</div>


@endif







<div class="glass-panel form-card">


<div class="panel-title">

👤 Informasi Pengguna

</div>





<form method="POST"

action="{{route('admin.users.store')}}">


@csrf





<div class="form-grid">






<div class="form-group">

<label>
Nama Lengkap
</label>


<input

type="text"

name="name"

value="{{old('name')}}"

placeholder="Masukkan nama pengguna"

required>

</div>







<div class="form-group">

<label>
Email
</label>


<input

type="email"

name="email"

value="{{old('email')}}"

placeholder="nama@email.com"

required>

</div>








<div class="form-group">

<label>
Role Pengguna
</label>

<select name="role" id="role">

<option value="">
-- Pilih Role --
</option>


<option value="owner"
{{old('role')=='owner'?'selected':''}}>
Owner
</option>


<option value="admin"
{{old('role')=='admin'?'selected':''}}>
Admin
</option>


<option value="keuangan"
{{old('role')=='keuangan'?'selected':''}}>
Keuangan
</option>


<option value="karyawan"
{{old('role')=='karyawan'?'selected':''}}>
Karyawan
</option>


</select>


</div>








<div class="form-group employee-field">


<label>
Nama Karyawan
</label>


<input

type="text"

name="nama_karyawan"

value="{{old('nama_karyawan')}}"

placeholder="Masukkan nama karyawan">


</div>








<div class="form-group employee-field">


<label>
Divisi
</label>


<select name="divisi_id" id="divisi_id">

<option value="">
-- Pilih Divisi --
</option>



@foreach($divisi as $item)


<option value="{{$item->id}}"

{{old('divisi_id')==$item->id?'selected':''}}

>

{{$item->nama_divisi}}

</option>


@endforeach



</select>


</div>







<div class="form-group">

    <label for="password">
        Password
    </label>

    <div class="password-input-wrapper">

        <input
            id="password"
            type="password"
            name="password"
            placeholder="Masukkan password"
            autocomplete="new-password"
            required>

<button
    type="button"
    class="password-toggle"
    data-target="password"
    aria-label="Tampilkan password"
    aria-pressed="false">

    <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
        <circle cx="12" cy="12" r="3"></circle>
    </svg>

    <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 3l18 18"></path>
        <path d="M10.6 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 3.9"></path>
        <path d="M6.6 6.6C3.6 8.4 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.2-.8"></path>
    </svg>

</button>
    </div>

</div>


<div class="form-group">

    <label for="password_confirmation">
        Konfirmasi Password
    </label>

    <div class="password-input-wrapper">

        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Ulangi password"
            autocomplete="new-password"
            required>
<button
    type="button"
    class="password-toggle"
    data-target="password_confirmation"
    aria-label="Tampilkan konfirmasi password"
    aria-pressed="false">

    <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
        <circle cx="12" cy="12" r="3"></circle>
    </svg>

    <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 3l18 18"></path>
        <path d="M10.6 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 3.9"></path>
        <path d="M6.6 6.6C3.6 8.4 2 12 2 12s3.5 7 10 7a10.8 10.8 0 0 0 4.2-.8"></path>
    </svg>

</button>

    </div>

</div>





</div>







<div class="form-action">


<button class="btn-save">

💾 Simpan User

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
HEADER OWNER STYLE
================================ */


.page-header-card{

    background:#f8fafc;

    padding:25px 30px;

    border-radius:24px;

    border:1px solid #e2e8f0;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

    display:flex;

    justify-content:space-between;

    align-items:center;

}



.page-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.page-header-card h1{

    margin:8px 0;

    font-size:28px;

    font-weight:800;

    color:#1e293b;

}



.page-header-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

}







/* ===============================
BACK BUTTON
================================ */


.btn-back{

    display:flex;

    align-items:center;

    justify-content:center;

    background:white;

    color:#334155;

    border:1px solid #e2e8f0;

    padding:10px 20px;

    border-radius:12px;

    font-size:12px;

    font-weight:700;

    text-decoration:none;

    transition:.2s;

}



.btn-back:hover{

    background:#334155;

    color:white;

    border-color:#334155;

}







/* ===============================
ERROR
================================ */


.alert-error{

    background:#fee2e2;

    border:1px solid #fecaca;

    color:#991b1b;

    padding:15px;

    border-radius:16px;

    margin-bottom:20px;

    font-size:13px;

}



.alert-error strong{

    display:block;

    margin-bottom:8px;

}



.alert-error ul{

    margin:0;

    padding-left:20px;

}







/* ===============================
MAIN PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:25px;

    box-shadow:

    0 5px 20px rgba(15,23,42,.05);

}



.form-card{

    width:100%;

}





.panel-title{

    display:flex;

    align-items:center;

    gap:10px;

    font-size:17px;

    font-weight:800;

    color:#1e293b;

    padding-left:10px;

    border-left:4px solid #334155;

    margin-bottom:25px;

}







/* ===============================
FORM GRID
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}



.form-group{

    display:flex;

    flex-direction:column;

}





.form-group label{

    font-size:11px;

    font-weight:700;

    color:#64748b;

    margin-bottom:7px;

}







.form-group input,
.form-group select{


    height:44px;

    padding:0 14px;

    border-radius:12px;

    border:1px solid #e2e8f0;

    background:#f8fafc;

    font-size:13px;

    color:#334155;

    transition:.2s;

}





.form-group input::placeholder{

    color:#94a3b8;

}






.form-group input:focus,
.form-group select:focus{


    outline:none;

    background:white;

    border-color:#334155;

    box-shadow:

    0 0 0 3px rgba(51,65,85,.08);

}








/* ===============================
EMPLOYEE FIELD
================================ */


.employee-field.hidden{

    display:none!important;

}







/* ===============================
PASSWORD STYLE
================================ */


input[type=password]{

    letter-spacing:1px;

}







/* ===============================
ACTION BUTTON
================================ */


.form-action{

    margin-top:30px;

    display:flex;

    justify-content:flex-end;

}





.btn-save{


    display:flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    background:#334155;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:12px;

    font-size:13px;

    font-weight:700;

    cursor:pointer;

    transition:.2s;

}



.btn-save:hover{

    background:#1e293b;

}







/* ===============================
DISABLED
================================ */


input:disabled,
select:disabled{

    background:#f1f5f9;

    cursor:not-allowed;

}








/* ===============================
RESPONSIVE
================================ */


@media(max-width:1000px){


.form-grid{

    grid-template-columns:1fr;

}


}





@media(max-width:700px){



.page-header-card{

    flex-direction:column;

    align-items:flex-start;

    gap:15px;

}



.btn-back{

    width:100%;

}



.form-action{

    justify-content:stretch;

}



.btn-save{

    width:100%;

}



.glass-panel{

    padding:20px;

}


}
@media(max-width:900px){

    .page-header-card{
        flex-direction:column;
        align-items:stretch;
        gap:15px;
        padding:20px;
    }

    .page-header-card h1{
        font-size:22px;
    }

    .page-header-card p{
        font-size:11px;
        line-height:1.5;
    }

    .btn-back{
        width:100%;
        min-height:42px;
    }

    .form-grid{
        grid-template-columns:1fr;
        gap:16px;
    }

    .glass-panel{
        padding:20px;
        border-radius:18px;
    }

    .panel-title{
        font-size:15px;
        margin-bottom:20px;
    }

    .form-action{
        justify-content:stretch;
    }

    .btn-save{
        width:100%;
        min-height:42px;
    }

    .alert-error{
        font-size:11px;
        line-height:1.5;
    }

}


@media(max-width:600px){

    .page-header-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .page-label{
        font-size:9px;
    }

    .page-header-card h1{
        font-size:19px;
    }

    .page-header-card p{
        font-size:10px;
        line-height:1.5;
    }

    .btn-back{
        width:100%;
        height:42px;
        font-size:12px;
    }

    .glass-panel{
        padding:15px;
        border-radius:18px;
    }

    .panel-title{
        font-size:14px;
        margin-bottom:18px;
    }

    .form-grid{
        gap:15px;
    }

    .form-group{
        gap:6px;
    }

    .form-group label{
        font-size:10px;
        margin-bottom:0;
    }

    .form-group input,
    .form-group select{
        height:42px;
        padding:0 12px;
        font-size:12px;
        width:100%;
    }

    .form-action{
        margin-top:20px;
    }

    .btn-save{
        width:100%;
        height:42px;
        padding:0 18px;
        font-size:12px;
    }

    .alert-error{
        padding:12px 14px;
        font-size:10px;
        line-height:1.5;
    }

    .alert-error ul{
        padding-left:17px;
    }

}

/* ===============================
PASSWORD TOGGLE
================================ */

.password-input-wrapper {
    position: relative;
    width: 100%;
}

.password-input-wrapper input {
    width: 100%;
    padding-right: 45px !important;
}

.password-input-wrapper {
    position: relative;
    width: 100%;
}

.password-input-wrapper input {
    width: 100%;
    padding-right: 45px !important;
}

.password-toggle {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
    background: transparent;
    border: none;
    color: #64748b;
    cursor: pointer;
    z-index: 10;
}

.password-toggle:hover {
    color: #334155;
}

.password-toggle:focus {
    outline: none;
}

.password-toggle svg {
    width: 17px;
    height: 17px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.password-toggle .eye-closed {
    display: none;
}

.password-toggle.active .eye-open {
    display: none;
}

.password-toggle.active .eye-closed {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.password-toggle').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);

            if (!input) {
                return;
            }

            if (input.type === 'password') {

                input.type = 'text';

                this.classList.add('active');
                this.setAttribute('aria-label', 'Sembunyikan password');
                this.setAttribute('aria-pressed', 'true');

            } else {

                input.type = 'password';

                this.classList.remove('active');
                this.setAttribute('aria-label', 'Tampilkan password');
                this.setAttribute('aria-pressed', 'false');

            }

        });

    });

});
</script>
@endsection