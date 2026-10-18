<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

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

        <!-- ================= RIGHT COLUMN: Clean Pure White Login Form ================= -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-between px-5 py-6 sm:p-10 lg:p-12 xl:p-16 min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto custom-auth-scrollbar relative">
            
            <!-- Top Navigation: Kembali ke Beranda & Mobile Logo -->
            <div class="flex items-center justify-between w-full mb-4 sm:mb-6">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-[#bc0007] transition-colors group">
                    <span class="material-symbols-outlined text-base transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali ke Beranda</span>
                </a>

                <!-- Mobile Only Telkom Akses Logo -->
                <div class="lg:hidden flex items-center">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo Resmi PT Telkom Akses" 
                         class="h-8 w-auto object-contain"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                </div>

                <!-- Desktop NOC Indicator -->
            </div>

            <!-- Vertically Centered Authentication Form -->
            <div class="my-auto w-full max-w-[390px] sm:max-w-[400px] mx-auto py-2 sm:py-4">
                
                <!-- ================= MOBILE ONLY: Dedicated Mobile Login Screen Header ================= -->
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
                            Masuk ke Akun
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                            Sistem Monitoring &amp; Validasi Data VALINS - GPON Witel Sukabumi
                        </p>
                    </div>
                </div>

                <!-- ================= DESKTOP ONLY: Heading Masuk ================= -->
                <div class="hidden lg:block mb-6 sm:mb-8">
                    <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Masuk
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        Login untuk mengakses sistem monitoring data Valins Service &amp; GPON.
                    </p>
                </div>

                <!-- Session Status Alert -->
                @if (session('status'))
                    <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @php
                    $initialIdentityError = $errors->first('identity') ?? $errors->first('email');
                    $initialPasswordError = $errors->first('password');
                @endphp

                <!-- Form Element -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-4.5" id="authLoginForm" onsubmit="handleFormSubmit(event)" novalidate>
                    @csrf

                    <!-- EMAIL / NIK Input -->
                    <div id="identityGroup">
                        <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry mb-1.5" for="identityInput">
                            EMAIL ATAU NIK
                        </label>
                        <div class="relative flex items-center">
                            <span id="identityIcon" class="material-symbols-outlined absolute left-3.5 {{ $initialIdentityError ? 'text-rose-500' : 'text-slate-400' }} text-lg pointer-events-none transition-colors duration-200">
                                mail
                            </span>
                            <input class="w-full h-12 pl-11 pr-4 border text-slate-900 text-sm rounded-xl {{ $initialIdentityError ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/15' : 'border-slate-200 bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20' }} outline-none transition-colors duration-200" 
                                   id="identityInput" 
                                   name="identity" 
                                   value="{{ old('identity') ?? old('email') }}" 
                                   placeholder="nama@email.com atau NIK Karyawan" 
                                   required 
                                   autofocus 
                                   type="text"
                                   autocomplete="username">
                        </div>
                        <!-- Inline Error Helper with Refined Micro-Card Component & Zero Layout Shift Transition -->
                        <div id="identityErrorContainer" 
                             class="transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] {{ $initialIdentityError ? 'opacity-100 translate-y-0 scale-100 h-auto max-h-24 mt-2' : 'opacity-0 -translate-y-1.5 scale-[0.98] pointer-events-none h-0 max-h-0 overflow-hidden' }}" 
                             aria-live="polite">
                            <div class="p-2.5 sm:px-3 sm:py-2 rounded-xl bg-rose-50/90 border border-rose-200/80 shadow-xs shadow-rose-500/5 flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-rose-100 border border-rose-200/90 flex items-center justify-center shrink-0 mt-0.5 text-rose-600">
                                    <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9" />
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-linecap="round" />
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor" stroke="none" />
                                    </svg>
                                </div>
                                <p class="flex-1 text-xs sm:text-[12.5px] font-medium text-rose-900 leading-snug">
                                    <span id="identityErrorMessage">{{ $initialIdentityError ?? '' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD Input with Eye Toggle -->
                    <div id="passwordGroup">
                        <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry mb-1.5" for="passwordInput">
                            PASSWORD
                        </label>
                        <div class="relative flex items-center">
                            <span id="passwordIcon" class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg pointer-events-none transition-colors duration-200">
                                lock
                            </span>
                            <input class="w-full h-12 pl-11 pr-11 border text-slate-900 text-sm rounded-xl border-slate-200 bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-colors duration-200" 
                                   id="passwordInput" 
                                   name="password" 
                                   placeholder="••••••••" 
                                   required 
                                   type="password"
                                   autocomplete="current-password">
                            <button aria-label="Tampilkan / Sembunyikan Kata Sandi" 
                                    class="absolute right-3 text-slate-400 hover:text-slate-700 p-1.5 rounded-lg transition-colors cursor-pointer" 
                                    id="togglePasswordBtn" 
                                    onclick="togglePasswordVisibility()" 
                                    type="button">
                                <span class="material-symbols-outlined text-lg" id="pwdEyeIcon">visibility</span>
                            </button>
                        </div>
                        <!-- Inline Error Helper with Refined Micro-Card Component & Zero Layout Shift Transition -->
                        <div id="passwordErrorContainer" 
                             class="transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] opacity-0 -translate-y-1.5 scale-[0.98] pointer-events-none h-0 max-h-0 overflow-hidden" 
                             aria-live="polite">
                            <div class="p-2.5 sm:px-3 sm:py-2 rounded-xl bg-rose-50/90 border border-rose-200/80 shadow-xs shadow-rose-500/5 flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-rose-100 border border-rose-200/90 flex items-center justify-center shrink-0 mt-0.5 text-rose-600">
                                    <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9" />
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-linecap="round" />
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor" stroke="none" />
                                    </svg>
                                </div>
                                <p class="flex-1 text-xs sm:text-[12.5px] font-medium text-rose-900 leading-snug">
                                    <span id="passwordErrorMessage"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Row: Ingat Saya & Lupa Password -->
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input class="w-4 h-4 rounded text-[#bc0007] focus:ring-[#bc0007] border-slate-300 accent-[#bc0007]" 
                                   id="rememberSession" 
                                   name="remember" 
                                   type="checkbox"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-xs text-slate-600 font-medium">
                                Ingat Saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-slate-500 hover:text-[#bc0007] transition-colors" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Primary Action Button: Masuk (Mordant Red 19) -->
                    <div class="pt-2">
                        <button class="w-full h-12 flex items-center justify-center gap-2 bg-[#AE0C00] text-white font-headline text-base font-bold rounded-xl opacity-60 cursor-not-allowed shadow-none transition-all duration-200" 
                                id="submitAuthBtn" 
                                type="submit"
                                disabled>
                            <span>Masuk</span>
                        </button>
                    </div>

                    <!-- Divider: "atau" (Patterned from Reference Image) -->
                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs text-slate-400">
                            <span class="bg-white px-3 font-medium">atau</span>
                        </div>
                    </div>

                    <!-- Inline Google SSO Notice (Dismissible) -->
                    <div id="googleSsoNotice" class="hidden p-3 bg-red-50/90 border border-red-200 text-slate-800 rounded-xl text-xs flex items-start gap-2.5 transition-all">
                        <span class="material-symbols-outlined text-[#bc0007] text-base shrink-0 mt-0.5">info</span>
                        <div class="flex-1 text-[11px] leading-relaxed">
                            <span class="font-bold text-slate-900 block">Single Sign-On (SSO) Telkom Group</span>
                            Integrasi Google Workspace (@telkomakses.co.id) sedang dipersiapkan. Untuk saat ini silakan gunakan NIK atau Email terdaftar untuk masuk.
                        </div>
                        <button type="button" onclick="document.getElementById('googleSsoNotice').classList.add('hidden')" class="text-slate-400 hover:text-slate-700 shrink-0 cursor-pointer">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>

                    <!-- Google SSO Login Button (Patterned from Reference Image) -->
                    <div>
                        <button type="button" 
                                onclick="toggleGoogleNotice()"
                                class="w-full h-12 flex items-center justify-center gap-3 bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 font-semibold text-sm rounded-xl border border-slate-200 hover:border-slate-300 transition-all duration-200 shadow-2xs cursor-pointer group">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-105" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span>Login dengan Google</span>
                        </button>
                    </div>

                    <!-- Bottom Link: Belum punya akun? Daftar -->
                    <div class="pt-4 text-center">
                        <p class="text-xs sm:text-sm text-slate-500">
                            Belum punya akun? 
                            <a class="text-[#bc0007] font-bold hover:underline ml-1" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </p>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Micro-Interactions & Real-Time Inline Validation Script -->
    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('pwdEyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                pwdInput.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }

        function toggleGoogleNotice() {
            const notice = document.getElementById('googleSsoNotice');
            if (notice) {
                notice.classList.toggle('hidden');
            }
        }

        // ================= Real-Time Inline Validation Logic =================
        const identityInput = document.getElementById('identityInput');
        const identityIcon = document.getElementById('identityIcon');
        const identityErrorContainer = document.getElementById('identityErrorContainer');
        const identityErrorMessage = document.getElementById('identityErrorMessage');

        const passwordInput = document.getElementById('passwordInput');
        const passwordIcon = document.getElementById('passwordIcon');
        const passwordErrorContainer = document.getElementById('passwordErrorContainer');
        const passwordErrorMessage = document.getElementById('passwordErrorMessage');

        const submitBtn = document.getElementById('submitAuthBtn');

        // Refined styling classes matching Mordant Red / Rose micro-card theme
        const INVALID_INPUT_CLASSES = ['border-rose-400', 'bg-rose-50/20', 'text-slate-900', 'focus:border-rose-500', 'focus:ring-2', 'focus:ring-rose-500/15', 'transition-colors', 'duration-200'];
        const VALID_INPUT_CLASSES = ['border-emerald-500/80', 'bg-white', 'text-slate-900', 'focus:border-emerald-600', 'focus:ring-2', 'focus:ring-emerald-500/15', 'transition-colors', 'duration-200'];
        const NEUTRAL_INPUT_CLASSES = ['border-slate-200', 'bg-white', 'text-slate-900', 'focus:border-[#bc0007]', 'focus:ring-2', 'focus:ring-[#bc0007]/20', 'transition-colors', 'duration-200'];
        const ALL_INPUT_CLASSES = [
            'border-red-500', 'bg-red-50/10', 'bg-red-50/20', 'focus:border-red-600', 'focus:ring-red-500/15',
            'border-rose-400', 'bg-rose-50/20', 'focus:border-rose-500', 'focus:ring-rose-500/15',
            'border-emerald-500/80', 'focus:border-emerald-600', 'focus:ring-emerald-500/15',
            'border-slate-200', 'focus:border-[#bc0007]', 'focus:ring-[#bc0007]/20'
        ];

        // Smooth Zero Layout Shift Transition Classes for Error Container
        const ERROR_INACTIVE_CLASSES = ['opacity-0', '-translate-y-1.5', 'scale-[0.98]', 'pointer-events-none', 'h-0', 'max-h-0', 'overflow-hidden'];
        const ERROR_ACTIVE_CLASSES = ['opacity-100', 'translate-y-0', 'scale-100', 'h-auto', 'max-h-24', 'mt-2'];

        const BTN_DISABLED_CLASSES = ['opacity-60', 'cursor-not-allowed', 'shadow-none'];
        const BTN_ACTIVE_CLASSES = ['hover:bg-[#8A0900]', 'active:bg-[#750800]', 'shadow-sm', 'hover:shadow-md', 'cursor-pointer'];

        let identityTouched = false;
        let isIdentityValid = false;
        let passwordTouched = false;
        let isPasswordValid = false;

        let identityDebounceTimer = null;
        let passwordDebounceTimer = null;
        let currentRequestId = 0;
        let activeAbortController = null;
        const identityCheckCache = new Map(); // Client-side cache to eliminate redundant network requests

        function setFieldInvalid(inputEl, iconEl, errorContainerEl, errorMsgEl, message) {
            if (!inputEl) return;
            ALL_INPUT_CLASSES.forEach(c => inputEl.classList.remove(c));
            INVALID_INPUT_CLASSES.forEach(c => inputEl.classList.add(c));

            if (iconEl) {
                iconEl.classList.remove('text-slate-400', 'text-emerald-600', 'text-red-500');
                iconEl.classList.add('text-rose-500');
            }

            if (errorMsgEl) errorMsgEl.textContent = message;
            if (errorContainerEl) {
                errorContainerEl.classList.remove(...ERROR_INACTIVE_CLASSES, 'hidden');
                errorContainerEl.classList.add(...ERROR_ACTIVE_CLASSES);
            }
        }

        function setFieldValid(inputEl, iconEl, errorContainerEl) {
            if (!inputEl) return;
            ALL_INPUT_CLASSES.forEach(c => inputEl.classList.remove(c));
            VALID_INPUT_CLASSES.forEach(c => inputEl.classList.add(c));

            if (iconEl) {
                iconEl.classList.remove('text-red-500', 'text-rose-500');
                iconEl.classList.add('text-slate-400');
            }

            if (errorContainerEl) {
                errorContainerEl.classList.remove(...ERROR_ACTIVE_CLASSES);
                errorContainerEl.classList.add(...ERROR_INACTIVE_CLASSES);
            }
        }

        function setFieldNeutral(inputEl, iconEl, errorContainerEl) {
            if (!inputEl) return;
            ALL_INPUT_CLASSES.forEach(c => inputEl.classList.remove(c));
            NEUTRAL_INPUT_CLASSES.forEach(c => inputEl.classList.add(c));

            if (iconEl) {
                iconEl.classList.remove('text-red-500', 'text-rose-500', 'text-emerald-600');
                iconEl.classList.add('text-slate-400');
            }

            if (errorContainerEl) {
                errorContainerEl.classList.remove(...ERROR_ACTIVE_CLASSES);
                errorContainerEl.classList.add(...ERROR_INACTIVE_CLASSES);
            }
        }

        function updateSubmitButtonState() {
            if (!submitBtn) return;
            if (isIdentityValid && isPasswordValid) {
                submitBtn.disabled = false;
                BTN_DISABLED_CLASSES.forEach(c => submitBtn.classList.remove(c));
                BTN_ACTIVE_CLASSES.forEach(c => submitBtn.classList.add(c));
            } else {
                submitBtn.disabled = true;
                BTN_ACTIVE_CLASSES.forEach(c => submitBtn.classList.remove(c));
                BTN_DISABLED_CLASSES.forEach(c => submitBtn.classList.add(c));
            }
        }

        function checkCredentialsAsync(identityVal, passwordVal) {
            const trimmedIdentity = (identityVal || '').trim();
            const trimmedPassword = passwordVal || '';

            if (!trimmedIdentity) {
                isIdentityValid = false;
                setFieldNeutral(identityInput, identityIcon, identityErrorContainer);
                updateSubmitButtonState();
                return;
            }

            // Check cache when only identity is being verified (empty password)
            if (!trimmedPassword && identityCheckCache.has(trimmedIdentity)) {
                const cached = identityCheckCache.get(trimmedIdentity);
                if (cached.identity_valid) {
                    isIdentityValid = true;
                    setFieldValid(identityInput, identityIcon, identityErrorContainer);
                } else {
                    isIdentityValid = false;
                    setFieldInvalid(
                        identityInput,
                        identityIcon,
                        identityErrorContainer,
                        identityErrorMessage,
                        cached.identity_message || 'Kredensial NIK atau Email tidak ditemukan dalam data personel teknisi kami.'
                    );
                }
                updateSubmitButtonState();
                return;
            }

            // Abort prior in-flight request to eliminate race conditions
            if (activeAbortController) {
                activeAbortController.abort();
            }
            activeAbortController = new AbortController();

            const reqId = ++currentRequestId;
            const url = `/auth/check-credentials?identity=${encodeURIComponent(trimmedIdentity)}&password=${encodeURIComponent(trimmedPassword)}`;

            fetch(url, {
                signal: activeAbortController.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (reqId !== currentRequestId) return;

                // Cache identity lookup result for instant future lookups
                if (!trimmedPassword) {
                    identityCheckCache.set(trimmedIdentity, {
                        identity_valid: data.identity_valid,
                        identity_message: data.identity_message
                    });
                }

                // 1. Evaluasi Status Kolom Identity
                if (data.identity_valid) {
                    isIdentityValid = true;
                    setFieldValid(identityInput, identityIcon, identityErrorContainer);
                } else {
                    isIdentityValid = false;
                    setFieldInvalid(
                        identityInput,
                        identityIcon,
                        identityErrorContainer,
                        identityErrorMessage,
                        data.identity_message || 'Kredensial NIK atau Email tidak ditemukan dalam data personel teknisi kami.'
                    );
                }

                // 2. Evaluasi Status Kolom Password jika sudah diisi
                if (trimmedPassword && trimmedPassword.length >= 8) {
                    if (data.password_valid === true) {
                        isPasswordValid = true;
                        setFieldValid(passwordInput, passwordIcon, passwordErrorContainer);
                    } else if (data.password_valid === false) {
                        isPasswordValid = false;
                        setFieldInvalid(
                            passwordInput,
                            passwordIcon,
                            passwordErrorContainer,
                            passwordErrorMessage,
                            data.password_message || 'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.'
                        );
                    }
                } else if (!trimmedPassword) {
                    isPasswordValid = false;
                    setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                }

                updateSubmitButtonState();
            })
            .catch(err => {
                if (err.name === 'AbortError') return; // Ignore intentional abort
                console.error('Check credentials error:', err);
            });
        }

        function validateIdentity(isTyping = false) {
            const val = identityInput.value.trim();

            if (val === '') {
                isIdentityValid = false;
                if (isTyping) {
                    // While typing: if user cleared the input, remain calm & neutral without jarring error
                    setFieldNeutral(identityInput, identityIcon, identityErrorContainer);
                } else if (identityTouched) {
                    // On blur or submit: show error if field is left empty
                    setFieldInvalid(
                        identityInput,
                        identityIcon,
                        identityErrorContainer,
                        identityErrorMessage,
                        'Kolom Email atau NIK wajib diisi.'
                    );
                }
                updateSubmitButtonState();
                return;
            }

            identityTouched = true;

            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            const hasAtOrLetters = /[@a-zA-Z]/.test(val);
            const isOnlyDigits = /^\d+$/.test(val);

            if (isTyping) {
                // BALANCED UX WHILE TYPING:
                // Only trigger live check when format is complete (avoid premature format nagging)
                if (emailRegex.test(val)) {
                    checkCredentialsAsync(val, passwordInput.value);
                } else if (isOnlyDigits && val.length >= 6 && val.length <= 20) {
                    checkCredentialsAsync(val, passwordInput.value);
                } else {
                    // Input is in-progress (e.g. user just typed partial email or digits)
                    // Keep state calm/neutral and dismiss prior error
                    isIdentityValid = false;
                    setFieldNeutral(identityInput, identityIcon, identityErrorContainer);
                    updateSubmitButtonState();
                }
                return;
            }

            // THOROUGH VALIDATION ON BLUR OR SUBMISSION:
            if (hasAtOrLetters) {
                if (!emailRegex.test(val)) {
                    isIdentityValid = false;
                    setFieldInvalid(
                        identityInput,
                        identityIcon,
                        identityErrorContainer,
                        identityErrorMessage,
                        'Format alamat email belum lengkap atau tidak valid.'
                    );
                    updateSubmitButtonState();
                    return;
                }
            } else if (isOnlyDigits) {
                if (val.length < 6 || val.length > 20) {
                    isIdentityValid = false;
                    setFieldInvalid(
                        identityInput,
                        identityIcon,
                        identityErrorContainer,
                        identityErrorMessage,
                        'Format NIK tidak valid. Masukkan nomor induk personel yang sesuai.'
                    );
                    updateSubmitButtonState();
                    return;
                }
            } else {
                isIdentityValid = false;
                setFieldInvalid(
                    identityInput,
                    identityIcon,
                    identityErrorContainer,
                    identityErrorMessage,
                    'Format alamat email belum lengkap atau tidak valid.'
                );
                updateSubmitButtonState();
                return;
            }

            // Format is valid -> verify credentials
            checkCredentialsAsync(val, passwordInput.value);
        }

        function validatePassword(isTyping = false) {
            const val = passwordInput.value;

            // 1. Kolom password kosong (baik awal, disentuh lalu dikosongkan, atau saat blur):
            // Strictly hide error notification, return to neutral
            if (val === '') {
                isPasswordValid = false;
                setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                updateSubmitButtonState();
                return;
            }

            passwordTouched = true;

            if (isTyping) {
                if (val.length >= 8) {
                    if (isIdentityValid) {
                        checkCredentialsAsync(identityInput.value.trim(), val);
                    } else {
                        setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                        isPasswordValid = false;
                        updateSubmitButtonState();
                    }
                } else {
                    // While typing (<8 chars), remain neutral without premature error
                    isPasswordValid = false;
                    setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                    updateSubmitButtonState();
                }
                return;
            }

            // On blur:
            if (val.length < 8) {
                isPasswordValid = false;
                setFieldInvalid(
                    passwordInput,
                    passwordIcon,
                    passwordErrorContainer,
                    passwordErrorMessage,
                    'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.'
                );
                updateSubmitButtonState();
                return;
            }

            if (isIdentityValid) {
                checkCredentialsAsync(identityInput.value.trim(), val);
            } else {
                setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                isPasswordValid = false;
                updateSubmitButtonState();
            }
        }

        // Event Listeners: Debounced Input (400ms) & Blur
        identityInput.addEventListener('input', () => {
            clearTimeout(identityDebounceTimer);
            identityDebounceTimer = setTimeout(() => {
                validateIdentity(true);
            }, 400);
        });

        identityInput.addEventListener('blur', () => {
            clearTimeout(identityDebounceTimer);
            validateIdentity(false);
        });

        passwordInput.addEventListener('input', () => {
            clearTimeout(passwordDebounceTimer);
            if (passwordInput.value === '') {
                isPasswordValid = false;
                setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                updateSubmitButtonState();
                return;
            }
            passwordDebounceTimer = setTimeout(() => {
                validatePassword(true);
            }, 400);
        });

        passwordInput.addEventListener('blur', () => {
            clearTimeout(passwordDebounceTimer);
            if (passwordInput.value === '') {
                isPasswordValid = false;
                setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);
                updateSubmitButtonState();
                return;
            }
            validatePassword(false);
        });

        function handleFormSubmit(event) {
            identityTouched = true;
            passwordTouched = true;

            validateIdentity(false);
            if (passwordInput.value !== '') {
                validatePassword(false);
            } else {
                isPasswordValid = false;
                setFieldInvalid(
                    passwordInput,
                    passwordIcon,
                    passwordErrorContainer,
                    passwordErrorMessage,
                    'Kolom Password wajib diisi.'
                );
            }

            if (!isIdentityValid || !isPasswordValid) {
                event.preventDefault();
                if (!isIdentityValid) {
                    identityInput.focus();
                } else if (!isPasswordValid) {
                    passwordInput.focus();
                }
                return false;
            }

            const submitBtn = document.getElementById('submitAuthBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengautentikasi...</span>
            `;
            return true;
        }

        // Initialize state on page load (autofill or server validation redirect)
        window.addEventListener('DOMContentLoaded', () => {
            @if ($initialIdentityError)
                identityTouched = true;
                isIdentityValid = false;
                setFieldInvalid(identityInput, identityIcon, identityErrorContainer, identityErrorMessage, "{{ $initialIdentityError }}");
            @endif

            // Pastikan kolom password dalam state netral tanpa error saat awal halaman dimuat
            setFieldNeutral(passwordInput, passwordIcon, passwordErrorContainer);

            updateSubmitButtonState();

            // Detect autofilled values from browser password manager
            setTimeout(() => {
                if (identityInput.value && !isIdentityValid && !identityTouched) {
                    validateIdentity(false);
                }
                if (passwordInput.value && !isPasswordValid && !passwordTouched) {
                    validatePassword(false);
                }
            }, 300);
        });
    </script>

</body>
</html>
