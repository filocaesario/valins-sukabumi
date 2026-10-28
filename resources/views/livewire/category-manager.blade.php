<div x-data="{ open: false }" 
     @buka-modal-kategori.window="open = true" 
     @tutup-modal-kategori.window="open = false">
    
    <!-- Modal Backdrop: Kaca Buram Terang (Light Frosted Glass — Bebas Latar Hitam Pekat) -->
    <div x-show="open" 
         x-transition.opacity.duration.200ms
         class="fixed inset-0 bg-slate-900/[0.12] backdrop-blur-md z-40 transition-opacity"
         style="display: none;">
    </div>

    <!-- Gaya Keyframes Animasi Transisi Halus (Slide & Fade Bebas Gerakan Kaget) -->
    <style>
        @keyframes cmSlideInRight {
            from { opacity: 0; transform: translateX(18px); }
            to { opacity: 1; transform: none; }
        }
        @keyframes cmSlideInLeft {
            from { opacity: 0; transform: translateX(-18px); }
            to { opacity: 1; transform: none; }
        }
        @keyframes cmRowAppear {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: none; }
        }
        .cm-anim-slide-right { animation: cmSlideInRight 0.22s cubic-bezier(0.16, 1, 0.3, 1); }
        .cm-anim-slide-left { animation: cmSlideInLeft 0.22s cubic-bezier(0.16, 1, 0.3, 1); }
        .cm-anim-row-appear { animation: cmRowAppear 0.2s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>

    <!-- Modal Box: Bingkai Perak Halus, Tinggi Terkunci Stabil (Anti-Loncat), & Floating Elevation Shadow -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-250 transform"
         x-transition:enter-start="opacity-0 translate-y-3 sm:scale-[0.98]"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-150 transform"
         x-transition:leave-start="opacity-100 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-3 sm:scale-[0.98]"
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
         
        <div class="bg-white rounded-2xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.18),0_0_1px_1px_rgba(0,0,0,0.05)] border border-slate-200/90 overflow-hidden w-full max-w-3xl flex flex-col h-[620px] sm:h-[660px] max-h-[92vh]">
            
            <!-- Modal Header (Tinggi & Tata Letak Terkunci Stabil) -->
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50/80 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Wadah persegi membulat berlatar merah muda lembut dengan ikon merah korporat -->
                    <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-headline font-bold text-slate-800">
                            {{ $mode === 'list' ? 'Kelola Kategori & Kolom' : ($isEditing ? 'Ubah Kategori: ' . $nama_kategori : 'Tambah Kategori Baru') }}
                        </h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-sans">
                            {{ $mode === 'list' ? 'Tahan & geser kategori dengan kursor untuk memindahkan posisinya' : 'Atur nama kategori dan sesuaikan kolom data yang aktif' }}
                        </p>
                    </div>
                </div>
                <!-- Tombol silang penutup (X) berbingkai membulat halus -->
                <button @click="open = false" 
                        class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200/70 flex items-center justify-center transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Notifikasi Modal -->
            @if (session()->has('success_modal'))
                <div class="mx-4 sm:mx-6 mt-3 sm:mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2 shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success_modal') }}</span>
                </div>
            @endif

            <!-- Modal Content (Scrollable & Tinggi Terkunci Stabil) -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 overflow-y-auto flex-1 custom-scrollbar min-h-0">
                
                <!-- MODE 1: DAFTAR KATEGORI (KARTU MANDIRI MODERN, DRAG PLACEHOLDER ANTI-TABRAKAN, & KONFIRMASI INLINE) -->
                @if($mode === 'list')
                    <div class="cm-anim-slide-left space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2.5">
                            <span class="text-xs font-headline font-bold uppercase text-slate-600 tracking-wider flex items-center gap-1.5 select-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                Urutan Tab Kategori
                            </span>
                            <button wire:click="bukaTambah" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 h-9 px-3.5 rounded-xl text-xs font-headline font-bold bg-[#AE0C00] hover:bg-[#8E0A00] active:bg-[#730800] text-white shadow-2xs hover:shadow-xs transition-all duration-150 cursor-pointer select-none">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path></svg>
                                <span>Tambah Kategori Baru</span>
                            </button>
                        </div>

                        <!-- Alpine Drag and Drop Container (Bebas Tabrakan, Background Solid 100%, Placeholder Halus) -->
                        <div class="space-y-3"
                             x-data="{
                                 draggedIdx: null,
                                 dragOverIdx: null,
                                 dropPosition: 'before',
                                 items: {{ json_encode($daftarKategori->pluck('id')) }},
                                 onDragStart(e, idx) {
                                     this.draggedIdx = idx;
                                     e.dataTransfer.effectAllowed = 'move';
                                     e.dataTransfer.setData('text/plain', idx);
                                 },
                                 onDragOver(e, idx) {
                                     e.preventDefault();
                                     if (this.draggedIdx === null || this.draggedIdx === idx) {
                                         this.dragOverIdx = null;
                                         return;
                                     }
                                     const rect = e.currentTarget.getBoundingClientRect();
                                     const offset = e.clientY - rect.top;
                                     this.dropPosition = offset > (rect.height / 2) ? 'after' : 'before';
                                     this.dragOverIdx = idx;
                                 },
                                 onDragLeave(e, idx) {
                                     if (!e.currentTarget.contains(e.relatedTarget)) {
                                         if (this.dragOverIdx === idx) {
                                             this.dragOverIdx = null;
                                         }
                                     }
                                 },
                                 onDrop(e, targetIdx) {
                                     e.preventDefault();
                                     if (this.draggedIdx !== null && this.draggedIdx !== targetIdx) {
                                         let newItems = [...this.items];
                                         const movedItem = newItems.splice(this.draggedIdx, 1)[0];
                                         let insertIdx = targetIdx;
                                         if (this.dropPosition === 'after') {
                                             insertIdx = this.draggedIdx < targetIdx ? targetIdx : targetIdx + 1;
                                         } else {
                                             insertIdx = this.draggedIdx < targetIdx ? targetIdx - 1 : targetIdx;
                                         }
                                         newItems.splice(insertIdx, 0, movedItem);
                                         this.items = newItems;
                                         $wire.updateUrutanDrag(this.items);
                                     }
                                     this.draggedIdx = null;
                                     this.dragOverIdx = null;
                                 },
                                 onDragEnd() {
                                     this.draggedIdx = null;
                                     this.dragOverIdx = null;
                                 }
                             }">
                            @forelse($daftarKategori as $idx => $item)
                                @php
                                    $rawCatName = $item->nama_kategori;
                                    $cleanUpper = strtoupper(trim($rawCatName));
                                    $displayLabel = match ($cleanUpper) {
                                        'ODP TIDAK SAMA' => 'ODP Tidak Sama',
                                        'DATEK TIDAK SAMA' => 'Datek Tidak Sama',
                                        'ODP DAN DATEK TIDAK SAMA', 'ODP & DATEK TIDAK SAMA' => 'ODP & Datek Tidak Sama',
                                        'NOT IN SERVICE' => 'Not In Service',
                                        'KENDALA ODP' => 'Kendala ODP',
                                        default => preg_replace_callback('/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/i', fn($m) => strtoupper($m[0]), ucwords(strtolower($rawCatName)))
                                    };
                                @endphp

                                <div wire:key="cat-card-wrapper-{{ $item->id }}" class="space-y-2">
                                    <!-- Celah Placeholder Ruang Kosong Otomatis (Posisi Sebelum Kartu) -->
                                    <div x-show="dragOverIdx === {{ $idx }} && dropPosition === 'before' && draggedIdx !== {{ $idx }}" 
                                         x-transition:enter="transition-all duration-150 ease-out"
                                         x-transition:enter-start="opacity-0 h-0"
                                         x-transition:enter-end="opacity-100 h-10"
                                         class="h-10 rounded-xl border-2 border-dashed border-[#AE0C00] bg-red-50/70 flex items-center justify-center gap-2 text-xs font-headline font-bold text-[#AE0C00] select-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                        <span>Pindahkan ke Posisi Ini</span>
                                    </div>

                                    <!-- Kartu Kategori: Latar Solid Putih 100%, Garis Tepi Merah Tipis Saat Diangkat, Bebas Ghosting -->
                                    <div wire:key="cat-card-{{ $item->id }}"
                                         x-data="{ confirmDelete: false }"
                                         draggable="true"
                                         @dragstart="onDragStart($event, {{ $idx }})"
                                         @dragover="onDragOver($event, {{ $idx }})"
                                         @dragleave="onDragLeave($event, {{ $idx }})"
                                         @drop="onDrop($event, {{ $idx }})"
                                         @dragend="onDragEnd()"
                                         :class="{ 
                                             'ring-1 ring-[#AE0C00] shadow-lg border-[#AE0C00] opacity-70 scale-[1.01]': draggedIdx === {{ $idx }} 
                                         }"
                                         class="relative p-3.5 sm:p-4 bg-white rounded-xl border border-slate-200/90 shadow-2xs hover:border-slate-300 hover:shadow-xs transition-all duration-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 cursor-grab active:cursor-grabbing group select-none">
                                        
                                        <!-- Grip Handle & Info Kategori -->
                                        <div class="flex items-start sm:items-center gap-3 flex-1 min-w-0">
                                            <!-- Ikon Titik Enam Vertikal (Grip Handle Ergonomis — Tanpa Tooltip Hitam) -->
                                            <div class="p-1.5 text-slate-300 group-hover:text-slate-500 rounded-lg hover:bg-slate-100 transition-colors shrink-0 select-none cursor-grab active:cursor-grabbing">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <circle cx="8.5" cy="6" r="1.5"/>
                                                    <circle cx="15.5" cy="6" r="1.5"/>
                                                    <circle cx="8.5" cy="12" r="1.5"/>
                                                    <circle cx="15.5" cy="12" r="1.5"/>
                                                    <circle cx="8.5" cy="18" r="1.5"/>
                                                    <circle cx="15.5" cy="18" r="1.5"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="space-y-2 flex-1 min-w-0">
                                                <!-- Judul Kategori & Lencana Jumlah Kolom (Netral Arang) -->
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h4 class="text-xs sm:text-sm font-headline font-bold text-slate-800 tracking-tight">
                                                        {{ $displayLabel }}
                                                    </h4>
                                                    <span class="text-[10px] sm:text-[10.5px] font-mono font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200/90 shadow-2xs select-none">
                                                        {{ count($item->konfigurasi_kolom ?? []) }} Kolom
                                                    </span>
                                                </div>

                                                <!-- Kapsul Kolom Bersih (Bebas Tooltip Hitam Pengganggu & Bebas Tipe Data Mentah) -->
                                                <div class="flex flex-wrap gap-1.5 pt-0.5">
                                                    @foreach($item->konfigurasi_kolom ?? [] as $col)
                                                        @php $isColHidden = !empty($col['hidden']); @endphp
                                                        <span class="inline-flex items-center text-[10.5px] font-mono font-medium px-2 py-0.5 rounded-md border transition-colors {{ $isColHidden ? 'bg-red-50/60 text-red-500 line-through border-red-200' : 'bg-slate-50 text-slate-700 border-slate-200/90' }}">
                                                            {{ $col['nama'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grup Tombol Aksi Kanan (Tersedia Konfirmasi Hapus Inline Elegan Tanpa Alert Browser) -->
                                        <div class="shrink-0 self-end sm:self-center pt-1 sm:pt-0" @click.stop>
                                            
                                            <!-- Panel Konfirmasi Hapus Inline -->
                                            <div x-show="confirmDelete" 
                                                 x-transition:enter="transition ease-out duration-150"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 class="flex items-center gap-2 p-1 bg-red-50 border border-red-200 rounded-xl shadow-2xs" 
                                                 style="display: none;">
                                                <span class="text-[11px] font-headline font-bold text-red-800 pl-1.5">
                                                    Hapus kategori & datanya?
                                                </span>
                                                <button wire:click="hapusKategori({{ $item->id }})" 
                                                        class="h-6.5 px-2.5 rounded-lg bg-[#AE0C00] hover:bg-[#8E0A00] text-white text-[11px] font-headline font-bold shadow-2xs transition-colors cursor-pointer">
                                                    Ya, Hapus
                                                </button>
                                                <button @click="confirmDelete = false" 
                                                        class="h-6.5 px-2 rounded-lg bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-headline font-semibold transition-colors cursor-pointer">
                                                    Batal
                                                </button>
                                            </div>

                                            <!-- Tombol Navigasi Normal (Aktif Saat Tidak Dalam Konfirmasi) -->
                                            <div x-show="!confirmDelete" class="flex items-center gap-1">
                                                <!-- Tombol Panah Cepat Naik -->
                                                <button wire:click="geserPosisi({{ $item->id }}, 'up')" 
                                                        class="w-7 h-7 rounded-lg border border-slate-200/90 bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                                </button>

                                                <!-- Tombol Panah Cepat Turun -->
                                                <button wire:click="geserPosisi({{ $item->id }}, 'down')" 
                                                        class="w-7 h-7 rounded-lg border border-slate-200/90 bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </button>

                                                <!-- Tombol Ubah (Edit - Hover Arang Gelap) -->
                                                <button wire:click="bukaEdit({{ $item->id }})" 
                                                        class="w-7 h-7 rounded-lg border border-slate-200/90 bg-white hover:bg-slate-800 hover:text-white hover:border-slate-800 text-slate-600 flex items-center justify-center transition-all shadow-2xs cursor-pointer ml-0.5 active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>

                                                <!-- Tombol Pemicu Konfirmasi Hapus (Bebas Alert Bawaan Browser) -->
                                                <button @click="confirmDelete = true" 
                                                        class="w-7 h-7 rounded-lg border border-slate-200/90 bg-white hover:bg-red-50 hover:text-[#AE0C00] hover:border-red-200 text-slate-400 flex items-center justify-center transition-all shadow-2xs cursor-pointer active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Celah Placeholder Ruang Kosong Otomatis (Posisi Setelah Kartu) -->
                                    <div x-show="dragOverIdx === {{ $idx }} && dropPosition === 'after' && draggedIdx !== {{ $idx }}" 
                                         x-transition:enter="transition-all duration-150 ease-out"
                                         x-transition:enter-start="opacity-0 h-0"
                                         x-transition:enter-end="opacity-100 h-10"
                                         class="h-10 rounded-xl border-2 border-dashed border-[#AE0C00] bg-red-50/70 flex items-center justify-center gap-2 text-xs font-headline font-bold text-[#AE0C00] select-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                        <span>Pindahkan ke Posisi Ini</span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center text-slate-400 text-xs bg-slate-50/50 rounded-xl border border-slate-200/80">
                                    Belum ada kategori yang dibuat.
                                </div>
                            @endforelse
                        </div>
                    </div>

                <!-- MODE 2: FORM TAMBAH / UBAH KATEGORI (SLIDE IN HALUS, KONSISTENSI HURUF KAPITAL AWAL, TOMBOL SAKELAR MATA, & KONFIRMASI INLINE) -->
                @else
                    <div class="cm-anim-slide-right space-y-4"
                         x-data="{ showBulkDeleteConfirm: false }">
                        <!-- Tombol Navigasi Kembali -->
                        <button wire:click="kembaliKeDaftar" 
                                class="inline-flex items-center gap-1.5 text-xs font-headline font-semibold text-slate-600 hover:text-slate-900 transition-colors cursor-pointer select-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>Kembali ke Daftar Kategori</span>
                        </button>

                        <!-- Kartu Input Nama Kategori (Konsistensi Huruf Awal Kapital Rapi) -->
                        <div class="bg-white rounded-xl border border-slate-200/90 p-4 shadow-2xs space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-700 uppercase tracking-wide">
                                Nama Kategori <span class="text-[#AE0C00]">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="nama_kategori" 
                                   placeholder="Contoh: ODP Tidak Sama, Datek Tidak Sama, Kendala ODP..." 
                                   class="w-full h-9 bg-slate-50/50 border border-slate-200/90 rounded-lg px-3 text-xs font-sans text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] transition-all outline-none">
                            @error('nama_kategori') 
                                <span class="text-[#AE0C00] text-[11px] font-medium block pt-0.5">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Kartu Konfigurasi Kolom & Visibilitas -->
                        <div class="bg-white rounded-xl border border-slate-200/90 p-4 shadow-2xs space-y-3 relative"
                             x-data="{
                                 activeDropdownUid: null,
                                 activeType: 'text',
                                 dropUp: false,
                                 coords: { top: 0, left: 0, width: 120 },
                                 openDropdown(uid, currentType, buttonEl) {
                                     if (this.activeDropdownUid === uid) {
                                         this.closeDropdown();
                                         return;
                                     }
                                     this.activeDropdownUid = uid;
                                     this.activeType = currentType;
                                     
                                     const rect = buttonEl.getBoundingClientRect();
                                     const container = this.$refs.kolomContainer ? this.$refs.kolomContainer.getBoundingClientRect() : null;
                                     
                                     // Deteksi ruang otomatis (auto-flip):
                                     // Cek sisa ruang di bawah tombol terhadap batas kontainer gulir dan jendela browser
                                     const spaceBelowInContainer = container ? (container.bottom - rect.bottom) : 200;
                                     const spaceBelowInWindow = window.innerHeight - rect.bottom;
                                     const menuHeight = 112;
                                     
                                     // Jika ruang di bawah kurang dari 125px (tinggi menu popover ~112px + margin), buka ke atas (drop-up)
                                     this.dropUp = (spaceBelowInContainer < 125 || spaceBelowInWindow < 130);
                                     
                                     const targetTop = this.dropUp ? (rect.top - 6 - menuHeight) : (rect.bottom + 6);
                                     const targetLeft = Math.min(rect.left, window.innerWidth - 148);
                                     
                                     this.coords = {
                                         top: Math.max(8, targetTop),
                                         left: Math.max(8, targetLeft),
                                         width: rect.width || 120
                                     };
                                 },
                                 closeDropdown() {
                                     this.activeDropdownUid = null;
                                 },
                                 selectType(type) {
                                     if (this.activeDropdownUid) {
                                         $wire.set('konfigurasi_kolom.' + this.activeDropdownUid + '.tipe', type);
                                     }
                                     this.closeDropdown();
                                 }
                             }"
                             @click.outside="closeDropdown()"
                             @keydown.escape.window="closeDropdown()"
                             @scroll.window.capture.passive="closeDropdown()"
                             @tutup-modal-kategori.window="closeDropdown()">
                            <!-- Header Toolbar Kolom (Bebas Tooltip Bertabrakan) -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                <div>
                                    <h4 class="text-xs font-headline font-bold text-slate-800 uppercase tracking-wider">
                                        Konfigurasi Urutan & Visibilitas Kolom
                                    </h4>
                                    <p class="text-[11px] text-slate-500 font-sans">
                                        Tahan dan geser ikon titik <span class="font-bold text-slate-700">:::</span> untuk mengatur urutan kolom
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Tombol Muat Kolom Standar (Bebas Tooltip Hitam Penabrak) -->
                                    <button type="button" 
                                            wire:click="muatKolomStandar" 
                                            class="inline-flex items-center gap-1.5 h-7 px-2.5 rounded-lg text-[11px] font-headline font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200/80 border border-slate-200/90 transition-colors cursor-pointer select-none">
                                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        <span>Kolom Standar</span>
                                    </button>
                                    <!-- Tombol Tambah Kolom Baru -->
                                    <button type="button" 
                                            wire:click="tambahKolom" 
                                            class="inline-flex items-center gap-1.5 h-7 px-2.5 rounded-lg text-[11px] font-headline font-bold text-[#AE0C00] bg-red-50 hover:bg-red-100 border border-red-200/80 transition-colors cursor-pointer select-none">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        <span>Tambah Kolom</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Notifikasi Info Aksi Kolom -->
                            @if (session()->has('info_kolom'))
                                <div class="p-2.5 bg-red-50 border border-red-200 text-red-900 text-xs font-semibold rounded-lg flex items-center gap-2 shadow-2xs">
                                    <svg class="w-4 h-4 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ session('info_kolom') }}</span>
                                </div>
                            @endif

                            <!-- Bar Kontrol Checkbox Massal (Latar Solid, Batas Bawah Tegas, & Kotak Centang Merah Korporat) -->
                            <div class="p-2.5 bg-slate-100/90 rounded-xl border border-slate-200/90 flex flex-wrap items-center justify-between gap-2 shadow-2xs">
                                <div class="flex items-center gap-2.5">
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="checkbox" 
                                               wire:model.live="selectAllKolom"
                                               class="w-4 h-4 text-[#AE0C00] accent-[#AE0C00] bg-white border-slate-300 rounded focus:ring-[#AE0C00] cursor-pointer">
                                        <span class="text-xs font-headline font-bold text-slate-700">
                                            Pilih Semua ({{ count($konfigurasi_kolom) }})
                                        </span>
                                    </label>

                                    @if(count($selectedKolom) > 0)
                                        <span class="text-[10.5px] font-mono font-bold bg-red-100 text-[#AE0C00] px-2 py-0.5 rounded-md border border-red-200">
                                            {{ count($selectedKolom) }} Kolom Dipilih
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if(count($selectedKolom) > 0)
                                        <button type="button" 
                                                @click="showBulkDeleteConfirm = true"
                                                class="inline-flex items-center gap-1.5 h-6.5 px-2.5 text-[11px] font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] rounded-md shadow-2xs transition-colors cursor-pointer select-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hapus Terpilih</span>
                                        </button>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">
                                            Centang kotak untuk menghapus beberapa kolom sekaligus
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Bilah Konfirmasi Hapus Massal Inline (Bebas Dialog Mentah Browser '127.0.0.1:8000 says...') -->
                            <div x-show="showBulkDeleteConfirm" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1.5"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="p-2.5 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between gap-3 shadow-2xs" 
                                 style="display: none;">
                                <div class="flex items-center gap-2 text-xs text-red-900 font-medium">
                                    <svg class="w-4 h-4 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>Hapus {{ count($selectedKolom) }} kolom yang dipilih? Tindakan ini tidak dapat dibatalkan.</span>
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button type="button" 
                                            @click="showBulkDeleteConfirm = false" 
                                            class="h-6.5 px-2.5 text-[11px] font-headline font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg transition-colors cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="button" 
                                            wire:click="hapusKolomTerpilih" 
                                            @click="showBulkDeleteConfirm = false" 
                                            class="h-6.5 px-3 text-[11px] font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] rounded-lg shadow-2xs transition-colors cursor-pointer">
                                        Ya, Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- List Kolom dengan Drag & Drop Kursor Mouse (Custom Scrollbar, Auto Scroll, & Animasi Baris Baru) -->
                            <div x-ref="kolomContainer"
                                 @scroll.passive="closeDropdown()"
                                 @kolom-ditambah.window="$nextTick(() => { $refs.kolomContainer.scrollTop = $refs.kolomContainer.scrollHeight; })"
                                 x-data="{
                                     draggingUid: null,
                                     overUid: null,
                                     dragStart(e, uid) {
                                         if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'LABEL' || e.target.closest('label') || e.target.closest('input') || e.target.closest('select') || e.target.closest('button')) {
                                             e.preventDefault();
                                             return;
                                         }
                                         this.draggingUid = uid;
                                         e.dataTransfer.effectAllowed = 'move';
                                         e.dataTransfer.setData('text/plain', uid);
                                     },
                                     dragOver(e, uid) {
                                         e.preventDefault();
                                         e.dataTransfer.dropEffect = 'move';
                                         this.overUid = uid;
                                     },
                                     dragLeave(e, uid) {
                                         if (this.overUid === uid) {
                                             this.overUid = null;
                                         }
                                     },
                                     drop(e, targetUid) {
                                         e.preventDefault();
                                         if (this.draggingUid && this.draggingUid !== targetUid) {
                                             $wire.pindahUrutanKolom(this.draggingUid, targetUid);
                                         }
                                         this.draggingUid = null;
                                         this.overUid = null;
                                     }
                                 }" 
                                 class="space-y-2 border border-slate-200/90 rounded-xl p-3 bg-slate-50/50 max-h-[340px] overflow-y-auto custom-scrollbar">

                                @forelse($konfigurasi_kolom as $uid => $kolom)
                                    @php
                                        $isRowSelected = in_array((string)$uid, $selectedKolom, true);
                                        $isColHidden = !empty($kolom['hidden']);
                                    @endphp

                                    <div wire:key="kolom-row-{{ $uid }}"
                                         data-uid="{{ $uid }}"
                                         draggable="true"
                                         @dragstart="dragStart($event, '{{ $uid }}')"
                                         @dragover="dragOver($event, '{{ $uid }}')"
                                         @dragleave="dragLeave($event, '{{ $uid }}')"
                                         @drop="drop($event, '{{ $uid }}')"
                                         :class="{ 
                                             'ring-2 ring-[#AE0C00] bg-red-50/90 scale-[1.01] shadow-md border-red-300': overUid === '{{ $uid }}' && draggingUid !== '{{ $uid }}',
                                             'opacity-40': draggingUid === '{{ $uid }}',
                                             'bg-red-50/60 border-red-300': {{ $isRowSelected ? 'true' : 'false' }} && overUid !== '{{ $uid }}',
                                             'opacity-60 bg-slate-50/90 border-slate-200/80': {{ $isColHidden ? 'true' : 'false' }} && !{{ $isRowSelected ? 'true' : 'false' }} && overUid !== '{{ $uid }}',
                                             'bg-white border-slate-200/90': !{{ $isColHidden ? 'true' : 'false' }} && !{{ $isRowSelected ? 'true' : 'false' }} && overUid !== '{{ $uid }}',
                                             'relative z-40': activeDropdownUid === '{{ $uid }}'
                                         }"
                                         class="cm-anim-row-appear flex items-center gap-2 sm:gap-3 p-2.5 rounded-lg border shadow-2xs hover:border-slate-300 transition-all cursor-grab active:cursor-grabbing group">
                                        
                                        <!-- 1. Checkbox Pilih Baris Hapus Massal (Warna Merah Korporat #AE0C00) -->
                                        <label class="flex items-center p-1 cursor-pointer select-none" @click.stop>
                                            <input type="checkbox" 
                                                   wire:model.live="selectedKolom"
                                                   value="{{ $uid }}"
                                                   class="w-4 h-4 text-[#AE0C00] accent-[#AE0C00] bg-white border-slate-300 rounded focus:ring-[#AE0C00] cursor-pointer">
                                        </label>

                                        <!-- 2. Handle Drag & Drop Kursor Mouse (Ikon Titik Enam) -->
                                        <div class="cursor-grab-handle p-1 text-slate-300 group-hover:text-slate-600 rounded transition shrink-0 select-none cursor-grab active:cursor-grabbing">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="8.5" cy="6" r="1.5"/>
                                                <circle cx="15.5" cy="6" r="1.5"/>
                                                <circle cx="8.5" cy="12" r="1.5"/>
                                                <circle cx="15.5" cy="12" r="1.5"/>
                                                <circle cx="8.5" cy="18" r="1.5"/>
                                                <circle cx="15.5" cy="18" r="1.5"/>
                                            </svg>
                                        </div>

                                        <!-- 3. Nomor Urut -->
                                        <span class="text-xs font-mono font-semibold text-slate-400 w-5 text-center shrink-0 select-none">
                                            {{ $loop->iteration }}
                                        </span>

                                        <!-- 4. Input Nama Kolom -->
                                        <div class="flex-1 min-w-[120px]" @click.stop>
                                            <input type="text" 
                                                   wire:model.blur="konfigurasi_kolom.{{ $uid }}.nama" 
                                                   placeholder="Nama Kolom (Misal: QR CODE VALINS)"
                                                   class="w-full text-xs font-mono font-semibold text-slate-800 bg-slate-50 border border-slate-200/90 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-[#AE0C00] focus:border-[#AE0C00] focus:bg-white transition-all outline-none">
                                        </div>

                                        <!-- 5. Pemilih Tipe Kolom Modern (Tombol Pemicu Floating Portal Bebas Potongan Bingkai) -->
                                        @php
                                            $colTipe = $kolom['tipe'] ?? 'text';
                                        @endphp
                                        <div class="shrink-0" @click.stop>
                                            <!-- Tombol Pemicu (Trigger Button) Berbingkai Halus, Sejajar, & Presisi -->
                                            <button type="button" 
                                                    @click="openDropdown('{{ $uid }}', '{{ $colTipe }}', $el)" 
                                                    class="h-7 w-[114px] sm:w-[120px] px-2 bg-white rounded-lg flex items-center justify-between gap-1.5 text-left transition-all duration-150 cursor-pointer select-none"
                                                    :class="activeDropdownUid === '{{ $uid }}' 
                                                        ? 'border-[#AE0C00]/60 ring-2 ring-[#AE0C00]/10 shadow-xs' 
                                                        : 'border border-slate-200/90 hover:border-slate-300 hover:bg-slate-50/70 shadow-2xs'">
                                                
                                                <div class="flex items-center gap-1.5 min-w-0 flex-1">
                                                    @if($colTipe === 'text')
                                                        <!-- Ikon Teks: Huruf Aa Garis Tajam & Bersih -->
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18l4.5-12 4.5 12M4.8 14h5.4M20 12v6m0-2.5a2.5 2.5 0 10-5 0 2.5 2.5 0 005 0z"/>
                                                        </svg>
                                                        <span class="text-[11px] font-headline font-semibold text-slate-700 truncate">Teks</span>
                                                    @elseif($colTipe === 'number')
                                                        <!-- Ikon Angka / ID: Tanda Pagar # Garis Tajam -->
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                        </svg>
                                                        <span class="text-[11px] font-headline font-semibold text-slate-700 truncate">Angka / ID</span>
                                                    @elseif($colTipe === 'date')
                                                        <!-- Ikon Tanggal: Kalender Garis Tipis -->
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
                                                        </svg>
                                                        <span class="text-[11px] font-headline font-semibold text-slate-700 truncate">Tanggal</span>
                                                    @else
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18l4.5-12 4.5 12M4.8 14h5.4M20 12v6m0-2.5a2.5 2.5 0 10-5 0 2.5 2.5 0 005 0z"/>
                                                        </svg>
                                                        <span class="text-[11px] font-headline font-semibold text-slate-700 truncate">Teks</span>
                                                    @endif
                                                </div>

                                                <!-- Ikon Panah Kecil Berputar Halus Saat Terbuka -->
                                                <svg class="w-3 h-3 text-slate-400 transition-transform duration-200 shrink-0" 
                                                     :class="activeDropdownUid === '{{ $uid }}' ? 'rotate-180 text-[#AE0C00]' : ''" 
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- 6. Tombol Sakelar Lencana Ikon Mata (Tampil / Sembunyi) -->
                                        <div class="shrink-0" @click.stop>
                                            <button type="button" 
                                                    wire:click="$toggle('konfigurasi_kolom.{{ $uid }}.hidden')"
                                                    class="inline-flex items-center gap-1.5 h-6.5 px-2.5 rounded-lg text-[11px] font-headline font-semibold transition-all cursor-pointer select-none active:scale-95 {{ $isColHidden ? 'bg-red-50 hover:bg-red-100 text-red-600 border border-red-200' : 'bg-slate-100 hover:bg-slate-200/90 text-slate-700 border border-slate-200/90' }}">
                                                @if($isColHidden)
                                                    <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                                    </svg>
                                                    <span>Sembunyi</span>
                                                @else
                                                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <span>Tampil</span>
                                                @endif
                                            </button>
                                        </div>

                                        <!-- 7. Tombol Hapus Baris Tunggal -->
                                        <button type="button" 
                                                wire:click="hapusKolom('{{ $uid }}')" 
                                                class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-[#AE0C00] hover:bg-red-50 rounded-lg transition-colors shrink-0 cursor-pointer active:scale-95" 
                                                @click.stop>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-slate-400 text-xs">
                                        Belum ada konfigurasi kolom yang dibuat.
                                    </div>
                                @endforelse
                            </div>

                            <!-- Panel Menu Melayang Bebas (Floating Portal Menu di Luar Batas Scroll Container — Anti-Clipped & Auto-Flip) -->
                            <div x-show="activeDropdownUid !== null"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 :style="{
                                     position: 'fixed',
                                     top: coords.top + 'px',
                                     left: coords.left + 'px',
                                     width: Math.max(coords.width, 140) + 'px',
                                     zIndex: 9999
                                 }"
                                 @click.stop
                                 class="bg-white rounded-xl shadow-xl border border-slate-200/90 py-1 px-1 space-y-0.5"
                                 style="display: none;">
                                
                                <!-- Opsi 1: Teks -->
                                <button type="button" 
                                        @click="selectType('text')" 
                                        class="w-full flex items-center justify-between gap-2 px-2.5 py-1.5 rounded-lg text-[11px] font-headline transition-colors text-left cursor-pointer"
                                        :class="activeType === 'text' 
                                            ? 'bg-slate-100 text-slate-900 font-bold' 
                                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium'">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <svg class="w-3.5 h-3.5 shrink-0 transition-colors" 
                                             :class="activeType === 'text' ? 'text-slate-800' : 'text-slate-400'" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18l4.5-12 4.5 12M4.8 14h5.4M20 12v6m0-2.5a2.5 2.5 0 10-5 0 2.5 2.5 0 005 0z"/>
                                        </svg>
                                        <span class="truncate">Teks</span>
                                    </div>
                                    <svg x-show="activeType === 'text'" class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>

                                <!-- Opsi 2: Angka / ID -->
                                <button type="button" 
                                        @click="selectType('number')" 
                                        class="w-full flex items-center justify-between gap-2 px-2.5 py-1.5 rounded-lg text-[11px] font-headline transition-colors text-left cursor-pointer"
                                        :class="activeType === 'number' 
                                            ? 'bg-slate-100 text-slate-900 font-bold' 
                                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium'">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <svg class="w-3.5 h-3.5 shrink-0 transition-colors" 
                                             :class="activeType === 'number' ? 'text-slate-800' : 'text-slate-400'" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        <span class="truncate">Angka / ID</span>
                                    </div>
                                    <svg x-show="activeType === 'number'" class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>

                                <!-- Opsi 3: Tanggal -->
                                <button type="button" 
                                        @click="selectType('date')" 
                                        class="w-full flex items-center justify-between gap-2 px-2.5 py-1.5 rounded-lg text-[11px] font-headline transition-colors text-left cursor-pointer"
                                        :class="activeType === 'date' 
                                            ? 'bg-slate-100 text-slate-900 font-bold' 
                                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium'">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <svg class="w-3.5 h-3.5 shrink-0 transition-colors" 
                                             :class="activeType === 'date' ? 'text-slate-800' : 'text-slate-400'" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
                                        </svg>
                                        <span class="truncate">Tanggal</span>
                                    </div>
                                    <svg x-show="activeType === 'date'" class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </div>

                            @error('konfigurasi_kolom') <span class="text-[#AE0C00] text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            @error('konfigurasi_kolom.*.nama') <span class="text-[#AE0C00] text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

            </div>

            <!-- Modal Footer (Abu-Abu Sangat Lembut & Garis Pemisah Atas) -->
            <div class="px-5 sm:px-6 py-3.5 bg-slate-50/90 border-t border-slate-100 flex justify-end items-center gap-2.5 shrink-0">
                @if($mode === 'list')
                    <button @click="open = false" 
                            class="h-8.5 px-4 bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 rounded-xl shadow-2xs transition-all text-xs font-headline font-semibold cursor-pointer active:scale-95">
                        Tutup
                    </button>
                @else
                    <button wire:click="kembaliKeDaftar" 
                            class="h-8.5 px-4 bg-white hover:bg-slate-50 border border-slate-200/90 text-slate-700 rounded-xl shadow-2xs transition-all text-xs font-headline font-semibold cursor-pointer active:scale-95">
                        Batal
                    </button>
                    <button wire:click="simpanKategori" 
                            class="h-8.5 px-4 bg-[#AE0C00] hover:bg-[#8E0A00] active:bg-[#730800] text-white rounded-xl shadow-2xs hover:shadow-xs transition-all text-xs font-headline font-bold flex items-center gap-1.5 cursor-pointer active:scale-95">
                        <span>{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Kategori' }}</span>
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>