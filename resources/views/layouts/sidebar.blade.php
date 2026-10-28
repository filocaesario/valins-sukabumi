@php
    $valinsTab = \App\Models\NavbarTab::where('slug', 'valins-services')->orWhere('route_name', 'valins.index')->first();
    $gponTab   = \App\Models\NavbarTab::where('slug', 'monitoring-gpon')->orWhere('route_name', 'master-gpon.index')->first();

    $user = Auth::user();
    $userName = $user->name ?? 'User';
    $userAvatarUrl = $user?->avatarUrl();
    $nameParts = explode(' ', trim($userName));
    // Mengambil inisial "BI" untuk Bintang Nugraha sesuai rancangan visual
    $initials = count($nameParts) >= 2 
        ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
        : strtoupper(substr($userName, 0, 2));
    
    if (str_starts_with(strtoupper($userName), 'BINTANG')) {
        $initials = 'BI';
    }
@endphp

<!-- ================= SIDEBAR KIRI INTERAKTIF (EKSKLUSIF DESKTOP, NONAKTIF TOTAL DI MOBILE) ================= -->
<aside id="app-sidebar"
       :class="sidebarExpanded ? 'lg:w-64' : 'lg:w-20'"
       class="hidden lg:flex fixed top-0 bottom-0 left-0 z-40 bg-white border-r border-slate-200/90 shadow-xs flex-col justify-between transition-all duration-300 ease-in-out select-none">

    <!-- 1. BAGIAN PUNCAK SIDEBAR: BRAND IDENTITY (EMBLEM SAAT COLLAPSE & FULL LOGO SAAT EXPAND) -->
    <div class="sidebar-top-bar h-16 border-b border-slate-100 flex items-center bg-white shrink-0 px-3 transition-all duration-300"
         :class="sidebarExpanded ? 'justify-between px-3.5' : 'justify-center px-2'">
        
        <!-- Logo Telkom Akses Full saat Expand (Bebas Kedip / Instan Render) -->
        <a href="{{ route('dashboard') }}" 
           @click.stop
           x-show="sidebarExpanded"
           data-sidebar-label
           class="sidebar-logo-expanded sidebar-label-expanded flex items-center gap-2 overflow-hidden transition-all duration-300">
            <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                 alt="Logo Telkom Akses" 
                 class="h-7 sm:h-8 w-auto object-contain"
                 onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
        </a>

        <!-- Logo Emblem Telkom Akses saat Collapse (Menempati Posisi Puncak yang Ditinggalkan Toggle) -->
        <a href="{{ route('dashboard') }}" 
           x-show="!sidebarExpanded" 
           class="sidebar-logo-collapsed flex items-center justify-center w-11 h-11 rounded-xl hover:bg-slate-50 transition-all duration-200 group shrink-0"
           title="Telkom Akses - Beranda Dashboard">
            <img src="{{ asset('images/telkom-akses-logo.png') }}" 
                 alt="Telkom Akses Emblem" 
                 class="w-8.5 h-8.5 object-contain transition-transform duration-200 group-hover:scale-105"
                 onerror="this.src='{{ asset('images/telkom-akses-official-transparent.png') }}'">
        </a>

    </div>

    <!-- 2. DAFTAR MENU NAVIGASI UTAMA (LANGSUNG / TANPA DROPDOWN) -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-2.5 sm:space-y-3 scrollbar-thin scrollbar-thumb-slate-200 overflow-x-hidden">
        
        <!-- Label Kategori Menu (Eksklusif Mode Expand - Tersembunyi Mutlak Saat Collapse) -->
        <div x-show="sidebarExpanded" 
             data-sidebar-label
             class="sidebar-category-header sidebar-label-expanded text-[10px] font-headline font-bold uppercase tracking-wider text-slate-400 px-3 pb-1 transition-opacity duration-200">
            Menu Utama
        </div>

        <!-- Garis Pemisah Halus Pengganti Label Saat Collapse (Menjaga Kestabilan Vertikal Ikon) -->
        <div x-show="!sidebarExpanded" 
             x-cloak
             class="sidebar-divider-collapsed hidden my-1 mx-auto w-8 h-px bg-slate-200/90 rounded-full"
             :class="!sidebarExpanded && 'lg:block'"></div>

        <!-- 1. MENU DASHBOARD -->
        <div class="relative group flex justify-center w-full"
             @mouseenter="showTooltip('dashboard')"
             @mouseleave="hideTooltip('dashboard')">
            <a href="{{ route('dashboard') }}" 
               @click="navigateMenu('dashboard')"
               :class="{
                   'bg-red-50/90 text-red-700 shadow-2xs font-bold': activeMenu === 'dashboard',
                   'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80': activeMenu !== 'dashboard',
                   'w-full h-11 px-3 gap-3': sidebarExpanded,
                   'w-11 h-11 justify-center p-0': !sidebarExpanded
               }"
               class="sidebar-menu-capsule relative flex items-center w-full h-11 px-3 gap-3 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-red-50/90 text-red-700 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                
                <!-- Indikator Lengkungan Garis Merah Korporat (Presisi Tanpa Box-Model Shift) -->
                <span x-show="activeMenu === 'dashboard'"
                      style="{{ request()->routeIs('dashboard') ? '' : 'display: none;' }}"
                      class="sidebar-active-indicator"></span>

                <!-- Ikon Menu (Terkunci Sempurna di Sumbu Tengah Saat Collapse) -->
                <svg class="w-5 h-5 shrink-0 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700' }}" 
                     :class="activeMenu === 'dashboard' ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700'" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>

                <span x-show="sidebarExpanded" data-sidebar-text class="sidebar-text-truncate text-xs font-headline font-semibold tracking-wide truncate">
                    Dashboard
                </span>
            </a>

            <!-- Floating Tooltip saat Sidebar Collapse (Desktop) -->
            <div x-show="!sidebarExpanded && !isNavigating && hoveredTooltip === 'dashboard' && activeMenu !== 'dashboard'" 
                 x-cloak
                 class="hidden lg:block absolute left-full ml-3 top-1/2 -translate-y-1/2 px-2.5 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-lg shadow-xl pointer-events-none whitespace-nowrap z-50">
                Dashboard
                <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-slate-900"></div>
            </div>
        </div>

        <!-- 2. MENU VALINS SERVICES (MENU LANGSUNG / TANPA DROPDOWN) -->
        <div class="relative group flex justify-center w-full"
             @mouseenter="showTooltip('valins')"
             @mouseleave="hideTooltip('valins')">
            <div :class="{
                     'bg-red-50/90 text-red-700 shadow-2xs font-bold': activeMenu === 'valins',
                     'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80': activeMenu !== 'valins',
                     'w-full h-11 justify-between': sidebarExpanded,
                     'w-11 h-11 justify-center p-0': !sidebarExpanded
                 }"
                 class="sidebar-menu-capsule relative flex items-center w-full h-11 justify-between rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('valins.*') ? 'bg-red-50/90 text-red-700 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                
                <!-- Indikator Lengkungan Garis Merah Korporat (Presisi Tanpa Box-Model Shift) -->
                <span x-show="activeMenu === 'valins'"
                      style="{{ request()->routeIs('valins.*') ? '' : 'display: none;' }}"
                      class="sidebar-active-indicator"></span>

                <a href="{{ route('valins.index') }}" 
                   @click="navigateMenu('valins')"
                   class="flex items-center transition-colors duration-200 flex-1 h-full px-3 gap-3 truncate"
                   :class="sidebarExpanded ? 'flex-1 h-full px-3 gap-3 truncate' : 'w-full h-full justify-center p-0'">
                    
                    <!-- Ikon Menu (Terkunci Sempurna di Sumbu Tengah Saat Collapse) -->
                    <svg class="w-5 h-5 shrink-0 transition-colors duration-200 {{ request()->routeIs('valins.*') ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700' }}" 
                         :class="activeMenu === 'valins' ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700'" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>

                    <span x-show="sidebarExpanded" data-sidebar-text class="sidebar-text-truncate text-xs font-headline font-semibold tracking-wide truncate">
                        {{ $valinsTab?->nama_tab ?? 'Valins Services' }}
                    </span>
                </a>

                <!-- Tombol Ubah Penamaan Tab (Muncul saat Kursor Mengarah ke Menu - Hanya saat Expand) -->
                <div x-show="sidebarExpanded" data-sidebar-label class="sidebar-label-expanded pr-2 flex items-center shrink-0">
                    <button type="button" 
                            @click.stop="$dispatch('buka-modal-edit-tab', { 
                                id: {{ $valinsTab?->id ?? 1 }}, 
                                nama: '{{ addslashes($valinsTab?->nama_tab ?? 'Valins Services') }}', 
                                deskripsi: '{{ addslashes($valinsTab?->deskripsi ?? '') }}' 
                            })" 
                            class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-red-600 p-1 rounded-md transition"
                            title="Ubah Nama Tab">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Floating Tooltip saat Sidebar Collapse (Desktop) -->
            <div x-show="!sidebarExpanded && !isNavigating && hoveredTooltip === 'valins' && activeMenu !== 'valins'" 
                 x-cloak
                 class="hidden lg:block absolute left-full ml-3 top-1/2 -translate-y-1/2 px-2.5 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-lg shadow-xl pointer-events-none whitespace-nowrap z-50">
                {{ $valinsTab?->nama_tab ?? 'Valins Services' }}
                <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-slate-900"></div>
            </div>
        </div>

        <!-- 3. MENU MONITORING GPON (MENU LANGSUNG / TANPA DROPDOWN) -->
        <div class="relative group flex justify-center w-full"
             @mouseenter="showTooltip('gpon')"
             @mouseleave="hideTooltip('gpon')">
            <div :class="{
                     'bg-red-50/90 text-red-700 shadow-2xs font-bold': activeMenu === 'gpon',
                     'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80': activeMenu !== 'gpon',
                     'w-full h-11 justify-between': sidebarExpanded,
                     'w-11 h-11 justify-center p-0': !sidebarExpanded
                 }"
                 class="sidebar-menu-capsule relative flex items-center w-full h-11 justify-between rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('master-gpon.*') ? 'bg-red-50/90 text-red-700 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                
                <!-- Indikator Lengkungan Garis Merah Korporat (Presisi Tanpa Box-Model Shift) -->
                <span x-show="activeMenu === 'gpon'"
                      style="{{ request()->routeIs('master-gpon.*') ? '' : 'display: none;' }}"
                      class="sidebar-active-indicator"></span>

                <a href="{{ route('master-gpon.index') }}" 
                   @click="navigateMenu('gpon')"
                   class="flex items-center transition-colors duration-200 flex-1 h-full px-3 gap-3 truncate"
                   :class="sidebarExpanded ? 'flex-1 h-full px-3 gap-3 truncate' : 'w-full h-full justify-center p-0'">
                    
                    <!-- Ikon Menu (Terkunci Sempurna di Sumbu Tengah Saat Collapse) -->
                    <svg class="w-5 h-5 shrink-0 transition-colors duration-200 {{ request()->routeIs('master-gpon.*') ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700' }}" 
                         :class="activeMenu === 'gpon' ? 'text-[#AE0C00]' : 'text-slate-500 group-hover:text-slate-700'" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>

                    <span x-show="sidebarExpanded" data-sidebar-text class="sidebar-text-truncate text-xs font-headline font-semibold tracking-wide truncate">
                        {{ $gponTab?->nama_tab ?? 'Monitoring GPON' }}
                    </span>
                </a>

                <!-- Tombol Ubah Penamaan Tab (Muncul saat Kursor Mengarah ke Menu - Hanya saat Expand) -->
                <div x-show="sidebarExpanded" data-sidebar-label class="sidebar-label-expanded pr-2 flex items-center shrink-0">
                    <button type="button" 
                            @click.stop="$dispatch('buka-modal-edit-tab', { 
                                id: {{ $gponTab?->id ?? 2 }}, 
                                nama: '{{ addslashes($gponTab?->nama_tab ?? 'Monitoring GPON') }}', 
                                deskripsi: '{{ addslashes($gponTab?->deskripsi ?? '') }}' 
                            })" 
                            class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-red-600 p-1 rounded-md transition"
                            title="Ubah Nama Tab">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Floating Tooltip saat Sidebar Collapse (Desktop) -->
            <div x-show="!sidebarExpanded && !isNavigating && hoveredTooltip === 'gpon' && activeMenu !== 'gpon'" 
                 x-cloak
                 class="hidden lg:block absolute left-full ml-3 top-1/2 -translate-y-1/2 px-2.5 py-1.5 bg-slate-900 text-white text-xs font-semibold rounded-lg shadow-xl pointer-events-none whitespace-nowrap z-50">
                {{ $gponTab?->nama_tab ?? 'Monitoring GPON' }}
                <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-slate-900"></div>
            </div>
        </div>

    </div>

    <!-- 3. BAGIAN BAWAH SIDEBAR: AREA PROFIL PENGGUNA & DROPDOWN AKUN -->
    <div x-data="{ 
            profileOpen: false, 
            sidebarAvatarUrl: @js($userAvatarUrl),
            sidebarInitials: @js($initials)
         }" 
         @profile-avatar-updated.window="sidebarAvatarUrl = $event.detail.avatarUrl"
         @click.outside="profileOpen = false" 
         class="p-3 border-t border-slate-100 bg-slate-50/70 relative">
        
        <!-- Tombol Trigger Profil Pengguna -->
        <button type="button" 
                @click="profileOpen = !profileOpen"
                class="w-full flex items-center rounded-2xl transition-all duration-200 p-1.5 hover:bg-white hover:shadow-2xs border border-transparent hover:border-slate-200/80 cursor-pointer focus:outline-none group relative"
                :class="sidebarExpanded ? 'justify-between' : 'justify-center'"
                title="Menu Akun & Profil">
            
            <div class="flex items-center gap-2.5 min-w-0">
                <!-- Avatar Squircle Merah / Foto Profil (Pre-rendered, Zero Pop-in, Instant 0-Lag) -->
                <div class="w-9 h-9 rounded-xl overflow-hidden ring-2 ring-red-100 shadow-xs shrink-0 relative flex items-center justify-center bg-[#AE0C00] font-headline">
                    @if($userAvatarUrl)
                        <img src="{{ $userAvatarUrl }}" 
                             :src="sidebarAvatarUrl || '{{ $userAvatarUrl }}'"
                             x-show="sidebarAvatarUrl"
                             alt="{{ $userName }}" 
                             x-on:error="sidebarAvatarUrl = null"
                             class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300">
                    @else
                        <template x-if="sidebarAvatarUrl">
                            <img :src="sidebarAvatarUrl" 
                                 alt="{{ $userName }}" 
                                 x-on:error="sidebarAvatarUrl = null"
                                 class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300">
                        </template>
                    @endif
                    <span x-show="!sidebarAvatarUrl" class="text-white font-black text-xs select-none" style="{{ $userAvatarUrl ? 'display: none;' : '' }}" x-text="sidebarInitials">
                        {{ $initials }}
                    </span>
                </div>
                
                <!-- Nama dan Sub-Unit Pengguna (Tampil Saat Expand) -->
                <div x-show="sidebarExpanded" 
                     data-sidebar-label
                     class="sidebar-user-info sidebar-label-expanded text-left min-w-0">
                    <div class="font-headline font-bold text-xs text-slate-800 leading-tight truncate">{{ $userName }}</div>
                    <div class="text-[10px] text-slate-400 font-medium leading-tight truncate font-mono">MO DAMAN SKB</div>
                </div>
            </div>

            <!-- Ikon Chevron ke Atas saat Expand -->
            <div x-show="sidebarExpanded" data-sidebar-label class="sidebar-chevron-expanded sidebar-label-expanded text-slate-400 group-hover:text-slate-600 pr-1">
                <svg class="w-4 h-4 transform transition-transform duration-200" 
                     :class="profileOpen ? 'rotate-180' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                </svg>
            </div>
        </button>

        <!-- MENU POPOVER / DROPDOWN PROFIL (Membuka ke Atas Saat Expand, atau ke Samping Kanan Saat Collapse) -->
        <div x-show="profileOpen" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
             :class="sidebarExpanded ? 'bottom-full mb-2 left-2 right-2' : 'left-full bottom-2 ml-3 w-56'"
             class="absolute z-50 bg-white rounded-2xl shadow-xl border border-slate-200/90 py-1 overflow-hidden"
             x-cloak>
            
            <!-- Info Header Pengguna -->
            <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/60 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg overflow-hidden ring-1 ring-red-100 shrink-0 relative flex items-center justify-center bg-[#AE0C00] font-headline">
                    <template x-if="sidebarAvatarUrl">
                        <img :src="sidebarAvatarUrl" 
                             alt="{{ $userName }}" 
                             x-on:error="sidebarAvatarUrl = null"
                             class="w-full h-full object-cover object-center absolute inset-0">
                    </template>
                    <span x-show="!sidebarAvatarUrl" class="text-white font-black text-[11px] select-none" x-text="sidebarInitials">
                        {{ $initials }}
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="font-headline font-bold text-xs text-slate-900 truncate">{{ $userName }}</div>
                    <div class="text-[10px] text-slate-500 font-mono truncate">{{ Auth::user()->email ?? '' }}</div>
                    <span class="inline-block mt-0.5 px-1.5 py-0.2 rounded text-[9px] font-bold tracking-wider uppercase bg-red-100/70 text-[#AE0C00] font-mono">
                        DAMAN SKB
                    </span>
                </div>
            </div>

            <!-- Tautan Pengaturan Profil -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition font-headline font-semibold">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Pengaturan Profil</span>
            </a>

            <!-- Tombol Keluar Akun (Logout) -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-red-600 hover:bg-red-50 hover:text-red-700 transition cursor-pointer text-left font-headline font-semibold">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>

    </div>

</aside>
