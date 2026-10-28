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

        /* Hilangkan spinner panah bawaan browser pada input type number */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        function valinsEditForm() {
            return {
                kategoriPilihan: '{{ $valins->kategori }}',
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
                isFieldOptional(name) {
                    if (!name) return false;
                    const normalized = name.toUpperCase().replace(/[^A-Z0-9]/g, '');
                    const optionals = ['NOINETVALINS', 'NOINET','SIP1VALINS', 'SIP1', 'SIP2VALINS', 'SIP2', 'SID', 'KETERANGAN', 'STATUS', 'KETERANGANSTATUS', 'TANGGAL', 'PIC', 'UPDATEPROGRESS', 'UPDATE', 'NOTES'];
                    return optionals.includes(normalized);
                },
                getDynamicValue(colName) {
                    const dyn = @json($valins->dynamic_data ?? []);
                    if (dyn && dyn[colName] !== undefined && dyn[colName] !== null) return dyn[colName];
                    
                    const propName = colName.toLowerCase().replace(/ /g, '_');
                    let physical = @json($valins);
                    if (propName === 'panel_odp') return physical['panel_o'] || '';
                    if (propName === 'port_odp') return physical['port_od'] || '';
                    return physical[propName] !== undefined && physical[propName] !== null ? physical[propName] : '';
                },
                validateForm() {
                    this.errors = {};
                    
                    // 1. Validasi STO & Kolom Statis (jika non-dinamis)
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

                    // 2. Validasi Kolom Dinamis (jika dinamis)
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
                // Fitur Cerdas: Sinkronisasi data dinamis ke kolom fisik database sebelum disimpan
                syncBeforeSubmit() {
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
                                        physInput.disabled = false; // Aktifkan input agar terkirim ke backend
                                        physInput.value = input.value; // Salin nilai yang baru diketik
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
            $u = strtoupper(trim($nama ?? ''));
            return match ($u) {
                'ODP TIDAK SAMA' => 'ODP Tidak Sama',
                'DATEK TIDAK SAMA' => 'Datek Tidak Sama',
                'ODP DAN DATEK TIDAK SAMA', 'ODP & DATEK TIDAK SAMA' => 'ODP & Datek Tidak Sama',
                'NOT IN SERVICE' => 'Not In Service',
                'KENDALA ODP' => 'Kendala ODP',
                default => preg_replace_callback('/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/i', fn($m) => strtoupper($m[0]), ucwords(strtolower($nama ?? '')))
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

        $catUpper = strtoupper(trim($valins->kategori ?? ''));
        $matchedCat = $categories->first(function($c) use ($valins, $catUpper) {
            return ($valins->valins_category_id && $c->id == $valins->valins_category_id)
                || strtoupper(trim($c->nama_kategori)) === $catUpper;
        });
        $editIconType = $resolveCatIconType($matchedCat ?? $valins->kategori);
        $editCatLabel = $formatCatLabel($valins->kategori);

        $currentUser = auth()->check() ? auth()->user()->name : 'System';
        $lockedByName = explode('|', $valins->locked_by ?? '')[0];
        $expireTime = now()->subMinutes(15);
        
        // Banner Read-Only HANYA muncul jika namanya beda DAN belum kedaluwarsa
        $isLockedByOther = !empty($valins->locked_by) 
            && $lockedByName !== $currentUser 
            && $valins->locked_at >= $expireTime;
    @endphp

    <!-- Kontainer Halaman Penuh Dinamis (Lebar Penuh 100%, Simetris & Bebas Ruang Kosong Kiri-Kanan) -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6" x-data="valinsEditForm()">
        
        <!-- Kartu Formulir Utama: Sudut Membulat Modern, Border Halus, Bebas Elemen Mentah -->
        <div class="w-full bg-white rounded-2xl shadow-2xs border border-slate-200/90 relative">
            
            <!-- Header Kartu: Ikon Pensil Lembut, Judul Halaman, Badge ID Netral & Tombol Kembali Stabil (Zero-Jump) -->
            <div class="px-5 sm:px-8 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 rounded-t-2xl">
                <div class="flex items-center gap-3.5">
                    <!-- Wadah ikon persegi membulat berlatar merah muda lembut dengan ikon pensil merah korporat -->
                    <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-5 h-5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-headline font-bold text-slate-900 tracking-tight">
                            Edit Data Valins
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 font-normal">
                            Perbarui parameter data rekonsiliasi dan status tindak lanjut sesuai kondisi lapangan.
                        </p>
                    </div>
                </div>

                <!-- Tombol Kembali ke Tabel (100% Stabil di Tempat / Zero Layout Jump) -->
                <a href="{{ route('valins.index') }}" 
                   class="inline-flex items-center gap-2 h-9 px-3.5 bg-white hover:bg-slate-100 text-slate-700 hover:text-slate-900 text-xs font-headline font-semibold rounded-xl border border-slate-200/90 shadow-2xs transition-colors cursor-pointer select-none">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Tabel</span>
                </a>
            </div>

            <!-- Isi Formulir Utama -->
            <form action="{{ route('valins.update', $valins->id) }}" method="POST" novalidate @submit.prevent="handleSubmit($event)" class="divide-y divide-slate-100">
                @csrf
                @method('PUT')

                <input type="hidden" name="valins_category_id" :value="kategoriAktif ? kategoriAktif.id : ''">

                <!-- BANNER PERINGATAN JIKA DATA DIKUNCI OLEH PENGGUNA LAIN -->
                @if($isLockedByOther)
                    <div class="mx-5 sm:mx-8 mt-5 p-4 bg-amber-50/90 border border-amber-200/90 rounded-2xl flex items-center gap-3 text-amber-900 shadow-2xs">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-headline font-bold text-xs text-amber-900">Mode Hanya-Lihat (Read Only)</h4>
                            <p class="text-xs text-amber-800 font-sans mt-0.5">Data ini sedang diproses oleh <strong>{{ $valins->locked_by }}</strong>. Anda tidak dapat menyimpan perubahan pada data ini.</p>
                        </div>
                    </div>
                @endif

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

                <!-- BAGIAN 1: INFORMASI REGIONAL & KATEGORI -->
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

                    <!-- Baris Kategori Terkunci Lega & Bebas Terpotong (Bilah Penuh Bebas Truncate) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-4 bg-slate-50/70 border border-slate-200/80 rounded-2xl">
                        <div class="flex items-center gap-3 flex-wrap">
                            <label class="text-xs font-headline font-bold text-slate-700">
                                Kategori Rekonsiliasi Data:
                            </label>
                            
                            <!-- Lencana Kategori Terkunci Lega & Utuh -->
                            <div class="inline-flex items-center gap-2.5 px-3 py-1.5 bg-white border border-slate-200/90 rounded-xl shadow-2xs">
                                <div class="w-6 h-6 rounded-lg bg-red-50 border border-red-200/70 text-[#AE0C00] flex items-center justify-center shrink-0">
                                    @if($editIconType === 'odp')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    @elseif($editIconType === 'datek')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @elseif($editIconType === 'odp_datek')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                        </svg>
                                    @elseif($editIconType === 'nis')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    @elseif($editIconType === 'kendala')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_server')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="2" y="2" width="20" height="8" rx="1.5" stroke-width="2"/>
                                            <rect x="2" y="14" width="20" height="8" rx="1.5" stroke-width="2"/>
                                            <line x1="6" y1="6" x2="6.01" y2="6" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="6" y1="18" x2="6.01" y2="18" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_chip')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="5" y="5" width="14" height="14" rx="2" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6v6H9zM9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_network')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="3" stroke-width="2"/>
                                            <circle cx="5" cy="19" r="3" stroke-width="2"/>
                                            <circle cx="19" cy="19" r="3" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m-5.5 4L10 13.5m4 0l3.5 2.5"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_table')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_barcode')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16M8 4v16M11 4v16M16 4v16M20 4v16"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_folder')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                    @elseif($editIconType === 'custom_tag')
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.343 9.343a15 15 0 0121.214 0"/>
                                        </svg>
                                    @endif
                                </div>

                                <span class="text-xs font-headline font-bold text-slate-800 whitespace-nowrap">
                                    {{ $editCatLabel }}
                                </span>

                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 border border-amber-200/70 text-amber-700 text-[10px] font-headline font-bold uppercase tracking-wider ml-0.5">
                                    <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Terkunci</span>
                                </span>
                            </div>

                            <!-- Hidden input sebagai pengaman agar nilai kategori tetap terkirim saat form disubmit -->
                            <input type="hidden" name="kategori" value="{{ $valins->kategori }}">
                        </div>

                        <!-- Keterangan Alasan Terkunci -->
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-sans">
                            <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>Kategori dikunci untuk menjaga konsistensi struktur kolom pada data yang sudah tersimpan.</span>
                        </div>
                    </div>

                    <!-- Parameter Regional Tetap (Hanya Aktif Jika Kategori Non-Dinamis) -->
                    <div x-show="!isDinamis" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-1">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-500 flex items-center justify-between">
                                <span>TREG</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="number" 
                                   name="treg" 
                                   value="{{ $valins->treg ?? 3 }}" 
                                   class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed shadow-2xs outline-none no-spinner" 
                                   :disabled="isDinamis"
                                   readonly>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-500 flex items-center justify-between">
                                <span>WITEL</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="text" 
                                   name="witel" 
                                   value="{{ $valins->witel ?? 'SUKABUMI' }}" 
                                   class="w-full h-10 px-3 text-xs font-headline font-semibold text-slate-500 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed shadow-2xs outline-none" 
                                   :disabled="isDinamis"
                                   readonly>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                <span>STO</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                    Wajib
                                </span>
                            </label>
                            <input type="text" 
                                   name="sto" 
                                   value="{{ $valins->sto }}" 
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
                </div>

                <!-- BAGIAN 2: DATA DINAMIS BERDASARKAN KATEGORI (MODERN, BERSIH, BEBAS KOTAK BIRU, GRID 4-KOLOM LEBAR) -->
                <div x-show="isDinamis" class="p-5 sm:p-8">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-red-50 text-[#AE0C00] border border-red-200/80 text-xs font-headline font-bold tracking-tight shadow-2xs">
                                    {{ $editCatLabel }}
                                </span>
                            </div>

                            <span class="text-[11px] text-slate-400 font-sans">
                                Kolom disesuaikan otomatis dengan kategori data
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
                                           :value="getDynamicValue(kolom.nama)"
                                           @input="if (['PORT ODP', 'PORT_ODP', 'PORT OD', 'SLOT', 'PORT'].includes(kolom.nama.toUpperCase().trim())) { $event.target.value = $event.target.value.replace(/[^0-9]/g, '') }; clearError(kolom.nama)"
                                           @change="clearError(kolom.nama)"
                                           class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all placeholder-slate-400 no-spinner" 
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

                <!-- BAGIAN 3: DATA FISIK BAWAAN (Hanya Aktif Jika Kategori Non-Dinamis) -->
                <div x-show="!isDinamis" 
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
                                       value="{{ $valins->odp_name }}" 
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
                                       value="{{ $valins->panel_o ?? $valins->panel_odp }}" 
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
                                       value="{{ $valins->port_od ?? $valins->port_odp }}" 
                                       placeholder="Contoh: 1" 
                                       @input="$event.target.value = $event.target.value.replace(/[^0-9]/g, ''); clearError('port_od')"
                                       class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border rounded-xl outline-none shadow-2xs transition-all no-spinner" 
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
                                <input type="text" name="valins_id" value="{{ $valins->valins_id }}" placeholder="12345" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Node ID</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" name="node_id" value="{{ $valins->node_id }}" placeholder="GPON04-D3..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Node IP</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="text" name="node_ip" value="{{ $valins->node_ip }}" placeholder="172.29..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Slot</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="number" name="slot" value="{{ $valins->slot }}" placeholder="1" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors no-spinner" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>Port</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-red-50 text-[#AE0C00] border border-red-200/60 leading-none shrink-0">
                                        Wajib
                                    </span>
                                </label>
                                <input type="number" name="port" value="{{ $valins->port }}" placeholder="1" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors no-spinner" :disabled="isDinamis">
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
                                       value="{{ $valins->onu_sn }}" 
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
                                <input type="text" name="no_inet_valins" value="{{ $valins->no_inet_valins }}" placeholder="1311..." class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SIP 1 Valins</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sip1_valins" value="{{ $valins->sip1_valins }}" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SIP 2 Valins</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sip2_valins" value="{{ $valins->sip2_valins }}" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-headline font-bold text-slate-700 flex items-center justify-between">
                                    <span>SID</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-sans font-medium bg-slate-100 text-slate-500 border border-slate-200/60 leading-none shrink-0">
                                        Opsional
                                    </span>
                                </label>
                                <input type="text" name="sid" value="{{ $valins->sid }}" placeholder="Opsional" class="w-full h-10 px-3 text-xs font-mono font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors" :disabled="isDinamis">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: STATUS & PELAKSANA -->
                <div class="p-5 sm:p-8 space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-xs font-headline font-bold uppercase tracking-wider text-slate-600 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Status & Pelaksana</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Keterangan / Status dengan chevron dropdown elegan -->
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
                                       value="{{ $valins->keterangan }}"
                                       list="status_options" 
                                       placeholder="Pilih atau ketik status..." 
                                       class="w-full h-10 px-3 pr-8 text-xs font-headline font-semibold text-slate-800 bg-white border border-slate-200/90 rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none shadow-2xs transition-colors placeholder-slate-400">
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
                                   value="{{ $valins->tanggal ? \Carbon\Carbon::parse($valins->tanggal)->format('Y-m-d') : '' }}"
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
                                   value="{{ $valins->pic }}"
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
                                  placeholder="Contoh: Menunggu validasi tim lapangan...">{{ $valins->update_progress }}</textarea>
                    </div>
                </div>

                <!-- BAGIAN 5: BILAH KAKI (FOOTER) & TOMBOL AKSI STABIL (ZERO JUMP) -->
                <div class="px-5 sm:px-8 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end items-center gap-3 rounded-b-2xl">
                    <!-- Tombol Batal: Latar Putih Bersih, Border Abu-abu Halus, Terkunci Stabil Tanpa Lompatan -->
                    <a href="{{ route('valins.index') }}" 
                       class="h-9.5 px-5 inline-flex items-center justify-center bg-white hover:bg-slate-100 text-slate-700 text-xs font-headline font-semibold rounded-xl border border-slate-200/90 shadow-2xs transition-colors cursor-pointer select-none">
                        Batal
                    </a>

                    <!-- Tombol Simpan Perubahan: Merah Korporat (#AE0C00), Ikon Centang Putih, 100% Zero-Jump -->
                    <button type="submit" 
                            @disabled($isLockedByOther)
                            class="h-9.5 px-6 inline-flex items-center justify-center gap-2 text-xs font-headline font-bold rounded-xl transition-colors select-none cursor-pointer {{ $isLockedByOther ? 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none border border-slate-200/80' : 'bg-[#AE0C00] hover:bg-[#8e0a00] text-white shadow-2xs hover:shadow-xs' }}">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ $isLockedByOther ? 'Terkunci (Sedang Diproses)' : 'Simpan Perubahan' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>