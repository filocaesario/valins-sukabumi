<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Preload Critical Showcase Images to Eliminate Navigation Flicker/Shift -->
    <link rel="preload" as="image" href="{{ asset('images/auth/login-validation-illustration.png') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/telkom-akses-official-transparent.png') }}" fetchpriority="high">

    <!-- Scripts & Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --telkom-red: #bc0007;
            --telkom-red-dark: #960005;
            --telkom-red-light: #ffe5e2;
        }

        html {
            scrollbar-gutter: stable;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #0b1c30;
        }

        /* Slim minimalist scrollbar for desktop right column */
        .custom-auth-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 9999px;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        .font-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-telemetry {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="bg-white text-[#0b1c30] antialiased min-h-screen selection:bg-[#bc0007] selection:text-white">

    <!-- Split Screen Two-Column Container -->
    <div class="min-h-screen lg:h-screen w-full flex flex-col lg:flex-row lg:overflow-hidden">
        
        <!-- ================= LEFT COLUMN: Modern Telkom Akses Branded Showcase (Desktop Only) ================= -->
        <div class="hidden lg:flex lg:w-1/2 lg:h-full bg-gradient-to-br from-[#ffffff] via-[#f4f8fe] to-[#e8f1fc] border-r border-slate-200/80 relative overflow-hidden flex-col justify-between p-8 lg:p-10 xl:p-12 text-slate-900 select-none shadow-xs shrink-0">
            <!-- Soft Blue Ambient Glow Overlays (Clean Gradient without Dots) -->
            <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-6 right-0 w-80 h-80 bg-sky-100/60 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-50/50 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Top Header: Official Transparent Logo Telkom Akses & Status Badge -->
            <div class="relative z-10 flex items-center justify-between h-11 shrink-0">
                <a href="{{ route('login') }}" class="inline-flex items-center focus:outline-none transition-opacity duration-200 hover:opacity-90" title="PT Telkom Akses - Beranda">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo Resmi PT Telkom Akses" 
                         width="180"
                         height="44"
                         loading="eager"
                         decoding="sync"
                         fetchpriority="high"
                         class="h-9 sm:h-10 md:h-11 w-auto object-contain shrink-0"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                </a>
            </div>

            <!-- Center Visual Composition: Data Validation & Authentication Illustration -->
            <div class="relative z-10 my-auto py-4 sm:py-6 flex flex-col items-center justify-center shrink-0">
                <div class="relative flex items-center justify-center w-full max-w-[360px] sm:max-w-[400px] lg:max-w-[440px] xl:max-w-[470px]">
                    <!-- Subtle Ambient Backdrop Circle -->
                    <div class="absolute -inset-6 sm:-inset-8 bg-gradient-to-tr from-blue-200/40 via-sky-100/45 to-red-100/35 rounded-3xl blur-2xl pointer-events-none"></div>
                    
                    <img src="{{ asset('images/auth/login-validation-illustration.png') }}" 
                         alt="Ilustrasi Sistem Keamanan & Validasi Terpadu PT Telkom Akses" 
                         width="783"
                         height="541"
                         loading="eager"
                         decoding="sync"
                         fetchpriority="high"
                         class="relative z-10 w-full h-auto aspect-[783/541] max-h-[290px] sm:max-h-[320px] lg:max-h-[350px] object-contain drop-shadow-md select-none pointer-events-none">
                </div>
            </div>

            <!-- Bottom Typography: Headline & Subheadline (Dark Slate on Light Background) -->
            <div class="relative z-10 pt-2 shrink-0">
                <!-- Dual Accent Bars (Garis Utama & Garis Pendek Berdampingan) -->
                <div class="flex items-center gap-1.5 mb-3">
                    <div class="w-10 h-1 bg-[#bc0007] rounded-full"></div>
                    <div class="w-2.5 h-1 bg-[#bc0007] rounded-full"></div>
                </div>
                <h2 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-snug">
                    Sistem Terpadu Validasi dan Monitoring Jaringan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5 leading-relaxed max-w-lg">
                    Platform terpadu data validasi ODC/ODP, monitoring redaman GPON OLT, dan rekonsiliasi jaringan fisik PT Telkom Akses Witel Sukabumi.
                </p>
                <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-slate-600 font-medium">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Data Fisik Tervalidasi
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        Infrastruktur Resmi Telkom Akses
                    </span>
                </div>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: Clean Pure White Recovery Form ================= -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-between px-5 py-6 sm:p-10 lg:p-12 xl:p-16 min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto custom-auth-scrollbar relative">
            
            <!-- Top Navigation: Kembali ke Login & Mobile Logo -->
            <div class="flex items-center justify-between w-full mb-4 sm:mb-6">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-[#bc0007] transition-colors group">
                    <span class="material-symbols-outlined text-base transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali ke Login</span>
                </a>

                <!-- Mobile Only Telkom Akses Logo -->
                <div class="lg:hidden flex items-center">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo Resmi PT Telkom Akses" 
                         class="h-8 w-auto object-contain"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                </div>
            </div>

            <!-- Vertically Centered Authentication Form -->
            <div class="my-auto w-full max-w-[400px] sm:max-w-[420px] mx-auto py-2 sm:py-4">
                
                <!-- ================= MOBILE ONLY: Dedicated Mobile Screen Header ================= -->
                <div class="block lg:hidden mb-5">
                    <!-- Visual Teamwork Illustration with Ambient Soft Glow -->
                    <div class="flex justify-center items-center py-1 sm:py-2 mb-3 relative">
                        <div class="absolute w-36 h-36 rounded-full bg-gradient-to-tr from-red-500/10 via-sky-400/10 to-red-400/15 blur-2xl pointer-events-none"></div>
                        <img src="{{ asset('images/auth/mobile-login-illustration.png') }}" 
                             alt="Ilustrasi Sinergi Tim Telkom Akses" 
                             class="w-auto max-h-[140px] xs:max-h-[155px] sm:max-h-[175px] object-contain select-none pointer-events-none filter drop-shadow-sm relative z-10 transition-transform duration-300">
                    </div>

                    <!-- Mobile Title (Rata Kiri) -->
                    <div class="text-left">
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Lupa Password
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">
                            Masukkan email anda, kami akan kirimkan kode OTP untuk reset password.
                        </p>
                    </div>
                </div>

                <!-- ================= DESKTOP ONLY: Heading Lupa Password ================= -->
                <div class="hidden lg:block mb-6 sm:mb-8">
                    <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Lupa Password
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        Masukkan email anda, kami akan kirimkan kode OTP untuk reset password.
                    </p>
                </div>

                <!-- Session Status Alert -->
                @if (session('status'))
                    <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Validation Error Alert -->
                @if ($errors->any())
                    <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-800 rounded-xl text-xs space-y-1">
                        <div class="flex items-center gap-1.5 font-bold text-[#bc0007]">
                            <span class="material-symbols-outlined text-[18px]">error</span>
                            <span>Perhatian:</span>
                        </div>
                        <ul class="list-disc pl-5 space-y-0.5 text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Interactive Reset Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-4.5" id="recoveryForm" onsubmit="handleRecoverySubmit(event)">
                    @csrf
                    <input type="hidden" name="recovery_method" value="email">

                    <!-- EMAIL Input -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry" for="emailInput">
                            EMAIL
                        </label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg pointer-events-none">
                                mail
                            </span>
                            <input class="w-full h-12 pl-11 pr-4 bg-white text-slate-900 text-sm rounded-xl border border-slate-200 focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 transition-all outline-none" 
                                   id="emailInput" 
                                   name="email" 
                                   value="{{ old('email') ?? old('identity') }}" 
                                   placeholder="nama@email.com" 
                                   required 
                                   autofocus 
                                   type="email">
                        </div>
                    </div>

                    <!-- Primary Action Button: Kirim Kode OTP -->
                    <div class="pt-2">
                        <button class="w-full h-12 flex items-center justify-center gap-2 bg-[#bc0007] hover:bg-[#960005] active:bg-[#7a0004] text-white font-headline text-base font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed" 
                                id="btnSubmitRecovery" 
                                type="submit">
                            <span>Kirim Kode OTP</span>
                        </button>
                    </div>

                    <!-- Bottom Link: Sudah ingat kata sandi? Masuk -->
                    <div class="pt-4 text-center">
                        <p class="text-xs sm:text-sm text-slate-500">
                            Sudah ingat kata sandi? 
                            <a class="text-[#bc0007] font-bold hover:underline ml-1" href="{{ route('login') }}">
                                Masuk
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Script for submit feedback -->
    <script>
        function handleRecoverySubmit(event) {
            const form = document.getElementById('recoveryForm');
            if (!form.checkValidity()) {
                return;
            }
            const btn = document.getElementById('btnSubmitRecovery');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengirim Kode OTP...</span>
            `;
        }
    </script>

</body>
</html>
