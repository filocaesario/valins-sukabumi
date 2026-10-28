<x-app-layout>

    <!-- Wrapper Utama dengan Alpine.js untuk Modal Import Excel (Kontainer Seragam Anti-Tertutup Sidebar & Split Drag-Drop) -->
    <div x-data="{ 
            modalOpen: false,
            isDragging: false,
            isSubmitting: false,
            fileDetails: null,
            closeModal() {
                this.modalOpen = false;
                setTimeout(() => {
                    this.fileDetails = null;
                    this.isDragging = false;
                    this.isSubmitting = false;
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = '';
                    }
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
            }
         }" 
         class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6">

        <!-- Header Halaman & Kelompok Tombol Aksi Sejajar -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <!-- Bagian Kiri: Hierarki Tipografi Vertikal Murni (Lencana Kapsul Penuh + Judul Rata Kiri Tanpa Ikon) -->
            <div class="flex flex-col items-start gap-2.5 max-w-3xl">
                <!-- Baris 1: Lencana Mikro Penanda Operasional (Identik Penuh Halaman Kebijakan Privasi) -->

                <!-- Baris 2: Judul Utama Tanpa Ikon (Rata Kiri Murni) -->
                <h1 class="text-xl sm:text-2xl font-headline font-bold text-[#0F172A] tracking-tight leading-tight">
                    GPON ALL STO WITEL SUKABUMI
                </h1>

                <!-- Baris 3: Deskripsi Sub-Judul yang Berwibawa & Proporsional -->
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl">
                    Pusat kendali pemantauan topologi perangkat OLT, manajemen alokasi slot dan port transmisi optik, serta sinkronisasi parameter jaringan GPON PT Telkom Akses Regional Jawa Barat (Witel Sukabumi).
                </p>
            </div>

            <!-- Bagian Kanan (Grup Tombol Aksi Sejajar Presisi: Import Data & + Tambah Data) -->
            <div class="flex items-center gap-3 w-full sm:w-auto shrink-0 self-start lg:self-center">
                <!-- Tombol Sekunder "Import Data" (Putih Bersih, Border Abu-abu, Ikon Merah Korporat) -->
                <button type="button" 
                        @click="modalOpen = true" 
                        class="inline-flex items-center justify-center gap-2 h-9.5 px-4 rounded-xl text-xs font-headline font-semibold bg-white hover:bg-slate-50 active:bg-slate-100 text-[#0F172A] hover:text-[#AE0C00] border border-[#E2E8F0] hover:border-slate-300 shadow-2xs hover:shadow-xs transition-colors duration-150 cursor-pointer select-none">
                    <svg class="w-4 h-4 text-[#AE0C00] shrink-0 transition-colors duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Import Data</span>
                </button>

                <!-- Tombol Utama "+ Tambah Data" (Merah Korporat Solid #AE0C00) -->
                <button type="button" 
                        @click="$dispatch('open-modal-tambah-instant'); $dispatch('open-modal-tambah')" 
                        class="inline-flex items-center justify-center gap-2 h-9.5 px-4.5 rounded-xl text-xs font-headline font-semibold bg-[#AE0C00] hover:bg-[#900A00] active:bg-[#780800] text-white shadow-xs hover:shadow-sm transition-colors duration-150 cursor-pointer select-none">
                    <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-xs flex items-center justify-between text-sm font-semibold">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Panggil Komponen Tabel Livewire -->
        <div class="w-full min-w-0">
            @livewire('master-gpon-table')
        </div>

        <!-- Pop-up Modal Import Data GPON (Split 2-Column System, Telkom Akses Corporate Red & Smooth GPU Transitions) -->
        <template x-teleport="body">
            <div x-show="modalOpen" 
                 x-cloak 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 role="dialog" 
                 aria-modal="true" 
                 @keydown.escape.window="closeModal()">
                
                <!-- Backdrop Transparan Kaca Buram Terang (160ms GPU opacity transition, static blur) -->
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
                                    <h3 class="text-slate-900 font-headline font-bold text-base sm:text-lg leading-tight truncate">
                                        Import Data GPON
                                    </h3>
                                    <p class="text-slate-500 text-xs mt-0.5 truncate">
                                        Unggah berkas spreadsheet format .xlsx, .xls, atau .csv untuk sinkronisasi perangkat GPON.
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Penutup Silang (X) Berputar 90 Derajat -->
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
                        <form action="{{ route('master-gpon.import') }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              @submit="if(!fileDetails) { $event.preventDefault(); return false; } isSubmitting = true" 
                              class="flex flex-col flex-1 overflow-hidden m-0">
                            @csrf
                            
                            <div class="p-5 sm:p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-145px)]">
                                <!-- Two Column Split Card System -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                                    
                                    <!-- ============================================== -->
                                    <!-- KOLOM KIRI: DROPZONE INTERAKTIF               -->
                                    <!-- ============================================== -->
                                    <div class="flex flex-col">
                                        <label class="text-xs font-headline font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                                            <span>Area Unggah Berkas</span>
                                        </label>
                                        
                                        <div @dragover.prevent="isDragging = true"
                                             @dragleave.prevent="isDragging = false"
                                             @drop.prevent="handleDrop($event)"
                                             @click="$refs.fileInput.click()"
                                             :class="isDragging 
                                                ? 'border-solid border-[#AE0C00] bg-[#FFF5F5] ring-2 ring-[#AE0C00]/20' 
                                                : 'border-dashed border-[1.5px] border-slate-300 hover:border-slate-400 bg-slate-50/70 hover:bg-slate-50'"
                                             class="relative h-[230px] rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-200 group select-none overflow-hidden">
                                            
                                            <!-- Hidden Native File Input -->
                                            <input type="file" 
                                                   name="file_excel" 
                                                   x-ref="fileInput" 
                                                   accept=".xlsx,.xls,.csv" 
                                                   @change="handleFileChange($event)" 
                                                   class="sr-only" 
                                                   required>

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

                                            <!-- Indikator Berkas Siap Diunggah -->
                                            <div class="mt-3 px-3 py-2 bg-emerald-50/80 rounded-xl border border-emerald-200/70 flex items-center gap-2 text-emerald-800 text-xs">
                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="text-[11px] font-medium">Berkas siap diunggah dan diproses ke sistem GPON.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bilah Panduan Bawah (Panduan Sinkronisasi & Distribusi Data Otomatis) -->
                                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 sm:p-4 flex items-center gap-3.5 shadow-2xs">
                                    <!-- Wadah Ikon Merah Muda Lembut dengan Ikon Perisai Centang Korporat -->
                                    <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-200/60 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                                        <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <!-- Blok Teks Panduan Operasional 2 Tingkat -->
                                    <div class="flex flex-col min-w-0 justify-center">
                                        <h4 class="text-xs font-headline font-bold text-[#0F172A] leading-tight">
                                            Panduan Sinkronisasi &amp; Distribusi Data Otomatis
                                        </h4>
                                        <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed mt-0.5">
                                            Sistem akan memindai berkas lembar kerja secara otomatis, melewati baris rumus tanpa kendala, dan langsung mendistribusikan data perangkat OLT ke masing-masing kategori wilayah STO.
                                        </p>
                                    </div>
                                </div>

                                <!-- Error Flash Message jika ada validasi gagal -->
                                @if ($errors->any())
                                    <div class="p-3 bg-red-50 text-red-700 text-xs font-semibold rounded-xl border border-red-200 flex items-start gap-2 shadow-2xs">
                                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div class="space-y-0.5">
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

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
                                        :disabled="!fileDetails || isSubmitting" 
                                        class="h-9 px-5 bg-[#AE0C00] hover:bg-[#900A00] active:bg-[#780800] text-white rounded-xl text-xs font-headline font-semibold shadow-xs hover:shadow-sm transition-colors duration-150 flex items-center gap-2 cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-[#AE0C00]">
                                    <span x-show="!isSubmitting" class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        <span>Mulai Import Data</span>
                                    </span>
                                    <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
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
</x-app-layout>
