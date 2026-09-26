<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | Sahabat Eksplorasi Banua</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, rgba(15,23,42,.85), rgba(107,79,29,.65)), url('{{asset("images/company-bg.png")}}');
            background-size: cover; background-position: center;
        }
        .box {
            background: white; width: 420px; padding: 40px; border-radius: 30px;
            box-shadow: 0 40px 100px rgba(0,0,0,.45);
            border: 1px solid rgba(166,124,46,.15);
        }
        .logo-login {
            width: 85px; display: block; margin: auto;
            filter: drop-shadow(0 15px 25px rgba(0,0,0,.2));
        }
        h2 { font-size: 22px; color: #111827; margin-top: 15px; margin-bottom: 8px; text-align: center; font-weight: 700; }
        p { font-size: 13px; color: #64748b; text-align: center; margin-bottom: 24px; line-height: 1.5; }
        .group { margin-bottom: 16px; }
        label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; color: #374151; }
        input {
            width: 100%; height: 46px; border-radius: 12px; border: 1px solid #d1d5db;
            background: #f8fafc; padding: 0 14px; font-size: 13px; transition: .3s;
        }
        input:focus { outline: none; background: white; border-color: #a67c2e; box-shadow: 0 0 0 4px rgba(166,124,46,.15); }
        .btn {
            width: 100%; height: 48px; border: none; border-radius: 12px;
            background: linear-gradient(135deg, #166534, #22c55e); color: white;
            font-weight: 600; font-size: 14px; cursor: pointer; margin-top: 10px; transition: .3s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(34,197,94,.35); }
        .back { margin-top: 20px; text-align: center; font-size: 13px; }
        .back a { color: #64748b; text-decoration: none; font-weight: 500; transition: 0.2s; }
        .back a:hover { color: #111827; }
        .alert-success {
            background: #dcfce7; color: #166534; padding: 10px 14px;
            border-radius: 10px; font-size: 12px; margin-bottom: 16px; text-align: center; font-weight: 500;
        }
        .error-msg { color: #dc2626; font-size: 11px; margin-top: 5px; display: block; }
    </style>
</head>
<body>

<div class="box">
    <img src="{{asset('images/logo-cv.png')}}" class="logo-login">
    <h2>Lupa Kata Sandi?</h2>
    <p>Masukkan alamat email perusahaan Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>

    <!-- Status Sesi / Pesan Berhasil Kirim -->
    @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="group">
            <label>Email Perusahaan</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@perusahaan.com">
            @error('email')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Kirim Tautan Reset Sandi</button>
    </form>

    <div class="back">
        <a href="{{ url('/') }}">← Kembali ke halaman login</a>
    </div>
</div>

</body>
</html>