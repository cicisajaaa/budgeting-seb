<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
CV Sahabat Alam | Project System
</title>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


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
135deg,
rgba(3,46,30,.85),
rgba(15,23,42,.90)
),

url('{{asset("images/company-bg.png")}}');


background-size:cover;

background-position:center;

}


/* ambient light */


body::before,
body::after{

content:"";

position:absolute;

border-radius:50%;

filter:blur(120px);

z-index:-1;

}


body::before{

width:450px;

height:450px;

background:#22c55e;

top:-150px;

left:-150px;

opacity:.25;

}


body::after{

width:400px;

height:400px;

background:#16a34a;

bottom:-150px;

right:-100px;

opacity:.15;

}




/* ======================
WELCOME
====================== */


.welcome{

height:100vh;

display:flex;

justify-content:center;

align-items:center;

text-align:center;

color:white;


transition:

1s cubic-bezier(.77,0,.18,1);

}


.welcome.move{

transform:

translateX(-100px)
scale(.92);


opacity:0;

filter:blur(20px);

}



.logo-main{

width:140px;

margin-bottom:30px;


filter:

drop-shadow(
0 20px 35px rgba(0,0,0,.5)
);


animation:

floating 4s ease-in-out infinite;

}



.company{

font-size:58px;

font-weight:800;

letter-spacing:-2px;

}



.company span{

color:#4ade80;

}



.system-title{

margin-top:15px;

font-size:20px;

font-weight:600;

color:#dcfce7;

}



.tagline{

margin-top:20px;

font-size:16px;

line-height:1.8;

color:#d1fae5;

}



.enter-btn{


margin-top:40px;

padding:16px 65px;


border-radius:50px;

border:none;


background:

linear-gradient(
135deg,
#15803d,
#4ade80
);


color:white;

font-size:15px;

font-weight:700;

cursor:pointer;


box-shadow:

0 15px 40px rgba(34,197,94,.35);


transition:.35s;

}


.enter-btn:hover{


transform:

translateY(-5px)
scale(1.05);


box-shadow:

0 25px 60px rgba(34,197,94,.55);


}




.system-online{


margin-top:30px;

display:flex;

justify-content:center;

align-items:center;

gap:10px;

font-size:13px;

}



.system-online span{


width:10px;

height:10px;

border-radius:50%;

background:#22c55e;


box-shadow:

0 0 20px #22c55e;


animation:pulse 1.5s infinite;

}





/* ======================
LOGIN
====================== */



.login-panel{


position:absolute;

inset:0;


display:flex;

align-items:center;

justify-content:center;



background:

rgba(15,23,42,.45);



backdrop-filter:

blur(18px);



opacity:0;

pointer-events:none;


transition:.8s;

}



.login-panel.show{

opacity:1;

pointer-events:auto;

}





.login-box{


width:420px;


padding:45px;


border-radius:32px;



background:

rgba(255,255,255,.96);



box-shadow:

0 40px 100px rgba(0,0,0,.45);



transform:

translateY(80px)
scale(.85);



opacity:0;


transition:

.8s cubic-bezier(.34,1.56,.64,1);

}




.login-panel.show .login-box{


transform:

translateY(0)
scale(1);


opacity:1;


}





.logo-login{


width:95px;

display:block;

margin:auto;


}



.company-login{


margin-top:18px;

text-align:center;


font-size:22px;

font-weight:800;


color:#166534;

}





.badge{


margin:20px auto;

width:max-content;

padding:7px 18px;

border-radius:30px;


background:#dcfce7;

color:#15803d;


font-size:12px;

font-weight:700;


}




.login-box h2{


text-align:center;

font-size:27px;

margin-top:25px;

color:#111827;


}



.login-desc{


text-align:center;

margin:12px 0 35px;


font-size:14px;

color:#64748b;


}





.group{

margin-bottom:22px;

}



label{


display:block;

margin-bottom:8px;


font-size:13px;

font-weight:600;


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

0 0 0 5px rgba(34,197,94,.15);


}





.remember{


display:flex;

align-items:center;

gap:10px;


font-size:13px;

color:#64748b;


}


.remember input{

width:auto;

height:auto;

}





.login-btn{


width:100%;


height:54px;


margin-top:25px;


border:none;


border-radius:15px;


background:

linear-gradient(
135deg,
#166534,
#22c55e
);



color:white;


font-weight:700;


cursor:pointer;


transition:.35s;


}





.login-btn:hover{


transform:

translateY(-4px);


box-shadow:

0 20px 40px rgba(34,197,94,.4);


}





.back{


margin-top:25px;


text-align:center;


font-size:13px;


color:#64748b;


cursor:pointer;


}





.footer{


margin-top:30px;

text-align:center;


font-size:12px;

color:#94a3b8;


}






@keyframes floating{


0%,100%{

transform:translateY(0);

}


50%{

transform:translateY(-12px);

}

}



@keyframes pulse{


50%{

opacity:.4;

transform:scale(1.5);

}

}




@media(max-width:600px){


.company{

font-size:40px;

}


.login-box{

width:90%;

padding:35px 25px;

}


.logo-main{

width:110px;

}


}



</style>


</head>


<body>


<div class="welcome" id="welcome">


<div>


<img

src="{{asset('images/logo-cv.png')}}"

class="logo-main">


<div class="company">

CV Sahabat <span>Alam</span>

</div>



<div class="system-title">

Sahabat Alam Project System

</div>



<div class="tagline">

Sistem informasi perusahaan untuk mengelola

<br>

project, keuangan, dan aktivitas operasional.

</div>



<button class="enter-btn" onclick="openLogin()">

Masuk Sistem

</button>



<div class="system-online">

<span></span>

System Online

</div>


</div>


</div>




<div class="login-panel" id="login">


<div class="login-box">


<img

src="{{asset('images/logo-cv.png')}}"

class="logo-login">



<div class="company-login">

CV Sahabat Alam

</div>


<div class="badge">

PROJECT MANAGEMENT SYSTEM

</div>



<h2>

Masuk Sistem

</h2>



<div class="login-desc">

Gunakan akun resmi perusahaan

</div>



<form method="POST" action="{{route('login')}}">


@csrf


<div class="group">

<label>Email</label>

<input

type="email"

name="email"

placeholder="nama@email.com"

autocomplete="email"

required>


</div>




<div class="group">


<label>Password</label>


<input

type="password"

name="password"

placeholder="Masukkan password"

autocomplete="current-password"

required>


</div>




<div class="remember">


<input type="checkbox" name="remember">


Ingat saya


</div>




<button class="login-btn">

MASUK KE SISTEM

</button>


</form>



<div class="back" onclick="back()">

← Kembali

</div>



<div class="footer">

© {{date('Y')}} CV Sahabat Alam

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


},500);


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