@extends('layouts.dashboard')

@section('content')

<style>

/* ==========================
PROFILE CONTAINER
========================== */

.profile-page{

    width:100%;
    max-width:1200px;
    margin:0 auto;
    padding:0 0 40px;

}


.profile-page *,
.profile-page *::before,
.profile-page *::after{

    box-sizing:border-box;

}



/* ==========================
HEADER
========================== */


.user-profile-header{

    background:#ffffff;

    border:1px solid #e2e8f0;

    border-radius:22px;

    padding:24px 28px;

    margin-bottom:20px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.user-profile-header-content{

    display:flex;

    align-items:center;

    gap:16px;

}



.user-profile-avatar{

    width:56px;
    height:56px;

    border-radius:50%;

    background:#334155;

    color:white;

    font-size:22px;

    font-weight:700;

    background:#f1f5f9;

    color:#334155;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

}



.user-profile-title h1{

    margin:0;

    font-size:24px;

    font-weight:800;

    color:#0f172a;

}



.user-profile-title p{

    margin:5px 0 0;

    font-size:13px;

    color:#64748b;

}



.user-profile-email{

    margin-top:8px;

    display:flex;

    align-items:center;

    gap:7px;

    color:#94a3b8;

    font-size:12px;

}





/* ==========================
GRID
========================== */


.profile-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:14px;
}


.profile-card{

    background:#ffffff;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:22px;

    box-shadow:

    0 5px 18px rgba(15,23,42,.04);

}
.profile-card{
    padding:20px;
    min-height:auto;
}

.profile-card.full{

    grid-column:1/-1;

}


.profile-form form > div{
    margin-bottom:10px!important;
}
/* ==========================
CARD HEADER
========================== */


.profile-card-header{

    display:flex;

    align-items:center;

    gap:12px;

    padding-bottom:16px;

    margin-bottom:18px;

    border-bottom:1px solid #eef2f7;

}



.profile-icon{

    width:42px;

    height:42px;

    border-radius:12px;

    background:#f1f5f9;

    color:#334155;

    display:flex;

    align-items:center;

    justify-content:center;

}



.profile-card-title{

    margin:0;

    font-size:16px;

    font-weight:800;

    color:#111827;

}



.profile-card-description{

    margin:4px 0 0;

    font-size:12px;

    color:#64748b;

}





/* ==========================
FORM
========================== */


.profile-form{

    width:100%;

}



.profile-form section{

    width:100%;

}



.profile-form section > header{

    display:none;

}



.profile-form form{

    margin-top:0!important;

}



.profile-form label{

    display:block;

    margin-bottom:6px;

    font-size:12px!important;

    font-weight:700!important;

    color:#374151!important;

}



.profile-form input[type=text],
.profile-form input[type=email],
.profile-form input[type=password]{


    width:100%!important;

    height:42px;

    border-radius:10px!important;

    border:1px solid #cbd5e1!important;

    padding:0 12px!important;

    font-size:13px!important;

    background:#fff!important;

}



.profile-form input:focus{

    border-color:#64748b!important;

    box-shadow:
    0 0 0 3px rgba(100,116,139,.12)!important;

}





/* ==========================
BUTTON
========================== */


.profile-form button[type=submit]{


    height:38px;

    padding:0 18px!important;

    border-radius:9px!important;

    background:#334155!important;

    color:white!important;

    font-size:12px!important;

    font-weight:700!important;

    border:none!important;

}



.profile-form button[type=submit]:hover{

    background:#1e293b!important;

}





/* ==========================
SECURITY
========================== */


.security-card .profile-icon{

    background:#eff6ff;

    color:#2563eb;

}





/* ==========================
DELETE
========================== */


.delete-card{

    border-color:#fecaca;

}



.delete-card .profile-icon{

    background:#fef2f2;

    color:#dc2626;

}



.delete-card .profile-card-title{

    color:#991b1b;

}



.delete-card button[type=submit]{


    background:#dc2626!important;

}



.delete-card button[type=submit]:hover{


    background:#b91c1c!important;

}



/* ==========================
INFO
========================== */

.profile-security-info{

    margin-top:18px;

    padding:13px 15px;

    border-radius:14px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    color:#64748b;

    font-size:12px;

    display:flex;

    gap:10px;

    align-items:center;

}

/* ==========================
RESPONSIVE
========================== */


@media(max-width:900px){


.profile-grid{

    grid-template-columns:1fr;

}


}



@media(max-width:600px){


.profile-page{

    padding:0 10px 30px;

}


.user-profile-header{

    padding:20px;

}


.user-profile-title h1{

    font-size:20px;

}


.profile-card{

    padding:18px;

}


.profile-grid{

    gap:15px;

}



}

</style>





<div class="profile-page">



{{-- ==========================
HEADER PROFILE
========================== --}}

<div class="user-profile-header">

<div class="user-profile-header-content">
<div class="user-profile-avatar">
    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
</div>

<div class="user-profile-title">

<h1>
Profil Pengguna
</h1>

<p>
Kelola informasi akun dan keamanan pengguna.
</p>


<div class="user-profile-email">

<i class="fas fa-envelope"></i>

{{ auth()->user()->email }}

</div>

</div>

</div>

</div>


<div class="profile-grid">





{{-- ==========================
INFORMASI PROFIL
========================== --}}


<div class="profile-card">


<div class="profile-card-header">


<div class="profile-icon">

<i class="fas fa-user-edit"></i>

</div>



<div>


<h2 class="profile-card-title">

Informasi Profil

</h2>



<p class="profile-card-description">

Perbarui nama dan alamat email akun Anda.

</p>


</div>


</div>





<div class="profile-form">


@include('profile.partials.update-profile-information-form')


</div>


</div>








{{-- ==========================
PASSWORD
========================== --}}


<div class="profile-card security-card">


<div class="profile-card-header">


<div class="profile-icon">

<i class="fas fa-shield-alt"></i>

</div>



<div>


<h2 class="profile-card-title">

Keamanan Password

</h2>



<p class="profile-card-description">

Perbarui password secara berkala untuk menjaga keamanan akun.

</p>


</div>


</div>





<div class="profile-form">


@include('profile.partials.update-password-form')


</div>


</div>









{{-- ==========================
DELETE ACCOUNT
========================== --}}


<div class="profile-card full delete-card">


<div class="profile-card-header">


<div class="profile-icon">

<i class="fas fa-user-times"></i>

</div>



<div>


<h2 class="profile-card-title">

Hapus Akun

</h2>



<p class="profile-card-description">

Tindakan ini bersifat permanen dan tidak dapat dibatalkan.

</p>


</div>


</div>





<div class="profile-form">


@include('profile.partials.delete-user-form')


</div>


</div>






</div>




<div class="profile-security-info">

<i class="fas fa-info-circle"></i>

<span>
Pastikan informasi akun dan password selalu diperbarui untuk menjaga keamanan akses sistem.
</span>

</div>





</div>


@endsection