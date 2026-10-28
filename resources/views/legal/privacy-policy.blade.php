<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>
    <meta name="description" content="Pedoman tata kelola kerahasiaan data teknis optik GPON, verifikasi NIK personel lapangan, serta kepatuhan UU PDP No. 27/2022 PT Telkom Akses Witel Sukabumi.">

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
        <!-- Hero & Regulation Banner (Clean Light Enterprise Header) -->
        <section class="w-full bg-white border-b border-slate-200/80 relative">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-10 lg:py-12 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
                <!-- Blok Kiri: Headline & Deskripsi -->
                <div class="max-w-3xl flex flex-col gap-3 text-left items-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200/80 text-[#AE0C00] text-xs font-bold tracking-wider uppercase w-fit shadow-2xs">
                        <span class="material-symbols-outlined text-[17px] text-[#AE0C00]">verified_user</span>
                        <span class="font-telemetry">KEPATUHAN REGULASI &amp; DATA GOVERNANCE</span>
                    </div>
                    <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Kebijakan Privasi Perlindungan <span class="text-[#AE0C00]">Data Personel &amp; Operasional Jaringan</span>
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        Pedoman tata kelola kerahasiaan data teknis optik GPON, verifikasi NIK personel lapangan, serta integritas telemetri telekomunikasi PT Telkom Akses Regional Jawa Barat (Witel Sukabumi).
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content Layout (Sticky ToC + Content Articles) -->
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 lg:py-12 flex-1">
            
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
                                <span id="mobile-toc-label" class="text-xs font-bold text-slate-900 truncate leading-tight mt-0.5">1. Ruang Lingkup &amp; Dasar Hukum</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] font-bold text-[#AE0C00] bg-rose-50 border border-rose-200/60 px-2 py-0.5 rounded font-telemetry">7 PASAL</span>
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
                        <a href="#pasal-1" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-1" data-label="1. Ruang Lingkup &amp; Dasar Hukum">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">01</span>
                                <span class="truncate">1. Ruang Lingkup &amp; Dasar Hukum</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-2" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-2" data-label="2. Jenis Data yang Dikumpulkan">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">02</span>
                                <span class="truncate">2. Jenis Data yang Dikumpulkan</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-3" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-3" data-label="3. Tujuan Pemrosesan &amp; UIM Sync">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">03</span>
                                <span class="truncate">3. Tujuan Pemrosesan &amp; UIM Sync</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-4" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-4" data-label="4. Pembagian Data &amp; Helpdesk NOC">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">04</span>
                                <span class="truncate">4. Pembagian Data &amp; Helpdesk NOC</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-5" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-5" data-label="5. Keamanan Enkripsi &amp; Retensi Log">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">05</span>
                                <span class="truncate">5. Keamanan Enkripsi &amp; Retensi Log</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-6" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-6" data-label="6. Hak &amp; Kewajiban Teknisi Mitra">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">06</span>
                                <span class="truncate">6. Hak &amp; Kewajiban Teknisi Mitra</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                        <a href="#pasal-7" class="mobile-toc-link flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:text-[#AE0C00] hover:bg-rose-50/70 font-medium text-xs transition-colors group" data-target="pasal-7" data-label="7. Kontak DPO &amp; Helpdesk Sukabumi">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="mobile-toc-badge w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-[#AE0C00] group-hover:text-white flex items-center justify-center text-[10px] font-bold font-telemetry transition-colors shrink-0">07</span>
                                <span class="truncate">7. Kontak DPO &amp; Helpdesk Sukabumi</span>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover:text-[#AE0C00] shrink-0 transition-colors">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Sticky Table of Contents -->
                <aside id="toc-sidebar" class="lg:col-span-4 lg:sticky lg:top-[144px] sm:lg:top-[154px] flex flex-col gap-5 order-2 lg:order-1">
                    <div class="hidden lg:flex bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex-col gap-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">format_list_bulleted</span>
                                <span class="font-headline font-bold text-sm text-slate-900">Daftar Isi Regulasi</span>
                            </div>
                            <span class="font-telemetry text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">7 PASAL</span>
                        </div>
                        
                        <nav class="flex flex-col gap-1 text-xs" id="toc-nav">
                            <a href="#pasal-1" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">1. Ruang Lingkup &amp; Dasar Hukum</span>
                            </a>
                            <a href="#pasal-2" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">2. Jenis Data yang Dikumpulkan</span>
                            </a>
                            <a href="#pasal-3" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">3. Tujuan Pemrosesan &amp; UIM Sync</span>
                            </a>
                            <a href="#pasal-4" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">4. Pembagian Data &amp; Helpdesk NOC</span>
                            </a>
                            <a href="#pasal-5" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">5. Keamanan Enkripsi &amp; Retensi Log</span>
                            </a>
                            <a href="#pasal-6" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">6. Hak &amp; Kewajiban Teknisi Mitra</span>
                            </a>
                            <a href="#pasal-7" class="toc-link flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-medium transition-all group">
                                <span class="truncate">7. Kontak DPO &amp; Helpdesk Sukabumi</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Unit Pengawas Callout Card -->
                    <div class="bg-gradient-to-br from-white to-blue-50/50 p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-primary shrink-0 border border-red-100">
                                <span class="material-symbols-outlined text-xl">security</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline font-bold text-xs text-slate-900">Unit Legal &amp; Governance</span>
                                <span class="font-telemetry text-[11px] text-slate-500">Regional Network III Jabar</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setiap pembaruan data optik atau keluhan penanganan kerahasiaan dapat dikonsultasikan langsung ke Helpdesk DPO Sukabumi.
                        </p>
                    </div>
                </aside>

                <!-- Right Column: Comprehensive Content Sections -->
                <div class="lg:col-span-8 flex flex-col gap-8 order-1 lg:order-2" id="clauses-container">
                    
                    <!-- Pasal 1 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-1">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">01</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Ruang Lingkup &amp; Dasar Hukum Kedinasan</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB I : LEGAL BASIS</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kebijakan Privasi dan Perlindungan Data Operasional ini merupakan standar operasional prosedur kedinasan yang mengikat secara menyeluruh bagi seluruh personel internal PT Telkom Akses Witel Sukabumi, mitra pelaksana teknis (vendor subkontraktor), teknisi provisioning, dispatcher, serta tim pemeliharaan infrastruktur jaringan optik.
                        </p>

                        <!-- Dasar Hukum Bento Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-1.5 text-primary">
                                    <span class="material-symbols-outlined text-[18px]">account_balance</span>
                                    <span class="font-telemetry text-[11px] uppercase font-bold">Undang-Undang Republik Indonesia</span>
                                </div>
                                <span class="font-headline font-bold text-sm text-slate-900">UU No. 27 Tahun 2022 (UU PDP)</span>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Kepatuhan terhadap prinsip pemrosesan data pribadi secara sah, transparan, terukur, dan akuntabel sesuai perundang-undangan perlindungan data konsumen serta personel kerja.
                                </p>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-1.5 text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">policy</span>
                                    <span class="font-telemetry text-[11px] uppercase font-bold">Direktif Korporat Telkom Group</span>
                                </div>
                                <span class="font-headline font-bold text-sm text-slate-900">SOP O&amp;M FTTH &amp; GPON No. 41/2024</span>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Prosedur Operasi Standar Validasi Data Fisik Valins, manajemen redaman sinyal optik, dan standardisasi penamaan aset ODN (Optical Distribution Network).
                                </p>
                            </div>
                        </div>

                        <!-- Alert Callout -->
                        <div class="bg-blue-50/70 border border-blue-200/70 p-4 rounded-xl flex items-start gap-3">
                            <span class="material-symbols-outlined text-tertiary text-xl mt-0.5 shrink-0">info</span>
                            <div class="flex flex-col gap-1">
                                <span class="font-headline text-xs font-bold text-slate-900 uppercase tracking-wide">Penerapan Yurisdiksi Kedinasan</span>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Segala aktivitas input, penarikan, pengunggahan data redaman serta geotagging lokasi kabinet fiber optik tunduk pada jurisdiksi operasional Kantor Perwakilan Witel Sukabumi yang mencakup wilayah administrasi Kota Sukabumi, Kabupaten Sukabumi, serta perbatasan Wilayah Cianjur Barat.
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- Pasal 2 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-2">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">02</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Jenis Data yang Dikumpulkan &amp; Diproses</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB II : DATA TAXONOMY</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Dalam rangka memastikan kepatuhan teknis dan validasi fisik instalasi kabel optik, Sistem Informasi Manajemen Valins Sukabumi mengumpulkan dua klasifikasi data:
                        </p>

                        <!-- Split Visual Breakdown of Data -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Data Personel Field Card -->
                            <div class="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200/60 flex flex-col gap-3">
                                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                                    <span class="material-symbols-outlined text-primary text-xl">badge</span>
                                    <span class="font-headline font-bold text-sm text-slate-900">1. Data Personel Lapangan</span>
                                </div>
                                <ul class="flex flex-col gap-2.5 text-xs text-slate-600">
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-primary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">NIK &amp; Identitas Pegawai:</strong> Nomor Induk Kependudukan &amp; ID Karyawan/Mitra resmi.</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-primary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Kontak Operasional:</strong> Nomor seluler WhatsApp dinas untuk dispatching alert.</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-primary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Unit &amp; STO Induk:</strong> Penugasan regu (IOAN, B2B, Maintenance Cikole/Palabuhanratu).</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-primary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Biometrik Wajah Singkat:</strong> Foto swafoto presensi saat open order validasi lapangan.</div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Data Teknis Telemetri Card -->
                            <div class="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200/60 flex flex-col gap-3">
                                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                                    <span class="material-symbols-outlined text-tertiary text-xl">settings_input_antenna</span>
                                    <span class="font-headline font-bold text-sm text-slate-900">2. Data Teknis Optik Lapangan</span>
                                </div>
                                <ul class="flex flex-col gap-2.5 text-xs text-slate-600">
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-tertiary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Koordinat Geotagging GPS:</strong> Titik Latitude/Longitude tiang, ODC &amp; ODP presisi tinggi (&lt; 3m).</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-tertiary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Redaman Optik (Power):</strong> Angka dBm hasil ukur OPM pada port splitter 1:8 / 1:16.</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-tertiary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Dokumentasi Enclosure:</strong> Foto barcode QR ODP, kerapihan kaset tray, dan grounding tiang.</div>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-xs text-tertiary mt-1 shrink-0">check_circle</span>
                                        <div><strong class="text-slate-900">Status Port Dropcore:</strong> Port idle, port aktif pelanggan, serta port rusak/loss.</div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Strict Warning Banner -->
                        <div class="p-4 rounded-xl bg-red-50 border border-red-200/80 flex items-start gap-3">
                            <span class="material-symbols-outlined text-red-600 text-xl shrink-0 mt-0.5">warning</span>
                            <div class="flex flex-col gap-1">
                                <span class="font-headline text-xs font-bold text-red-800 uppercase">LARANGAN KERAS PEMBOCORAN DATA TOPOLOGI FIBER</span>
                                <p class="text-xs text-red-700 leading-relaxed">
                                    Data peta jalur kabel tanam (feeder &amp; distribution) dan titik terminasi ODC merupakan <strong>Objek Vital Telekomunikasi Nasional (OVNI)</strong>. Setiap upaya mengunduh atau menyebarluaskan koordinat topologi di luar website monitoring dikenakan sanksi pemutusan kontrak kemitraan serta tuntutan pidana sesuai UU PDP Pasal 65 ayat (2).
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- Pasal 3 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-3">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">03</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Tujuan Pemrosesan &amp; Sinkronisasi UIM / NMS</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB III : SYSTEM INTEGRATION</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Seluruh data telemetri dan input teknis personel diproses secara otomatis melalui pipa sinkronisasi terenkripsi dengan Unified Inventory Management (UIM) PT Telkom Indonesia untuk tujuan-tujuan berikut:
                        </p>

                        <!-- Process Flow Visualization -->
                        <div class="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200/60 flex flex-col gap-3">
                            <span class="font-telemetry text-[11px] text-slate-500 uppercase font-bold">Alur Pemrosesan Validasi Data Lapangan</span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 flex flex-col gap-1.5 shadow-2xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-6 h-6 rounded-full bg-red-100 text-primary font-telemetry text-xs font-bold flex items-center justify-center">01</span>
                                        <span class="material-symbols-outlined text-sm text-slate-400">qr_code_scanner</span>
                                    </div>
                                    <span class="font-headline font-bold text-xs text-slate-900 mt-1">Pemindaian QR &amp; Input dBm</span>
                                    <span class="text-[11px] text-slate-500 leading-snug">Teknisi membaca label ODP di tiang fisik dan menginput redaman optik aktual.</span>
                                </div>

                                <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 flex flex-col gap-1.5 shadow-2xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-6 h-6 rounded-full bg-blue-100 text-tertiary font-telemetry text-xs font-bold flex items-center justify-center">02</span>
                                        <span class="material-symbols-outlined text-sm text-slate-400">sync_alt</span>
                                    </div>
                                    <span class="font-headline font-bold text-xs text-slate-900 mt-1">UIM Core Cross-Check</span>
                                    <span class="text-[11px] text-slate-500 leading-snug">Server Valins mencocokkan kapasitas port riil terhadap data master UIM pusat.</span>
                                </div>

                                <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 flex flex-col gap-1.5 shadow-2xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-telemetry text-xs font-bold flex items-center justify-center">03</span>
                                        <span class="material-symbols-outlined text-sm text-slate-400">verified</span>
                                    </div>
                                    <span class="font-headline font-bold text-xs text-slate-900 mt-1">Penerbitan Sertifikat Valins</span>
                                    <span class="text-[11px] text-slate-500 leading-snug">ODP berstatus compliant, aman dialokasikan pesanan pelanggan IndiHome / Astinet.</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-slate-600">
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1">
                                <span class="font-headline font-bold text-slate-900">1. Penugasan Work Order (WO) Otomatis</span>
                                <span>Data lokasi GPS teknisi digunakan untuk dispatching tiket gangguan darurat (LOS/High Attenuation) terdekat di Sukabumi.</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex flex-col gap-1">
                                <span class="font-headline font-bold text-slate-900">2. Audit Splice Loss &amp; Kualitas Redaman</span>
                                <span>Memetakan potensi macrobending atau fiber bending pada kabel drop optic di sepanjang jalur Sukabumi - Pelabuhan Ratu.</span>
                            </div>
                        </div>
                    </article>

                    <!-- Pasal 4 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">04</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Pembagian Data ke Dispatcher &amp; Helpdesk NOC</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB IV : ACCESS CONTROL</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Data operasional telekomunikasi yang dihimpun dibagikan hanya atas dasar asas <em>Need-to-Know</em> dan <em>Principle of Least Privilege</em>. Pihak-pihak yang memiliki hak akses terbatas mencakup:
                        </p>

                        <!-- Access Matrix Table -->
                        <div class="w-full overflow-x-auto rounded-xl border border-slate-200/80">
                            <table class="w-full min-w-[660px] text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-700 font-telemetry text-[11px] uppercase tracking-wider border-b border-slate-200">
                                        <th class="p-3 font-bold w-[22%] whitespace-nowrap">Entitas Penerima</th>
                                        <th class="p-3 font-bold w-[20%] whitespace-nowrap">Tingkat Hak Akses</th>
                                        <th class="p-3 font-bold w-[38%]">Cakupan Data yang Dibagikan</th>
                                        <th class="p-3 font-bold text-right w-[20%] whitespace-nowrap">Protokol Keamanan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-3 font-semibold text-slate-900 whitespace-nowrap">Dispatcher Area Sukabumi</td>
                                        <td class="p-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200/80 font-telemetry text-[11px] font-bold tracking-wide uppercase whitespace-nowrap">READ / DISPATCH</span>
                                        </td>
                                        <td class="p-3 leading-relaxed">Lokasi regu, status tiket WO, dan kontak WhatsApp dinas.</td>
                                        <td class="p-3 font-telemetry text-right text-tertiary font-semibold whitespace-nowrap">MFA + IP Whitelist</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-3 font-semibold text-slate-900 whitespace-nowrap">Helpdesk NOC Regional III</td>
                                        <td class="p-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 font-telemetry text-[11px] font-bold tracking-wide uppercase whitespace-nowrap">FULL TELEMETRY</span>
                                        </td>
                                        <td class="p-3 leading-relaxed">Grafik attenuation loss GPON, link OLT-ODC, dan status ODP offline.</td>
                                        <td class="p-3 font-telemetry text-right text-tertiary font-semibold whitespace-nowrap">VPN IPSec Cisco</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-3 font-semibold text-slate-900 whitespace-nowrap">Mitra Pelaksana (Subkon)</td>
                                        <td class="p-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200/80 font-telemetry text-[11px] font-bold tracking-wide uppercase whitespace-nowrap">RESTRICTED WO</span>
                                        </td>
                                        <td class="p-3 leading-relaxed">Hanya ID ODP target yang ditugaskan dalam tiket WO berjalan.</td>
                                        <td class="p-3 font-telemetry text-right text-tertiary font-semibold whitespace-nowrap">OTP Session (8h)</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-3 font-semibold text-slate-900 whitespace-nowrap">Audit Internal Telkom Akses</td>
                                        <td class="p-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200/80 font-telemetry text-[11px] font-bold tracking-wide uppercase whitespace-nowrap">AUDIT LOGS READ</span>
                                        </td>
                                        <td class="p-3 leading-relaxed">Log mutasi port, riwayat redaman, dan timestamp validasi fisik.</td>
                                        <td class="p-3 font-telemetry text-right text-tertiary font-semibold whitespace-nowrap">Encrypted Archive</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </article>

                    <!-- Pasal 5 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-5">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">05</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Keamanan Enkripsi TLS v1.3 &amp; Retensi Log</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB V : DATA DEFENSE</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Infrastruktur Data Valins &amp; GPON Witel Sukabumi dibangun di atas arsitektur Zero-Trust Network Architecture dengan proteksi data bertingkat:
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-lg">lock</span>
                                    <span class="font-headline font-bold text-xs text-slate-900">In-Transit TLS 1.3</span>
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">
                                    Semua lalu lintas API mobile Valins terenkripsi cipher suite ECDHE-RSA-AES256-GCM-SHA384.
                                </span>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-lg">enhanced_encryption</span>
                                    <span class="font-headline font-bold text-xs text-slate-900">At-Rest AES-256</span>
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">
                                    Basis data NIK personel dan koordinat ODP di-enkripsi di storage disk SAN Telkom DC Sentul.
                                </span>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-lg">history_toggle_off</span>
                                    <span class="font-headline font-bold text-xs text-slate-900">Retensi 5 Tahun</span>
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">
                                    Log audit disimpan aktif selama 2 tahun dan diarsipkan dingin (cold storage) selama 3 tahun.
                                </span>
                            </div>
                        </div>

                        <!-- Secondary detail box -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-tertiary text-xl shrink-0">fingerprint</span>
                                <div class="flex flex-col">
                                    <span class="font-headline text-xs font-bold text-slate-900">Integritas Audit Trail Forensik</span>
                                    <span class="text-xs text-slate-500">Setiap klik ekspor data memicu watermark dinamis yang berisi NIK personel penarik data.</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Pasal 6 -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4 scroll-mt-44 sm:scroll-mt-48" id="pasal-6">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">06</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Hak dan Kewajiban Teknisi Mitra</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB VI : PERSONNEL RIGHTS</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                                <span class="font-headline text-xs text-tertiary uppercase font-bold flex items-center gap-1.5 pb-2 border-b border-slate-200">
                                    <span class="material-symbols-outlined text-base">assignment_turned_in</span> Hak Personel &amp; Teknisi
                                </span>
                                <ul class="flex flex-col gap-2 text-xs text-slate-600 mt-1">
                                    <li class="flex items-start gap-2">
                                        <span class="text-tertiary font-bold text-sm leading-none">•</span>
                                        <span>Hak memperoleh transparansi atas riwayat data validasi dan performa KPI yang dicatat.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-tertiary font-bold text-sm leading-none">•</span>
                                        <span>Hak mengajukan pembetulan metadata jika terdapat anomali pembacaan OPM oleh perangkat keras.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-tertiary font-bold text-sm leading-none">•</span>
                                        <span>Hak pemusnahan foto swafoto harian setelah masa retensi verifikasi penugasan selesai (30 hari).</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="flex flex-col gap-2 p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                                <span class="font-headline text-xs text-primary uppercase font-bold flex items-center gap-1.5 pb-2 border-b border-slate-200">
                                    <span class="material-symbols-outlined text-base">rule</span> Kewajiban Mutlak Personel
                                </span>
                                <ul class="flex flex-col gap-2 text-xs text-slate-600 mt-1">
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary font-bold text-sm leading-none">•</span>
                                        <span>Wajib merahasiakan kredensial akun Monitoring, token SSO, dan kunci otentikasi dua faktor (OTP).</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary font-bold text-sm leading-none">•</span>
                                        <span>Dilarang keras melakukan manipulasi GPS (Fake GPS) saat pelaporan titik enclosure ODP di lapangan.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary font-bold text-sm leading-none">•</span>
                                        <span>Wajib segera melapor ke Helpdesk NOC apabila gawai dinas hilang atau tercuri dalam 1x24 jam.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </article>

                    <!-- Pasal 7 & Kontak Tim DPO -->
                    <article class="clause-section bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-5 scroll-mt-44 sm:scroll-mt-48" id="pasal-7">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="h-7 w-7 rounded-lg bg-primary text-white font-telemetry text-xs flex items-center justify-center font-bold">07</span>
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Kontak Tim Data Protection Officer (DPO)</h2>
                            </div>
                            <span class="font-telemetry text-[11px] text-slate-400 uppercase font-semibold hidden sm:inline">BAB VII : GOVERNANCE DESK</span>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Untuk pengajuan keberatan pemrosesan data, eskalasi insiden kebocoran informasi, atau permohonan audit akses log, personel berwenang dapat menghubungi pejabat Data Protection Officer Telkom Akses Witel Sukabumi:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="dpo-contact">
                            <!-- DPO Contact Card -->
                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/60 flex flex-col gap-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center">
                                        <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline font-bold text-xs text-slate-900">Unit DPO &amp; Kepatuhan Legal</span>
                                        <span class="text-[11px] text-slate-500">Telkom Akses Regional Network III Sukabumi</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 mt-1 text-xs text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-tertiary">mail</span>
                                        <span class="font-telemetry text-xs text-slate-800">dpo.sukabumi@telkomakses.co.id</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-tertiary">call</span>
                                        <span class="font-telemetry text-xs text-slate-800">(0266) 221000 psw. 412 (Jam Kerja)</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-sm text-tertiary shrink-0 mt-0.5">location_on</span>
                                        <span>Jl. R. E. Martadinata No.24, Gunungparang, Kec. Cikole, Kota Sukabumi, Jawa Barat 43111</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 24/7 Escalation NOC Desk -->
                            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200/60 flex flex-col gap-3" id="eskalasi-noc">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-tertiary text-white flex items-center justify-center">
                                        <span class="material-symbols-outlined text-lg">crisis_alert</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline font-bold text-xs text-slate-900">Eskalasi Darurat Keamanan Siber</span>
                                        <span class="text-[11px] text-slate-500">Computer Security Incident Response Team (CSIRT)</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 mt-1 text-xs text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">phone_in_talk</span>
                                        <span class="font-telemetry text-xs font-bold text-primary">Hotline 24/7: 0800-1-Valins</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-tertiary">chat</span>
                                        <span class="font-telemetry text-xs text-slate-800">Telegram Bot: @TA_SKB_SEC_BOT</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-emerald-600">timer</span>
                                        <span>SLA Respons Pertama: &lt; 15 Menit sejak laporan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Official Stamp & Endorsement Box -->
                        <div class="mt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-xl bg-slate-50 border border-slate-200/80 relative overflow-hidden">
                            <!-- Left Group: Logo & Legal Entity -->
                            <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
                                <div class="h-14 sm:h-16 px-3.5 sm:px-4 py-2 rounded-xl bg-white border border-slate-200/90 flex items-center justify-center shrink-0 shadow-2xs">
                                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                                         alt="Logo Resmi PT Telkom Akses" 
                                         class="h-7 sm:h-8 w-auto object-contain"
                                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-telemetry text-[10px] text-slate-500 uppercase font-bold tracking-wider">Otorisasi &amp; Pengesahan Dokumen</span>
                                    <span class="font-headline font-bold text-xs sm:text-sm text-slate-900 truncate">PT Telkom Akses Witel Sukabumi</span>
                                    <span class="font-telemetry text-[11px] text-emerald-700 font-semibold mt-0.5">Status: DISAHKAN &amp; DIBERLAKUKAN SECARA ELEKTRONIK</span>
                                </div>
                            </div>

                            <!-- Right Group: Document Metadata & Digital Verification Badge -->
                            <div class="flex flex-col items-start sm:items-end gap-1.5 shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-200/60 w-full sm:w-auto">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[11px] font-bold">
                                    <span class="material-symbols-outlined text-[14px] text-emerald-600">verified</span>
                                    <span>Terverifikasi Digital</span>
                                </div>
                                <span class="text-[11px] text-slate-500">Pembaruan Terakhir: Oktober 2026</span>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </div>

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
                        Masih Memiliki Pertanyaan Mengenai Kebijakan Privasi?
                    </h2>

                    <p class="text-red-100/90 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Hubungi tim Tata Kelola Data (DPO) dan Helpdesk Operasional kami apabila anda memiliki pertanyaan mengenai kebijakan privasi.
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

    <!-- Persistent Telkom Akses Operations Footer (Hidden on Mobile / Inspect < lg) -->
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
                            Sistem Informasi Manajemen Data Valins & Monitoring GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional.
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
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Hubungi Kami</span>
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
                            <a href="{{ route('privacy.policy') }}" class="group flex items-center gap-2 text-[#bc0007] font-semibold transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms.conditions') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
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
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO SKB - Sukabumi Kota</span>
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

    <!-- Client-Side Search, ToC Scrollspy & Mobile Menu Script -->
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
    </script>
</body>
</html>
