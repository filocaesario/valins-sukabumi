<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>
    <meta name="description" content="Pusat layanan komunikasi terpadu Monitoring Valins & Operasional Jaringan GPON PT Telkom Akses Witel Sukabumi. Siap melayani eskalasi lapangan, validasi redaman ODP, dan aduan pelanggan.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Leaflet.js Interactive Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
                        "primary-container": "#ee2e24",
                        "primary-deep": "#880e0a",
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

        /* Dynamic Nav Link Styling - Frameless with Glowing Animated Underline */
        .nav-link-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.8rem;
            font-size: 0.865rem;
            font-weight: 600;
            color: #475569;
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
        .nav-link-item:active {
            transform: translateY(0.5px) scale(0.97);
            transition-duration: 0.08s;
        }
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

        /* Action Buttons */
        .btn-header-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b;
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
        }
        .btn-header-login:hover {
            color: #bc0007;
            border-color: #fca5a5;
            background-color: #fff8f8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px -2px rgba(188, 0, 7, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
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
        .btn-header-register:hover {
            background: linear-gradient(135deg, #e3000a 0%, #c90008 50%, #a60006 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px -3px rgba(188, 0, 7, 0.55), 0 4px 10px -2px rgba(188, 0, 7, 0.35);
        }
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

        /* Partner Logos & Social Polish */
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
            transition: transform 0.28s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.25s ease;
        }
        .partner-logo-item:hover {
            transform: translate3d(0, -4px, 0) scale(1.06);
            opacity: 1;
        }
        .partner-logo-item img {
            pointer-events: none;
            user-select: none;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.04));
        }
        .btn-instagram-bg {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .btn-instagram:hover {
            border-color: transparent !important;
            box-shadow: 0 4px 14px -1px rgba(214, 36, 159, 0.45), 0 2px 6px -1px rgba(253, 89, 73, 0.3) !important;
        }

        /* Leaflet custom styling */
        .leaflet-popup-content-wrapper {
            border-radius: 14px !important;
            padding: 4px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid #fee2e2 !important;
        }
        .leaflet-popup-content {
            margin: 12px 14px !important;
            line-height: 1.4 !important;
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
    <header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 h-18 sm:h-20 flex items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Tombol Kembali Panah Kiri (Khusus Mobile) & Logo Resmi Telkom Akses (Desktop Only) -->
            <!-- Mobile Back Arrow Button -->
            <button type="button" 
                    onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ url('/') }}'; }" 
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-primary border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                    title="Kembali ke Halaman Sebelumnya"
                    aria-label="Kembali ke Halaman Sebelumnya">
                <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-primary transition-colors">arrow_back</span>
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
                                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                                <span>Buka Dashboard</span>
                            </a>
                        </div>
                    @else
                        <!-- Guest Auth Buttons (Desktop Only) -->
                        <div class="hidden lg:flex items-center gap-2.5 sm:gap-3">
                            <a href="{{ route('login') }}" 
                               class="btn-header-login group"
                               title="Masuk ke Akun">
                                <span class="material-symbols-outlined text-[18px] text-slate-500 group-hover:text-primary transition-colors">login</span>
                                <span>Masuk</span>
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="btn-header-register group"
                                   title="Pendaftaran Akun Baru">
                                    <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                                    <span>Daftar Akun</span>
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif

                <!-- Mobile Home Button -->
                <a href="{{ url('/') }}" 
                   class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-primary border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                   title="Kembali ke Beranda"
                   aria-label="Kembali ke Beranda">
                    <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-primary transition-colors">home</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full flex-1 flex flex-col">
        
        <!-- ================= SECTION 1: HERO BANNER (Clean Light Enterprise Aesthetic) ================= -->
        <section class="relative w-full bg-white text-slate-900 border-b border-slate-200/80 py-10 sm:py-12 px-4 sm:px-6 lg:px-8 xl:px-12 shadow-2xs">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-4">
                <!-- Page Headline & Operational Metadata -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200/80 text-primary text-xs font-bold tracking-wider uppercase mb-3 shadow-2xs font-telemetry">
                            <span class="material-symbols-outlined text-[16px] text-primary">support_agent</span>
                            <span>PUSAT KOMUNIKASI &amp; ESKALASI TERPADU</span>
                        </div>
                        <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Hubungi Kami &amp; Pusat Layanan <span class="text-primary">Pengaduan Teknis</span>
                        </h1>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mt-2 max-w-2xl">
                            Layanan terintegrasi data Valins &amp; Operasional Jaringan GPON Telkom Akses Witel Sukabumi. Siap melayani eskalasi lapangan, validasi redaman ODP, permohonan BAST, dan aduan gangguan jaringan optik.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 2: DUAL-COLUMN CORE SECTION (Informasi Kontak & Kirim Formulir) ================= -->
        <section class="w-full py-8 sm:py-12 px-4 sm:px-6 lg:px-8 xl:px-12 bg-surface">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- KOLOM KIRI (4 Cols): Informasi Kontak & Hotline Cepat -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    
                    <!-- Card 1: Informasi Kontak Resmi Kantor Operasional -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-slate-200/90 flex flex-col gap-5">
                        <div class="border-b border-slate-100 pb-4">
                            <div class="flex items-center justify-between">
                                <h2 class="font-headline text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-2xl">apartment</span>
                                    <span>Informasi Kontak Resmi</span>
                                </h2>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Layanan terpadu kantor operasional &amp; NOC Telkom Akses Sukabumi.</p>
                        </div>

                        <div class="flex flex-col gap-4 text-xs sm:text-sm">
                            <!-- Alamat Kantor -->
                            <div class="flex items-start gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-red-100 transition-colors border border-red-100/80 shadow-2xs">
                                    <span class="material-symbols-outlined text-xl">location_on</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">Alamat Kantor Wilayah</span>
                                    <p class="text-slate-600 text-xs leading-relaxed mt-0.5">
                                        Jl. R. E. Martadinata No.24, Gunungparang, Kec. Cikole,<br>
                                        Kota Sukabumi, Jawa Barat 43111
                                    </p>
                                    <span class="text-[11px] font-semibold text-primary mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[13px]">domain</span>
                                        <span>Telkom Akses Witel Sukabumi • Kantor Unit Akses</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Telepon & Dispatcher -->
                            <div class="flex items-start gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-red-100 transition-colors border border-red-100/80 shadow-2xs">
                                    <span class="material-symbols-outlined text-xl">phone_in_talk</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">Telepon &amp; Dispatcher Hotline</span>
                                    <a href="tel:0266221100" class="font-telemetry font-bold text-slate-800 hover:text-primary transition-colors text-xs sm:text-sm mt-0.5">
                                        (0266) 221-100 / ext. 408 - 412
                                    </a>
                                    <span class="text-[11px] text-slate-500">Pusat Komando Kendali Dispatcher Sukabumi</span>
                                </div>
                            </div>

                            <!-- Email Resmi Kedinasan -->
                            <div class="flex items-start gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-red-100 transition-colors border border-red-100/80 shadow-2xs">
                                    <span class="material-symbols-outlined text-xl">mail</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">Email Komunikasi &amp; Administrasi</span>
                                    <a href="mailto:noc.sukabumi@telkomakses.co.id" class="font-telemetry text-xs text-slate-600 hover:text-primary transition-colors font-medium mt-0.5 break-all">
                                        noc.sukabumi@telkomakses.co.id
                                    </a>
                                    <a href="mailto:admin.sukabumi@telkomakses.co.id" class="font-telemetry text-[11px] text-slate-500 hover:text-primary transition-colors break-all">
                                        admin.sukabumi@telkomakses.co.id
                                    </a>
                                </div>
                            </div>

                            <!-- Jam Layanan & NOC Siaga -->
                            <div class="flex items-start gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-red-100 transition-colors border border-red-100/80 shadow-2xs">
                                    <span class="material-symbols-outlined text-xl">schedule</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">Jam Layanan &amp; Siaga</span>
                                    <p class="text-xs text-slate-600 mt-0.5">
                                        Setiap Hari: <span class="font-telemetry font-semibold text-slate-900">08.00 - 21.00 WIB</span> (Kantor)<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (8 Cols): Formulir Terpadu Kirim Tiket & Pengaduan -->
                <div class="lg:col-span-8 bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200/90 flex flex-col gap-6">
                    
                    <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h2 class="font-headline text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-primary text-2xl">rate_review</span>
                                <span>Kirim Pesan &amp; Pengaduan Teknis</span>
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Formulir terpadu validasi VALINS, keluhan redaman GPON, pengajuan BAST mitra, dan kebutuhan bantuan teknisi.
                            </p>
                        </div>
                    </div>

                    <form id="contactForm" onsubmit="event.preventDefault(); handleSubmit();" class="flex flex-col gap-5">
                        
                        <!-- Row 1: Kategori Layanan & ID Pelapor -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div class="flex flex-col gap-1.5">
                                <label for="inputKategori" class="text-xs sm:text-sm font-bold text-slate-800 flex items-center justify-between">
                                    <span>Kategori Pengaduan <span class="text-primary">*</span></span>
                                </label>
                                <select id="inputKategori" required class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                    <option value="valins">Validasi Data Valins &amp; ODP Barcode</option>
                                    <option value="gpon">Gangguan Redaman GPON / Optical Cut STO</option>
                                    <option value="public">Pengaduan Layanan / Keluhan Pelanggan</option>
                                    <option value="vendor">Kemitraan, BAST &amp; Subkontraktor</option>
                                    <option value="other">Pertanyaan &amp; Konsultasi Teknis Umum</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="inputIdPelapor" class="text-xs sm:text-sm font-bold text-slate-800 flex items-center justify-between">
                                    <span>ID Pelapor / NIK / ID Teknisi</span>
                                    <span class="text-[11px] text-slate-400 font-normal">Opsional</span>
                                </label>
                                <input type="text" id="inputIdPelapor" placeholder="Contoh: SMI-TK-1082 / NIK" 
                                       class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-telemetry">
                            </div>
                        </div>

                        <!-- Row 2: Nama Lengkap & Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div class="flex flex-col gap-1.5">
                                <label for="inputNama" class="text-xs sm:text-sm font-bold text-slate-800">
                                    Nama Lengkap <span class="text-primary">*</span>
                                </label>
                                <input type="text" id="inputNama" name="nama" placeholder="Masukkan nama lengkap Anda" required 
                                       class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="inputEmail" class="text-xs sm:text-sm font-bold text-slate-800">
                                    Email Korespondensi <span class="text-primary">*</span>
                                </label>
                                <input type="email" id="inputEmail" name="email" placeholder="nama@email.com" required 
                                       class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-telemetry">
                            </div>
                        </div>

                        <!-- Row 3: No WhatsApp & Target STO / ID ODP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div class="flex flex-col gap-1.5">
                                <label for="inputPhone" class="text-xs sm:text-sm font-bold text-slate-800">
                                    Nomor WhatsApp Aktif <span class="text-primary">*</span>
                                </label>
                                <input type="tel" id="inputPhone" placeholder="08xxxxxxxxxx" required 
                                       class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-telemetry">
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="inputSto" class="text-xs sm:text-sm font-bold text-slate-800 flex items-center justify-between">
                                    <span>Target STO / ID ODP Terkait</span>
                                    <span class="text-[11px] text-slate-400 font-normal">Jika relevan</span>
                                </label>
                                <input type="text" id="inputSto" placeholder="Contoh: STO-SMI / ODP-SMI-FA/02" 
                                       class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-telemetry">
                            </div>
                        </div>

                        <!-- Row 4: Subjek Tiket -->
                        <div class="flex flex-col gap-1.5">
                            <label for="inputSubjek" class="text-xs sm:text-sm font-bold text-slate-800">
                                Subjek Laporan<span class="text-primary">*</span>
                            </label>
                            <input type="text" id="inputSubjek" name="subjek" placeholder="Ringkasan kendala, audit ODP, atau permohonan bantuan" required 
                                   class="w-full h-11 px-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>

                        <!-- Row 5: Kronologi & Keterangan Masalah -->
                        <div class="flex flex-col gap-1.5">
                            <label for="inputPesan" class="text-xs sm:text-sm font-bold text-slate-800">
                                Detail Kronologi &amp; Keterangan Masalah <span class="text-primary">*</span>
                            </label>
                            <textarea id="inputPesan" name="pesan" rows="4" required 
                                      placeholder="Sebutkan detail kendala, titik lokasi ODP/ODC, nilai dBm redaman terukur, atau nomor referensi sebelumnya..." 
                                      class="w-full p-3.5 rounded-xl bg-slate-50/80 border border-slate-200 text-slate-800 placeholder:text-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-y"></textarea>
                        </div>

                        <!-- Row 6: Upload Bukti Lapangan / Foto Redaman OPM -->
                        <div class="p-4 rounded-xl border border-dashed border-red-200 bg-red-50/40 flex flex-col gap-2.5 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <label for="fileAttachment" class="text-xs sm:text-sm font-bold text-slate-800 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-primary text-base">attach_file</span>
                                    <span>Lampiran Foto Lapangan / Bukti Redaman OPM (Opsional)</span>
                                </label>
                                <span class="text-[11px] text-slate-500 font-telemetry">PNG, JPG, PDF (Maks. 10MB)</span>
                            </div>
                            <input type="file" id="fileAttachment" 
                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary-dark cursor-pointer">
                            <span class="text-[11px] text-slate-500">
                                Unggah bukti barcode ODP, screenshot OPM, atau dokumen pendukung untuk percepatan investigasi oleh NOC.
                            </span>
                        </div>

                        <!-- Form Footer: Disclaimer & Submit Button -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                            <span class="text-[11px] text-slate-500 flex items-center gap-1.5">
                                <span></span>
                            </span>
                            <button type="submit" id="btnSubmit" 
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary hover:bg-primary-dark active:bg-primary-deep text-white font-bold text-xs sm:text-sm tracking-wide shadow-md hover:shadow-lg transition-all group shrink-0">
                                <span>Kirim Pesan &amp; Pengaduan</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        

        <!-- ================= SECTION 4: INTERACTIVE GIS MAP & 5 POSKO STO COVERAGE ================= -->
        <section class="w-full py-10 sm:py-14 px-4 sm:px-6 lg:px-8 xl:px-12 bg-slate-50/60 border-t border-slate-200/80">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-primary text-xs font-bold uppercase tracking-wider mb-2 border border-red-200/60 font-telemetry">
                            <span class="material-symbols-outlined text-sm">map</span>
                            <span>CENTRAL HUB & GIS COVERAGE</span>
                        </div>
                        <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Lokasi &amp; Kantor Telkom Akses Witel Sukabumi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl">
                            Kunjungi Kantor Telkom Akses Witel Sukabumi.
                        </p>
                    </div>

                    <a href="https://maps.google.com/?q=Plaza+Telkom+Sukabumi" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:border-primary/40 text-slate-800 hover:text-primary font-bold text-xs sm:text-sm shadow-2xs transition-all self-start md:self-auto shrink-0">
                        <span class="material-symbols-outlined text-primary text-base">directions</span>
                        <span>Petunjuk Arah Google Maps</span>
                    </a>
                </div>

                <!-- Map Container with Leaflet Interactive Canvas & Floating Info Box -->
                <div class="relative w-full h-[400px] md:h-[480px] rounded-2xl overflow-hidden shadow-md border border-slate-200/90 bg-slate-100">
                    
                    <!-- Leaflet Container -->
                    <div id="interactive-contact-map" class="w-full h-full z-0"></div>

                    <!-- Floating Office Badge Card (Hidden on Mobile / Inspect < lg) -->
                    <div class="hidden lg:block absolute top-4 left-4 z-10 max-w-sm w-80 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 shadow-xl border border-slate-200/90">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span class="font-headline font-extrabold text-slate-900 text-sm sm:text-base">
                                    Telkom Akses Witel Sukabumi
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 leading-snug">
                                Jl. R. E. Martadinata No.24, Gunungparang, Kec. Cikole, Kota Sukabumi, Jawa Barat 43111
                            </p>
                            
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="font-telemetry text-xs font-bold text-amber-700">5.0</span>
                                <div class="flex items-center text-amber-500 text-xs">
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    <span class="material-symbols-outlined text-xs">star</span>
                                </div>
                                <span class="text-[11px] text-slate-500">• Kantor Perusahaan</span>
                            </div>

                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                                <a href="https://maps.google.com/?q=Plaza+Telkom+Sukabumi" target="_blank" rel="noopener noreferrer" 
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-dark text-white text-xs font-bold shadow-xs transition-colors">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    <span>Buka Maps</span>
                                </a>
                                <button type="button" id="btnRecenterContactMap" 
                                        class="p-1.5 px-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1"
                                        title="Kembali ke Titik Pusat">
                                    <span class="material-symbols-outlined text-sm text-primary">my_location</span>
                                    <span>Pusat</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= SECTION 5: FAQ & PUSAT BANTUAN LAPANGAN ================= -->
        <section class="w-full py-10 sm:py-14 px-4 sm:px-6 lg:px-8 xl:px-12 bg-white">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-8">
                
                <div class="flex flex-col text-center max-w-2xl mx-auto">
                    <span class="text-xs font-bold text-primary uppercase tracking-wider font-telemetry">Pusat Pengetahuan &amp; Prosedur Operasional</span>
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Pertanyaan Sering Diajukan (FAQ)
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                        Panduan ringkas seputar validasi VALINS, standarisasi redaman dBm, dan alur eskalasi tiket insiden jaringan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-5xl mx-auto w-full">
                    
                    <!-- FAQ 1 -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 hover:border-red-200 hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-primary flex items-center justify-center font-bold text-xs shrink-0 border border-red-100">
                                Q1
                            </div>
                            <div class="flex flex-col">
                                <h4 class="font-bold text-sm text-slate-900">Berapa ambang batas toleransi redaman GPON pada ODP?</h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                    Sesuai standar operasional Telkom Akses Witel Sukabumi, nilai redaman optimal di data ODP wajib dieskalasi untuk perbaikan splice core atau koreksi bending fiber.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 hover:border-red-200 hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-primary flex items-center justify-center font-bold text-xs shrink-0 border border-red-100">
                                Q2
                            </div>
                            <div class="flex flex-col">
                                <h4 class="font-bold text-sm text-slate-900">Bagaimana jika barcode ODP rusak atau tidak terbaca di aplikasi VALINS?</h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                    Gunakan formulir 'Kirim Pesan' di atas dengan melampirkan foto fisik ODP, koordinat GPS tagging, dan nomor referensi STO. Tim Dispatcher NOC akan melakukan sinkronisasi QR manual dalam tempo 30 menit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 hover:border-red-200 hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-primary flex items-center justify-center font-bold text-xs shrink-0 border border-red-100">
                                Q3
                            </div>
                            <div class="flex flex-col">
                                <h4 class="font-bold text-sm text-slate-900">Berapa lama target SLA penyelesaian gangguan masal (Optical Cut)?</h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                    Untuk kategori insiden prioritas P1 (Feeder Cut / Putus Kabel Distribusi Utama), respon dispatch tim teknis adalah <strong class="text-slate-900 font-telemetry">15 menit</strong> dengan target MTTR normalisasi maksimal 3 jam sejak laporan diverifikasi oleh NOC.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 hover:border-red-200 hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-primary flex items-center justify-center font-bold text-xs shrink-0 border border-red-100">
                                Q4
                            </div>
                            <div class="flex flex-col">
                                <h4 class="font-bold text-sm text-slate-900">Apakah mitra teknisi eksternal bisa mengajukan permohonan BAST online?</h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                    Ya, pilih kategori 'Kemitraan, BAST &amp; Vendor' pada formulir, sertakan lampiran dokumen scan Berita Acara serta ID ODP. Data otomatis dialirkan ke verifikator Manager Unit Akses Sukabumi.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ================= SECTION 3: CONFIRMATION / SUCCESS STATE BANNER ================= -->
        <section id="successSection" class="w-full bg-[#bc0007] py-10 sm:py-14 px-4 sm:px-6 lg:px-8 xl:px-12 transition-all duration-300 relative overflow-hidden" style="background-color: #bc0007; background: linear-gradient(135deg, #880e0a 0%, #bc0007 50%, #ee2e24 100%);">
            <!-- Decorative Subtle Ambient Glow (Full Red Telkom Akses, Tanpa Pola / Efek Putih) -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-red-900/30 blur-2xl pointer-events-none"></div>
            <div class="absolute -left-16 -top-16 w-80 h-80 rounded-full bg-red-950/40 blur-2xl pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto relative z-10">
                <div class="bg-white rounded-2xl p-6 sm:p-10 text-center shadow-2xl flex flex-col items-center gap-4 border border-slate-200/90">
                    
                    <!-- Icon Status -->
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-primary shadow-inner">
                        <span class="material-symbols-outlined text-4xl font-bold">check_circle</span>
                    </div>

                    <!-- Judul & Keterangan -->
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Terima Kasih Telah Menghubungi Kami
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto leading-relaxed">
                        Kepuasan dan kelancaran jaringan Anda adalah komitmen utama kami. Tim NOC Monitoring Valins &amp; Operasional Jaringan Telkom Akses Sukabumi akan menindaklanjuti laporan Anda segera.
                    </p>

                    <!-- Actions -->
                    <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                        <button type="button" onclick="resetFormAndScrollTop()" 
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-bold text-xs sm:text-sm transition-all shadow-sm">
                            Buat Laporan Baru
                        </button>
                        <a href="{{ url('/') }}" 
                           class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs sm:text-sm transition-all">
                            <span class="material-symbols-outlined text-sm">home</span>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- ================= PERSISTENT TELKOM AKSES OPERATIONS FOOTER ================= -->
    <footer class="hidden lg:block w-full bg-white border-t border-slate-200/80 shadow-xs mt-0 pt-8 sm:pt-10 pb-5 text-left" id="footer">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 xl:gap-10">
                
                <!-- Column 1: Brand & Profil + Kontak Bantuan NOC (lg:col-span-5) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                                 alt="Logo Resmi PT Telkom Akses" 
                                 class="h-11 sm:h-12 md:h-13 w-auto object-contain shrink-0"
                                 onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-md">
                            Sistem Informasi Manajemen Data Valins &amp; Monitoring GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional Witel Sukabumi.
                        </p>
                        <div class="flex flex-wrap items-center gap-2.5 mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-sky-800 text-[11px] font-semibold border border-slate-200">
                                <span class="material-symbols-outlined text-[15px] text-sky-600">verified</span>
                                <span>BUMN Terpercaya</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-primary text-[11px] font-semibold border border-red-200/60">
                                <span class="material-symbols-outlined text-[15px]">security</span>
                                <span>ISO 27001 Certified</span>
                            </span>
                        </div>
                    </div>

                    <!-- Kontak Bantuan NOC -->
                    <div class="flex flex-col pt-1">
                        <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-3">
                            <span>KONTAK BANTUAN NOC</span>
                        </div>
                        <div class="flex flex-col gap-2.5 max-w-md">
                            <a href="tel:0266221100" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-red-50/60 border border-slate-100 hover:border-red-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-red-100 text-primary flex items-center justify-center shrink-0 border border-red-200/60 group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[19px]">call</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-primary transition-colors leading-tight">Hotline Fixed Line</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">(0266) 221-100 / ext. 408</span>
                                </div>
                            </a>

                            <a href="https://wa.me/6281120098800" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 hover:border-emerald-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#25D366] flex items-center justify-center shrink-0 border border-emerald-200/60 group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-tight">WhatsApp Dispatcher</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">+62 811-2009-8800</span>
                                </div>
                            </a>

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

                <!-- Column 2: Navigasi Portal (lg:col-span-2) -->
                <div class="lg:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>NAVIGASI PORTAL</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Masuk Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Registrasi Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Validasi Data Valins</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Monitoring &amp; Rekonsiliasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact.us') }}" class="group flex items-center gap-2 text-primary font-bold transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-semibold group-hover:translate-x-0.5 transition-transform duration-200">Hubungi Kami</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Regulasi & Bantuan (lg:col-span-2) -->
                <div class="lg:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>Tentang PERUSAHAAN</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('about.us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Tentang Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.policy') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms.conditions') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Syarat &amp; Ketentuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-primary transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Arsitektur Jaringan GPON</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: 5 STO Coverage (lg:col-span-3) -->
                <div class="lg:col-span-3 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>AREA DISTRIBUSI 5 STO</span>
                    </div>
                    <div class="flex flex-col gap-2 font-telemetry text-xs">
                        <div class="bg-slate-50/90 px-3.5 py-2 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 transition-all group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate">STO SKB - Sukabumi Kota</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 transition-all group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate">STO CCR - Cicurug</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 transition-all group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate">STO CBD - Cibadak</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 transition-all group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate">STO PLR - Pelabuhanratu</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 transition-all group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate">STO SGN - Sagaranten</span>
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

    <!-- Interactive Client Scripts -->
    <script>
        // Channel / Tab Filter Switcher
        function selectChannel(btn, channelType) {
            document.querySelectorAll('.channel-tab-btn').forEach(b => {
                b.className = 'channel-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 border border-slate-200/80 transition-all flex items-center gap-1.5';
            });
            btn.className = 'channel-tab-btn active px-3.5 py-1.5 rounded-lg text-xs font-bold bg-primary text-white shadow-xs hover:bg-primary-dark transition-all flex items-center gap-1.5';

            const select = document.getElementById('inputKategori');
            if (select) {
                if (channelType === 'valins') select.value = 'valins';
                else if (channelType === 'redaman') select.value = 'gpon';
                else if (channelType === 'publik') select.value = 'public';
                else if (channelType === 'kemitraan') select.value = 'vendor';
            }
        }

        // Form Submit Handler & Pseudo Ticket Generator
        function handleSubmit() {
            const btn = document.getElementById('btnSubmit');
            const originalText = btn.innerHTML;
            
            // Loading State
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-lg">progress_activity</span><span>Mengirimkan Pesan ke Dispatcher...</span>';

            setTimeout(() => {
                // Generate pseudo ticket ID (e.g. VAL-2026-SMI-481)
                const randomNum = Math.floor(100 + Math.random() * 900);
                const currentYear = new Date().getFullYear();
                const generatedTicket = `VAL-${currentYear}-SMI-${randomNum}`;
                
                const dynamicElem = document.getElementById('dynamicTicketId');
                if (dynamicElem) {
                    dynamicElem.innerText = generatedTicket;
                }

                // Reset button
                btn.disabled = false;
                btn.innerHTML = originalText;

                // Smooth scroll to success section
                const successElem = document.getElementById('successSection');
                if (successElem) {
                    successElem.scrollIntoView({ behavior: 'smooth' });
                    successElem.classList.add('ring-4', 'ring-red-400');
                    setTimeout(() => {
                        successElem.classList.remove('ring-4', 'ring-red-400');
                    }, 1500);
                }
            }, 800);
        }

        function resetFormAndScrollTop() {
            document.getElementById('contactForm')?.reset();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Live Clock Ticker
        const timestampClock = document.getElementById('timestamp-clock');
        if (timestampClock) {
            const updateClock = () => {
                const now = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                const formatted = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())} WIB`;
                timestampClock.textContent = formatted;
            };
            updateClock();
            setInterval(updateClock, 1000);
        }

        // Interactive Leaflet Map Initialization
        document.addEventListener('DOMContentLoaded', function () {
            const mapContainer = document.getElementById('interactive-contact-map');
            if (mapContainer && typeof L !== 'undefined') {
                try {
                    // Exact Coordinates: Plaza Telkom Sukabumi (Jl. R. E. Martadinata No.24, Cikole)
                    const telkomCoords = [-6.920591, 106.928677];

                    const contactMap = L.map('interactive-contact-map', {
                        center: telkomCoords,
                        zoom: 17,
                        zoomControl: true,
                        scrollWheelZoom: false,
                        attributionControl: false
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(contactMap);

                    contactMap.on('focus', () => { contactMap.scrollWheelZoom.enable(); });
                    contactMap.on('click', () => { contactMap.scrollWheelZoom.enable(); });

                    // Custom Telkom Red Pin Marker
                    const telkomPin = L.divIcon({
                        className: 'telkom-marker-wrapper',
                        html: `
                            <div style="position: relative; display: flex; flex-direction: column; align-items: center; cursor: pointer; filter: drop-shadow(0 4px 10px rgba(188,0,7,0.45));">
                                <div style="background: linear-gradient(135deg, #e3000a 0%, #bc0007 100%); width: 38px; height: 38px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; border: 2.5px solid #ffffff;">
                                    <svg style="transform: rotate(45deg); width: 20px; height: 20px; color: #ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div style="width: 14px; height: 5px; background: rgba(15,23,42,0.4); border-radius: 50%; margin-top: 3px; filter: blur(1px);"></div>
                            </div>
                        `,
                        iconSize: [38, 46],
                        iconAnchor: [19, 44],
                        popupAnchor: [0, -44]
                    });

                    const marker = L.marker(telkomCoords, { icon: telkomPin }).addTo(contactMap);

                    const popupContent = `
                        <div style="font-family: 'Plus Jakarta Sans', Inter, sans-serif; min-width: 220px;">
                            <div style="font-size: 13px; font-weight: 800; color: #bc0007; margin-bottom: 2px;">
                                Telkom Akses Witel Sukabumi
                            </div>
                            <div style="font-size: 11px; color: #475569; margin-bottom: 6px; line-height: 1.35;">
                                Jl. R. E. Martadinata No.24, Cikole, Kota Sukabumi
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent).openPopup();

                    // Recenter button
                    const recenterBtn = document.getElementById('btnRecenterContactMap');
                    if (recenterBtn) {
                        recenterBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            contactMap.flyTo(telkomCoords, 17, { duration: 1.2 });
                            setTimeout(() => {
                                marker.openPopup();
                            }, 1250);
                        });
                    }

                    setTimeout(() => { contactMap.invalidateSize(); }, 350);
                    window.addEventListener('resize', () => { contactMap.invalidateSize(); });

                    if ('IntersectionObserver' in window) {
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    contactMap.invalidateSize();
                                }
                            });
                        }, { threshold: 0.1 });
                        observer.observe(mapContainer);
                    }
                } catch (err) {
                    console.error('Map init error:', err);
                }
            }
        });
    </script>
</body>
</html>
