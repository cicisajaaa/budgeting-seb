<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Sahabat Eksplorasi Banua | Project System
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
            rgba(15,23,42,.85),
            rgba(107,79,29,.65)
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
    background:#d7b787;
    filter:blur(180px);
    opacity:.18;
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
    transition: 1s cubic-bezier(.77,0,.18,1);
}

.welcome.move{
    transform: scale(.95) translateX(-100%);
    opacity:0;
    filter:blur(12px);
}

.logo-main{
    width:170px;
    padding:15px;
    background: rgba(255,255,255,.12);
    border-radius:35px;
    backdrop-filter:blur(10px);
    border: 1px solid rgba(255,255,255,.25);
    filter: drop-shadow(0 20px 35px rgba(0,0,0,.45));
    animation: floating 5s infinite ease-in-out;
}

.company{
    margin-top:25px;
    font-size:48px;
    font-weight:700;
    letter-spacing:-1px;
}

.company span{
    color:#d7b787;
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
    margin-top: 25px;
    padding: 14px 35px;
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    background: linear-gradient(135deg, #6b4f1d, #a67c2e);
    box-shadow: 0 20px 40px rgba(166,124,46,.35);
    transition: 0.3s;
}

.enter-btn:hover{
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(34,197,94,.4);
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
    box-shadow: 0 0 15px #22c55e;
}

/* ================= LOGIN ================= */

.login-panel{
    position:absolute;
    inset:0;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgba(0,0,0,.25);
    backdrop-filter: blur(10px);
    opacity:0;
    pointer-events:none;
    transition:.8s ease;
}

.login-panel.show{
    opacity:1;
    pointer-events:auto;
}

.login-box{
    background:white;
    width: 420px;
    padding: 40px;
    border-radius:30px;
    border: 1px solid rgba(166,124,46,.15);
    box-shadow: 0 40px 100px rgba(0,0,0,.45);
    transform: scale(0.9);
    opacity: 0;
    transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.login-panel.show .login-box{
    transform: scale(1);
    opacity:1;
}

.logo-login{
    width:85px;
    display:block;
    margin:auto;
    filter: drop-shadow(0 15px 25px rgba(0,0,0,.2));
}

.company-login{
    margin-top:14px;
    text-align:center;
    font-size:18px;
    font-weight:700;
    color:#6b4f1d;
}

.company-sub{
    margin-top:4px;
    text-align:center;
    font-size:12px;
    color:#64748b;
}

.badge{
    margin:14px auto 0;
    width:max-content;
    padding:5px 14px;
    border-radius:30px;
    background:#f8f3e8;
    color:#a67c2e;
    border: 1px solid #d7b787;
    font-size:11px;
    font-weight:600;
}

.login-box h2{
    margin-top:20px;
    text-align:center;
    font-size:24px;
    color:#111827;
}

.login-desc{
    margin-top:6px;
    margin-bottom:24px;
    text-align:center;
    font-size:13px;
    color:#64748b;
}

.group{
    margin-bottom:16px;
}

label{
    display:block;
    font-size:12px;
    font-weight:600;
    margin-bottom:6px;
    color:#374151;
}

input{
    width:100%;
    height:46px;
    border-radius:12px;
    border:1px solid #d1d5db;
    background:#f8fafc;
    padding:0 14px;
    font-size:13px;
    transition:.3s;
}

input:focus{
    outline:none;
    background:white;
    border-color:#a67c2e;
    box-shadow: 0 0 0 4px rgba(166,124,46,.15);
}

.password-box{
    position:relative;
}

.password-box input{
    padding-right:40px;
}

.toggle-password{
    position:absolute;
    right:14px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    font-size:16px;
    color:#64748b;
}

.toggle-password:hover{
    color:#a67c2e;
}


/* Bagian Ingat Saya & Lupa Sandi */
.login-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
    margin-bottom: 20px;
    font-size: 13px;
    position: relative; /* Tambahkan ini */
    z-index: 10; /* Tambahkan ini agar bisa diklik */
}

.forgot-link {
    color: #a67c2e;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
    cursor: pointer;
    position: relative; /* Tambahkan ini */
    z-index: 20; /* Tambahkan ini agar aman dari tumpukan CSS lain */
}

.login-btn{
    width:100%;
    height:48px;
    border:none;
    border-radius:12px;
    background: linear-gradient(135deg, #166534, #22c55e);
    color:white;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
    transition:.3s;
}

.login-btn:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(34,197,94,.35);
}

.back{
    margin-top:16px;
    text-align:center;
    font-size:13px;
    color:#64748b;
    cursor:pointer;
    transition: 0.2s;
}

.back:hover {
    color: #111827;
}

.footer{
    margin-top:18px;
    text-align:center;
    font-size:11px;
    color:#94a3b8;
}

@keyframes floating{
    0%,100%{ transform:translateY(0); }
    50%{ transform:translateY(-10px); }
}

@media(max-width:600px){
    .login-box{
        width:90%;
        padding:25px;
    }
}
</style>
</head>

<body>

<!-- WELCOME -->
<div class="welcome" id="welcome">
    <div>
        <img src="{{asset('images/logo-cv.png')}}" class="logo-main">
        <div class="company">Sahabat Eksplorasi<span>Banua</span></div>
        <div class="system-name">Sahabat Eksplorasi Banua Project System</div>
        <div class="tagline">
            Kelola proyek, keuangan, dan aktivitas perusahaan<br>dalam satu sistem terintegrasi.
        </div>
        <button class="enter-btn" onclick="openLogin()">Masuk Sistem</button>
        <div class="system-online">
            <span></span> Sistem Berjalan Normal
        </div>
    </div>
</div>

<!-- LOGIN -->
<div class="login-panel" id="login">
    <div class="login-box">
        <img src="{{asset('images/logo-cv.png')}}" class="logo-login">
        <div class="company-login">Sahabat Eksplorasi Banua</div>
        <div class="company-sub">Portal Sistem Perusahaan</div>
        <div class="badge">Akses Resmi Perusahaan</div>

        <h2>Selamat Datang Kembali</h2>
        <div class="login-desc">Masuk menggunakan akun resmi perusahaan</div>

        <form method="POST" action="{{route('login')}}">
            @csrf

            <div class="group">
                <label>Email</label>
                <input type="email" name="email" required autofocus placeholder="nama@perusahaan.com">
            </div>

            <div class="group">
                <label>Password</label>
                <div class="password-box">
                    <input id="password" type="password" name="password" required placeholder="Masukkan password">
                    <span class="toggle-password" onclick="togglePassword()">👁</span>
                </div>
            </div>

           <!-- Opsi Ingat Saya & Lupa Kata Sandi -->
<div class="login-options">
    <label class="remember">
        <input type="checkbox" name="remember"> Ingat saya
    </label>
    
    <!-- JURUS PAMUNGKAS: Mencegah # dan memaksa pindah halaman -->
    <a href="{{ route('password.request') }}" 
       onclick="event.preventDefault(); window.location.href='{{ route('password.request') }}';" 
       class="forgot-link" 
       style="position: relative; z-index: 50;">
        Lupa kata sandi?
    </a>
</div>

            <button class="login-btn">MASUK</button>
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
    document.getElementById('welcome').classList.add('move');
    setTimeout(()=>{
        document.getElementById('login').classList.add('show');
    },350);
}

function back(){
    document.getElementById('login').classList.remove('show');
    setTimeout(()=>{
        document.getElementById('welcome').classList.remove('move');
    },500);
}

function togglePassword(){
    const password = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if(password.type === "password"){
        password.type = "text";
        icon.textContent = "🙈";
    }else{
        password.type = "password";
        icon.textContent = "👁";
    }
}
</script>

</body>
</html>