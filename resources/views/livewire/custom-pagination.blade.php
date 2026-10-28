@if ($paginator->total() > 0)
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = max(1, $paginator->lastPage());
    @endphp
    <nav role="navigation" aria-label="Navigasi Halaman Compact" class="flex items-center bg-slate-50/90 p-1 rounded-xl border border-slate-200/90 shadow-2xs">
        
        <!-- Kontrol Tombol Navigasi Compact dengan Feedback Halus -->
        <div class="flex items-center gap-1 select-none">
            {{-- Tombol Lompat ke Awal (|<) --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200/60 text-slate-300 bg-slate-100/50 cursor-not-allowed" 
                      title="Halaman Pertama">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                </span>
            @else
                <button type="button" 
                        wire:click="gotoPage(1)" 
                        wire:loading.attr="disabled" 
                        wire:target="search,filterSto,filterStatus,perPage,resetFilters,setKategori,kategori,setSto,searchNode,searchSlot,searchPort,previousPage,nextPage,gotoPage"
                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:text-[#AE0C00] hover:border-red-300 hover:bg-white bg-white/90 transition shadow-2xs cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-wait" 
                        title="Halaman Pertama (1)">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                </button>
            @endif

            {{-- Tombol Sebelumnya (<) --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200/60 text-slate-300 bg-slate-100/50 cursor-not-allowed" 
                      title="Halaman Sebelumnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <button type="button" 
                        wire:click="previousPage" 
                        wire:loading.attr="disabled" 
                        wire:target="search,filterSto,filterStatus,perPage,resetFilters,setKategori,kategori,setSto,searchNode,searchSlot,searchPort,previousPage,nextPage,gotoPage"
                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:text-[#AE0C00] hover:border-red-300 hover:bg-white bg-white/90 transition shadow-2xs cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-wait" 
                        title="Halaman Sebelumnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            @endif

            {{-- Badge Status Halaman Compact (Dimensi Terkunci Tetap, Tanpa Pergeseran Tombol) --}}
            <div class="px-3 h-7 mx-0.5 flex items-center justify-center min-w-[96px] rounded-lg bg-white border border-slate-200/90 shadow-2xs font-headline text-xs font-semibold text-slate-700 select-none shrink-0">
                <div class="inline-flex items-center gap-1.5 whitespace-nowrap">
                    <!-- Spinner Berputar Rapi Tanpa Mengubah Lebar Saat Loading -->
                    <svg wire:loading 
                         wire:target="search,filterSto,filterStatus,perPage,resetFilters,setKategori,kategori,setSto,searchNode,searchSlot,searchPort,previousPage,nextPage,gotoPage" 
                         class="animate-spin w-3 h-3 text-[#AE0C00] shrink-0" 
                         fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span class="text-slate-400 font-sans text-[11px]">Hal.</span>
                    <span class="font-mono font-bold text-[#AE0C00] tabular-nums">{{ $currentPage }}</span>
                    <span class="text-slate-300 font-light">/</span>
                    <span class="font-mono font-bold text-slate-700 tabular-nums">{{ $lastPage }}</span>
                </div>
            </div>

            {{-- Tombol Selanjutnya (>) --}}
            @if ($paginator->hasMorePages())
                <button type="button" 
                        wire:click="nextPage" 
                        wire:loading.attr="disabled" 
                        wire:target="search,filterSto,filterStatus,perPage,resetFilters,setKategori,kategori,setSto,searchNode,searchSlot,searchPort,previousPage,nextPage,gotoPage"
                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:text-[#AE0C00] hover:border-red-300 hover:bg-white bg-white/90 transition shadow-2xs cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-wait" 
                        title="Halaman Selanjutnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/></svg>
                </button>
            @else
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200/60 text-slate-300 bg-slate-100/50 cursor-not-allowed" 
                      title="Halaman Selanjutnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif

            {{-- Tombol Lompat ke Akhir (>|) --}}
            @if ($paginator->hasMorePages())
                <button type="button" 
                        wire:click="gotoPage({{ $lastPage }})" 
                        wire:loading.attr="disabled" 
                        wire:target="search,filterSto,filterStatus,perPage,resetFilters,setKategori,kategori,setSto,searchNode,searchSlot,searchPort,previousPage,nextPage,gotoPage"
                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:text-[#AE0C00] hover:border-red-300 hover:bg-white bg-white/90 transition shadow-2xs cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-wait" 
                        title="Halaman Terakhir ({{ $lastPage }})">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </button>
            @else
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200/60 text-slate-300 bg-slate-100/50 cursor-not-allowed" 
                      title="Halaman Terakhir">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

    </nav>
@endif

