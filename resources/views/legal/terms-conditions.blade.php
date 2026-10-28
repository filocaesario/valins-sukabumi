<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>
    <meta name="description" content="Ketentuan resmi hak akses, tanggung jawab teknisi lapangan, analis NOC, standar input ODP, dan pakta integritas PT Telkom Akses Witel Sukabumi.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Tailwind CSS via Vite & Fallback CDN -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#bc0007",
                        "primary-dark": "#960005",
                        "primary-container": "#e2241d",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#ffdad5",
                        secondary: "#565e74",
                        "secondary-container": "#dae2fd",
                        "on-secondary-container": "#131b2e",
                        tertiary: "#00628d",
                        "tertiary-container": "#007cb1",
                        "on-tertiary": "#ffffff",
                        background: "#f8f9ff",
                        surface: "#f8f9ff",
                        "on-surface": "#0b1c30",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "surface-container": "#e5eeff",
                        "surface-container-high": "#dce9ff",
                        "surface-container-highest": "#d3e4fe",
                        "outline-variant": "#e2e8f0",
                        error: "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        headline: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                        telemetry: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
            color: #0b1c30;
        }

        .font-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-telemetry {
            font-family: 'JetBrains Mono', monospace;
        }

        /* ================= HEADER INTERACTIVE POLISH (EXACT AS LANDING PAGE) ================= */
        /* Dynamic Nav Link Styling - Frameless with Glowing Animated Underline */
        .nav-link-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.8rem;
            font-size: 0.865rem;
            font-weight: 600;
            color: #475569; /* text-slate-600 */
            background-color: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            transition: color 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), text-shadow 0.22s ease;
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            letter-spacing: -0.01em;
        }
        /* Dynamic Smooth Interactive Underline Indicator */
        .nav-link-item::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 0.8rem;
            right: 0.8rem;
            height: 2.5px;
            background: linear-gradient(90deg, #e0000a 0%, #bc0007 50%, #960005 100%);
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: center;
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.35s ease, box-shadow 0.30s ease;
            pointer-events: none;
        }

        /* Hover State: Red line immediately emerges, closes smoothly on leave */
        .nav-link-item:hover {
            color: #bc0007;
            transform: translateY(-1.5px);
            text-shadow: 0 0 12px rgba(188, 0, 7, 0.18);
        }
        .nav-link-item:hover::after {
            transform: scaleX(1);
            opacity: 1;
            box-shadow: 0 2px 8px rgba(188, 0, 7, 0.45), 0 0 10px rgba(224, 0, 10, 0.25);
            transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease, box-shadow 0.24s ease;
        }

        /* Click State: Tactile press feedback */
        .nav-link-item:active {
            transform: translateY(0.5px) scale(0.97);
            transition-duration: 0.08s;
        }

        /* Active State: Clicked/current menu line remains permanently open and visible */
        .nav-link-item.active {
            color: #bc0007;
            font-weight: 700;
            text-shadow: 0 0 16px rgba(188, 0, 7, 0.22);
        }
        .nav-link-item.active::after,
        .nav-link-item.active:hover::after {
            transform: scaleX(1) !important;
            opacity: 1 !important;
            box-shadow: 0 2px 8px rgba(188, 0, 7, 0.5), 0 0 12px rgba(224, 0, 10, 0.3) !important;
        }

        /* Action Button: Masuk (Secondary Bordered) */
        .btn-header-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b; /* slate-800 */
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1; /* slate-300 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
        }
        .btn-header-login:hover {
            color: #bc0007;
            border-color: #fca5a5; /* red-300 */
            background-color: #fff8f8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px -2px rgba(188, 0, 7, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .btn-header-login:active {
            transform: translateY(0.5px) scale(0.96);
            background-color: #fee2e2;
            border-color: #f87171;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition-duration: 0.08s;
        }
        .btn-header-login .btn-login-icon {
            color: #64748b;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), color 0.22s ease;
        }
        .btn-header-login:hover .btn-login-icon {
            color: #bc0007;
            transform: translateX(3px);
        }
        .btn-header-login:active .btn-login-icon {
            transform: translateX(1px);
        }

        /* Action Button: Daftar Akun (Primary High Impact) */
        .btn-header-register {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff !important;
            background: linear-gradient(135deg, #d30009 0%, #bc0007 50%, #9e0006 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px -1px rgba(188, 0, 7, 0.4), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.24s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            overflow: hidden;
        }
        .btn-header-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.5s ease-in-out;
            pointer-events: none;
        }
        .btn-header-register:hover {
            background: linear-gradient(135deg, #e3000a 0%, #c90008 50%, #a60006 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px -3px rgba(188, 0, 7, 0.55), 0 4px 10px -2px rgba(188, 0, 7, 0.35);
        }
        .btn-header-register:hover::before {
            left: 100%;
        }
        .btn-header-register:active {
            transform: translateY(0.5px) scale(0.96);
            box-shadow: 0 2px 6px rgba(188, 0, 7, 0.45);
            transition-duration: 0.08s;
        }
        .btn-header-register .btn-register-icon {
            color: #ffffff;
            transition: transform 0.24s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-header-register:hover .btn-register-icon {
            transform: scale(1.2) rotate(-5deg);
        }
        .btn-header-register:active .btn-register-icon {
            transform: scale(0.95);
        }

        /* Action Button: Dashboard (Authenticated) */
        .btn-header-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff !important;
            background: linear-gradient(135deg, #bc0007 0%, #960005 100%);
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px -1px rgba(188, 0, 7, 0.35);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
        }
        .btn-header-dashboard:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -3px rgba(188, 0, 7, 0.5);
        }
        .btn-header-dashboard:active {
            transform: translateY(0.5px) scale(0.96);
            transition-duration: 0.08s;
        }
        .btn-header-dashboard .btn-dashboard-icon {
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-header-dashboard:hover .btn-dashboard-icon {
            transform: scale(1.15) rotate(10deg);
        }

        /* ================= FOOTER PARTNER & SOCIAL POLISH (EXACT AS LANDING PAGE & REGISTER) ================= */
        .partner-logo-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.5rem;
            opacity: 0.85;
            cursor: pointer;
            overflow: visible;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            will-change: transform, opacity;
            transition: transform 0.28s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.25s ease;
        }
        .partner-logo-item:hover {
            transform: translate3d(0, -4px, 0) scale(1.06);
            opacity: 1;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        }
        .partner-logo-item:active {
            transform: translate3d(0, -1px, 0) scale(1.01);
            transition: transform 0.1s ease;
        }
        .partner-logo-item img {
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.04));
        }

        /* Official Instagram Brand Theme & Hover Interaction */
        .btn-instagram-bg {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .btn-instagram:hover {
            border-color: transparent !important;
            box-shadow: 0 4px 14px -1px rgba(214, 36, 159, 0.45), 0 2px 6px -1px rgba(253, 89, 73, 0.3) !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #eff4ff;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mobile Table of Contents Dropdown Chevron Animation */
        #mobile-toc-chevron {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            transform-origin: center center !important;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            will-change: transform;
            transform: rotate(0deg) !important;
            rotate: 0deg !important;
        }
        #mobile-toc-trigger[aria-expanded="true"] #mobile-toc-chevron {
            transform: rotate(180deg) !important;
            rotate: 0deg !important;
        }

        /* Print Optimization */
        @media print {
            header, footer, #search-bar-container, #toc-sidebar, .no-print {
                display: none !important;
            }
            main {
                padding-top: 0 !important;
            }
            .clause-section {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                page-break-inside: avoid;
            }
            body {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#0b1c30] antialiased selection:bg-[#bc0007] selection:text-white min-h-screen flex flex-col">

    <!-- ================= TOP OPERATIONAL ALERT / TELEMETRY TICKER ================= -->
    <div class="bg-[#bc0007] border-b border-[#960005] text-xs py-2 px-4 sm:px-6 lg:px-8 xl:px-12 shadow-xs text-white">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center gap-2.5 overflow-hidden text-ellipsis whitespace-nowrap">
                <span class="text-[12px] sm:text-[12.5px] font-medium text-white flex items-center gap-1.5 tracking-wide">
                    <span class="material-symbols-outlined text-[15px] text-red-100">sensors</span>
                    <span>Monitoring Real-time All STO Witel Sukabumi</span>
                </span>
            </div>
        </div>
    </div>

    <!-- ================= STICKY MAIN NAVIGATION BAR ================= -->
    <header class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 h-18 sm:h-20 flex items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Tombol Kembali Panah Kiri (Khusus Mobile) & Logo Resmi Telkom Akses (Desktop Only) -->
            <!-- Mobile Back Arrow Button -->
            <button type="button" 
                    onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ url('/') }}'; }" 
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-[#AE0C00] border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                    title="Kembali ke Halaman Sebelumnya"
                    aria-label="Kembali ke Halaman Sebelumnya">
                <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-[#AE0C00] transition-colors">arrow_back</span>
            </button>

            <!-- Brand Logo & Identity (Desktop Only) -->
            <a href="{{ url('/') }}" class="hidden lg:inline-flex items-center focus:outline-none group active:scale-95 transition-transform duration-200">
                <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                     alt="Logo Resmi PT Telkom Akses" 
                     width="165"
                     height="42"
                     class="h-9 sm:h-10 md:h-11 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                     onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
            </a>

            <!-- Desktop Nav Links (Frameless Floating Aesthetic with Animated Underline) -->

            <!-- Auth Action Buttons (Desktop) & Mobile Home Button -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                @if (Route::has('login'))
                    @auth
                        <!-- Authenticated User Dropdown / Dashboard Button (Desktop Only) -->
                        <div class="hidden lg:flex items-center gap-3">
                            <span class="hidden md:flex flex-col text-right">
                                <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-500 font-mono leading-none">Petugas Terautentikasi</span>
                            </span>
                            <a href="{{ route('dashboard') }}" 
                               class="btn-header-dashboard group">
                                <span class="material-symbols-outlined text-[18px] btn-dashboard-icon">dashboard</span>
                                <span>Buka Dashboard</span>
                            </a>
                        </div>
                    @else
                        <!-- Guest Auth Buttons (Desktop Only) -->
                        <div class="hidden lg:flex items-center gap-2.5 sm:gap-3">
                            <a href="{{ route('login') }}" 
                               class="btn-header-login group"
                               title="Masuk ke Akun">
                                <span class="material-symbols-outlined text-[18px] btn-login-icon">login</span>
                                <span>Masuk</span>
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="btn-header-register group"
                                   title="Pendaftaran Akun Baru">
                                    <span class="material-symbols-outlined text-[18px] btn-register-icon">how_to_reg</span>
                                    <span>Daftar Akun</span>
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif

                <!-- Mobile Home Button (Gantikan Masuk, Register, & Garis Tiga di Layar Mobile) -->
                <a href="{{ url('/') }}" 
                   class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-[#AE0C00] border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                   title="Kembali ke Beranda"
                   aria-label="Kembali ke Beranda">
                    <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-[#AE0C00] transition-colors">home</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full flex-1 flex flex-col">
        <!-- Hero Section -->
        <section class="w-full bg-white border-b border-slate-200/80 relative">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-10 lg:py-12 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
                <!-- Blok Kiri: Headline & Deskripsi -->
                <div class="max-w-3xl flex flex-col gap-3 text-left items-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-tertiary text-xs font-bold tracking-wider uppercase w-fit shadow-2xs">
                        <span class="material-symbols-outlined text-[17px] text-tertiary">gavel</span>
                        <span class="font-telemetry">STANDAR OPERASIONAL PROSEDUR &amp; KODE ETIK</span>
                    </div>
                    <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Syarat dan Ketentuan Akses Monitoring <span class="text-[#AE0C00]">Data Valins Service &amp; GPON</span>
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        Ketentuan resmi hak akses, tanggung jawab operasional teknisi lapangan, analis NOC, dan kepatuhan kode etik penginputan data validasi fiber optic PT Telkom Akses Witel Sukabumi. Wajib dipatuhi oleh seluruh personel operasional.
                    </p>
                </div>
            </div>
        </section>

        <!-- Two-Column Master Layout -->
        <section class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 lg:py-12 flex-1">
            
            <!-- Mobile Sticky Index Navigator Dropdown (Khusus Mobile / Inspect < lg) -->
            <div class="lg:hidden sticky top-[72px] sm:top-[80px] z-40 bg-[#f8f9ff]/95 backdrop-blur-md py-3 -mt-3 mb-6 border-b border-slate-200/80 transition-all duration-200">
                <div class="relative" id="mobile-toc-dropdown">
                    <!-- Dropdown Trigger -->
                    <button type="button" 
                            id="mobile-toc-trigger" 
                            class="w-full flex items-center justify-between gap-3 px-3.5 sm:px-4 py-2.5 rounded-xl bg-white hover:bg-rose-50/50 active:bg-rose-100/40 border border-slate-200/90 hover:border-rose-300 text-slate-800 shadow-2xs transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#AE0C00]/20"
                            aria-expanded="false" 
                            aria-haspopup="listbox"
                            aria-label="Pilih Bab Regulasi">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-7 h-7 rounded-lg bg-rose-50 text-[#AE0C00] flex items-center justify-center shrink-0 border border-rose-100/90 shadow-2xs">
                                <span class="material-symbols-outlined text-[17px]">format_list_bulleted</span>
                            </span>
                            <div class="flex flex-col text-left min-w-0">
                                <span class="text-[9.5px] uppercase font-bold text-slate-400 font-telemetry tracking-wider leading-none">Daftar Isi Regulasi</span>
                                <span id="mobile-toc-label" class="text-xs font-bold text-slate-900 truncate leading-tight mt-0.5">1. Definisi &amp; Ketentuan</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] font-bold text-[#AE0C00] bg-rose-50 border border-rose-200/60 px-2 py-0.5 rounded font-telemetry">7 BAB</span>
                            <svg id="mobile-toc-chevron" 
                                 class="w-5 h-5 text-slate-400 shrink-0" 
                                 viewBox="0 0 24 24" 
                                 fill="none" 
                                 stroke="currentColor" 
                                 stroke-width="2.5" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="m18 15-6-6-6 6"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Dropdown Menu List -->
                    <div id="mobile-toc-menu" 
                         class="hidden absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl border border-slate-200/90 shadow-xl overflow-hidden z-50 p-1.5 max-h-[60vh] overflow-y-auto space-y-1 ring-1 ring-black/5"
                         role="listbox">
                        <a href="#pasal-1" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-1" data-label="1. Definisi &amp; Ketentuan">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">01</span>
                                <span class="truncate">1. Definisi &amp; Ketentuan</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-2" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-2" data-label="2. Hak Akses &amp; Kredensial">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">02</span>
                                <span class="truncate">2. Hak Akses &amp; Kredensial</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-3" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-3" data-label="3. Standar Input Valins">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">03</span>
                                <span class="truncate">3. Standar Input Valins</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-4" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-4" data-label="4. Instrumen OLT &amp; Redaman">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">04</span>
                                <span class="truncate">4. Instrumen OLT &amp; Redaman</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-5" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-5" data-label="5. Larangan &amp; Sanksi Disiplin">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">05</span>
                                <span class="truncate">5. Larangan &amp; Sanksi Disiplin</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-6" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-6" data-label="6. Downtime &amp; Koordinasi NOC">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">06</span>
                                <span class="truncate">6. Downtime &amp; Koordinasi NOC</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-7" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-7" data-label="7. Pakta Integritas Resmi">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">07</span>
                                <span class="truncate">7. Pakta Integritas Resmi</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Sticky Index Navigator -->
                <aside id="toc-sidebar" class="lg:col-span-4 xl:col-span-3 lg:sticky lg:top-[144px] sm:lg:top-[154px] flex flex-col gap-5 order-2 lg:order-1">
                    <div class="hidden lg:flex bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex-col gap-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">format_list_bulleted</span>
                                <span class="font-headline font-bold text-sm text-slate-900">Daftar Isi Regulasi</span>
                            </div>
                            <span class="font-telemetry text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">7 BAB</span>
                        </div>
                        
                        <nav class="flex flex-col gap-1 text-xs" id="toc-nav">
                            <a href="#pasal-1" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">1. Definisi &amp; Ketentuan</span>
                            </a>
                            <a href="#pasal-2" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">2. Hak Akses &amp; Kredensial</span>
                            </a>
                            <a href="#pasal-3" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">3. Standar Input Valins</span>
                            </a>
                            <a href="#pasal-4" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">4. Instrumen OLT &amp; Redaman</span>
                            </a>
                            <a href="#pasal-5" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">5. Larangan &amp; Sanksi Disiplin</span>
                            </a>
                            <a href="#pasal-6" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">6. Downtime &amp; Koordinasi NOC</span>
                            </a>
                            <a href="#pasal-7" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">7. Pakta Integritas Resmi</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Unit Pengawas Callout Card -->

                    <!-- Catatan Penting Callout Card -->
                    <div class="bg-gradient-to-br from-white to-amber-50/40 p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0 border border-amber-200/60 shadow-2xs">
                                <span class="material-symbols-outlined text-xl">info</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline font-bold text-xs text-slate-900">Catatan Penting</span>
                                <span class="font-telemetry text-[11px] text-slate-500">Klausul Dinamis</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Ketentuan ini dapat berubah sewaktu-waktu.
                        </p>
                        <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] font-telemetry">
                            <span class="text-slate-500 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px] text-slate-400">history</span>
                                <span>Terakhir diperbarui:</span>
                            </span>
                            <span class="font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">September 2026</span>
                        </div>
                    </div>
                </aside>

                <!-- Right Column: Full Clause Cards -->
                <main class="lg:col-span-8 xl:col-span-9 flex flex-col gap-8 order-1 lg:order-2" id="clauses-container">
                    
                    <!-- Operational Notice & Navigation Directory Card -->
                    <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden transition-all duration-300">
                        <!-- Top Accent Strip -->
                        <div class="h-1.5 w-full bg-[#AE0C00]"></div>

                        <!-- Card Header & Description -->
                        <div class="p-6 sm:p-7">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-rose-50 border border-rose-100/90 flex items-center justify-center shrink-0 shadow-2xs">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-[#AE0C00]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                            <path d="m9 12 2 2 4-4"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight leading-snug">Pemberlakuan Ketat Kebijakan Data Valins</h2>
                                        <span class="text-xs sm:text-sm font-medium text-slate-400 mt-0.5">Kepatuhan &amp; Validasi Silang OLT</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-sm text-slate-600 leading-relaxed mt-4">
                                Setiap penginputan validasi silang terhadap telemetry OLT GPON Sukabumi secara otomatis guna menjamin keakuratan inventori jaringan fisik dan logis.
                            </p>
                        </div>

                        <!-- Navigation Directory Items -->
                        <div class="border-t border-slate-100 bg-slate-50/30 px-6 py-3 sm:px-7 sm:py-4">
                            <div class="divide-y divide-slate-100">
                                <!-- Directory Item 1: Hak Akses & Kredensial Kedinasan -->
                                <a href="#pasal-2" class="group flex items-center justify-between gap-3 sm:gap-4 py-3 px-2 -mx-2 rounded-xl hover:bg-rose-50/40 transition-colors duration-200 cursor-pointer" aria-label="Navigasi ke Bab II Hak Akses & Kredensial Kedinasan">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-full bg-slate-100/80 text-slate-500 group-hover:bg-rose-50 group-hover:text-[#AE0C00] flex items-center justify-center shrink-0 transition-colors duration-200">
                                            <span class="material-symbols-outlined text-[19px]">badge</span>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-sm font-semibold text-slate-800 group-hover:text-[#AE0C00] transition-colors truncate">Hak Akses &amp; Kredensial Kedinasan</span>
                                            <span class="text-xs text-slate-500 line-clamp-1 mt-0.5">Ketentuan kerahasiaan NIK dan RBAC akun personal teknisi</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 font-mono text-[11px] border border-slate-200/60">BAB II</span>
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#AE0C00] group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>

                                <!-- Directory Item 2: Standar Input VALINS & Audit Fisik ODP -->
                                <a href="#pasal-3" class="group flex items-center justify-between gap-3 sm:gap-4 py-3 px-2 -mx-2 rounded-xl hover:bg-rose-50/40 transition-colors duration-200 cursor-pointer" aria-label="Navigasi ke Bab III Standar Input Valins & Audit Fisik ODP">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-full bg-slate-100/80 text-slate-500 group-hover:bg-rose-50 group-hover:text-[#AE0C00] flex items-center justify-center shrink-0 transition-colors duration-200">
                                            <span class="material-symbols-outlined text-[19px]">qr_code_scanner</span>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-sm font-semibold text-slate-800 group-hover:text-[#AE0C00] transition-colors truncate">Standar Input Valins &amp; Audit Fisik ODP</span>
                                            <span class="text-xs text-slate-500 line-clamp-1 mt-0.5">Validasi GPS toleransi 5m, 4 elemen foto, dan OPM terkalibrasi</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 font-mono text-[11px] border border-slate-200/60">BAB III</span>
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#AE0C00] group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>

                                <!-- Directory Item 3: Larangan Manipulasi & Sanksi Disiplin -->
                                <a href="#pasal-5" class="group flex items-center justify-between gap-3 sm:gap-4 py-3 px-2 -mx-2 rounded-xl hover:bg-rose-50/40 transition-colors duration-200 cursor-pointer" aria-label="Navigasi ke Bab V Larangan Manipulasi & Sanksi Disiplin">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-full bg-slate-100/80 text-slate-500 group-hover:bg-rose-50 group-hover:text-[#AE0C00] flex items-center justify-center shrink-0 transition-colors duration-200">
                                            <span class="material-symbols-outlined text-[19px]">warning</span>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-sm font-semibold text-slate-800 group-hover:text-[#AE0C00] transition-colors truncate">Larangan Manipulasi &amp; Sanksi Disiplin</span>
                                            <span class="text-xs text-slate-500 line-clamp-1 mt-0.5">Penindakan spoofing lokasi, redaman fiktif, hingga sanksi UU ITE</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 font-mono text-[11px] border border-slate-200/60">BAB V</span>
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#AE0C00] group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- PASAL 1 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-1">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-telemetry text-xs text-tertiary font-bold">BAB I</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Definisi &amp; Ketentuan Umum</h2>
                            </div>
                            <span class="material-symbols-outlined text-slate-400">folder_open</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Dalam Dokumen Syarat dan Ketentuan Operasional ini, terminologi teknis dan nomenklatur kedinasan yang digunakan merujuk pada standar arsitektur telekomunikasi PT Telkom Akses Witel Sukabumi:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Valins Service</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Sistem Informasi Manajemen Validation Information System yang digunakan untuk inventarisasi, validasi fisik, audit tagging, dan sertifikasi kelayakan Optical Distribution Point (ODP).
                                </p>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">GPON Infrastructure</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Gigabit-capable Passive Optical Network mencakup Optical Line Terminal (OLT) di STO, Optical Distribution Cabinet (ODC), hingga drop wire Optical Network Terminal (ONT) pelanggan.
                                </p>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Wilayah Kerja STO Sukabumi</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Mencakup 5 Sentral Telepon Otomat: STO Sukabumi Kota (SKB), STO Cicurug (CCR), STO Cibadak (CBD), STO Pelabuhanratu (PLB), dan STO Sagaranten (SGR).
                                </p>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">NOC Daman</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Network Operations Center Unit Data Management and Network Analysis yang berwenang melakukan audit, koreksi inventory, dan pemberian sanksi integritas data.
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- PASAL 2 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-2">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-telemetry text-xs text-tertiary font-bold">BAB II</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Hak Akses Akun &amp; Kredensial Kedinasan</h2>
                            </div>
                            <span class="material-symbols-outlined text-slate-400">badge</span>
                        </div>

                        <div class="flex flex-col gap-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            <div class="flex items-start gap-3">
                                <span class="font-telemetry text-xs text-primary font-bold px-2 py-0.5 rounded bg-red-50 border border-red-100 shrink-0 mt-0.5">2.1</span>
                                <div>
                                    <strong class="text-slate-900">Sifat Akun Personal Kedinasan:</strong> Akun monitoring data valins service bersifat strictly confidential. Setiap pengguna (Teknisi Lapangan, Team Leader, Helpdesk, maupun NOC Engineer) hanya berhak menggunakan kredensial NIK terdaftar yang terafiliasi dengan Single Sign-On (SSO) LDAP PT Telkom Akses.
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="font-telemetry text-xs text-primary font-bold px-2 py-0.5 rounded bg-red-50 border border-red-100 shrink-0 mt-0.5">2.2</span>
                                <div>
                                    <strong class="text-slate-900">Larangan Pemindahtanganan:</strong> Dilarang keras membagikan kredensial, username, sandi, atau token Multi-Factor Authentication (MFA) kepada pihak ketiga, teknisi magang tanpa supervisi, atau mitra subkontraktor tanpa persetujuan tertulis dari Asman Operasi &amp; Pemeliharaan Witel Sukabumi.
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="font-telemetry text-xs text-primary font-bold px-2 py-0.5 rounded bg-red-50 border border-red-100 shrink-0 mt-0.5">2.3</span>
                                <div>
                                    <strong class="text-slate-900">Kewajiban Pengakhiran Sesi (Logout):</strong> Seluruh personel wajib melakukan logout resmi segera setelah sesi kerja lapangan atau shift loket pemeliharaan selesai. Setiap transaksi data yang terjadi selama sesi aktif menjadi tanggung jawab mutlak pemilik akun.
                                </div>
                            </div>
                        </div>

                        <!-- Matriks Kewenangan Hak Akses -->
                        <div class="mt-2 flex flex-col gap-2">
                            <span class="font-headline text-xs font-bold text-slate-900 uppercase">Matriks Wewenang Pengguna (RBAC Matrix)</span>
                            <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-slate-50 text-slate-700 font-telemetry text-[11px] uppercase tracking-wider border-b border-slate-200">
                                        <tr>
                                            <th class="py-3 px-3.5 font-bold">Peran / Role</th>
                                            <th class="py-3 px-3.5 font-bold">Cakupan Wilayah</th>
                                            <th class="py-3 px-3.5 font-bold">Input ODP</th>
                                            <th class="py-3 px-3.5 font-bold">Koreksi Redaman</th>
                                            <th class="py-3 px-3.5 font-bold">Approval Valins</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-600">
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="py-2.5 px-3.5 font-semibold text-slate-900">Teknisi IOAN / Maintenance</td>
                                            <td class="py-2.5 px-3.5 font-telemetry text-xs">Sektor Rayon STO</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Write / Draft</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Measure Only</td>
                                            <td class="py-2.5 px-3.5 text-slate-400">None</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="py-2.5 px-3.5 font-semibold text-slate-900">Team Leader Area (TL)</td>
                                            <td class="py-2.5 px-3.5 font-telemetry text-xs">Rayon STO Terkait</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Review &amp; Submit</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Verify</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Level 1</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="py-2.5 px-3.5 font-semibold text-slate-900">NOC Daman &amp; Quality Engineer</td>
                                            <td class="py-2.5 px-3.5 font-telemetry text-xs">All Witel Sukabumi</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Audit &amp; Purge</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Full Override</td>
                                            <td class="py-2.5 px-3.5 text-primary font-bold">Final Approval</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="py-2.5 px-3.5 font-semibold text-slate-900">Mitra Deployment Fiber</td>
                                            <td class="py-2.5 px-3.5 font-telemetry text-xs">Nomor SPK Aktif</td>
                                            <td class="py-2.5 px-3.5 text-tertiary font-bold">Provisioning Only</td>
                                            <td class="py-2.5 px-3.5 text-slate-400">Read Only</td>
                                            <td class="py-2.5 px-3.5 text-slate-400">None</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </article>

                    <!-- PASAL 3 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-telemetry text-xs text-tertiary font-bold">BAB III</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Standar Input Data Valins &amp; Audit Fisik ODP</h2>
                            </div>
                            <span class="material-symbols-outlined text-slate-400">qr_code_scanner</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Integritas data jaringan fiber adalah aset strategis operasional telekomunikasi nasional. Setiap petugas yang menginput data ke dalam sistem Valins wajib mematuhi standar operasional prosedur teknis berikut:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Requirement 1 -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-xl">pin_drop</span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Validasi Fisik &amp; Koordinat On-Site</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Petugas wajib berada langsung di lokasi tiang atau manhole ODP saat melakukan submission. Sistem memberlakukan validasi GPS Geofencing radius toleransi maksimal 5.0 meter. Penginputan secara remote tanpa verifikasi fisik merupakan pelanggaran integritas.
                                </p>
                            </div>

                            <!-- Requirement 2 -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-xl">photo_camera</span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Standar Foto Dokumentasi Fisik</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Unggahan foto wajib memuat 4 unsur: (1) Label barcode ODP terbaca jelas, (2) Kondisi tray kaset splitter, (3) Jalur masuk drop core tertata rapi, dan (4) Sudut pandang lingkungan tiang secara umum. Dilarang mengunggah foto buram atau foto dari layar perangkat lain.
                                </p>
                            </div>

                            <!-- Requirement 3 -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-xl">sensors</span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Pengukuran OPM Terkalibrasi</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Nilai redaman optical power wajib diukur menggunakan Optical Power Meter (OPM) berlabel kalibrasi sah. Nilai pada panjang gelombang 1490nm (downstream data) wajib diinput sesuai angka real-time tanpa penyesuaian artifisial.
                                </p>
                            </div>

                            <!-- Requirement 4 -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-600 text-xl">share</span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900">Sinkronisasi Port Splitter</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemetaan nomor port splitter (Port 1 s/d Port 8/16) wajib persis sama antara pelabelan fisik di lapangan dengan data pada database Valins untuk mencegah terjadinya port rebutan (cross-connection discrepancy).
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- PASAL 4 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-telemetry text-xs text-tertiary font-bold">BAB IV</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Penggunaan Instrumen OLT &amp; Ambang Redaman</h2>
                            </div>
                            <span class="material-symbols-outlined text-slate-400">show_chart</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Sistem GPON PT Telkom Akses Witel Sukabumi menerapkan parameter ketat untuk menjaga QoS (Quality of Service) dan throughput bandwidth pelanggan. Nilai redaman optik wajib memenuhi ketentuan batas berikut:
                        </p>

                        <!-- Attenuation Tolerance Table -->
                        <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-slate-50 text-slate-700 font-telemetry text-[11px] uppercase tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="py-3 px-3.5 font-bold">Klasifikasi Health</th>
                                        <th class="py-3 px-3.5 font-bold">Rentang Optik (dBm)</th>
                                        <th class="py-3 px-3.5 font-bold">Tindakan Sistem</th>
                                        <th class="py-3 px-3.5 font-bold">Status Sertifikasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-2.5 px-3.5 flex items-center gap-2 font-semibold text-slate-900">
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Optimal Class A
                                        </td>
                                        <td class="py-2.5 px-3.5 font-telemetry text-xs font-semibold">-16.00 s/d -21.99 dBm</td>
                                        <td class="py-2.5 px-3.5 text-slate-500">Auto-approved ke inventory komersial</td>
                                        <td class="py-2.5 px-3.5 text-emerald-700 font-bold">LURUS SEMPURNA</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-2.5 px-3.5 flex items-center gap-2 font-semibold text-slate-900">
                                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Tolerable Class B
                                        </td>
                                        <td class="py-2.5 px-3.5 font-telemetry text-xs font-semibold">-22.00 s/d -24.00 dBm</td>
                                        <td class="py-2.5 px-3.5 text-slate-500">Approved dengan catatan pembersihan adapter</td>
                                        <td class="py-2.5 px-3.5 text-blue-700 font-bold">LURUS BERSYARAT</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-2.5 px-3.5 flex items-center gap-2 font-semibold text-slate-900">
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>High Loss / Warning
                                        </td>
                                        <td class="py-2.5 px-3.5 font-telemetry text-xs font-semibold">-24.01 s/d -26.99 dBm</td>
                                        <td class="py-2.5 px-3.5 text-slate-500">Tiket re-splicing otomatis ke tim pemeliharaan</td>
                                        <td class="py-2.5 px-3.5 text-amber-700 font-bold">HOLD AUDIT</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-2.5 px-3.5 flex items-center gap-2 font-semibold text-slate-900">
                                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Critical / Severe LOS
                                        </td>
                                        <td class="py-2.5 px-3.5 font-telemetry text-xs font-semibold">&lt; -27.00 dBm / No Light</td>
                                        <td class="py-2.5 px-3.5 text-slate-500">Locking port ODP dari sistem penjualan IndiHome</td>
                                        <td class="py-2.5 px-3.5 text-red-600 font-bold">DITOLAK SISTEM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </article>

                    <!-- PASAL 5 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-red-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-5">
                        <div class="flex items-center justify-between pb-3 border-b border-red-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-red-100 font-telemetry text-xs text-primary font-bold">BAB V</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-red-800">Larangan Manipulasi &amp; Sanksi Pelanggaran Disiplin</h2>
                            </div>
                            <span class="material-symbols-outlined text-primary">warning</span>
                        </div>

                        <div class="p-4 rounded-xl bg-red-50 border border-red-200/60 flex flex-col gap-1.5">
                            <span class="font-headline text-xs sm:text-sm font-bold text-red-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">gavel</span>
                                Pernyataan Tegas Manajemen Operasional PT Telkom Akses
                            </span>
                            <p class="text-xs text-red-700 leading-relaxed">
                                Integritas data adalah pilar keandalan jaringan telekomunikasi nasional. Segala bentuk kecurangan, pemalsuan titik, atau rekayasa redaman akan diproses melalui dewan kode etik kedinasan tanpa kompromi.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 text-xs sm:text-sm">
                            <div class="flex flex-col gap-2">
                                <span class="font-headline font-bold text-xs text-slate-900 uppercase">5.1 Bentuk Tindakan Terlarang (Tindak Pelanggaran Data)</span>
                                <ul class="flex flex-col gap-2 pl-4 list-disc text-slate-600 text-xs">
                                    <li><strong class="text-slate-900">Spoofing / Mock Location GPS:</strong> Memakai aplikasi pihak ketiga untuk memalsukan posisi koordinat saat melakukan validasi ODP.</li>
                                    <li><strong class="text-slate-900">Redaman Fiktif (Ghost Attenuation Input):</strong> Memasukkan angka daya optik -18 dBm secara acak tanpa melakukan pengetesan fisik menggunakan OPM.</li>
                                    <li><strong class="text-slate-900">Duplikasi Foto ODP:</strong> Menggunakan kembali foto dokumentasi ODP lain atau foto arsip lama untuk validasi ODP baru.</li>
                                    <li><strong class="text-slate-900">Intervensi Port Ilegal:</strong> Memindahkan jumpering patchcord pelanggan lain di ODC tanpa tiket resmi dari Daman/NOC Sukabumi.</li>
                                </ul>
                            </div>

                            <div class="flex flex-col gap-2">
                                <span class="font-headline font-bold text-xs text-slate-900 uppercase">5.2 Tingkatan Sanksi &amp; Tindakan Hukum</span>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1">
                                        <span class="font-telemetry text-[10px] text-slate-500 font-bold uppercase">Tingkat I - Peringatan</span>
                                        <span class="font-headline font-bold text-xs text-slate-900">Surat Peringatan 1</span>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">
                                            Pembekuan akun Monitoring selama 7 hari kerja dan kewajiban survei ulang mandiri terhadap seluruh ODP bermasalah.
                                        </p>
                                    </div>

                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1">
                                        <span class="font-telemetry text-[10px] text-amber-600 font-bold uppercase">Tingkat II - Skorsing</span>
                                        <span class="font-headline font-bold text-xs text-slate-900">Skorsing Lapangan</span>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">
                                            Pencabutan sertifikasi teknisi fiber optik, pemotongan insentif kinerja, dan blacklist penugasan area STO selama 3 bulan.
                                        </p>
                                    </div>

                                    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200/60 flex flex-col gap-1">
                                        <span class="font-telemetry text-[10px] text-red-600 font-bold uppercase">Tingkat III - Terminasi</span>
                                        <span class="font-headline font-bold text-xs text-red-800">PHK &amp; UU ITE</span>
                                        <p class="text-[11px] text-red-700 leading-relaxed">
                                            Pemutusan hubungan kerja dengan tidak hormat serta pelaporan tindak pidana manipulasi data elektronik sesuai UU ITE No. 1/2024.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- PASAL 6 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-6">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-telemetry text-xs text-tertiary font-bold">BAB VI</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Pemeliharaan Terjadwal &amp; Downtime SLA</h2>
                            </div>
                            <span class="material-symbols-outlined text-slate-400">update</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Sistem monitoring data valins service terintegrasi dengan UIM (Unified Inventory Management) Telkom Group. Untuk menjamin stabilitas data, ketentuan jendela pemeliharaan (maintenance window) diatur sebagai berikut:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <span class="font-telemetry text-[10px] text-slate-500 uppercase font-bold">Jendela Rutin (Maintenance Window)</span>
                                <span class="font-headline font-bold text-sm text-slate-900">Setiap Hari</span>
                                <span class="font-telemetry text-xs text-primary font-bold">Pukul 08:00 s/d 21:00 WIB</span>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Pada saat sistem berstatus Read-Only selama replikasi database regional Jawa Barat. Input data lapangan ditangguhkan sementara.
                                </p>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1.5">
                                <span class="font-telemetry text-[10px] text-slate-500 uppercase font-bold">Target SLA Ketersediaan Sistem</span>
                                <span class="font-headline font-bold text-sm text-slate-900">SLA 99.85% Kesiapan</span>
                                <span class="font-telemetry text-xs text-tertiary font-bold">Max MTTR Insiden: 120 Menit</span>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Dukungan teknis Helpdesk NOC Sukabumi aktif 24 jam x 7 hari melalui kanal eskalasi internal portal.
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- PASAL 7 / PAKTA INTEGRITAS INTERACTIVE CONFIRMATION -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-6 scroll-mt-44 sm:scroll-mt-48" id="pasal-7">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-1 rounded-lg bg-red-50 font-telemetry text-xs text-primary font-bold">BAB VII</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Pakta Integritas &amp; Konfirmasi Kepatuhan Petugas</h2>
                            </div>
                            <span class="material-symbols-outlined text-primary">verified</span>
                        </div>

                        <div class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-slate-50 to-red-50/30 border border-red-100 flex flex-col gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shrink-0 shadow-2xs">
                                    <span class="material-symbols-outlined text-xl">assignment_turned_in</span>
                                </div>
                                <div>
                                    <span class="font-headline font-bold text-sm text-slate-900">Formulir Pakta Integritas Elektronik</span>
                                    <p class="text-xs text-slate-500">Pernyataan komitmen kedinasan operasional PT Telkom Akses Witel Sukabumi</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs sm:text-sm text-slate-700 leading-relaxed flex flex-col gap-2">
                                <p class="font-semibold text-slate-900">
                                    Dengan menandatangani dan mencentang konfirmasi di bawah ini, saya menyatakan dengan penuh tanggung jawab kedinasan:
                                </p>
                                <ul class="list-disc pl-4 text-slate-600 space-y-1 text-xs">
                                    <li>Akan selalu menginput data fisik ODP dan hasil redaman optik GPON berdasarkan pengukuran nyata di lapangan.</li>
                                    <li>Tidak akan menggunakan akun rekan kerja atau memberikan kredensial login kepada personel tidak berwenang.</li>
                                    <li>Bersedia menerima sanksi disiplin kedinasan, sanksi administrasi, maupun tindakan hukum pidana apabila terbukti memanipulasi data inventaris jaringan PT Telkom Akses Witel Sukabumi.</li>
                                </ul>
                            </div>

                            <!-- Verification Metadata Preview -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                                <div class="p-3 rounded-xl bg-white border border-slate-200/80 flex flex-col">
                                    <span class="font-telemetry text-[10px] text-slate-400 uppercase font-semibold">Petugas Terautentikasi</span>
                                    <span class="font-headline font-bold text-xs text-slate-800">
                                        @auth {{ Auth::user()->name }} @else Unit Legal &amp; Compliance @endauth
                                    </span>
                                    <span class="font-telemetry text-[11px] text-slate-500">
                                        @auth ID: {{ Auth::user()->email }} @else ID: NIK-92041837 @endauth
                                    </span>
                                </div>

                                <div class="p-3 rounded-xl bg-white border border-slate-200/80 flex flex-col">
                                    <span class="font-telemetry text-[10px] text-slate-400 uppercase font-semibold">Lokasi Penugasan</span>
                                    <span class="font-headline font-bold text-xs text-slate-800">Witel Sukabumi</span>
                                    <span class="font-telemetry text-[11px] text-slate-500">Regional Network III</span>
                                </div>

                                <div class="p-3 rounded-xl bg-white border border-slate-200/80 flex flex-col">
                                    <span class="font-telemetry text-[10px] text-slate-400 uppercase font-semibold">Waktu Audit Sesi</span>
                                    <span class="font-headline font-bold text-xs text-slate-800" id="timestamp-clock">2026-10-15 08:30 WIB</span>
                                    <span class="font-telemetry text-[11px] text-emerald-600 font-semibold">SHA-256 Verified</span>
                                </div>
                            </div>

                            <!-- Agreement Interactive Controls -->
                            <div class="flex flex-col gap-4 pt-2">
                                <label class="flex items-start gap-3 cursor-pointer select-none group">
                                    <input type="checkbox" id="tos-agreement-checkbox" class="mt-0.5 w-4 h-4 rounded text-primary focus:ring-primary/20 accent-primary cursor-pointer transition">
                                    <span class="text-xs sm:text-sm text-slate-700 group-hover:text-primary transition-colors leading-relaxed">
                                        <strong>Saya telah membaca, memahami, dan menyetujui seluruh Syarat &amp; Ketentuan serta Pakta Integritas Operasional monitoring data valins service &amp; GPON PT Telkom Akses Witel Sukabumi.</strong> Saya siap menerima sanksi jika terbukti melakukan pelanggaran data.
                                    </span>
                                </label>

                                <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-slate-200/80">
                                    <div class="flex items-center gap-1.5 text-slate-500 text-xs font-telemetry">
                                        <span class="material-symbols-outlined text-sm">lock</span>
                                        <span>Terekam dalam Ledger Audit Keamanan Telkom Witel Sukabumi</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors text-xs font-semibold">
                                            Kembali ke Atas
                                        </button>
                                        <button type="button" id="confirm-btn" disabled class="px-5 py-2 rounded-xl bg-primary text-white hover:bg-primary-dark disabled:opacity-40 disabled:cursor-not-allowed transition-all text-xs font-bold shadow-sm flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px]">done_all</span>
                                            <span>Konfirmasi Kepatuhan &amp; Lanjutkan</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Toast Feedback (Revealed on click) -->
                                <div id="confirmation-toast" class="hidden p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-slate-800 flex items-center justify-between gap-3 shadow-2xs">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-emerald-600 text-2xl font-bold">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline font-bold text-xs sm:text-sm text-emerald-900">Persetujuan Pakta Integritas Berhasil Disimpan</span>
                                            <span class="text-xs text-emerald-700">Token sertifikat kepatuhan aktif untuk sesi Anda. Terverifikasi resmi ke Ledger Witel Sukabumi.</span>
                                        </div>
                                    </div>
                                    <span class="font-telemetry text-xs text-emerald-800 font-bold bg-emerald-100 px-2.5 py-1 rounded-md shrink-0">ACK-200 OK</span>
                                </div>
                            </div>
                        </div>
                    </article>

                </main>
            </div>
        </section>

        <!-- ================= SECTION: MASIH ADA PERTANYAAN? (HELP & INQUIRY BANNER) ================= -->
        <section class="w-full relative overflow-hidden py-12 sm:py-16 px-4 sm:px-6 lg:px-8 xl:px-12 border-t border-red-900/30 text-white shadow-xl"
                 style="background-color: #bc0007; background: linear-gradient(135deg, #780702 0%, #b30006 45%, #d11208 100%);">
            
            <!-- Decorative Subtle Ambient Glow Elements (No White Fading on Edges) -->
            <div class="absolute -right-24 -bottom-24 w-96 h-96 rounded-full bg-red-950/40 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-red-900/30 blur-3xl pointer-events-none"></div>
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#ffffff_1.2px,transparent_1.2px)] [background-size:24px_24px] pointer-events-none"></div>

            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8 lg:gap-12">
                
                <!-- Left Content: Operational Badge, Heading, Contextual Subtitle, Feature Highlights -->
                <div class="max-w-3xl flex flex-col gap-3.5">
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Masih Memiliki Pertanyaan Mengenai Syarat &amp; Ketentuan?
                    </h2>

                    <p class="text-red-100/90 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Tim Operasional dan Helpdesk NOC kami siap membantu anda apabila memahami mengenai syarat dan ketentuan.
                    </p>
                </div>

                <!-- Right Actions: Primary "Hubungi Kami" Button & Secondary Hotline -->
                <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-stretch sm:items-center gap-3.5 shrink-0">
                    <a href="{{ route('contact.us') }}" 
                       class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-xl bg-white hover:bg-red-50 active:scale-95 text-[#bc0007] font-headline font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all duration-200 group">
                        <span class="material-symbols-outlined text-xl text-[#bc0007]">support_agent</span>
                        <span>Hubungi Kami</span>
                        <span class="material-symbols-outlined text-lg text-[#bc0007] transition-transform duration-200 group-hover:translate-x-1">arrow_forward</span>
                    </a>
                </div>

            </div>
        </section>
    </main>

    <!-- Persistent Telkom Akses Operations Footer -->
    <footer class="hidden lg:block w-full bg-white border-t border-slate-200/80 shadow-xs mt-0 pt-7 sm:pt-8.5 pb-4 sm:pb-5 text-left" id="bantuan">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 xl:gap-10">
                
                <!-- Column 1: Brand & Profil + Kontak Bantuan NOC (lg:col-span-5, xl:col-span-5) -->
                <div class="lg:col-span-5 xl:col-span-5 flex flex-col gap-6">
                    <!-- Brand & Profil -->
                    <div class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                                 alt="Logo Resmi PT Telkom Akses" 
                                 class="h-11 sm:h-12 md:h-13 w-auto object-contain shrink-0"
                                 onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-md">
                            Sistem Informasi Manajemen Data Valins & Monitoring Jaringan GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional.
                        </p>
                        <div class="flex flex-wrap items-center gap-2.5 mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-sky-800 text-[11px] font-semibold border border-slate-200">
                                <span class="material-symbols-outlined text-[15px] text-sky-600">verified</span>
                                BUMN Terpercaya
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-[#bc0007] text-[11px] font-semibold border border-red-200/60">
                                <span class="material-symbols-outlined text-[15px]">security</span>
                                ISO 27001 Certified
                            </span>
                        </div>
                    </div>

                    <!-- Kontak Bantuan NOC (Tepat di Bawah Brand & Profil - Vertikal Rapi Tanpa Garis Pembatas) -->
                    <div class="flex flex-col pt-1">
                        <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-3">
                            <span>KONTAK BANTUAN NOC</span>
                        </div>
                        <div class="flex flex-col gap-2.5 max-w-md">
                            <!-- Hotline Fixed Line -->
                            <a href="tel:0266221100" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-red-50/60 border border-slate-100 hover:border-red-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-red-100 text-[#bc0007] flex items-center justify-center shrink-0 border border-red-200/60 group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[19px]">call</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors leading-tight">Hotline Fixed Line</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">(0266) 221100 / ext. 408</span>
                                </div>
                            </a>

                            <!-- WhatsApp Dispatcher NOC -->
                            <a href="https://wa.me/6281120898880" target="_blank" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 hover:border-emerald-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#25D366] flex items-center justify-center shrink-0 border border-emerald-200/60 group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-tight">WhatsApp Dispatcher</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">+62 811-2089-8880</span>
                                </div>
                            </a>

                            <!-- Email Kedinasan -->
                            <a href="mailto:noc.sukabumi@telkomakses.co.id" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-sky-50/60 border border-slate-100 hover:border-sky-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-[#0284C7] flex items-center justify-center shrink-0 border border-sky-200/60 group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[19px]">mail</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-tight">Email Kedinasan</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 truncate font-semibold">noc.sukabumi@telkomakses.co.id</span>
                                </div>
                            </a>                            
                        </div>
                    </div>
                </div>

                <!-- Column 2: Navigasi Portal (lg:col-span-2, xl:col-span-2) -->
                <div class="lg:col-span-2 xl:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>NAVIGASI PORTAL</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Masuk Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Registrasi Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Validasi Data Valins</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Monitoring &amp; Rekonsiliasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('contact-us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Hubungi kami</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Informasi / Tentang Perusahaan (lg:col-span-2, xl:col-span-2) -->
                <div class="lg:col-span-2 xl:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>TENTANG PERUSAHAAN</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('about.us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Tentang Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.policy') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms.conditions') }}" class="group flex items-center gap-2 text-[#bc0007] font-semibold transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Syarat &amp; Ketentuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Arsitektur Jaringan GPON</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Area Distribusi STO (lg:col-span-3, xl:col-span-3) -->
                <div class="lg:col-span-3 xl:col-span-3 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>AREA DISTRIBUSI STO</span>
                    </div>
                    <div class="flex flex-col gap-2 font-telemetry text-xs">
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO SKB - Sukabumi</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO CCR - Cicurug</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO CBD - Cibadak</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO PLR - Pelabuhanratu</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO SGN - Sagaranten</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Garis Pembatas Horisontal Tunggal yang Presisi -->
            <div class="border-t border-slate-200/80 mt-8 mb-6 sm:mt-9 sm:mb-6"></div>

            <!-- Bilah Hak Cipta & Media Sosial (Bottom Bar) -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <!-- Sisi Kiri: Teks Hak Cipta & Otoritas Regional -->
                <p class="text-center sm:text-left leading-relaxed text-slate-500">
                    <span class="font-medium text-slate-700">© {{ date('Y') }} PT Telkom Akses Witel Sukabumi.</span>
                    <span class="text-slate-300 hidden sm:inline">•</span>
                    <span class="text-slate-500">Sub-Direktorat Operasi Jaringan Regional Jawa Barat</span>
                </p>

                <!-- Sisi Kanan: Deretan Ikon Media Sosial (Lingkaran Abu-abu Tipis Membulat, Hover State Merah Korporat) -->
                <div class="flex items-center gap-2">
                    <!-- 1. Instagram -->
                    <a href="https://www.instagram.com/telkomaksesindonesia/" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="Instagram Resmi Telkom Akses (@telkomaksesindonesia)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    <!-- 2. YouTube -->
                    <a href="https://www.youtube.com/@TelkomAksesOfficial/streams" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="YouTube Channel Telkom Akses">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>

                    <!-- 3. TikTok -->
                    <a href="https://www.tiktok.com/@telkomaksesindonesia" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="TikTok Telkom Akses (@telkomaksesindonesia)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>

                    <!-- 4. Facebook -->
                    <a href="https://www.facebook.com/telkomaksesofficial/" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="Facebook Telkom Akses">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Client-Side Search, ToC Scrollspy & Interactive Checkbox -->
    <script>
        // Real-Time Search / Filter across clauses
        const searchInput = document.getElementById('search-clause-input');
        const clearSearchBtn = document.getElementById('clear-search-btn');
        const searchStats = document.getElementById('search-stats');
        const sections = document.querySelectorAll('.clause-section');

        function filterClauses(query) {
            query = query.toLowerCase().trim();
            let matchCount = 0;

            sections.forEach(section => {
                const text = section.innerText.toLowerCase();
                if (query === '' || text.includes(query)) {
                    section.classList.remove('hidden');
                    section.classList.add('flex');
                    matchCount++;
                } else {
                    section.classList.add('hidden');
                    section.classList.remove('flex');
                }
            });

            if (clearSearchBtn) {
                if (query.length > 0) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }
            }

            if (searchStats) {
                searchStats.textContent = `Menampilkan ${matchCount} dari ${sections.length} Bab`;
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                filterClauses(e.target.value);
            });
        }

        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', () => {
                searchInput.value = '';
                filterClauses('');
                searchInput.focus();
            });
        }

        function expandAllClauses() {
            if (searchInput) searchInput.value = '';
            filterClauses('');
        }

        // Mobile Table of Contents Dropdown Logic
        const mobileTocTrigger = document.getElementById('mobile-toc-trigger');
        const mobileTocMenu = document.getElementById('mobile-toc-menu');
        const mobileTocChevron = document.getElementById('mobile-toc-chevron');
        const mobileTocLabel = document.getElementById('mobile-toc-label');
        const mobileTocLinks = document.querySelectorAll('.mobile-toc-link');

        function toggleMobileToc(forceState) {
            if (!mobileTocMenu) return;
            const isCurrentlyOpen = !mobileTocMenu.classList.contains('hidden');
            const shouldOpen = forceState !== undefined ? forceState : !isCurrentlyOpen;

            if (shouldOpen) {
                mobileTocMenu.classList.remove('hidden');
                mobileTocTrigger?.setAttribute('aria-expanded', 'true');
            } else {
                mobileTocMenu.classList.add('hidden');
                mobileTocTrigger?.setAttribute('aria-expanded', 'false');
            }
        }

        if (mobileTocTrigger) {
            mobileTocTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleMobileToc();
            });
        }

        // Close dropdown when clicking a link
        mobileTocLinks.forEach(link => {
            link.addEventListener('click', () => {
                toggleMobileToc(false);
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('mobile-toc-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                toggleMobileToc(false);
            }
        });

        // Close dropdown on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                toggleMobileToc(false);
            }
        });

        // Active State for Table of Contents based on Scroll Position (Scrollspy)
        function updateScrollspy() {
            const navLinks = document.querySelectorAll('#toc-nav .toc-link');
            let currentId = 'pasal-1';

            sections.forEach(section => {
                if (!section.classList.contains('hidden')) {
                    const top = section.offsetTop - 210;
                    if (window.scrollY >= top) {
                        currentId = section.getAttribute('id');
                    }
                }
            });

            // Update Desktop ToC
            navLinks.forEach(link => {
                if (link.getAttribute('href') === `#${currentId}`) {
                    link.classList.add('bg-rose-50', 'text-[#AE0C00]', 'font-semibold', 'border-l-4', 'border-[#AE0C00]', 'pl-2.5');
                    link.classList.remove('text-slate-700', 'hover:bg-slate-50', 'font-medium');
                } else {
                    link.classList.remove('bg-rose-50', 'text-[#AE0C00]', 'font-semibold', 'border-l-4', 'border-[#AE0C00]', 'pl-2.5');
                    link.classList.add('text-slate-700', 'hover:bg-slate-50', 'font-medium');
                }
            });

            // Update Mobile ToC Dropdown
            mobileTocLinks.forEach(link => {
                const target = link.getAttribute('data-target');
                const badge = link.querySelector('.mobile-toc-badge');
                if (target === currentId) {
                    link.classList.add('bg-rose-50', 'text-[#AE0C00]', 'font-semibold');
                    link.classList.remove('text-slate-700');
                    if (badge) {
                        badge.classList.add('bg-[#AE0C00]', 'text-white');
                        badge.classList.remove('bg-slate-100', 'text-slate-600');
                    }
                    if (mobileTocLabel) {
                        const labelText = link.getAttribute('data-label');
                        if (labelText) mobileTocLabel.textContent = labelText;
                    }
                } else {
                    link.classList.remove('bg-rose-50', 'text-[#AE0C00]', 'font-semibold');
                    link.classList.add('text-slate-700');
                    if (badge) {
                        badge.classList.remove('bg-[#AE0C00]', 'text-white');
                        badge.classList.add('bg-slate-100', 'text-slate-600');
                    }
                }
            });
        }
        window.addEventListener('scroll', updateScrollspy, { passive: true });
        updateScrollspy();

        // Pakta Integritas Interactive Checkbox and Button States
        const checkbox = document.getElementById('tos-agreement-checkbox');
        const confirmBtn = document.getElementById('confirm-btn');
        const toast = document.getElementById('confirmation-toast');
        const timestampClock = document.getElementById('timestamp-clock');

        if (checkbox && confirmBtn) {
            checkbox.addEventListener('change', (e) => {
                confirmBtn.disabled = !e.target.checked;
            });

            confirmBtn.addEventListener('click', () => {
                if (!checkbox.checked) return;
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = `
                    <span class="material-symbols-outlined text-[16px] animate-spin">refresh</span>
                    <span>Memverifikasi Kredensial...</span>
                `;

                setTimeout(() => {
                    confirmBtn.innerHTML = `
                        <span class="material-symbols-outlined text-[16px]">check</span>
                        <span>Tersimpan Resmi</span>
                    `;
                    if (toast) {
                        toast.classList.remove('hidden');
                        toast.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                }, 1000);
            });
        }

        // Live Clock
        if (timestampClock) {
            const updateClock = () => {
                const now = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                const formatted = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())} WIB`;
                timestampClock.textContent = formatted;
            };
            updateClock();
            setInterval(updateClock, 30000);
        }
    </script>
</body>
</html>
