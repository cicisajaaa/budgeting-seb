@extends('layouts.dashboard')

@section('content')
<style>
    .profile-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 30px;
    }

    /* HERO */
    .profile-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        border-radius: 20px;
        padding: 30px 34px;
        margin-bottom: 24px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .12);
    }

    .profile-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -70px;
        top: -100px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }

    .profile-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .profile-avatar {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 27px;
    }

    .profile-hero-text h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -.4px;
    }

    .profile-hero-text p {
        margin: 6px 0 0;
        color: rgba(255,255,255,.72);
        font-size: 14px;
    }

    .profile-email {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 9px;
        color: rgba(255,255,255,.62);
        font-size: 12px;
    }

    /* GRID */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .profile-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 26px;
        box-shadow: 0 5px 18px rgba(15,23,42,.045);
    }

    .profile-card.full-width {
        grid-column: 1 / -1;
    }

    /* CARD HEADER */
    .profile-card-header {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 1px solid #eef0f3;
    }

    .profile-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
    }

    .profile-card-title {
        margin: 0;
        color: #111827;
        font-size: 17px;
        font-weight: 700;
    }

    .profile-card-description {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
    }

    /* FORM */
    .profile-form {
        width: 100%;
        max-width: 100%;
    }

    .profile-form section {
        width: 100%;
    }

    /* Hilangkan heading Breeze karena sudah dibuat oleh card */
    .profile-form section > header {
        display: none;
    }

    .profile-form form {
        margin-top: 0 !important;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .profile-form form > div {
        margin-bottom: 16px;
    }

    .profile-form label {
        display: block;
        margin-bottom: 7px;
        color: #374151 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
    }

    .profile-form input[type="text"],
    .profile-form input[type="email"],
    .profile-form input[type="password"] {
        display: block;
        width: 100% !important;
        height: 44px;
        min-height: 44px;
        padding: 0 13px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 10px !important;
        background: #fff !important;
        color: #111827 !important;
        font-size: 13px !important;
        outline: none !important;
        box-shadow: none !important;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .profile-form input:focus {
        border-color: #64748b !important;
        box-shadow: 0 0 0 3px rgba(100,116,139,.12) !important;
    }

    .profile-form input::placeholder {
        color: #9ca3af;
    }

    /* BUTTON */
    .profile-form form > div:last-child {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .profile-form button[type="submit"] {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 92px;
        min-height: 40px;
        padding: 9px 18px !important;
        border: 0 !important;
        border-radius: 9px !important;
        background: #1f2937 !important;
        color: #fff !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        cursor: pointer;
        box-shadow: none !important;
        transition: background .2s ease, transform .15s ease;
    }

    .profile-form button[type="submit"]:hover {
        background: #111827 !important;
        transform: translateY(-1px);
    }

    /* SAVED */
    .profile-form p.text-sm {
        font-size: 12px !important;
    }

    /* ERROR */
    .profile-form [role="alert"],
    .profile-form .text-red-600,
    .profile-form .text-red-500 {
        color: #dc2626 !important;
        font-size: 12px !important;
        margin-top: 5px;
    }

    /* DELETE */
    .delete-card {
        border-color: #fecaca;
    }

    .delete-card .profile-icon {
        background: #fef2f2;
        color: #b91c1c;
    }

    .delete-card .profile-card-title {
        color: #991b1b;
    }

    .delete-card button[type="submit"] {
        background: #dc2626 !important;
    }

    .delete-card button[type="submit"]:hover {
        background: #b91c1c !important;
    }

    /* INFO */
    .profile-info-strip {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    /* MOBILE */
    @media (max-width: 900px) {
        .profile-page {
            padding: 24px 20px;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-card.full-width {
            grid-column: auto;
        }
    }

    @media (max-width: 650px) {
        .profile-page {
            padding: 18px 14px;
        }

        .profile-hero {
            padding: 23px 20px;
            border-radius: 16px;
        }

        .profile-avatar {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            font-size: 21px;
        }

        .profile-hero-text h1 {
            font-size: 21px;
        }

        .profile-hero-text p {
            font-size: 12px;
        }

        .profile-grid {
            gap: 15px;
        }

        .profile-card {
            padding: 20px 16px;
            border-radius: 15px;
        }

        .profile-card-header {
            gap: 11px;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .profile-icon {
            width: 39px;
            height: 39px;
            border-radius: 10px;
            font-size: 15px;
        }

        .profile-card-title {
            font-size: 15px;
        }

        .profile-card-description {
            font-size: 12px;
        }

        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="password"] {
            height: 42px;
            min-height: 42px;
        }
    }

    @media (max-width: 420px) {
        .profile-page {
            padding: 14px 10px;
        }

        .profile-hero {
            padding: 20px 16px;
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            font-size: 19px;
        }

        .profile-hero-text h1 {
            font-size: 19px;
        }

        .profile-card {
            padding: 18px 14px;
        }

        .profile-form button[type="submit"] {
            width: 100%;
        }

        .profile-form form > div:last-child {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="profile-page">

    {{-- =========================
         PROFILE HERO
    ========================== --}}
    <div class="profile-hero">
        <div class="profile-hero-content">

            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>

            <div class="profile-hero-text">
                <h1>Profil Pengguna</h1>

                <p>
                    Kelola informasi akun dan keamanan pengguna.
                </p>

                <div class="profile-email">
                    <i class="fas fa-envelope"></i>
                    {{ auth()->user()->email }}
                </div>
            </div>

        </div>
    </div>


    {{-- =========================
         PROFILE GRID
    ========================== --}}
    <div class="profile-grid">

        {{-- INFORMASI PROFIL --}}
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


        {{-- KEAMANAN PASSWORD --}}
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


        {{-- HAPUS AKUN --}}
        <div class="profile-card delete-card full-width">

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


    {{-- INFO --}}
    <div class="profile-info-strip">
        <i class="fas fa-info-circle"></i>

        <span>
            Pastikan informasi akun dan password Anda selalu diperbarui
            untuk menjaga keamanan akses ke sistem.
        </span>
    </div>

</div>

@endsection