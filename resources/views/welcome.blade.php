<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Eksplorasi Banua | Financial Management System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =========================================================
           SWEETALERT CUSTOM STYLING
        ========================================================= */
        .swal2-container {
            z-index: 99999 !important;
        }

        .swal-custom-popup {
            border-radius: 20px !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2) !important;
        }

        /* =========================================================
           ROOT & BASE
        ========================================================= */
        :root {
            --primary: #6b4f1d;
            --gold: #a67c2e;
            --gold-light: #d7b787;
            --dark: #0f172a;
            --white: #ffffff;
            --soft: #f8f3e8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: var(--soft);
            color: var(--dark);
        }

        /* =========================================================
           NAVBAR (DENGAN HAMBURGER UNTUK MOBILE)
        ========================================================= */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 70px;
            color: var(--white);
            z-index: 9999;
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--white);
            min-width: 0;
        }

        .brand img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: contain;
            background: var(--white);
            padding: 4px;
            flex-shrink: 0;
        }

        .brand-text {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-text span {
            display: block;
            font-size: 11px;
            color: var(--gold-light);
            font-weight: 400;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .nav-menu a {
            color: var(--white);
            text-decoration: none;
            font-size: 13px;
            opacity: 0.8;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-menu a:hover {
            opacity: 1;
            color: var(--gold-light);
        }

        .nav-menu .nav-active {
            opacity: 1;
            color: var(--gold-light);
            font-weight: 700;
        }

        /* Tombol Hamburger Mobile */
        .mobile-menu-toggle {
            display: none;
            font-size: 22px;
            color: var(--white);
            cursor: pointer;
            padding: 8px;
            z-index: 10001;
        }

        /* Tombol Masuk Navbar */
        .nav-login-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            color: var(--white) !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(107, 79, 29, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1 !important;
        }

        .nav-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(166, 124, 46, 0.6);
            background: linear-gradient(135deg, #7c5c22, #b88a33);
        }

        /* Media Query Navbar Mobile Berstandar Overlay */
        @media (max-width: 900px) {
            .navbar {
                padding: 0 24px !important;
                height: 70px !important;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .nav-menu {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(15, 23, 42, 0.98);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 16px;
                padding: 40px 20px;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
                z-index: 99998;
            }

            .nav-menu.show {
                opacity: 1;
                pointer-events: auto;
            }

            .nav-menu a {
                font-size: 15px !important;
                font-weight: 600 !important;
                color: #cbd5e1 !important;
                padding: 12px 24px;
                border-radius: 12px;
                width: 80%;
                max-width: 280px;
                text-align: center;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.06);
                transition: 0.2s;
            }

            .nav-menu a:hover,
            .nav-menu .nav-active {
                color: #fff !important;
                background: rgba(166, 124, 46, 0.2);
                border-color: rgba(166, 124, 46, 0.4);
            }

            .nav-login-btn {
                width: 80% !important;
                max-width: 280px !important;
            }
        }

        /* =========================================================
           HERO SECTION
        ========================================================= */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 130px 80px 80px;
            color: var(--white);
            background: linear-gradient(90deg, rgba(15, 23, 42, 0.94), rgba(15, 23, 42, 0.75)),
                        url('{{ asset("images/company-bg.png") }}');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            position: relative;
        }

        .hero-left {
            width: 55%;
            position: relative;
            z-index: 2;
        }

        .logo-box {
            width: 110px;
            height: 110px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            margin-bottom: 25px;
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .company {
            font-size: 46px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
        }

        .company span {
            color: var(--gold-light);
        }

        .system {
            margin-top: 18px;
            font-size: 21px;
            font-weight: 600;
            color: var(--soft);
        }

        .description {
            margin-top: 20px;
            font-size: 15px;
            line-height: 1.8;
            color: #cbd5e1;
            max-width: 500px;
        }

        .btn-login {
            margin-top: 35px;
            display: inline-block;
            padding: 18px 75px;
            font-size: 15px;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            color: var(--white);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            box-shadow: 0 20px 40px rgba(107, 79, 29, 0.4);
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(107, 79, 29, 0.5);
        }

        .status {
            margin-top: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 15px #22c55e;
        }

        /* HERO FEATURES */
        .features {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        .feature {
            width: 170px;
            padding: 22px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
        }

        .feature-icon {
            font-size: 25px;
        }

        .feature-title {
            margin-top: 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .feature-text {
            margin-top: 5px;
            font-size: 11px;
            color: #cbd5e1;
        }

        /* HERO RIGHT PANEL */
        .hero-right {
            width: 45%;
            display: flex;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .dashboard-preview {
            width: 390px;
            padding: 25px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            animation: floating 5s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .preview-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .preview-card {
            background: var(--white);
            color: #334155;
            padding: 18px;
            border-radius: 15px;
            margin-bottom: 12px;
        }

        .preview-label {
            font-size: 12px;
            color: #64748b;
        }

        .preview-value {
            font-size: 25px;
            font-weight: 800;
            color: var(--primary);
        }

        /* =========================================================
           SYSTEM SECTION
        ========================================================= */
        .system-section {
            padding: 90px 70px;
            background: var(--soft);
            color: #1e293b;
            min-height: 500px;
            position: relative;
            overflow: hidden;
        }

        .system-section::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--gold-light);
            opacity: 0.15;
            border-radius: 50%;
            top: -100px;
            right: -100px;
            filter: blur(80px);
        }

        .system-container {
            max-width: 1100px;
            margin: auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .section-label {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 3px;
            color: var(--gold);
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .system-container h2 {
            font-size: 35px;
            color: var(--primary);
            font-weight: 800;
        }

        .section-desc {
            max-width: 700px;
            margin: 15px auto 20px;
            line-height: 1.8;
            color: #64748b;
            font-size: 15px;
        }

        .system-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 45px;
        }

        .system-card {
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: 0.35s;
        }

        .system-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gold);
        }

        .system-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.1);
        }

        .system-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .system-card h3 {
            margin-bottom: 12px;
            color: var(--primary);
            font-size: 18px;
            font-weight: 700;
        }

        .system-card p {
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 12px;
            color: #64748b;
        }

        .system-card ul {
            padding-left: 18px;
            margin-top: 10px;
        }

        .system-card li {
            font-size: 13px;
            line-height: 1.7;
            color: #334155;
        }

        /* =========================================================
           ENTERPRISE MODERN LOGIN MODAL
        ========================================================= */
        .login-overlay {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.4); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s cubic-bezier(0.32, 0.72, 0, 1);
            z-index: 10000;
        }

        .login-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .login-box {
            width: 900px;
            min-height: 520px;
            display: flex;
            background: var(--white);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
            margin: 20px;
            position: relative;
            opacity: 0;
            transform: scale(0.96) translateY(20px);
            transition: all 0.6s cubic-bezier(0.32, 0.72, 0, 1);
        }

        .login-overlay.show .login-box {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* MODAL KIRI */
        .login-left {
            flex: 0 0 42%;
            position: relative;
            background: url('{{ asset("images/company-bg.png") }}') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(107, 79, 29, 0.85) 100%);
            z-index: 1;
        }

        .login-content-left {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            padding: 40px;
        }

        .login-logo {
            width: 100px;
            height: 100px;
            background: var(--white);
            padding: 12px;
            border-radius: 50%;
            margin-bottom: 25px;
            object-fit: contain;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            transition: transform 0.4s ease;
        }

        .login-left:hover .login-logo {
            transform: translateY(-5px);
        }

        .login-company {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .login-divider {
            width: 40px;
            height: 3px;
            background: var(--gold);
            margin: 15px auto;
            border-radius: 10px;
        }

        .login-content-left p {
            font-size: 14px;
            color: #e2e8f0;
            line-height: 1.6;
            font-weight: 400;
        }

        /* MODAL KANAN */
        .login-right {
            flex: 1;
            background: var(--white);
            padding: 60px 70px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* FIX TOMBOL CLOSE LOGIN MOBILE & DESKTOP */
        .modal-close-btn {
            position: absolute !important;
            top: 18px !important;
            right: 18px !important;
            width: 42px !important;
            height: 42px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            outline: none !important;
            border-radius: 50% !important;
            background: rgba(15, 23, 42, 0.08) !important;
            color: #172033 !important;
            font-size: 18px !important;
            cursor: pointer !important;
            z-index: 99999 !important;
            pointer-events: auto !important;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            transition: all 0.3s ease;
        }

        .modal-close-btn i {
            pointer-events: none !important;
        }

        .modal-close-btn:hover {
            background: rgba(15, 23, 42, 0.14) !important;
            transform: rotate(90deg);
        }

        .modal-close-btn:active {
            transform: scale(0.94);
        }

        .login-right-inner {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.7s cubic-bezier(0.32, 0.72, 0, 1) 0.1s;
        }

        .login-overlay.show .login-right-inner {
            opacity: 1;
            transform: translateY(0);
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h2 {
            font-size: 30px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .login-header p {
            font-size: 14px;
            color: #64748b;
        }

        /* FLOATING LABELS INPUT */
        .form-floating {
            position: relative;
            margin-bottom: 22px;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            transition: 0.3s ease;
            z-index: 2;
        }

        .form-floating input {
            width: 100%;
            height: 62px;
            border-radius: 16px;
            border: 2px solid transparent;
            background: #f8fafc;
            padding: 24px 20px 8px 52px; 
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            transition: all 0.3s ease;
        }

        .form-floating label {
            position: absolute;
            left: 52px;
            top: 22px;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
            pointer-events: none;
            transform-origin: left top;
        }

        .form-floating input:focus ~ label,
        .form-floating input:not(:placeholder-shown) ~ label {
            transform: translateY(-12px) scale(0.85);
            color: var(--gold);
            font-weight: 700;
        }

        .form-floating input:focus {
            outline: none;
            background: var(--white);
            border-color: var(--gold);
            box-shadow: 0 4px 15px rgba(166, 124, 46, 0.1);
        }

        .form-floating input:focus ~ .input-icon {
            color: var(--gold);
        }

        .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 16px;
            transition: 0.3s;
            z-index: 3;
        }

        .toggle-password:hover {
            color: var(--gold);
        }

        /* OPSI BAWAH FORM */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            position: relative;
            z-index: 99;
            pointer-events: auto;
        }

        .custom-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
        }

        .custom-checkbox-wrapper input {
            width: 16px;
            height: 16px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            transition: 0.3s;
            cursor: pointer;
        }

        .forgot-link:hover {
            color: var(--gold);
        }

        /* SHIMMER BUTTON */
        .submit-btn-shimmer {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 56px;
            border-radius: 14px;
            border: none;
            background: var(--primary);
            color: var(--white);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(107, 79, 29, 0.3);
            transition: all 0.3s ease;
        }

        .submit-btn-shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-20deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -150%; }
            50%, 100% { left: 150%; }
        }

        .submit-btn-shimmer:hover {
            background: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(166, 124, 46, 0.4);
        }

        .submit-btn-shimmer i {
            transition: transform 0.3s ease;
        }

        .submit-btn-shimmer:hover i {
            transform: translateX(4px);
        }

        /* =========================================================
           RESPONSIVE FIXES (NAVBAR & MODAL MOBILE)
        ========================================================= */
        @media (max-width: 900px) {
            .hero {
                padding: 120px 30px 60px;
                background-attachment: scroll;
            }
            .hero-left {
                width: 100%;
            }
            .hero-right {
                display: none;
            }
            .system-grid {
                grid-template-columns: 1fr;
            }
            .system-section {
                scroll-margin-top: 80px;
                padding: 70px 30px;
            }
            
            /* KODE CSS NAVBAR YANG BERTABRAKAN TELAH DIHAPUS DI SINI */

            .company {
                font-size: 36px;
            }
            .features {
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            .hero {
                padding: 100px 20px 50px;
                align-items: flex-start;
            }
            .logo-box {
                width: 85px;
                height: 85px;
                margin-bottom: 20px;
            }
            .company {
                font-size: 29px;
            }
            .system {
                font-size: 17px;
            }
            .description {
                font-size: 13px;
            }
            .btn-login {
                width: 100%;
                text-align: center;
                padding: 15px 20px;
                margin-top: 25px;
                font-size: 14px;
            }
            .system-section {
                padding: 60px 18px;
            }
            .system-container h2 {
                font-size: 25px;
            }
            
            /* Responsive Modal Login */
            .login-overlay {
                padding: 15px;
            }
            .login-box {
                width: 100%;
                max-width: 420px;
                height: auto;
                min-height: 0;
                flex-direction: column;
                border-radius: 20px;
            }
            .login-left {
                width: 100%;
                min-height: 170px;
                padding: 25px 15px;
            }
            .login-logo {
                width: 75px;
                height: 75px;
                margin-bottom: 10px;
            }
            .login-company {
                font-size: 17px;
            }
            .login-right {
                width: 100%;
                padding: 25px 20px 20px;
            }
            .login-right h2 {
                font-size: 23px;
                margin-bottom: 8px;
            }
            .modal-close-btn {
                top: 12px !important;
                right: 12px !important;
                width: 40px !important;
                height: 40px !important;
            }
        }

        /* Tombol Back to Top Melayang */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 10px 25px rgba(107, 79, 29, 0.4);
            cursor: pointer;
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-to-top.show-btn {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(166, 124, 46, 0.6);
        }
    </style>
</head>

<body id="home">
<!-- Tombol Kembali ke Atas -->
    <div class="back-to-top" id="backToTopBtn" onclick="goHome()" title="Kembali ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <a href="#" onclick="goHome(); return false;" class="brand">
            <img src="{{ asset('images/logo-cv.png') }}" alt="Logo Sahabat Eksplorasi Banua">
            <div class="brand-text">
                Sahabat Eksplorasi Banua
                <span>Sistem Manajemen Keuangan</span>
            </div>
        </a>

        <!-- Tombol Hamburger Mobile -->
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <i class="fa-solid fa-bars" id="menuIcon"></i>
        </div>

        <div class="nav-menu" id="navMenu">
            <a href="#" onclick="goHome(); closeMobileMenu(); return false;" class="nav-active">Beranda</a>
            <a href="#system" onclick="goSystem(); closeMobileMenu(); return false;">Fitur Sistem</a>
            <a href="{{ route('public.finance') }}" onclick="closeMobileMenu()">Keuangan</a>
            
            <a href="javascript:void(0)" onclick="openLogin(); closeMobileMenu();" class="nav-login-btn">
                Masuk <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-left">
            <div class="logo-box">
                <img src="{{ asset('images/logo-cv.png') }}" alt="Logo">
            </div>

            <h1 class="company">Sahabat Eksplorasi<span>Banua</span></h1>
            <div class="system">Sistem Manajemen Keuangan & Proyek</div>
            <div class="description">
                Platform digital perusahaan untuk mengelola proyek,
                keuangan, persetujuan dana, dan aktivitas operasional
                secara terintegrasi dalam satu sistem.
            </div>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">📁</div>
                    <div class="feature-title">Manajemen Proyek</div>
                    <div class="feature-text">Pemantauan proyek perusahaan</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">💰</div>
                    <div class="feature-title">Kontrol Keuangan</div>
                    <div class="feature-text">Transaksi dan laporan keuangan</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">👥</div>
                    <div class="feature-title">Hak Akses Pengguna</div>
                    <div class="feature-text">Pengaturan akses pengguna</div>
                </div>
            </div>

            <button class="btn-login" onclick="openLogin()">Masuk Ke Sistem</button>

            <div class="status">
                <div class="status-dot"></div>
                Sistem Berjalan Normal
            </div>
        </div>

<div class="hero-right">
            <div class="dashboard-preview">
                <div class="preview-title">Ringkasan Sistem</div>
                <div class="preview-card">
                    <div class="preview-label">Pemantauan Keuangan</div>
                    <div class="preview-value">Aktif</div>
                </div>
               <div class="preview-card">
                    <div class="preview-label">Proyek Aktif</div>
                    <!-- Nilai diambil otomatis dari database, dengan fallback angka 137 jika kosong -->
                    <div class="preview-value" data-target="{{ $totalProyek ?? 137 }}">0</div>
                </div>
                <div class="preview-card">
                    <div class="preview-label">Status Sistem</div>
                    <div class="preview-value">Terhubung</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SYSTEM SECTION -->
    <section class="system-section" id="system">
        <div class="system-container">
            <div class="section-label">FITUR SISTEM</div>
            <h2>Platform Manajemen Perusahaan Terintegrasi</h2>
            <p class="section-desc">
                Sistem digital perusahaan yang membantu pengelolaan
                proyek, keuangan, pengguna, dan laporan operasional
                secara terintegrasi.
            </p>

            <div class="system-grid">
                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-folder-open"></i></div>
                    <h3>Project Management</h3>
                    <p>Mengelola data project perusahaan, monitoring aktivitas pekerjaan, dan melihat perkembangan project secara real-time.</p>
                    <ul>
                        <li>Data project</li>
                        <li>Monitoring progres</li>
                        <li>Manajemen divisi</li>
                    </ul>
                </div>

                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-wallet"></i></div>
                    <h3>Financial Management</h3>
                    <p>Mengelola transaksi keuangan perusahaan mulai dari pemasukan, pengeluaran, hingga saldo keuangan.</p>
                    <ul>
                        <li>Pembayaran masuk</li>
                        <li>Pengeluaran dana</li>
                        <li>Laporan keuangan</li>
                    </ul>
                </div>

                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-check-double"></i></div>
                    <h3>Approval Workflow</h3>
                    <p>Mendukung proses persetujuan dana secara terstruktur berdasarkan hak akses pengguna.</p>
                    <ul>
                        <li>Pengajuan dana</li>
                        <li>Approval keuangan</li>
                        <li>Riwayat persetujuan</li>
                    </ul>
                </div>

                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-building-columns"></i></div>
                    <h3>Bank Monitoring</h3>
                    <p>Melakukan monitoring rekening bank dan ketersediaan saldo perusahaan.</p>
                    <ul>
                        <li>Multi rekening</li>
                        <li>Saldo bank</li>
                        <li>Status rekening</li>
                    </ul>
                </div>

                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-users-gear"></i></div>
                    <h3>Role Management</h3>
                    <p>Mengatur akses sistem berdasarkan peran pengguna agar keamanan data terjaga.</p>
                    <ul>
                        <li>Admin</li>
                        <li>Keuangan</li>
                        <li>Karyawan</li>
                    </ul>
                </div>

                <div class="system-card">
                    <div class="system-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <h3>Reporting System</h3>
                    <p>Menyediakan laporan yang informatif dengan export data untuk kebutuhan perusahaan.</p>
                    <ul>
                        <li>Dashboard laporan</li>
                        <li>Export Excel</li>
                        <li>Analisis data</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- LOGIN MODAL -->
    <div class="login-overlay" id="login">
        <div class="login-box">
            <!-- MODAL KIRI -->
            <div class="login-left">
                <div class="login-left-overlay"></div>
                <div class="login-content-left">
                    <img src="{{ asset('images/logo-cv.png') }}" class="login-logo" alt="Logo">
                    <div class="login-company">Sahabat Eksplorasi Banua</div>
                    <div class="login-divider"></div>
                    <p>Sistem Manajemen Keuangan & Proyek</p>
                </div>
            </div>

            <!-- MODAL KANAN -->
            <div class="login-right">
                <button type="button" class="modal-close-btn" onclick="closeLogin()" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="login-right-inner">
                    <div class="login-header">
                        <h2>Masuk ke Portal</h2>
                        <p>Selamat datang kembali! Silakan masuk ke akun Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="modern-form">
                        @csrf

                        @if ($errors->any())
                            <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #dc2626; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 22px; display: flex; align-items: center; gap: 10px; animation: fadeIn 0.3s ease;">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size: 16px; flex-shrink: 0;"></i>
                                <span>Email atau kata sandi yang Anda masukkan salah. Silakan periksa kembali.</span>
                            </div>
                        @endif
                        
                        <div class="form-floating">
                            <i class="fa-regular fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" required placeholder=" ">
                            <label for="email">Email Perusahaan</label>
                        </div>
                        
                        <div class="form-floating">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" required placeholder=" ">
                            <label for="password">Kata Sandi</label>
                            <span class="toggle-password" onclick="togglePassword()">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>

                        <div class="login-options">
                            <label class="custom-checkbox-wrapper">
                                <input type="checkbox" name="remember">
                                Ingat Sesi Saya
                            </label>
                            
                            <span onclick="showForgotAlert()" class="forgot-link">
                                Lupa Sandi?
                            </span>
                        </div>

                        <button type="submit" class="submit-btn-shimmer">
                            <span>MASUK KE SISTEM</span>
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </button>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openLogin() {
            document.getElementById('login').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLogin() {
            document.getElementById('login').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function goSystem() {
            document.getElementById('system').scrollIntoView({ behavior: 'smooth' });
            history.pushState("", document.title, window.location.pathname);
        }

        function goHome() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            history.pushState("", document.title, window.location.pathname);
        }

        window.addEventListener("scroll", function() {
            const nav = document.getElementById("navbar");
            if (window.scrollY > 50) {
                nav.style.background = "rgba(15, 23, 42, 0.85)";
            } else {
                nav.style.background = "rgba(15, 23, 42, 0.35)";
            }
        });

        window.addEventListener("load", function() {
            if (window.location.hash) {
                history.replaceState(null, null, window.location.pathname);
                window.scrollTo(0, 0);
            }
        });

        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.querySelector(".toggle-password i");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function showForgotAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Akses Terkunci',
                html: 'Mohon segera lapor ke <b>Administrator</b> atau <b>Tim IT</b> untuk melakukan reset kata sandi Anda.',
                confirmButtonText: 'Baik, Mengerti',
                confirmButtonColor: '#a67c2e',
                background: '#ffffff',
                color: '#0f172a',
                iconColor: '#a67c2e',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        }

        // Toggle Hamburger Menu Mobile
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            const menuIcon = document.getElementById('menuIcon');
            
            navMenu.classList.toggle('show');
            
            if (navMenu.classList.contains('show')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');
                document.body.style.overflow = 'hidden';
            } else {
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
                document.body.style.overflow = 'auto';
            }
        }

        function closeMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            const menuIcon = document.getElementById('menuIcon');
            
            navMenu.classList.remove('show');
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
            document.body.style.overflow = 'auto';
        }

        // Efek loading saat form dikirim
        document.querySelector('.modern-form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email && password) {
                e.preventDefault(); 
                const btn = this.querySelector('.submit-btn-shimmer');
                const span = btn.querySelector('span');
                
                span.innerHTML = 'MEMPROSES... <i class="fa-solid fa-spinner fa-spin"></i>';
                btn.style.opacity = '0.8';
                btn.style.pointerEvents = 'none'; 

                setTimeout(() => {
                    this.submit();
                }, 450);
            }
        });

       // Efek Counter Animation untuk Angka Proyek Aktif (Dinamis)
        document.addEventListener("DOMContentLoaded", () => {
            const counterElement = document.querySelector('.preview-value[data-target]');
            if (!counterElement) return;

            const target = +counterElement.getAttribute('data-target');
            let count = 0;
            
            const speed = target > 100 ? 40 : 200; 

            const updateCount = () => {
                const increment = Math.ceil(target / 50); 
                count += increment;

                if (count < target) {
                    counterElement.innerText = count;
                    setTimeout(updateCount, 25);
                } else {
                    counterElement.innerText = target; 
                }
            };

            updateCount();
        });

        // Otomatis buka modal login kembali jika ada pesan error dari Laravel
        @if ($errors->any())
            window.addEventListener("DOMContentLoaded", () => {
                openLogin();
            });
        @endif

        // Munculkan atau sembunyikan tombol Back to Top berdasarkan posisi scroll
        window.addEventListener("scroll", function() {
            const backToTopBtn = document.getElementById("backToTopBtn");
            if (window.scrollY > 300) {
                backToTopBtn.classList.add("show-btn");
            } else {
                backToTopBtn.classList.remove("show-btn");
            }
        });
    </script>
</body>
</html>