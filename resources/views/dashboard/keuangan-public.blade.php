<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keuangan | Sahabat Eksplorasi Banua</title>

    <!-- Font & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Efek kedipan instan untuk menutupi transisi load dari atas */
        body {
            animation: instantFade 0.25s ease-in-out;
        }
        @keyframes instantFade {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Menyembunyikan layar sekejap saat memuat halaman agar tidak kelihatan lompat */
        html.is-loading {
            visibility: hidden;
        }
        html {
            transition: opacity 0.15s ease-in-out;
        }


        /* =========================================================
           STYLE KHUSUS CETAK / PRINT
        ========================================================= */
        @media print {
            .public-navbar, .data-toolbar, .segment-control, .export-actions, .pagination-container, script {
                display: none !important;
            }
            body {
                background: #ffffff !important;
            }
            .finance-hero {
                min-height: auto !important;
                padding: 40px 20px !important;
                background: #0f172a !important;
                -webkit-print-color-adjust: exact;
            }
        }
        /* Aksen warna ketika filter bulan/tahun sedang aktif */
        .filter-select.has-value {
            border-color: var(--brand-gold) !important;
            background-color: var(--brand-gold-light) !important;
            color: var(--brand-dark) !important;
            font-weight: 700 !important;
        }
        /* =========================================================
           1. CORE VARIABLES (EXECUTIVE MINIMALISM)
        ========================================================= */
        :root {
            --brand-dark: #0f172a;
            --brand-gold: #b48629;
            --brand-gold-light: #fefce8;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-tertiary: #94a3b8;
            --bg-body: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            
            /* Premium Soft Shadows */
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            min-height: 100vh; overflow-x: hidden; font-family: 'Inter', sans-serif;
            color: var(--text-primary); background: var(--bg-body);
            -webkit-font-smoothing: antialiased;
        }

        .tabular-nums { font-variant-numeric: tabular-nums; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade { animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }

        /* =========================================================
           2. NAVBAR & HERO
        ========================================================= */
        .public-navbar {
            position: fixed; top: 0; left: 0; right: 0; height: 80px; display: flex; align-items: center; justify-content: space-between;
            padding: 0 6%; color: var(--white); z-index: 9999; background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.4s ease;
        }
        .public-navbar.scrolled { background: rgba(15, 23, 42, 0.95); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .navbar-container { width: 100%; max-width: 1240px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 30px; }
        .brand { display: flex; align-items: center; gap: 14px; text-decoration: none; color: #fff; }
        .brand img { width: 42px; height: 42px; border-radius: 50%; object-fit: contain; background: #fff; padding: 4px; }
        .brand-text { font-size: 15px; font-weight: 700; line-height: 1.3; letter-spacing: -0.3px; }
        .brand-text span { display: block; font-size: 11px; color: var(--brand-gold); font-weight: 500; letter-spacing: 0.5px; }
        .nav-menu { display: flex; align-items: center; gap: 36px; }
        .nav-menu a { color: rgba(255,255,255,0.75); text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.3s; }
        .nav-menu a:hover, .nav-menu .nav-active { color: #fff; }
        .nav-menu .nav-active { font-weight: 700; position: relative; }
        .nav-menu .nav-active::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 100%; height: 2px; background: var(--brand-gold); border-radius: 2px; }

        .finance-hero {
            position: relative; overflow: hidden; min-height: 100vh !important; width: 100vw !important; margin-left: calc(-50vw + 50%); padding: 140px 6% 80px !important;
            color: #fff; background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.85)), url('{{ asset("images/company-bg.png") }}') !important;
            background-size: cover !important; background-position: center center !important; background-attachment: fixed; display: flex; align-items: center; justify-content: center; 
        }
        .hero-inner { position: relative; z-index: 2; width: 100%; max-width: 1240px; margin: 0 auto; display: grid; grid-template-columns: 1.1fr 0.9fr; align-items: center; gap: 60px; }
        .hero-label { display: inline-flex; align-items: center; padding: 6px 14px; margin-bottom: 24px; border-radius: 50px; background: rgba(180, 134, 41, 0.15); border: 1px solid rgba(180, 134, 41, 0.3); color: var(--brand-gold); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
        .hero-title { margin: 0; color: #fff; font-size: 48px; line-height: 1.15; font-weight: 800; letter-spacing: -1.5px; }
        .hero-title span { display: block; margin-top: 4px; color: var(--brand-gold); }
        .hero-subtitle { margin-top: 18px; color: #cbd5e1; font-size: 18px; font-weight: 500; }
        .hero-description { max-width: 580px; margin: 16px 0 0; color: #94a3b8; font-size: 15px; line-height: 1.7; }
        .hero-status { display: inline-flex; align-items: center; gap: 8px; margin-top: 36px; font-size: 13px; font-weight: 600; padding: 10px 20px; background: rgba(255,255,255,0.05); border-radius: 50px; border: 1px solid rgba(255,255,255,0.1); }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 12px rgba(16,185,129,0.6); }

        .hero-summary { padding: 35px; border-radius: 24px; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4); }
        .summary-title { margin-bottom: 24px; color: #fff; font-size: 16px; font-weight: 700; }
        .summary-card { background: #fff; color: var(--text-primary); padding: 20px 24px; border-radius: 16px; margin-bottom: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .summary-card:last-child { margin-bottom: 0; }
        .summary-label { font-size: 12px; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .summary-value { color: var(--brand-dark); font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }

        /* =========================================================
           3. DASHBOARD CONTENT
        ========================================================= */
        .finance-content { position: relative; z-index: 5; width: 100%; max-width: 1200px; margin: 0 auto !important; padding: 80px 20px !important; background: var(--bg-body) !important; }
        .section-heading { text-align: center; margin-bottom: 50px; }
        .section-label { font-size: 12px; font-weight: 800; letter-spacing: 3px; color: var(--brand-gold); margin-bottom: 16px; text-transform: uppercase; }
        .section-heading h2 { margin: 0; color: var(--text-primary); font-size: 36px; line-height: 1.2; font-weight: 800; letter-spacing: -1px; }
        .section-heading p { margin: 15px auto 0; max-width: 650px; color: var(--text-secondary); font-size: 15px; line-height: 1.8; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px; }
        .stat-card { background: var(--surface); padding: 28px 24px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); display: flex; flex-direction: column; gap: 18px; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: #cbd5e1; }
        .stat-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .icon-blue { background: #eff6ff; color: #3b82f6; } .icon-red { background: var(--danger-bg); color: var(--danger); } .icon-green { background: var(--success-bg); color: var(--success); } .icon-gold { background: var(--brand-gold-light); color: var(--brand-gold); }
        .stat-info { display: flex; flex-direction: column; }
        .stat-label { color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .stat-value { color: var(--text-primary); font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }

        .widget-grid { display: grid; grid-template-columns: 1.6fr 1.4fr; gap: 24px; margin-bottom: 40px; }
        .widget-box { background: var(--surface); padding: 35px; border-radius: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .widget-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .widget-title { font-size: 16px; font-weight: 800; color: var(--text-primary); }
        .chart-wrap { position: relative; height: 350px; width: 100%; } 
        
        .rekap-item { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px dashed var(--border); gap: 16px; }
        .rekap-item:last-child { border-bottom: none; padding-bottom: 0; }
        .r-info { display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1; }
        .r-icon { width: 36px; height: 36px; min-width: 36px; border-radius: 10px; background: var(--border-light); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 13px; }
        .r-name { font-size: 12px; font-weight: 600; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .r-amount { font-size: 13px; font-weight: 800; color: var(--text-primary); white-space: nowrap; text-align: right; }

        /* =========================================================
           4. DATA CENTER & FILTER TOOLBAR
        ========================================================= */
        .data-center { background: var(--surface); padding: 40px; border-radius: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .data-toolbar { display: flex; justify-content: space-between; align-items: center; background: var(--bg-body); padding: 16px 20px; border-radius: 16px; border: 1px solid var(--border); margin-bottom: 30px; flex-wrap: wrap; gap: 16px; }

        .filter-form { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .filter-select { padding: 10px 16px; border-radius: 10px; border: 1px solid var(--border); background: var(--surface); color: var(--text-primary); font-size: 13px; font-weight: 500; font-family: 'Inter', sans-serif; cursor: pointer; outline: none; transition: 0.2s; }
        .filter-select:focus, .filter-select:hover { border-color: var(--brand-gold); }
        .btn-filter { padding: 10px 20px; border-radius: 10px; border: none; background: var(--text-primary); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 8px; }
        .btn-filter:hover { background: var(--brand-gold); }

        .export-actions { display: flex; align-items: center; gap: 12px; }
        .btn-export { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; transition: 0.2s; border: 1px solid transparent; cursor: pointer; }
        .btn-export.pdf { background: #fef2f2; color: var(--danger); border-color: #fca5a5; }
        .btn-export.pdf:hover { background: var(--danger); color: #fff; }
        .btn-export.excel { background: #ecfdf5; color: var(--success); border-color: #6ee7b7; }
        .btn-export.excel:hover { background: var(--success); color: #fff; }

        .segment-control { display: inline-flex; background: var(--border-light); padding: 6px; border-radius: 16px; margin-bottom: 30px; position: relative; }
        .segment-btn { position: relative; z-index: 2; padding: 12px 28px; border: none; background: transparent; font-size: 13px; font-weight: 600; color: var(--text-secondary); cursor: pointer; transition: 0.3s; }
        .segment-btn.active { color: var(--text-primary); font-weight: 700; }
        .segment-highlight { position: absolute; top: 6px; left: 6px; height: calc(100% - 12px); background: var(--surface); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1); z-index: 1; }

        .tab-content { display: none; animation: fadeUp 0.4s ease forwards; }
        .tab-content.active { display: block; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .table-container { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 10px; }
        .fintech-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; min-width: 700px; }
        .fintech-table th { font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; padding: 0 20px 10px; text-align: left; }
        .fintech-table th.right { text-align: right; }
        
        .fintech-table tbody tr { background: var(--bg-body); transition: all 0.2s ease; cursor: pointer; border-radius: 16px; box-shadow: inset 0 0 0 1px var(--border); }
        .fintech-table tbody td { padding: 20px 24px; font-size: 14px; font-weight: 600; border: none; vertical-align: middle; }
        .fintech-table tbody td:first-child { border-radius: 16px 0 0 16px; }
        .fintech-table tbody td:last-child { border-radius: 0 16px 16px 0; text-align: right; }
        .fintech-table tbody tr:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); z-index: 10; position: relative; background: var(--surface); }

        .t-primary { display: block; color: var(--text-primary); font-weight: 700; margin-bottom: 4px; }
        .t-date { font-size: 12px; color: var(--text-secondary); font-weight: 500; display: block; }
        
        .badge { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; display: inline-block; }
        .bg-green { background: var(--success-bg); color: var(--success); }
        .bg-red { background: var(--danger-bg); color: var(--danger); }
        .bg-gray { background: var(--border-light); color: var(--text-secondary); }
        .action-arrow { color: var(--text-secondary); font-size: 14px; transition: 0.2s; opacity: 0.5; margin-left: 10px; }
        .fintech-table tbody tr:hover .action-arrow { color: var(--brand-gold); opacity: 1; transform: translateX(5px); }

        /* =========================================================
           PAGINATION CLEAN STYLING
        ========================================================= */
        .pagination-container { margin-top: 30px; width: 100%; }
        .pagination-container nav { display: flex !important; justify-content: space-between !important; align-items: center !important; width: 100% !important; background: var(--bg-body) !important; padding: 14px 20px !important; border-radius: 12px !important; border: 1px solid var(--border) !important; flex-wrap: wrap; gap: 15px; }
        .pagination-container .text-sm, .pagination-container div:first-child { color: var(--text-secondary); font-size: 13px; font-weight: 500; margin: 0; }
        .pagination-container nav div:last-child { display: flex !important; align-items: center !important; gap: 8px !important; }
        .pagination-container ul.pagination { display: flex !important; list-style: none !important; gap: 4px !important; align-items: center !important; margin: 0 !important; padding: 0 !important; }
        .pagination-container svg { width: 14px; height: 14px; }
        .pagination-container .page-item, .pagination-container span[aria-disabled], .pagination-container a[rel] { display: inline-flex !important; align-items: center; justify-content: center; padding: 6px 12px !important; border-radius: 8px !important; font-size: 13px !important; font-weight: 600 !important; color: var(--text-secondary) !important; background: var(--surface) !important; border: 1px solid var(--border) !important; text-decoration: none !important; transition: 0.2s; }
        .pagination-container .page-item.active span, .pagination-container span[aria-current="page"] { background: var(--text-primary) !important; color: #fff !important; border-color: var(--text-primary) !important; }
        .pagination-container .page-item.disabled span, .pagination-container span[aria-disabled="true"] { color: var(--text-tertiary) !important; background: var(--border-light) !important; cursor: not-allowed; opacity: 0.6; }
        .pagination-container a:hover { border-color: var(--brand-gold) !important; color: var(--brand-gold) !important; }

        /* =========================================================
           5. RECEIPT MODAL
        ========================================================= */
        .modal-wrap { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); opacity: 0; pointer-events: none; transition: 0.4s ease; z-index: 999999; padding: 20px; }
        .modal-wrap.show { opacity: 1; pointer-events: auto; }
        .receipt-card { background: #ffffff; width: 100%; max-width: 420px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); transform: translateY(40px) scale(0.95); transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; z-index: 1000000; }
        .modal-wrap.show .receipt-card { transform: translateY(0) scale(1); }
        .receipt-header { background: var(--bg-body); padding: 35px 30px; text-align: center; border-bottom: 2px dashed #cbd5e1; position: relative; }
        .receipt-header::before, .receipt-header::after { content: ''; position: absolute; bottom: -10px; width: 20px; height: 20px; background: rgba(15, 23, 42, 0.7); border-radius: 50%; z-index: 2; }
        .receipt-header::before { left: -10px; } .receipt-header::after { right: -10px; }
        .r-icon-large { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 15px; }
        .icon-in { background: var(--success-bg); color: var(--success); } .icon-out { background: var(--danger-bg); color: var(--danger); } .icon-proj { background: var(--brand-gold-light); color: var(--brand-gold); }
        .receipt-title { font-size: 13px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; }
        .receipt-amount { font-size: 32px; font-weight: 800; color: var(--text-primary); margin-top: 5px; letter-spacing: -1px; }
        .receipt-body { padding: 35px 30px; background: #ffffff; }
        .r-row { display: flex; justify-content: space-between; margin-bottom: 16px; } .r-row:last-child { margin-bottom: 0; }
        .r-lbl { font-size: 13px; color: var(--text-secondary); font-weight: 500; }
        .r-val { font-size: 14px; color: var(--text-primary); font-weight: 700; text-align: right; max-width: 60%; }
        .receipt-footer { padding: 0 30px 30px; background: #ffffff; text-align: center; }
        .btn-close-modal { padding: 14px 30px; border-radius: 12px; border: none; background: var(--text-primary); color: #ffffff; font-size: 14px; font-weight: 700; cursor: pointer; transition: 0.2s; width: 100%; position: relative; z-index: 10; }
        .btn-close-modal:hover { background: var(--brand-gold); }

        @media (max-width: 1024px) {
            .hero-inner { grid-template-columns: 1fr; gap: 40px; } .widget-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); } .finance-hero { padding: 120px 40px 60px !important; }
            .nav-menu { display: none; }
        }
        @media (max-width: 768px) {
            .data-toolbar { flex-direction: column; align-items: stretch; }
            .filter-form { width: 100%; } .filter-select { flex: 1; }
            .export-actions { width: 100%; justify-content: flex-start; }
            .btn-export { flex: 1; justify-content: center; }
            .chart-wrap { height: 280px; }
        }
        @media (max-width: 600px) {
            .finance-hero { padding: 100px 20px 50px !important; } .hero-title { font-size: 36px; }
            .finance-content { padding: 50px 15px !important; } .stats-grid { grid-template-columns: 1fr; gap: 16px; }
            .widget-box, .data-center { padding: 24px 20px; }
            .segment-control { display: flex; overflow-x: auto; white-space: nowrap; width: 100%; }
            .segment-btn { flex: 1; text-align: center; padding: 10px 15px; font-size: 12px; }
            .fintech-table th { padding: 12px 15px; } .fintech-table tbody td { padding: 18px 15px; }
            .chart-wrap { height: 220px; }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="public-navbar" id="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('images/logo-cv.png') }}" alt="Logo Sahabat Eksplorasi Banua">
                <div class="brand-text">Sahabat Eksplorasi Banua<span>Sistem Manajemen Keuangan</span></div>
            </a>
            <div class="nav-menu">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('public.finance') }}" class="nav-active">Keuangan</a>
                <a href="#dashboard">Dashboard</a>
                <a href="#laporan">Laporan</a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="finance-hero">
        <div class="hero-inner">
            <div class="animate-fade">
                <div class="hero-label">INFORMASI KEUANGAN PUBLIK</div>
                <h1 class="hero-title">Transparansi<span>Keuangan</span></h1>
                <div class="hero-subtitle">Sistem Manajemen Keuangan & Proyek</div>
                <p class="hero-description">Halaman informasi keuangan perusahaan yang menyajikan ringkasan dana masuk, pengeluaran, saldo, anggaran, serta rekap keuangan setiap project secara informatif dan transparan.</p>
                <div class="hero-status"><span class="status-dot"></span> Sistem Berjalan Normal</div>
            </div>

            <div class="hero-summary animate-fade delay-1">
                <div class="summary-title">Ringkasan Keuangan</div>
                <div class="summary-card">
                    <div class="summary-label">Total Dana Masuk</div>
                    <div class="summary-value tabular-nums">Rp {{ number_format($totalDeposit ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Total Pengeluaran</div>
                    <div class="summary-value tabular-nums">Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="summary-card" style="background: var(--text-primary);">
                    <div class="summary-label" style="color: var(--border-light);">Saldo Aktif Perusahaan</div>
                    <div class="summary-value tabular-nums" style="color: var(--white);">Rp {{ number_format($sisaDana ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- DASHBOARD CONTENT --}}
    <main class="finance-content" id="dashboard">

        <div class="section-heading animate-fade delay-1">
            <div class="section-label">OVERVIEW KINERJA</div>
            <h2>Dashboard Keuangan</h2>
            <p>Pemantauan statistik keseluruhan operasional keuangan dan proyek untuk tahun berjalan.</p>
        </div>

        {{-- 1. TOP CARDS --}}
        <div class="stats-grid animate-fade delay-2">
            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="fa-solid fa-arrow-down-long"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Pemasukan</span>
                    <span class="stat-value tabular-nums">Rp {{ number_format($totalDeposit ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-red"><i class="fa-solid fa-arrow-up-long"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Pengeluaran</span>
                    <span class="stat-value tabular-nums">Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-green"><i class="fa-solid fa-wallet"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Saldo Kas Tersedia</span>
                    <span class="stat-value tabular-nums">Rp {{ number_format($sisaDana ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-gold"><i class="fa-regular fa-folder-open"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Total Project</span>
                    <span class="stat-value tabular-nums">{{ number_format($totalProject ?? 0) }} Aktif</span>
                </div>
            </div>
        </div>

        {{-- 2. WIDGETS (CHART & REKAP) --}}
        <div class="widget-grid animate-fade delay-2">
            <div class="widget-box">
                <div class="widget-header">
                    <div class="widget-title">Arus Kas Bulanan</div>
                    <span class="badge bg-gray"><i class="fa-regular fa-calendar"></i> {{ request('tahun') ?? date('Y') }}</span>
                </div>
                <div class="chart-wrap">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>

            <div class="widget-box">
                <div class="widget-header">
                    <div class="widget-title">Rekapitulasi Anggaran</div>
                </div>
                <div>
                    <div class="rekap-item">
                        <div class="r-info">
                            <div class="r-icon"><i class="fa-solid fa-layer-group"></i></div>
                            <span class="r-name">Total Anggaran Project</span>
                        </div>
                        <span class="r-amount tabular-nums">Rp {{ number_format($totalBudget ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="rekap-item">
                        <div class="r-info">
                            <div class="r-icon"><i class="fa-solid fa-building-columns"></i></div>
                            <span class="r-name">Total Saldo Divisi</span>
                        </div>
                        <span class="r-amount tabular-nums">Rp {{ number_format($totalSaldoDivisi ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="rekap-item">
                        <div class="r-info">
                            <div class="r-icon" style="color: var(--danger); background: var(--danger-bg);"><i class="fa-solid fa-fire"></i></div>
                            <span class="r-name">Pengeluaran Bulan Ini</span>
                        </div>
                        <span class="r-amount tabular-nums">Rp {{ number_format($expenseThisMonth ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="rekap-item" style="border:none;">
                        <div class="r-info">
                            <div class="r-icon" style="color: var(--success); background: var(--success-bg);"><i class="fa-solid fa-bolt"></i></div>
                            <span class="r-name">Volume Transaksi</span>
                        </div>
                        <span class="r-amount tabular-nums">{{ number_format($totalTransaction ?? 0) }} Trx</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. DATA CENTER (FILTER, TAB & TABEL) --}}
        <div class="data-center animate-fade delay-2" id="laporan">
            <div class="widget-header" style="margin-bottom: 20px;">
                <div class="widget-title">Laporan Terperinci</div>
            </div>

            <!-- ================= TOOLBAR FILTER & EXPORT ================= -->
            <div class="data-toolbar">
                <form method="GET" action="{{ route('public.finance') }}#laporan" class="filter-form">
                    <select name="bulan" class="filter-select">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="tahun" class="filter-select">
                        <option value="">Semua Tahun</option>
                        @php $currentYear = date('Y'); @endphp
                        @for($y = $currentYear; $y >= ($currentYear - 3); $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn-filter"><i class="fa-solid fa-filter"></i> Filter</button>
                    @if(request('bulan') || request('tahun'))
                        <a href="{{ route('public.finance') }}#laporan" class="btn-filter" style="background:var(--border-light); color:var(--text-secondary);"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    @endif
                </form>
            <div class="export-actions">
                    <a href="#" onclick="window.print(); return false;" class="btn-export" style="background: var(--border-light); color: var(--text-primary); border-color: var(--border);">
                        <i class="fa-solid fa-print"></i> Cetak
                    </a>
                    
                    <a href="{{ route('public.finance.export', ['type' => 'pdf'] + request()->all()) }}" class="btn-export pdf">
                        <i class="fa-solid fa-file-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('public.finance.export', ['type' => 'excel'] + request()->all()) }}" class="btn-export excel">
                        <i class="fa-solid fa-file-excel"></i> Download Excel
                    </a>
                </div>
            </div>

            <!-- ================= TAB & LIVE SEARCH ================= -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
                <div class="segment-control" id="tabContainer" style="margin-bottom: 0;">
                    <div class="segment-highlight" id="segmentHighlight"></div>
                    <button class="segment-btn {{ request('tab') == 'masuk' || !request('tab') ? 'active' : '' }}" onclick="switchTab(event, 'tab-masuk')">Dana Masuk</button>
                    <button class="segment-btn {{ request('tab') == 'keluar' ? 'active' : '' }}" onclick="switchTab(event, 'tab-keluar')">Pengeluaran</button>
                    <button class="segment-btn {{ request('tab') == 'project' ? 'active' : '' }}" onclick="switchTab(event, 'tab-project')">Status Project</button>
                </div>

                <div style="position: relative; flex-grow: 1; max-width: 320px; min-width: 250px;">
                    <i class="fa-solid fa-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-tertiary); font-size: 14px;"></i>
                    <input type="text" id="liveSearchInput" placeholder="Cari project, tanggal, atau nominal..." 
                           style="width: 100%; padding: 12px 16px 12px 42px; border-radius: 12px; border: 1px solid var(--border); background: var(--surface); color: var(--text-primary); font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; outline: none; transition: 0.3s; box-shadow: var(--shadow-sm);"
                           onfocus="this.style.borderColor='var(--brand-gold)'" 
                           onblur="this.style.borderColor='var(--border)'">
                </div>
            </div>

            <!-- Tab 1: Dana Masuk -->
            <div id="tab-masuk" class="tab-content {{ request('tab') == 'masuk' || !request('tab') ? 'active' : '' }}">
                <div class="table-container">
                    <table class="fintech-table">
                        <thead>
                            <tr>
                                <th>Deskripsi Transaksi</th>
                                <th>Sumber / Project</th>
                                <th class="right">Nominal Masuk</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publicDeposits as $index => $deposit)
                                <tr onclick="openModal('modal-deposit-{{ $index }}')">
                                    <td>
                                        <span class="t-primary">Penerimaan Dana</span>
                                        <span class="t-date">{{ $deposit->tanggal_setoran ? \Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td>{{ $deposit->proyek?->nama_proyek ?? 'Kas Internal' }}</td>
                                    <td class="right tabular-nums"><span class="badge bg-green">+ Rp {{ number_format($deposit->jumlah_setoran ?? 0, 0, ',', '.') }}</span></td>
                                    <td class="right"><i class="fa-solid fa-chevron-right action-arrow"></i></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; color: var(--text-tertiary); padding: 40px;">Tidak ada data masuk pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($publicDeposits, 'links'))
                <div class="pagination-container">
                    {{ $publicDeposits->fragment('laporan')->appends(['tab' => 'masuk'])->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

            <!-- Tab 2: Pengeluaran -->
            <div id="tab-keluar" class="tab-content {{ request('tab') == 'keluar' ? 'active' : '' }}">
                <div class="table-container">
                    <table class="fintech-table">
                        <thead>
                            <tr>
                                <th>Deskripsi Transaksi</th>
                                <th>Keperluan / Project</th>
                                <th class="right">Nominal Keluar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publicExpenses as $index => $expense)
                                <tr onclick="openModal('modal-expense-{{ $index }}')">
                                    <td>
                                        <span class="t-primary">Pencairan Dana</span>
                                        <span class="t-date">{{ $expense->tanggal ? \Carbon\Carbon::parse($expense->tanggal)->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td>{{ $expense->pengajuanDana?->proyek?->nama_proyek ?? 'Operasional Umum' }}</td>
                                    <td class="right tabular-nums"><span class="badge bg-red">- Rp {{ number_format($expense->jumlah ?? 0, 0, ',', '.') }}</span></td>
                                    <td class="right"><i class="fa-solid fa-chevron-right action-arrow"></i></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; color: var(--text-tertiary); padding: 40px;">Tidak ada pengeluaran pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($publicExpenses, 'links'))
                <div class="pagination-container">
                    {{ $publicExpenses->fragment('laporan')->appends(['tab' => 'keluar'])->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

            <!-- Tab 3: Project -->
            <div id="tab-project" class="tab-content {{ request('tab') == 'project' ? 'active' : '' }}">
                <div class="table-container">
                    <table class="fintech-table">
                        <thead>
                            <tr>
                                <th>Nama Project</th>
                                <th>Anggaran Disetujui</th>
                                <th class="right">Status Saldo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publicProjectFinance as $index => $project)
                                @php
                                    $projectExpense = $project->pengajuanDana->flatMap(function ($p) { return $p->transaksiDana; })->sum('jumlah');
                                    $projectDeposit = $project->setoranProyek->sum('jumlah_setoran');
                                    $projectBalance = $projectDeposit - $projectExpense;
                                @endphp
                                <tr onclick="openModal('modal-project-{{ $index }}')">
                                    <td>
                                        <span class="t-primary">{{ $project->nama_proyek }}</span>
                                        <span class="t-date">Monitoring Aktif</span>
                                    </td>
                                    <td class="tabular-nums">Rp {{ number_format($project->total_anggaran ?? 0, 0, ',', '.') }}</td>
                                    <td class="right tabular-nums">
                                        <span class="badge {{ $projectBalance > 0 ? 'bg-green' : 'bg-gray' }}">
                                            Sisa Rp {{ number_format($projectBalance, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="right"><i class="fa-solid fa-chevron-right action-arrow"></i></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; color: var(--text-tertiary); padding: 40px;">Tidak ada project aktif.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($publicProjectFinance, 'links'))
                <div class="pagination-container">
                    {{ $publicProjectFinance->fragment('laporan')->appends(['tab' => 'project'])->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>

        </div>
    </main>

    {{-- MODALS --}}
    @foreach($publicDeposits as $index => $deposit)
    <div class="modal-wrap" id="modal-deposit-{{ $index }}">
        <div class="receipt-card">
            <div class="receipt-header">
                <div class="r-icon-large icon-in"><i class="fa-solid fa-arrow-down"></i></div>
                <div class="receipt-title">Penerimaan Dana</div>
                <div class="receipt-amount tabular-nums">Rp {{ number_format($deposit->jumlah_setoran ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="receipt-body">
                <div class="r-row"><span class="r-lbl">ID Referensi</span><span class="r-val tabular-nums">#IN-{{ str_pad($deposit->id, 5, '0', STR_PAD_LEFT) }}</span></div>
                <div class="r-row"><span class="r-lbl">Tanggal</span><span class="r-val">{{ $deposit->tanggal_setoran ? \Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y, H:i') : '-' }}</span></div>
                <div class="r-row"><span class="r-lbl">Dialokasikan Ke</span><span class="r-val">{{ $deposit->proyek?->nama_proyek ?? 'Kas Perusahaan' }}</span></div>
                <div class="r-row" style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed var(--border);">
                    <span class="r-lbl">Status Transaksi</span>
                    <span class="r-val" style="color: var(--success);">Berhasil Selesai</span>
                </div>
            </div>
            <div class="receipt-footer"><button class="btn-close-modal" onclick="closeModal('modal-deposit-{{ $index }}')">Tutup Rincian</button></div>
        </div>
    </div>
    @endforeach

    @foreach($publicExpenses as $index => $expense)
    <div class="modal-wrap" id="modal-expense-{{ $index }}">
        <div class="receipt-card">
            <div class="receipt-header">
                <div class="r-icon-large icon-out"><i class="fa-solid fa-arrow-up"></i></div>
                <div class="receipt-title">Dana Keluar</div>
                <div class="receipt-amount tabular-nums">Rp {{ number_format($expense->jumlah ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="receipt-body">
                <div class="r-row"><span class="r-lbl">ID Referensi</span><span class="r-val tabular-nums">#OUT-{{ str_pad($expense->id, 5, '0', STR_PAD_LEFT) }}</span></div>
                <div class="r-row"><span class="r-lbl">Tanggal</span><span class="r-val">{{ $expense->tanggal ? \Carbon\Carbon::parse($expense->tanggal)->format('d M Y, H:i') : '-' }}</span></div>
                <div class="r-row"><span class="r-lbl">Tujuan / Project</span><span class="r-val">{{ $expense->pengajuanDana?->proyek?->nama_proyek ?? 'Operasional Umum' }}</span></div>
                <div class="r-row"><span class="r-lbl">Divisi Meminta</span><span class="r-val">{{ $expense->pengajuanDana?->divisi?->nama ?? '-' }}</span></div>
                <div class="r-row" style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed var(--border);">
                    <span class="r-lbl">Status Transaksi</span>
                    <span class="r-val" style="color: var(--success);">Selesai</span>
                </div>
            </div>
            <div class="receipt-footer"><button class="btn-close-modal" onclick="closeModal('modal-expense-{{ $index }}')">Tutup Rincian</button></div>
        </div>
    </div>
    @endforeach

    @foreach($publicProjectFinance as $index => $project)
        @php
            $projectExpense = $project->pengajuanDana->flatMap(function ($p) { return $p->transaksiDana; })->sum('jumlah');
            $projectDeposit = $project->setoranProyek->sum('jumlah_setoran');
            $projectBalance = $projectDeposit - $projectExpense;
        @endphp
    <div class="modal-wrap" id="modal-project-{{ $index }}">
        <div class="receipt-card" style="max-width: 460px;">
            <div class="receipt-header">
                <div class="r-icon-large icon-proj"><i class="fa-solid fa-folder-tree"></i></div>
                <div class="receipt-title">Sisa Saldo Project</div>
                <div class="receipt-amount tabular-nums">Rp {{ number_format($projectBalance, 0, ',', '.') }}</div>
            </div>
            <div class="receipt-body">
                <div class="r-row"><span class="r-lbl">Nama Project</span><span class="r-val">{{ $project->nama_proyek }}</span></div>
                <div class="r-row"><span class="r-lbl">Anggaran Disetujui</span><span class="r-val tabular-nums">Rp {{ number_format($project->total_anggaran ?? 0, 0, ',', '.') }}</span></div>
                <div class="r-row" style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed var(--border);">
                    <span class="r-lbl">Total Dana Masuk</span><span class="r-val tabular-nums" style="color: var(--success);">Rp {{ number_format($projectDeposit, 0, ',', '.') }}</span>
                </div>
                <div class="r-row">
                    <span class="r-lbl">Total Pengeluaran</span><span class="r-val tabular-nums" style="color: var(--danger);">- Rp {{ number_format($projectExpense, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="receipt-footer"><button class="btn-close-modal" onclick="closeModal('modal-project-{{ $index }}')">Tutup Rincian</button></div>
        </div>
    </div>
    @endforeach

    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}
    <script>
        // Mencegah browser melompat posisi scroll saat reload
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }

        const urlParamsCheck = new URLSearchParams(window.location.search);
        if (urlParamsCheck.has('page') || urlParamsCheck.has('tab') || window.location.hash === '#laporan') {
            document.documentElement.classList.add('is-loading');
        }

        // Navbar blur effect
        window.addEventListener("scroll", function() {
            const nav = document.querySelector(".public-navbar");
            if (window.scrollY > 50) {
                nav.classList.add("scrolled");
            } else {
                nav.classList.remove("scrolled");
            }
        });

        // Setup Initial Segment Highlight Position & Scroll Position
        window.addEventListener("DOMContentLoaded", () => {
            const activeBtn = document.querySelector('.segment-btn.active');
            if(activeBtn) updateHighlight(activeBtn);

            if (urlParamsCheck.has('page') || urlParamsCheck.has('tab') || window.location.hash === '#laporan') {
                const laporanSection = document.getElementById('laporan');
                if (laporanSection) {
                    window.scrollTo({
                        top: laporanSection.offsetTop - 80,
                        behavior: 'instant'
                    });
                }
            }

            // Inisialisasi Indikator Visual Aktif pada Filter Bulan & Tahun
            const filterSelects = document.querySelectorAll('.filter-select');
            filterSelects.forEach(select => {
                if (select.value !== "") {
                    select.classList.add('has-value');
                }
                select.addEventListener('change', function() {
                    if (this.value !== "") {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });

            setTimeout(() => {
                document.documentElement.classList.remove('is-loading');
            }, 50);
        });

        function updateHighlight(btn) {
            const highlight = document.getElementById('segmentHighlight');
            highlight.style.width = btn.offsetWidth + 'px';
            highlight.style.left = btn.offsetLeft + 'px';
        }

        // Tab Switching Logic
        function switchTab(evt, tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.segment-btn').forEach(btn => btn.classList.remove('active'));
            evt.currentTarget.classList.add('active');
            updateHighlight(evt.currentTarget);
        }

        window.addEventListener('resize', () => {
            const activeBtn = document.querySelector('.segment-btn.active');
            if(activeBtn) updateHighlight(activeBtn);
        });

        // Modal Logic
        function openModal(id) {
            document.getElementById(id).classList.add('show');
            document.body.style.overflow = 'hidden'; 
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        window.onclick = function(e) {
            if (e.target.classList.contains('modal-wrap')) {
                e.target.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        // Chart.js Configuration (Smooth Line Chart with Gradient Fill)
        document.addEventListener('DOMContentLoaded', function() {
            const chartDataRaw = @json($publicCashFlow);
            const incomeData = Object.values(chartDataRaw.income);
            const expenseData = Object.values(chartDataRaw.expense);
            const labels = chartDataRaw.labels;

            const ctx = document.getElementById('cashFlowChart').getContext('2d');
            
            const incomeGradient = ctx.createLinearGradient(0, 0, 0, 300);
            incomeGradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
            incomeGradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            const expenseGradient = ctx.createLinearGradient(0, 0, 0, 300);
            expenseGradient.addColorStop(0, 'rgba(220, 38, 38, 0.25)');
            expenseGradient.addColorStop(1, 'rgba(220, 38, 38, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { 
                            label: 'Pemasukan', 
                            data: incomeData, 
                            borderColor: '#3b82f6', 
                            backgroundColor: incomeGradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4,
                            fill: true
                        },
                        { 
                            label: 'Pengeluaran', 
                            data: expenseData, 
                            borderColor: '#dc2626', 
                            backgroundColor: expenseGradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#dc2626',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4, 
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { family: 'Inter', weight: 600, size: 11 } } },
                        tooltip: {
                            backgroundColor: '#0f172a', padding: 14, titleFont: { family: 'Inter', size: 12 },
                            bodyFont: { family: 'Inter', size: 13, weight: 'bold' }, cornerRadius: 8,
                            callbacks: {
                                label: function(context) { return context.dataset.label + ': Rp ' + (context.raw || 0).toLocaleString('id-ID'); }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, border: { display: false },
                            grid: { color: '#f1f5f9', drawTicks: false },
                            ticks: { 
                                font: { family: 'Inter', size: 11, weight: 600 }, 
                                color: '#94a3b8', 
                                padding: 12,
                                callback: function(value) { 
                                    if (value === 0) return '0';
                                    if (value < 1000000) {
                                        return (value / 1000).toLocaleString('id-ID') + ' Rb';
                                    }
                                    return (value / 1000000).toLocaleString('id-ID', { maximumFractionDigits: 1 }) + ' Jt'; 
                                }
                            }
                        },
                        x: { 
                            border: { display: false }, grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11, weight: 600 }, color: '#94a3b8' }
                        }
                    }
                }
            });
        });

        // Live Search
        const liveSearchInput = document.getElementById('liveSearchInput');
        if(liveSearchInput) {
            liveSearchInput.addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('.fintech-table tbody tr');

                rows.forEach(row => {
                    if(row.cells.length > 1) {
                        let textContent = row.textContent.toLowerCase();
                        row.style.display = textContent.includes(filter) ? '' : 'none';
                    }
                });
            });
        }

        // Counter-Up Animation
        document.addEventListener("DOMContentLoaded", () => {
            const counterElements = document.querySelectorAll('.summary-value, .stat-value');
            
            counterElements.forEach(el => {
                const originalText = el.innerText;
                const rawNumberString = originalText.replace(/[^0-9]/g, '');
                const targetNumber = parseInt(rawNumberString, 10);
                
                if (isNaN(targetNumber) || targetNumber === 0) return;

                const hasRp = originalText.includes('Rp');
                const hasAktif = originalText.includes('Aktif');

                let currentNumber = 0;
                const duration = 1200;
                const frameRate = 30;
                const totalFrames = Math.round(duration / frameRate);
                const increment = targetNumber / totalFrames;

                const counter = setInterval(() => {
                    currentNumber += increment;
                    
                    if (currentNumber >= targetNumber) {
                        currentNumber = targetNumber;
                        clearInterval(counter);
                        el.innerText = originalText; 
                    } else {
                        let formattedNum = Math.floor(currentNumber).toLocaleString('id-ID');
                        
                        if (hasRp) {
                            el.innerText = 'Rp ' + formattedNum;
                        } else if (hasAktif) {
                            el.innerText = formattedNum + ' Aktif';
                        } else {
                            el.innerText = formattedNum;
                        }
                    }
                }, frameRate);
            });
        });
    </script>
</body>
</html>