<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Sahabat Eksplorasi Banua| Project System
</title>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>


*{

margin:0;
padding:0;
box-sizing:border-box;

}



body{


height:100vh;


overflow:hidden;


font-family:'Inter',sans-serif;



background:


linear-gradient(

120deg,

rgba(2,44,34,.70),

rgba(15,23,42,.70)

),


url('{{asset("images/company-bg.png")}}');



background-size:cover;


background-position:center;


}





body::before{


content:"";


position:absolute;


width:500px;


height:500px;


background:#22c55e;


filter:blur(180px);


opacity:.15;


top:-180px;


left:-150px;


}







/* ================= WELCOME ================= */



.welcome{


width:100%;


height:100vh;


display:flex;


align-items:center;


justify-content:center;


text-align:center;


color:white;



transition:

1s cubic-bezier(.77,0,.18,1);


}



.welcome.move{


transform:

scale(.95)

translateX(-100%);



opacity:0;


filter:blur(12px);



}






.logo-main{


width:150px;



filter:

drop-shadow(

0 20px 35px rgba(0,0,0,.45)

);



animation:

floating 5s infinite ease-in-out;


}







.company{


margin-top:25px;


font-size:48px;


font-weight:700;


letter-spacing:-1px;


}



.company span{


color:#4ade80;


}






.system-name{


margin-top:10px;


font-size:18px;


font-weight:500;


color:#dcfce7;


}






.tagline{


margin-top:15px;


font-size:15px;


line-height:1.8;


color:#d1fae5;


}





.enter-btn{


margin-top:38px;


padding:15px 55px;


border:none;


border-radius:50px;


background:


linear-gradient(

135deg,

#15803d,

#22c55e

);



color:white;


font-size:15px;


font-weight:600;


cursor:pointer;


transition:.3s;



}



.enter-btn:hover{


transform:

translateY(-4px);


box-shadow:


0 15px 40px rgba(34,197,94,.4);



}





.system-online{


margin-top:25px;


display:flex;


justify-content:center;


align-items:center;


gap:8px;


font-size:13px;


color:#dcfce7;


}





.system-online span{


width:9px;


height:9px;


background:#22c55e;


border-radius:50%;


box-shadow:

0 0 15px #22c55e;


}









/* ================= LOGIN ================= */



.login-panel{


position:absolute;


inset:0;


height:100vh;


display:flex;


align-items:center;


justify-content:center;



background:

rgba(0,0,0,.25);



backdrop-filter:

blur(10px);



opacity:0;


pointer-events:none;


transition:.8s ease;


}





.login-panel.show{


opacity:1;


pointer-events:auto;


}





.login-box{


width:420px;


padding:40px 45px;



background:

rgba(255,255,255,.96);



border-radius:28px;



box-shadow:


0 30px 80px rgba(0,0,0,.35);



transform:

scale(.85);



opacity:0;



transition:

.6s ease;


}





.login-panel.show .login-box{


transform:

scale(1);



opacity:1;


}







.logo-login{


width:105px;


display:block;


margin:auto;



filter:

drop-shadow(

0 15px 25px rgba(0,0,0,.2)

);



}







.company-login{


margin-top:18px;


text-align:center;


font-size:22px;


font-weight:700;


color:#166534;


}



.company-sub{


margin-top:6px;


text-align:center;


font-size:13px;


color:#64748b;


}






.badge{


margin:18px auto 0;


width:max-content;


padding:6px 15px;


border-radius:30px;


background:#dcfce7;


color:#15803d;


font-size:12px;


font-weight:600;


}





.login-box h2{


margin-top:28px;


text-align:center;


font-size:28px;


color:#111827;


}





.login-desc{


margin-top:10px;


margin-bottom:30px;


text-align:center;


font-size:14px;


color:#64748b;


}







.group{


margin-bottom:20px;


}





label{


display:block;


font-size:13px;


font-weight:600;


margin-bottom:8px;


color:#374151;


}





input{


width:100%;


height:52px;


border-radius:14px;


border:1px solid #d1d5db;


background:#f8fafc;


padding:0 16px;


font-size:14px;


transition:.3s;



}





input:focus{


outline:none;


background:white;


border-color:#22c55e;


box-shadow:


0 0 0 4px rgba(34,197,94,.15);



}







.remember{


display:flex;


align-items:center;


gap:8px;


font-size:13px;


color:#64748b;


}



.remember input{


width:auto;


}







.login-btn{


width:100%;


height:52px;


margin-top:20px;


border:none;


border-radius:14px;



background:


linear-gradient(

135deg,

#166534,

#22c55e

);



color:white;


font-weight:600;


font-size:15px;


cursor:pointer;


transition:.3s;


}





.login-btn:hover{


transform:

translateY(-3px);


box-shadow:


0 15px 35px rgba(34,197,94,.35);



}






.back{


margin-top:20px;


text-align:center;


font-size:13px;


color:#64748b;


cursor:pointer;


}



.footer{


margin-top:25px;


text-align:center;


font-size:12px;


color:#94a3b8;


}








@keyframes floating{


0%,100%{


transform:translateY(0);


}


50%{


transform:translateY(-10px);


}


}







@media(max-width:600px){


.login-box{


width:90%;


padding:35px;


}



}







</style>


</head>




<body>





<!-- WELCOME -->

<div class="welcome" id="welcome">


<div>


<img

src="{{asset('images/logo-cv.png')}}"

class="logo-main"

>




<div class="company">

Sahabat Eksplorasi<span>Banua</span>

</div>



<div class="system-name">

Sahabat Eksplorasi Banua Project System

</div>





<div class="tagline">

Kelola proyek, keuangan, dan aktivitas perusahaan

<br>

dalam satu sistem terintegrasi.

</div>






<button

class="enter-btn"

onclick="openLogin()"

>

Masuk Sistem

</button>





<div class="system-online">

<span></span>

Sistem Online

</div>





</div>


</div>








<!-- LOGIN -->


<div class="login-panel" id="login">



<div class="login-box">



<img

src="{{asset('images/logo-cv.png')}}"

class="logo-login"

>




<div class="company-login">

Sahabat Eksplorasi Banua

</div>




<div class="company-sub">

Portal Sistem Perusahaan

</div>





<div class="badge">

Akses Resmi Perusahaan

</div>






<h2>

Selamat Datang Kembali

</h2>






<div class="login-desc">

Masuk menggunakan akun resmi perusahaan

</div>






<form method="POST" action="{{route('login')}}">


@csrf




<div class="group">


<label>

Email

</label>


<input

type="email"

name="email"

required

autofocus

>


</div>






<div class="group">


<label>

Password

</label>


<input

type="password"

name="password"

required

>


</div>







<div class="remember">


<input

type="checkbox"

name="remember"

>


Ingat saya


</div>







<button class="login-btn">

MASUK

</button>




</form>







<div class="back" onclick="back()">

← Kembali ke halaman utama

</div>






<div class="footer">

© {{date('Y')}} Sahabat Eksplorasi Banua

</div>





</div>


</div>









<script>


function openLogin(){


document

.getElementById('welcome')

.classList.add('move');



setTimeout(()=>{


document

.getElementById('login')

.classList.add('show');


},350);


}







function back(){


document

.getElementById('login')

.classList.remove('show');



setTimeout(()=>{


document

.getElementById('welcome')

.classList.remove('move');


},500);



}


</script>







</body>


</html>