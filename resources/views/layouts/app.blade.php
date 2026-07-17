<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Tracker System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --mint-primary: #10b981; 
            --mint-hover: #059669;   
            --glass-bg: rgba(255, 255, 255, 0.55);
            --glass-border: rgba(255, 255, 255, 0.8);
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Poppins", sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            background-color: #ecfdf5;
            background-image: 
                radial-gradient(at 10% 0%, #a7f3d0 0px, transparent 50%),
                radial-gradient(at 90% 10%, #d1fae5 0px, transparent 50%),
                radial-gradient(at 90% 90%, #6ee7b7 0px, transparent 50%),
                radial-gradient(at 10% 90%, #a7f3d0 0px, transparent 50%);
            background-attachment: fixed;
        }

        .header {
            height: 75px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo { font-size: 20px; font-weight: 700; color: var(--mint-hover); }
        .user-info { font-size: 12px; color: var(--text-muted); background: rgba(255, 255, 255, 0.6); padding: 6px 15px; border-radius: 20px; border: 1px solid white; }
        .user-info b { color: var(--mint-hover); }
        .header-right { display: flex; align-items: center; gap: 25px; }

        .wrapper { display: flex; min-height: calc(100vh - 75px); }

        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 30px 20px;
        }

        .sidebar h4 { font-size: 12px; color: var(--mint-hover); margin: 20px 0 10px 15px; font-weight: 600; text-transform: uppercase; }
        .sidebar a { display: block; padding: 12px 18px; margin-bottom: 8px; border-radius: 12px; color: var(--text-dark); text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s ease; border: 1px solid transparent; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.8); color: var(--mint-primary); border: 1px solid white; transform: translateX(5px); }

        .content { flex: 1; padding: 40px; overflow-x: auto; }

        .card { background: var(--glass-bg); backdrop-filter: blur(16px); border: 1px solid var(--glass-border); border-radius: 24px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04); }
        .card h2, .card h3 { margin-bottom: 20px; color: var(--mint-hover); }

        button, .btn { background: var(--mint-primary); color: white; border: none; padding: 10px 24px; border-radius: 12px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
        button:hover, .btn:hover { background: var(--mint-hover); transform: translateY(-2px); }
        .logout { background: #fff; color: #ef4444; border: 1px solid #fee2e2; }
        .logout:hover { background: #ef4444; color: white; }

        table { width: 100%; border-collapse: separate; border-spacing: 0; }
        th { background: rgba(255, 255, 255, 0.6); padding: 16px; text-align: left; border-bottom: 2px solid var(--glass-border); color: var(--text-muted); font-size: 13px; text-transform: uppercase; }
        td { padding: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.4); font-size: 14px; }
        tr:hover td { background: rgba(255, 255, 255, 0.4); }

        .badge { background: #ef4444; color: white; border-radius: 50px; padding: 3px 6px; font-size: 11px; position: absolute; top: -5px; right: -5px; }
        .notification { position: relative; }
        .notification > a { text-decoration: none; font-size: 20px; background: rgba(255,255,255,0.7); padding: 8px; border-radius: 50%; border: 1px solid white; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <div class="logo">Project Tracker</div>
            <div class="user-info">
                Login sebagai: <b>{{ auth()->check() ? auth()->user()->name : 'Guest' }}</b> | {{ auth()->check() ? auth()->user()->role : '-' }}
            </div>
        </div>

        <div class="header-right">
            <div class="notification">
                @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                <a href="#">🔔 <span class="badge">{{ auth()->user()->unreadNotifications->count() }}</span></a>
                @endif
            </div>

            @if(auth()->check())
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout">Logout</button>
            </form>
            @endif
        </div>
    </div>

    <div class="wrapper">
        <div class="sidebar">
            @if(auth()->check() && auth()->user()->role == 'owner')
                <h4>Owner Area</h4>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('finance.report') }}">Laporan Keuangan</a>
            @endif

            @if(auth()->check() && auth()->user()->role == 'bendahara')
                <h4>Bendahara Area</h4>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('finance.deposit') }}">Input Pembayaran</a>
                <a href="{{ route('finance.distribution') }}">Distribusi Dana</a>
                <a href="{{ route('finance.balance') }}">Saldo Divisi</a>
                <a href="{{ route('expense.approval') }}">Approval Pengeluaran</a>
                <a href="{{ route('finance.report') }}">Laporan Keuangan</a>
            @endif

            @if(auth()->check() && auth()->user()->role == 'karyawan')
                <h4>Karyawan Area</h4>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('expense.create') }}">Pengajuan Dana</a>
                <a href="{{route('expense.myhistory')}}">Riwayat Pengajuan</a>
            @endif

            @if(auth()->check() && auth()->user()->role == 'admin')
                <h4>Admin Area</h4>
                <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                <a href="{{ route('admin.users.index') }}">Kelola User</a>
                <a href="{{ route('admin.projects.index') }}">Kelola Project</a>
                <a href="{{ route('admin.divisions.index') }}">Kelola Divisi</a>
            @endif
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>