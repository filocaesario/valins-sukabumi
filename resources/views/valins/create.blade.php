<x-app-layout>
    <style>
        @keyframes valinsShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }
        .valins-anim-shake {
            animation: valinsShake 0.22s ease-in-out;
        }
    </style>

    <script>
        function valinsCreateForm() {
            return {
                dropdownOpen: false,
                kategoriPilihan: '{{ $defaultKategori ?? request('kategori', '') }}',
                pendingKategori: '',
                showResetConfirm: false,
                daftarKategori: @json($categories),
                errors: {},
                showErrorBanner: false,
                isShaking: false,

                get kategoriAktif() {
                    return this.daftarKategori.find(k => k.nama_kategori === this.kategoriPilihan);
                },
                get isDinamis() {
                    return Boolean(this.kategoriAktif && this.kategoriAktif.konfigurasi_kolom && this.kategoriAktif.konfigurasi_kolom.length > 0);
                },
                clearError(field) {
                    if (this.errors[field]) {
                        delete this.errors[field];
                        this.errors = { ...this.errors };
                    }
                    if (Object.keys(this.errors).length === 0) {
                        this.showErrorBanner = false;
                    }
                },
                validateForm() {
                    this.errors = {};
                    
                    // 1. Validasi Kategori
                    if (!this.kategoriPilihan) {
                        this.errors['kategori'] = 'Kategori rekonsiliasi data wajib dipilih.';
                    }

                    // 2. Validasi STO & Kolom Statis (jika non-dinamis)
                    if (!this.isDinamis) {
                        const stoInput = document.querySelector('input[name="sto"]');
                        if (!stoInput || !stoInput.value || stoInput.value.trim() === '') {
                            this.errors['sto'] = 'STO wajib diisi.';
                        }

                        const requiredStatics = [
                            { name: 'odp_name', label: 'ODP Name' },
                            { name: 'panel_o', label: 'Panel ODP' },
                            { name: 'port_od', label: 'Port ODP' },
                            { name: 'onu_sn', label: 'ONU SN' },
                        ];
                        requiredStatics.forEach(f => {
                            const el = document.querySelector(`input[name="${f.name}"]`);
                            if (!el || !el.value || el.value.trim() === '') {
                                this.errors[f.name] = `${f.label} wajib diisi.`;
                            }
                        });
                    }

                    // 3. Validasi Kolom Dinamis (jika dinamis)
                    if (this.isDinamis && this.kategoriAktif && this.kategoriAktif.konfigurasi_kolom) {
                        this.kategoriAktif.konfigurasi_kolom.forEach(kolom => {
                            const uName = kolom.nama.toUpperCase().trim();
                            if (['KETERANGAN', 'TANGGAL', 'PIC'].includes(uName)) return;
                            if (!this.isFieldOptional(kolom.nama)) {
                                const el = document.querySelector(`input[name="dynamic_data[${kolom.nama}]"]`);
                                if (!el || !el.value || el.value.trim() === '') {
                                    this.errors[kolom.nama] = `${kolom.nama} wajib diisi.`;
                                }
                            }
                        });
                    }

                    return Object.keys(this.errors).length === 0;
                },
                handleSubmit(event) {
                    if (!this.validateForm()) {
                        this.showErrorBanner = true;
                        this.isShaking = true;
                        setTimeout(() => this.isShaking = false, 250);

                        // Fokus dan gulir otomatis ke kolom galat pertama
                        this.$nextTick(() => {
                            if (this.errors['kategori']) {
                                this.dropdownOpen = true;
                                const dropdownBtn = document.querySelector('#category_dropdown_btn');
                                if (dropdownBtn) {
                                    dropdownBtn.focus();
                                    dropdownBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                                return;
                            }

                            const errorKeys = Object.keys(this.errors);
                            if (errorKeys.length > 0) {
                                const firstKey = errorKeys[0];
                                let targetInput = document.querySelector(`input[name="dynamic_data[${firstKey}]"]`) ||
                                                  document.querySelector(`input[name="${firstKey}"]`);
                                if (targetInput) {
                                    targetInput.focus();
                                    targetInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }
                        });
                        return false;
                    }

                    // Jika valid, jalankan sinkronisasi data dan kirim form
                    if (this.syncBeforeSubmit()) {
                        event.target.submit();
                    }
                },
                hasFilledData() {
                    const dyn = document.querySelectorAll('input[name^="dynamic_data["]');
                    for (let el of dyn) {
                        if (el.value && el.value.trim() !== '') return true;
                    }
                    const phys = ['odp_name', 'panel_o', 'port_od', 'valins_id', 'node_id', 'node_ip', 'slot', 'port', 'onu_sn', 'no_inet_valins', 'sip1_valins', 'sip2_valins', 'sid'];
                    for (let name of phys) {
                        const el = document.querySelector(`input[name="${name}"]`);
                        if (el && el.value && el.value.trim() !== '') return true;
                    }
                    return false;
                },
                pilihKategori(nama) {
                    this.dropdownOpen = false;
                    this.clearError('kategori');
                    if (this.kategoriPilihan === nama) return;
                    
                    // Jika belum ada kategori yang dipilih atau belum ada data terisi, langsung terapkan
                    if (!this.kategoriPilihan || !this.hasFilledData()) {
                        this.kategoriPilihan = nama;
                        this.showResetConfirm = false;
                        return;
                    }

                    // Jika pengguna sudah mengisi data lalu memilih kategori lain, buka konfirmasi inline
                    this.pendingKategori = nama;
                    this.showResetConfirm = true;
                },
                konfirmasiGantiKategori(resetKolom) {
                    if (resetKolom) {
                        const dyn = document.querySelectorAll('input[name^="dynamic_data["]');
                        dyn.forEach(el => el.value = '');
                        
                        const phys = ['odp_name', 'panel_o', 'port_od', 'valins_id', 'node_id', 'node_ip', 'slot', 'port', 'onu_sn', 'no_inet_valins', 'sip1_valins', 'sip2_valins', 'sid'];
                        phys.forEach(name => {
                            const el = document.querySelector(`input[name="${name}"]`);
                            if (el) el.value = '';
                        });
                    }
                    this.kategoriPilihan = this.pendingKategori;
                    this.pendingKategori = '';
                    this.showResetConfirm = false;
                    this.errors = {};
                    this.showErrorBanner = false;
                },
                batalGantiKategori() {
                    this.pendingKategori = '';
                    this.showResetConfirm = false;
                },
                getCategoryIconType(name) {
                    if (!name) return 'default';
                    const u = name.toUpperCase().trim();
                    if (u === 'ODP TIDAK SAMA') return 'odp';
                    if (u === 'DATEK TIDAK SAMA') return 'datek';
                    if (u === 'ODP DAN DATEK TIDAK SAMA' || u === 'ODP & DATEK TIDAK SAMA') return 'odp_datek';
                    if (u === 'NOT IN SERVICE') return 'nis';
                    if (u === 'KENDALA ODP') return 'kendala';

                    // Algoritma Rotasi Ikon Otomatis (Opsi 1): Berbasis ID / hash unik kategori
                    const catObj = this.daftarKategori ? this.daftarKategori.find(k => k.nama_kategori === name) : null;
                    const rotationPool = ['custom_server', 'custom_chip', 'custom_network', 'custom_table', 'custom_barcode', 'custom_folder', 'custom_tag', 'custom_signal'];
                    if (catObj && catObj.id) {
                        return rotationPool[(catObj.id - 1) % rotationPool.length];
                    }
                    let hash = 0;
                    for (let i = 0; i < name.length; i++) hash = (hash * 31 + name.charCodeAt(i)) >>> 0;
                    return rotationPool[hash % rotationPool.length];
                },
                formatCatName(name) {
                    if (!name) return '';
                    const u = name.toUpperCase().trim();
                    if (u === 'ODP TIDAK SAMA') return 'ODP Tidak Sama';
                    if (u === 'DATEK TIDAK SAMA') return 'Datek Tidak Sama';
                    if (u === 'ODP DAN DATEK TIDAK SAMA' || u === 'ODP & DATEK TIDAK SAMA') return 'ODP & Datek Tidak Sama';
                    if (u === 'NOT IN SERVICE') return 'Not In Service';
                    if (u === 'KENDALA ODP') return 'Kendala ODP';
                    return name.replace(/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/gi, m => m.toUpperCase());
                },
                isFieldOptional(name) {
                    if (!name) return false;
                    const normalized = name.toUpperCase().replace(/[^A-Z0-9]/g, '');
                    const optionals = ['NOINETVALINS', 'NOINET', 'SIP1VALINS', 'SIP1', 'SIP2VALINS', 'SIP2', 'SID', 'KETERANGAN', 'STATUS', 'KETERANGANSTATUS', 'TANGGAL', 'PIC', 'UPDATEPROGRESS', 'UPDATE'];
                    return optionals.includes(normalized);
                },
                // Fitur Cerdas: Sinkronisasi data dinamis ke kolom fisik database sebelum submit
                syncBeforeSubmit() {
                    if (!this.kategoriPilihan) {
                        this.dropdownOpen = true;
                        return false;
                    }
                    if (this.isDinamis) {
                        const map = {
                            'TREG': 'treg', 'WITEL': 'witel', 'STO': 'sto', 'ODPNAME': 'odp_name', 
                            'PANELODP': 'panel_o', 'PORTODP': 'port_od', 'VALINSID': 'valins_id', 
                            'NODEID': 'node_id', 'NODEIP': 'node_ip', 'SLOT': 'slot', 'PORT': 'port', 
                            'ONUSN': 'onu_sn', 'NOINETVALINS': 'no_inet_valins', 'SIP1VALINS': 'sip1_valins', 
                            'SIP2VALINS': 'sip2_valins', 'SID': 'sid'
                        };
                        const dynInputs = document.querySelectorAll('input[name^="dynamic_data["]');
                        dynInputs.forEach(input => {
                            const match = input.name.match(/\[(.*?)\]/);
                            if (match) {
                                const normName = match[1].toUpperCase().replace(/[^A-Z0-9]/g, '');
                                if (map[normName]) {
                                    const physInput = document.querySelector(`input[name="${map[normName]}"]`);
                                    if (physInput) {
                                        physInput.disabled = false;
                                        physInput.value = input.value;
                                    }
                                }
                            }
                        });
                    }
                    return true;
                }
            };
        }
    </script>

    @php
        $formatCatLabel = function($nama) {
            $u = strtoupper(trim($nama));
            return match ($u) {
                'ODP TIDAK SAMA' => 'ODP Tidak Sama',
                'DATEK TIDAK SAMA' => 'Datek Tidak Sama',
                'ODP DAN DATEK TIDAK SAMA', 'ODP & DATEK TIDAK SAMA' => 'ODP & Datek Tidak Sama',
                'NOT IN SERVICE' => 'Not In Service',
                'KENDALA ODP' => 'Kendala ODP',
                default => preg_replace_callback('/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/i', fn($m) => strtoupper($m[0]), ucwords(strtolower($nama)))
            };
        };

        $resolveCatIconType = function($cat) {
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

    <!-- Kontainer Halaman Penuh Dinamis (Lebar Penuh 100%, Simetris & Bebas Ruang Kosong Kiri-Kanan) -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6" x-data="valinsCreateForm()">
        
        <!-- Kartu Formulir Utama: Sudut Membulat Modern, Border Halus, Bebas Elemen Mentah -->
        <div class="w-full bg-white rounded-2xl shadow-2xs border border-slate-200/90 relative">
            
            <!-- Header Kartu: Ikon Lembut, Judul Halaman & Tombol Kembali Stabil (Zero-Jump) -->
            <div class="px-5 sm:px-8 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 rounded-t-2xl">
                <div class="flex items-center gap-3.5">
                    <!-- Wadah ikon persegi membulat berlatar merah muda lembut dengan ikon data database presisi -->
                    <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-5 h-5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-headline font-bold text-slate-900 tracking-tight">
                            Tambah Data Valins
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 font-normal">
                            Lengkapi parameter data rekonsiliasi sesuai kategori yang dipilih.
                        </p>
                    </div>
                </div>

                <!-- Tombol Kembali ke Tabel (Interaktif, Animasi Geser Panah Saat Hover & Respon Taktil Saat Klik) -->
                <a href="{{ route('valins.index') }}" 
                   class="group inline-flex items-center gap-2 h-9 px-3.5 bg-white hover:bg-slate-100/90 active:bg-slate-200/80 text-slate-700 hover:text-slate-900 text-xs font-headline font-semibold rounded-xl border border-slate-200/90 hover:border-slate-300 shadow-2xs hover:shadow-xs active:scale-[0.97] transition-all duration-150 cursor-pointer select-none">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-[#AE0C00] transition-all duration-200 ease-out group-hover:-translate-x-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Tabel</span>
                </a>
            </div>

            <!-- Isi Formulir Utama -->
            <form action="{{ route('valins.store') }}" method="POST" novalidate @submit.prevent="handleSubmit($event)" class="divide-y divide-slate-100">
                @csrf

                <input type="hidden" name="valins_category_id" :value="kategoriAktif ? kategoriAktif.id : ''">

                <!-- Bilah Informasi Ringkasan Galat di Atas Formulir (Muncul jika ada kolom yang belum lengkap) -->
                <div x-show="showErrorBanner && Object.keys(errors).length > 0" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mx-5 sm:mx-8 mt-5 p-3.5 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between gap-3 shadow-2xs"
                     style="display: none;">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-6 h-6 rounded-lg bg-red-100 border border-red-200 text-[#AE0C00] flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                            </svg>
                        </div>
                        <p class="text-xs font-headline font-semibold text-red-900 leading-snug">
                            Terdapat beberapa kolom wajib yang belum dilengkapi. Silakan periksa kolom yang ditandai merah.
                        </p>
                    </div>
                    <button type="button" 
                            @click="showErrorBanner = false" 
                            class="p-1 rounded-lg text-red-400 hover:text-red-700 hover:bg-red-100/60 transition-colors shrink-0" 
                            title="Tutup pemberitahuan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- BAGIAN 1: INFORMASI REGIONAL & KATEGORI TAB -->
                <div class="p-5 sm:p-8 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <h3 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Informasi Regional & Kategori</span>
                        </h3>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-50/80 border border-slate-200/80 text-[11px] font-sans text-slate-600 shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Kolom berlabel <span class="font-semibold text-slate-700">Wajib</span> harus dilengkapi</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Dropdown Kategori Rekonsiliasi Data Kustom Berikon & Bebas Tampilan Mentah -->
                        <div class="space-y-1.5 relative" @click.outside="dropdownOpen = false">
                            <label class="block text-xs font-headline font-bold text-slate-800 flex items-center justify-between">
                                <span>Kategori Rekonsiliasi Data</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>

                            <!-- Input Tersembunyi untuk Jaminan Keutuhan Logika Backend 100% -->
                            <input type="hidden" name="kategori" :value="kategoriPilihan">

                            <!-- Tombol Pemicu Dropdown Kustom (Trigger Button Berikon) -->
                            <div class="relative">
                                <button type="button" 
                                        id="category_dropdown_btn"
                                        @click="dropdownOpen = !dropdownOpen" 
                                        class="w-full h-10 px-3 bg-white border rounded-xl flex items-center justify-between gap-2.5 text-left transition-all duration-150 cursor-pointer select-none"
                                        :class="errors['kategori'] 
                                            ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 shadow-xs ' + (isShaking ? 'valins-anim-shake' : '')
                                            : (dropdownOpen 
                                                ? 'border-[#AE0C00]/60 ring-2 ring-[#AE0C00]/10 shadow-xs' 
                                                : 'border-slate-200/90 hover:border-slate-300 shadow-2xs hover:bg-slate-50/40')">
                                    
                                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                        <!-- Ikon Sisi Kiri: Ikon Grid Kategori 4-Kotak Presisi & Distingtif saat belum ada pilihan -->
                                        <div x-show="!kategoriPilihan" class="w-6 h-6 rounded-lg bg-slate-100 border border-slate-200/70 text-slate-400 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                            </svg>
                                        </div>

                                        <div x-show="kategoriPilihan" class="w-6 h-6 rounded-lg bg-red-50 border border-red-200/70 text-[#AE0C00] flex items-center justify-center shrink-0" style="display: none;">
                                            <!-- ODP Tidak Sama -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'odp'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <!-- Datek Tidak Sama -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'datek'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <!-- ODP & Datek Tidak Sama -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'odp_datek'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                            </svg>
                                            <!-- Not In Service -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'nis'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            <!-- Kendala ODP -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'kendala'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <!-- Kategori Kustom: Server Rack -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_server'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="2" y="2" width="20" height="8" rx="1.5" stroke-width="2"/>
                                                <rect x="2" y="14" width="20" height="8" rx="1.5" stroke-width="2"/>
                                                <line x1="6" y1="6" x2="6.01" y2="6" stroke-width="2" stroke-linecap="round"/>
                                                <line x1="6" y1="18" x2="6.01" y2="18" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            <!-- Kategori Kustom: Microchip / Processor -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_chip'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="5" y="5" width="14" height="14" rx="2" stroke-width="2"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6v6H9zM9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4"/>
                                            </svg>
                                            <!-- Kategori Kustom: Network Topology -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_network'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="3" stroke-width="2"/>
                                                <circle cx="5" cy="19" r="3" stroke-width="2"/>
                                                <circle cx="19" cy="19" r="3" stroke-width="2"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m-5.5 4L10 13.5m4 0l3.5 2.5"/>
                                            </svg>
                                            <!-- Kategori Kustom: Data Matrix / Table -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_table'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                                            </svg>
                                            <!-- Kategori Kustom: Digital Barcode -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_barcode'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16M8 4v16M11 4v16M16 4v16M20 4v16"/>
                                            </svg>
                                            <!-- Kategori Kustom: Data Archive / Folder -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_folder'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                            </svg>
                                            <!-- Kategori Kustom: Asset Label / Tag -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_tag'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <!-- Kategori Kustom: Telemetry / Wireless Signal -->
                                            <svg x-show="getCategoryIconType(kategoriPilihan) === 'custom_signal'" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.343 9.343a15 15 0 0121.214 0"/>
                                            </svg>
                                        </div>

                                        <!-- Teks Kategori / Placeholder Bebas Tanda Strip Ganda -->
                                        <span x-show="!kategoriPilihan" class="text-xs font-headline font-normal text-slate-400 select-none">
                                            Pilih kategori data...
                                        </span>
                                        <span x-show="kategoriPilihan" class="text-xs font-headline font-bold text-slate-800 truncate select-none" x-text="formatCatName(kategoriPilihan)" style="display: none;"></span>
                                    </div>

                                    <!-- Ikon Panah Kanan yang Berputar 180 Derajat Halus Saat Terbuka -->
                                    <div class="flex items-center text-slate-400 transition-colors shrink-0" :class="dropdownOpen ? 'text-[#AE0C00]' : ''">
                                        <svg class="w-4 h-4 transition-transform duration-200 ease-out" :class="dropdownOpen ? 'rotate-180 text-[#AE0C00]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                <!-- Panel Daftar Pilihan Kustom (Custom Floating Popover) -->
                                <div x-show="dropdownOpen" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-1 scale-[0.98]"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
                                     class="absolute left-0 top-full mt-1.5 w-full min-w-[270px] bg-white rounded-2xl shadow-xl border border-slate-200/90 py-1.5 px-1.5 z-50 max-h-72 overflow-y-auto"
                                     style="display: none;">
                                    
                                    <div class="space-y-0.5">
                                        @foreach($categories as $cat)
                                            @php
                                                $iconType = $resolveCatIconType($cat);
                                                $catLabel = $formatCatLabel($cat->nama_kategori);
                                            @endphp

                                            <button type="button"
                                                    @click="pilihKategori('{{ addslashes($cat->nama_kategori) }}')"
                                                    class="w-full group flex items-center justify-between gap-3 px-3 py-2 rounded-xl text-xs font-headline transition-all duration-150 text-left cursor-pointer"
                                                    :class="kategoriPilihan === '{{ addslashes($cat->nama_kategori) }}' 
                                                        ? 'bg-red-50/80 text-[#AE0C00] font-bold' 
                                                        : 'text-slate-700 hover:bg-slate-50/90 hover:text-slate-900 font-semibold'">
                                                
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    <!-- Wadah Ikon Garis Kategori -->
                                                    <div class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 transition-colors"
                                                         :class="kategoriPilihan === '{{ addslashes($cat->nama_kategori) }}' 
                                                             ? 'bg-white text-[#AE0C00] shadow-2xs border border-red-200/60' 
                                                             : 'bg-slate-100/80 text-slate-400 group-hover:text-slate-600 group-hover:bg-slate-200/60'">
                                                        @if($iconType === 'odp')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                            </svg>
                                                        @elseif($iconType === 'datek')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                        @elseif($iconType === 'odp_datek')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                                            </svg>
                                                        @elseif($iconType === 'nis')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                            </svg>
                                                        @elseif($iconType === 'kendala')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_server')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <rect x="2" y="2" width="20" height="8" rx="1.5" stroke-width="2"/>
                                                                <rect x="2" y="14" width="20" height="8" rx="1.5" stroke-width="2"/>
                                                                <line x1="6" y1="6" x2="6.01" y2="6" stroke-width="2" stroke-linecap="round"/>
                                                                <line x1="6" y1="18" x2="6.01" y2="18" stroke-width="2" stroke-linecap="round"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_chip')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <rect x="5" y="5" width="14" height="14" rx="2" stroke-width="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6v6H9zM9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_network')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <circle cx="12" cy="5" r="3" stroke-width="2"/>
                                                                <circle cx="5" cy="19" r="3" stroke-width="2"/>
                                                                <circle cx="19" cy="19" r="3" stroke-width="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m-5.5 4L10 13.5m4 0l3.5 2.5"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_table')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_barcode')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16M8 4v16M11 4v16M16 4v16M20 4v16"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_folder')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                            </svg>
                                                        @elseif($iconType === 'custom_tag')
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.343 9.343a15 15 0 0121.214 0"/>
                                                            </svg>
                                                        @endif
                                                    </div>

                                                    <span class="truncate">{{ $catLabel }}</span>
                                                </div>

                                                <!-- Ikon Tanda Centang Tegas di Ujung Kanan untuk Kategori Aktif -->
                                                <div x-show="kategoriPilihan === '{{ addslashes($cat->nama_kategori) }}'" class="shrink-0" style="display: none;">
                                                    <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Pesan Galat Inline Kategori -->
                            <div x-show="errors['kategori']" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                 style="display: none;">
                                <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                </svg>
                                <span x-text="errors['kategori']"></span>
                            </div>
                        </div>

                        <!-- Parameter Regional Tetap (Mendampingi Pilihan Kategori di Baris Atas) -->
                        <div class="space-y-1.5" x-show="!isDinamis">
                            <label class="block text-xs font-headline font-bold text-slate-500 flex items-center justify-between">
                                <span>TREG</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="number" 
                                   name="treg" 
                                   value="3" 
                                   class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed shadow-2xs outline-none" 
                                   :disabled="isDinamis"
                                   readonly>
                        </div>
                        <div class="space-y-1.5" x-show="!isDinamis">
                            <label class="block text-xs font-headline font-bold text-slate-500 flex items-center justify-between">
                                <span>WITEL</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="text" 
                                   name="witel" 
                                   value="SUKABUMI" 
                                   class="w-full h-10 px-3 text-xs font-headline font-semibold text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed shadow-2xs outline-none" 
                                   :disabled="isDinamis"
                                   readonly>
                        </div>
                        <div class="space-y-1.5" x-show="!isDinamis">
                            <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                <span>STO</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="text" 
                                   name="sto" 
                                   placeholder="Contoh: SKB" 
                                   @input="clearError('sto')"
                                   class="w-full h-10 px-3 text-xs font-headline font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all uppercase" 
                                   :class="errors['sto'] 
                                       ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                       : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'"
                                   :disabled="isDinamis">
                            
                            <!-- Pesan Galat Inline STO -->
                            <div x-show="errors['sto']" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                 style="display: none;">
                                <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                </svg>
                                <span x-text="errors['sto']"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Konfirmasi Inline Singkat Saat Penggantian Kategori dengan Data Terisi -->
                    <div x-show="showResetConfirm" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="p-4 bg-amber-50/90 border border-amber-200/90 rounded-2xl shadow-2xs text-amber-900 mt-2"
                         style="display: none;">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-xs font-headline font-bold text-amber-900">
                                        Pergantian Kategori ke <span class="text-[#AE0C00]" x-text="formatCatName(pendingKategori)"></span>
                                    </h5>
                                    <p class="text-[11px] text-amber-800 font-sans mt-0.5">
                                        Formulir telah berisi data. Apakah Anda ingin mereset kolom parameter yang tidak relevan dengan kategori baru?
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                                <button type="button" 
                                        @click="konfirmasiGantiKategori(true)" 
                                        class="h-8 px-3 rounded-lg bg-[#AE0C00] hover:bg-[#8e0a00] text-white text-xs font-headline font-bold shadow-2xs hover:shadow-xs transition-colors cursor-pointer select-none">
                                    Ya, Reset Kolom
                                </button>
                                <button type="button" 
                                        @click="konfirmasiGantiKategori(false)" 
                                        class="h-8 px-3 rounded-lg bg-white hover:bg-amber-100/70 border border-amber-300 text-amber-900 text-xs font-headline font-semibold shadow-2xs transition-colors cursor-pointer select-none">
                                    Pertahankan Data
                                </button>
                                <button type="button" 
                                        @click="batalGantiKategori()" 
                                        class="h-8 px-2.5 text-xs font-headline font-semibold text-slate-500 hover:text-slate-800 transition-colors cursor-pointer select-none">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KONTANER PANDUAN AWAL (EMPTY STATE BOX SAAT KATEGORI BELUM DIPILIH) -->
                <div x-show="!kategoriPilihan" 
                     x-transition:enter="transition-opacity ease-out duration-250"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="p-6 sm:p-12">
                    <div class="bg-white border-2 border-dashed border-slate-200/90 rounded-2xl p-8 sm:p-12 text-center flex flex-col items-center justify-center max-w-2xl mx-auto shadow-2xs">
                        <!-- Wadah Persegi Membulat Berlatar Merah Muda Lembut dengan Ikon Lapisan Kategori Merah Korporat -->
                        <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-7 h-7 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>

                        <h4 class="text-base sm:text-lg font-headline font-bold text-slate-800 tracking-tight">
                            Pilih Kategori Rekonsiliasi Data
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1.5 max-w-md font-sans leading-relaxed">
                            Tentukan kategori di atas untuk memuat kolom parameter yang sesuai secara otomatis.
                        </p>

                        <!-- Petunjuk Visual Mikro -->
                        <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100/80 border border-slate-200/70 text-slate-600 text-[11px] font-headline font-medium">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            <span>Gunakan menu pilihan kategori di bagian atas</span>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: DATA FISIK BAWAAN (Hanya Aktif Jika Kategori Dipilih & Non-Dinamis) -->
                <div x-show="kategoriPilihan && !isDinamis" 
                     x-transition:enter="transition-opacity ease-out duration-250"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     style="display: none;" 
                     class="p-5 sm:p-8 space-y-6">
                    <div>
                        <h4 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 mb-3">
                            Parameter Data ODP
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>ODP Name</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" 
                                       name="odp_name" 
                                       placeholder="Contoh: ODP-SKB-FCE/8" 
                                       @input="clearError('odp_name')"
                                       class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all" 
                                       :class="errors['odp_name'] 
                                           ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                           : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'" 
                                       :disabled="isDinamis">
                                
                                <div x-show="errors['odp_name']" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                     style="display: none;">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                    </svg>
                                    <span x-text="errors['odp_name']"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Panel ODP</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" 
                                       name="panel_o" 
                                       placeholder="Contoh: PANEL01" 
                                       @input="clearError('panel_o')"
                                       class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all" 
                                       :class="errors['panel_o'] 
                                           ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                           : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'" 
                                       :disabled="isDinamis">
                                
                                <div x-show="errors['panel_o']" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                     style="display: none;">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                    </svg>
                                    <span x-text="errors['panel_o']"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Port ODP</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="number" 
                                       name="port_od" 
                                       min="1"
                                       placeholder="Contoh: 1" 
                                       @input="$event.target.value = $event.target.value.replace(/[^0-9]/g, ''); clearError('port_od')"
                                       class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all" 
                                       :class="errors['port_od'] 
                                           ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                           : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'" 
                                       :disabled="isDinamis">
                                
                                <div x-show="errors['port_od']" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                     style="display: none;">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                    </svg>
                                    <span x-text="errors['port_od']"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 mb-3">
                            Parameter Data Node OLT
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Valins ID</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" name="valins_id" placeholder="12345" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Node ID</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" name="node_id" placeholder="GPON04-D3..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Node IP</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" name="node_ip" placeholder="172.29..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Slot</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="number" name="slot" placeholder="1" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Port</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="number" name="port" placeholder="1" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 mb-3">
                            Parameter Data Layanan
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>ONU SN</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" 
                                       name="onu_sn" 
                                       placeholder="ZTEG... / HWTC..." 
                                       @input="clearError('onu_sn')"
                                       class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all" 
                                       :class="errors['onu_sn'] 
                                           ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                           : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'" 
                                       :disabled="isDinamis">
                                
                                <div x-show="errors['onu_sn']" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                     style="display: none;">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                    </svg>
                                    <span x-text="errors['onu_sn']"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>No Inet Valins</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="no_inet_valins" placeholder="1311..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SIP 1 Valins</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sip1_valins" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SIP 2 Valins</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sip2_valins" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SID</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sid" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: DATA DINAMIS BERDASARKAN KATEGORI (MODERN, BERSIH, BEBAS KOTAK BIRU & BEBAS TABUNG KIMIA) -->
                <div x-show="kategoriPilihan && isDinamis" 
                     x-transition:enter="transition-opacity ease-out duration-250"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     style="display: none;" 
                     class="p-5 sm:p-8">
                    
                    <div class="bg-slate-50/70 rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4">
                        <!-- Kepala Panel Kolom Kustom Dinamis -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-1 border-b border-slate-200/60">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <div class="w-6 h-6 rounded-lg bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-headline font-bold text-slate-800 tracking-tight">
                                    Parameter Data Kategori:
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-red-50 text-[#AE0C00] border border-red-200/80 text-xs font-headline font-bold tracking-tight shadow-2xs"
                                      x-text="formatCatName(kategoriPilihan)">
                                </span>
                            </div>

                            <span class="text-[11px] text-slate-400 font-sans">
                                Kolom di bawah ini otomatis disesuaikan dengan konfigurasi tab aktif
                            </span>
                        </div>

                        <!-- Grid 4 Kolom Proporsional pada Layar Lebar -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 pt-1">
                            <template x-for="(kolom, index) in (kategoriAktif ? kategoriAktif.konfigurasi_kolom.filter(k => !['KETERANGAN', 'TANGGAL', 'PIC'].includes(k.nama.toUpperCase().trim())) : [])" :key="index">
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-headline font-bold text-slate-700 truncate" :for="'dyn_' + kolom.nama">
                                            <span x-text="kolom.nama"></span>
                                        </label>
                                        <span x-show="!isFieldOptional(kolom.nama)" 
                                              class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0 ml-1">
                                            Wajib
                                        </span>
                                        <span x-show="isFieldOptional(kolom.nama)" 
                                              class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0 ml-1">
                                            Opsional
                                        </span>
                                    </div>
                                    <input :type="kolom.tipe" 
                                           :name="'dynamic_data[' + kolom.nama + ']'" 
                                           :id="'dyn_' + kolom.nama"
                                           @input="if (['PORT ODP', 'PORT_ODP', 'PORT OD', 'SLOT', 'PORT'].includes(kolom.nama.toUpperCase().trim())) { $event.target.value = $event.target.value.replace(/[^0-9]/g, '') }; clearError(kolom.nama)"
                                           @change="clearError(kolom.nama)"
                                           class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all placeholder-slate-400" 
                                           :class="errors[kolom.nama] 
                                               ? 'border-[#AE0C00] bg-red-50/20 ring-2 ring-[#AE0C00]/10 ' + (isShaking ? 'valins-anim-shake' : '') 
                                               : 'border-slate-200/90 focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00]'" 
                                           :placeholder="'Masukkan ' + kolom.nama + '...'">
                                    
                                    <!-- Pesan Galat Inline Kolom Dinamis -->
                                    <div x-show="errors[kolom.nama]" 
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 -translate-y-1"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-1"
                                         class="flex items-center gap-1.5 mt-1 text-[11px] font-headline font-semibold text-[#AE0C00]"
                                         style="display: none;">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                            <line x1="12" y1="8" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>
                                            <circle cx="12" cy="16" r="0.75" fill="currentColor"/>
                                        </svg>
                                        <span x-text="errors[kolom.nama]"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: STATUS & PELAKSANA (Tampil Hanya Jika Kategori Dipilih) -->
                <div x-show="Boolean(kategoriPilihan)" 
                     x-transition:enter="transition-opacity ease-out duration-250"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     style="display: none;" 
                     class="p-5 sm:p-8 space-y-4">
                    <h3 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Status & Pelaksana</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Keterangan / Status -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                <span>Keterangan / Status</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                    Opsional
                                </span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="keterangan" 
                                       list="status_options" 
                                       placeholder="Pilih atau ketik status..." 
                                       class="w-full h-10 pl-3 pr-8 text-xs font-headline font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors placeholder-slate-400">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            <datalist id="status_options">
                                <option value="OTB">
                                <option value="DONE">
                                <option value="DONE OLO">
                                <option value="Disconnected">
                                <option value="ASTINET">
                                <option value="ODP TIDAK DITEMUKAN">
                                <option value="DATEK TIDAK SAMA">
                                <option value="KENDALA BI">
                                <option value="TIDAK ADA ODP DI UIM">
                                <option value="WITEL LAIN">
                            </datalist>
                        </div>

                        <!-- Tanggal -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                <span>Tanggal</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                    Opsional
                                </span>
                            </label>
                            <input type="date" 
                                   name="tanggal" 
                                   class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors">
                        </div>

                        <!-- PIC -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                <span>PIC</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                    Opsional
                                </span>
                            </label>
                            <input type="text" 
                                   name="pic" 
                                   placeholder="Contoh: Firdi / LIANTY" 
                                   class="w-full h-10 px-3 text-xs font-headline font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Update / Keterangan Progress (Ukuran Terkunci Proporsional & Resize-None) -->
                    <div class="space-y-1.5 pt-1">
                        <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                            <span>Update / Keterangan Progress</span>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                Opsional
                            </span>
                        </label>
                        <textarea name="update_progress" 
                                  rows="3" 
                                  class="w-full p-3 text-xs font-sans text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors placeholder-slate-400 resize-none" 
                                  placeholder="Contoh: Menunggu validasi tim lapangan..."></textarea>
                    </div>
                </div>

                <!-- BAGIAN 5: BILAH KAKI (FOOTER) & TOMBOL AKSI STABIL (ZERO JUMP) -->
                <div class="px-5 sm:px-8 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end items-center gap-3 rounded-b-2xl">
                    <!-- Tombol Batal: Latar Putih Bersih, Border Abu-abu Halus, Terkunci Stabil Tanpa Lompatan -->
                    <a href="{{ route('valins.index') }}" 
                       class="h-9.5 px-5 inline-flex items-center justify-center bg-white hover:bg-slate-100 text-slate-700 text-xs font-headline font-semibold rounded-xl border border-slate-200/90 shadow-2xs transition-colors cursor-pointer select-none">
                        Batal
                    </a>

                    <!-- Tombol Simpan Data Valins: Aktif hanya jika kategori dipilih -->
                    <button type="submit" 
                            :disabled="!kategoriPilihan"
                            class="h-9.5 px-6 inline-flex items-center justify-center gap-2 text-xs font-headline font-bold rounded-xl transition-all duration-150 select-none"
                            :class="!kategoriPilihan 
                                ? 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none border border-slate-200/80' 
                                : 'bg-[#AE0C00] hover:bg-[#8e0a00] text-white shadow-2xs hover:shadow-xs active:scale-[0.98] cursor-pointer'">
                        <svg class="w-4 h-4" :class="!kategoriPilihan ? 'text-slate-400' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Data Valins</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>