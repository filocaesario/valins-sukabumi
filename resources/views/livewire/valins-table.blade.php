<div class="w-full min-w-0">
    <!-- Toast Notification Melayang -->
    @if (session()->has('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 sm:translate-x-8"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-2 sm:translate-x-8"
             class="fixed top-4 sm:top-6 right-4 sm:right-6 left-4 sm:left-auto sm:max-w-md z-50 bg-white border-l-4 border-green-500 shadow-xl rounded-xl p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4">
            <div class="text-green-500 bg-green-100 p-1 sm:p-1.5 rounded-full shrink-0">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="text-gray-700 font-semibold text-xs sm:text-sm pr-2 flex-1">
                {{ session('success') }}
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 focus:outline-none shrink-0 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             class="fixed top-4 sm:top-6 right-4 sm:right-6 left-4 sm:left-auto sm:max-w-md z-50 bg-white border-l-4 border-red-500 shadow-xl rounded-xl p-3 sm:p-4 flex items-center space-x-3 sm:space-x-4">
            <div class="text-red-500 bg-red-100 p-1 sm:p-1.5 rounded-full shrink-0">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div class="text-gray-700 font-semibold text-xs sm:text-sm pr-2 flex-1">
                {{ session('error') }}
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 focus:outline-none shrink-0 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Widget Statistik Valins Services: 4 Kartu Metrik Selaras Dashboard (Bebas Garis Lengkung Samping) -->
    @php
        $donePercent = $stats['total'] > 0 ? round(($stats['done'] / $stats['total']) * 100, 1) : 0;
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5 sm:mb-6 mt-1 sm:mt-2 w-full">
        <!-- Kartu 1: Total Seluruh Data -->
        <div class="bg-white rounded-xl shadow-2xs border border-slate-200/90 hover:border-slate-300 hover:shadow-xs p-3.5 sm:p-4 flex flex-col justify-between transition-all duration-150 group">
            <div>
                <div class="flex items-start justify-between gap-2">
                    <span class="text-xs font-headline font-bold text-slate-500 tracking-tight leading-snug">Total Seluruh Data</span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-600 shrink-0 shadow-2xs">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    </div>
                </div>
                <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                    {{ number_format($stats['total']) }}
                </div>
            </div>
            <div class="mt-3.5 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                <span class="whitespace-nowrap shrink-0 text-slate-500">Cakupan Rekonsiliasi</span>
                <span class="font-bold text-slate-700 whitespace-nowrap shrink-0">Witel Sukabumi</span>
            </div>
        </div>

        <!-- Kartu 2: Status Lurus (DONE) -->
        <div class="bg-white rounded-xl shadow-2xs border border-slate-200/90 hover:border-slate-300 hover:shadow-xs p-3.5 sm:p-4 flex flex-col justify-between transition-all duration-150 group">
            <div>
                <div class="flex items-start justify-between gap-2">
                    <span class="text-xs font-headline font-bold text-slate-500 tracking-tight leading-snug">Status Lurus (DONE)</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-200/80 flex items-center justify-center text-emerald-600 shrink-0 shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-emerald-600 tracking-tight tabular-nums">
                    {{ number_format($stats['done']) }}
                </div>
                <!-- Bilah Progres Tipis Hijau Zamrud -->
                <div class="mt-2.5 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ min(100, $donePercent) }}%;"></div>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                <span class="whitespace-nowrap shrink-0 text-slate-500">Rasio Kesesuaian</span>
                <span class="font-bold text-emerald-600 tabular-nums whitespace-nowrap shrink-0">{{ $donePercent }}%</span>
            </div>
        </div>

        <!-- Kartu 3: Kendala OTB -->
        <div class="bg-white rounded-xl shadow-2xs border border-slate-200/90 hover:border-slate-300 hover:shadow-xs p-3.5 sm:p-4 flex flex-col justify-between transition-all duration-150 group">
            <div>
                <div class="flex items-start justify-between gap-2">
                    <span class="text-xs font-headline font-bold text-slate-500 tracking-tight leading-snug">Kendala OTB</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 shrink-0 shadow-2xs">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                    {{ number_format($stats['otb']) }}
                </div>
            </div>
            <div class="mt-3.5 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                <span class="whitespace-nowrap shrink-0 text-slate-500">Status Penanganan</span>
                <span class="font-bold text-amber-600 whitespace-nowrap shrink-0">Perlu Tindak Lanjut</span>
            </div>
        </div>

        <!-- Kartu 4: Disconnected -->
        <div class="bg-white rounded-xl shadow-2xs border border-slate-200/90 hover:border-slate-300 hover:shadow-xs p-3.5 sm:p-4 flex flex-col justify-between transition-all duration-150 group">
            <div>
                <div class="flex items-start justify-between gap-2">
                    <span class="text-xs font-headline font-bold text-slate-500 tracking-tight leading-snug">Disconnected</span>
                    <div class="w-8 h-8 rounded-lg bg-red-50 border border-red-200/80 flex items-center justify-center text-[#AE0C00] shrink-0 shadow-2xs">
                        <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1M3 3l18 18"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-[#AE0C00] tracking-tight tabular-nums">
                    {{ number_format($stats['disconnected']) }}
                </div>
            </div>
            <div class="mt-3.5 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                <span class="whitespace-nowrap shrink-0 text-slate-500">Status Layanan</span>
                <span class="font-bold text-[#AE0C00] whitespace-nowrap shrink-0">Non-Aktif / Cabut</span>
            </div>
        </div>
    </div>
    
    <!-- Unified Control Toolbar: Tab Filter Kategori & Kluster Tombol Aksi (Sleek Enterprise Toolbar) -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 sm:gap-4 mb-5 sm:mb-6 min-w-0 w-full">
        <!-- Segmented Tab Nav Container (Scrollable Horizontal & Pill Tabs Bersih) -->
        <div class="min-w-0 flex-1 overflow-x-auto scroll-smooth py-0.5 w-full"
             x-data
             x-init="$nextTick(() => { $el.scrollLeft = 0; })"
             style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="inline-flex items-center h-10 p-1 bg-slate-100/90 border border-slate-200/90 rounded-xl shadow-2xs whitespace-nowrap gap-1">
                @php
                    $resolveTabIcon = function($cat) {
                        $nama = is_object($cat) ? ($cat->nama_kategori ?? '') : (string)$cat;
                        $u = strtoupper(trim($nama));
                        if ($u === 'ODP TIDAK SAMA') return 'odp';
                        if ($u === 'DATEK TIDAK SAMA') return 'datek';
                        if ($u === 'ODP DAN DATEK TIDAK SAMA' || $u === 'ODP & DATEK TIDAK SAMA') return 'odp_datek';
                        if ($u === 'NOT IN SERVICE') return 'nis';
                        if ($u === 'KENDALA ODP') return 'kendala';

                        $rotationPool = ['custom_server', 'custom_chip', 'custom_network', 'custom_table', 'custom_barcode', 'custom_folder', 'custom_tag', 'custom_signal'];
                        $catId = is_object($cat) ? ($cat->id ?? 0) : 0;
                        if ($catId > 0) {
                            return $rotationPool[($catId - 1) % count($rotationPool)];
                        }
                        return $rotationPool[abs(crc32($nama)) % count($rotationPool)];
                    };
                @endphp
                @foreach($categories as $index => $cat)
                    @php
                        $catUpper = strtoupper(trim($cat->nama_kategori));
                        $displayLabel = match($catUpper) {
                            'ODP TIDAK SAMA' => 'ODP Tidak Sama',
                            'DATEK TIDAK SAMA' => 'Datek Tidak Sama',
                            'ODP DAN DATEK TIDAK SAMA', 'ODP & DATEK TIDAK SAMA' => 'ODP & Datek Tidak Sama',
                            'NOT IN SERVICE' => 'Not In Service',
                            'KENDALA ODP' => 'Kendala ODP',
                            default => preg_replace_callback('/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/i', fn($m) => strtoupper($m[0]), ucwords(strtolower($cat->nama_kategori))),
                        };
                        $iconType = $resolveTabIcon($cat);
                        $isActive = ($kategori == $cat->nama_kategori && empty($search));
                    @endphp

                    <button wire:click="setKategori('{{ $cat->nama_kategori }}')" 
                            type="button"
                            class="group h-8 px-3.5 rounded-lg text-xs font-headline inline-flex items-center gap-1.5 whitespace-nowrap select-none transition-all duration-150 cursor-pointer shrink-0 {{ $isActive ? 'bg-white text-[#AE0C00] font-bold shadow-2xs border border-red-200/90 ring-1 ring-red-100/60' : 'text-slate-600 hover:text-slate-900 hover:bg-white/70 font-semibold border border-transparent' }}">
                        
                        {{-- Ikon Garis Kontekstual per Kategori --}}
                        @if($iconType === 'odp')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        @elseif($iconType === 'datek')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        @elseif($iconType === 'odp_datek')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        @elseif($iconType === 'nis')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        @elseif($iconType === 'kendala')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        @elseif($iconType === 'custom_server')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="8" rx="1.5" stroke-width="2"/>
                                <rect x="2" y="14" width="20" height="8" rx="1.5" stroke-width="2"/>
                                <line x1="6" y1="6" x2="6.01" y2="6" stroke-width="2" stroke-linecap="round"/>
                                <line x1="6" y1="18" x2="6.01" y2="18" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        @elseif($iconType === 'custom_chip')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="5" y="5" width="14" height="14" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6v6H9zM9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4"/>
                            </svg>
                        @elseif($iconType === 'custom_network')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="5" r="3" stroke-width="2"/>
                                <circle cx="5" cy="19" r="3" stroke-width="2"/>
                                <circle cx="19" cy="19" r="3" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m-5.5 4L10 13.5m4 0l3.5 2.5"/>
                            </svg>
                        @elseif($iconType === 'custom_table')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                            </svg>
                        @elseif($iconType === 'custom_barcode')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16M8 4v16M11 4v16M16 4v16M20 4v16"/>
                            </svg>
                        @elseif($iconType === 'custom_folder')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                        @elseif($iconType === 'custom_tag')
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 shrink-0 transition-colors {{ $isActive ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.343 9.343a15 15 0 0121.214 0"/>
                            </svg>
                        @endif

                        <span>{{ $displayLabel }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Kluster Tombol Aksi Responsif (Grid 50:50 Simetris Mobile, Flex di Desktop) -->
        <div class="grid grid-cols-2 gap-2 sm:gap-2.5 w-full lg:flex lg:w-auto lg:items-center shrink-0">
            <!-- 1. Tombol Sekunder "Kelola Kategori" (Kolom Kiri 50%) -->
            <button x-data @click="$dispatch('buka-modal-kategori')" 
                    type="button"
                    class="group inline-flex items-center justify-center gap-1.5 sm:gap-2 h-11 sm:h-10 px-2.5 sm:px-3.5 text-xs font-headline font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-slate-300 active:scale-[0.98] rounded-xl transition-all duration-150 shadow-2xs hover:shadow-xs cursor-pointer select-none w-full lg:w-auto whitespace-nowrap">
                <svg class="w-4 h-4 text-slate-500 group-hover:text-slate-700 shrink-0 transition-transform duration-300 group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="truncate">Kelola Kategori</span>
            </button>

            <!-- 2. Tombol Utama "+ Tambah Data Valins" (Kolom Kanan 50%) -->
            <a href="{{ route('valins.create', array_filter(['kategori' => $kategori])) }}" 
               class="inline-flex items-center justify-center gap-1.5 sm:gap-2 h-11 sm:h-10 px-2.5 sm:px-4 text-xs font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] active:scale-[0.98] rounded-xl shadow-2xs hover:shadow-xs transition-all duration-150 select-none w-full lg:w-auto whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="sm:hidden">Tambah Data</span>
                <span class="hidden sm:inline">Tambah Data Valins</span>
            </a>
        </div>
    </div>

    <!-- Modal Kelola Kategori -->
    @livewire('category-manager')

    <!-- Banner Notifikasi Saat Pencarian Aktif -->
    @if(!empty($search))
        <div class="mb-4 px-3.5 sm:px-4 py-2.5 bg-red-50/70 border border-red-200/80 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5 shadow-2xs">
            <div class="flex items-center gap-2 text-xs text-red-900 flex-wrap">
                <span class="leading-relaxed">
                    Pencarian data: 
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-100 text-[#AE0C00] font-bold border border-red-200 break-all">
                        "{{ $search }}"
                    </span>
                    <span class="text-slate-500 font-normal">({{ $data->total() }} ditemukan)</span>
                </span>
            </div>
            
            <button wire:click="$set('search', '')" 
                    type="button"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white hover:bg-red-50 text-[#AE0C00] border border-red-200 rounded-lg text-xs font-semibold shadow-2xs hover:border-red-300 transition-all duration-150 w-full sm:w-auto shrink-0 cursor-pointer">
                <span>Reset Pencarian</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- KARTU UTAMA: PENCARIAN, AKSI & TABEL DATA VALINS -->
    <div class="bg-white rounded-xl border border-slate-200/90 p-4 sm:p-5 space-y-4 shadow-2xs w-full">
        
        <!-- PANEL PENCARIAN & TOMBOL AKSI -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4 pb-1 w-full"
             x-data
             @keydown.window.slash.prevent="if($event.target.tagName !== 'INPUT' && $event.target.tagName !== 'TEXTAREA') { $refs.searchInput.focus(); }"
             @keydown.window.cmd.k.prevent="$refs.searchInput.focus()"
             @keydown.window.ctrl.k.prevent="$refs.searchInput.focus()">
            
            <!-- Search Box -->
            <div class="relative w-full md:w-1/2 lg:w-5/12 group">
                <div wire:loading.class="hidden" wire:target="search" class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 group-focus-within:text-[#AE0C00] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                </div>

                <div wire:loading.flex wire:target="search" class="absolute inset-y-0 left-0 items-center pl-3 hidden">
                    <svg class="animate-spin h-4 w-4 text-[#AE0C00]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <input x-ref="searchInput"
                       type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="{{ $searchPlaceholder ?? 'Cari data...' }}"
                       class="w-full h-9 bg-white text-slate-800 placeholder-slate-400 text-xs pl-9 pr-8 rounded-xl border border-slate-200/90 hover:border-slate-300 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] transition-all duration-150 outline-none shadow-2xs font-sans">

                @if(!empty($search))
                    <button type="button"
                            wire:click="$set('search', '')"
                            title="Bersihkan input"
                            class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                @endif
            </div>

            <!-- Tombol Aksi di Kanan -->
            <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center justify-between md:justify-end w-full md:w-auto gap-2 sm:gap-2.5">
                <!-- Badge Total Data (Tanpa titik hijau, bergaya netral slate enterprise) -->
                <div class="col-span-2 sm:col-span-1 h-9 px-3 rounded-xl border border-slate-200/90 bg-slate-50 shadow-2xs relative overflow-hidden flex items-center justify-center sm:justify-start gap-1.5 text-xs text-slate-600 select-none">
                    <div wire:loading.class="opacity-0" wire:target="search" class="transition-opacity duration-200 text-slate-600 flex items-center gap-1">
                        <span>Total:</span>
                        <strong class="text-slate-800 font-bold">{{ $data->total() }} Data</strong>
                    </div>
                    <div wire:loading.flex wire:target="search" class="absolute inset-0 bg-red-50/80 items-center justify-center text-[#AE0C00] hidden font-bold text-xs">
                        <span class="animate-pulse">Memuat...</span>
                    </div>
                </div>

                <!-- Tombol Import Data (Gaya Korporat Sekunder Bersih, Aksen Merah Korporat & Seragam Tinggi h-9) -->
                <button wire:click="openImportModal" 
                        @click="$dispatch('open-import-modal-instant')"
                        type="button"
                        class="group inline-flex items-center justify-center gap-2 h-9 px-3.5 rounded-xl text-xs font-semibold bg-white hover:bg-[#FEF2F2] active:bg-red-100/70 text-slate-800 hover:text-[#AE0C00] border border-slate-200/90 hover:border-red-300 shadow-2xs hover:shadow-xs transition-colors duration-150 cursor-pointer focus:outline-hidden select-none">
                    <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0 transition-colors duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Import Data</span>
                </button>

                <!-- DROPDOWN EXPORT (EXCEL & PDF) (Latar Putih Bersih, Chevron Berputar & Popover Melayang) -->
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button type="button" 
                            @click="open = !open" 
                            wire:loading.attr="disabled" 
                            wire:target="exportPDF, exportExcel"
                            :class="open 
                                ? 'border-[#AE0C00]/40 ring-1 ring-[#AE0C00]/15 bg-slate-50/80 text-slate-900 shadow-xs' 
                                : 'border-slate-200/90 hover:border-slate-300 bg-white hover:bg-slate-50 text-slate-800 shadow-2xs hover:shadow-xs'"
                            class="w-full inline-flex items-center justify-center gap-2 h-9 px-3.5 text-xs font-semibold rounded-xl border focus:outline-hidden transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer select-none">
                        
                        <!-- Ikon Unduh Garis Mikro -->
                        <svg wire:loading.remove wire:target="exportPDF, exportExcel" class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>

                        <!-- Spinner saat proses ekspor berlangsung -->
                        <svg wire:loading wire:target="exportPDF, exportExcel" class="w-3.5 h-3.5 animate-spin text-[#AE0C00] shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>

                        <span wire:loading.remove wire:target="exportPDF, exportExcel">Export</span>
                        <span wire:loading wire:target="exportPDF">PDF...</span>
                        <span wire:loading wire:target="exportExcel">Excel...</span>

                        <!-- Chevron yang berputar halus 180 derajat -->
                        <svg wire:loading.remove wire:target="exportPDF, exportExcel" 
                             class="w-3 h-3 text-slate-400 transition-transform duration-200 shrink-0" 
                             :class="{ 'rotate-180': open }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Menu Pilihan Dropdown Melayang (Soft Elevation, Radius 14px, Gap Presisi) -->
                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-[160ms] transform-gpu"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-[0.98]"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-[120ms] transform-gpu"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
                         x-cloak
                         class="absolute right-0 z-50 mt-1.5 w-56 rounded-[14px] bg-white shadow-xl shadow-slate-900/10 border border-slate-200/80 p-1.5 flex flex-col gap-1 focus:outline-hidden will-change-transform">
                        
                        <!-- Opsi 1: Export ke Excel -->
                        <button type="button" 
                                wire:click="exportExcel" 
                                @click="open = false" 
                                wire:loading.attr="disabled"
                                class="w-full group flex items-center gap-3 p-2 rounded-xl text-left hover:bg-slate-100/80 transition-colors duration-150 cursor-pointer focus:outline-hidden">
                            <!-- Squircle Hijau Zamrud Lembut (#ECFDF5) dengan ikon spreadsheet hijau tua (#059669) -->
                            <div class="w-8.5 h-8.5 rounded-lg bg-[#ECFDF5] border border-emerald-200/60 flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform duration-150">
                                <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-800 group-hover:text-slate-900 leading-tight">Export ke Excel</span>
                                <span class="block text-[10px] text-slate-500 font-medium leading-normal mt-0.5">Format berkas spreadsheet (.xlsx)</span>
                            </div>
                        </button>

                        <!-- Opsi 2: Export ke PDF -->
                        <button type="button" 
                                wire:click="exportPDF" 
                                @click="open = false" 
                                wire:loading.attr="disabled"
                                class="w-full group flex items-center gap-3 p-2 rounded-xl text-left hover:bg-slate-100/80 transition-colors duration-150 cursor-pointer focus:outline-hidden">
                            <!-- Squircle Merah Muda Lembut (#FEF2F2) dengan ikon dokumen merah korporat (#AE0C00) -->
                            <div class="w-8.5 h-8.5 rounded-lg bg-[#FEF2F2] border border-red-200/60 flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform duration-150">
                                <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-800 group-hover:text-slate-900 leading-tight">Export ke PDF</span>
                                <span class="block text-[10px] text-slate-500 font-medium leading-normal mt-0.5">Laporan data siap cetak (.pdf)</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <!-- SEKSI INTERAKTIF TABEL & TINDAKAN MASSAL (RESPONS ZERO-LAG SELECTION) -->
    <div x-data="{
        selected: @entangle('selectedRows').live,
        openStatus: false,
        confirmDeleteModal: false,
        singleDeleteId: null,
        confirmDeleteSingleModal: false,
        allPageIds: [],
        init() {
            this.syncPageIds();
            this.$watch('selected', () => {
                this.syncPageIds();
            });
        },
        syncPageIds() {
            this.$nextTick(() => {
                this.allPageIds = Array.from(document.querySelectorAll('.row-checkbox:not(:disabled)')).map(el => String(el.value));
            });
        },
        isAllPageSelected() {
            return this.allPageIds.length > 0 && this.allPageIds.every(id => this.selected.map(String).includes(String(id)));
        },
        toggleAll(checked) {
            this.syncPageIds();
            let currentSelected = this.selected.map(String);
            if (checked) {
                this.selected = Array.from(new Set([...currentSelected, ...this.allPageIds]));
            } else {
                this.selected = currentSelected.filter(id => !this.allPageIds.includes(id));
            }
        },
        clearAll() {
            this.selected = [];
            $wire.clearSelection();
        }
    }" 
    @clear-checkboxes.window="selected = []; confirmDeleteModal = false; confirmDeleteSingleModal = false; singleDeleteId = null; $nextTick(() => syncPageIds())"
    class="w-full relative">

        @php
            $tersediaDipilih = $totalSelectable ?? $data->total();
            $sedangDikunciOrangLain = $data->total() - $tersediaDipilih;
        @endphp

        <!-- Bilah Tindakan Massal (Bulk Actions Bar - Tampil Instan 0ms Tanpa Menunggu Server) -->
        <div x-show="selected.length > 0" 
             x-cloak
             x-transition:enter="transition ease-out duration-120 transform"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100 transform"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="relative z-30 mb-3 sm:mb-4 bg-white border border-slate-200/90 rounded-2xl shadow-lg shadow-slate-900/5 p-3 sm:px-4 sm:py-3 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            
            <!-- Sisi Kiri: Indikator Pilihan & Aksi Seleksi Massal -->
            <div class="flex items-center flex-wrap gap-2 sm:gap-2.5 text-xs">
                <!-- Lencana Jumlah Terpilih (Kotak Angka Merah Tegas & Teks Arang di Kapsul Abu-Abu Lembut Bersih) -->
                <div class="inline-flex items-center rounded-xl bg-slate-100 border border-slate-200/80 p-0.5 shadow-2xs overflow-hidden">
                    <span class="px-2.5 py-1 rounded-lg bg-[#AE0C00] text-white font-headline font-extrabold text-xs tracking-tight shadow-xs tabular-nums"
                          x-text="selected.length">
                        {{ count($selectedRows) }}
                    </span>
                    <span class="px-2.5 py-1 text-slate-700 font-headline font-semibold text-xs tracking-tight">
                        Data Dipilih
                    </span>
                </div>

                <!-- Tombol Batalkan Seleksi -->
                <button type="button" 
                        @click="clearAll()" 
                        class="inline-flex items-center gap-1.5 h-8 px-3 rounded-xl bg-slate-100 hover:bg-slate-200/90 text-slate-700 hover:text-slate-900 font-semibold text-xs border border-slate-200/80 shadow-2xs cursor-pointer transition-colors focus:outline-hidden">
                    <svg class="w-3.5 h-3.5 text-slate-500 hover:text-slate-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Batalkan</span>
                </button>

                <!-- Tombol Pilih Seluruh Data di Kategori Ini -->
                @if($tersediaDipilih > 0)
                    <template x-if="selected.length < {{ $tersediaDipilih }}">
                        <div class="inline-flex items-center gap-2">
                            <div class="h-4 w-px bg-slate-200 hidden sm:block mx-0.5"></div>
                            <button type="button" 
                                    wire:click="selectAllMatching" 
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 h-8 px-3 rounded-xl bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 font-semibold text-xs border border-slate-200/90 shadow-2xs cursor-pointer transition-all focus:outline-hidden">
                                <span wire:loading.remove wire:target="selectAllMatching" class="inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span>Pilih Seluruh <strong class="text-slate-900 font-bold">{{ $tersediaDipilih }}</strong> Data di Kategori Ini</span>
                                    @if($sedangDikunciOrangLain > 0)
                                        <span class="text-[11px] text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded font-medium border border-amber-200/70">({{ $sedangDikunciOrangLain }} dikunci)</span>
                                    @endif
                                </span>
                                <span wire:loading wire:target="selectAllMatching" class="inline-flex items-center gap-1.5 text-slate-500">
                                    <svg class="animate-spin w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path>
                                    </svg>
                                    <span>Memilih seluruh data...</span>
                                </span>
                            </button>
                        </div>
                    </template>
                @endif
            </div>

            <!-- Sisi Kanan: Grup Tombol Tindakan Terpadu -->
            <div class="flex items-center flex-wrap gap-2 justify-end">
                <!-- Dropdown Ubah Status Massal -->
                <div class="relative w-full sm:w-auto">
                    <button type="button" 
                            @click="openStatus = !openStatus" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 h-8 px-3 rounded-xl bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 font-semibold text-xs border border-slate-200/90 shadow-2xs cursor-pointer transition-colors focus:outline-hidden">
                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Ubah Status</span>
                        <svg class="w-3 h-3 text-slate-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': openStatus }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Popover Menu Dropdown Status (Bebas Titik Bulat, Ikon Garis Mikro & Title Case) -->
                    <div x-show="openStatus" 
                         @click.outside="openStatus = false" 
                         x-transition:enter="transition ease-out duration-150 transform"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100 transform"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute left-0 sm:left-auto sm:right-0 mt-1.5 w-52 bg-white rounded-xl shadow-xl shadow-slate-900/10 border border-slate-200/90 z-50 overflow-hidden divide-y divide-slate-100">
                        
                        <div class="px-3 py-2 bg-slate-50 border-b border-slate-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Pilih Status Baru</span>
                        </div>

                        <div class="py-1">
                            <!-- Done -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('DONE'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-200/60 group-hover:bg-emerald-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                <span>Done</span>
                            </button>

                            <!-- Done OLO -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('DONE OLO'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-cyan-50 text-cyan-600 border border-cyan-200/60 group-hover:bg-cyan-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                </span>
                                <span>Done OLO</span>
                            </button>

                            <!-- Astinet -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('ASTINET'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-indigo-50 text-indigo-600 border border-indigo-200/60 group-hover:bg-indigo-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </span>
                                <span>Astinet</span>
                            </button>

                            <!-- OTB -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('OTB'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-amber-50 text-amber-600 border border-amber-200/60 group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>
                                        <circle cx="7.5" cy="10" r="1.5" stroke-width="1.5"/>
                                        <circle cx="12" cy="10" r="1.5" stroke-width="1.5"/>
                                        <circle cx="16.5" cy="10" r="1.5" stroke-width="1.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 16h14"/>
                                    </svg>
                                </span>
                                <span>OTB</span>
                            </button>

                            <!-- Disconnected -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('Disconnected'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#AE0C00] font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-red-50 text-[#AE0C00] border border-red-200/60 group-hover:bg-red-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </span>
                                <span>Disconnected</span>
                            </button>
                        </div>

                        <div class="py-1">
                            <!-- Kendala BI -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('KENDALA BI'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-slate-100 text-slate-600 border border-slate-200/70 group-hover:bg-slate-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </span>
                                <span>Kendala BI</span>
                            </button>

                            <!-- Witel Lain -->
                            <button type="button" 
                                    wire:click="bulkChangeStatus('WITEL LAIN'); openStatus = false" 
                                    class="w-full text-left px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold flex items-center gap-2.5 transition-colors cursor-pointer group">
                                <span class="p-1 rounded-md bg-slate-100 text-slate-600 border border-slate-200/70 group-hover:bg-slate-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </span>
                                <span>Witel Lain</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tombol Edit Massal (Instan 0ms Trigger + Background Data Fetch) -->
                <button type="button" 
                        @click="$dispatch('open-bulk-edit-instant'); $wire.openBulkEdit()" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 h-8 px-3 rounded-xl bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 hover:text-slate-900 font-semibold text-xs border border-slate-200/90 shadow-2xs cursor-pointer transition-colors focus:outline-hidden">
                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Edit Massal</span>
                </button>

                <!-- Tombol Hapus (Memicu Modal Konfirmasi Kustom, Tanpa Browser Alert) -->
                <button type="button" 
                        @click="confirmDeleteModal = true" 
                        wire:loading.attr="disabled"
                        wire:target="bulkDelete"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 h-8 px-3.5 rounded-xl bg-[#AE0C00] hover:bg-[#8E0A00] active:bg-[#770800] text-white font-bold text-xs shadow-xs cursor-pointer transition-colors focus:outline-hidden focus:ring-2 focus:ring-red-400 disabled:opacity-60 disabled:cursor-wait">
                    <svg wire:loading.remove wire:target="bulkDelete" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg wire:loading wire:target="bulkDelete" class="animate-spin w-3.5 h-3.5 shrink-0 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="bulkDelete">Hapus</span>
                    <span wire:loading wire:target="bulkDelete">Menghapus...</span>
                </button>
            </div>

            <!-- Modal Konfirmasi Hapus Massal (Custom Light-Themed Modal, Tanpa Browser Alert) -->
            <template x-teleport="body">
                <div x-show="confirmDeleteModal" 
                     x-cloak
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="modal-bulk-delete-title" 
                     role="dialog" 
                     aria-modal="true">
                    <!-- Backdrop Lembut -->
                    <div x-show="confirmDeleteModal"
                         x-transition:enter="ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity"
                         @click="confirmDeleteModal = false"></div>

                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <div x-show="confirmDeleteModal"
                             x-transition:enter="ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200/90">
                            
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-[#AE0C00] border border-red-200/60">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-slate-900" id="modal-bulk-delete-title">
                                            Hapus <span x-text="selected.length"></span> Data Terpilih?
                                        </h3>
                                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                                            Anda akan menghapus <span class="font-bold text-slate-900" x-text="selected.length + ' baris data'"></span> secara permanen dari basis data. Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                                <button type="button" 
                                        @click="confirmDeleteModal = false"
                                        wire:loading.attr="disabled"
                                        wire:target="bulkDelete"
                                        class="px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-100/80 rounded-xl border border-slate-200/80 shadow-2xs transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    Batalkan
                                </button>
                                <button type="button" 
                                        @click="$wire.bulkDelete(selected)" 
                                        wire:loading.attr="disabled"
                                        wire:target="bulkDelete"
                                        class="px-4 py-2 text-xs font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] active:bg-[#770800] rounded-xl shadow-xs transition-colors cursor-pointer inline-flex items-center gap-1.5 disabled:opacity-60 disabled:cursor-wait">
                                    <svg wire:loading.remove wire:target="bulkDelete" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <svg wire:loading wire:target="bulkDelete" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="bulkDelete">Ya, Hapus Permanen</span>
                                    <span wire:loading wire:target="bulkDelete">Menghapus...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Modal Konfirmasi Hapus Baris Tunggal (Custom Light Modal, Tanpa Browser Alert) -->
        <template x-teleport="body">
            <div x-show="confirmDeleteSingleModal" 
                 x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto"
                 aria-labelledby="modal-single-delete-title" 
                 role="dialog" 
                 aria-modal="true">
                <div x-show="confirmDeleteSingleModal"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity"
                     @click="confirmDeleteSingleModal = false"></div>

                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div x-show="confirmDeleteSingleModal"
                         x-transition:enter="ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200/90">
                        
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-[#AE0C00] border border-red-200/60">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-slate-900" id="modal-single-delete-title">
                                        Hapus Baris Data Ini?
                                    </h3>
                                    <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                                        Data rekonsiliasi ini akan dihapus secara permanen dari basis data. Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                            <button type="button" 
                                    @click="confirmDeleteSingleModal = false"
                                    wire:loading.attr="disabled"
                                    wire:target="hapusData"
                                    class="px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-100/80 rounded-xl border border-slate-200/80 shadow-2xs transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                Batalkan
                            </button>
                            <button type="button" 
                                    @click="$wire.hapusData(singleDeleteId)" 
                                    wire:loading.attr="disabled"
                                    wire:target="hapusData"
                                    class="px-4 py-2 text-xs font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] active:bg-[#770800] rounded-xl shadow-xs transition-colors cursor-pointer inline-flex items-center gap-1.5 disabled:opacity-60 disabled:cursor-wait">
                                <svg wire:loading.remove wire:target="hapusData" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <svg wire:loading wire:target="hapusData" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="hapusData">Ya, Hapus Permanen</span>
                                <span wire:loading wire:target="hapusData">Menghapus...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- TABEL UTAMA -->
        <div class="w-full bg-white rounded-xl border border-slate-200/90 overflow-x-auto shadow-2xs" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full min-w-full leading-normal whitespace-nowrap text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-headline font-bold uppercase tracking-wider text-[10px] border-b-2 border-slate-200">
                        <!-- Checkbox Master (Respons Instan 0ms) -->
                        <th class="px-3 sm:px-4 py-3 border-r border-slate-200/90 text-center font-bold w-10 sm:w-12 select-none">
                            <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="flex items-center justify-center">
                                <input type="checkbox" 
                                       id="masterCheckbox"
                                       :checked="isAllPageSelected()"
                                       @change="toggleAll($event.target.checked)" 
                                       class="rounded border-slate-300 text-[#AE0C00] focus:ring-[#AE0C00] cursor-pointer transition-all">
                            </div>
                            <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex items-center justify-center">
                                <div class="w-4 h-4 rounded bg-slate-300/80 animate-pulse"></div>
                            </div>
                    <!-- KOLOM SESUAI SKEMA 1:1 (MODE SKEMA) ATAU STANDAR SISTEM -->
                    @if(($activeColumns['mode'] ?? 'standard') === 'schema')
                        @foreach(($activeColumns['columns'] ?? []) as $col)
                            @php
                                $normK = $col['norm'] ?? strtoupper(preg_replace('/[^A-Z0-9]/', '', $col['nama'] ?? ''));
                                $isColPortOdp = ($col['is_port_odp'] ?? false) || in_array($normK, ['PORTODP', 'PORTOD']);
                                $isColSlotPort = in_array($normK, ['SLOT', 'PORT']);
                                $isColTreg = ($col['is_treg'] ?? false) || in_array($normK, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL']);
                                $thAlign = ($col['align'] ?? 'left');
                                if ($isColPortOdp || $isColSlotPort || $isColTreg) {
                                    $thAlign = 'center';
                                }
                                $colWidthClass = '';
                                if ($isColPortOdp) {
                                    $colWidthClass = 'w-24 min-w-[5.5rem]';
                                } elseif ($isColSlotPort) {
                                    $colWidthClass = 'w-20 min-w-[4.5rem]';
                                } elseif ($isColTreg) {
                                    $colWidthClass = 'w-20 min-w-[4.5rem]';
                                }
                            @endphp
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-{{ $thAlign }} font-bold select-none {{ $colWidthClass }}">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="{{ $thAlign === 'center' ? 'flex items-center justify-center text-center' : '' }}">
                                    {{ $col['label'] }}
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden {{ $thAlign === 'center' ? 'flex justify-center' : '' }} py-0.5">
                                    <div class="h-2.5 w-16 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endforeach
                    @else
                        <!-- KOLOM TERPADU / STANDAR SESUAI SKEMA KATEGORI AKTIF (Hierarki: TREG -> WITEL -> STO) -->
                        @if(!empty($activeColumns['treg']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    TREG
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-12 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['witel']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-left font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    WITEL
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden py-0.5">
                                    <div class="h-2.5 w-16 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['sto']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    STO
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-10 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['odp_name']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-left font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    ODP NAME
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden py-0.5">
                                    <div class="h-2.5 w-16 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['valins_id']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    VALINS ID
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-14 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['node_info']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-left font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    NODE ID & IP
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden py-0.5">
                                    <div class="h-2.5 w-20 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['slot_port']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    SLOT & PORT OLT
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-24 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['onu_sn']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-left font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    ONU SN
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden py-0.5">
                                    <div class="h-2.5 w-14 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['no_inet_valins']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    NO INET VALINS
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-22 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['sip1_valins']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    SIP 1 VALINS
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-18 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['sip2_valins']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    SIP 2 VALINS
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-18 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['sid']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    SID
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-10 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        <!-- KOLOM KUSTOM DINAMIS BERDASARKAN KATEGORI AKTIF -->
                        @foreach(($activeColumns['custom'] ?? []) as $col)
                            @php
                                $normTh = strtoupper(preg_replace('/[^A-Z0-9]/', '', $col['nama'] ?? ''));
                                $isThPortOdp = in_array($normTh, ['PORTODP', 'PORTOD']);
                                $isThCenter = $isThPortOdp || in_array($normTh, ['SLOT', 'PORT', 'TREG', 'STO', 'VALINSID']);
                            @endphp
                            <th class="px-3.5 py-3 border-r border-slate-200/90 {{ $isThCenter ? 'text-center' : 'text-left' }} font-bold select-none {{ $isThPortOdp ? 'w-24 min-w-[5.5rem]' : '' }}">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="{{ $isThCenter ? 'flex justify-center text-center' : '' }}">
                                    {{ $col['label'] }}
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden {{ $isThCenter ? 'flex justify-center' : '' }} py-0.5">
                                    <div class="h-2.5 w-20 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endforeach

                        <!-- KOLOM INFORMASI STATUS & PENANGGUNG JAWAB -->
                        <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                            <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                KETERANGAN
                            </div>
                            <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                <div class="h-2.5 w-20 rounded bg-slate-300/80 animate-pulse"></div>
                            </div>
                        </th>

                        @if(!empty($activeColumns['tanggal']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-center font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    TANGGAL
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                                    <div class="h-2.5 w-16 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif

                        @if(!empty($activeColumns['pic']))
                            <th class="px-3.5 py-3 border-r border-slate-200/90 text-left font-bold select-none">
                                <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                                    PIC
                                </div>
                                <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden py-0.5">
                                    <div class="h-2.5 w-12 rounded bg-slate-300/80 animate-pulse"></div>
                                </div>
                            </th>
                        @endif
                    @endif

                    <!-- KOLOM AKSI (100% SOLID BACKGROUND, PENGAMAN ANTI-TABRAKAN HEADER STICKY) -->
                    <th class="px-3.5 py-3 text-center font-bold sticky right-0 bg-[#f1f5f9] text-slate-700 z-30 select-none">
                        <!-- Garis batas vertikal kiri tegas & bayangan pemisah halus anti-tabrakan saat scroll -->
                        <div class="absolute inset-y-0 left-0 w-0.5 bg-slate-300 pointer-events-none"></div>
                        <div class="absolute inset-y-0 -left-2.5 w-2.5 pointer-events-none bg-gradient-to-l from-slate-900/[0.08] to-transparent"></div>

                        <div wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                            AKSI
                        </div>
                        <div wire:loading.class.remove="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" class="hidden flex justify-center py-0.5">
                            <div class="h-2.5 w-8 rounded bg-slate-300/80 animate-pulse"></div>
                        </div>
                    </th>
                </tr>
            </thead>
            
            <tbody wire:poll.6s class="bg-white">
                <!-- SKELETON ROWS: Tampil Saat Berpindah Kategori, Berpindah Halaman, atau Mencari Data -->
                @for ($i = 0; $i < 10; $i++)
                    <tr wire:key="valins-skeleton-row-{{ $i }}"
                        wire:loading.class.remove="hidden" 
                        wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" 
                        class="hidden skeleton-row animate-pulse h-[53px] min-h-[53px] border-b border-slate-200/80 bg-white">
                        
                        <!-- Checkbox Skeleton -->
                        <td class="px-3 sm:px-4 py-3 text-center align-middle w-10 sm:w-12 border-r border-slate-200/80">
                            <div class="w-4 h-4 rounded bg-slate-200/80 mx-auto"></div>
                        </td>

                        @if(($activeColumns['mode'] ?? 'standard') === 'schema')
                            @foreach(($activeColumns['columns'] ?? []) as $col)
                                <td class="px-3.5 py-3 {{ ($col['align'] ?? 'left') === 'center' ? 'text-center' : '' }} align-middle border-r border-slate-200/80">
                                    <div class="h-3.5 w-20 rounded bg-slate-200/80 {{ ($col['align'] ?? 'left') === 'center' ? 'mx-auto' : '' }}"></div>
                                </td>
                            @endforeach
                        @else
                            @if(!empty($activeColumns['treg']))
                            <!-- TREG Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                <div class="h-4 w-12 rounded-md bg-slate-200/90 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['witel']))
                            <!-- WITEL Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-16 rounded bg-slate-200/90"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['sto']))
                            <!-- STO Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                <div class="h-4 w-9 rounded-md bg-slate-200/90 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['odp_name']))
                            <!-- ODP NAME Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                <div class="flex flex-col gap-1.5 min-w-0">
                                    <div class="h-3.5 w-28 rounded bg-slate-200/90"></div>
                                    <div class="h-4 w-24 rounded bg-slate-200/70"></div>
                                </div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['valins_id']))
                            <!-- VALINS ID Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                <div class="h-4 w-16 rounded bg-slate-200/90 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['node_info']))
                            <!-- NODE ID & IP Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                <div class="flex flex-col gap-1.5 min-w-0">
                                    <div class="h-3.5 w-24 rounded bg-slate-200/90"></div>
                                    <div class="h-3 w-24 rounded bg-slate-200/70"></div>
                                </div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['slot_port']))
                            <!-- SLOT & PORT OLT Skeleton -->
                            <td class="px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                <div class="inline-flex items-center justify-center gap-1.5 px-2 py-1 rounded-lg bg-slate-100 border border-slate-200/70 mx-auto">
                                    <div class="h-3.5 w-10 rounded bg-slate-200/90"></div>
                                    <div class="h-1.5 w-1.5 rounded-full bg-slate-300"></div>
                                    <div class="h-3.5 w-10 rounded bg-slate-200/90"></div>
                                </div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['onu_sn']))
                            <!-- ONU SN Skeleton -->
                            <td class="px-3.5 py-3 align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-24 rounded bg-slate-200/80"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['no_inet_valins']))
                            <!-- NO INET VALINS Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-20 rounded bg-slate-200/80 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['sip1_valins']))
                            <!-- SIP 1 VALINS Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-16 rounded bg-slate-200/70 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['sip2_valins']))
                            <!-- SIP 2 VALINS Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-16 rounded bg-slate-200/70 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['sid']))
                            <!-- SID Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-16 rounded bg-slate-200/70 mx-auto"></div>
                            </td>
                            @endif

                            <!-- Custom Columns Skeleton -->
                            @foreach(($activeColumns['custom'] ?? []) as $col)
                                <td class="px-3.5 py-3 align-middle border-r border-slate-200/80">
                                    <div class="h-3.5 w-20 rounded bg-slate-200/80"></div>
                                </td>
                            @endforeach

                            <!-- KETERANGAN Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-5.5 w-22 rounded-md bg-slate-200/80 mx-auto"></div>
                            </td>

                            @if(!empty($activeColumns['tanggal']))
                            <!-- TANGGAL Skeleton -->
                            <td class="px-3.5 py-3 text-center align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-18 rounded bg-slate-200/80 mx-auto"></div>
                            </td>
                            @endif

                            @if(!empty($activeColumns['pic']))
                            <!-- PIC Skeleton -->
                            <td class="px-3.5 py-3 align-middle border-r border-slate-200/80">
                                <div class="h-3.5 w-16 rounded bg-slate-200/80"></div>
                            </td>
                            @endif
                        @endif

                        <!-- AKSI Skeleton (Sticky Right) -->
                        <td class="px-3.5 py-3 text-center align-middle sticky right-0 bg-white z-20">
                            <!-- Garis batas vertikal kiri tegas & bayangan pemisah halus anti-tabrakan saat scroll -->
                            <div class="absolute inset-y-0 left-0 w-0.5 bg-slate-300 pointer-events-none"></div>
                            <div class="absolute inset-y-0 -left-2.5 w-2.5 pointer-events-none bg-gradient-to-l from-slate-900/[0.08] to-transparent"></div>

                            <div class="flex justify-center items-center gap-1.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-200/80"></div>
                                <div class="w-8 h-8 rounded-lg bg-slate-200/80"></div>
                            </div>
                        </td>
                    </tr>
                @endfor

                <!-- DATA REAL ROWS: Disembunyikan Saat Status Memuat -->
                @forelse ($data as $item)
                @php
                    $currentUser = auth()->check() ? auth()->user()->name : 'System';
                    $lockedByName = explode('|', $item->locked_by ?? '')[0];
                    $namaPendek = explode(' ', $lockedByName)[0];

                    // Kunci dianggap milik orang lain jika namanya berbeda dan tidak kosong
                    $isLockedByOther = !empty($item->locked_by) && $lockedByName !== $currentUser;
                    $isLockedByMe = in_array($item->id, $selectedRows);

                    $dynData = is_array($item->dynamic_data) 
                        ? $item->dynamic_data 
                        : (is_string($item->dynamic_data) ? json_decode($item->dynamic_data, true) : []);
                    if (!is_array($dynData)) $dynData = [];
                @endphp

                <tr wire:key="row-{{ $item->id }}-{{ $item->locked_by ?? 'unlocked' }}-{{ $item->updated_at?->timestamp }}" 
                    wire:loading.class="hidden" 
                    wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters" 
                    :class="{ '!bg-red-50/70': selected.map(String).includes('{{ (string) $item->id }}') }"
                    class="border-b border-slate-200/90 transition-colors {{ $isLockedByMe ? 'bg-red-50/70' : ($isLockedByOther ? 'bg-amber-50/70' : 'hover:bg-slate-50/80') }} group">

                    <!-- Checkbox Baris (Respons Instan 0ms Sisi Klien) -->
                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-center align-middle w-10 sm:w-12 border-r border-slate-200/90">
                        @if($isLockedByOther)
                            <div class="flex items-center justify-center cursor-not-allowed group" title="Sedang diproses oleh {{ $item->locked_by }}">
                                <svg class="w-4 h-4 text-amber-500 opacity-80 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a5 5 0 0 1 5 5v3h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v3h6V7a3 3 0 0 0-3-3z"/></svg>
                            </div>
                        @else
                            <input type="checkbox" 
                                   x-model="selected" 
                                   value="{{ (string) $item->id }}" 
                                   class="row-checkbox rounded border-slate-300 text-[#AE0C00] focus:ring-[#AE0C00] cursor-pointer transition-all">
                        @endif
                    </td>

                    @if(($activeColumns['mode'] ?? 'standard') === 'schema')
                        <!-- RENDER 1:1 KOLOM SKEMA SESUAI BERKAS ASLI -->
                        @foreach(($activeColumns['columns'] ?? []) as $col)
                            @php
                                $colKey = $col['nama'];
                                $normKey = $col['norm'];
                                $cellVal = null;
                                $foundInDyn = false;

                                // 1. Cari di dynamic_data (nama persis atau normalized)
                                if (array_key_exists($colKey, $dynData)) {
                                    $cellVal = $dynData[$colKey];
                                    $foundInDyn = true;
                                } else {
                                    foreach ($dynData as $dk => $dv) {
                                        if (preg_replace('/[^A-Z0-9]/', '', strtoupper((string)$dk)) === $normKey) {
                                            $cellVal = $dv;
                                            $foundInDyn = true;
                                            break;
                                        }
                                    }
                                }

                                // 2. Fallback ke atribut model langsung HANYA jika kolom TIDAK ada sama sekali di berkas
                                if (!$foundInDyn && ($cellVal === null || $cellVal === '')) {
                                    if ($normKey === 'KETERANGAN' || $normKey === 'STATUS' || $normKey === 'KETERANGANSTATUS') {
                                        $cellVal = $item->keterangan ?? null;
                                    } elseif ($normKey === 'TANGGAL' || $normKey === 'DATE') {
                                        $cellVal = ($item->tanggal && \Carbon\Carbon::parse($item->tanggal)->year > 1971)
                                            ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y')
                                            : null;
                                    } elseif ($normKey === 'PIC' || $normKey === 'PETUGAS' || $normKey === 'USER') {
                                        $cellVal = $item->pic ?? null;
                                    } elseif ($normKey === 'STO') {
                                        $cellVal = $item->sto ?? null;
                                    } elseif ($normKey === 'ODPNAME' || $normKey === 'ODPLOCATION') {
                                        $cellVal = $item->odp_name ?? null;
                                    } elseif ($normKey === 'VALINSID') {
                                        $cellVal = $item->valins_id ?? null;
                                    } elseif ($normKey === 'NODEID') {
                                        $cellVal = $item->node_id ?? null;
                                    } elseif ($normKey === 'NODEIP') {
                                        $cellVal = $item->node_ip ?? null;
                                    } elseif ($normKey === 'SLOT') {
                                        $cellVal = $item->slot ?? null;
                                    } elseif ($normKey === 'PORT') {
                                        $cellVal = $item->port ?? null;
                                    } elseif ($normKey === 'ONUSN') {
                                        $cellVal = $item->onu_sn ?? null;
                                    } elseif ($normKey === 'NOINETVALINS' || $normKey === 'NOINET') {
                                        $cellVal = $item->no_inet_valins ?? null;
                                    } elseif ($normKey === 'SIP1VALINS' || $normKey === 'SIP1') {
                                        $cellVal = $item->sip1_valins ?? null;
                                    } elseif ($normKey === 'SIP2VALINS' || $normKey === 'SIP2') {
                                        $cellVal = $item->sip2_valins ?? null;
                                    } elseif ($normKey === 'SID') {
                                        $cellVal = $item->sid ?? null;
                                    } elseif (in_array($normKey, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL', 'AREANUM', 'NOMORAREA'])) {
                                        $cellVal = $item->treg ?? null;
                                    } elseif (in_array($normKey, ['WITEL', 'DISTRICT', 'KOTA', 'KABUPATEN'])) {
                                        $cellVal = $item->witel ?? null;
                                    }
                                }

                                // 3. Penanganan khusus Tanggal (Konversi angka serial Excel & proteksi 1970)
                                if ($col['is_date'] || in_array($normKey, ['TANGGAL', 'DATE', 'DBLASTUPDATEDATE', 'TANGGALUPDATEDATABASE'])) {
                                    if ($cellVal !== null && $cellVal !== '' && $cellVal !== '-') {
                                        if (is_numeric($cellVal)) {
                                            $num = (float)$cellVal;
                                            if ($num >= 20000 && $num < 80000) {
                                                $days = floor($num);
                                                $cellVal = gmdate('d-m-Y', (int)(($days - 25569) * 86400));
                                            } else {
                                                $cellVal = null;
                                            }
                                        } else {
                                            $cStr = trim((string)$cellVal);
                                            if ($cStr === '0000-00-00' || $cStr === '1970-01-01' || $cStr === '01-01-1970' || strpos($cStr, '1970-01-01') !== false) {
                                                $cellVal = null;
                                            } else {
                                                try {
                                                    $cb = \Carbon\Carbon::parse($cStr);
                                                    if ($cb->year > 1971) {
                                                        $cellVal = $cb->format('d-m-Y');
                                                    } else {
                                                        $cellVal = null;
                                                    }
                                                } catch (\Throwable $e) {
                                                    $cellVal = null;
                                                }
                                            }
                                        }
                                    } else {
                                        $cellVal = null;
                                    }
                                }

                                // 3b. Format baku TREG: Tampilkan angka saja, tanpa teks "TREG"
                                if ($col['is_treg'] ?? false || in_array($normKey, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL', 'AREANUM', 'NOMORAREA'])) {
                                    if (!empty($cellVal) && $cellVal !== '-') {
                                        $tStr = trim((string)$cellVal);
                                        if (preg_match('/(\d+)/', $tStr, $mTreg)) {
                                            $cellVal = $mTreg[1];
                                        }
                                    }
                                }

                                // 4. Pembersihan nilai kosong secara ketat
                                $isEmpty = ($cellVal === null 
                                    || trim((string)$cellVal) === '' 
                                    || trim((string)$cellVal) === '-' 
                                    || trim((string)$cellVal) === '0000-00-00' 
                                    || trim((string)$cellVal) === '1970-01-01'
                                    || trim((string)$cellVal) === '01-01-1970'
                                    || strpos(trim((string)$cellVal), '1970-01-01') !== false);
                                
                                $normKey = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$col['nama']));
                                $isPortOdp = ($col['is_port_odp'] ?? false) || in_array($normKey, ['PORTODP', 'PORTOD']);
                                $isCenterCol = ($col['align'] ?? 'left') === 'center' || $isPortOdp || in_array($normKey, ['SLOT', 'PORT', 'TREG', 'STO', 'VALINSID', 'NOINETVALINS', 'SIP1VALINS', 'SIP2VALINS']);
                                
                                $alignClass = $isCenterCol ? 'text-center' : 'text-left';
                                if ($isEmpty) {
                                    $alignClass = 'text-center';
                                }
                            @endphp

                            <td class="px-3.5 py-2.5 whitespace-nowrap {{ $alignClass }} align-middle border-r border-slate-200/90 text-xs">
                                @if($isEmpty)
                                    <span class="text-slate-400 font-mono text-[11px] select-none">-</span>
                                @elseif($isPortOdp)
                                    @php
                                        $cleanedPort = trim((string)$cellVal);
                                        if (preg_match('/(\d+)/', $cleanedPort, $mP)) {
                                            $cleanedPort = $mP[1];
                                        }
                                    @endphp
                                    <div class="flex items-center justify-center w-full">
                                        <span class="inline-flex items-center justify-center min-w-[26px] h-6 px-2 rounded-md text-[11px] font-mono font-bold text-slate-800 bg-slate-100/90 border border-slate-200/80 shadow-2xs tabular-nums group-hover:bg-red-50 group-hover:text-[#AE0C00] group-hover:border-red-200/70 transition-colors">
                                            {{ $cleanedPort }}
                                        </span>
                                    </div>
                                @elseif($col['is_status'])
                                    @php
                                        $rawVal = trim((string)$cellVal);
                                        $uVal = strtoupper($rawVal);
                                        
                                        if ($uVal === 'DONE' || in_array($uVal, ['VALID', 'CLEAR', 'SELESAI', 'NORMAL', 'LURUS', 'BERES', 'SUKSES'])) {
                                            // 1. DONE (Emerald Fresh dengan Lingkaran Centang Terverifikasi)
                                            $bBg = 'bg-emerald-50 text-emerald-800 border-emerald-200/90 group-hover:border-emerald-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 5-5"/></svg>';
                                        } elseif ($uVal === 'DONE OLO') {
                                            // 2. DONE OLO (Cyan Sejuk dengan Ikon Interkoneksi Simpul Operator)
                                            $bBg = 'bg-cyan-50 text-cyan-800 border-cyan-300/80 group-hover:border-cyan-400';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
                                        } elseif ($uVal === 'ASTINET') {
                                            // 3. ASTINET (Indigo Korporat dengan Ikon Bola Dunia Jaringan Fiber Dedicated)
                                            $bBg = 'bg-indigo-50 text-indigo-800 border-indigo-200/90 group-hover:border-indigo-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>';
                                        } elseif ($uVal === 'OTB') {
                                            // 4. OTB (Amber Hangat dengan Ikon Terminal Hardware Box)
                                            $bBg = 'bg-amber-50 text-amber-800 border-amber-300/80 group-hover:border-amber-400';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/><circle cx="7.5" cy="10" r="1.5" stroke-width="1.5"/><circle cx="12" cy="10" r="1.5" stroke-width="1.5"/><circle cx="16.5" cy="10" r="1.5" stroke-width="1.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 16h14"/></svg>';
                                        } elseif (in_array($uVal, ['DISCONNECTED', 'PENDING_DISCONN', 'PENDING_DISCONNECT'])) {
                                            // 5. DISCONNECTED (Rose Red dengan Ikon Lingkaran Terputus / Prohibited)
                                            $bBg = 'bg-rose-50 text-rose-800 border-rose-200/90 group-hover:border-rose-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>';
                                        } elseif (in_array($uVal, ['SUSPENDED', 'ISOLIR', 'CABUT'])) {
                                            // 6. SUSPENDED / ISOLIR (Orange Hangat dengan Ikon Gembok Penangguhan)
                                            $bBg = 'bg-orange-50 text-orange-800 border-orange-200/90 group-hover:border-orange-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-orange-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>';
                                        } elseif (preg_match('/(PENDING|PROGRES|PROGRESS|BELUM|TUNGGU|VALIDASI|PROSES|ANTRE)/i', $uVal)) {
                                            // 7. PENDING / DALAM PROGRES (Biru Tenang dengan Ikon Jam Timer)
                                            $bBg = 'bg-blue-50 text-blue-800 border-blue-200/90 group-hover:border-blue-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        } elseif (in_array($uVal, ['CANCELLED', 'BATAL'])) {
                                            // 8. CANCELLED / BATAL (Slate Netral dengan Ikon Lingkaran X)
                                            $bBg = 'bg-slate-100 text-slate-700 border-slate-300/80 group-hover:border-slate-400';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        } elseif (in_array($uVal, ['TIDAK VALID', 'RUSAK', 'KENDALA', 'BEDA', 'DEV', 'TIDAK SAMA', 'KENDALA BI'])) {
                                            // 9. TIDAK VALID / KENDALA (Merah Telkom dengan Ikon Segitiga Peringatan)
                                            $bBg = 'bg-red-50 text-red-800 border-red-200/90 group-hover:border-red-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
                                        } elseif (in_array($uVal, ['SKIP DULU', 'SKIP'])) {
                                            // 10. SKIP DULU (Ungu Violet dengan Ikon Fast Forward)
                                            $bBg = 'bg-purple-50 text-purple-800 border-purple-200/90 group-hover:border-purple-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>';
                                        } elseif (in_array($uVal, ['WITEL LAIN'])) {
                                            // 11. WITEL LAIN (Slate Netral dengan Ikon Gedung Kantor Witel)
                                            $bBg = 'bg-slate-100 text-slate-700 border-slate-300/80 group-hover:border-slate-400';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
                                        } else {
                                            // 12. Catatan Khusus / Deskripsi Teknis Bebas (misal "Slot Port GPON tidak ada", dsb.)
                                            $bBg = 'bg-slate-50 text-slate-700 border-slate-200/90 group-hover:border-slate-300';
                                            $bIc = '<svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10.5px] font-mono font-bold border tracking-tight shadow-2xs transition-all duration-150 {{ $bBg }}">
                                        {!! $bIc !!}
                                        <span>{{ $rawVal }}</span>
                                    </span>
                                @elseif($col['is_date'])
                                    <span class="font-mono text-slate-800">{{ $cellVal }}</span>
                                @elseif($col['is_pic'])
                                    <span class="font-medium text-slate-800">{{ $cellVal }}</span>
                                @elseif($col['is_treg'] ?? false || in_array($normKey, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL']))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80 font-mono tracking-tight shadow-2xs">
                                        {{ $cellVal }}
                                    </span>
                                @elseif($normKey === 'WITEL' || $normKey === 'DISTRICT')
                                    <span class="font-bold text-slate-700 font-mono text-xs">{{ $cellVal }}</span>
                                @elseif($normKey === 'STO')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-slate-100 group-hover:bg-red-50 text-slate-800 group-hover:text-[#AE0C00] border border-slate-200/90 group-hover:border-red-200 font-headline tracking-wide transition-colors shadow-2xs">
                                        {{ $cellVal }}
                                    </span>
                                @elseif(in_array($normKey, ['ODPLOCATION', 'ODPNAME']))
                                    <div class="font-bold text-slate-900 font-mono text-[11px] group-hover:text-[#AE0C00] transition-colors truncate">
                                        {{ $cellVal }}
                                    </div>
                                @elseif(in_array($normKey, ['SLOT', 'PORT']))
                                    <div class="flex items-center justify-center w-full">
                                        <span class="font-mono font-bold text-slate-800 text-[11px] tabular-nums">{{ trim((string)$cellVal) }}</span>
                                    </div>
                                @elseif(in_array($normKey, ['VALINSID', 'NODEID', 'NODEIP', 'ONUSN', 'NOINETVALINS', 'SIP1VALINS', 'SIP2VALINS', 'SID']))
                                    <span class="font-mono font-bold text-slate-800 text-[11px]">{{ trim((string)$cellVal) }}</span>
                                @else
                                    <span class="text-slate-800 text-xs">{{ trim((string)$cellVal) }}</span>
                                @endif
                            </td>
                        @endforeach
                    @else
                        <!-- RENDER KOLOM STANDAR SISTEM BAWAAN (Hierarki: TREG -> WITEL -> STO -> ODP NAME) -->
                        @if(!empty($activeColumns['treg']))
                        <!-- 1. TREG (Nama Regional Tipografi Semi-Bold Abu-Abu Netral) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @php
                                $tregVal = $item->treg;
                                if (!empty($tregVal) && $tregVal !== '-') {
                                    if (preg_match('/(\d+)/', (string)$tregVal, $mTr)) {
                                        $tregVal = $mTr[1];
                                    } else {
                                        $tregVal = trim((string)$tregVal);
                                    }
                                }
                            @endphp
                            @if(!empty($tregVal) && $tregVal !== '-')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80 font-mono tracking-tight shadow-2xs">
                                    {{ $tregVal }}
                                </span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px] select-none">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['witel']))
                        <!-- 2. WITEL (Nama Witel Tipografi Sejajar) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                            <span class="font-bold text-slate-700 font-mono text-xs">{{ $item->witel ?? '-' }}</span>
                        </td>
                        @endif

                        @if(!empty($activeColumns['sto']))
                        <!-- 3. STO (Kode STO Lencana Persegi Membulat Halus) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if(!empty($item->sto) && $item->sto !== '-')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-slate-100 group-hover:bg-red-50 text-slate-800 group-hover:text-[#AE0C00] border border-slate-200/90 group-hover:border-red-200 font-headline tracking-wide transition-colors shadow-2xs">
                                    {{ $item->sto }}
                                </span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px] select-none">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['odp_name']))
                        <!-- 2. ODP NAME (Nama ODP & Kapsul Panel/Port Persis Dashboard) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                            <div class="font-bold text-slate-900 font-mono text-[11px] group-hover:text-[#AE0C00] transition-colors truncate">
                                {{ $item->odp_name ?? '-' }}
                            </div>
                            @php
                                $panel = $item->panel_odp ?? $item->panel_o ?? null;
                                $port = $item->port_odp ?? $item->port_od ?? null;
                            @endphp
                            @if (!empty($panel) || !empty($port))
                                <div class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded bg-slate-100 text-[9.5px] text-slate-600 font-mono mt-0.5 border border-slate-200/60">
                                    <span>{{ $panel ?? 'PANEL01' }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span>Port {{ $port ?? '-' }}</span>
                                </div>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['valins_id']))
                        <!-- 3. VALINS ID (Tengah Sel, Angka Monospace Tebal Persis Dashboard) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if (!empty($item->valins_id) && $item->valins_id !== '-')
                                <span class="font-mono font-bold text-slate-900 text-xs tabular-nums tracking-tight">
                                    {{ $item->valins_id }}
                                </span>
                            @else
                                <span class="text-slate-400 font-mono text-xs">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['node_info']))
                        <!-- 4. NODE ID & IP (Node ID Tebal & Ikon Bola Dunia IP Persis Dashboard) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                            @if (!empty($item->node_id) && $item->node_id !== '-')
                                <div class="font-bold text-slate-800 text-[11px] font-mono tracking-tight truncate">
                                    {{ $item->node_id }}
                                </div>
                                @if (!empty($item->node_ip) && $item->node_ip !== '-')
                                    <div class="text-[10px] text-slate-500 font-mono flex items-center gap-1 mt-0.5">
                                        <svg class="w-2.5 h-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                        <span class="truncate">{{ $item->node_ip }}</span>
                                    </div>
                                @endif
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['slot_port']))
                        <!-- 5. SLOT & PORT OLT (Kapsul Terpadu Slot • Port Persis Dashboard) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if ((!empty($item->slot) && $item->slot !== '-') || (!empty($item->port) && $item->port !== '-'))
                                <div class="inline-flex items-center justify-center gap-1.5 px-2 py-0.5 rounded-lg text-[11px] font-mono font-medium bg-slate-100/90 text-slate-800 border border-slate-200/80 tabular-nums shadow-2xs">
                                    <span class="text-slate-500 text-[10px]">Slot</span>
                                    <strong class="text-slate-900 font-bold">{{ $item->slot ?? '-' }}</strong>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-500 text-[10px]">Port</span>
                                    <strong class="text-slate-900 font-bold">{{ $item->port ?? '-' }}</strong>
                                </div>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['onu_sn']))
                        <!-- 6. ONU SN (Huruf Kode Teknis Tegas) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                            @if (!empty($item->onu_sn) && $item->onu_sn !== '-')
                                <span class="font-mono text-[11px] font-semibold text-slate-800 tracking-wide">{{ $item->onu_sn }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['no_inet_valins']))
                        <!-- 7. NO INET VALINS (Angka Rapi di Tengah Sel) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if (!empty($item->no_inet_valins) && $item->no_inet_valins !== '-')
                                <span class="font-mono text-[11px] text-slate-800 font-medium tabular-nums">{{ $item->no_inet_valins }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['sip1_valins']))
                        <!-- 8. SIP 1 VALINS (Angka Rapi di Tengah Sel) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if (!empty($item->sip1_valins) && $item->sip1_valins !== '-')
                                <span class="font-mono text-[11px] text-slate-800 font-medium tabular-nums">{{ $item->sip1_valins }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['sip2_valins']))
                        <!-- 9. SIP 2 VALINS (Angka Rapi di Tengah Sel) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if (!empty($item->sip2_valins) && $item->sip2_valins !== '-')
                                <span class="font-mono text-[11px] text-slate-800 font-medium tabular-nums">{{ $item->sip2_valins }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['sid']))
                        <!-- 10. SID (Kode SID Utuh Satu Baris Tanpa Terpotong) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            @if (!empty($item->sid) && $item->sid !== '-')
                                <span class="font-mono text-[11px] text-slate-800 font-medium whitespace-nowrap">{{ $item->sid }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                            @endif
                        </td>
                        @endif

                        <!-- Kolom Tambahan Dinamis Berdasarkan Kategori Aktif -->
                        @foreach(($activeColumns['custom'] ?? []) as $col)
                            @php
                                $namaKolom = $col['nama'];
                                $normK = strtoupper(preg_replace('/[^A-Z0-9]/', '', $namaKolom));
                                $isCustomPortOdp = in_array($normK, ['PORTODP', 'PORTOD']);
                                $isCustomCenter = $isCustomPortOdp || in_array($normK, ['SLOT', 'PORT', 'TREG', 'STO', 'VALINSID', 'NOINETVALINS', 'SIP1VALINS', 'SIP2VALINS']);
                                $nilai = '-';

                                if (isset($dynData[$namaKolom]) && $dynData[$namaKolom] !== null && $dynData[$namaKolom] !== '') {
                                    $nilai = $dynData[$namaKolom];
                                } else {
                                    foreach ($dynData as $k => $v) {
                                        if ($v !== null && $v !== '' && strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k)) === $normK) {
                                            $nilai = $v;
                                            break;
                                        }
                                    }
                                }
                                if ($nilai === '-' || $nilai === '') {
                                    $propName = strtolower(str_replace(' ', '_', $namaKolom));
                                    if (isset($item->{$propName}) && $item->{$propName} !== null && $item->{$propName} !== '') {
                                        $nilai = $item->{$propName};
                                    }
                                }
                                if ($isCustomPortOdp && $nilai !== '-' && $nilai !== '') {
                                    $pTrim = trim((string)$nilai);
                                    $nilai = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : $pTrim;
                                }
                            @endphp
                            <td class="px-3.5 py-2.5 text-xs text-slate-800 align-middle border-r border-slate-200/90 font-mono font-bold tracking-tight {{ $isCustomCenter ? 'text-center' : 'text-left' }}">
                                @if($nilai !== '-' && $nilai !== '')
                                    @if($isCustomPortOdp)
                                        <div class="flex items-center justify-center w-full">
                                            <span class="inline-flex items-center justify-center min-w-[26px] h-6 px-2 rounded-md text-[11px] font-mono font-bold text-slate-800 bg-slate-100/90 border border-slate-200/80 shadow-2xs tabular-nums group-hover:bg-red-50 group-hover:text-[#AE0C00] group-hover:border-red-200/70 transition-colors">
                                                {{ $nilai }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-800 border border-slate-200/70">{{ $nilai }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">-</span>
                                @endif
                            </td>
                        @endforeach

                        <!-- 11. KETERANGAN (Modern Enterprise Tag & 2-Tier Dynamic Engine) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                            <div class="flex flex-col items-center justify-center gap-1">
                                @php
                                    $rawKet = trim($item->keterangan ?? '');
                                    $ketUpper = strtoupper($rawKet);
                                @endphp

                                @if (!empty($rawKet) && $rawKet !== '-')
                                    @php
                                        // 1. Pemetaan Baku Status Utama
                                        if ($ketUpper === 'DONE' || in_array($ketUpper, ['VALID', 'CLEAR', 'SELESAI', 'NORMAL', 'LURUS', 'BERES', 'SUKSES'])) {
                                            // 1. DONE (Emerald Fresh dengan Lingkaran Centang Terverifikasi)
                                            $badgeBg = 'bg-emerald-50 text-emerald-800 border-emerald-200/90 group-hover:border-emerald-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 5-5"/></svg>';
                                        } elseif ($ketUpper === 'DONE OLO') {
                                            // 2. DONE OLO (Cyan Sejuk dengan Ikon Interkoneksi Simpul Operator)
                                            $badgeBg = 'bg-cyan-50 text-cyan-800 border-cyan-300/80 group-hover:border-cyan-400';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
                                        } elseif ($ketUpper === 'ASTINET') {
                                            // 3. ASTINET (Indigo Korporat dengan Ikon Bola Dunia Jaringan Fiber Dedicated)
                                            $badgeBg = 'bg-indigo-50 text-indigo-800 border-indigo-200/90 group-hover:border-indigo-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>';
                                        } elseif ($ketUpper === 'OTB') {
                                            // 4. OTB (Amber Hangat dengan Ikon Terminal Hardware Box)
                                            $badgeBg = 'bg-amber-50 text-amber-800 border-amber-300/80 group-hover:border-amber-400';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/><circle cx="7.5" cy="10" r="1.5" stroke-width="1.5"/><circle cx="12" cy="10" r="1.5" stroke-width="1.5"/><circle cx="16.5" cy="10" r="1.5" stroke-width="1.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 16h14"/></svg>';
                                        } elseif (in_array($ketUpper, ['DISCONNECTED', 'PENDING_DISCONN', 'PENDING_DISCONNECT'])) {
                                            // 5. DISCONNECTED (Rose Red dengan Ikon Lingkaran Terputus / Prohibited)
                                            $badgeBg = 'bg-rose-50 text-rose-800 border-rose-200/90 group-hover:border-rose-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>';
                                        } elseif (in_array($ketUpper, ['SUSPENDED', 'ISOLIR', 'CABUT'])) {
                                            // 6. SUSPENDED / ISOLIR (Orange Hangat dengan Ikon Gembok Penangguhan)
                                            $badgeBg = 'bg-orange-50 text-orange-800 border-orange-200/90 group-hover:border-orange-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-orange-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>';
                                        } elseif (preg_match('/(PENDING|PROGRES|PROGRESS|BELUM|TUNGGU|VALIDASI|PROSES|ANTRE)/i', $ketUpper)) {
                                            // 7. PENDING / DALAM PROGRES (Biru Tenang dengan Ikon Jam Timer)
                                            $badgeBg = 'bg-blue-50 text-blue-800 border-blue-200/90 group-hover:border-blue-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        } elseif (in_array($ketUpper, ['CANCELLED', 'BATAL'])) {
                                            // 8. CANCELLED / BATAL (Slate Netral dengan Ikon Lingkaran X)
                                            $badgeBg = 'bg-slate-100 text-slate-700 border-slate-300/80 group-hover:border-slate-400';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        } elseif (in_array($ketUpper, ['TIDAK VALID', 'RUSAK', 'KENDALA', 'BEDA', 'DEV', 'TIDAK SAMA', 'KENDALA BI'])) {
                                            // 9. TIDAK VALID / KENDALA (Merah Telkom dengan Ikon Segitiga Peringatan)
                                            $badgeBg = 'bg-red-50 text-red-800 border-red-200/90 group-hover:border-red-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
                                        } elseif (in_array($ketUpper, ['SKIP DULU', 'SKIP'])) {
                                            // 10. SKIP DULU (Ungu Violet dengan Ikon Fast Forward)
                                            $badgeBg = 'bg-purple-50 text-purple-800 border-purple-200/90 group-hover:border-purple-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>';
                                        } elseif (in_array($ketUpper, ['WITEL LAIN'])) {
                                            // 11. WITEL LAIN (Slate Netral dengan Ikon Gedung Kantor Witel)
                                            $badgeBg = 'bg-slate-100 text-slate-700 border-slate-300/80 group-hover:border-slate-400';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
                                        } else {
                                            // 12. Catatan Khusus / Deskripsi Teknis Bebas
                                            $badgeBg = 'bg-slate-50 text-slate-700 border-slate-200/90 group-hover:border-slate-300';
                                            $iconSvg = '<svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>';
                                        }
                                    @endphp

                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10.5px] font-mono font-bold border tracking-tight shadow-2xs transition-all duration-150 {{ $badgeBg }}">
                                        {!! $iconSvg !!}
                                        <span>{{ $item->keterangan }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">-</span>
                                @endif

                                @if($isLockedByOther)
                                    <div class="flex items-center justify-center gap-1 text-[9px] text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md shadow-2xs font-bold animate-pulse mt-0.5">
                                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        <span>Diproses: {{ explode(' ', $item->locked_by)[0] }}</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        @if(!empty($activeColumns['tanggal']))
                        <!-- 12. TANGGAL (Satu Baris Utuh di Tengah Sel) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-center text-xs text-slate-800 align-middle border-r border-slate-200/90 font-mono">
                            @php
                                $tglObj = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal) : null;
                                $isTglValid = $tglObj && $tglObj->year > 1971;
                            @endphp
                            @if($isTglValid)
                                <span>{{ $tglObj->format('d-m-Y') }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px] select-none">-</span>
                            @endif
                        </td>
                        @endif

                        @if(!empty($activeColumns['pic']))
                        <!-- 13. PIC (Nama Petugas Tipografi Bersih) -->
                        <td class="px-3.5 py-2.5 whitespace-nowrap text-xs text-slate-800 align-middle border-r border-slate-200/90 font-medium {{ empty($item->pic) || $item->pic === '-' ? 'text-center' : '' }}">
                            @if(!empty($item->pic) && $item->pic !== '-')
                                <span>{{ $item->pic }}</span>
                            @else
                                <span class="text-slate-400 font-mono text-[11px] select-none">-</span>
                            @endif
                        </td>
                        @endif
                    @endif

                    @php
                        $aksiBg = 'bg-white group-hover:bg-slate-50';
                        if ($isLockedByMe) {
                            $aksiBg = 'bg-[#fef2f2]';
                        } elseif ($isLockedByOther) {
                            $aksiBg = 'bg-[#fffbeb]';
                        }
                    @endphp

                    <!-- 14. AKSI (100% Solid Opaque Sticky Right, Anti-Tabrakan Keterangan) -->
                    <td :class="{ '!bg-[#fef2f2]': selected.map(String).includes('{{ (string) $item->id }}') }" class="px-3 sm:px-4 py-2.5 sm:py-3 text-center align-middle sticky right-0 {{ $aksiBg }} transition-colors z-20">
                        <!-- Garis batas vertikal kiri tegas & bayangan pemisah halus anti-tabrakan saat scroll -->
                        <div class="absolute inset-y-0 left-0 w-0.5 bg-slate-300 pointer-events-none"></div>
                        <div class="absolute inset-y-0 -left-2.5 w-2.5 pointer-events-none bg-gradient-to-l from-slate-900/[0.08] to-transparent"></div>

                        <div class="flex justify-center items-center gap-1.5">
                            @if($isLockedByOther)
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/60 bg-slate-50 text-slate-300 cursor-not-allowed select-none" title="Tidak dapat diedit: Sedang diproses oleh {{ $item->locked_by }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </div>
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/60 bg-slate-50 text-slate-300 cursor-not-allowed select-none" title="Tidak dapat dihapus: Sedang diproses oleh {{ $item->locked_by }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </div>
                            @else
                                <a href="{{ route('valins.edit', $item->id) }}" 
                                   class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 bg-white hover:bg-blue-50/50 text-slate-500 hover:text-blue-600 hover:border-blue-200 shadow-2xs transition-all duration-150 cursor-pointer" 
                                   title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>
                                <button type="button" 
                                        @click="singleDeleteId = {{ $item->id }}; confirmDeleteSingleModal = true" 
                                        class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 bg-white hover:bg-red-50/50 text-slate-500 hover:text-[#AE0C00] hover:border-red-200 shadow-2xs transition-all duration-150 cursor-pointer" 
                                        title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr wire:loading.class="hidden" wire:target="setKategori,kategori,previousPage,nextPage,gotoPage,search,filterSto,filterStatus,perPage,resetFilters">
                    <td colspan="100%" class="px-4 py-14 sm:py-16 text-center bg-slate-50/40">
                        <div class="flex flex-col items-center justify-center max-w-md mx-auto text-center">
                            <!-- 1. Wadah Persegi Bersudut Membulat Modern (Modern Squircle Icon) -->
                            <div class="w-14 h-14 rounded-2xl bg-slate-50/80 border border-slate-200/90 shadow-2xs flex items-center justify-center mb-4 text-slate-500">
                                @if(!empty($search))
                                    <!-- Opsi A: Dokumen Pencarian Bersih (File Search dengan Gap Presisi Tanpa Tumpang Tindih) -->
                                    <svg class="w-6 h-6 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3v4a1 1 0 001 1h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11V7l-5-5H6a2 2 0 00-2 2v16a2 2 0 002 2h5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h4m-4 4h2" />
                                        <circle cx="16.5" cy="16.5" r="3" stroke-width="1.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.8 18.8l2.7 2.7" />
                                    </svg>
                                @else
                                    <!-- Opsi B: Arsip / Folder Data Minimalis Bergaris Tunggal Bersih -->
                                    <svg class="w-6 h-6 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- 2. Hierarki Tipografi Dua Tingkat -->
                            <h3 class="text-sm sm:text-base font-headline font-bold text-slate-800 tracking-tight">
                                {{ !empty($search) ? 'Tidak Ada Data yang Cocok' : 'Belum Ada Data di Kategori Ini' }}
                            </h3>
                            <p class="mt-1 text-xs sm:text-[13px] text-slate-500 font-sans leading-relaxed">
                                {{ !empty($search) ? 'Tidak ditemukan baris data rekonsiliasi yang cocok dengan kata kunci "' . $search . '". Silakan periksa kembali ejaan pencarian Anda.' : 'Tidak ada baris data rekonsiliasi yang tersimpan untuk kategori ini saat ini.' }}
                            </p>

                            <!-- 3. Tombol Tindakan Cepat (Actionable Shortcuts) -->
                            <div class="mt-5 flex flex-wrap items-center justify-center gap-2.5 sm:gap-3">
                                @if(!empty($search))
                                    <!-- Tombol Reset Pencarian -->
                                    <button type="button" 
                                            wire:click="$set('search', '')" 
                                            class="inline-flex items-center justify-center gap-1.5 h-8.5 px-3.5 bg-white hover:bg-red-50 text-[#AE0C00] hover:text-[#8E0A00] border border-red-200/90 hover:border-red-300 rounded-xl shadow-2xs hover:shadow-xs transition-all duration-150 text-xs font-headline font-semibold cursor-pointer active:scale-95 select-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span>Reset Pencarian</span>
                                    </button>
                                @endif

                                <!-- Tombol + Tambah Data -->
                                <a href="{{ route('valins.create', array_filter(['kategori' => $kategori])) }}" 
                                   class="inline-flex items-center justify-center gap-1.5 h-8.5 px-3.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200/90 hover:border-slate-300 rounded-xl shadow-2xs hover:shadow-xs transition-all duration-150 text-xs font-headline font-semibold cursor-pointer active:scale-95 select-none">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span>Tambah Data</span>
                                </a>

                                <!-- Tombol Import Data -->
                                <button type="button" 
                                        wire:click="openImportModal" 
                                        @click="$dispatch('open-import-modal-instant')" 
                                        class="inline-flex items-center justify-center gap-1.5 h-8.5 px-3.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200/90 hover:border-slate-300 rounded-xl shadow-2xs hover:shadow-xs transition-all duration-150 text-xs font-headline font-semibold cursor-pointer active:scale-95 select-none">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span>Import Data</span>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Navigasi Pagination & Info Footer Tabel Terstruktur -->
    <div class="pt-2 flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-2">
            <span>
                Menampilkan <strong class="text-slate-900 font-bold tabular-nums">{{ $data->firstItem() ?? 0 }}</strong> - <strong class="text-slate-900 font-bold tabular-nums">{{ $data->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-900 font-bold tabular-nums">{{ number_format($data->total()) }}</strong> Data
                @if(!empty($search))
                    <span class="text-slate-400 font-mono">(Hasil Pencarian: "{{ $search }}")</span>
                @elseif(!empty($kategori))
                    <span class="text-slate-400 font-mono">({{ $kategori }})</span>
                @else
                    Terdata
                @endif
            </span>
        </div>

        <div class="overflow-x-auto max-w-full">
            {{ $data->links('livewire.custom-pagination') }}
        </div>
    </div>
</div>

    <!-- Modal Edit Massal (Latar Kaca Transparan Terang, Tema Korporat & Transisi Mulus Anti-Lompat) -->
    <template x-teleport="body">
        <div x-data="{ 
                modalOpen: @entangle('bulkEditOpen'),
                statusValue: @entangle('bulkEditKeterangan'),
                closeModal() {
                    this.modalOpen = false;
                    setTimeout(() => {
                        $wire.closeBulkEdit();
                    }, 160);
                },
                selectStatus(val) {
                    this.statusValue = val;
                    $wire.set('bulkEditKeterangan', val);
                }
             }"
             x-show="modalOpen"
             @open-bulk-edit-instant.window="modalOpen = true"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog" 
             aria-modal="true"
             @keydown.escape.window="closeModal()">
            
            <!-- Backdrop Transparan Kaca Buram Terang (160ms GPU opacity-only transition, static blur) -->
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
                     class="relative w-full max-w-lg max-h-[90vh] bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-200/90 text-left flex flex-col overflow-hidden will-change-transform">
                    
                    <!-- Header Modal -->
                    <div class="bg-white px-5 sm:px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#AE0C00] border border-red-200/60 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-slate-900 font-headline font-bold text-base sm:text-lg leading-tight">
                                    {{ count($selectedRows) === 1 ? 'Edit Data Terpilih' : 'Pembaruan Data Massal' }}
                                </h3>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-[#AE0C00] border border-red-200/70 tracking-wide">
                                        {{ count($selectedRows) === 1 ? 'Target: 1 Baris Data' : 'Target: ' . count($selectedRows) . ' Baris Data' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" 
                                @click="closeModal()" 
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors duration-150 cursor-pointer focus:outline-hidden"
                                title="Tutup Modal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Bilah Informasi Panduan -->
                    <div class="bg-slate-50 border-b border-slate-100 px-5 sm:px-6 py-2.5 sm:py-3 flex items-start gap-2.5 shrink-0">
                        <svg class="w-4 h-4 text-[#AE0C00] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            @if(count($selectedRows) === 1)
                                Data saat ini telah dimuat. Sesuaikan parameter di bawah lalu klik <strong class="font-semibold text-slate-800">Simpan Perubahan</strong>.
                            @else
                                Hanya parameter yang diisi yang akan diperbarui untuk <strong class="font-semibold text-slate-800">{{ count($selectedRows) }} data terpilih</strong>.
                            @endif
                        </p>
                    </div>

                    <!-- Form Fields -->
                    <div class="px-5 sm:px-6 py-4 space-y-4 overflow-y-auto flex-1 custom-scrollbar">
                        <!-- Kolom Keterangan / Status -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Keterangan / Status</label>
                            <div class="relative">
                                <input type="text" 
                                       x-model="statusValue"
                                       wire:model="bulkEditKeterangan" 
                                       autocomplete="off"
                                       placeholder="Ketik status atau pilih dari tombol di bawah..."
                                       class="w-full bg-white border border-slate-200/90 rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 shadow-2xs transition duration-150">
                            </div>

                            <!-- Pilihan Status Cepat (Tata Letak 3 Kolom Seimbang & Baris Petunjuk Minimalis) -->
                            <div class="mt-2.5">
                                <!-- Baris Bantuan Minimalis -->
                                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 mb-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Pilih status cepat di bawah atau ketik langsung di atas</span>
                                </div>

                                <!-- Grid Kapsul 3 Kolom Seimbang (3 Kolom x 2 Baris Presisi) -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <!-- DONE (Centang tunggal di dalam lingkaran hijau zamrud) -->
                                    <button type="button" 
                                            @click="selectStatus('DONE')"
                                            :class="statusValue === 'DONE' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 5-5"/>
                                        </svg>
                                        <span>Done</span>
                                    </button>

                                    <!-- DONE OLO (Simpul tautan / interkoneksi link operator cyan) -->
                                    <button type="button" 
                                            @click="selectStatus('DONE OLO')"
                                            :class="statusValue === 'DONE OLO' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <span>Done OLO</span>
                                    </button>

                                    <!-- ASTINET (Globe / Jaringan Fiber Dedicated Enterprise Indigo) -->
                                    <button type="button" 
                                            @click="selectStatus('ASTINET')"
                                            :class="statusValue === 'ASTINET' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        <span>Astinet</span>
                                    </button>

                                    <!-- OTB (Optical Termination Box - Kotak Terminasi & Simpul Kabel Optik Amber Gelap) -->
                                    <button type="button" 
                                            @click="selectStatus('OTB')"
                                            :class="statusValue === 'OTB' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-amber-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>
                                            <circle cx="7.5" cy="10" r="1.5" stroke-width="1.5"/>
                                            <circle cx="12" cy="10" r="1.5" stroke-width="1.5"/>
                                            <circle cx="16.5" cy="10" r="1.5" stroke-width="1.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 16h14"/>
                                        </svg>
                                        <span>OTB</span>
                                    </button>

                                    <!-- Disconnected (Lingkaran garis miring tunggal merah korporat) -->
                                    <button type="button" 
                                            @click="selectStatus('Disconnected')"
                                            :class="statusValue === 'Disconnected' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 5.636l12.728 12.728"/>
                                        </svg>
                                        <span>Disconnected</span>
                                    </button>

                                    <!-- Kendala BI (Segitiga peringatan garis tipis amber tenang) -->
                                    <button type="button" 
                                            @click="selectStatus('KENDALA BI')"
                                            :class="statusValue === 'KENDALA BI' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <span>Kendala BI</span>
                                    </button>

                                    <!-- Witel Lain (Gedung administratif garis tipis abu-abu arang netral) -->
                                    <button type="button" 
                                            @click="selectStatus('WITEL LAIN')"
                                            :class="statusValue === 'WITEL LAIN' 
                                                ? 'border-[#AE0C00] bg-red-50/70 text-[#AE0C00] font-bold ring-1 ring-[#AE0C00]/25 shadow-2xs' 
                                                : 'border-slate-200/90 bg-slate-50/70 hover:bg-slate-100/80 text-slate-700 hover:text-slate-900 font-medium'"
                                            class="w-full h-8 px-2.5 inline-flex items-center justify-center gap-1.5 rounded-xl text-xs border transition-colors duration-150 cursor-pointer focus:outline-hidden">
                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>Witel Lain</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 2 Kolom Sejajar: PIC & Tanggal -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">PIC (Penanggung Jawab)</label>
                                <div class="relative">
                                    <input type="text" 
                                           wire:model="bulkEditPic" 
                                           placeholder="Contoh: FIRDI / LIANTY"
                                           class="w-full bg-white border border-slate-200/90 rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 shadow-2xs transition duration-150">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal</label>
                                <div class="relative">
                                    <input type="date" 
                                           wire:model="bulkEditTanggal"
                                           class="w-full bg-white border border-slate-200/90 rounded-xl px-3.5 py-2 text-xs sm:text-sm text-slate-800 focus:outline-hidden focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 shadow-2xs transition duration-150">
                                </div>
                            </div>
                        </div>

                        <!-- Update / Keterangan Progress -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Update / Keterangan Progress</label>
                            <textarea wire:model="bulkEditUpdateProgress" 
                                      rows="3" 
                                      placeholder="Catatan update atau keterangan progress..."
                                      class="w-full bg-white border border-slate-200/90 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-[#AE0C00] focus:ring-2 focus:ring-[#AE0C00]/15 shadow-2xs transition duration-150 resize-none h-24"></textarea>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                        <button type="button" 
                                @click="closeModal()" 
                                class="h-9 px-4 rounded-xl border border-slate-200/90 bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 font-semibold text-xs sm:text-sm shadow-2xs transition-colors duration-150 cursor-pointer focus:outline-hidden">
                            Batal
                        </button>
                        <button type="button" 
                                wire:click="saveBulkEdit" 
                                wire:loading.attr="disabled"
                                class="min-w-[172px] h-9 px-4 rounded-xl bg-[#AE0C00] hover:bg-[#930A00] active:bg-[#7d0800] text-white font-bold text-xs sm:text-sm shadow-xs transition-colors duration-150 cursor-pointer flex items-center justify-center gap-2 focus:outline-hidden disabled:opacity-80 disabled:cursor-wait">
                            <svg wire:loading wire:target="saveBulkEdit" class="animate-spin w-3.5 h-3.5 shrink-0 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2.5"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path>
                            </svg>
                            <svg wire:loading.remove wire:target="saveBulkEdit" class="w-3.5 h-3.5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span wire:loading.remove wire:target="saveBulkEdit">Simpan Perubahan</span>
                            <span wire:loading wire:target="saveBulkEdit">Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Import Data Massal (Split 2-Column System, Telkom Akses Corporate Red & GPU-Accelerated Drag-Drop) -->
    <template x-teleport="body">
        <div x-data="{ 
                modalOpen: @entangle('importModalOpen'),
                isDragging: false,
                fileDetails: @if($importFile) {
                    name: '{{ $importFile->getClientOriginalName() }}',
                    size: '{{ round($importFile->getSize() / 1024, 1) < 1024 ? round($importFile->getSize() / 1024, 1) . ' KB' : round($importFile->getSize() / (1024 * 1024), 2) . ' MB' }}',
                    type: '{{ strtolower(pathinfo($importFile->getClientOriginalName(), PATHINFO_EXTENSION)) }}'
                } @else null @endif,
                closeModal() {
                    this.modalOpen = false;
                    setTimeout(() => {
                        $wire.closeImportModal();
                        this.fileDetails = null;
                        this.isDragging = false;
                    }, 160);
                },
                setFile(file) {
                    if (!file) return;
                    const sizeKb = file.size / 1024;
                    const sizeFormatted = sizeKb < 1024 ? sizeKb.toFixed(1) + ' KB' : (sizeKb / 1024).toFixed(2) + ' MB';
                    const ext = file.name.split('.').pop().toLowerCase();
                    this.fileDetails = {
                        name: file.name,
                        size: sizeFormatted,
                        type: ext
                    };
                },
                handleDrop(e) {
                    this.isDragging = false;
                    if (e.dataTransfer && e.dataTransfer.files.length > 0) {
                        const file = e.dataTransfer.files[0];
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        if (this.$refs.fileInput) {
                            this.$refs.fileInput.files = dt.files;
                            this.$refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        this.setFile(file);
                    }
                },
                handleFileChange(e) {
                    if (e.target.files && e.target.files.length > 0) {
                        this.setFile(e.target.files[0]);
                    }
                },
                clearFile() {
                    this.fileDetails = null;
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = '';
                    }
                    $wire.set('importFile', null);
                }
             }"
             x-show="modalOpen"
             @open-import-modal-instant.window="modalOpen = true"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog" 
             aria-modal="true"
             @keydown.escape.window="closeModal()">
            
            <!-- Backdrop Transparan Kaca Buram Terang (160ms GPU opacity-only transition, static blur) -->
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
                     class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-200/90 text-left flex flex-col overflow-hidden will-change-transform">
                    
                    <!-- Header Modal Modern & Lencana Ringkas -->
                    <div class="bg-white px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Squircle Berlatar Merah Muda Lembut dengan Ikon Awan Unggah Merah Korporat -->
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#AE0C00] border border-red-200/60 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-slate-900 font-headline font-bold text-base sm:text-lg leading-tight">
                                        Import Data Massal
                                    </h3>
                                </div>
                                <p class="text-slate-500 text-xs mt-1 truncate">
                                    Unggah berkas rekonsiliasi data khusus untuk kategori <strong class="text-slate-700 font-semibold">{{ $kategori ?: 'yang sedang dibuka' }}</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- Lencana Kapsul & Tombol Penutup Silang (X) Berputar 90 Derajat -->
                        <div class="flex items-center gap-2.5 sm:gap-3 shrink-0 ml-3">
                            <button type="button" 
                                    @click="closeModal()" 
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all duration-200 hover:rotate-90 cursor-pointer focus:outline-hidden"
                                    title="Tutup Modal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body Modal: Form Split 2-Kolom & Bilah Panduan Bawah -->
                    <form wire:submit.prevent="importData" class="flex flex-col flex-1 overflow-hidden m-0">
                        <div class="p-5 sm:p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-145px)]">
                            <!-- Two Column Split Card System -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                                
                                <!-- ============================================== -->
                                <!-- KOLOM KIRI: DROPZONE INTERAKTIF               -->
                                <!-- ============================================== -->
                                <div class="flex flex-col">
                                    <label class="text-xs font-headline font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                                        <span>Area Unggah Berkas</span>
                                        <span class="text-[10px] font-normal text-slate-400">(Drag & Drop)</span>
                                    </label>
                                    
                                    <div @dragover.prevent="isDragging = true"
                                         @dragleave.prevent="isDragging = false"
                                         @drop.prevent="handleDrop($event)"
                                         @click="$refs.fileInput.click()"
                                         :class="isDragging 
                                            ? 'border-solid border-[#AE0C00] bg-[#FFF5F5] ring-2 ring-[#AE0C00]/20' 
                                            : 'border-dashed border-[1.5px] border-slate-300 hover:border-slate-400 bg-slate-50/70 hover:bg-slate-50'"
                                         class="relative h-[230px] rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-200 group select-none overflow-hidden">
                                        
                                        <!-- Hidden Native File Input (Livewire Model) -->
                                        <input type="file" 
                                               x-ref="fileInput"
                                               wire:model="importFile" 
                                               accept=".xlsx,.xls,.csv" 
                                               @change="handleFileChange($event)"
                                               class="sr-only">

                                        <!-- Squircle Ikon Tengah (Scale 1.06 saat Drag-Over) -->
                                        <div :class="isDragging ? 'scale-106 ring-4 ring-[#AE0C00]/15' : 'group-hover:scale-105'" 
                                             class="w-14 h-14 rounded-2xl bg-white shadow-2xs border border-slate-200/80 flex items-center justify-center text-[#AE0C00] mb-3 transition-transform duration-200 ease-out shrink-0">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>

                                        <!-- Teks Status Drag & Bantuan -->
                                        <p class="text-sm font-semibold transition-colors duration-150"
                                           :class="isDragging ? 'text-[#AE0C00] font-bold' : 'text-slate-800'"
                                           x-text="isDragging ? 'Lepaskan Berkas untuk Mengunggah' : 'Seret & Lepas Berkas di Sini'">
                                        </p>
                                        <p class="text-xs text-slate-500 mt-1" x-show="!isDragging">
                                            atau klik untuk memilih berkas dari perangkat
                                        </p>

                                        <!-- Lencana Teks Format Berkas -->
                                        <p class="text-[11px] text-slate-400 font-medium mt-2" x-show="!isDragging">
                                            Format didukung: <span class="font-semibold text-slate-500">.xlsx, .xls, .csv</span> (Maks. 30MB)
                                        </p>

                                        <!-- Tombol Tindakan Cepat "Pilih Berkas" -->
                                        <div class="mt-3.5" x-show="!isDragging">
                                            <button type="button" 
                                                    class="inline-flex items-center gap-1.5 h-8 px-3.5 bg-white group-hover:bg-slate-50 text-slate-700 border border-slate-200/90 rounded-xl text-xs font-headline font-semibold shadow-2xs group-hover:shadow-xs transition-all duration-150 pointer-events-none">
                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                </svg>
                                                <span>Pilih Berkas</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ============================================== -->
                                <!-- KOLOM KANAN: DAFTAR BERKAS TERPILIH           -->
                                <!-- ============================================== -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-between mb-2 h-4">
                                        <label class="text-xs font-headline font-bold text-slate-700 flex items-center gap-1">
                                            <span>Berkas Terpilih</span>
                                            <span class="text-[#AE0C00] font-bold">(<span x-text="fileDetails ? '1' : '0'"></span>)</span>
                                        </label>
                                        <button type="button" 
                                                x-show="fileDetails" 
                                                @click="clearFile()" 
                                                x-cloak
                                                class="text-[11px] font-semibold text-slate-400 hover:text-[#AE0C00] transition-colors duration-150 cursor-pointer">
                                            Hapus Semua
                                        </button>
                                    </div>

                                    <!-- Kondisi Belum Ada Berkas (Empty Queue State) -->
                                    <div x-show="!fileDetails" 
                                         class="h-[230px] rounded-2xl border border-slate-200/70 bg-slate-50/50 p-6 flex flex-col items-center justify-center text-center">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-400 mb-3 shadow-2xs">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-slate-700">Belum ada berkas yang dipilih</p>
                                        <p class="text-[11px] text-slate-400 mt-1 max-w-[210px] leading-relaxed">
                                            Berkas yang Anda pilih atau seret akan muncul di sini.
                                        </p>
                                    </div>

                                    <!-- Kondisi Berkas Terpilih (Card List) -->
                                    <div x-show="fileDetails" 
                                         x-cloak 
                                         class="h-[230px] rounded-2xl border border-slate-200/70 bg-slate-50/40 p-3.5 flex flex-col justify-start">
                                        <div class="border border-slate-200/90 bg-white rounded-2xl p-3.5 shadow-2xs hover:shadow-xs transition-all duration-200 flex items-center gap-3">
                                            <!-- Format Wadah Ikon: Excel Hijau Zamrud atau CSV Tabel Biru Lembut -->
                                            <div :class="fileDetails && fileDetails.type === 'csv' ? 'bg-sky-50 text-sky-600 border-sky-200/70' : 'bg-emerald-50 text-emerald-600 border-emerald-200/70'"
                                                 class="w-10 h-10 rounded-xl border flex items-center justify-center shrink-0 shadow-2xs">
                                                <template x-if="fileDetails && fileDetails.type === 'csv'">
                                                    <!-- Ikon Tabel CSV -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M9 4v16m6-16v16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                    </svg>
                                                </template>
                                                <template x-if="!fileDetails || fileDetails.type !== 'csv'">
                                                    <!-- Ikon Dokumen Spreadsheet Excel -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </template>
                                            </div>

                                            <!-- Nama Berkas & Ukuran Berkas -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-headline font-bold text-slate-800 truncate" 
                                                   x-text="fileDetails ? fileDetails.name : ''" 
                                                   :title="fileDetails ? fileDetails.name : ''"></p>
                                                <p class="text-[11px] text-slate-500 font-medium truncate mt-0.5" 
                                                   x-text="fileDetails ? (fileDetails.name + ' • ' + fileDetails.size) : ''"></p>
                                            </div>

                                            <!-- Tombol Hapus Berkas Individual (X) -->
                                            <button type="button" 
                                                    @click="clearFile()" 
                                                    class="w-7 h-7 rounded-full bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-[#AE0C00] flex items-center justify-center transition-colors duration-150 shrink-0 cursor-pointer" 
                                                    title="Hapus berkas ini">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Status Unggah Berkas ke Livewire Backend -->
                                        <div wire:loading wire:target="importFile" class="mt-3 px-3 py-2 bg-slate-100/80 rounded-xl border border-slate-200/80 flex items-center gap-2 text-slate-600 text-xs">
                                            <svg class="animate-spin h-3.5 w-3.5 text-[#AE0C00]" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path>
                                            </svg>
                                            <span class="text-[11px] font-medium">Mengunggah ke sistem...</span>
                                        </div>

                                        @error('importFile')
                                            <div class="mt-2.5 px-3 py-2 bg-red-50 text-red-700 text-xs font-semibold rounded-xl border border-red-200 flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-[11px]">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Bilah Panduan Bawah (Panduan Impor Sesuai Kategori Aktif) -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 flex items-start gap-3 shadow-2xs">
                                <div class="w-6 h-6 rounded-lg bg-red-50 text-[#AE0C00] border border-red-200/60 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-headline font-bold text-slate-900 leading-tight">
                                        Panduan Impor Sesuai Kategori Aktif
                                    </h4>
                                    <p class="text-[11px] text-slate-600 font-medium leading-relaxed mt-0.5">
                                        Data dari berkas yang Anda unggah hanya akan dimasukkan ke dalam kategori <span class="font-bold text-slate-800">{{ $kategori ?: 'yang sedang Anda buka' }}</span> saat ini. Lembar kerja kategori lain atau kategori yang telah dihapus akan diabaikan secara otomatis.
                                    </p>
                                </div>
                            </div>

                            <!-- Session Error Flash Message (Jika ada kendala eksekusi) -->
                            @if (session()->has('error'))
                                <div class="p-3 bg-red-50 text-red-700 text-xs font-semibold rounded-xl border border-red-200 flex items-start gap-2 shadow-2xs">
                                    <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Aksi Modal (Rata Kanan Bawah Stabil) -->
                        <div class="bg-slate-50/80 px-5 sm:px-6 py-3.5 border-t border-slate-200/80 flex items-center justify-end gap-2.5 shrink-0">
                            <button type="button" 
                                    @click="closeModal()" 
                                    class="h-9 px-4.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200/90 rounded-xl text-xs font-headline font-semibold transition-colors duration-150 shadow-2xs cursor-pointer focus:outline-hidden">
                                Batal
                            </button>
                            <button type="submit" 
                                    :disabled="!fileDetails"
                                    class="h-9 px-5 bg-[#AE0C00] hover:bg-[#900A00] active:bg-[#780800] text-white rounded-xl text-xs font-headline font-semibold shadow-xs hover:shadow-sm transition-colors duration-150 flex items-center gap-2 cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-[#AE0C00]"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="importData" class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span>Mulai Import Data</span>
                                </span>
                                <span wire:loading wire:target="importData" class="flex items-center gap-2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path>
                                    </svg>
                                    <span>Memproses Berkas...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
