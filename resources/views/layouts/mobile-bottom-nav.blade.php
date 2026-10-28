@php
    $isDashboard = request()->routeIs('dashboard');
    $isValins = request()->routeIs('valins.*');
    $isGpon = request()->routeIs('master-gpon.*');
    $isProfile = request()->routeIs('profile.*');
@endphp

<!-- ================= BILAH NAVIGASI BAWAH LEKAT PENUH (EDGE-TO-EDGE DOCKED BOTTOM TAB BAR) ================= -->
<nav class="fixed bottom-0 inset-x-0 z-40 lg:hidden w-full bg-white border-t border-slate-200/90 shadow-[0_-4px_20px_rgba(15,23,42,0.06)] select-none"
     style="padding-bottom: max(0.25rem, env(safe-area-inset-bottom, 0px));"
     aria-label="Navigasi Bawah Ponsel">
    <div class="grid grid-cols-4 w-full h-15 sm:h-16 max-w-full">
        
        <!-- 1. MENU BERANDA / DASHBOARD -->
        <a href="{{ route('dashboard') }}" 
           class="relative flex flex-col items-center justify-center py-1.5 px-0.5 h-full transition-all duration-150 active:scale-95 group"
           title="Beranda Dashboard">
            @if($isDashboard)
                <!-- Penanda Mikro Garis Atas Aktif (Merah Korporat Solid) -->
                <span class="absolute top-0 inset-x-3 sm:inset-x-6 h-[2.5px] bg-[#AE0C00] rounded-b-full shadow-2xs"></span>
            @endif

            <div class="flex items-center justify-center w-6 h-6 shrink-0 transition-transform duration-150 group-active:scale-90">
                <svg class="w-5 h-5 transition-colors duration-150 {{ $isDashboard ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="{{ $isDashboard ? '2.2' : '1.8' }}" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </div>

            <span class="text-[10px] font-headline {{ $isDashboard ? 'font-bold text-[#AE0C00]' : 'font-semibold text-slate-500 group-hover:text-slate-700' }} tracking-tight leading-none mt-1 transition-colors">
                Dashboard
            </span>
        </a>

        <!-- 2. MENU VALINS SERVICES -->
        <a href="{{ route('valins.index') }}" 
           class="relative flex flex-col items-center justify-center py-1.5 px-0.5 h-full transition-all duration-150 active:scale-95 group"
           title="Valins Services">
            @if($isValins)
                <!-- Penanda Mikro Garis Atas Aktif (Merah Korporat Solid) -->
                <span class="absolute top-0 inset-x-3 sm:inset-x-6 h-[2.5px] bg-[#AE0C00] rounded-b-full shadow-2xs"></span>
            @endif

            <div class="flex items-center justify-center w-6 h-6 shrink-0 transition-transform duration-150 group-active:scale-90">
                <svg class="w-5 h-5 transition-colors duration-150 {{ $isValins ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="{{ $isValins ? '2.2' : '1.8' }}" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>

            <span class="text-[10px] font-headline {{ $isValins ? 'font-bold text-[#AE0C00]' : 'font-semibold text-slate-500 group-hover:text-slate-700' }} tracking-tight leading-none mt-1 transition-colors">
                Valins
            </span>
        </a>

        <!-- 3. MENU MONITORING GPON -->
        <a href="{{ route('master-gpon.index') }}" 
           class="relative flex flex-col items-center justify-center py-1.5 px-0.5 h-full transition-all duration-150 active:scale-95 group"
           title="Monitoring GPON">
            @if($isGpon)
                <!-- Penanda Mikro Garis Atas Aktif (Merah Korporat Solid) -->
                <span class="absolute top-0 inset-x-3 sm:inset-x-6 h-[2.5px] bg-[#AE0C00] rounded-b-full shadow-2xs"></span>
            @endif

            <div class="flex items-center justify-center w-6 h-6 shrink-0 transition-transform duration-150 group-active:scale-90">
                <svg class="w-5 h-5 transition-colors duration-150 {{ $isGpon ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="{{ $isGpon ? '2.2' : '1.8' }}" 
                     viewBox="0 0 24 24">
                    <rect x="2.5" y="3.5" width="19" height="6.5" rx="2" />
                    <rect x="2.5" y="14" width="19" height="6.5" rx="2" />
                    <line x1="6" y1="6.75" x2="6.01" y2="6.75" stroke-linecap="round" stroke-width="2.5" />
                    <line x1="9.5" y1="6.75" x2="9.51" y2="6.75" stroke-linecap="round" stroke-width="2.5" />
                    <line x1="6" y1="17.25" x2="6.01" y2="17.25" stroke-linecap="round" stroke-width="2.5" />
                    <line x1="9.5" y1="17.25" x2="9.51" y2="17.25" stroke-linecap="round" stroke-width="2.5" />
                </svg>
            </div>

            <span class="text-[10px] font-headline {{ $isGpon ? 'font-bold text-[#AE0C00]' : 'font-semibold text-slate-500 group-hover:text-slate-700' }} tracking-tight leading-none mt-1 transition-colors">
                GPON
            </span>
        </a>

        <!-- 4. MENU PROFIL & AKUN -->
        <a href="{{ route('profile.edit') }}" 
           class="relative flex flex-col items-center justify-center py-1.5 px-0.5 h-full transition-all duration-150 active:scale-95 group"
           title="Pengaturan Akun & Profil">
            @if($isProfile)
                <!-- Penanda Mikro Garis Atas Aktif (Merah Korporat Solid) -->
                <span class="absolute top-0 inset-x-3 sm:inset-x-6 h-[2.5px] bg-[#AE0C00] rounded-b-full shadow-2xs"></span>
            @endif

            <div class="flex items-center justify-center w-6 h-6 shrink-0 transition-transform duration-150 group-active:scale-90">
                <svg class="w-5 h-5 transition-colors duration-150 {{ $isProfile ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="{{ $isProfile ? '2.2' : '1.8' }}" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>

            <span class="text-[10px] font-headline {{ $isProfile ? 'font-bold text-[#AE0C00]' : 'font-semibold text-slate-500 group-hover:text-slate-700' }} tracking-tight leading-none mt-1 transition-colors">
                Akun
            </span>
        </a>

    </div>
</nav>
