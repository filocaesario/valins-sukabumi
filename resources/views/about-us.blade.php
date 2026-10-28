<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>
    <meta name="description" content="Profil resmi PT Telkom Akses Witel Sukabumi. Membangun kedaulatan digital, standarisasi validasi aset fisik VALINS, dan pemantauan telemetri GPON presisi tinggi di wilayah Sukabumi.">

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

        /* Dynamic Nav Link Styling */
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

        /* Action Buttons Header */
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
        .btn-header-login:active {
            transform: translateY(0.5px) scale(0.96);
            background-color: #fee2e2;
            border-color: #f87171;
            transition-duration: 0.08s;
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
        }
        .btn-header-register:hover {
            background: linear-gradient(135deg, #e3000a 0%, #c90008 50%, #a60006 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px -3px rgba(188, 0, 7, 0.55), 0 4px 10px -2px rgba(188, 0, 7, 0.35);
        }
        .btn-header-register:active {
            transform: translateY(0.5px) scale(0.96);
            box-shadow: 0 2px 6px rgba(188, 0, 7, 0.45);
            transition-duration: 0.08s;
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

        /* Mobile Scrollbar Hide Utility */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
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

        /* Mobile AKHLAK Carousel Fixed Width & Horizontal Swipe Rules */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @media (max-width: 1023px) {
            #akhlak-carousel {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                gap: 1rem !important;
                padding-left: 1rem !important;
                padding-right: 1.5rem !important;
                scroll-padding-left: 1rem !important;
            }

            #akhlak-carousel .akhlak-card {
                flex: 0 0 84vw !important;
                width: 84vw !important;
                min-width: 84vw !important;
                max-width: 84vw !important;
                scroll-snap-align: start !important;
                scroll-snap-stop: normal !important;
                box-sizing: border-box !important;
                height: auto !important;
                align-self: stretch !important;
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
    <header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 h-16 sm:h-18 lg:h-20 flex items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Tombol Kembali Panah Kiri (Khusus Mobile) & Logo Resmi Telkom Akses (Desktop Only) -->
            <!-- Mobile Back Arrow Button -->
            <button type="button" 
                    onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ url('/') }}'; }" 
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-[#bc0007] border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                    title="Kembali ke Halaman Sebelumnya"
                    aria-label="Kembali ke Halaman Sebelumnya">
                <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-[#bc0007] transition-colors">arrow_back</span>
            </button>

            <!-- Sisi Kiri: Logo Resmi PT Telkom Akses (Desktop Only) -->
            <a href="{{ route('home') }}" class="hidden lg:inline-flex items-center focus:outline-none group active:scale-95 transition-transform duration-200 shrink-0">
                <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                     alt="Logo Resmi PT Telkom Akses" 
                     width="165" 
                     height="42" 
                     class="h-[32px] sm:h-[36px] md:h-[40px] lg:h-[44px] max-h-[32px] sm:max-h-[36px] md:max-h-[40px] lg:max-h-[44px] w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]" 
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
                                <span class="material-symbols-outlined text-[18px]">login</span>
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

                <!-- Mobile Home Button (Gantikan Masuk, Register, & Garis Tiga di Layar Mobile) -->
                <a href="{{ url('/') }}" 
                   class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/90 hover:bg-rose-50 text-slate-700 hover:text-[#bc0007] border border-slate-200 hover:border-rose-200 transition-all duration-200 active:scale-90 shadow-2xs group focus:outline-none"
                   title="Kembali ke Beranda"
                   aria-label="Kembali ke Beranda">
                    <span class="material-symbols-outlined text-2xl text-slate-700 group-hover:text-[#bc0007] transition-colors">home</span>
                </a>
            </div>
        </div>
    </header>

    <!-- ================= MAIN CONTENT WRAPPER ================= -->
    <main class="flex-grow">
        <!-- 1. HERO CORPORATE OVERVIEW (Clean Light Enterprise Header - Perataan Kiri) -->
        <section class="relative w-full bg-white border-b border-slate-200/80 py-8 sm:py-10 lg:py-12 px-4 sm:px-6 lg:px-8 xl:px-12 shadow-2xs">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-8">
                <!-- Blok Kiri: Headline & Deskripsi (Perataan Kiri) -->
                <div class="max-w-3xl flex flex-col gap-3 text-left items-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200/80 text-[#bc0007] text-xs font-bold tracking-wider uppercase w-fit shadow-2xs font-telemetry">
                        <span class="material-symbols-outlined text-[17px] text-[#bc0007]">domain</span>
                        <span>PROFIL &amp; DEDIKASI INFRASTRUKTUR</span>
                    </div>

                    <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Membangun Kedaulatan Digital &amp; Keandalan <span class="text-[#bc0007]">Jaringan Fiber Optik Sukabumi</span>
                    </h1>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        Sebagai anak perusahaan PT Telkom Indonesia (Persero) Tbk, Telkom Akses berkomitmen menghadirkan konektivitas prima, standardisasi validasi aset fisik Valins, dan pemantauan telemetri GPON presisi tinggi hingga pelosok Jawa Barat.
                    </p>
                </div>  
            </div>
        </section>

        <!-- 3. DEDIKASI JARINGAN NASIONAL & PROFIL OPERASIONAL -->
        <section class="w-full py-14 sm:py-18 lg:py-22 bg-white border-b border-slate-200/80">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                    
                    <!-- Sisi Kiri: Narasi Kisah Operasional -->
                    <div class="lg:col-span-6 flex flex-col gap-5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold">Dedikasi Jaringan Nasional</span>
                        </div>

                        <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Profil Korporat & Transformasi Strategis
                        </h2>

                        <!-- Narasi Profil: Selalu Penuh di Desktop, Dapat Dilipat di Ponsel -->
                        <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-4">
                            <!-- Paragraf 1: Selalu Ditampilkan Penuh -->
                            <p>
                                <strong>Telkom Akses</strong> adalah anak perusahaan PT Telkom Indonesia (Persero) Tbk yang berfokus pada pengelolaan dan pengembangan jaringan akses telekomunikasi di seluruh Indonesia. Kami memastikan jutaan pelanggan terhubung dengan layanan digital seperti internet, telepon, dan televisi berlangganan melalui infrastruktur jaringan yang andal dan efisien.
                            </p>

                            <!-- Paragraf 2 & 3: Dibuka-Tutup pada Layar Ponsel, Selalu Tampil Penuh di Desktop -->
                            <div id="mobile-profile-content" class="hidden lg:!block space-y-4">
                                <p>
                                    Didirikan untuk memperkuat kualitas layanan TelkomGroup, Telkom Akses kini memasuki babak baru. Sejak tahun 2024, kami mulai memperluas cakupan layanan ke pasar eksternal di luar TelkomGroup, menjawab kebutuhan infrastruktur digital yang semakin luas dan kompleks, sesuai dengan subsidiary direction yang tertuang dalam dokumen Corporate Strategic Scenario (CSS) Telkom 2024–2027.
                                </p>
                                <p>
                                    Sejalan dengan arah transformasi tersebut, Telkom Akses hadir dengan visi baru untuk menjadi mitra strategis pilihan di industri telekomunikasi Indonesia guna mendorong kemajuan masyarakat digital. Berlandaskan semangat ini, kami berkomitmen tumbuh sebagai perusahaan managed service yang dominan dan terpercaya secara nasional, sebagai mandat yang turut diwujudkan oleh Telkom Akses Witel Sukabumi dalam menjaga keandalan infrastruktur serta mengakselerasi transformasi digital di wilayah Regional Network III Jabar.
                                </p>
                            </div>

                            <!-- Tombol Buka/Tutup Paragraf Khusus Ponsel -->
                            <button type="button" 
                                    id="btn-toggle-profile" 
                                    onclick="toggleProfileNarration()" 
                                    class="lg:hidden inline-flex items-center gap-1.5 text-xs font-bold text-[#bc0007] hover:text-[#960005] py-1 transition-colors focus:outline-none"
                                    aria-expanded="false">
                                <span id="btn-toggle-profile-text">Baca Selengkapnya Profil Transformasi</span>
                                <span id="btn-toggle-profile-icon" class="material-symbols-outlined text-base transition-transform duration-200">expand_more</span>
                            </button>
                        </div>

                        <!-- 2 Highlight Boxes (Grid 2 Kolom Kompak Berdampingan di Ponsel) -->
                        <div class="grid grid-cols-2 gap-3 sm:gap-3.5 pt-2">
                            <div class="p-3 sm:p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                                <div class="flex items-center gap-1.5 sm:gap-2 text-[#bc0007] font-bold text-[11px] sm:text-xs uppercase tracking-wider mb-1">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px] shrink-0">qr_code_scanner</span>
                                    <span class="truncate">Sinkronisasi 100%</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-normal">
                                    Audit barcode ODP &amp; tagging GPS berakurasi tinggi memangkas anomali fisik.
                                </p>
                            </div>

                            <div class="p-3 sm:p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                                <div class="flex items-center gap-1.5 sm:gap-2 text-[#bc0007] font-bold text-[11px] sm:text-xs uppercase tracking-wider mb-1">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px] shrink-0">speed</span>
                                    <span class="truncate">Deteksi Dini</span>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-normal">
                                    Polling telemetri redaman GPON setiap menit mendeteksi degradasi dBm seketika.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Foto Asli Kantor Operasional Witel Sukabumi dengan Keterangan Afiliasi -->
                    <div class="lg:col-span-6 flex flex-col gap-3">
                        <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 bg-slate-950 group">
                            <img src="{{ asset('images/landing/telkom-sukabumi-office.jpg') }}" 
                                 alt="Kantor Operasional PT Telkom Akses Witel Sukabumi" 
                                 width="800" 
                                 height="500" 
                                 class="w-full h-64 sm:h-80 md:h-[400px] lg:h-[430px] object-cover transition-transform duration-700 group-hover:scale-105"
                                 onerror="this.src='{{ asset('images/landing/noc-monitoring-room.jpg') }}'">
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. VISI & MISI PERUSAHAAN -->
        <section class="w-full py-14 sm:py-18 lg:py-22 bg-[#f8f9ff] border-b border-slate-200/80">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                
                <div class="max-w-3xl mb-8 sm:mb-12">
                    <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold block mb-1">Arah &amp; Komitmen Jangka Panjang</span>
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Visi &amp; Misi Telkom Akses
                    </h2>
                    <p class="mt-2 text-sm sm:text-base text-slate-600 leading-relaxed">
                        Kompas strategis dalam mengeksekusi keunggulan operasional, keandalan jaringan serat optik, dan kepuasan pelanggan secara berkesinambungan.
                    </p>
                </div>

                <!-- Mobile Segmented Tab Switcher (Khusus Layar Ponsel untuk Mencegah Scroll Panjang) -->
                <div class="flex lg:hidden items-center p-1 rounded-xl bg-slate-200/80 mb-6 border border-slate-300/60" role="tablist" aria-label="Pilih Tampilan Visi atau Misi">
                    <button type="button" 
                            id="tab-btn-visi" 
                            onclick="switchVisiMisiTab('visi')" 
                            class="flex-1 py-2.5 px-3 rounded-lg text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 bg-[#b30006] text-white shadow-xs"
                            role="tab"
                            aria-selected="true"
                            aria-controls="card-visi">
                        <span class="material-symbols-outlined text-[17px]">visibility</span>
                        <span>Visi</span>
                    </button>
                    <button type="button" 
                            id="tab-btn-misi" 
                            onclick="switchVisiMisiTab('misi')" 
                            class="flex-1 py-2.5 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all duration-200 flex items-center justify-center gap-1.5"
                            role="tab"
                            aria-selected="false"
                            aria-controls="card-misi">
                        <span class="material-symbols-outlined text-[17px]">track_changes</span>
                        <span>Misi</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
                    
                    <!-- Visi Card (5 Cols di Desktop, Tab 1 di Ponsel) - Merah Solid Teduh (Mordant Red) Tanpa Gradasi -->
                    <div id="card-visi" class="flex flex-col lg:!flex lg:col-span-5 p-6 sm:p-8 lg:p-10 rounded-2xl sm:rounded-3xl bg-[#b30006] text-white shadow-lg shadow-red-950/10 justify-between gap-6 border border-[#960005] transition-all duration-300">
                        <div class="flex flex-col gap-5">
                            <div class="w-12 h-12 rounded-xl bg-white text-[#b30006] shadow-sm flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">visibility</span>
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <span class="text-xs uppercase tracking-widest text-red-200 font-bold font-telemetry">Visi</span>
                                <h3 class="font-headline text-xl sm:text-2xl font-bold leading-snug text-white">
                                    Menjadi perusahaan telekomunikasi digital kelas dunia yang berdampak besar di tingkat regional, dan membentuk ekosistem digital untuk menciptakan nilai bagi para pemangku kepentingan
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Misi Card (7 Cols di Desktop, Tab 2 di Ponsel) - Minimalis & Ternormalisasi -->
                    <div id="card-misi" class="hidden lg:!flex flex-col lg:col-span-7 p-6 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-sm justify-between gap-6 transition-all duration-300">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#bc0007] border border-red-100 flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-xl">track_changes</span>
                            </div>
                            <div>
                                <h3 class="font-headline text-lg sm:text-xl font-bold text-slate-900">Misi</h3>
                            </div>
                        </div>

                        <!-- 3 Normalized Minimalist Mission Items (Full Width, Zero Blank Space) -->
                        <div class="flex flex-col gap-3.5 flex-1 justify-between">
                            <!-- Misi 1 -->
                            <div class="p-4 sm:p-4.5 rounded-xl bg-slate-50/80 hover:bg-red-50/40 border border-slate-200/80 hover:border-red-200 transition-all duration-200 flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-white text-[#bc0007] border border-red-100 shadow-2xs flex items-center justify-center font-telemetry font-bold text-xs shrink-0 group-hover:bg-[#bc0007] group-hover:text-white transition-colors">
                                    01
                                </div>
                                <p class="font-headline text-sm sm:text-[15px] font-semibold text-slate-800 leading-snug flex-1">
                                    Mempercepat Pembangunan Infrastruktur Digital Dan Pengelolaan Layanan Yang Berkualitas
                                </p>
                            </div>

                            <!-- Misi 2 -->
                            <div class="p-4 sm:p-4.5 rounded-xl bg-slate-50/80 hover:bg-red-50/40 border border-slate-200/80 hover:border-red-200 transition-all duration-200 flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-white text-[#bc0007] border border-red-100 shadow-2xs flex items-center justify-center font-telemetry font-bold text-xs shrink-0 group-hover:bg-[#bc0007] group-hover:text-white transition-colors">
                                    02
                                </div>
                                <p class="font-headline text-sm sm:text-[15px] font-semibold text-slate-800 leading-snug flex-1">
                                    Mengorkestrasi Ekosistem Infrastruktur Digital Untuk Memberikan Pengalaman Pelanggan Yang Unggul
                                </p>
                            </div>

                            <!-- Misi 3 -->
                            <div class="p-4 sm:p-4.5 rounded-xl bg-slate-50/80 hover:bg-red-50/40 border border-slate-200/80 hover:border-red-200 transition-all duration-200 flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-white text-[#bc0007] border border-red-100 shadow-2xs flex items-center justify-center font-telemetry font-bold text-xs shrink-0 group-hover:bg-[#bc0007] group-hover:text-white transition-colors">
                                    03
                                </div>
                                <p class="font-headline text-sm sm:text-[15px] font-semibold text-slate-800 leading-snug flex-1">
                                    Mengembangkan Talenta Digital Unggul Dan Kapabilitas Digital Baru Untuk Memaksimalkan Nilai Bagi Semua Pemangku Kepentingan
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 5. BUDAYA KERJA AKHLAK BUMN -->
        <section class="w-full py-14 sm:py-18 lg:py-22 bg-white border-b border-slate-200/80">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 sm:mb-12">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold block mb-1">Nilai Inti BUMN</span>
                        <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                            Budaya Kerja di Witel Sukabumi
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md sm:text-right leading-relaxed">
                        Prinsip fundamental yang memandu setiap langkah personel lapangan, teknisi splicing, dispatcher, dan analis jaringan.
                    </p>
                </div>

                <!-- AKHLAK Carousel (Horizontal Scroll Snap di Ponsel, Grid 3-Kolom di Desktop) -->
                <div id="akhlak-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-4.5 pb-2 pt-1 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:grid lg:grid-cols-3 lg:gap-5 scrollbar-none items-stretch">
                    
                    <!-- A - Amanah -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-white border border-red-300 sm:border-slate-200/90 shadow-md shadow-red-500/5 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-[#bc0007] text-white border border-[#bc0007] shadow-sm sm:bg-red-50 sm:text-[#bc0007] sm:border-red-200/80 flex items-center justify-center group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">verified_user</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                1 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Amanah</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Memegang teguh kepercayaan dengan menjaga kejujuran dan integritas data validasi lapangan ODP secara presisi tanpa manipulasi.
                            </p>
                        </div>
                    </div>

                    <!-- K - Kompeten -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-[#f8f9ff] border border-slate-200/90 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-[#bc0007] border border-red-200/80 flex items-center justify-center shadow-2xs group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">workspace_premium</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                2 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Kompeten</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Terus meningkatkan keahlian lewat sertifikasi berkala pengoperasian OTDR, OPM, fusion splicer, dan standardisasi topologi FTTH.
                            </p>
                        </div>
                    </div>

                    <!-- H - Harmonis -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-[#f8f9ff] border border-slate-200/90 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-[#bc0007] border border-red-200/80 flex items-center justify-center shadow-2xs group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">diversity_3</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                3 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Harmonis</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Saling peduli dan menghargai keberagaman, menciptakan soliditas tim patroli rute udara maupun tanam di wilayah berbukit Sukabumi.
                            </p>
                        </div>
                    </div>

                    <!-- L - Loyal -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-[#f8f9ff] border border-slate-200/90 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-[#bc0007] border border-red-200/80 flex items-center justify-center shadow-2xs group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">loyalty</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                4 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Loyal</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Dedikasi tanpa henti menjaga uptime jaringan strategis perbankan, instansi pemda, rumah sakit, dan warga Sukabumi 24 jam non-stop.
                            </p>
                        </div>
                    </div>

                    <!-- A - Adaptif -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-[#f8f9ff] border border-slate-200/90 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-[#bc0007] border border-red-200/80 flex items-center justify-center shadow-2xs group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">tips_and_updates</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                5 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Adaptif</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Cepat mengadopsi kemajuan telemetri GPON real-time, sistem pelaporan berbasis GIS, hingga otomasi alarm degradasi optical return loss.
                            </p>
                        </div>
                    </div>

                    <!-- K - Kolaboratif -->
                    <div class="akhlak-card group p-5 sm:p-6 rounded-2xl bg-[#f8f9ff] border border-slate-200/90 hover:border-red-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 flex flex-col justify-between gap-4 shrink-0 flex-none snap-start lg:w-auto lg:min-w-0 lg:max-w-none lg:flex-initial lg:snap-align-none">
                        <div class="flex items-center justify-between w-full">
                            <div class="akhlak-icon-box w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-[#bc0007] border border-red-200/80 flex items-center justify-center shadow-2xs group-hover:bg-[#bc0007] group-hover:text-white group-hover:border-[#bc0007] group-hover:shadow-md group-hover:shadow-red-500/20 transition-all duration-300 shrink-0">
                                <span class="material-symbols-outlined text-[24px] sm:text-[26px] transition-transform duration-300 group-hover:scale-110">hub</span>
                            </div>
                            <span class="lg:hidden inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200/90 text-[11px] font-bold text-slate-500 font-telemetry tracking-wider whitespace-nowrap shrink-0">
                                6 / 6
                            </span>
                        </div>
                        <div class="flex flex-col flex-1 justify-between pt-1">
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 mb-1.5 sm:mb-2 whitespace-nowrap">Kolaboratif</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Membangun sinergi harmonis antara engineer NOC, regu lapangan, mitra penyedia, dan instansi dinas Sukabumi untuk percepatan penanganan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Indikator Titik Halaman Geser Mobile (Dot Indicators) -->
                <div id="akhlak-dots" class="flex lg:hidden items-center justify-center gap-1.5 pt-4" aria-label="Navigasi Geser Kartu Budaya Kerja">
                    <button type="button" onclick="scrollToAkhlakCard(0)" class="akhlak-dot w-6 h-2 rounded-full bg-[#bc0007] transition-all duration-200" aria-label="Lihat Kartu 1 Amanah"></button>
                    <button type="button" onclick="scrollToAkhlakCard(1)" class="akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200" aria-label="Lihat Kartu 2 Kompeten"></button>
                    <button type="button" onclick="scrollToAkhlakCard(2)" class="akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200" aria-label="Lihat Kartu 3 Harmonis"></button>
                    <button type="button" onclick="scrollToAkhlakCard(3)" class="akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200" aria-label="Lihat Kartu 4 Loyal"></button>
                    <button type="button" onclick="scrollToAkhlakCard(4)" class="akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200" aria-label="Lihat Kartu 5 Adaptif"></button>
                    <button type="button" onclick="scrollToAkhlakCard(5)" class="akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200" aria-label="Lihat Kartu 6 Kolaboratif"></button>
                </div>
            </div>
        </section>

        <!-- 6. SERTIFIKASI & PENJAMINAN MUTU OPERASIONAL -->
        <section class="w-full py-14 sm:py-18 lg:py-22 bg-white border-b border-slate-200/80">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
                    <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold block mb-1">Kepatuhan Regulasi &amp; Standardisasi</span>
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Akreditasi &amp; Penjaminan Mutu Operasional
                    </h2>
                    <p class="mt-2 text-sm sm:text-base text-slate-600 leading-relaxed">
                        Seluruh aktivitas konstruksi jaringan, validasi data, hingga penanganan insiden lapangan diuji secara berkala mengikuti standar internasional.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                    
                    <!-- ISO 9001 -->
                    <div class="p-3.5 sm:p-5 lg:p-6 rounded-xl sm:rounded-2xl bg-[#f8f9ff] border-t-4 border-[#bc0007] border-x border-b border-slate-200/90 shadow-2xs flex flex-col justify-between gap-3 sm:gap-4">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-[#bc0007] text-2xl sm:text-3xl">verified</span>
                            <span class="font-telemetry text-[9px] sm:text-[11px] font-bold text-slate-400">CERTIFIED</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-xs sm:text-base lg:text-lg font-bold text-slate-900 mb-1">ISO 9001:2015</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-relaxed">
                                Sistem Manajemen Mutu berkesinambungan pada rancang bangun, instalasi kabel serat optik, dan pemeliharaan preventif FTTH.
                            </p>
                        </div>
                        <span class="text-[10px] sm:text-[11px] font-semibold text-[#bc0007] truncate">Standar Mutu Layanan</span>
                    </div>

                    <!-- ISO 27001 -->
                    <div class="p-3.5 sm:p-5 lg:p-6 rounded-xl sm:rounded-2xl bg-[#f8f9ff] border-t-4 border-[#00628d] border-x border-b border-slate-200/90 shadow-2xs flex flex-col justify-between gap-3 sm:gap-4">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-[#00628d] text-2xl sm:text-3xl">lock</span>
                            <span class="font-telemetry text-[9px] sm:text-[11px] font-bold text-slate-400">SECURITY</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-xs sm:text-base lg:text-lg font-bold text-slate-900 mb-1">ISO 27001:2022</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-relaxed">
                                Sistem Manajemen Keamanan Informasi dalam perlindungan data topologi GPON, kredensial pelanggan, dan arsip validasi VALINS.
                            </p>
                        </div>
                        <span class="text-[10px] sm:text-[11px] font-semibold text-[#00628d] truncate">Perlindungan Aset Data</span>
                    </div>

                    <!-- SMK3 / ISO 45001 -->
                    <div class="p-3.5 sm:p-5 lg:p-6 rounded-xl sm:rounded-2xl bg-[#f8f9ff] border-t-4 border-amber-600 border-x border-b border-slate-200/90 shadow-2xs flex flex-col justify-between gap-3 sm:gap-4">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-amber-600 text-2xl sm:text-3xl">health_and_safety</span>
                            <span class="font-telemetry text-[9px] sm:text-[11px] font-bold text-slate-400">SAFETY FIRST</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-xs sm:text-base lg:text-lg font-bold text-slate-900 mb-1">SMK3 &amp; ISO 45001</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-relaxed">
                                Sistem Manajemen K3 dengan komitmen ketat Zero Accident pada pemanjatan tiang, penarikan kabel, dan manhole ruang terbatas.
                            </p>
                        </div>
                        <span class="text-[10px] sm:text-[11px] font-semibold text-amber-700 truncate">Keselamatan Personel Lapangan</span>
                    </div>

                    <!-- Valins Presisi Telkom -->
                    <div class="p-3.5 sm:p-5 lg:p-6 rounded-xl sm:rounded-2xl bg-[#f8f9ff] border-t-4 border-emerald-600 border-x border-b border-slate-200/90 shadow-2xs flex flex-col justify-between gap-3 sm:gap-4">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl sm:text-3xl">fact_check</span>
                            <span class="font-telemetry text-[9px] sm:text-[11px] font-bold text-slate-400">TELKOM GROUP</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-xs sm:text-base lg:text-lg font-bold text-slate-900 mb-1">Valins Presisi Telkom</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-snug sm:leading-relaxed">
                                Standarisasi protokol audit fisik lapangan berkala dengan verifikasi foto barcode ODP, QR code port, dan tagging GPS akurasi tinggi.
                            </p>
                        </div>
                        <span class="text-[10px] sm:text-[11px] font-semibold text-emerald-700 truncate">Audit Fisik Lapangan Terpadu</span>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= SECTION: MASIH ADA PERTANYAAN? (HELP & INQUIRY BANNER) ================= -->
        <section class="w-full relative overflow-hidden py-12 sm:py-16 px-4 sm:px-6 lg:px-8 xl:px-12 bg-[#b30006] border-t border-[#960005] text-white shadow-xl">
            
            <!-- Decorative Subtle Ambient Glow Elements (No White Fading on Edges) -->
            <div class="absolute -right-24 -bottom-24 w-96 h-96 rounded-full bg-red-950/40 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-red-900/30 blur-3xl pointer-events-none"></div>
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#ffffff_1.2px,transparent_1.2px)] [background-size:24px_24px] pointer-events-none"></div>

            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8 lg:gap-12">
                
                <!-- Left Content: Operational Heading & Contextual Subtitle -->
                <div class="max-w-3xl flex flex-col gap-3.5">
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Masih Memiliki Pertanyaan Mengenai Profil &amp; Layanan Kami?
                    </h2>

                    <p class="text-red-100/90 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Tim Operasional dan Helpdesk NOC Telkom Akses Witel Sukabumi siap membantu Anda apabila memerlukan informasi lebih lanjut mengenai profil, kemitraan, maupun operasional jaringan.
                    </p>
                </div>

                <!-- Right Actions: Primary "Hubungi Kami" Button -->
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
                            Sistem Informasi Manajemen Data Valins &amp; Monitoring GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional.
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
                            <a href="https://wa.me/6281120898880" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 hover:border-emerald-200 transition-all duration-200 shadow-2xs">
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
                            <a href="{{ route('contact.us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
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
                            <a href="{{ route('about.us') }}" class="group flex items-center gap-2 text-[#bc0007] font-semibold transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
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

    <!-- Client-side Interactive Logic (Mobile Collapsible, Visi-Misi Tabs, & AKHLAK Carousel Sync) -->
    <script>
        // 1. Mobile Narrative Collapsible Toggle (Section 3)
        function toggleProfileNarration() {
            var content = document.getElementById('mobile-profile-content');
            var btnText = document.getElementById('btn-toggle-profile-text');
            var btnIcon = document.getElementById('btn-toggle-profile-icon');
            var btn = document.getElementById('btn-toggle-profile');
            
            if (!content || !btnText || !btnIcon) return;
            
            var isHidden = content.classList.contains('hidden');
            if (isHidden) {
                content.classList.remove('hidden');
                btnText.textContent = 'Tutup Profil Singkat';
                btnIcon.textContent = 'expand_less';
                if (btn) btn.setAttribute('aria-expanded', 'true');
            } else {
                content.classList.add('hidden');
                btnText.textContent = 'Baca Selengkapnya Profil Transformasi';
                btnIcon.textContent = 'expand_more';
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        }

        // 2. Mobile Visi & Misi Segmented Tab Switcher (Section 4)
        function switchVisiMisiTab(tab) {
            var cardVisi = document.getElementById('card-visi');
            var cardMisi = document.getElementById('card-misi');
            var btnVisi = document.getElementById('tab-btn-visi');
            var btnMisi = document.getElementById('tab-btn-misi');
            
            if (!cardVisi || !cardMisi || !btnVisi || !btnMisi) return;

            if (tab === 'visi') {
                // Show Visi, Hide Misi on Mobile
                cardVisi.classList.remove('hidden');
                cardMisi.classList.add('hidden');
                cardMisi.classList.remove('flex');

                btnVisi.className = 'flex-1 py-2.5 px-3 rounded-lg text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 bg-[#b30006] text-white shadow-xs';
                btnVisi.setAttribute('aria-selected', 'true');

                btnMisi.className = 'flex-1 py-2.5 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all duration-200 flex items-center justify-center gap-1.5';
                btnMisi.setAttribute('aria-selected', 'false');
            } else {
                // Show Misi, Hide Visi on Mobile
                cardVisi.classList.add('hidden');
                cardMisi.classList.remove('hidden');
                cardMisi.classList.add('flex');

                btnMisi.className = 'flex-1 py-2.5 px-3 rounded-lg text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 bg-[#b30006] text-white shadow-xs';
                btnMisi.setAttribute('aria-selected', 'true');

                btnVisi.className = 'flex-1 py-2.5 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all duration-200 flex items-center justify-center gap-1.5';
                btnVisi.setAttribute('aria-selected', 'false');
            }
        }

        // 3. Mobile AKHLAK Horizontal Scroll Carousel & Dot Sync (Section 5)
        function scrollToAkhlakCard(index) {
            var carousel = document.getElementById('akhlak-carousel');
            if (!carousel) return;
            var cards = carousel.querySelectorAll('.akhlak-card');
            if (cards[index]) {
                var targetLeft = cards[index].offsetLeft - carousel.offsetLeft - 16;
                carousel.scrollTo({ left: targetLeft > 0 ? targetLeft : 0, behavior: 'smooth' });
            }
        }

        function syncAkhlakDots() {
            var carousel = document.getElementById('akhlak-carousel');
            var dots = document.querySelectorAll('#akhlak-dots .akhlak-dot');
            if (!carousel || dots.length === 0) return;

            var cards = carousel.querySelectorAll('.akhlak-card');
            if (cards.length === 0) return;

            var carouselRect = carousel.getBoundingClientRect();
            var carouselThreshold = carouselRect.left + 24;

            var closestIdx = 0;
            var minDiff = Infinity;

            cards.forEach(function(card, idx) {
                var rect = card.getBoundingClientRect();
                var diff = Math.abs(rect.left - carouselThreshold);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestIdx = idx;
                }
            });

            // Update dots
            dots.forEach(function(dot, idx) {
                if (idx === closestIdx) {
                    dot.className = 'akhlak-dot w-6 h-2 rounded-full bg-[#bc0007] transition-all duration-200';
                } else {
                    dot.className = 'akhlak-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-200';
                }
            });

            // Highlight active card icon and card border on mobile
            if (window.innerWidth < 1024) {
                cards.forEach(function(card, idx) {
                    var iconBox = card.querySelector('.akhlak-icon-box');
                    if (idx === closestIdx) {
                        card.classList.add('border-red-300', 'bg-white', 'shadow-md', 'shadow-red-500/5');
                        card.classList.remove('border-slate-200/90', 'bg-[#f8f9ff]');
                        if (iconBox) {
                            iconBox.classList.add('bg-[#bc0007]', 'text-white', 'border-[#bc0007]', 'shadow-sm');
                            iconBox.classList.remove('bg-red-50', 'text-[#bc0007]', 'border-red-200/80');
                        }
                    } else {
                        card.classList.remove('border-red-300', 'shadow-md', 'shadow-red-500/5');
                        card.classList.add('border-slate-200/90', 'bg-[#f8f9ff]');
                        if (iconBox) {
                            iconBox.classList.remove('bg-[#bc0007]', 'text-white', 'border-[#bc0007]', 'shadow-sm');
                            iconBox.classList.add('bg-red-50', 'text-[#bc0007]', 'border-red-200/80');
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var carousel = document.getElementById('akhlak-carousel');
            if (carousel) {
                var scrollTimeout;
                carousel.addEventListener('scroll', function() {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(syncAkhlakDots, 40);
                }, { passive: true });

                window.addEventListener('resize', function() {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(syncAkhlakDots, 80);
                });

                // Initialize on load
                syncAkhlakDots();
            }
        });
    </script>
</body>
</html>
