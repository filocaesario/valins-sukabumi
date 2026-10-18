<div>
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

    <!-- Splide Slider: Widget Statistik Dashboard -->
    <div wire:ignore 
         wire:key="widget-stats-{{ $stats['total'] }}-{{ $stats['done'] }}-{{ $stats['otb'] }}-{{ $stats['disconnected'] }}"
         class="splide mb-4 sm:mb-6 mt-1 sm:mt-2" 
         x-data 
         x-init="new Splide($el, {
            type: 'loop',
            perPage: 3,
            gap: '1.25rem',
            pagination: false,
            arrows: false,
            autoplay: true,
            interval: 2800,
            pauseOnHover: true,
            drag: true,
            breakpoints: { 
                640: { perPage: 1, gap: '0.75rem', padding: { right: '1.75rem' } },
                1024: { perPage: 2, gap: '1rem' } 
            }
        }).mount()">
        <div class="splide__track cursor-grab active:cursor-grabbing">
            <ul class="splide__list">
                <!-- Total Data -->
                <li class="splide__slide">
                    <div class="bg-white rounded-xl shadow-xs border-l-4 border-gray-800 p-4 sm:p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Seluruh Data</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-0.5">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="bg-gray-100 p-2.5 sm:p-3 rounded-xl text-gray-800 shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        </div>
                    </div>
                </li>
                <!-- Status DONE -->
                <li class="splide__slide">
                    <div class="bg-white rounded-xl shadow-xs border-l-4 border-green-500 p-4 sm:p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide">Status Lurus (DONE)</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-green-600 mt-0.5">{{ $stats['done'] }}</h3>
                        </div>
                        <div class="bg-green-100 p-2.5 sm:p-3 rounded-xl text-green-600 shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </li>
                <!-- Status OTB -->
                <li class="splide__slide">
                    <div class="bg-white rounded-xl shadow-xs border-l-4 border-yellow-500 p-4 sm:p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide">Kendala OTB</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-yellow-600 mt-0.5">{{ $stats['otb'] }}</h3>
                        </div>
                        <div class="bg-yellow-100 p-2.5 sm:p-3 rounded-xl text-yellow-600 shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </li>
                <!-- Disconnected -->
                <li class="splide__slide">
                    <div class="bg-white rounded-xl shadow-xs border-l-4 border-red-500 p-4 sm:p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wide">Disconnected</p>
                            <h3 class="text-2xl sm:text-3xl font-bold text-red-600 mt-0.5">{{ $stats['disconnected'] }}</h3>
                        </div>
                        <div class="bg-red-100 p-2.5 sm:p-3 rounded-xl text-red-600 shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Header Tabs & Tombol Kelola -->
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center border-b-2 border-gray-200 mb-5 sm:mb-6 gap-3 sm:gap-4">
        <div class="flex items-center space-x-4 sm:space-x-6 font-semibold text-xs sm:text-sm overflow-x-auto whitespace-nowrap pt-1 pb-2 scroll-smooth"
             style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($categories as $cat)
                <button wire:click="setKategori('{{ $cat->nama_kategori }}')" 
                        class="pb-2 transition-all shrink-0 {{ ($kategori == $cat->nama_kategori && empty($search)) ? 'text-red-600 border-b-2 border-red-600 font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                    {{ $cat->nama_kategori }}
                </button>
            @endforeach
        </div>

        <button x-data @click="$dispatch('buka-modal-kategori')" 
                class="mb-2 sm:mb-0 shrink-0 bg-gray-800 hover:bg-gray-900 active:bg-black text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Kelola Kategori</span>
        </button>
    </div>

    <!-- Modal Kelola Kategori -->
    @livewire('category-manager')

    <!-- Banner Notifikasi Saat Pencarian Aktif -->
    @if(!empty($search))
        <div class="mb-4 sm:mb-5 px-3.5 sm:px-4 py-2.5 bg-gradient-to-r from-red-50 via-rose-50 to-white border border-red-200/80 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5 shadow-xs">
            <div class="flex items-center gap-2 text-xs text-red-900 flex-wrap">
                <span class="flex h-2 w-2 relative shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                </span>
                <span class="leading-relaxed">
                    Pencarian data: 
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-100 text-red-800 font-bold border border-red-200 break-all">
                        "{{ $search }}"
                    </span>
                    <span class="text-gray-500 font-normal">({{ $data->total() }} ditemukan)</span>
                </span>
            </div>
            
            <button wire:click="$set('search', '')" 
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold shadow-xs hover:border-red-300 transition-all duration-150 w-full sm:w-auto shrink-0">
                <span>Reset Pencarian</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- PANEL PENCARIAN & TOMBOL AKSI -->
    <div class="bg-white p-3.5 sm:p-4 rounded-xl shadow-xs mb-5 sm:mb-6 border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4"
         x-data
         @keydown.window.slash.prevent="if($event.target.tagName !== 'INPUT' && $event.target.tagName !== 'TEXTAREA') { $refs.searchInput.focus(); }"
         @keydown.window.cmd.k.prevent="$refs.searchInput.focus()"
         @keydown.window.ctrl.k.prevent="$refs.searchInput.focus()">
        
        <!-- Search Box -->
        <div class="relative w-full md:w-1/2 lg:w-5/12 group">
            <div wire:loading.class="hidden" wire:target="search" class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 group-focus-within:text-red-500 transition-colors">
                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
            </div>

            <div wire:loading.flex wire:target="search" class="absolute inset-y-0 left-0 items-center pl-3.5 hidden">
                <svg class="animate-spin h-4 w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <input x-ref="searchInput"
                   type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Cari ONU SN, No Inet, ODP, IP..."
                   class="w-full bg-gray-50 hover:bg-white focus:bg-white text-gray-800 placeholder-gray-400 text-xs sm:text-sm pl-9 sm:pl-10 pr-16 sm:pr-24 py-2 sm:py-2.5 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 outline-none shadow-xs">

            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:pr-2.5 gap-1.5">
                @if(!empty($search))
                    <button type="button"
                            wire:click="$set('search', '')"
                            title="Bersihkan input"
                            class="p-1 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                @else
                    <div class="hidden sm:flex items-center gap-1 text-[10px] font-semibold text-gray-400 select-none">
                        <kbd class="px-1.5 py-0.5 bg-white border border-gray-200 rounded shadow-2xs">Ctrl</kbd>
                        <span>+</span>
                        <kbd class="px-1.5 py-0.5 bg-white border border-gray-200 rounded shadow-2xs">K</kbd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tombol Aksi di Kanan (Grid di mobile, flex di desktop) -->
        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center justify-between md:justify-end w-full md:w-auto gap-2 sm:gap-2.5">
            <!-- Badge Total Data -->
            <div class="col-span-2 sm:col-span-1 text-xs sm:text-sm font-medium bg-gray-50 px-3 py-2 rounded-xl border border-gray-200 shadow-xs relative overflow-hidden flex items-center justify-center sm:justify-start gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                <div wire:loading.class="opacity-0" wire:target="search" class="transition-opacity duration-200 text-gray-600 text-xs">
                    Total: <strong class="text-gray-800 font-bold">{{ $data->total() }}</strong>
                </div>
                <div wire:loading.flex wire:target="search" class="absolute inset-0 bg-red-50 items-center justify-center text-red-600 hidden font-bold text-xs">
                    <span class="animate-pulse">Memuat...</span>
                </div>
            </div>

            <!-- Tombol Import Data -->
            <button wire:click="openImportModal" 
                    class="group inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-3 sm:px-3.5 py-2 rounded-xl text-xs font-bold shadow-xs hover:shadow transition-all duration-150">
                <svg class="w-4 h-4 text-blue-100 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>Import Data</span>
            </button>

            <!-- DROPDOWN EXPORT (EXCEL & PDF) -->
            <div class="relative inline-block text-left" x-data="{ open: false }">
                <button type="button" 
                        @click="open = !open" 
                        wire:loading.attr="disabled" 
                        wire:target="exportPDF, exportExcel"
                        class="w-full inline-flex items-center justify-center gap-2 px-3.5 sm:px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 active:bg-black text-white text-xs font-semibold rounded-xl shadow-xs border border-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 transition-all duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    <svg wire:loading.remove wire:target="exportPDF, exportExcel" class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>

                    <svg wire:loading wire:target="exportPDF, exportExcel" class="w-4 h-4 animate-spin text-white shrink-0" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>

                    <span wire:loading.remove wire:target="exportPDF, exportExcel">Export</span>
                    <span wire:loading wire:target="exportPDF">PDF...</span>
                    <span wire:loading wire:target="exportExcel">Excel...</span>

                    <svg wire:loading.remove wire:target="exportPDF, exportExcel" 
                         class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="{ 'rotate-180': open }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Menu Pilihan Dropdown -->
                <div x-show="open" 
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     x-cloak
                     class="absolute right-0 z-50 mt-2 w-52 rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 border border-gray-100 overflow-hidden focus:outline-none">
                    
                    <div class="py-1.5">
                        <button type="button" 
                                wire:click="exportExcel" 
                                @click="open = false" 
                                wire:loading.attr="disabled"
                                class="w-full group flex items-center gap-3 px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition text-left">
                            <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            <div>
                                <span class="font-bold block text-gray-800 group-hover:text-emerald-700">Export ke Excel</span>
                                <span class="text-[10px] text-gray-400 block">Format spreadsheet .csv</span>
                            </div>
                        </button>

                        <button type="button" 
                                wire:click="exportPDF" 
                                @click="open = false" 
                                wire:loading.attr="disabled"
                                class="w-full group flex items-center gap-3 px-4 py-2.5 text-xs text-gray-700 hover:bg-red-50 hover:text-red-700 transition text-left">
                            <span class="p-1.5 rounded-lg bg-red-100 text-red-600 group-hover:bg-red-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <div>
                                <span class="font-bold block text-gray-800 group-hover:text-red-700">Export ke PDF</span>
                                <span class="text-[10px] text-gray-400 block">Format dokumen Legal</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions (Muncul jika ada baris yang dipilih) -->
    @if(count($selectedRows) > 0)
    @php
        $tersediaDipilih = $totalSelectable ?? $data->total();
        $sedangDikunciOrangLain = $data->total() - $tersediaDipilih;
    @endphp

    <div class="bg-gray-900 text-white p-3 sm:p-4 mb-4 rounded-xl shadow-lg flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 transition-all animate-fadeIn">
        <div class="flex items-center flex-wrap gap-2 sm:gap-3 text-xs sm:text-sm">
            <span class="bg-white text-gray-900 px-2.5 py-0.5 rounded-full text-xs font-extrabold shadow-inner transition-all">
                {{ count($selectedRows) }}
            </span>
            <span class="font-semibold text-gray-200">baris dipilih</span>
            <button type="button" wire:click="clearSelection" class="text-gray-400 hover:text-white text-xs underline ml-1">Batalkan</button>

            <!-- Tombol Pilih Semua -->
            @if(count($selectedRows) < $tersediaDipilih && $tersediaDipilih > 0)
                <span class="text-gray-600 hidden sm:inline ml-1">|</span>
                <button type="button" 
                        wire:click="selectAllMatching" 
                        wire:loading.attr="disabled"
                        class="text-blue-400 hover:text-blue-300 text-xs font-bold underline transition-colors flex items-center gap-1.5 w-full sm:w-auto mt-1 sm:mt-0">
                    <span wire:loading.remove wire:target="selectAllMatching" class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Pilih seluruh {{ $tersediaDipilih }} data
                        @if($sedangDikunciOrangLain > 0)
                            <span class="text-gray-400 font-normal">({{ $sedangDikunciOrangLain }} dikunci)</span>
                        @endif
                    </span>
                    <span wire:loading wire:target="selectAllMatching" class="flex items-center gap-1 text-gray-400">
                        <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path></svg>
                        Memilih...
                    </span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-3 sm:flex sm:flex-wrap items-center gap-2">
            <div x-data="{ open: false }" class="relative w-full sm:w-auto">
                <button type="button" @click="open = !open" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold py-2 px-2.5 sm:px-4 rounded-lg shadow-xs flex items-center justify-center gap-1 sm:gap-2">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="truncate">Status</span>
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" @click.outside="open = false" x-transition class="absolute left-0 sm:left-auto sm:right-0 mt-1 w-48 sm:w-52 bg-white rounded-lg shadow-xl border border-gray-200 z-50 overflow-hidden">
                    <button type="button" wire:click="bulkChangeStatus('DONE'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> DONE
                    </button>
                    <button type="button" wire:click="bulkChangeStatus('OTB'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-800 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span> OTB
                    </button>
                    <button type="button" wire:click="bulkChangeStatus('DONE OLO'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> DONE OLO
                    </button>
                    <button type="button" wire:click="bulkChangeStatus('Disconnected'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-red-50 hover:text-red-800 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-600"></span> Disconnected
                    </button>
                    <hr class="border-gray-100">
                    <button type="button" wire:click="bulkChangeStatus('KENDALA BI'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-gray-100 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gray-500"></span> KENDALA BI
                    </button>
                    <button type="button" wire:click="bulkChangeStatus('WITEL LAIN'); open = false" class="w-full text-left px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-gray-100 font-semibold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gray-500"></span> WITEL LAIN
                    </button>
                </div>
            </div>

            <button type="button" wire:click="openBulkEdit" class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs sm:text-sm font-bold py-2 px-2.5 sm:px-4 rounded-lg shadow-xs flex items-center justify-center gap-1 sm:gap-2">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Edit</span>
            </button>

            <button type="button" wire:click="bulkDelete" wire:confirm="PERINGATAN: Anda akan menghapus {{ count($selectedRows) }} data secara permanen! Tindakan ini tidak dapat dibatalkan. Lanjutkan?" class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-xs sm:text-sm font-bold py-2 px-2.5 sm:px-4 rounded-lg shadow-xs flex items-center justify-center gap-1 sm:gap-2">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Hapus</span>
            </button>
        </div>
    </div>
    @endif

    <!-- TABEL UTAMA -->
    <div class="w-full bg-white rounded-xl shadow-xs border border-gray-200 overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
        <table class="min-w-full leading-normal whitespace-nowrap text-xs sm:text-sm">
            <thead>
                <tr class="bg-gray-800 text-white text-[11px] sm:text-xs uppercase tracking-wider">
                    <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold w-10 sm:w-12">
                        <input type="checkbox" 
                               id="masterCheckbox"
                               x-data 
                               @clear-checkboxes.window="$el.checked = false; document.querySelectorAll('.row-checkbox').forEach(el => el.checked = false);"
                               x-on:change="$event.target.checked ? document.querySelectorAll('.row-checkbox').forEach(el => { if(!el.checked) el.click() }) : document.querySelectorAll('.row-checkbox').forEach(el => { if(el.checked) el.click() })" 
                               class="rounded border-gray-500 bg-gray-700 text-red-500 focus:ring-red-500 cursor-pointer shadow-inner transition-all">
                    </th>

                    @if(!empty($activeCategory) && !empty($activeCategory->konfigurasi_kolom))
                        @foreach($activeCategory->konfigurasi_kolom as $kolom)
                            @if(empty($kolom['hidden']) && !in_array(strtoupper(trim($kolom['nama'])), ['KETERANGAN', 'TANGGAL', 'PIC']))
                                <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">{{ $kolom['nama'] }}</th>
                            @endif
                        @endforeach
                    @else
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">TREG</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">WITEL</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">STO</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">ODP NAME</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">PANEL ODP</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">PORT ODP</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">VALINS ID</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">NODE ID</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">NODE IP</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">SLOT</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">PORT</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">ONU SN</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">NO INET VALINS</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">SIP 1 VALINS</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">SIP 2 VALINS</th>
                        <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">SID</th>
                    @endif

                    <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold">KETERANGAN</th>
                    <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">TANGGAL</th>
                    <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-left font-semibold">PIC</th>
                    <th class="px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-center font-semibold sticky right-0 bg-gray-900 shadow-md z-20">AKSI</th>
                </tr>
            </thead>
            
            <tbody wire:poll.6s>
                @forelse ($data as $item)
                @php
                    $currentUser = auth()->check() ? auth()->user()->name : 'System';
                    $lockedByName = explode('|', $item->locked_by ?? '')[0];
                    $namaPendek = explode(' ', $lockedByName)[0];

                    // Kunci dianggap milik orang lain jika namanya berbeda dan tidak kosong
                    $isLockedByOther = !empty($item->locked_by) && $lockedByName !== $currentUser;
                    $isLockedByMe = in_array($item->id, $selectedRows);
                @endphp

                <tr wire:key="row-{{ $item->id }}-{{ $item->locked_by ?? 'unlocked' }}-{{ $item->updated_at?->timestamp }}" 
                    class="border-b border-gray-100 transition-colors {{ $isLockedByMe ? 'bg-red-50' : ($isLockedByOther ? 'bg-orange-50/70' : 'hover:bg-red-50') }}">

                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-center align-middle w-10 sm:w-12">
                        @if($isLockedByOther)
                            <div class="flex items-center justify-center cursor-not-allowed group" title="Sedang diproses oleh {{ $item->locked_by }}">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 opacity-70 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a5 5 0 0 1 5 5v3h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v3h6V7a3 3 0 0 0-3-3z"/></svg>
                            </div>
                        @else
                            <input type="checkbox" wire:model.live="selectedRows" value="{{ $item->id }}" class="row-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer shadow-sm">
                        @endif
                    </td>

                    @if(!empty($activeCategory) && !empty($activeCategory->konfigurasi_kolom))
                        @foreach($activeCategory->konfigurasi_kolom as $kolom)
                            @if(empty($kolom['hidden']) && !in_array(strtoupper(trim($kolom['nama'])), ['KETERANGAN', 'TANGGAL', 'PIC']))
                                @php
                                    $namaKolom = $kolom['nama'];
                                    $normK = strtoupper(preg_replace('/[^A-Z0-9]/', '', $namaKolom));
                                    $propMap = [
                                        'TREG' => 'treg', 'WITEL' => 'witel', 'STO' => 'sto',
                                        'ODPNAME' => 'odp_name', 'PANELODP' => 'panel_o', 'PORTODP' => 'port_od',
                                        'VALINSID' => 'valins_id', 'NODEID' => 'node_id', 'NODEIP' => 'node_ip',
                                        'SLOT' => 'slot', 'PORT' => 'port', 'ONUSN' => 'onu_sn',
                                        'NOINETVALINS' => 'no_inet_valins', 'SIP1VALINS' => 'sip1_valins',
                                        'SIP2VALINS' => 'sip2_valins', 'SID' => 'sid',
                                    ];
                                    $prop = $propMap[$normK] ?? strtolower(str_replace(' ', '_', $namaKolom));
                                    $nilai = '-';

                                    if (isset($item->{$prop}) && $item->{$prop} !== null && $item->{$prop} !== '') {
                                        $nilai = $item->{$prop};
                                    }

                                    if ($nilai === '-') {
                                        $dyn = is_array($item->dynamic_data) 
                                            ? $item->dynamic_data 
                                            : (is_string($item->dynamic_data) ? json_decode($item->dynamic_data, true) : []);

                                        if (is_array($dyn)) {
                                            if (isset($dyn[$namaKolom]) && $dyn[$namaKolom] !== null && $dyn[$namaKolom] !== '') {
                                                $nilai = $dyn[$namaKolom];
                                            } else {
                                                foreach ($dyn as $k => $v) {
                                                    if ($v !== null && $v !== '' && strtoupper(preg_replace('/[^A-Z0-9]/', '', $k)) === $normK) {
                                                        $nilai = $v;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $nilai }}</td>
                            @endif
                        @endforeach
                    @else
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center text-gray-900 align-middle">{{ $item->treg ?? '3' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->witel ?? 'SUKABUMI' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-gray-900 align-middle">{{ $item->sto }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-blue-700 font-semibold align-middle">{{ $item->odp_name }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center text-gray-900 align-middle">{{ $item->panel_odp ?? $item->panel_o ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center text-gray-900 align-middle">{{ $item->port_odp ?? $item->port_od ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->valins_id ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-600 align-middle">{{ $item->node_id ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 font-medium align-middle">{{ $item->node_ip ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center text-gray-900 align-middle">{{ $item->slot ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center text-gray-900 align-middle">{{ $item->port ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->onu_sn ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->no_inet_valins ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->sip1_valins ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->sip2_valins ?? '-' }}</td>
                        <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->sid ?? '-' }}</td>
                    @endif

                    <!-- Kolom Keterangan / Status -->
                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center align-middle">
                        <div class="flex flex-col items-center justify-center gap-1.5">
                            <div>
                                @if($item->keterangan == 'DONE' || $item->keterangan == 'DONE OLO')
                                    <span class="bg-green-100 text-green-800 py-0.5 sm:py-1 px-2.5 sm:px-3 rounded-full text-[10px] sm:text-xs font-bold border border-green-300">{{ $item->keterangan }}</span>
                                @elseif($item->keterangan == 'OTB')
                                    <span class="bg-yellow-100 text-yellow-800 py-0.5 sm:py-1 px-2.5 sm:px-3 rounded-full text-[10px] sm:text-xs font-bold border border-yellow-300">OTB</span>
                                @elseif($item->keterangan == 'Disconnected')
                                    <span class="bg-red-100 text-red-800 py-0.5 sm:py-1 px-2.5 sm:px-3 rounded-full text-[10px] sm:text-xs font-bold border border-red-300">DISCONNECTED</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 py-0.5 sm:py-1 px-2.5 sm:px-3 rounded-full text-[10px] sm:text-xs font-bold border border-gray-300">{{ $item->keterangan ?? 'NO STATUS' }}</span>
                                @endif
                            </div>

                            @if(!empty($item->update_progress))
                                <div class="text-[10px] sm:text-[11px] text-left bg-blue-50 text-blue-800 p-1.5 sm:p-2 rounded-md border border-blue-200 whitespace-normal w-40 sm:w-48 shadow-2xs leading-snug mt-0.5">
                                    <strong class="block text-blue-900 mb-0.5">Update:</strong>
                                    {{ $item->update_progress }}
                                </div>
                            @endif

                            @if($isLockedByOther)
                                <div class="mt-0.5 flex items-center justify-center gap-1 text-[9px] sm:text-[10px] text-orange-800 bg-orange-100 border border-orange-300 px-2 py-0.5 rounded shadow-2xs font-bold animate-pulse">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Diproses: {{ explode(' ', $item->locked_by)[0] }}
                                </div>
                            @endif

                            @if(!empty($item->updated_by) && $item->updated_at && !$isLockedByOther)
                                <div class="mt-0.5 flex items-center justify-center gap-1 text-[9px] sm:text-[10px] text-gray-400 font-medium hover:text-blue-600 transition-colors cursor-help"
                                     title="Diupdate oleh {{ $item->updated_by }} pada {{ $item->updated_at->format('d M Y, H:i') }}"
                                     x-data="{ 
                                         timeAgo: '', 
                                         updateTime() {
                                             const diff = Math.floor((new Date().getTime() - {{ $item->updated_at->timestamp * 1000 }}) / 1000);
                                             if (diff < 60) this.timeAgo = 'Baru saja';
                                             else if (diff < 3600) this.timeAgo = Math.floor(diff / 60) + ' mnt lalu';
                                             else if (diff < 86400) this.timeAgo = Math.floor(diff / 3600) + ' jam lalu';
                                             else this.timeAgo = Math.floor(diff / 86400) + ' hr lalu';
                                         }
                                     }"
                                     x-init="updateTime(); setInterval(() => updateTime(), 60000);"
                                >
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    <span class="truncate max-w-[100px] sm:max-w-[120px]">
                                        {{ explode(' ', $item->updated_by)[0] }} &bull; <span x-text="timeAgo"></span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Tanggal & PIC -->
                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td>
                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-900 align-middle">{{ $item->pic ?? '-' }}</td>

                    <!-- Kolom Aksi -->
                    <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-center align-middle sticky right-0 bg-white group-hover:bg-red-50 transition-colors border-l shadow-[-5px_0_10px_-5px_rgba(0,0,0,0.1)] z-10">
                        <div class="flex justify-center items-center space-x-2.5 sm:space-x-3">
                            @if($isLockedByOther)
                                <span class="text-gray-300 cursor-not-allowed select-none" title="Tidak dapat diedit: Sedang diproses oleh {{ $item->locked_by }}">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </span>
                                <span class="text-gray-300 cursor-not-allowed select-none" title="Tidak dapat dihapus: Sedang diproses oleh {{ $item->locked_by }}">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </span>
                            @else
                                <a href="{{ route('valins.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 transition transform hover:scale-110" title="Edit Data">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>
                                <button type="button" wire:click="hapusData({{ $item->id }})" wire:confirm="Yakin ingin menghapus data ini secara permanen?" class="text-red-500 hover:text-red-700 transition transform hover:scale-110" title="Hapus Data">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100%" class="px-4 py-12 text-center text-gray-500 bg-gray-50">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm sm:text-base font-medium text-gray-600">
                                {{ !empty($search) ? 'Tidak ada data yang cocok dengan pencarian "' . $search . '".' : 'Tidak ada data ditemukan di kategori ini.' }}
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 mb-6 sm:mb-8 px-1 sm:px-0">
        {{ $data->links() }}
    </div>

    <!-- Modal Edit Massal -->
    @if($bulkEditOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black bg-opacity-60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden animate-fadeIn">
            <div class="bg-indigo-700 px-4 sm:px-6 py-3.5 sm:py-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="bg-indigo-500 p-1.5 sm:p-2 rounded-lg text-white shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-base sm:text-lg">Edit Data</h3>
                        <p class="text-indigo-200 text-[11px] sm:text-xs">
                            {{ count($selectedRows) === 1 ? 'Mengedit 1 data yang dipilih' : 'Mengedit ' . count($selectedRows) . ' data sekaligus' }}
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="closeBulkEdit" class="text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="bg-indigo-50 border-b border-indigo-100 px-4 sm:px-6 py-2.5 sm:py-3 flex items-start gap-2 shrink-0">
                <svg class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @if(count($selectedRows) === 1)
                    <p class="text-xs text-indigo-700 font-medium">Data saat ini telah dimuat. Sesuaikan nilai kolom di bawah lalu klik <strong>Simpan Perubahan</strong>.</p>
                @else
                    <p class="text-xs text-indigo-700 font-medium">Hanya field yang diisi yang akan diperbarui untuk {{ count($selectedRows) }} data terpilih.</p>
                @endif
            </div>

            <div class="px-4 sm:px-6 py-4 space-y-3.5 sm:space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1">Keterangan / Status</label>
                    <input type="text" 
                           wire:model="bulkEditKeterangan" 
                           list="bulk_status_options" 
                           placeholder="{{ count($selectedRows) === 1 ? 'Pilih atau ketik status...' : 'Kosongkan jika tidak ingin mengubah status...' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 sm:py-2.5 text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition shadow-xs">
                    <datalist id="bulk_status_options">
                        <option value="DONE">
                        <option value="OTB">
                        <option value="DONE OLO">
                        <option value="Disconnected">
                        <option value="ODP TIDAK DITEMUKAN">
                        <option value="DATEK TIDAK SAMA">
                        <option value="KENDALA BI">
                        <option value="TIDAK ADA ODP DI UIM">
                        <option value="WITEL LAIN">
                    </datalist>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1">PIC (Penanggung Jawab)</label>
                    <input type="text" 
                           wire:model="bulkEditPic" 
                           placeholder="Contoh: FIRDI / LIANTY"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 sm:py-2.5 text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition shadow-xs">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" 
                           wire:model="bulkEditTanggal"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 sm:py-2.5 text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition shadow-xs">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1">Update / Keterangan Progress</label>
                    <textarea wire:model="bulkEditUpdateProgress" 
                              rows="3" 
                              placeholder="Catatan update atau keterangan progress..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 sm:py-2.5 text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition shadow-xs resize-none"></textarea>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center shrink-0">
                <button type="button" wire:click="closeBulkEdit" class="text-gray-600 hover:text-gray-800 font-semibold text-xs sm:text-sm px-3.5 sm:px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition">Batal</button>
                <button type="button" wire:click="saveBulkEdit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs sm:text-sm py-2 px-4 sm:px-6 rounded-lg shadow-xs flex items-center gap-2 transition">
                    <svg wire:loading wire:target="saveBulkEdit" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL IMPORT DATA -->
    @if($importModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black bg-opacity-60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden animate-fadeIn">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-4 sm:px-6 py-3.5 sm:py-4 flex justify-between items-center text-white shrink-0">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="bg-white/20 p-2 sm:p-2.5 rounded-xl backdrop-blur-md shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold">Import Data (Excel / CSV)</h3>
                        <p class="text-blue-100 text-[11px] sm:text-xs">Tambahkan data massal ke kategori masing-masing</p>
                    </div>
                </div>
                <button type="button" wire:click="closeImportModal" class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-4 sm:p-6 space-y-3.5 sm:space-y-4 overflow-y-auto flex-1">
                <div class="bg-blue-50 text-blue-900 p-3 sm:p-3.5 rounded-xl border border-blue-200/80 text-xs shadow-2xs space-y-1.5">
                    <div class="font-bold flex items-center gap-1.5 text-blue-800">
                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Ketentuan Import Cerdas:</span>
                    </div>
                    <ul class="list-disc ml-5 space-y-1 text-gray-700 text-[11px] sm:text-xs">
                        <li>Mendukung file langsung <strong>.xlsx</strong>, <strong>.xls</strong>, maupun <strong>.csv</strong>.</li>
                        <li>File multi-sheet Telkom akan dipindai dan didistribusikan ke tab kategori masing-masing secara otomatis.</li>
                        <li>Rumus / formula Excel akan dilewati secara aman tanpa menyebabkan error.</li>
                    </ul>
                </div>

                <form wire:submit.prevent="importData">
                    <div class="border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-2xl p-4 sm:p-6 flex flex-col items-center justify-center bg-gray-50/50 hover:bg-blue-50/30 transition relative cursor-pointer group">
                        <input type="file" 
                               wire:model="importFile" 
                               accept=".xlsx,.xls,.csv" 
                               id="fileUpload" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div class="p-2.5 sm:p-3 bg-white rounded-full shadow-2xs border border-gray-200 text-blue-600 group-hover:scale-110 transition-transform mb-2">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        
                        <p class="text-xs sm:text-sm font-bold text-gray-800 text-center">Klik untuk memilih atau tarik file Excel / CSV ke sini</p>
                        
                        @if($importFile)
                            <div class="text-xs text-emerald-700 font-bold mt-2.5 flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg shadow-2xs max-w-full truncate">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span class="truncate">File siap: {{ $importFile->getClientOriginalName() }}</span>
                            </div>
                        @else
                            <p class="text-[10px] sm:text-[11px] text-gray-500 mt-1">Format didukung: <strong>.xlsx</strong>, <strong>.xls</strong>, <strong>.csv</strong> (Maks. 30MB)</p>
                        @endif
                    </div>
                    @error('importFile') <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> @enderror

                    @if (session()->has('error'))
                        <div class="mt-3 p-2.5 sm:p-3 bg-red-50 text-red-700 text-xs font-semibold rounded-xl border border-red-200 flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-end gap-2 mt-4 sm:mt-6 border-t pt-3 sm:pt-4">
                        <button type="button" wire:click="closeImportModal" class="px-3.5 sm:px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl shadow-2xs hover:bg-gray-50 transition text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 sm:px-5 py-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl shadow-xs transition text-xs font-bold flex items-center gap-2" 
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="importData">Mulai Import Data</span>
                            <span wire:loading wire:target="importData" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4"></path></svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
