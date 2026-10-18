<div x-data="{ open: false }" 
     @buka-modal-kategori.window="open = true" 
     @tutup-modal-kategori.window="open = false">
    
    <!-- Modal Backdrop -->
    <div x-show="open" 
         x-transition.opacity 
         class="fixed inset-0 bg-gray-900 bg-opacity-60 z-40 backdrop-blur-sm"
         style="display: none;">
    </div>

    <!-- Modal Box -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4"
         style="display: none;">
         
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-3xl flex flex-col max-h-[90vh]">
            
            <!-- Modal Header -->
            <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="p-2 bg-gray-800 text-white rounded-lg shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">
                            {{ $mode === 'list' ? 'Kelola Kategori & Kolom' : ($isEditing ? 'Edit Kategori: ' . $nama_kategori : 'Tambah Kategori Baru') }}
                        </h3>
                        <p class="text-[11px] sm:text-xs text-gray-500">Tahan & geser kategori dengan kursor untuk memindahkan posisinya</p>
                    </div>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-red-500 transition p-1.5 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Notifikasi Modal -->
            @if (session()->has('success_modal'))
                <div class="mx-4 sm:mx-6 mt-3 sm:mt-4 p-3 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold rounded-lg flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success_modal') }}</span>
                </div>
            @endif

            <!-- Modal Content -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 overflow-y-auto flex-1">
                
                <!-- MODE 1: DAFTAR KATEGORI (DENGAN DRAG AND DROP) -->
                @if($mode === 'list')
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2.5">
                        <span class="text-xs font-bold uppercase text-gray-500 tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            Urutan Tab Kategori
                        </span>
                        <button wire:click="bukaTambah" class="w-full sm:w-auto justify-center bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3.5 py-2 rounded-lg shadow-sm transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Kategori Baru
                        </button>
                    </div>

                    <!-- Alpine Drag and Drop Container -->
                    <div class="divide-y divide-gray-100 border rounded-xl overflow-hidden bg-white shadow-sm"
                         x-data="{
                             draggingIndex: null,
                             items: {{ json_encode($daftarKategori->pluck('id')) }},
                             dragStart(e, idx) {
                                 this.draggingIndex = idx;
                                 e.dataTransfer.effectAllowed = 'move';
                             },
                             drop(e, targetIdx) {
                                 if (this.draggingIndex !== null && this.draggingIndex !== targetIdx) {
                                     const moved = this.items.splice(this.draggingIndex, 1)[0];
                                     this.items.splice(targetIdx, 0, moved);
                                     $wire.updateUrutanDrag(this.items);
                                 }
                                 this.draggingIndex = null;
                             }
                         }">
                        @forelse($daftarKategori as $idx => $item)
                            <div draggable="true"
                                 @dragstart="dragStart($event, {{ $idx }})"
                                 @dragover.prevent
                                 @drop="drop($event, {{ $idx }})"
                                 class="p-4 hover:bg-gray-50 transition flex items-center justify-between gap-3 bg-white cursor-grab active:cursor-grabbing group">
                                
                                <!-- Grip Handle & Info -->
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="text-gray-300 group-hover:text-gray-500 p-1" title="Tahan dan geser">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                    </div>
                                    
                                    <div class="space-y-1.5 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-bold text-gray-900">{{ $item->nama_kategori }}</h4>
                                            <span class="text-[10px] bg-blue-50 text-blue-700 font-semibold px-2 py-0.5 rounded-full border border-blue-200">
                                                {{ count($item->konfigurasi_kolom ?? []) }} Kolom
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-1.5 pt-0.5">
                                            @foreach($item->konfigurasi_kolom ?? [] as $col)
                                                @php $isColHidden = !empty($col['hidden']); @endphp
                                                <span class="inline-flex items-center text-[11px] {{ $isColHidden ? 'bg-red-50 text-red-500 line-through border-red-200' : 'bg-gray-100 text-gray-600 border-gray-200' }} px-2 py-0.5 rounded border" title="{{ $isColHidden ? 'Kolom Disembunyikan' : 'Kolom Tampil' }}">
                                                    {{ $col['nama'] }} <span class="text-[9px] {{ $isColHidden ? 'text-red-400' : 'text-gray-400' }} ml-1">({{ $col['tipe'] ?? 'text' }})</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Aksi Pindah & Edit/Hapus -->
                                <div class="flex items-center gap-1 shrink-0" @click.stop>
                                    <!-- Tombol Panah Cepat Naik / Turun -->
                                    <button wire:click="geserPosisi({{ $item->id }}, 'up')" class="p-1.5 text-gray-400 hover:text-gray-800 hover:bg-gray-100 rounded" title="Pindah ke Atas / Kiri">
                                        ▲
                                    </button>
                                    <button wire:click="geserPosisi({{ $item->id }}, 'down')" class="p-1.5 text-gray-400 hover:text-gray-800 hover:bg-gray-100 rounded" title="Pindah ke Bawah / Kanan">
                                        ▼
                                    </button>

                                    <!-- Edit & Hapus -->
                                    <button wire:click="bukaEdit({{ $item->id }})" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition ml-1" title="Edit Kategori & Kolom">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="hapusKategori({{ $item->id }})" 
                                            wire:confirm="PERINGATAN KERAS: Menghapus kategori '{{ $item->nama_kategori }}' juga akan MENGHAPUS SELURUH DATA yang ada di dalamnya secara permanen! Tindakan ini tidak dapat dibatalkan. Apakah Anda sangat yakin?" 
                                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" 
                                            title="Hapus Kategori & Seluruh Datanya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-500 text-sm">Belum ada kategori yang dibuat.</div>
                        @endforelse
                    </div>

                <!-- MODE 2: FORM TAMBAH / EDIT KATEGORI -->
                @else
                    <div class="space-y-4">
                        <button wire:click="kembaliKeDaftar" class="text-xs font-bold text-gray-600 hover:text-gray-900 flex items-center gap-1">
                            &larr; Kembali ke Daftar Kategori
                        </button>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Nama Kategori</label>
                            <input type="text" wire:model="nama_kategori" placeholder="Contoh: DATEK TIDAK SAMA, Kendala ODP..." 
                                   class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:border-red-500 focus:ring-red-500">
                            @error('nama_kategori') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <!-- Header & Toolbar Pengaturan Kolom -->
                            <div class="flex flex-wrap justify-between items-center mb-1.5 gap-2">
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        Konfigurasi Urutan Kolom & Visibilitas
                                    </label>
                                    <p class="text-[11px] text-gray-500">
                                        Tahan dan geser ikon <span class="font-bold text-gray-700">:::</span> dengan kursor untuk mengubah urutan kolom.
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            wire:click="muatKolomStandar" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
                                            title="Muat 16 Kolom Standar Valins">
                                        ↺ Kolom Standar
                                    </button>
                                    <button type="button" 
                                            wire:click="tambahKolom" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Kolom
                                    </button>
                                </div>
                            </div>

                            <!-- Notifikasi Info Aksi Kolom -->
                            @if (session()->has('info_kolom'))
                                <div class="mb-2 p-2 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold rounded-lg flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ session('info_kolom') }}</span>
                                </div>
                            @endif

                            <!-- Bar Kontrol Checkbox Massal (Pilih Semua & Hapus Sekaligus) -->
                            <div class="mb-2 p-2 bg-gray-100/80 rounded-xl border border-gray-200 flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="checkbox" 
                                               wire:model.live="selectAllKolom"
                                               class="w-4 h-4 text-red-600 bg-white border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                                        <span class="text-xs font-bold text-gray-700">
                                            Pilih Semua ({{ count($konfigurasi_kolom) }})
                                        </span>
                                    </label>

                                    @if(count($selectedKolom) > 0)
                                        <span class="text-[11px] bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full border border-red-200">
                                            {{ count($selectedKolom) }} Kolom Dipilih
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if(count($selectedKolom) > 0)
                                        <button type="button" 
                                                wire:click="hapusKolomTerpilih" 
                                                wire:confirm="PERINGATAN: Apakah Anda yakin ingin menghapus {{ count($selectedKolom) }} kolom yang dipilih sekaligus?"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-xs transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus ({{ count($selectedKolom) }}) Kolom Terpilih
                                        </button>
                                    @else
                                        <span class="text-[11px] text-gray-400 italic">
                                            Centang kotak di sisi kiri kolom untuk menghapus massal
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Container List Kolom dengan Drag & Drop Kursor Mouse -->
                            <div x-data="{
                                    draggingUid: null,
                                    overUid: null,
                                    init() {
                                        if (typeof Sortable !== 'undefined' && this.$el) {
                                            new Sortable(this.$el, {
                                                animation: 200,
                                                handle: '.cursor-grab-handle',
                                                ghostClass: 'bg-red-50',
                                                chosenClass: 'ring-2 ring-red-400 bg-gray-50',
                                                onEnd: (evt) => {
                                                    let order = Array.from(this.$el.children)
                                                        .filter(el => el.hasAttribute('data-uid'))
                                                        .map(el => el.getAttribute('data-uid'));
                                                    $wire.reorderKolom(order);
                                                }
                                            });
                                        }
                                    },
                                    dragStart(e, uid) {
                                        if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL' || e.target.closest('label') || e.target.closest('input') || e.target.closest('button')) {
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
                                 class="space-y-2 border border-gray-200 rounded-xl p-3 bg-gray-50/50 max-h-[420px] overflow-y-auto">

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
                                             'ring-2 ring-red-500 bg-red-50/90 scale-[1.01] shadow-md border-red-400': overUid === '{{ $uid }}' && draggingUid !== '{{ $uid }}',
                                             'opacity-40': draggingUid === '{{ $uid }}',
                                             'bg-red-50/60 border-red-300': {{ $isRowSelected ? 'true' : 'false' }} && overUid !== '{{ $uid }}',
                                             'bg-white border-gray-200': !{{ $isRowSelected ? 'true' : 'false' }} && overUid !== '{{ $uid }}'
                                         }"
                                         class="flex items-center gap-3 p-2.5 rounded-lg border shadow-xs hover:border-gray-300 transition-all cursor-grab active:cursor-grabbing group">
                                        
                                        <!-- 1. Checkbox Pilih Baris untuk Hapus Massal -->
                                        <label class="flex items-center p-1 cursor-pointer select-none" title="Centang untuk pilih hapus massal" @click.stop>
                                            <input type="checkbox" 
                                                   wire:model.live="selectedKolom"
                                                   value="{{ $uid }}"
                                                   class="w-4 h-4 text-red-600 bg-white border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                                        </label>

                                        <!-- 2. Handle Drag & Drop Kursor Mouse (::: icon) -->
                                        <div class="cursor-grab-handle p-1.5 text-gray-400 group-hover:text-gray-700 hover:bg-gray-100 rounded transition shrink-0 select-none" 
                                             title="Tahan dan geser kursor untuk memindahkan posisi urutan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                            </svg>
                                        </div>

                                        <!-- 3. Nomor Urut -->
                                        <span class="text-xs font-semibold text-gray-400 w-5 text-center shrink-0 select-none">{{ $loop->iteration }}</span>

                                        <!-- 4. Input Nama Kolom (di-bind langsung ke UID uniknya) -->
                                        <div class="flex-1" @click.stop>
                                            <input type="text" 
                                                   wire:model.blur="konfigurasi_kolom.{{ $uid }}.nama" 
                                                   placeholder="Nama Kolom (Misal: ODP NAME)"
                                                   class="w-full text-xs font-semibold text-gray-800 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-red-500 focus:bg-white transition-all">
                                        </div>

                                        <!-- 5. Checkbox Sembunyikan Kolom -->
                                        <label class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border border-transparent hover:border-red-200 hover:bg-red-50/60 cursor-pointer select-none transition-all shrink-0" 
                                               title="Centang untuk menyembunyikan kolom dari tabel data dan ekspor PDF" @click.stop>
                                            <input type="checkbox" 
                                                   wire:model.live="konfigurasi_kolom.{{ $uid }}.hidden"
                                                   value="1"
                                                   class="w-4 h-4 text-red-600 bg-white border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                                            <span class="text-[11px] font-medium text-gray-600 {{ $isColHidden ? 'line-through text-red-500 font-bold' : '' }}">
                                                Sembunyikan
                                            </span>
                                        </label>

                                        <!-- 6. Tombol Hapus Baris Tunggal -->
                                        <button type="button" 
                                                wire:click="hapusKolom('{{ $uid }}')" 
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0" 
                                                title="Hapus Kolom Ini"
                                                @click.stop>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-400 text-xs">
                                        Belum ada konfigurasi kolom yang dibuat.
                                    </div>
                                @endforelse
                            </div>

                            @error('konfigurasi_kolom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            @error('konfigurasi_kolom.*.nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-100 flex justify-end gap-2.5 shrink-0">
                @if($mode === 'list')
                    <button @click="open = false" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-xs font-bold">
                        Tutup
                    </button>
                @else
                    <button wire:click="kembaliKeDaftar" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition text-xs font-bold">
                        Batal
                    </button>
                    <button wire:click="simpanKategori" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-sm hover:bg-red-700 transition text-xs font-bold flex items-center gap-1.5">
                        <span>{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Kategori' }}</span>
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>