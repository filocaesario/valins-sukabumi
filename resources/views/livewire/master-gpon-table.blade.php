<div @open-modal-tambah.window="$wire.openModalTambah()">
    <style>
        /* Modern Minimalist Floating Scrollbar untuk Slot GPON (Bebas Panah Segitiga Native) */
        .slot-port-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .slot-port-scrollbar::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .slot-port-scrollbar::-webkit-scrollbar-track {
            background: transparent !important;
        }
        .slot-port-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(203, 213, 225, 0.6);
            border-radius: 9999px;
        }
        .slot-port-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(148, 163, 184, 0.85);
        }
        .slot-port-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(203, 213, 225, 0.6) transparent;
        }
    </style>

    <!-- Notifikasi Sukses Melayang -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-5 right-5 z-50 bg-emerald-600 text-white px-5 py-2.5 rounded-xl shadow-lg flex items-center gap-2.5 text-xs font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- HEADER NAVIGASI: TAB STO (ZERO NATIVE SCROLLBAR & KORPORAT RED) -->
    <div class="mb-5 space-y-2.5">
        <!-- Label Kategori STO & Total Badge -->
        <div class="flex items-center justify-between gap-3 h-6">
            <div class="flex items-center gap-2">
                <span class="text-xs font-headline font-semibold text-slate-600 tracking-wider uppercase">Kategori STO:</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200/80">
                    {{ count($stos) }} STO
                </span>
            </div>
        </div>

        <!-- Daftar Tab STO dengan Zero Native Scrollbar & Tombol Geser Halus -->
        <div x-data="{
                canScrollLeft: false,
                canScrollRight: false,
                checkScroll() {
                    const el = this.$refs.tabContainer;
                    if (!el) return;
                    this.canScrollLeft = el.scrollLeft > 4;
                    this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 4);
                },
                scrollLeft() {
                    this.$refs.tabContainer.scrollBy({ left: -220, behavior: 'smooth' });
                },
                scrollRight() {
                    this.$refs.tabContainer.scrollBy({ left: 220, behavior: 'smooth' });
                }
             }"
             x-init="$nextTick(() => checkScroll())"
             @resize.window="checkScroll()"
             class="relative group">
            
            <!-- Tombol Panah Geser Kiri -->
            <button type="button" 
                    x-show="canScrollLeft" 
                    x-cloak 
                    @click="scrollLeft()" 
                    class="absolute -left-2 top-1/2 -translate-y-1/2 z-10 w-7 h-7 rounded-full bg-white text-slate-600 hover:text-slate-900 shadow-md border border-slate-200/80 flex items-center justify-center transition-all duration-150 cursor-pointer hover:scale-105"
                    title="Geser ke kiri">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Scroll Container (Scrollbar Hidden Cross-Browser) -->
            <div x-ref="tabContainer"
                 @scroll.passive="checkScroll()"
                 @wheel.passive="$refs.tabContainer.scrollLeft += $event.deltaY; checkScroll()"
                 style="scrollbar-width: none; -ms-overflow-style: none;"
                 class="flex items-center gap-1.5 overflow-x-auto py-1 [&::-webkit-scrollbar]:hidden scroll-smooth select-none">
                @forelse($stos as $sto)
                    <button type="button"
                            wire:key="tab-{{ md5($sto) }}"
                            wire:click="setSto('{{ $sto }}')"
                            wire:loading.attr="disabled"
                            class="h-8.5 px-3.5 inline-flex items-center justify-center text-xs rounded-xl whitespace-nowrap transition-colors duration-150 cursor-pointer focus:outline-hidden disabled:cursor-wait {{ $activeSto === $sto ? 'bg-[#AE0C00] text-white font-bold border border-[#AE0C00] shadow-xs shadow-red-900/20' : 'bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 font-semibold border border-slate-200/90 hover:border-slate-300 shadow-2xs' }}">
                        STO {{ $sto }}
                    </button>
                @empty
                    <span class="text-xs text-slate-400 italic">Belum ada kategori STO.</span>
                @endforelse
            </div>

            <!-- Tombol Panah Geser Kanan -->
            <button type="button" 
                    x-show="canScrollRight" 
                    x-cloak 
                    @click="scrollRight()" 
                    class="absolute -right-2 top-1/2 -translate-y-1/2 z-10 w-7 h-7 rounded-full bg-white text-slate-600 hover:text-slate-900 shadow-md border border-slate-200/80 flex items-center justify-center transition-all duration-150 cursor-pointer hover:scale-105"
                    title="Geser ke kanan">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

   <!-- PANEL PENCARIAN TERSTRUKTUR (IDENTITAS TELKOM AKSES) -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/90 mb-6 transition-all duration-200">

        <!-- Header Panel Pencarian & Tombol Reset -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#FEF2F2] border border-red-100/80 flex items-center justify-center shrink-0 shadow-2xs">
                    <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-[#0F172A] tracking-tight leading-snug">
                        Filter Pencarian Perangkat
                    </h3>
                    <p class="text-xs text-[#64748B] mt-0.5 font-normal">
                        Saring data berdasarkan parameter simpul jaringan, slot, atau port OLT.
                    </p>
                </div>
            </div>

            <!-- Tombol Reset Filter -->
            @if($hasSearch)
                <button type="button"
                        wire:click="resetSearch"
                        class="group inline-flex items-center gap-1.5 h-8 px-3.5 bg-white text-slate-800 hover:text-[#AE0C00] border border-slate-200 hover:border-red-200 hover:bg-red-50/50 rounded-xl text-xs font-semibold transition-all duration-150 shadow-xs active:scale-[0.98] cursor-pointer"
                        title="Reset semua filter pencarian">
                    <svg class="w-3.5 h-3.5 text-[#AE0C00] transition-transform duration-300 group-hover:-rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Filter</span>
                </button>
            @else
                <button type="button"
                        disabled
                        class="inline-flex items-center gap-1.5 h-8 px-3.5 bg-slate-50/60 text-slate-400 border border-slate-200/60 rounded-xl text-xs font-medium cursor-not-allowed select-none opacity-60"
                        title="Filter belum aktif">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <!-- Grid Input Parameter Jaringan (3 Kolom Proporsional) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- 1. Input Node ID / IP -->
            <div class="relative">
                <label class="block text-xs font-semibold text-[#334155] mb-1.5">
                    Node ID / Node IP
                </label>
                <div class="relative group">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-focus-within:text-[#AE0C00] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>

                    <input type="text"
                           wire:model.live.debounce.300ms="searchNode"
                           placeholder="Ketik nama Node atau IP (cth: GPON01 / 172.28...)"
                           class="w-full bg-white border border-slate-200/90 h-10 pl-10 pr-9 rounded-xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 transition-all shadow-2xs">

                    @if($searchNode)
                        <button type="button"
                                wire:click="$set('searchNode', '')"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#AE0C00] p-1 rounded-md hover:bg-red-50 transition-colors"
                                title="Hapus filter Node">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- 2. Input Slot OLT -->
            <div class="relative">
                <label class="block text-xs font-semibold text-[#334155] mb-1.5">
                    Slot OLT
                </label>
                <div class="relative group">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-focus-within:text-[#AE0C00] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v3H4V6zm0 5h16v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7zm4 4h3m-3-2h1" />
                        </svg>
                    </div>

                    <input type="text"
                           wire:model.live.debounce.300ms="searchSlot"
                           placeholder="Contoh: 8 atau SLOT 8"
                           class="w-full bg-white border border-slate-200/90 h-10 pl-10 pr-9 rounded-xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 transition-all shadow-2xs">

                    @if($searchSlot)
                        <button type="button"
                                wire:click="$set('searchSlot', '')"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#AE0C00] p-1 rounded-md hover:bg-red-50 transition-colors"
                                title="Hapus filter Slot">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- 3. Input Port OLT -->
            <div class="relative">
                <label class="block text-xs font-semibold text-[#334155] mb-1.5">
                    Port OLT
                </label>
                <div class="relative group">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-focus-within:text-[#AE0C00] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2zm3 5h4v4h-4v-4z" />
                        </svg>
                    </div>

                    <input type="text"
                           wire:model.live.debounce.300ms="searchPort"
                           placeholder="Contoh: 5 atau 12"
                           class="w-full bg-white border border-slate-200/90 h-10 pl-10 pr-9 rounded-xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 transition-all shadow-2xs">

                    @if($searchPort)
                        <button type="button"
                                wire:click="$set('searchPort', '')"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#AE0C00] p-1 rounded-md hover:bg-red-50 transition-colors"
                                title="Hapus filter Port">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Indikator Status Pencarian Global Aktif (Hanya muncul jika tidak berada di tab STO) -->
        @if($hasSearch && empty($activeSto))
            <div class="mt-4 text-xs font-medium bg-red-50/70 border border-red-200/70 py-2 px-3.5 rounded-xl flex items-center gap-2.5">
                <span class="text-slate-700">Mode Pencarian Global Aktif: <span class="text-[#AE0C00] font-semibold">Menampilkan hasil penyaringan parameter perangkat di seluruh STO.</span></span>
            </div>
        @endif
    </div>

    <!-- SKELETON CARDS: Penggantian In-Place Presisi 1:1 Saat Berpindah STO, Berpindah Halaman, atau Menyaring Data -->
    <div wire:loading.class.remove="hidden" 
         wire:target="setSto, searchNode, searchSlot, searchPort, resetSearch, gotoPage, previousPage, nextPage" 
         class="hidden space-y-8 animate-pulse">
        @for ($s = 0; $s < 2; $s++)
            <div wire:key="gpon-skeleton-card-{{ $s }}" class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden border-l-4 border-l-[#AE0C00]/40">
                <!-- Top Card Header Skeleton (3 Kolom Identik 1:1) -->
                <div class="bg-white p-4 sm:p-5 border-b border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                        
                        <!-- Kolom 1: Parameter Node ID & IP Address Skeleton -->
                        <div class="flex flex-col justify-center">
                            <div class="h-3 w-32 rounded bg-slate-200/70 mb-2.5"></div>
                            <div class="flex items-center gap-3">
                                <!-- Wadah Ikon Squircle Skeleton -->
                                <div class="w-10 h-10 rounded-xl bg-red-50/70 border border-red-200/50 flex items-center justify-center shrink-0">
                                    <div class="w-5 h-5 rounded-md bg-red-200/60"></div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <!-- Baris Node ID Skeleton -->
                                    <div class="h-5 sm:h-6 w-44 rounded-md bg-slate-200/90"></div>
                                    <!-- Baris IP Address Skeleton -->
                                    <div class="mt-2 h-5 w-28 rounded-lg bg-slate-100 border border-slate-200/70"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2: ID Logical Device Skeleton -->
                        <div class="pt-3 md:pt-0 md:pl-6 flex flex-col justify-center">
                            <div class="h-3 w-28 rounded bg-slate-200/70 mb-2.5"></div>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200/70 flex items-center justify-center shrink-0">
                                    <div class="w-4 h-4 rounded bg-slate-200/80"></div>
                                </div>
                                <div class="h-5 sm:h-6 w-36 rounded-md bg-slate-200/90"></div>
                            </div>
                        </div>

                        <!-- Kolom 3: Type GPON Skeleton -->
                        <div class="pt-3 md:pt-0 md:pl-6 flex flex-col justify-center">
                            <div class="h-3 w-20 rounded bg-slate-200/70 mb-2.5"></div>
                            <div>
                                <div class="h-7.5 w-32 rounded-xl bg-red-50/80 border border-red-200/60"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Kontainer Daftar Slot Cards Horizontal Skeleton -->
                <div class="p-4 bg-slate-50/70 flex gap-5 overflow-x-hidden">
                    @for ($slot = 1; $slot <= 3; $slot++)
                        <div class="min-w-[350px] sm:min-w-[370px] max-w-[400px] bg-white border border-slate-200/90 rounded-xl shadow-2xs shrink-0 overflow-hidden flex flex-col">
                            <!-- Slot Header Skeleton -->
                            <div class="bg-slate-100 py-2.5 px-4 border-b border-slate-200/90 flex justify-between items-center">
                                <div class="h-4 w-16 rounded bg-slate-200/90"></div>
                                <div class="h-5 w-16 rounded-full bg-white border border-slate-200/80"></div>
                            </div>

                            <!-- Baris Data Port Skeleton (Tinggi 44px Kalibrasi 1:1) -->
                            <ul class="divide-y divide-slate-100">
                                @for ($p = 1; $p <= 6; $p++)
                                    <li class="h-[44px] min-h-[44px] max-h-[44px] flex items-center px-4 justify-between">
                                        <!-- Teks Port Skeleton (Tanpa Ikon Kiri Sesuai Standar Baru) -->
                                        <div class="h-3.5 {{ $p % 2 == 0 ? 'w-56' : 'w-48' }} rounded bg-slate-200/80"></div>
                                        <!-- Placeholder Halus Tombol Aksi Kanan -->
                                        <div class="flex items-center gap-1.5 opacity-30">
                                            <div class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200/60"></div>
                                            <div class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200/60"></div>
                                        </div>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

    <!-- TAMPILAN KARTU DATA REAL: Disembunyikan Saat Status Memuat Berlangsung -->
    <div wire:loading.class="hidden" 
         wire:target="setSto, searchNode, searchSlot, searchPort, resetSearch, gotoPage, previousPage, nextPage" 
         class="space-y-8">
        @forelse ($data as $nodeId => $ports)
            @php
                $firstSlot = $ports->first();
                $info = $firstSlot->first();
            @endphp

            <div wire:key="olt-{{ md5($nodeId) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200/90 overflow-hidden transition-all duration-200 border-l-4 border-l-[#AE0C00]">
                <!-- Top Card: Header Ringkasan Perangkat OLT (Tema Korporat Telkom Akses 3 Kolom) -->
                <div class="bg-white p-4 sm:p-5 border-b border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                        
                        <!-- Kolom 1: Parameter Node ID & IP Address (Identitas Utama) -->
                        <div class="flex flex-col justify-center">
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span>Node ID & IP Address</span>
                                @if($hasSearch)
                                    <span class="bg-red-50 text-[#AE0C00] border border-red-200/70 px-2 py-0.5 rounded-full text-[10px] font-extrabold shadow-2xs">
                                        STO {{ $info->sto ?? '-' }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3">
                                <!-- Wadah Ikon Rak Sasis OLT Modular Garis Mikro Merah Korporat (Bebas Ikon Panah/AC) -->
                                <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200/60 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                                    <svg class="w-5 h-5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <!-- Rak Sasis OLT Modular Tingkat 1 (Unit Atas) -->
                                        <rect x="2" y="3.5" width="20" height="7.5" rx="1.5" stroke-width="1.8"/>
                                        <circle cx="6" cy="7.25" r="1" fill="currentColor"/>
                                        <circle cx="9.5" cy="7.25" r="1" fill="currentColor"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.5 7.25h3.5"/>

                                        <!-- Rak Sasis OLT Modular Tingkat 2 (Unit Bawah) -->
                                        <rect x="2" y="13" width="20" height="7.5" rx="1.5" stroke-width="1.8"/>
                                        <circle cx="6" cy="16.75" r="1" fill="currentColor"/>
                                        <circle cx="9.5" cy="16.75" r="1" fill="currentColor"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.5 16.75h3.5"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base sm:text-lg font-headline font-bold text-[#0F172A] tracking-tight leading-tight truncate">
                                        {{ $nodeId }}
                                    </h3>
                                    <!-- Lencana Mikro Kapsul IP Address Terbungkus Tanda Kurung (Statis & Bebas Tombol Salin) -->
                                    @php
                                        $cleanIp = !empty($info->node_ip) && $info->node_ip !== '-' 
                                            ? trim(trim($info->node_ip), '()') 
                                            : null;
                                    @endphp
                                    <div class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-[#F1F5F9] text-slate-800 border border-slate-200/80 text-xs font-mono select-text"
                                         title="Alamat IP Node OLT">
                                        <!-- Ikon Bola Dunia (Globe) Abu-abu Netral Mikro Garis -->
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-3-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-3 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        <!-- Teks Alamat IP Terbungkus Tanda Kurung -->
                                        <span class="font-semibold tracking-tight text-slate-800">
                                            ({{ $cleanIp ?: 'Tanpa IP' }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2: ID Logical Device -->
                        <div class="pt-3 md:pt-0 md:pl-6 flex flex-col justify-center">
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                                ID Logical Device
                            </div>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200/70 text-slate-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                </div>
                                <span class="font-mono text-base sm:text-lg font-bold text-[#1E293B]">
                                    {{ $info->id_logical_device ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Kolom 3: Type GPON (Vendor Perangkat Keras) -->
                        <div class="pt-3 md:pt-0 md:pl-6 flex flex-col justify-center">
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                                Type GPON
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-headline font-bold bg-[#FEF2F2] text-[#AE0C00] border border-red-200/70 shadow-2xs">
                                    <!-- Ikon Chip / Perangkat Keras Mikro Garis -->
                                    <svg class="w-4 h-4 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="5" y="5" width="14" height="14" rx="2" stroke-width="1.8"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 2v3m6-3v3M9 19v3m6-3v3M2 9h3m-3 6h3m14-6h3m-3 6h3M9 9h6v6H9V9z"/>
                                    </svg>
                                    <span>{{ $info->type_gpon ?: 'STANDAR' }}</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-4 bg-slate-50/70 flex gap-5 overflow-x-auto snap-x">
                    @foreach($ports as $slotName => $slotPorts)
                        <div wire:key="slot-{{ md5($nodeId . $slotName) }}" class="min-w-[350px] sm:min-w-[370px] max-w-[400px] bg-white border border-slate-200/90 rounded-xl shadow-2xs shrink-0 snap-start overflow-hidden flex flex-col">
                            <div class="bg-slate-100 text-slate-800 text-center font-headline font-bold py-2.5 border-b border-slate-200/90 flex justify-between items-center px-4">
                                <span>{{ $slotName ?: 'TANPA SLOT' }}</span>
                                <span class="text-xs bg-white text-slate-700 border border-slate-200/90 px-2.5 py-0.5 rounded-full font-bold shadow-2xs">{{ $slotPorts->count() }} Port</span>
                            </div>

                           <ul class="max-h-[500px] overflow-y-auto divide-y divide-slate-100 relative scroll-smooth custom-scrollbar slot-port-scrollbar [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-button]:hidden [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-slate-300/50 hover:[&::-webkit-scrollbar-thumb]:bg-slate-400/80 [&::-webkit-scrollbar-thumb]:rounded-full [scrollbar-width:thin] [scrollbar-color:rgba(203,213,225,0.5)_transparent]"
                                x-data="{}"
                                x-init="$nextTick(() => {
                                    let highlighted = $el.querySelector('.highlight-port');
                                    if(highlighted) {
                                        highlighted.scrollIntoView({behavior: 'smooth', block: 'center'});
                                    }
                                })">

                                @foreach($slotPorts as $port)
                                    @php
                                        $isHighlighted = false;
                                        $dbPort = strtolower(trim($port->port));

                                        if (!empty($searchPort)) {
                                            $val = strtolower(trim($searchPort));

                                            if (is_numeric($val) && strlen($val) <= 3) {
                                                if (preg_match('/[:\-\s]0*' . preg_quote($val, '/') . '$/', $dbPort)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                            else {
                                                // ANTI-RACK: Tambahkan 'rack' dan 'slot' agar diabaikan
                                                $cleanedVal = trim(str_ireplace(['gpon', 'olt', 'port', 'rack', 'slot', '-', ':'], '', $val));
                                                if (strlen($cleanedVal) >= 2 && str_contains($dbPort, $val)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                        }

                                        if (!$isHighlighted && !empty($searchNode)) {
                                            $valNode = strtolower(trim($searchNode));
                                            $nodeLower = strtolower($nodeId);
                                            $ipLower = strtolower($info->node_ip ?? '');

                                            if (!str_contains($nodeLower, $valNode) && !str_contains($ipLower, $valNode)) {
                                                // ANTI-RACK: Tambahkan 'rack' dan 'slot' agar diabaikan
                                                $cleanedValNode = trim(str_ireplace(['gpon', 'olt', 'port', 'rack', 'slot', '-', ':'], '', $valNode));
                                                if (strlen($cleanedValNode) >= 3 && str_contains($dbPort, $valNode)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                        }
                                    @endphp

                                    <li wire:key="port-{{ $port->id }}"
                                        x-data="{ confirmDelete: false, isDeleting: false }"
                                        @click.outside="confirmDelete = false"
                                        class="relative overflow-hidden h-[44px] min-h-[44px] max-h-[44px] flex items-center px-4 transition-colors duration-150 group {{ $isHighlighted ? 'bg-amber-50/80 border-l-4 border-amber-500 highlight-port' : 'hover:bg-slate-50/90' }}">

                                        <!-- Tampilan Normal Port (Luas Tanpa Ikon Kiri, Keterbacaan Penuh Tanpa Elipsis) -->
                                        <div class="flex items-center justify-between w-full h-full min-w-0" x-show="!confirmDelete">
                                            <!-- Identitas Teks Port Utuh & Sejajar (Bebas Kotak Ikon / AI Slop) -->
                                            <div class="flex items-center min-w-0 pr-3">
                                                <span class="font-mono text-xs font-semibold whitespace-nowrap select-all tracking-tight {{ $isHighlighted ? 'text-amber-950 font-extrabold' : 'text-slate-800' }}">
                                                    {{ trim(str_ireplace('[icon]', '', $port->port)) }}
                                                </span>
                                            </div>

                                            <!-- Tombol Aksi Normal: Edit & Hapus (Tanpa Atribut Title Bawaan Browser) -->
                                            <div class="flex items-center gap-1.5 shrink-0 transition-opacity duration-150 {{ $isHighlighted ? 'opacity-100' : 'opacity-0 group-hover:opacity-100 focus-within:opacity-100' }}">
                                                <!-- Tombol Edit Port -->
                                                <button type="button" 
                                                        wire:click="openModalEdit({{ $port->id }})" 
                                                        aria-label="Edit Port"
                                                        class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 bg-white shadow-2xs rounded-lg border border-slate-200/90 transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>
                                                <!-- Tombol Hapus Port (Memicu Lapisan Konfirmasi Inline) -->
                                                <button type="button" 
                                                        @click.stop="confirmDelete = true" 
                                                        aria-label="Hapus Port"
                                                        class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-[#AE0C00] hover:bg-red-50 bg-white shadow-2xs rounded-lg border border-slate-200/90 hover:border-red-200 transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Lapisan Konfirmasi Internal (In-Row Overlay System: Mutlak Terkunci & Zero Overflow) -->
                                        <div x-show="confirmDelete" 
                                             x-cloak
                                             x-transition:enter="transition ease-out duration-150"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease-in duration-100"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="absolute inset-0 z-10 bg-white border border-red-200/90 px-3 flex items-center justify-between gap-1.5 overflow-hidden shadow-2xs">
                                            
                                            <!-- Sisi Kiri: Identitas Port Ringkas + Teks Pertanyaan Tenang (Bebas Titik Berdenyut) -->
                                            <div class="flex items-center gap-1.5 min-w-0 pr-1 flex-1">
                                                @php
                                                    $portRaw = trim($port->port);
                                                    if (preg_match('/(?:GPON_OLT:|PORT[\s:-]?|OLT:?|\:|\-)\s*([0-9]+)$/i', $portRaw, $m)) {
                                                        $compactPortBadge = 'P:' . $m[1];
                                                    } elseif (strlen($portRaw) > 10) {
                                                        $compactPortBadge = '…' . substr($portRaw, -8);
                                                    } else {
                                                        $compactPortBadge = $portRaw;
                                                    }
                                                @endphp
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-red-50 text-[#AE0C00] border border-red-200/70 text-[10px] font-mono font-bold shrink-0">
                                                    {{ $compactPortBadge }}
                                                </span>
                                                <span class="text-[11px] font-headline font-semibold text-slate-700 truncate">
                                                    Hapus port ini?
                                                </span>
                                            </div>

                                            <!-- Sisi Kanan: Tombol Mikro Batal & Konfirmasi Hapus (Sejajar Rapi, Tanpa Ikon Sampah Ganda) -->
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <!-- Tombol Batal -->
                                                <button type="button" 
                                                        @click.stop="confirmDelete = false" 
                                                        :disabled="isDeleting"
                                                        aria-label="Batalkan Hapus"
                                                        class="h-6.5 px-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/90 rounded-md text-[11px] font-headline font-semibold transition-colors duration-150 shadow-2xs cursor-pointer focus:outline-hidden disabled:opacity-50">
                                                    Batal
                                                </button>
                                                <!-- Tombol Konfirmasi Hapus (Merah Korporat Telkom Akses Solid, Bebas Ikon Tempat Sampah Ganda) -->
                                                <button type="button" 
                                                        wire:click="hapusData({{ $port->id }})"
                                                        @click.stop="isDeleting = true" 
                                                        :disabled="isDeleting"
                                                        aria-label="Konfirmasi Hapus Port"
                                                        class="h-6.5 px-2.5 bg-[#AE0C00] hover:bg-[#900A00] active:bg-[#780800] text-white rounded-md text-[11px] font-headline font-bold shadow-2xs transition-colors duration-150 flex items-center justify-center cursor-pointer focus:outline-hidden disabled:opacity-60 disabled:cursor-wait whitespace-nowrap">
                                                    <span wire:loading.remove wire:target="hapusData({{ $port->id }})">
                                                        Konfirmasi Hapus
                                                    </span>
                                                    <span wire:loading wire:target="hapusData({{ $port->id }})" class="flex items-center gap-1">
                                                        <svg class="animate-spin h-3 w-3 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                        <span>Hapus...</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Data Tidak Ditemukan</h3>
                <p class="text-gray-500 text-sm">Pastikan kata kunci pencarian Node, Slot, atau Port telah sesuai.</p>
            </div>
        @endforelse
    </div>

    <!-- Navigasi Pagination & Info Footer Tabel Terstruktur (Identitas Telkom Akses, Selaras Valins Services & Dashboard) -->
    <div class="mt-8 mb-4 pt-2 flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-2">
            <span>
                Menampilkan Halaman <strong class="text-slate-900 font-bold tabular-nums">{{ $paginatedNodes->currentPage() }}</strong> dari <strong class="text-slate-900 font-bold tabular-nums">{{ $paginatedNodes->lastPage() }}</strong>
                @if($hasSearch)
                    <span class="text-slate-400 font-mono">(Hasil Pencarian: {{ number_format($paginatedNodes->total()) }} Node)</span>
                @elseif(!empty($activeSto))
                    <span class="text-slate-400 font-mono">(STO: {{ $activeSto }} • Total {{ number_format($paginatedNodes->total()) }} Node Perangkat)</span>
                @else
                    <span class="text-slate-400 font-mono">(Total {{ number_format($paginatedNodes->total()) }} Node Perangkat)</span>
                @endif
            </span>
        </div>

        <div class="overflow-x-auto max-w-full">
            {{ $paginatedNodes->links('livewire.custom-pagination') }}
        </div>
    </div>

    <!-- MODAL TAMBAH & EDIT DATA (TEMA KORPORAT TELKOM AKSES DENGAN TRANSISI HALUS & GPU ACCELERATION) -->
    <template x-teleport="body">
        <div x-data="{ 
                modalOpen: @entangle('isOpen'),
                closeModal() {
                    this.modalOpen = false;
                    setTimeout(() => {
                        $wire.closeModal();
                    }, 160);
                }
             }"
             x-show="modalOpen"
             @open-modal-tambah-instant.window="modalOpen = true"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog" 
             aria-modal="true"
             @keydown.escape.window="closeModal()">
            
            <!-- Backdrop Transparan Kaca Buram Terang (160ms enter, 130ms leave GPU transition) -->
            <div x-show="modalOpen"
                 x-transition:enter="transition-opacity ease-out duration-[160ms]"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-[130ms]"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/20 backdrop-blur-md"
                 @click="closeModal()"></div>

            <!-- Modal Dialog Container (Centered) -->
            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <!-- Modal Card Box (Hardware-accelerated GPU transform: scale + translate3d + opacity) -->
                <div x-show="modalOpen"
                     x-transition:enter="transition ease-out duration-[160ms] transform-gpu"
                     x-transition:enter-start="opacity-0 scale-[0.98] translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-[130ms] transform-gpu"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-[0.98] translate-y-1"
                     class="relative w-full max-w-3xl my-auto bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-200/90 text-left flex flex-col overflow-hidden will-change-transform">
                    
                    <!-- Header Modal -->
                    <div class="bg-white px-5 sm:px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#AE0C00] border border-red-200/60 flex items-center justify-center shrink-0 shadow-2xs">
                                @if($isEdit)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-slate-900 font-headline font-bold text-base leading-tight">
                                    {{ $isEdit ? 'Perbarui Data Port' : 'Tambah Data Port Baru' }}
                                </h3>
                                <p class="text-slate-500 text-xs mt-0.5">
                                    {{ $isEdit ? 'Sesuaikan parameter konfigurasi perangkat OLT & Port' : 'Lengkapi formulir untuk menambahkan alokasi port OLT' }}
                                </p>
                            </div>
                        </div>
                        <button type="button" 
                                @click="closeModal()" 
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all duration-200 hover:rotate-90 cursor-pointer focus:outline-hidden"
                                title="Tutup Modal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="p-5 sm:p-6 md:p-7 overflow-y-auto max-h-[calc(90vh-140px)]">
                        <form wire:submit.prevent="simpanData">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori STO <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="formSto" placeholder="Contoh: BGL, CBD..." class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-semibold uppercase transition-colors outline-hidden">
                                        @error('formSto') <span class="text-red-500 text-[11px] mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama OLT (Node ID) <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="formNodeId" placeholder="GPON00-D3-BGL-2" class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-semibold uppercase transition-colors outline-hidden">
                                        @error('formNodeId') <span class="text-red-500 text-[11px] mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Node IP (Opsional)</label>
                                        <input type="text" wire:model="formNodeIp" placeholder="172.x.x.x" class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-medium font-mono transition-colors outline-hidden">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Type GPON</label>
                                        <input type="text" wire:model="formTypeGpon" placeholder="HUAWEI / ZTE" class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-semibold uppercase transition-colors outline-hidden">
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">ID Logical Device (Opsional)</label>
                                        <input type="text" wire:model="formLogicalId" placeholder="Misal: 75794" class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-mono font-medium transition-colors outline-hidden">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Slot / Rack <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="formSlot" placeholder="SLOT 1 atau RACK 1 / SLOT 2" class="w-full bg-slate-50/70 border border-slate-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-semibold uppercase transition-colors outline-hidden">
                                        @error('formSlot') <span class="text-red-500 text-[11px] mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="bg-slate-50/80 p-3.5 rounded-xl border border-slate-200/90">
                                        <label class="block text-xs font-bold text-slate-800 mb-1">Detail Port <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="formPort" placeholder="GPON - 85927361271..." class="w-full bg-white border border-slate-300 text-slate-900 rounded-lg focus:ring-2 focus:ring-[#AE0C00]/15 focus:border-[#AE0C00] block p-2.5 text-xs font-mono font-semibold transition-colors outline-hidden">
                                        @error('formPort') <span class="text-red-600 font-bold text-[11px] mt-1.5 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end gap-2.5">
                                <button type="button" 
                                        @click="closeModal()" 
                                        class="h-9 px-4.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200/90 rounded-xl text-xs font-headline font-semibold transition-colors duration-150 shadow-2xs cursor-pointer focus:outline-hidden">
                                    Batal
                                </button>
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        wire:target="simpanData"
                                        class="h-9 px-5 bg-[#AE0C00] hover:bg-[#900A00] active:bg-[#780800] text-white rounded-xl text-xs font-headline font-semibold shadow-xs hover:shadow-sm transition-colors duration-150 flex items-center gap-2 cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:cursor-wait">
                                    <span wire:loading.remove wire:target="simpanData" class="flex items-center gap-2">
                                        <span>Simpan Data</span>
                                    </span>
                                    <span wire:loading wire:target="simpanData" class="flex items-center gap-2">
                                        <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        <span>Menyimpan...</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
