<!DOCTYPE html>
<html lang="id">

<head>
<link 
rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Sahabat Eksplorasi Banua | Financial Management System
</title>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<style>


:root{

--primary:#6b4f1d;

--gold:#a67c2e;

--gold-light:#d7b787;

--dark:#0f172a;

--white:#ffffff;

--soft:#f8f3e8;

}



*{

margin:0;

padding:0;

box-sizing:border-box;

}



body{

min-height:100vh;

font-family:'Inter',sans-serif;

overflow-x:hidden;

background:

linear-gradient(

90deg,

rgba(15,23,42,.94),

rgba(15,23,42,.75)

),

url('{{asset("images/company-bg.png")}}');


background-size:100% auto;
background-position:center center;


}





/* ================= NAVBAR ================= */

.navbar{

position:fixed;

top:0;
left:0;
right:0;

height:80px;

display:flex;
align-items:center;
justify-content:space-between;

padding:0 70px;

color:white;

z-index:999;


background:

rgba(15,23,42,.35);


backdrop-filter:blur(12px);


border-bottom:

1px solid rgba(255,255,255,.1);


}


.brand{

display:flex;

align-items:center;

gap:12px;

}


.brand img{

width:45px;

height:45px;

border-radius:50%;

object-fit:contain;

background:white;

padding:4px;

}


.brand-text{

font-size:15px;

font-weight:700;

line-height:1.3;

}



.brand-text span{


display:block;

font-size:11px;

color:#d7b787;


}





.nav-menu{


display:flex;

gap:35px;


}



.nav-menu a{


color:white;

text-decoration:none;

font-size:13px;


opacity:.8;


}



.nav-menu a:hover{


opacity:1;

color:#d7b787;


}









/* ================= HERO ================= */


.hero{

min-height:100vh;

display:flex;

align-items:center;

padding:130px 80px 80px;

color:white;

}



.hero-left{


width:55%;


}




.logo-box{

width:110px;
height:110px;

background:white;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

padding:8px;

box-shadow:

0 15px 35px rgba(0,0,0,.35);

margin-bottom:25px;

}


.logo-box img{

width:100%;

height:100%;

object-fit:contain;

border-radius:50%;

}








.company{


font-size:46px;


font-weight:800;


line-height:1.15;


letter-spacing:-1px;


}



.company span{


color:#d7b787;


}




.system{


margin-top:18px;


font-size:21px;


font-weight:600;


color:#f8f3e8;


}




.description{


margin-top:20px;


font-size:15px;


line-height:1.8;


color:#cbd5e1;


max-width:500px;


}






.btn-login{


margin-top:35px;


display:inline-block;



padding:18px 75px;

font-size:15px;


border-radius:50px;


background:

linear-gradient(

135deg,

#6b4f1d,

#a67c2e

);


color:white;


font-weight:700;


text-decoration:none;


cursor:pointer;


box-shadow:

0 20px 40px rgba(107,79,29,.4);


transition:.3s;


}



.btn-login:hover{


transform:translateY(-5px);


}





.status{


margin-top:25px;


display:flex;


align-items:center;


gap:10px;


font-size:13px;


}



.status-dot{


width:10px;

height:10px;


border-radius:50%;


background:#22c55e;


box-shadow:

0 0 15px #22c55e;


}








/* ================= FEATURE ================= */



.features{


display:flex;


gap:15px;


margin-top:35px;


}



.feature{

width:170px;

padding:22px;


background:

rgba(255,255,255,.12);


border-radius:18px;


border:

1px solid rgba(255,255,255,.2);


backdrop-filter:blur(12px);


}



.feature-icon{


font-size:25px;


}



.feature-title{


margin-top:10px;


font-size:12px;


font-weight:700;


}



.feature-text{


margin-top:5px;


font-size:11px;


color:#cbd5e1;


}





/* ================= RIGHT PANEL ================= */


.hero-right{


width:45%;


display:flex;


justify-content:center;


}



.dashboard-preview{


width:390px;


padding:25px;


border-radius:25px;


background:

rgba(255,255,255,.12);


border:

1px solid rgba(255,255,255,.25);


backdrop-filter:blur(15px);


box-shadow:

0 30px 80px rgba(0,0,0,.4);


}



.preview-title{


font-weight:700;

font-size:16px;


margin-bottom:20px;


}



.preview-card{


background:white;


color:#334155;


padding:18px;


border-radius:15px;


margin-bottom:12px;


}



.preview-label{


font-size:12px;


color:#64748b;


}



.preview-value{


font-size:25px;


font-weight:800;


color:#6b4f1d;


}
/* ================= LOGIN MODAL ================= */



.login-overlay{

position:fixed;
inset:0;

display:flex;
align-items:center;
justify-content:center;

background:
rgba(15,23,42,.70);

backdrop-filter:blur(12px);

opacity:0;

pointer-events:none;

transition:.4s;

z-index:1000;

}


.login-overlay.show{

opacity:1;

pointer-events:auto;

}



.login-box{

width:850px;

height:460px;

display:flex;

overflow:hidden;

background:white;

border-radius:28px;

box-shadow:
0 40px 100px rgba(0,0,0,.5);

animation:loginShow .5s ease;

}



@keyframes loginShow{

from{

opacity:0;

transform:translateY(30px) scale(.95);

}

to{

opacity:1;

transform:none;

}

}



/* LEFT IMAGE */

.login-left > div{

transform:translateY(-20px);

}


.login-left{

background:

linear-gradient(
rgba(15,23,42,.35),
rgba(15,23,42,.65)
),
url('{{asset("images/company-bg.png")}}');

background-size:cover;

background-position:center;

display:flex;

align-items:center;

justify-content:center;

color:white;

text-align:center;

padding:0 20px;

}



.login-logo{

width:120px;

height:120px;

background:white;

padding:10px;

border-radius:50%;

margin-bottom:18px;

}


.login-company{

font-size:21px;

font-weight:800;

padding:0 20px;

}


.login-left p{

margin-top:8px;

font-size:13px;

opacity:.8;

}




/* RIGHT FORM */

.login-right{

width:55%;

padding:45px 55px;

display:flex;

flex-direction:column;

justify-content:center;

}



.login-badge{

width:max-content;

padding:7px 15px;

border-radius:20px;

background:#f8f3e8;

color:#8b6b2e;

font-size:11px;

font-weight:700;

margin-bottom:18px;

}



.login-right h2{

font-size:32px;

font-weight:800;

color:#172033;

line-height:1.2;

white-space:nowrap;

margin-bottom:12px;

}
.login-header{
    margin-bottom:25px;
}


.login-title-small{

    display:inline-block;

    padding:6px 14px;

    border-radius:20px;

    background:#f8f3e8;

    color:#8b6b2e;

    font-size:11px;

    font-weight:700;

    letter-spacing:1px;

    margin-bottom:15px;

}



.login-right h2{

    font-size:34px;

    font-weight:800;

    color:#172033;

    line-height:1.2;

    margin-bottom:12px;

}



.login-desc{

    font-size:14px;

    color:#64748b;

    line-height:1.6;

}




.form-group{

margin-bottom:20px;

}



.form-group label{

display:block;

font-size:13px;

font-weight:700;

color:#334155;

margin-bottom:8px;

}




.form-group input{

width:100%;

height:52px;

border-radius:14px;

border:1px solid #d8dee8;

background:#f8fafc;

padding:0 18px;

font-size:14px;

transition:.3s;

}



.form-group input:focus{

outline:none;

background:white;

border-color:#a67c2e;

box-shadow:
0 0 0 4px rgba(166,124,46,.15);

}




.password-box{

position:relative;

}



.password-box input{

padding-right:50px;

}

.toggle-password{

position:absolute;

right:18px;

top:50%;

transform:translateY(-50%);

cursor:pointer;

font-size:16px;

color:#94a3b8;

transition:.3s;

}


.toggle-password:hover{

color:#a67c2e;

}nter;

font-size:18px;

}




.remember{

display:flex;

align-items:center;

gap:8px;

font-size:13px;

color:#64748b;

}



.remember input{

width:16px;

height:16px;

accent-color:#a67c2e;

}



.submit-btn{

height:50px;

border-radius:12px;

width:92%;

margin-left:auto;

margin-right:auto;

border:none;

margin-top:25px;

margin-bottom:10px;

background:

linear-gradient(
135deg,
#6b4f1d,
#a67c2e
);


color:white;

font-size:14px;

font-weight:700;

letter-spacing:.8px;

cursor:pointer;


box-shadow:

0 15px 35px rgba(166,124,46,.25);

transition:.3s;

}


.submit-btn:hover{

transform:translateY(-3px);

box-shadow:

0 20px 45px rgba(166,124,46,.4);

}



.close-login{

margin-top:25px;

display:flex;

justify-content:center;

align-items:center;

gap:10px;

font-size:13px;

font-weight:600;

color:#64748b;

cursor:pointer;

transition:.3s;

}


.close-login{

margin-top:15px;

padding-bottom:8px;

font-size:13px;

}


.close-login:hover{

color:#a67c2e;

}



.close-login i{

font-size:12px;


}


.close-login span{
    border-bottom:1px solid transparent;
}


.close-login:hover span{
    border-bottom:1px solid #a67c2e;
}

.footer{

margin-top:18px;

text-align:center;

font-size:12px;

color:#94a3b8;

}


/* ================= SYSTEM SECTION ================= */


.system-section{


padding:90px 70px;


background:#f8f3e8;


color:#1e293b;


min-height:500px;


}



.system-container{


max-width:1100px;


margin:auto;


text-align:center;


}



.system-container h2{


font-size:35px;


color:#6b4f1d;


}



.system-container p{


margin-top:15px;


color:#64748b;


}



.system-grid{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:25px;

margin-top:45px;

}


.system-card{


width:280px;


background:white;


padding:30px;


border-radius:20px;


box-shadow:

0 15px 40px rgba(0,0,0,.08);


text-align:left;


}


.system-icon{

width:42px;
height:42px;

border-radius:12px;

background:#f8f3e8;

display:flex;

align-items:center;

justify-content:center;

font-size:22px;

margin-bottom:15px;

}

.system-card h3{

margin-bottom:12px;

}


.system-card p{

font-size:13px;

line-height:1.7;

margin-bottom:12px;

}


.system-card ul{

padding-left:18px;

margin-top:10px;

}


.system-card li{

font-size:13px;

line-height:1.7;

color:#334155;

}


.section-label{

font-size:12px;

font-weight:800;

letter-spacing:3px;

color:#a67c2e;

margin-bottom:15px;

}


.section-desc{

max-width:700px;

margin:20px auto;

line-height:1.8;

color:#64748b;

}
.system-section{

position:relative;

overflow:hidden;

}


.system-section::before{

content:"";

position:absolute;

width:300px;

height:300px;

background:#d7b787;

opacity:.15;

border-radius:50%;

top:-100px;

right:-100px;

filter:blur(80px);

}


.system-card h3{


color:#6b4f1d;


font-size:18px;


}



.system-card p{


font-size:13px;


line-height:1.6;


}




html{


scroll-behavior:smooth;


}
.dashboard-preview{

animation:

floating 5s ease-in-out infinite;

}


@keyframes floating{

0%,100%{

transform:translateY(0);

}


50%{

transform:translateY(-15px);

}

}



@media(max-width:900px){



.hero{


padding:100px 30px;


}



.hero-left{


width:100%;


}



.hero-right{


display:none;


}

.system-grid{

grid-template-columns:1fr;

}

.system-section{
    scroll-margin-top:100px;
}
.navbar{


padding:0 30px;


}



.nav-menu{


display:none;


}



.company{


font-size:36px;


}



.features{


flex-direction:column;


}

.brand img{

width:52px;

height:52px;

object-fit:contain;

background:white;

border-radius:50%;

padding:5px;

box-shadow:

0 5px 15px rgba(0,0,0,.25);

}


.section-label{

font-size:12px;

font-weight:700;

letter-spacing:3px;

color:#a67c2e;

margin-bottom:15px;

}


.section-desc{

max-width:700px;

margin:20px auto;

line-height:1.8;

color:#64748b;

}
.system-card{

background:white;

padding:35px;

border-radius:24px;

text-align:left;

box-shadow:
0 15px 40px rgba(107,79,29,.08);

border:1px solid #eee;

transition:.35s;

position:relative;

overflow:hidden;

}



.system-card::before{

content:"";

position:absolute;

top:0;

left:0;

width:100%;

height:5px;

background:#a67c2e;

}



.system-card:hover{

transform:translateY(-10px);

box-shadow:

0 25px 60px rgba(0,0,0,.15);

}
}
</style>

</head>

<body id="home">
<!-- NAVBAR -->

<div class="navbar">
<div class="brand">

<img src="{{asset('images/logo-cv.png')}}">


<div class="brand-text">

Sahabat Eksplorasi Banua

<span>
Sistem Manajemen Keuangan
</span>

</div>

</div>
<div class="nav-menu">

<a href="#" onclick="goHome(); return false;">
Beranda
</a>

<a href="#system" onclick="goSystem(); return false;">
Fitur Sistem
</a>


<a href="javascript:void(0)" onclick="openLogin()">
Masuk
</a>

</div>
</div>






<!-- HERO -->


<section class="hero" id="home">


<div class="hero-left">


<div class="logo-box">

<img src="{{asset('images/logo-cv.png')}}">

</div>




<div class="company">

Sahabat Eksplorasi<span>Banua</span>

</div>




<div class="system">

Sistem Manajemen Keuangan & Proyek

</div>



<div class="description">


Platform digital perusahaan untuk mengelola proyek,
keuangan, persetujuan dana, dan aktivitas operasional
secara terintegrasi dalam satu sistem.

</div>






<div class="features">


<div class="feature">

<div class="feature-icon">
📁
</div>

<div class="feature-title">
Manajemen Proyek
</div>

<div class="feature-text">
Pemantauan proyek perusahaan
</div>

</div>




<div class="feature">

<div class="feature-icon">
💰
</div>

<div class="feature-title">
Kontrol Keuangan
</div>

<div class="feature-text">
Transaksi dan laporan keuangan
</div>

</div>





<div class="feature">

<div class="feature-icon">
👥
</div>

<div class="feature-title">
Hak Akses Pengguna
</div>

<div class="feature-text">
Pengaturan akses pengguna
</div>

</div>


</div>






<button class="btn-login" onclick="openLogin()">

Masuk Ke Sistem

</button>




<div class="status">


<div class="status-dot"></div>


Sistem Berjalan Normal


</div>




</div>







<div class="hero-right">


<div class="dashboard-preview">


<div class="preview-title">

Ringkasan Sistem

</div>


<div class="preview-card">

<div class="preview-label">

Pemantauan Keuangan

</div>


<div class="preview-value">

Aktif

</div>


</div>




<div class="preview-card">

<div class="preview-label">

Proyek Aktif

</div>


<div class="preview-value">

12 Proyek

</div>


</div>




<div class="preview-card">

<div class="preview-label">

Status Sistem

</div>


<div class="preview-value">

Terhubung

</div>


</div>



</div>


</div>



</section>
<section class="system-section" id="system">


<div class="system-container">


<div class="section-label">
FITUR SISTEM
</div>


<h2>
Platform Manajemen Perusahaan Terintegrasi
</h2>


<p class="section-desc">

Sistem digital perusahaan yang membantu pengelolaan
proyek, keuangan, pengguna, dan laporan operasional
secara terintegrasi.

</p>




<div class="system-grid">



<div class="system-card">


<div class="system-icon">
📁
</div>


<h3>
Project Management
</h3>


<p>
Mengelola data project perusahaan,
monitoring aktivitas pekerjaan,
dan melihat perkembangan project secara real-time.
</p>


<ul>

<li>Data project</li>

<li>Monitoring progres</li>

<li>Manajemen divisi</li>

</ul>


</div>








<div class="system-card">


<div class="system-icon">
💰
</div>


<h3>
Financial Management
</h3>


<p>
Mengelola transaksi keuangan perusahaan
mulai dari pemasukan, pengeluaran,
hingga saldo keuangan.
</p>


<ul>

<li>Pembayaran masuk</li>

<li>Pengeluaran dana</li>

<li>Laporan keuangan</li>

</ul>


</div>







<div class="system-card">


<div class="system-icon">
✓
</div>


<h3>
Approval Workflow
</h3>


<p>
Mendukung proses persetujuan dana
secara terstruktur berdasarkan
hak akses pengguna.
</p>


<ul>

<li>Pengajuan dana</li>

<li>Approval keuangan</li>

<li>Riwayat persetujuan</li>

</ul>


</div>








<div class="system-card">


<div class="system-icon">
🏦
</div>


<h3>
Bank Monitoring
</h3>


<p>
Melakukan monitoring rekening bank
dan ketersediaan saldo perusahaan.
</p>


<ul>

<li>Multi rekening</li>

<li>Saldo bank</li>

<li>Status rekening</li>

</ul>


</div>








<div class="system-card">


<div class="system-icon">
👥
</div>


<h3>
Role Management
</h3>


<p>
Mengatur akses sistem berdasarkan
peran pengguna agar keamanan data terjaga.
</p>


<ul>

<li>Admin</li>

<li>Keuangan</li>

<li>Karyawan</li>

</ul>


</div>








<div class="system-card">


<div class="system-icon">
📊
</div>


<h3>
Reporting System
</h3>


<p>
Menyediakan laporan yang informatif
dengan export data untuk kebutuhan perusahaan.
</p>


<ul>

<li>Dashboard laporan</li>

<li>Export Excel</li>

<li>Analisis data</li>

</ul>


</div>






</div>


</div>


</section>
<div class="login-overlay" id="login">

<div class="login-box">
<div class="login-left">

<div>

<img 
src="{{asset('images/logo-cv.png')}}"
class="login-logo">


<div class="login-company">
Sahabat Eksplorasi Banua
</div>


<p>
Sistem Manajemen Keuangan & Proyek
</p>


</div>

</div>
<div class="login-right">

<div class="login-header">

<span class="login-title-small">
PORTAL PERUSAHAAN
</span>

<h2>
Selamat Datang Kembali
</h2>

<div class="login-desc">
Masuk menggunakan akun resmi perusahaan
</div>

</div>


<form method="POST" action="{{route('login')}}">

@csrf


<div class="form-group">

<label>Email</label>

<input 
type="email"
name="email"
required
placeholder="Email perusahaan">

</div>


<div class="form-group">

<label>Password</label>

<div class="password-box">

<input
id="password"
type="password"
name="password"
required
placeholder="Masukkan password">


<span 
class="toggle-password"
onclick="togglePassword()">

<i class="fa-solid fa-eye"></i>

</span>

</div>

</div>



<div class="remember">

<input type="checkbox" name="remember">

Ingat akun saya

</div>




<button class="submit-btn">

MASUK

</button>


</form>

<div class="close-login" onclick="closeLogin()">

<i class="fa-solid fa-arrow-left"></i>

<span>Kembali ke halaman utama</span>

</div>
<div class="footer">

© {{date('Y')}} Sahabat Eksplorasi Banua

</div>


</div> 
</div>
</div>
<script>


function openLogin(){

document
.getElementById('login')
.classList.add('show');

}


function goSystem(){

document
.getElementById('system')
.scrollIntoView({

behavior:'smooth'

});

history.pushState("", document.title, window.location.pathname);

}
function closeLogin(){

document
.getElementById('login')
.classList.remove('show');

}
 function goHome(){

history.pushState("", document.title, window.location.pathname);

window.scrollTo({

top:0,

behavior:'smooth'

});

}

window.addEventListener("scroll",function(){

const nav=document.querySelector(".navbar");


if(window.scrollY > 50){

nav.style.background="rgba(15,23,42,.85)";

}else{

nav.style.background="rgba(15,23,42,.35)";

}


});

window.addEventListener("load",function(){

if(window.location.hash){

history.replaceState(null,null,window.location.pathname);

window.scrollTo(0,0);

}

});
function togglePassword(){

const password = document.getElementById("password");

const icon = document.querySelector(".toggle-password i");


if(password.type === "password"){

password.type = "text";

icon.classList.remove("fa-eye");

icon.classList.add("fa-eye-slash");


}else{


password.type = "password";

icon.classList.remove("fa-eye-slash");

icon.classList.add("fa-eye");


}

}
</script>
