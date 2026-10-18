<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi OTP & Sandi Baru - Telkom Akses Sukabumi</title>

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

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }

        .animate-shake {
            animation: shake 0.3s ease-in-out;
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

        <!-- ================= RIGHT COLUMN: Clean Pure White Verification Form ================= -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-between px-5 py-6 sm:p-10 lg:p-12 xl:p-16 min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto custom-auth-scrollbar relative">
            
            <!-- Top Navigation: Kembali & Mobile Logo -->
            <div class="flex items-center justify-between w-full mb-4 sm:mb-6">
                <a href="{{ route('password.request') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-[#bc0007] transition-colors group">
                    <span class="material-symbols-outlined text-base transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali</span>
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
            <div class="my-auto w-full max-w-[400px] sm:max-w-[430px] mx-auto py-2 sm:py-4">
                
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
                            Verifikasi OTP &amp; Sandi Baru
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">
                            Masukkan 6-digit kode OTP yang telah dikirim ke email, lalu tentukan kata sandi baru.
                        </p>
                    </div>
                </div>

                <!-- ================= DESKTOP ONLY: Heading Verifikasi OTP ================= -->
                <div class="hidden lg:block mb-5 sm:mb-6">
                    <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Verifikasi OTP &amp; Sandi Baru
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        Masukkan 6-digit kode OTP yang telah dikirim ke email, lalu tentukan kata sandi baru.
                    </p>
                </div>

                <!-- Session / Error Alerts -->
                @if (session('status'))
                    <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3.5 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-600 text-[18px]">warning</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Recipient Context Info Card -->
                @php
                    $displayUser = $user ?? (session('otp_reset_user_id') ? \App\Models\User::find(session('otp_reset_user_id')) : null);
                    $emailVal = $displayUser->email ?? session('otp_reset_email') ?? old('email') ?? request('email');
                    $nikVal = $displayUser->nik ?? session('otp_reset_nik') ?? 'PERSONEL TEKNISI';
                    $nameVal = $displayUser->name ?? session('otp_reset_name') ?? 'Pengguna SIM VALINS';
                @endphp

                @if($emailVal)
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl p-3 mb-4 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-[#bc0007] text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-base">mail</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[11px] font-bold text-slate-900 truncate">{{ $emailVal }}</span>
                                <span class="text-[10px] text-slate-500 font-telemetry">NIK: {{ $nikVal }} • {{ $nameVal }}</span>
                            </div>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-[#bc0007] hover:underline shrink-0 ml-2" title="Ganti Email atau NIK">
                            Ubah
                        </a>
                    </div>
                @endif

                <!-- Interactive Reset Form -->
                <form method="POST" action="{{ route('password.otp.verify') }}" class="space-y-4" id="otpForm" onsubmit="handleOtpSubmit(event)" novalidate>
                    @csrf

                    <!-- Hidden inputs for legacy token / user context -->
                    <input type="hidden" name="email" value="{{ $emailVal }}">
                    @if(request()->route('token'))
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    @endif

                    <!-- Section 1: OTP Input 6-Digit -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry">
                                KODE OTP (6 DIGIT) <span class="text-[#bc0007]">*</span>
                            </label>
                            <span class="font-telemetry text-[10px] text-[#bc0007] font-bold flex items-center gap-1 bg-red-50 border border-red-100 px-2 py-0.5 rounded-lg">
                                <span class="material-symbols-outlined text-[12px] animate-pulse">timer</span>
                                <span id="countdownTimer">15:00</span>
                            </span>
                        </div>

                        <!-- 6 Digit Input Group -->
                        <div class="flex items-center justify-between gap-1.5 sm:gap-2 pt-0.5" id="otpInputGroup">
                            <input autofocus 
                                   class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="0" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                            <input class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="1" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                            <input class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="2" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                            
                            <span class="text-slate-300 font-bold text-sm select-none">-</span>

                            <input class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="3" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                            <input class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="4" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                            <input class="otp-cell w-11 h-12 sm:w-12 sm:h-12 text-center font-telemetry text-xl sm:text-2xl font-bold rounded-xl bg-slate-50 border-2 border-slate-200 text-slate-900 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 outline-none transition-all shadow-xs" 
                                   data-index="5" 
                                   maxlength="1" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   autocomplete="one-time-code"
                                   type="text">
                        </div>

                        <!-- Hidden combined OTP input for server submission -->
                        <input type="hidden" name="otp" id="combinedOtpInput" required>

                        <!-- Slot Kontainer Pesan Error Khusus OTP (CSS Grid Row Transition - Zero Abrupt Layout Shift) -->
                        <div id="otpErrorWrapper" class="{{ $errors->has('otp') ? 'grid grid-rows-[1fr] opacity-100 mt-2.5 mb-1 transition-all duration-300 ease-out' : 'grid grid-rows-[0fr] opacity-0 transition-all duration-300 ease-out pointer-events-none' }}" aria-live="polite">
                            <div class="overflow-hidden">
                                <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-red-50/80 border border-red-200/80 text-xs sm:text-[13px] font-medium text-red-600 leading-snug">
                                    <svg class="w-4 h-4 shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-linecap="round" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-linecap="round" />
                                    </svg>
                                    <span id="otpErrorMessage">{{ $errors->first('otp') ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Resend Action Trigger -->
                        <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                            <span>Tidak menerima kode?</span>
                            <button form="resendOtpForm" 
                                    class="font-bold text-[#bc0007] hover:text-[#960005] hover:underline inline-flex items-center gap-1 cursor-pointer" 
                                    id="btnResendOtp" 
                                    type="submit">
                                <span class="material-symbols-outlined text-[14px]">refresh</span>
                                <span>Kirim Ulang OTP</span>
                            </button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                    </div>

                    <!-- Section 2: Password Reset Inputs -->
                    <div class="space-y-3.5">
                        
                        <!-- New Password Field -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry" for="newPassword">
                                    KATA SANDI BARU <span class="text-[#bc0007]">*</span>
                                </label>
                                <span class="text-[10px] text-slate-400">Min. 8 Karakter</span>
                            </div>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg pointer-events-none">
                                    lock
                                </span>
                                <input class="w-full h-12 pl-11 pr-11 bg-white text-slate-900 text-sm rounded-xl border {{ $errors->has('password') ? 'border-red-500 bg-red-50/10' : 'border-slate-200' }} focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 transition-all outline-none" 
                                       id="newPassword" 
                                       name="password" 
                                       value="{{ old('password') }}"
                                       placeholder="••••••••" 
                                       required 
                                       type="password"
                                       oninput="evaluatePasswordStrength(this.value)">
                                <button aria-label="Toggle password visibility" 
                                        class="absolute right-3 text-slate-400 hover:text-slate-700 p-1.5 rounded-lg transition-colors cursor-pointer" 
                                        id="togglePassBtn" 
                                        type="button"
                                        onclick="toggleVisibility('newPassword', 'eyeIconNew')">
                                    <span class="material-symbols-outlined text-lg" id="eyeIconNew">visibility</span>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <div class="mt-1 flex items-center gap-1.5 text-xs text-red-600 font-medium">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    <span>{{ $errors->first('password') }}</span>
                                </div>
                            @endif

                            <!-- Password Strength Meter -->
                            <div class="pt-0.5 space-y-1">
                                <div class="flex items-center justify-between text-[10px]">
                                    <span class="text-slate-500 font-medium">Kekuatan Sandi:</span>
                                    <span class="font-bold text-slate-400" id="strengthLabel">Belum Diisi</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden flex gap-1">
                                    <div class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300" id="meter1"></div>
                                    <div class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300" id="meter2"></div>
                                    <div class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300" id="meter3"></div>
                                    <div class="h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300" id="meter4"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-[11px] font-bold text-slate-700 tracking-wider uppercase font-telemetry" for="confirmPassword">
                                    KONFIRMASI KATA SANDI <span class="text-[#bc0007]">*</span>
                                </label>
                                <span class="text-[10px] font-semibold text-slate-400 flex items-center gap-1" id="matchBadge">
                                    <span class="material-symbols-outlined text-[13px]">check</span>
                                    <span>Ketik ulang sandi</span>
                                </span>
                            </div>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg pointer-events-none">
                                    verified_user
                                </span>
                                <input class="w-full h-12 pl-11 pr-11 bg-white text-slate-900 text-sm rounded-xl border border-slate-200 focus:border-[#bc0007] focus:ring-2 focus:ring-[#bc0007]/20 transition-all outline-none" 
                                       id="confirmPassword" 
                                       name="password_confirmation" 
                                       value="{{ old('password_confirmation') }}"
                                       placeholder="••••••••" 
                                       required 
                                       type="password"
                                       oninput="checkPasswordMatch()">
                                <button aria-label="Toggle password visibility" 
                                        class="absolute right-3 text-slate-400 hover:text-slate-700 p-1.5 rounded-lg transition-colors cursor-pointer" 
                                        type="button"
                                        onclick="toggleVisibility('confirmPassword', 'eyeIconConfirm')">
                                    <span class="material-symbols-outlined text-lg" id="eyeIconConfirm">visibility</span>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Action Button: Perbarui Kata Sandi -->
                    <div class="pt-2">
                        <button class="w-full h-12 flex items-center justify-center gap-2 bg-[#bc0007] hover:bg-[#960005] active:bg-[#7a0004] text-white font-headline text-base font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed" 
                                id="btnSubmitReset" 
                                type="submit">
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>

                    <!-- Bottom Link: Sudah ingat kata sandi? Masuk -->
                    <div class="pt-3 text-center">
                        <p class="text-xs sm:text-sm text-slate-500">
                            Sudah ingat kata sandi? 
                            <a class="text-[#bc0007] font-bold hover:underline ml-1" href="{{ route('login') }}">
                                Masuk
                            </a>
                        </p>
                    </div>

                </form>

                <!-- Hidden Standalone Resend Form -->
                <form method="POST" action="{{ route('password.otp.resend') }}" id="resendOtpForm" class="hidden">
                    @csrf
                    <input type="hidden" name="email" value="{{ $emailVal }}">
                    @if($displayUser)
                        <input type="hidden" name="user_id" value="{{ $displayUser->id }}">
                    @endif
                </form>

            </div>
        </div>
    </div>

    <!-- Interactive Scripts for OTP Boxes, Countdown, & Password Strength -->
    <script>
        // 1. 6-Digit OTP Cells Handling & DOM Elements
        const otpCells = document.querySelectorAll('.otp-cell');
        const combinedOtpInput = document.getElementById('combinedOtpInput');
        const otpErrorWrapper = document.getElementById('otpErrorWrapper');
        const otpErrorMessage = document.getElementById('otpErrorMessage');

        function syncCombinedOtp() {
            let combined = '';
            otpCells.forEach(c => combined += c.value.trim());
            combinedOtpInput.value = combined;
            return combined;
        }

        function showOtpError(message, isServerFailure = false) {
            if (!otpErrorWrapper || !otpErrorMessage) return;
            otpErrorMessage.textContent = message;
            otpErrorWrapper.classList.remove('grid-rows-[0fr]', 'opacity-0', 'pointer-events-none');
            otpErrorWrapper.classList.add('grid-rows-[1fr]', 'opacity-100', 'mt-2.5', 'mb-1');

            if (isServerFailure) {
                otpCells.forEach(cell => {
                    cell.classList.remove(
                        'border-slate-200', 'bg-slate-50', 'bg-white', 'text-slate-900',
                        'ring-2', 'ring-red-500/15', 'bg-red-50/30'
                    );
                    cell.classList.add(
                        'border-red-500', 'bg-red-50/20', 'text-red-700',
                        'transition-colors', 'duration-200',
                        'animate-[shake_0.3s_ease-in-out]', 'animate-shake'
                    );
                });
                setTimeout(() => {
                    otpCells.forEach(cell => {
                        cell.classList.remove('animate-[shake_0.3s_ease-in-out]', 'animate-shake');
                    });
                }, 400);
            }
        }

        function clearOtpErrors() {
            if (otpErrorWrapper) {
                otpErrorWrapper.classList.remove('grid-rows-[1fr]', 'opacity-100', 'mt-2.5', 'mb-1');
                otpErrorWrapper.classList.add('grid-rows-[0fr]', 'opacity-0', 'pointer-events-none');
            }

            otpCells.forEach(cell => {
                cell.classList.remove(
                    'border-red-500',
                    'bg-red-50/20',
                    'bg-red-50/30',
                    'text-red-700',
                    'ring-2',
                    'ring-red-500/15',
                    'animate-[shake_0.3s_ease-in-out]',
                    'animate-shake'
                );
                cell.classList.add('border-slate-200', 'bg-slate-50', 'text-slate-900');
            });
        }

        otpCells.forEach((cell, idx) => {
            // Numeric-Only Guardrail & Auto-Advance Input
            cell.addEventListener('input', (e) => {
                clearOtpErrors();
                const rawVal = e.target.value;
                const cleanDigits = rawVal.replace(/[^0-9]/g, '');

                if (!cleanDigits) {
                    cell.value = '';
                    syncCombinedOtp();
                    return;
                }

                cell.value = cleanDigits.slice(-1);
                syncCombinedOtp();

                // Auto-advance to next cell
                if (idx < otpCells.length - 1) {
                    otpCells[idx + 1].focus();
                    if (otpCells[idx + 1].value) {
                        otpCells[idx + 1].select();
                    }
                }
            });

            // Backspace Navigation & Arrow Keys
            cell.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    clearOtpErrors();
                    if (!cell.value && idx > 0) {
                        e.preventDefault();
                        otpCells[idx - 1].focus();
                        otpCells[idx - 1].value = '';
                        syncCombinedOtp();
                    } else if (cell.value) {
                        cell.value = '';
                        syncCombinedOtp();
                    }
                } else if (e.key === 'ArrowLeft' && idx > 0) {
                    otpCells[idx - 1].focus();
                } else if (e.key === 'ArrowRight' && idx < otpCells.length - 1) {
                    otpCells[idx + 1].focus();
                }
            });

            // Smart Paste (supports 6-digit paste from Gmail/SMS)
            cell.addEventListener('paste', (e) => {
                e.preventDefault();
                clearOtpErrors();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
                const digits = pasteData.replace(/\D/g, '').slice(0, 6);
                if (digits) {
                    digits.split('').forEach((d, i) => {
                        if (otpCells[i]) {
                            otpCells[i].value = d;
                        }
                    });
                    const targetFocus = Math.min(digits.length, otpCells.length - 1);
                    otpCells[targetFocus].focus();
                    syncCombinedOtp();
                }
            });
        });

        // 2. Countdown Timer (15 Minutes)
        let totalSeconds = 15 * 60;
        const countdownEl = document.getElementById('countdownTimer');

        const timerInterval = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                countdownEl.textContent = '00:00 (Habis)';
                countdownEl.classList.remove('bg-red-50', 'text-[#bc0007]');
                countdownEl.classList.add('bg-slate-200', 'text-slate-600');
                return;
            }
            totalSeconds--;
            const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            const secs = String(totalSeconds % 60).padStart(2, '0');
            countdownEl.textContent = `${mins}:${secs}`;
        }, 1000);

        // 3. Password Visibility Toggle
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        // 4. Password Strength Evaluation
        function evaluatePasswordStrength(val) {
            const meter1 = document.getElementById('meter1');
            const meter2 = document.getElementById('meter2');
            const meter3 = document.getElementById('meter3');
            const meter4 = document.getElementById('meter4');
            const label = document.getElementById('strengthLabel');

            const hasLen = val.length >= 8;
            const hasCase = /[a-z]/.test(val) && /[A-Z]/.test(val);
            const hasNum = /[0-9]/.test(val);
            const hasSym = /[^a-zA-Z0-9]/.test(val);

            let score = 0;
            if (hasLen) score++;
            if (hasCase) score++;
            if (hasNum) score++;
            if (hasSym) score++;

            // Reset meters
            [meter1, meter2, meter3, meter4].forEach(m => {
                m.className = 'h-full w-1/4 bg-slate-200 rounded-full transition-all duration-300';
            });

            if (!val) {
                label.textContent = 'Belum Diisi';
                label.className = 'font-bold text-slate-400';
                checkPasswordMatch();
                return;
            }

            if (score <= 1) {
                meter1.className = 'h-full w-1/4 bg-red-500 rounded-full transition-all duration-300';
                label.textContent = 'Lemah';
                label.className = 'font-bold text-red-600';
            } else if (score === 2) {
                meter1.className = 'h-full w-1/4 bg-amber-500 rounded-full transition-all duration-300';
                meter2.className = 'h-full w-1/4 bg-amber-500 rounded-full transition-all duration-300';
                label.textContent = 'Cukup';
                label.className = 'font-bold text-amber-600';
            } else if (score === 3) {
                meter1.className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                meter2.className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                meter3.className = 'h-full w-1/4 bg-sky-500 rounded-full transition-all duration-300';
                label.textContent = 'Kuat';
                label.className = 'font-bold text-sky-600';
            } else {
                [meter1, meter2, meter3, meter4].forEach(m => {
                    m.className = 'h-full w-1/4 bg-emerald-500 rounded-full transition-all duration-300';
                });
                label.textContent = 'Sangat Kuat';
                label.className = 'font-bold text-emerald-600';
            }

            checkPasswordMatch();
        }

        // 5. Password Match Verification
        function checkPasswordMatch() {
            const pwd = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            const badge = document.getElementById('matchBadge');

            if (!confirm) {
                badge.className = 'text-[10px] font-semibold text-slate-400 flex items-center gap-1';
                badge.innerHTML = `<span class="material-symbols-outlined text-[13px]">check</span><span>Ketik ulang sandi</span>`;
                return;
            }

            if (pwd === confirm) {
                badge.className = 'text-[10px] font-bold text-emerald-600 flex items-center gap-1';
                badge.innerHTML = `<span class="material-symbols-outlined text-[13px]">check_circle</span><span>Kata sandi cocok</span>`;
            } else {
                badge.className = 'text-[10px] font-bold text-red-600 flex items-center gap-1';
                badge.innerHTML = `<span class="material-symbols-outlined text-[13px]">cancel</span><span>Belum cocok</span>`;
            }
        }

        // 6. Handle Submit (Zero Page Reload UX via Fetch, Preserving Password Fields)
        async function handleOtpSubmit(event) {
            event.preventDefault();
            const combinedVal = syncCombinedOtp();

            if (combinedVal.length < 6) {
                let firstEmptyCell = null;
                otpCells.forEach((cell) => {
                    if (!cell.value.trim()) {
                        cell.classList.remove('border-slate-200', 'bg-slate-50', 'bg-red-50/20', 'text-red-700');
                        cell.classList.add('border-red-500', 'bg-red-50/30', 'ring-2', 'ring-red-500/15', 'transition-all', 'duration-200');
                        if (!firstEmptyCell) {
                            firstEmptyCell = cell;
                        }
                    } else {
                        cell.classList.remove('border-red-500', 'bg-red-50/30', 'ring-2', 'ring-red-500/15', 'animate-[shake_0.3s_ease-in-out]', 'animate-shake');
                        cell.classList.add('border-slate-200', 'bg-slate-50');
                    }
                });

                if (firstEmptyCell) {
                    firstEmptyCell.focus();
                }

                showOtpError('Silakan lengkapi seluruh 6 digit kode OTP yang telah dikirimkan ke email Anda.', false);
                return false;
            }

            const newPwd = document.getElementById('newPassword').value;
            const confirmPwd = document.getElementById('confirmPassword').value;

            if (!newPwd || newPwd.length < 8) {
                document.getElementById('newPassword').focus();
                showOtpError('Kata sandi baru minimal harus terdiri dari 8 karakter.', false);
                return false;
            }

            if (newPwd !== confirmPwd) {
                document.getElementById('confirmPassword').focus();
                showOtpError('Konfirmasi kata sandi belum sesuai dengan kata sandi baru.', false);
                return false;
            }

            const form = document.getElementById('otpForm');
            const btn = document.getElementById('btnSubmitReset');
            const originalBtnHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan Sandi...</span>
            `;

            try {
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    btn.classList.remove('bg-[#bc0007]', 'hover:bg-[#960005]', 'active:bg-[#7a0004]');
                    btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                    btn.innerHTML = `
                        <svg class="w-5 h-5 text-white inline-block mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Berhasil!</span>
                    `;
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 600);
                    return;
                }

                // If error returned (e.g. OTP invalid / expired)
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;

                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                if (data.errors && data.errors.otp) {
                    const otpErr = Array.isArray(data.errors.otp) ? data.errors.otp[0] : data.errors.otp;
                    showOtpError(otpErr, true);
                    otpCells[0]?.focus();
                    otpCells[0]?.select();
                } else if (data.errors && data.errors.password) {
                    const pwdErr = Array.isArray(data.errors.password) ? data.errors.password[0] : data.errors.password;
                    showOtpError(pwdErr, false);
                    document.getElementById('newPassword').focus();
                } else if (data.message) {
                    showOtpError(data.message, true);
                } else {
                    showOtpError('Terjadi kendala saat memvalidasi data. Silakan coba kembali.', false);
                }

            } catch (err) {
                console.error('Submit error:', err);
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                showOtpError('Koneksi terputus atau server tidak merespons. Periksa koneksi Anda.', false);
            }
        }

        // 7. Initial State on Page Load (Handles Server Error Redirects & Preserved Values)
        window.addEventListener('DOMContentLoaded', () => {
            const pwdInput = document.getElementById('newPassword');
            if (pwdInput && pwdInput.value) {
                evaluatePasswordStrength(pwdInput.value);
            }

            @if ($errors->has('otp'))
                showOtpError("{{ $errors->first('otp') }}", true);
                otpCells[0]?.focus();
            @endif
        });
    </script>

</body>
</html>
