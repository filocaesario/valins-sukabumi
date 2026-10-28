<header x-data="{ 
            openInbox: false,
            openNotif: false, 
            openProfile: false,
            mobileSearchOpen: false,
            currentTime: '',
            updateTime() {
                const now = new Date();
                this.currentTime = now.toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit',
                    hour12: false 
                }) + ' WIB';
            }
        }" 
        x-init="updateTime(); setInterval(() => updateTime(), 1000)"
        @keydown.window.prevent.ctrl.k="$refs.globalSearchInput.focus()"
        @keydown.window.prevent.cmd.k="$refs.globalSearchInput.focus()"
        @keydown.escape.window="openInbox = false; openNotif = false; openProfile = false; mobileSearchOpen = false"
        wire:poll.15s="loadData"
        class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300 w-full max-w-full overflow-visible">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-3 lg:gap-5">
            
            <!-- ================= 1. ZONA KIRI: IDENTITAS WILAYAH KERJA & JUDUL MODUL ================= -->
            <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 flex-1 sm:flex-initial">
                <!-- Tombol Single Toggle Desktop (Expand / Collapse Sidebar - Modern Panel Left Dock) -->
                <button type="button" 
                        @click="toggleSidebar()" 
                        class="sidebar-toggle-btn hidden lg:flex items-center justify-center w-9.5 h-9.5 rounded-xl text-slate-500 hover:text-[#AE0C00] hover:bg-red-50/80 transition-all duration-200 focus:outline-none cursor-pointer border border-slate-200/85 shadow-2xs group relative shrink-0 active:scale-95 bg-white select-none mr-2.5 sm:mr-3 lg:mr-4"
                        :title="sidebarExpanded ? 'Ciutkan Sidebar' : 'Perluas Sidebar'">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-[#AE0C00] transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <!-- Bingkai Panel Navigasi Modern -->
                        <rect width="18" height="18" x="3" y="3" rx="2.5"/>
                        <line x1="9" y1="3" x2="9" y2="21"/>
                        <!-- Panah Ciutkan: Menghadap ke Kiri (Aktif saat Sidebar Terbuka / Expand) -->
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 9-3 3 3 3" class="sidebar-panel-arrow-close"/>
                        <!-- Panah Perluas: Menghadap ke Kanan (Aktif saat Sidebar Tertutup / Collapse) -->
                        <path stroke-linecap="round" stroke-linejoin="round" d="m13 9 3 3-3 3" class="sidebar-panel-arrow-open"/>
                    </svg>
                </button>

                <!-- Hierarki Tipografi Kiri Seragam: Baris Atas Wilayah Kerja, Baris Bawah Judul Modul -->
                <div class="flex flex-col min-w-0">
                    <!-- Baris Atas: Label penanda wilayah kerja dalam teks abu-abu netral ringkas -->
                    <div class="flex items-center gap-1.5 text-[10px] sm:text-[10.5px] text-slate-400 font-medium font-sans truncate">
                        <span class="hover:text-slate-600 transition truncate">Witel Sukabumi</span>
                        <span class="hidden sm:inline text-slate-300">/</span>
                        <span class="hidden sm:inline text-slate-500 font-semibold truncate">{{ $breadcrumb }}</span>
                    </div>

                    <!-- Baris Bawah: Judul modul aktif dalam tipografi tebal abu-abu arang yang proporsional -->
                    <div class="flex items-center gap-2 min-w-0 mt-0.5">
                        <h1 class="text-sm sm:text-base font-headline font-bold text-slate-900 tracking-tight truncate">
                            {{ $pageTitle }}
                        </h1>
                    </div>
                </div>
            </div>

            <!-- ================= 2. ZONA TENGAH: PENCARIAN CEPAT GLOBAL (FLEKSIBEL & ANTI-TERPOTONG) ================= -->
            <div class="hidden md:flex flex-1 max-w-md lg:max-w-lg xl:max-w-xl mx-2 sm:mx-3 lg:mx-4 justify-center min-w-0">
                <form action="{{ route('valins.index') }}" method="GET" class="w-full relative">
                    <div class="relative w-full">
                        <input type="text" 
                               name="search"
                               x-ref="globalSearchInput"
                               placeholder="Cari cepat ODP, Valins ID, atau Node OLT..." 
                               class="w-full pl-9.5 pr-20 py-2 text-xs rounded-xl bg-slate-100/80 hover:bg-slate-100/95 focus:bg-white border border-slate-200/85 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none transition placeholder-slate-400 text-slate-800 shadow-2xs font-sans">
                        
                        <!-- Ikon Kaca Pembesar Kiri -->
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>

                        <!-- Lencana Pintasan Papan Ketik Ctrl + K -->
                        <div class="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center pointer-events-none">
                            <kbd class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-mono font-medium text-slate-400 bg-white border border-slate-200/90 rounded-md shadow-2xs">Ctrl + K</kbd>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ================= 3. ZONA KANAN: STATUS WAKTU, INBOX, NOTIFIKASI & PROFIL PENGGUNA ================= -->
            <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
                
                <!-- Tombol Kaca Pembesar Mobile (Hanya di Layar Kecil < md) -->
                <button type="button" 
                        @click="mobileSearchOpen = !mobileSearchOpen"
                        class="md:hidden w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition border border-slate-200/80 shadow-2xs cursor-pointer"
                        title="Buka Pencarian Cepat">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- 1. Indikator Waktu Real-Time WIB & Tombol Sinkronisasi Cepat -->
                <div class="hidden lg:flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-600 font-mono text-xs shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3 2"/>
                    </svg>
                    <span x-text="currentTime" class="font-bold tabular-nums">--:--:-- WIB</span>
                    <button type="button" 
                            wire:click="loadData"
                            class="p-0.5 text-slate-400 hover:text-[#AE0C00] transition cursor-pointer active:rotate-180 duration-300" 
                            title="Segarkan Data Real-Time (Terakhir: {{ $lastSyncTime }})">
                        <svg class="w-3.5 h-3.5" wire:loading.class="animate-spin text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>

                <!-- 2. Tombol Kotak Pesan (Inbox / Log Pesan Operasional Real-Time) -->
                <div class="relative">
                    <button type="button" 
                            @click="openInbox = !openInbox; openNotif = false; openProfile = false" 
                            @click.outside="openInbox = false"
                            class="relative w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition focus:outline-none cursor-pointer border border-slate-200/80 shadow-2xs group" 
                            :class="openInbox && 'bg-slate-100 text-slate-900 border-slate-300'"
                            title="Log Pesan & Aktivitas Data">
                        <!-- Ikon Amplop Kotak Pesan Tegas & Simetris -->
                        <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-slate-800 transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </button>

                    <!-- Dropdown Panel Log Pesan & Aktivitas Data (Real-Time Anti-Slop) -->
                    <div x-show="openInbox" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                         class="absolute right-0 mt-2 w-80 sm:w-92 rounded-2xl bg-white border border-slate-200/90 shadow-2xl z-50 overflow-hidden divide-y divide-slate-100"
                         x-cloak>
                        
                        <!-- Header Log Pesan -->
                        <div class="px-4 py-3 bg-slate-50/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-headline font-bold text-xs text-slate-900">Log Pesan & Aktivitas Data</span>
                            </div>
                            <button type="button" 
                                    wire:click="markInboxAsRead"
                                    class="text-[10.5px] font-headline font-semibold text-slate-500 hover:text-[#AE0C00] transition cursor-pointer">
                                Tandai Dibaca
                            </button>
                        </div>

                        <!-- Daftar Log Aktivitas Nyata dari Database -->
                        <div class="max-h-76 overflow-y-auto divide-y divide-slate-100">
                            @forelse($inboxItems as $item)
                                @php
                                    $isUnread = !in_array($item['id'], $readInboxIds);
                                @endphp
                                <div wire:click="openInboxItem('{{ $item['id'] }}', '{{ $item['link'] }}')"
                                     class="p-3.5 flex items-start gap-3 hover:bg-slate-50/90 transition cursor-pointer group {{ $isUnread ? 'bg-red-50/20' : '' }}">
                                    
                                    <!-- Ikon Aksi Relevan -->
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 mt-0.5 border {{ $item['type'] === 'create' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($item['type'] === 'gpon' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-slate-100 text-slate-700 border-slate-200/90') }}">
                                        @if($item['type'] === 'create')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        @elseif($item['type'] === 'gpon')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-headline font-bold text-slate-800 group-hover:text-[#AE0C00] transition-colors truncate">
                                                {{ $item['title'] }}: <span class="font-mono text-slate-900">{{ $item['subject'] }}</span>
                                            </p>
                                            <span class="text-[9.5px] font-mono text-slate-400 shrink-0">{{ $item['time_ago'] }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug line-clamp-2">{{ $item['detail'] }}</p>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="text-[9.5px] font-mono text-slate-600 bg-slate-100 px-1.5 py-0.2 rounded border border-slate-200/60">{{ $item['actor'] }}</span>
                                            @if($isUnread)
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#AE0C00]"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <!-- Status Kosong yang Jujur (Honest Empty State) -->
                                <div class="py-8 px-4 text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-1.789 1.106l-.422.844A2 2 0 0112 18a2 2 0 01-1.789-1.05l-.422-.844A2 2 0 008 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-headline font-bold text-slate-700">Tidak Ada Log Baru</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 leading-snug">Semua riwayat perubahan data Valins & GPON telah ditandai dibaca.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer Dropdown Kotak Pesan -->
                        <div class="p-2.5 bg-slate-50/70 flex items-center justify-between px-4 text-[11px] font-headline font-bold">
                            <a href="{{ route('valins.index') }}" class="text-slate-600 hover:text-[#AE0C00] transition inline-flex items-center gap-1">
                                <span>Tabel Utama Valins</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="{{ route('contact.us') }}" class="text-slate-400 hover:text-slate-700 transition">
                                Bantuan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Tombol Lonceng Notifikasi (Peringatan Deviasi Data-Driven Real-Time) -->
                <div class="relative">
                    <button type="button" 
                            @click="openNotif = !openNotif; openInbox = false; openProfile = false" 
                            @click.outside="openNotif = false"
                            class="relative w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition focus:outline-none cursor-pointer border border-slate-200/80 shadow-2xs" 
                            :class="openNotif && 'bg-slate-100 text-slate-900 border-slate-300'"
                            title="Notifikasi & Peringatan Deviasi">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <!-- Titik Indikator Merah Notifikasi Aktif -->
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#AE0C00] ring-2 ring-white"></span>
                        @endif
                    </button>

                    <!-- Dropdown Panel Peringatan Sistem (Data-Driven Alerts) -->
                    <div x-show="openNotif" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                         class="absolute right-0 mt-2 w-80 sm:w-92 rounded-2xl bg-white border border-slate-200/90 shadow-2xl z-50 overflow-hidden divide-y divide-slate-100"
                         x-cloak>
                        
                        <!-- Header Peringatan Sistem -->
                        <div class="px-4 py-3 bg-slate-50/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-headline font-bold text-xs text-slate-900">Notifikasi & Peringatan Deviasi</span>
                            </div>
                            <button type="button" 
                                    wire:click="markAllNotifAsRead"
                                    class="text-[10.5px] font-headline font-semibold text-slate-500 hover:text-[#AE0C00] transition cursor-pointer">
                                Tandai Dibaca
                            </button>
                        </div>

                        <!-- Daftar Item Notifikasi Nyata (Data-Driven) -->
                        <div class="max-h-76 overflow-y-auto divide-y divide-slate-100">
                            @forelse($notifItems as $alert)
                                @php
                                    $isUnreadAlert = !in_array($alert['id'], $readNotifIds);
                                @endphp
                                <div wire:click="openNotifItem('{{ $alert['id'] }}', '{{ $alert['link'] }}')"
                                     class="p-3.5 flex items-start gap-3 hover:bg-slate-50/90 transition group cursor-pointer {{ $isUnreadAlert ? 'bg-amber-50/20' : '' }}">
                                    
                                    <!-- Ikon Notifikasi Sesuai Level Kritis / Waspada / Normal -->
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 mt-0.5 border {{ $alert['is_critical'] ? 'bg-red-50 text-[#AE0C00] border-red-200' : ($alert['type'] === 'gpon_telemetry' ? 'bg-sky-50 text-sky-600 border-sky-200' : 'bg-amber-50 text-amber-600 border-amber-200') }}">
                                        @if($alert['type'] === 'gpon_telemetry')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-headline font-bold text-slate-800 group-hover:text-[#AE0C00] transition-colors truncate">
                                                {{ $alert['title'] }}
                                            </p>
                                            <span class="text-[9.5px] font-mono px-1.5 py-0.2 rounded border shrink-0 {{ $alert['is_critical'] ? 'text-red-700 bg-red-50 border-red-200' : ($alert['type'] === 'gpon_telemetry' ? 'text-sky-700 bg-sky-50 border-sky-200' : 'text-amber-700 bg-amber-50 border-amber-200') }}">
                                                {{ $alert['badge'] }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug line-clamp-2">{{ $alert['detail'] }}</p>
                                        <div class="flex items-center justify-between mt-1 text-[9.5px] font-mono text-slate-400">
                                            <span>Klik untuk filter & tinjau data</span>
                                            @if($isUnreadAlert)
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#AE0C00]"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <!-- Status Kosong yang Bersih (Honest Empty State) -->
                                <div class="py-8 px-4 text-center">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-xs font-headline font-bold text-slate-700">Semua Peringatan Teratasi</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 leading-snug">Seluruh notifikasi deviasi telah ditandai dibaca.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer Dropdown Peringatan -->
                        <div class="p-2.5 bg-slate-50/60 text-center">
                            <a href="{{ route('dashboard') }}" class="text-[11px] font-headline font-bold text-[#AE0C00] hover:text-red-700 transition inline-flex items-center gap-1">
                                <span>Buka Tabel Antrean Deviasi Lengkap</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Garis Pembatas Vertikal Tipis -->
                <div class="h-6 w-px bg-slate-200/90 hidden sm:block mx-1 shrink-0"></div>

                <!-- 5. Kapsul Area Profil Pengguna (User Profile Capsule & Account Menu) -->
                <div class="relative" 
                     x-data="{ 
                         headerAvatarUrl: @js($avatarUrl),
                         headerInitials: @js($initials)
                     }"
                     @click.outside="openProfile = false"
                     @profile-avatar-updated.window="headerAvatarUrl = $event.detail.avatarUrl">
                    @php
                        // Format ringkas unit kerja (cth: "Regu Daman 03 - Jalur Feeder Lingkar Selatan" -> "Regu Daman 03 • Lingkar Selatan")
                        $compactRole = preg_replace('/\s*-\s*(?:Jalur\s+Feeder\s+)?/i', ' • ', $userRole);
                    @endphp
                    <button type="button" 
                            @click="openProfile = !openProfile; openInbox = false; openNotif = false" 
                            class="inline-flex items-center gap-1.5 sm:gap-2.5 p-1 sm:pl-1.5 sm:pr-2.5 py-1 rounded-xl bg-transparent hover:bg-slate-100 active:bg-slate-100/90 transition-all duration-150 border border-transparent hover:border-slate-200/80 text-left select-none cursor-pointer focus:outline-none shrink-0"
                            :class="openProfile && 'bg-slate-100 border-slate-200/90 shadow-2xs'"
                            title="Menu Akun &amp; Profil"
                            aria-label="Menu Akun dan Profil Pengguna"
                            :aria-expanded="openProfile ? 'true' : 'false'">
                        <!-- Avatar Inisial Merah Korporat Solid (#AE0C00) / Foto Profil Proporsional -->
                        <div class="w-8 h-8 rounded-full overflow-hidden bg-[#AE0C00] text-white flex items-center justify-center font-bold text-xs shadow-2xs shrink-0 font-headline relative border border-white ring-1 ring-slate-200/60">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" 
                                     alt="{{ $userName }}" 
                                     class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300"
                                     x-show="headerAvatarUrl"
                                     :src="headerAvatarUrl || '{{ $avatarUrl }}'"
                                     x-on:error="headerAvatarUrl = null">
                            @else
                                <template x-if="headerAvatarUrl">
                                    <img :src="headerAvatarUrl" 
                                         alt="{{ $userName }}" 
                                         x-on:error="headerAvatarUrl = null"
                                         class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300">
                                </template>
                            @endif
                            <span x-show="!headerAvatarUrl" class="w-full h-full flex items-center justify-center text-white font-bold text-xs select-none uppercase font-headline" style="{{ $avatarUrl ? 'display: none;' : 'display: flex;' }}" x-text="headerInitials">
                                {{ $initials }}
                            </span>
                        </div>
                        
                        <!-- Informasi Identitas: Nama Pengguna Arang Gelap & Unit Kerja Proporsional (Desktop) -->
                        <div class="hidden sm:flex flex-col text-left min-w-0 max-w-[170px] lg:max-w-[210px]">
                            <span class="text-xs font-headline font-bold text-slate-900 leading-tight truncate">{{ $userName }}</span>
                            <span class="text-[10px] font-mono text-slate-500 leading-tight truncate font-medium mt-0.5" title="{{ $userRole }}">{{ $compactRole }}</span>
                        </div>

                        <!-- Ikon Penunjuk (Chevron-down Berputar Halus 180 Derajat di Mobile & Desktop) -->
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 transform" 
                             :class="openProfile ? 'rotate-180 text-slate-700' : 'text-slate-400'" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu Profil Pengguna (Melayang Bebas di Lapisan Terdepan) -->
                    <div x-show="openProfile" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                         class="absolute right-0 top-full mt-2 w-72 max-w-[calc(100vw-1.5rem)] rounded-2xl bg-white border border-slate-200/90 shadow-2xl py-1 z-[100] divide-y divide-slate-100 select-none overflow-hidden"
                         x-cloak>
                        
                        <!-- Bagian Kepala Menu: Ringkasan Identitas Pengguna -->
                        <div class="px-4 py-3 bg-slate-50/80 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full overflow-hidden bg-[#AE0C00] text-white flex items-center justify-center font-bold text-xs shadow-2xs shrink-0 font-headline relative border border-white ring-1 ring-slate-200/60">
                                @if($avatarUrl)
                                    <img src="{{ $avatarUrl }}" 
                                         alt="{{ $userName }}" 
                                         class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300"
                                         x-show="headerAvatarUrl"
                                         :src="headerAvatarUrl || '{{ $avatarUrl }}'"
                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';"
                                         x-on:error="headerAvatarUrl = null">
                                @else
                                    <template x-if="headerAvatarUrl">
                                        <img :src="headerAvatarUrl" 
                                             alt="{{ $userName }}" 
                                             x-on:error="headerAvatarUrl = null"
                                             class="w-full h-full object-cover object-center absolute inset-0 transition-opacity duration-300">
                                    </template>
                                @endif
                                <span x-show="!headerAvatarUrl" class="w-full h-full flex items-center justify-center text-white font-bold text-xs select-none uppercase font-headline" style="{{ $avatarUrl ? 'display: none;' : 'display: flex;' }}" x-text="headerInitials">
                                    {{ $initials }}
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-headline font-bold text-slate-900 leading-snug truncate">{{ $userName }}</p>
                                <p class="text-[10px] font-mono text-slate-500 leading-tight truncate mt-0.5" title="{{ $userRole }}">{{ $compactRole }}</p>
                                <span class="inline-block mt-1 px-1.5 py-0.2 rounded text-[9px] font-bold tracking-wider uppercase bg-red-100/70 text-[#AE0C00] font-mono">
                                    {{ $userRole }}
                                </span>
                            </div>
                        </div>

                        <!-- Daftar Opsi Menu Navigasi Akun -->
                        <div class="py-1">
                            <!-- Opsi 1: Pengaturan Akun & Profil -->
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-headline font-semibold text-slate-700 hover:text-slate-900 hover:bg-red-50/60 transition group">
                                <div class="w-6.5 h-6.5 rounded-lg bg-red-50 text-[#AE0C00] flex items-center justify-center shrink-0 border border-red-100/60 group-hover:bg-[#AE0C00] group-hover:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                </div>
                                <span class="truncate">Pengaturan Akun &amp; Profil</span>
                            </a>

                            <!-- Opsi 2: Lihat Beranda Utama (Navigasi Cepat ke Halaman Landing Page / Beranda) -->
                            <a href="{{ route('home') }}" 
                               class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-headline font-semibold text-slate-700 hover:text-slate-900 hover:bg-red-50/60 transition group">
                                <div class="w-6.5 h-6.5 rounded-lg bg-red-50 text-[#AE0C00] flex items-center justify-center shrink-0 border border-red-100/60 group-hover:bg-[#AE0C00] group-hover:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                    </svg>
                                </div>
                                <span class="truncate">Lihat Beranda Utama</span>
                            </a>
                        </div>

                        <!-- Opsi Keluar: Keluar Sistem (Logout) -->
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-headline font-semibold text-red-600 hover:bg-red-50 hover:text-red-700 transition cursor-pointer text-left group">
                                    <div class="w-6.5 h-6.5 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0 border border-red-100/60 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                        </svg>
                                    </div>
                                    <span>Keluar Sistem</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Bilah Input Pencarian Cepat Mobile (Expand saat tombol kaca pembesar diklik di mobile) -->
        <div x-show="mobileSearchOpen" 
             x-transition 
             class="md:hidden pb-3 pt-1 border-t border-slate-100" 
             x-cloak>
            <form action="{{ route('valins.index') }}" method="GET" class="w-full relative">
                <input type="text" 
                       name="search"
                       placeholder="Cari ODP, Valins, atau Node..." 
                       class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-100 focus:bg-white border border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none transition text-slate-800 shadow-2xs font-sans">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>
    </div>
</header>
