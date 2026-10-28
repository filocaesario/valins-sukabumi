<div x-data="dashboardAnalytics({
        stoLabels: {{ json_encode($stoChart['labels']) }},
        stoSeries: {{ json_encode($stoChart['series']) }},
        stoColors: {{ json_encode($stoChart['colors']) }},
        donutLabels: {{ json_encode($donutChart['labels']) }},
        donutSeries: {{ json_encode($donutChart['series']) }},
        donutColors: {{ json_encode($donutChart['colors']) }}
    })" 
    x-init="initCharts()"
    class="space-y-6">

    <!-- Script CDN ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Notifikasi Flash Real-Time -->
    @if (session()->has('dashboard_msg'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 4000)" 
             x-show="show" 
             x-transition 
             class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-xs flex items-center justify-between text-emerald-800">
            <div class="flex items-center gap-2.5 text-xs sm:text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('dashboard_msg') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Scoped Dashboard Entry & Scroll Reveal Animation Styles -->
    <style>
        @keyframes dashFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes dashSlideUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-dashboard-fade {
            animation: dashFadeIn 0.32s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity;
        }
        .animate-dashboard-slide-up {
            opacity: 0;
            animation: dashSlideUp 0.42s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity, transform;
        }
        .dash-delay-1 { animation-delay: 80ms; }
        .dash-delay-2 { animation-delay: 160ms; }
        .dash-delay-3 { animation-delay: 240ms; }
        .dash-delay-4 { animation-delay: 320ms; }
        .dash-delay-5 { animation-delay: 400ms; }
        .dash-delay-6 { animation-delay: 480ms; }

        /* Scroll reveal for charts container */
        .dashboard-reveal-card {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.45s cubic-bezier(0.16, 1, 0.3, 1), transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .dashboard-reveal-card.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-dashboard-fade,
            .animate-dashboard-slide-up,
            .dashboard-reveal-card {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>

    <!-- 1. KONTEN UTAMA: PANEL KENDALI MONITORING VALINS & GPON -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4 sm:p-6 lg:p-7 space-y-6 w-full min-w-0 overflow-hidden">

        <!-- HEADER PANEL KENDALI -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-slate-100 animate-dashboard-fade">
            <div class="space-y-1.5">
                <h1 class="text-xl sm:text-2xl font-headline font-black text-slate-900 tracking-tight">
                    Panel Kendali Monitoring Data Valins & Jaringan GPON Witel Sukabumi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-4xl leading-relaxed">
                    Sistem kendali terpadu deviasi data fisik ODP, kepatuhan rekonsiliasi UIM, dan kesehatan transmisi optik GPON 12 Sentral Telepon Otomat secara real-time.
                </p>
            </div>
        </div>

        <!-- BILAH INFORMASI PRIORITAS REKONSILIASI (BERSIH TANPA GARIS MERAH) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-4.5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-2xs animate-dashboard-slide-up dash-delay-1">
            <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                <!-- Wadah Ikon Peringatan Tenang (Latar Merah Muda Pucat) -->
                <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs mt-0.5 sm:mt-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <!-- Hierarki Teks: Judul Prioritas & Deskripsi Jelas -->
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xs sm:text-sm font-headline font-bold text-slate-900 tracking-tight">
                            Prioritas Rekonsiliasi Sentral STO {{ $kpi['topSto'] }}
                        </h2>
                        <!-- Penanda Ringkas Kasus Aktif -->
                    </div>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Terdeteksi kategori dominan <strong class="text-[#AE0C00] font-semibold">{{ $kpi['topStoCategory'] }}</strong> pada wilayah sentral terkait. Diperlukan rekonsiliasi data lapangan dan pembaruan status pada sistem UIM.
                    </p>
                </div>
            </div>

            <!-- Tombol Aksi Modern & Proporsional -->
            <a href="{{ route('valins.index') }}" 
               class="group inline-flex items-center justify-center gap-1.5 shrink-0 w-full md:w-auto h-9 px-4 text-xs font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8e0a00] active:scale-95 rounded-xl shadow-xs hover:shadow transition-all duration-150 select-none whitespace-nowrap">
                <span>Tinjau Kasus di STO {{ $kpi['topSto'] }}</span>
                <svg class="w-3.5 h-3.5 text-white transition-transform duration-150 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- 2. BARIS 5 KARTU METRIK UTAMA (REAL-TIME KPI STRIP) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Kartu 1: Total Seluruh Data VALINS -->
            <div class="bg-white rounded-xl border border-slate-200/90 p-3.5 sm:p-4 flex flex-col justify-between hover:border-slate-300 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 shadow-2xs group animate-dashboard-slide-up dash-delay-2">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-headline font-bold text-slate-600 tracking-tight leading-snug">Total Data Valins</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200/80 text-slate-600 flex items-center justify-center shrink-0 shadow-2xs" title="Total Berkas Data Valins">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3m-7 3h7m-7 4h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                        {{ number_format($kpi['totalValins']) }}
                    </div>
                </div>
                <div class="mt-3.5 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                    <span class="whitespace-nowrap shrink-0 text-slate-500">Cakupan Wilayah</span>
                    <span class="font-bold text-slate-700 tabular-nums whitespace-nowrap shrink-0">{{ $kpi['totalSto'] }} STO</span>
                </div>
            </div>

            <!-- Kartu 2: Status Lurus (DONE) -->
            <div class="bg-white rounded-xl border border-slate-200/90 p-3.5 sm:p-4 flex flex-col justify-between hover:border-slate-300 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 shadow-2xs group animate-dashboard-slide-up dash-delay-3">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-headline font-bold text-slate-600 tracking-tight leading-snug">Status Lurus (DONE)</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-200/70 text-emerald-600 flex items-center justify-center shrink-0 shadow-2xs" title="Status Sesuai (DONE)">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                        {{ number_format($kpi['doneCount']) }}
                    </div>
                    <!-- Bilah Progres Rasio Kepatuhan di Bawah Angka -->
                    <div class="mt-2.5 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ min(100, $kpi['donePercent']) }}%;"></div>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                    <span class="whitespace-nowrap shrink-0 text-slate-500">Rasio Kepatuhan</span>
                    <span class="font-bold text-emerald-600 tabular-nums whitespace-nowrap shrink-0">{{ $kpi['donePercent'] }}%</span>
                </div>
            </div>

            <!-- Kartu 3: Total Deviasi Data Valins -->
            <div class="bg-white rounded-xl border border-slate-200/90 p-3.5 sm:p-4 flex flex-col justify-between hover:border-slate-300 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 shadow-2xs group animate-dashboard-slide-up dash-delay-4">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-headline font-bold text-slate-600 tracking-tight leading-snug">Total Deviasi Data Valins</span>
                        <div class="w-8 h-8 rounded-lg bg-red-50 border border-red-200/70 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs" title="Perlu Validasi Deviasi">
                            <svg class="w-4 h-4 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-[#AE0C00] tracking-tight tabular-nums">
                        {{ number_format($kpi['deviasiActive']) }}
                    </div>
                    <!-- Bilah Progres Rasio Deviasi di Bawah Angka -->
                    <div class="mt-2.5 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-[#AE0C00] h-1.5 rounded-full transition-all duration-500" style="width: {{ min(100, $kpi['deviasiPercent']) }}%;"></div>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between gap-2 text-[11px] xl:text-xs">
                    <span class="whitespace-nowrap shrink-0 text-slate-500">Deviasi Aktif</span>
                    <div class="flex items-center gap-1 text-right whitespace-nowrap shrink-0">
                        <strong class="font-bold text-[#AE0C00] tabular-nums">{{ $kpi['deviasiPercent'] }}%</strong>
                        <span class="font-normal text-slate-400">dari Total</span>
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Kendala OTB Tercatat -->
            <div class="bg-white rounded-xl border border-slate-200/90 p-3.5 sm:p-4 flex flex-col justify-between hover:border-slate-300 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 shadow-2xs group animate-dashboard-slide-up dash-delay-5">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-headline font-bold text-slate-600 tracking-tight leading-snug">Kendala OTB Tercatat</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200/70 text-amber-600 flex items-center justify-center shrink-0 shadow-2xs" title="Kendala OTB Tercatat">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                        {{ number_format($kpi['otbCount']) }}
                    </div>
                </div>
                <div class="mt-3.5 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                    <span class="whitespace-nowrap shrink-0 text-slate-500">Status Penanganan</span>
                    <span class="font-bold text-amber-600 whitespace-nowrap shrink-0">Terdaftar</span>
                </div>
            </div>

            <!-- Kartu 5: Monitoring OLT & Port -->
            <div class="bg-white rounded-xl border border-slate-200/90 p-3.5 sm:p-4 flex flex-col justify-between hover:border-slate-300 hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 shadow-2xs group animate-dashboard-slide-up dash-delay-6">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-headline font-bold text-slate-600 tracking-tight leading-snug">Monitoring OLT & Port</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200/70 text-blue-600 flex items-center justify-center shrink-0 shadow-2xs" title="Monitoring OLT & Port">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-2xl sm:text-3xl font-headline font-black text-slate-900 tracking-tight tabular-nums">
                        {{ $kpi['totalGponNodes'] }} <span class="text-base sm:text-lg font-normal text-slate-400 font-mono">/ {{ number_format($kpi['totalGponPorts']) }}</span>
                    </div>
                </div>
                <div class="mt-3.5 flex items-center justify-between gap-2 text-[11px] xl:text-xs text-slate-500">
                    <span class="whitespace-nowrap shrink-0 text-slate-500">Node ID Terpasang</span>
                    <div class="flex items-center gap-1 text-right whitespace-nowrap shrink-0">
                        <strong class="font-bold text-blue-600 tabular-nums">{{ number_format($kpi['totalGponPorts']) }}</strong>
                        <span class="font-normal text-slate-400">Port</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. SEKSI GRAFIK: SEBARAN STO & DISTRIBUSI KATEGORI VALINS (APEXCHARTS) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="dashboard-charts-container">

            <!-- KARTU GRAFIK KIRI: SEBARAN KENDALA AKTIF PER STO (7 Kolom) -->
            <div class="lg:col-span-7 bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between dashboard-reveal-card">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-headline font-bold text-slate-900">Sebaran Kendala Aktif per STO (12 Sentral)</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Distribusi deviasi fisik ODP, unspec port, dan kendala status rekonsiliasi di seluruh Witel Sukabumi.</p>
                        </div>

                        <!-- Legend Indikator Warna -->
                        <div class="flex items-center gap-2 text-[10px] text-slate-600 font-semibold self-start sm:self-center font-mono">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-600"></span>Kritis</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Waspada</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>Aman</span>
                        </div>
                    </div>

                    <!-- KANVAS APEXCHARTS BAR -->
                    <div class="mt-4" wire:ignore>
                        <div id="stoBarChart" class="w-full min-h-[250px]"></div>
                    </div>
                </div>

                <!-- Rekomendasi di Bagian Bawah Bar Chart -->
                <div class="mt-4 pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-slate-50/80 p-3 rounded-xl border border-slate-200/60">
                    <div class="flex items-center gap-2 text-xs text-slate-700">
                        <span>Fokus verifikasi deviasi pada sentral <strong class="font-headline font-bold">STO {{ $kpi['topSto'] }}</strong> (<span class="font-mono tabular-nums font-bold">{{ $kpi['topStoCount'] }}</span> kasus aktif).</span>
                    </div>

                    <a href="{{ route('valins.index') }}" 
                       class="inline-flex items-center gap-1 text-xs font-bold text-red-600 hover:text-red-700 hover:underline shrink-0">
                        <span>Buka Filter STO di Valins Services</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- KARTU GRAFIK KANAN: DISTRIBUSI STATUS REKONSILIASI VALINS (5 Kolom) -->
            <div class="lg:col-span-5 bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between dashboard-reveal-card">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div>
                            <h3 class="text-sm font-headline font-bold text-slate-900">Distribusi Status Rekonsiliasi Data Valins</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Klasifikasi kualifikasi <span class="font-mono tabular-nums font-semibold">{{ number_format($donutChart['total']) }}</span> total port data terpasang.</p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                        <!-- KANVAS DONUT CHART (5 Kolom) -->
                        <div class="sm:col-span-5 flex justify-center" wire:ignore>
                            <div id="valinsDonutChart" class="w-full"></div>
                        </div>

                        <!-- RINCIAN KATEGORI & PERSENTASE (7 Kolom - Ruang Lebih Lega, Anti-Terpotong) -->
                        <div class="sm:col-span-7 space-y-2">
                            @foreach ($donutChart['items'] as $item)
                                <div class="flex items-center justify-between text-xs py-1 border-b border-slate-50 last:border-0">
                                    <div class="flex items-center gap-1.5 min-w-0 pr-2">
                                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $item['color'] }};"></span>
                                        <span class="text-slate-700 font-medium text-[11px] whitespace-nowrap" title="{{ $item['label'] }}">
                                            {{ $item['label'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5 shrink-0 font-mono tabular-nums text-right ml-auto pl-2">
                                        <span class="font-bold text-slate-900 text-xs">{{ number_format($item['count']) }}</span>
                                        <span class="text-slate-400 text-[10.5px]">({{ $item['percent'] }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Bagian Bawah Donut Chart -->
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Total Port Terdata: <strong class="text-slate-800 font-mono tabular-nums">{{ number_format($donutChart['total']) }}</strong></span>
                    <span class="font-semibold text-emerald-600 font-mono tabular-nums">Rasio DONE: {{ $donutChart['donePct'] }}%</span>
                </div>
            </div>

        </div>

        <!-- 4. SEKSI TENGAH: INTEGRASI DATA MONITORING GPON & MATRIKS STO -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- KARTU KIRI: DAFTAR NODE OLT & KAPASITAS SLOT GPON (6 Kolom) -->
            <div class="lg:col-span-6 bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-headline font-bold text-slate-900 tracking-tight truncate">Daftar Node ID & Kapasitas Slot GPON</h3>
                                <p class="text-xs text-slate-500 mt-0.5 truncate"><span class="font-mono font-bold text-slate-700">{{ $kpi['totalGponNodes'] }}</span> Node ID Terdata di Jaringan GPON Witel Sukabumi</p>
                            </div>
                        </div>
                    </div>

                    <!-- DAFTAR NODE OLT NYATA DARI MASTER GPON -->
                    <div class="mt-4 space-y-3">
                        @forelse ($gponNodes as $node)
                            <div class="p-3 sm:p-3.5 rounded-xl border border-slate-200/80 hover:border-red-200/90 bg-slate-50/50 hover:bg-red-50/15 hover:shadow-xs transition-all duration-200 flex items-center justify-between gap-3 group">
                                <div class="flex items-center gap-3 min-w-0">
                                    <!-- Ikon Status Terstruktur: Shield Check Normal (Online & Siaga) -->
                                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 border border-emerald-200/90 text-emerald-600 shrink-0 shadow-2xs group-hover:border-emerald-300 transition-colors" title="Status Node: Normal (Online & Siaga)">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>

                                    <div class="space-y-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-slate-900 font-mono tracking-tight group-hover:text-[#AE0C00] transition-colors truncate">
                                                {{ data_get($node, 'node_id') }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex flex-wrap items-center gap-x-2 gap-y-0.5">
                                            <span class="inline-flex items-center gap-1 font-mono text-slate-600">IP: <strong class="text-slate-800 font-bold tabular-nums">{{ data_get($node, 'node_ip', '-') }}</strong></span>
                                            <span class="text-slate-300">•</span>
                                            <span class="inline-flex items-center gap-1 font-mono text-slate-600">Logical: <strong class="text-slate-800 font-bold">{{ data_get($node, 'id_logical_device', '-') }}</strong></span>
                                            <span class="text-slate-300">•</span>
                                            <span class="inline-flex items-center gap-1">STO: <strong class="text-slate-900 font-headline font-bold">{{ data_get($node, 'sto', '-') }}</strong></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <div class="text-xs font-headline font-bold text-slate-900 tabular-nums">{{ data_get($node, 'slot_count', 0) }} Slot Aktif</div>
                                    <div class="text-[10px] text-slate-600 font-bold font-mono tabular-nums mt-0.5">
                                        <span class="text-[#AE0C00] font-black">{{ number_format(data_get($node, 'port_count', 0)) }}</span> Total Port
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-slate-400">
                                Belum ada data Master GPON yang tercatat.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tautan Bawah Menuju Monitoring GPON -->
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Total Akumulasi Port: <strong class="text-slate-900 font-mono tabular-nums">{{ number_format($kpi['totalGponPorts']) }}</strong></span>
                    <a href="{{ route('master-gpon.index') }}" 
                       class="text-xs font-bold text-[#AE0C00] hover:text-red-700 inline-flex items-center gap-1.5 group transition-colors">
                        <span>Kelola {{ $kpi['totalGponNodes'] }} Node ID</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- KARTU KANAN: MATRIKS 5 STO PRIORITAS & AKSI CEPAT (6 Kolom) -->
            <div class="lg:col-span-6 flex flex-col gap-4">
                <!-- KARTU MATRIKS 5 STO PRIORITAS HARIAN (MANDIRI) -->
                <div class="bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between flex-1">
                    <div>
                        <!-- Header Kartu: Teks Subjudul Utuh & Kotak Ikon Merah Simetris -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-slate-100 gap-3">
                            <div class="flex items-start sm:items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-headline font-bold text-slate-900 tracking-tight">Matriks 5 STO Prioritas Harian Witel Sukabumi</h3>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Indeks kendala data Valins, kapasitas port GPON, dan status siaga lapangan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 5 KOTAK STO BERDAMPINGAN DENGAN MINI PROGRESS BAR & IKON TERSTRUKTUR -->
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-2.5 sm:gap-3">
                            @foreach ($stoMatrix as $item)
                                @php
                                    $isKritis = $item['status_level'] === 'KRITIS';
                                    $isWaspada = $item['status_level'] === 'WASPADA';
                                    $topAccent = $isKritis ? 'border-t-2 border-t-[#AE0C00]' : ($isWaspada ? 'border-t-2 border-t-amber-500' : 'border-t-2 border-t-emerald-500');
                                    $progressColor = $isKritis ? 'bg-gradient-to-r from-red-500 to-[#AE0C00]' : ($isWaspada ? 'bg-gradient-to-r from-amber-400 to-amber-600' : 'bg-emerald-500');
                                    $progressWidth = min(100, max(15, round(($item['deviasi'] / 62) * 100)));
                                @endphp
                                <div class="p-3 rounded-xl border border-slate-200/90 {{ $topAccent }} bg-slate-50/50 hover:bg-white hover:-translate-y-0.5 hover:shadow-sm hover:border-slate-300 transition-all duration-200 flex flex-col justify-between text-left group">
                                    <div>
                                        <!-- Baris Kode STO & Ikon Status Terstruktur -->
                                        <div class="flex items-start justify-between gap-1">
                                            <div class="min-w-0">
                                                <span class="text-xs font-headline font-black text-slate-900 tracking-tight block group-hover:text-[#AE0C00] transition-colors">{{ $item['sto'] }}</span>
                                                <span class="text-[9px] text-slate-400 font-medium truncate block leading-tight mt-0.5">{{ $item['name'] }}</span>
                                            </div>
                                            
                                            @if ($isKritis)
                                                <!-- Ikon Terstruktur Kritis: Alert Octagon Merah -->
                                                <div class="w-6 h-6 rounded-lg bg-red-50 border border-red-200/90 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs group-hover:border-red-300 transition-colors" title="Status Sentral: KRITIS (≥ 10 Kasus Deviasi Aktif)">
                                                    <svg class="w-3.5 h-3.5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                            @elseif ($isWaspada)
                                                <!-- Ikon Terstruktur Waspada: Alert Triangle Amber -->
                                                <div class="w-6 h-6 rounded-lg bg-amber-50 border border-amber-200/90 text-amber-700 flex items-center justify-center shrink-0 shadow-2xs group-hover:border-amber-300 transition-colors" title="Status Sentral: WASPADA (4-9 Kasus Deviasi)">
                                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <!-- Ikon Terstruktur Aman: Check Shield Emerald -->
                                                <div class="w-6 h-6 rounded-lg bg-emerald-50 border border-emerald-200/90 text-emerald-700 flex items-center justify-center shrink-0 shadow-2xs group-hover:border-emerald-300 transition-colors" title="Status Sentral: AMAN (≤ 3 Kasus Deviasi)">
                                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Angka Kasus & Mini Progress Bar -->
                                        <div class="mt-2.5">
                                            <div class="text-lg sm:text-xl font-headline font-black text-slate-900 tabular-nums leading-none">
                                                {{ $item['deviasi'] }} <span class="text-[10px] font-normal text-slate-400 font-sans">Kasus</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-200/70 rounded-full overflow-hidden mt-1.5">
                                                <div class="h-full rounded-full {{ $progressColor }}" style="width: {{ $progressWidth }}%;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rincian Kapasitas dalam Area Lembut (Terkunci Tidak Terlipat) -->
                                    <div class="mt-3 p-1.5 rounded-lg bg-slate-100/70 border border-slate-200/60 text-[9px] text-slate-500 font-mono tabular-nums space-y-0.5">
                                        <div class="flex items-center justify-between text-slate-600 whitespace-nowrap">
                                            <span>Node:</span>
                                            <strong class="text-slate-800">{{ $item['gpon_nodes'] }}</strong>
                                        </div>
                                        <div class="flex items-center justify-between text-slate-600 whitespace-nowrap">
                                            <span>Port:</span>
                                            <strong class="text-slate-900 font-bold">{{ number_format($item['gpon_ports']) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Footer Kartu Matriks 5 STO -->
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Prioritas Pengawasan: <strong class="text-slate-800 font-headline font-bold">5 Sentral Terbesar</strong></span>
                    </div>
                </div>

                <!-- BILAH AKSI CEPAT PENGELOLAAN DATA SIM (MANDIRI & TERPISAH DI BAWAH MATRIKS 5 STO) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 border-l-[4px] border-l-[#AE0C00] shadow-2xs p-3.5 sm:p-4 flex flex-col sm:flex-row items-center justify-between gap-4 transition-all duration-200 shrink-0">
                    <!-- Kelompok Informasi: Ikon Database & Teks Judul-Deskripsi Ramping Sejajar Tengah -->
                    <div class="flex items-center gap-3 sm:gap-3.5 min-w-0 flex-1">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-50 border border-red-200/70 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs">
                            <svg class="w-4.5 h-4.5 sm:w-5 sm:h-5 text-[#AE0C00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3m-7 3h7m-7 4h4" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 flex flex-col justify-center">
                            <h4 class="text-xs sm:text-sm font-headline font-bold text-slate-900 tracking-tight whitespace-nowrap">Aksi Cepat Pengelolaan Data</h4>
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 leading-snug">Pembaruan langsung data Valins, ODP, dan Master GPON Sukabumi.</p>
                        </div>
                    </div>

                    <!-- Kelompok Tombol Aksi (Ergonomis, Terkunci & Jarak Sela Tegas Sejajar Tengah) -->
                    <div class="flex items-center gap-2 sm:gap-2.5 w-full sm:w-auto shrink-0 justify-end">
                        <a href="{{ route('valins.create') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-3.5 text-xs font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8e0a00] active:scale-95 rounded-xl transition-all duration-150 shadow-xs hover:shadow whitespace-nowrap select-none">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            <span>Data Valins</span>
                        </a>
                        <a href="{{ route('master-gpon.index') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-3.5 text-xs font-headline font-bold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-slate-300 active:scale-95 rounded-xl transition-all duration-150 shadow-2xs whitespace-nowrap select-none">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                            <span>Kelola GPON</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- 5. TABEL BAWAH: DAFTAR DEVIASI DATA VALINS TERKINI (SKEMA DATABASE NYATA) -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-5 space-y-4 shadow-2xs">
             
            <!-- Header Tabel & Filter Pencarian (Fleksibel, Seimbang & Bebas Terpotong) -->
            <div class="flex flex-col 2xl:flex-row 2xl:items-center justify-between gap-3.5 pb-3.5 border-b border-slate-100">
                <!-- Blok Judul Sisi Kiri (Utuh, Teks Tidak Terpotong, Jarak Aman Terkunci) -->
                <div class="flex items-start sm:items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-200/80 text-[#AE0C00] flex items-center justify-center shrink-0 shadow-2xs mt-0.5 sm:mt-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 min-w-0">
                            <h3 class="text-sm font-headline font-bold text-slate-900 tracking-tight">Antrean Deviasi Data Valins & Rekonsiliasi Lapangan</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Inspeksi deviasi UIM, keselarasan data ODP, dan port OLT di seluruh sentral Sukabumi.</p>
                    </div>
                </div>

                <!-- Toolbar Kontrol Filter Sisi Kanan (Adaptif, Fleksibel & Bebas Terpotong) -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-2.5 w-full 2xl:w-auto justify-start 2xl:justify-end select-none">
                    <!-- 1. Search Input dengan Clear Button & Live Indicator (Tinggi Seragam h-9) -->
                    <div class="relative flex-1 min-w-[180px] sm:min-w-[220px] 2xl:w-56 2xl:flex-none">
                        <input type="text" 
                               wire:model.live.debounce.350ms="search" 
                               placeholder="Cari ODP, Valins, Node, STO..." 
                               class="w-full h-9 pl-8 pr-7 text-xs border rounded-xl focus:border-[#AE0C00] focus:ring-1 focus:ring-[#AE0C00] outline-none transition placeholder-slate-400 font-sans shadow-2xs {{ !empty($search) ? 'border-[#AE0C00] ring-1 ring-[#AE0C00] text-[#AE0C00] font-semibold bg-red-50/15' : 'border-slate-200/90 text-slate-800 bg-white hover:border-slate-300' }}">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        @if (!empty($search))
                            <button type="button" 
                                    wire:click="$set('search', '')" 
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition" 
                                    title="Hapus pencarian">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        @endif
                    </div>

                    <!-- 2. Filter Dropdown STO Kustom (Enterprise Popover) -->
                    <div class="relative shrink-0" 
                         x-data="{ open: false }" 
                         @click.outside="open = false" 
                         @keydown.escape.window="open = false"
                         wire:key="custom-dropdown-filter-sto">
                        <!-- Trigger Button -->
                        <button type="button" 
                                @click="open = !open" 
                                class="group inline-flex items-center gap-2 h-9 px-3 text-xs font-headline rounded-xl border transition-all duration-150 shadow-2xs whitespace-nowrap cursor-pointer select-none bg-white {{ !empty($filterSto) ? 'border-[#AE0C00] ring-1 ring-[#AE0C00] text-[#AE0C00] font-bold bg-red-50/15' : 'border-slate-200/90 text-slate-700 font-semibold hover:border-slate-300 hover:text-slate-900' }}"
                                title="Filter berdasarkan Sentral STO">
                            <!-- Ikon Garis Gedung Sentral -->
                            <svg class="w-3.5 h-3.5 {{ !empty($filterSto) ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }} shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            
                            @if (!empty($filterSto))
                                <span>STO {{ $filterSto }}</span>
                            @else
                                <span class="flex items-center gap-1.5">
                                    <span>Semua STO</span>
                                    <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold font-sans rounded-md bg-slate-100 text-slate-600 border border-slate-200/90 leading-none">{{ count($filterOptions['stos']) }}</span>
                                </span>
                            @endif

                            <!-- Chevron Panah Berputar Halus -->
                            <svg class="w-3.5 h-3.5 {{ !empty($filterSto) ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }} transition-transform duration-200 shrink-0" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Popover Menu Melayang -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             x-cloak
                             class="absolute left-0 mt-1.5 min-w-[190px] w-max max-w-xs bg-white rounded-xl border border-slate-200/90 shadow-lg py-1 z-40 focus:outline-none">
                            
                            <!-- Opsi Semua STO -->
                            <button type="button" 
                                    wire:click="$set('filterSto', '')" 
                                    @click="open = false" 
                                    class="w-full text-left px-3 py-2 text-xs flex items-center justify-between transition-colors {{ empty($filterSto) ? 'bg-red-50/70 text-[#AE0C00] font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                <span class="flex items-center gap-1.5">
                                    <span>Semua STO</span>
                                    <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold font-sans rounded-md {{ empty($filterSto) ? 'bg-red-100 text-[#AE0C00] border border-red-200/60' : 'bg-slate-100 text-slate-600 border border-slate-200/90' }} leading-none">{{ count($filterOptions['stos']) }}</span>
                                </span>
                                @if (empty($filterSto))
                                    <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>

                            <div class="h-px bg-slate-100 my-1"></div>

                            <!-- Daftar 12 STO dengan Bilah Gulir Vertikal Ramping (Tanpa Titik Warna) -->
                            <div class="max-h-56 overflow-y-auto overscroll-contain divide-y divide-slate-50">
                                @foreach ($filterOptions['stos'] as $sto)
                                    <button type="button" 
                                            wire:click="$set('filterSto', '{{ $sto }}')" 
                                            @click="open = false" 
                                            class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between transition-colors {{ $filterSto === $sto ? 'bg-red-50/70 text-[#AE0C00] font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                        <span>STO {{ $sto }}</span>
                                        @if ($filterSto === $sto)
                                            <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 3. Filter Dropdown Status / Kategori Kustom (Lebar Proporsional & Enterprise Popover) -->
                    <div class="relative shrink-0" 
                         x-data="{ open: false }" 
                         @click.outside="open = false" 
                         @keydown.escape.window="open = false"
                         wire:key="custom-dropdown-filter-status">
                        <!-- Trigger Button -->
                        <button type="button" 
                                @click="open = !open" 
                                class="group inline-flex items-center gap-2 h-9 px-3 text-xs font-headline rounded-xl border transition-all duration-150 shadow-2xs whitespace-nowrap cursor-pointer select-none bg-white {{ !empty($filterStatus) ? 'border-[#AE0C00] ring-1 ring-[#AE0C00] text-[#AE0C00] font-bold bg-red-50/15' : 'border-slate-200/90 text-slate-700 font-semibold hover:border-slate-300 hover:text-slate-900' }}"
                                title="Filter berdasarkan Kategori Deviasi">
                            <!-- Ikon Garis Lapisan Kategori / Filter -->
                            <svg class="w-3.5 h-3.5 {{ !empty($filterStatus) ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }} shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            
                            <span>{{ !empty($filterStatus) ? $filterStatus : 'Semua Kategori' }}</span>

                            <!-- Chevron Panah Berputar Halus -->
                            <svg class="w-3.5 h-3.5 {{ !empty($filterStatus) ? 'text-[#AE0C00]' : 'text-slate-400 group-hover:text-slate-600' }} transition-transform duration-200 shrink-0" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Popover Menu Melayang -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             x-cloak
                             class="absolute left-0 sm:left-auto sm:right-0 mt-1.5 min-w-[210px] w-max max-w-sm bg-white rounded-xl border border-slate-200/90 shadow-lg py-1 z-40 focus:outline-none">
                            
                            <!-- Opsi Semua Kategori -->
                            <button type="button" 
                                    wire:click="$set('filterStatus', '')" 
                                    @click="open = false" 
                                    class="w-full text-left px-3 py-2 text-xs flex items-center justify-between transition-colors {{ empty($filterStatus) ? 'bg-red-50/70 text-[#AE0C00] font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                <span>Semua Kategori</span>
                                @if (empty($filterStatus))
                                    <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>

                            <div class="h-px bg-slate-100 my-1"></div>

                            <!-- Daftar Kategori Deviasi (Teks Arang Bersih Tanpa Titik Warna) -->
                            <div class="max-h-60 overflow-y-auto overscroll-contain divide-y divide-slate-50">
                                @foreach ($filterOptions['categories'] as $cat)
                                    <button type="button" 
                                            wire:click="$set('filterStatus', '{{ $cat }}')" 
                                            @click="open = false" 
                                            class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between gap-3 transition-colors {{ $filterStatus === $cat ? 'bg-red-50/70 text-[#AE0C00] font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                        <span class="truncate">{{ $cat }}</span>
                                        @if ($filterStatus === $cat)
                                            <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 4. Filter Dropdown Per Page Kustom (Ukuran Ringkas & Padat h-9) -->
                    <div class="relative shrink-0" 
                         x-data="{ open: false }" 
                         @click.outside="open = false" 
                         @keydown.escape.window="open = false"
                         wire:key="custom-dropdown-filter-perpage">
                        <!-- Trigger Button -->
                        <button type="button" 
                                @click="open = !open" 
                                class="group inline-flex items-center gap-1.5 h-9 px-2.5 text-xs font-headline font-semibold rounded-xl border border-slate-200/90 hover:border-slate-300 text-slate-700 hover:text-slate-900 bg-white transition-all duration-150 shadow-2xs whitespace-nowrap cursor-pointer select-none"
                                title="Jumlah baris data per halaman">
                            <!-- Ikon Garis Susunan Baris Tabel -->
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            
                            <span>{{ $perPage }} baris</span>

                            <!-- Chevron Panah Berputar Halus -->
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200 shrink-0" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Popover Menu Melayang -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             x-cloak
                             class="absolute right-0 mt-1.5 w-32 bg-white rounded-xl border border-slate-200/90 shadow-lg py-1 z-40 focus:outline-none">
                            @foreach ([5, 10, 15, 25, 50] as $count)
                                <button type="button" 
                                        wire:click="$set('perPage', {{ $count }})" 
                                        @click="open = false" 
                                        class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between transition-colors {{ (int)$perPage === $count ? 'bg-red-50/70 text-[#AE0C00] font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                    <span>{{ $count }} baris</span>
                                    @if ((int)$perPage === $count)
                                        <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 5. Tombol Reset Ringkas Berikon Putar Ulang (Tinggi Seragam h-9) -->
                    @if ($isFiltered)
                        <button type="button" 
                                wire:click="resetFilters" 
                                class="inline-flex items-center gap-1.5 h-9 px-3 text-xs font-headline font-bold text-slate-700 hover:text-[#AE0C00] bg-slate-100 hover:bg-red-50 border border-slate-200/90 hover:border-red-200 rounded-xl transition shadow-2xs cursor-pointer active:scale-95 shrink-0 whitespace-nowrap"
                                title="Reset semua filter dan pencarian">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Reset</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Tabel Data Deviasi Nyata Berstandar Enterprise Telkom Akses (Kunci Kolom Table-Fixed & Full Grid Sheets/Excel) -->
            <div class="overflow-x-auto rounded-xl border border-slate-200/90 shadow-2xs min-h-[380px] transition-all duration-300">
                <table class="w-full min-w-[760px] lg:min-w-full table-fixed border-collapse text-left text-xs">
                    <colgroup>
                        @if ($isCustomCategory)
                            @foreach ($dynamicColumns as $col)
                                <col style="width: {{ $col['width'] }}">
                            @endforeach
                            <col class="w-[16%]"> <!-- KATEGORI STATUS -->
                            <col class="w-[9%]">  <!-- AKSI -->
                        @else
                            <col class="w-[14%]"> <!-- 1. WITEL & STO -->
                            <col class="w-[19%]"> <!-- 2. ODP NAME -->
                            <col class="w-[11%]"> <!-- 3. VALINS ID -->
                            <col class="w-[18%]"> <!-- 4. NODE ID & IP -->
                            <col class="w-[13%]"> <!-- 5. SLOT & PORT OLT -->
                            <col class="w-[16%]"> <!-- 6. KATEGORI STATUS -->
                            <col class="w-[9%]">  <!-- 7. AKSI -->
                        @endif
                    </colgroup>
                    <thead class="bg-slate-100/90 text-slate-700 font-headline font-bold uppercase tracking-wider text-[10px] border-b-2 border-slate-200">
                        <tr>
                            @if ($isCustomCategory)
                                @foreach ($dynamicColumns as $col)
                                    <th scope="col" style="width: {{ $col['width'] }}" class="px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">{{ $col['label'] }}</th>
                                @endforeach
                                <th scope="col" class="w-[16%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">KATEGORI STATUS</th>
                                <th scope="col" class="w-[9%] px-3.5 py-3 whitespace-nowrap truncate text-center">AKSI</th>
                            @else
                                <th scope="col" class="w-[14%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">WITEL & STO</th>
                                <th scope="col" class="w-[19%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">ODP NAME</th>
                                <th scope="col" class="w-[11%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-center">VALINS ID</th>
                                <th scope="col" class="w-[18%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">NODE ID & IP</th>
                                <th scope="col" class="w-[13%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-center">SLOT & PORT OLT</th>
                                <th scope="col" class="w-[16%] px-3.5 py-3 whitespace-nowrap truncate border-r border-slate-200/90 text-left">KATEGORI STATUS</th>
                                <th scope="col" class="w-[9%] px-3.5 py-3 whitespace-nowrap truncate text-center">AKSI</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <!-- SKELETON ROWS: Penggantian In-Place Tepat di Kolom yang Sama Saat Loading (Tinggi Kalibrasi 1:1) -->
                        @for ($i = 0; $i < (int)($perPage ?? 10); $i++)
                            <tr wire:key="skeleton-row-{{ $i }}"
                                wire:loading.class.remove="hidden" 
                                wire:target="search,filterSto,filterStatus,perPage,resetFilters,previousPage,nextPage,gotoPage" 
                                class="hidden skeleton-row animate-pulse h-[62px] min-h-[62px] border-b border-slate-200/80">
                                @if ($isCustomCategory)
                                    @foreach ($dynamicColumns as $col)
                                        <td style="width: {{ $col['width'] }}" class="px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                            <div class="h-4 w-20 rounded bg-slate-200/90"></div>
                                        </td>
                                    @endforeach
                                    <td class="w-[16%] px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                        <div class="flex flex-col gap-1.5 min-w-0">
                                            <div class="h-5.5 w-24 rounded-md bg-slate-200/90"></div>
                                            <div class="h-2.5 w-16 rounded bg-slate-200/70"></div>
                                        </div>
                                    </td>
                                    <td class="w-[9%] px-3.5 py-3 whitespace-nowrap text-center align-middle">
                                        <div class="h-7 w-16 rounded-lg bg-slate-200/90 mx-auto"></div>
                                    </td>
                                @else
                                    <!-- 1. WILAYAH & STO Skeleton -->
                                    <td class="w-[14%] px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-11 rounded-md bg-slate-200/90 shrink-0"></div>
                                            <div class="flex flex-col gap-1.5 min-w-0">
                                                <div class="h-2.5 w-11 rounded bg-slate-200/70"></div>
                                                <div class="h-3 w-16 rounded bg-slate-200/90"></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 2. IDENTITAS ODP & PANEL Skeleton -->
                                    <td class="w-[19%] px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                        <div class="flex flex-col gap-1.5 min-w-0">
                                            <div class="h-3.5 w-32 rounded bg-slate-200/90"></div>
                                            <div class="flex items-center gap-1.5">
                                                <div class="h-4 w-14 rounded bg-slate-200/70"></div>
                                                <div class="h-4 w-12 rounded bg-slate-200/70"></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 3. VALINS ID Skeleton -->
                                    <td class="w-[11%] px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                        <div class="h-4 w-16 rounded bg-slate-200/90 mx-auto"></div>
                                    </td>

                                    <!-- 4. KONFIGURASI NODE GPON Skeleton -->
                                    <td class="w-[18%] px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                        <div class="flex flex-col gap-1.5 min-w-0">
                                            <div class="h-3.5 w-24 rounded bg-slate-200/90"></div>
                                            <div class="h-3 w-28 rounded bg-slate-200/70"></div>
                                        </div>
                                    </td>

                                    <!-- 5. SLOT & PORT OLT Skeleton -->
                                    <td class="w-[13%] px-3.5 py-3 whitespace-nowrap text-center align-middle border-r border-slate-200/80">
                                        <div class="inline-flex items-center justify-center gap-1.5 px-2 py-1 rounded-lg bg-slate-100 border border-slate-200/70 mx-auto">
                                            <div class="h-3.5 w-10 rounded bg-slate-200/90"></div>
                                            <div class="h-1.5 w-1.5 rounded-full bg-slate-300"></div>
                                            <div class="h-3.5 w-10 rounded bg-slate-200/90"></div>
                                        </div>
                                    </td>

                                    <!-- 6. KATEGORI STATUS Skeleton -->
                                    <td class="w-[16%] px-3.5 py-3 whitespace-nowrap align-middle border-r border-slate-200/80">
                                        <div class="flex flex-col gap-1.5 min-w-0">
                                            <div class="h-5.5 w-24 rounded-md bg-slate-200/90"></div>
                                            <div class="h-2.5 w-16 rounded bg-slate-200/70"></div>
                                        </div>
                                    </td>

                                    <!-- 7. AKSI CEPAT Skeleton -->
                                    <td class="w-[9%] px-3.5 py-3 whitespace-nowrap text-center align-middle">
                                        <div class="h-7 w-16 rounded-lg bg-slate-200/90 mx-auto"></div>
                                    </td>
                                @endif
                            </tr>
                        @endfor

                        <!-- DATA REAL ROWS: Disembunyikan Saat Status Memuat -->
                        @forelse ($valinsDeviations as $item)
                            <tr wire:key="real-row-{{ $item->id }}"
                                wire:loading.class="hidden" 
                                wire:target="search,filterSto,filterStatus,perPage,resetFilters,previousPage,nextPage,gotoPage" 
                                class="hover:bg-slate-50/80 transition-colors group h-[62px] min-h-[62px] border-b border-slate-200/90">
                                @if ($isCustomCategory)
                                    @foreach ($dynamicColumns as $col)
                                        @php
                                            $val = $this->extractValue($item, $col['name']);
                                            $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', $col['name']));
                                        @endphp
                                        <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                                            @if ($norm === 'STO')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-slate-100 group-hover:bg-red-50 text-slate-800 group-hover:text-[#AE0C00] border border-slate-200/90 group-hover:border-red-200 font-headline tracking-wide transition-colors shadow-2xs">
                                                    {{ $val }}
                                                </span>
                                            @elseif ($norm === 'TREG')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 font-mono">
                                                    TREG {{ $val }}
                                                </span>
                                            @elseif ($norm === 'WITEL')
                                                <span class="text-[11px] font-bold text-slate-700 font-mono leading-tight">
                                                    {{ $val }}
                                                </span>
                                            @elseif (str_contains($norm, 'QR'))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-mono font-bold bg-red-50 text-[#AE0C00] border border-red-200/80 tracking-wide shadow-2xs">
                                                    <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                                    <span>{{ $val }}</span>
                                                </span>
                                            @else
                                                <span class="font-mono text-[11px] text-slate-800 font-medium">
                                                    {{ $val }}
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                @else
                                    <!-- 1. WILAYAH & STO -->
                                    <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-slate-100 group-hover:bg-red-50 text-slate-800 group-hover:text-[#AE0C00] border border-slate-200/90 group-hover:border-red-200 font-headline tracking-wide transition-colors shadow-2xs">
                                                {{ $item->sto ?? '-' }}
                                            </span>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] text-slate-400 font-medium">TREG {{ $item->treg ?? 3 }}</span>
                                                <span class="text-[11px] font-bold text-slate-700 font-mono leading-tight">{{ $item->witel ?? 'SUKABUMI' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 2. IDENTITAS ODP & PANEL (Dengan Fallback Cerdas untuk Kategori Dinamis/Kustom) -->
                                    <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                                        @if (!empty($item->odp_name) && $item->odp_name !== '-')
                                            <div class="font-bold text-slate-900 font-mono text-[11px] group-hover:text-[#AE0C00] transition-colors truncate">
                                                {{ $item->odp_name }}
                                            </div>
                                            @if (!empty($item->panel_o) || !empty($item->port_od))
                                                <div class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded bg-slate-100 text-[9.5px] text-slate-600 font-mono mt-0.5 border border-slate-200/60">
                                                    <span>{{ $item->panel_o ?? 'PANEL01' }}</span>
                                                    <span class="text-slate-300">•</span>
                                                    <span>Port {{ $item->port_od ?? '-' }}</span>
                                                </div>
                                            @endif
                                        @else
                                            @php
                                                $dynId = $this->getPrimaryDynamicIdentifier($item);
                                            @endphp
                                            @if ($dynId['value'] !== '-')
                                                <div class="font-bold text-[#AE0C00] font-mono text-[11px] group-hover:text-[#AE0C00] transition-colors truncate flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-[#AE0C00] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                                    <span>{{ $dynId['value'] }}</span>
                                                </div>
                                                <div class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded bg-red-50 text-[9.5px] text-[#AE0C00] font-mono mt-0.5 border border-red-200/60">
                                                    <span>{{ $dynId['label'] }}</span>
                                                </div>
                                            @else
                                                <span class="text-slate-400 font-mono text-[11px]">-</span>
                                            @endif
                                        @endif
                                    </td>

                                    <!-- 3. VALINS ID (Bersih Tanpa Kotak Ganda, Tepat di Tengah Sel) -->
                                    <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle border-r border-slate-200/90">
                                        @if (!empty($item->valins_id) && $item->valins_id !== '-')
                                            <span class="font-mono font-bold text-slate-900 text-xs tabular-nums tracking-tight">
                                                {{ $item->valins_id }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 font-mono text-xs">-</span>
                                        @endif
                                    </td>

                                    <!-- 4. KONFIGURASI NODE GPON -->
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

                                    <!-- 5. SLOT & PORT OLT (Terpusat Rapi di Tengah Sel) -->
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

                                <!-- 6. KATEGORI STATUS DENGAN IKON TERSTRUKTUR & EXTRA INFO -->
                                <td class="px-3.5 py-2.5 whitespace-nowrap align-middle border-r border-slate-200/90">
                                    @php
                                        $catUpper = strtoupper($item->kategori ?? '');
                                        $badgeConfig = match ($catUpper) {
                                            'DONE' => [
                                                'bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5l2.5 2.5 5-5"/></svg>',
                                            ],
                                            'DONE OLO' => [
                                                'bg' => 'bg-cyan-50 text-cyan-800 border-cyan-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
                                            ],
                                            'ODP TIDAK SAMA' => [
                                                'bg' => 'bg-cyan-50 text-cyan-800 border-cyan-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
                                            ],
                                            'DATEK TIDAK SAMA' => [
                                                'bg' => 'bg-amber-50 text-amber-800 border-amber-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                                            ],
                                            'ODP DAN DATEK TIDAK SAMA' => [
                                                'bg' => 'bg-orange-50 text-orange-800 border-orange-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-orange-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                            ],
                                            'NOT IN SERVICE' => [
                                                'bg' => 'bg-purple-50 text-purple-800 border-purple-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>',
                                            ],
                                            'KENDALA ODP' => [
                                                'bg' => 'bg-rose-50 text-rose-800 border-rose-200/90',
                                                'icon' => '<svg class="w-3 h-3 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                            ],
                                            default => [
                                                'bg' => 'bg-slate-100 text-slate-700 border-slate-200',
                                                'icon' => '<svg class="w-3 h-3 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                            ],
                                        };

                                        // Cek apakah ada update status progres (seperti di Not In Service)
                                        $updateVal = $this->extractValue($item, 'UPDATE');
                                    @endphp
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold border font-mono tracking-tight shadow-2xs {{ $badgeConfig['bg'] }}">
                                            {!! $badgeConfig['icon'] !!}
                                            <span class="truncate">{{ $item->kategori ?? 'STATUS' }}</span>
                                        </span>
                                        @if (!empty($item->keterangan) && strtoupper($item->keterangan) !== strtoupper($item->kategori ?? ''))
                                            <div class="text-[9.5px] text-slate-500 font-semibold font-mono pl-0.5 leading-tight">
                                                Ket: <span class="text-slate-700">{{ $item->keterangan }}</span>
                                            </div>
                                        @endif
                                        @if ($updateVal !== '-' && !empty($updateVal) && strtoupper($updateVal) !== strtoupper($item->keterangan ?? '') && strtoupper($updateVal) !== strtoupper($item->kategori ?? ''))
                                            <div class="text-[9.5px] text-purple-700 font-semibold font-mono pl-0.5 leading-tight">
                                                Progress: <span class="text-purple-800 font-bold">{{ $updateVal }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- 7. AKSI CEPAT DENGAN ELEGAN TELKOM AKSES BUTTON (Tepat di Tengah Sel) -->
                                <td class="px-3.5 py-2.5 whitespace-nowrap text-center align-middle">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('valins.edit', $item->id) }}" 
                                           class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-[11px] font-headline font-bold text-slate-700 hover:text-white bg-white hover:bg-[#AE0C00] border border-slate-200/90 hover:border-[#AE0C00] rounded-lg shadow-2xs transition-all duration-150 active:scale-95 group/btn">
                                            <span>Tinjau</span>
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr wire:key="empty-row"
                                wire:loading.class="hidden" 
                                wire:target="search,filterSto,filterStatus,perPage,resetFilters,previousPage,nextPage,gotoPage">
                                <td colspan="{{ $isCustomCategory ? (count($dynamicColumns) + 2) : 7 }}" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-sm font-headline font-bold text-slate-800">Tidak ada data deviasi yang cocok</div>
                                        <p class="text-xs text-slate-500 max-w-sm">Coba sesuaikan kata kunci pencarian atau ganti filter STO dan status kategori yang Anda gunakan.</p>
                                        @if ($isFiltered)
                                            <button type="button" 
                                                    wire:click="resetFilters" 
                                                    class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-headline font-bold text-white bg-[#AE0C00] hover:bg-red-700 rounded-xl transition shadow-xs cursor-pointer active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                <span>Reset Semua Filter</span>
                                            </button>
                                        @endif
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
                        Menampilkan <strong class="text-slate-900 font-bold tabular-nums">{{ $valinsDeviations->firstItem() ?? 0 }}</strong> - <strong class="text-slate-900 font-bold tabular-nums">{{ $valinsDeviations->lastItem() ?? 0 }}</strong> dari <strong class="text-slate-900 font-bold tabular-nums">{{ number_format($valinsDeviations->total()) }}</strong> Kasus
                        @if ($isFiltered)
                            <span class="text-slate-400 font-mono">(Total Deviasi Witel: {{ number_format($totalAllValins) }})</span>
                        @else
                            Terdata
                        @endif
                    </span>
                </div>

                <div class="overflow-x-auto max-w-full">
                    {{ $valinsDeviations->links('livewire.custom-pagination') }}
                </div>
            </div>
        </div>

       <!-- 6. KARTU FOOTER INFORMASI SISTEM (SOP, KONTAK, DAN SINKRONISASI) -->

    </div>

    <!-- SCRIPT PENGGERAK APEXCHARTS DENGAN LOGIKA REAKTIF ALPINE.JS -->
    <script>
        function dashboardAnalytics(initialConfig) {
            return {
                stoChartInstance: null,
                donutChartInstance: null,
                stoLabels: initialConfig.stoLabels,
                stoSeries: initialConfig.stoSeries,
                stoColors: initialConfig.stoColors,
                donutLabels: initialConfig.donutLabels,
                donutSeries: initialConfig.donutSeries,
                donutColors: initialConfig.donutColors,

                initCharts() {
                    this.$nextTick(() => {
                        this.renderStoBarChart();
                        this.renderDonutChart();
                        this.initScrollReveal();
                    });

                initScrollReveal() {
                    const chartCards = document.querySelectorAll('.dashboard-reveal-card');
                    if (!chartCards.length) return;

                    if (!('IntersectionObserver' in window)) {
                        chartCards.forEach(c => c.classList.add('revealed'));
                        return;
                    }

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('revealed');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.15,
                        rootMargin: '0px 0px -40px 0px'
                    });

                    chartCards.forEach(card => observer.observe(card));

                    // Failsafe: force visibility after 1.2s to prevent blank cards if network/scroll delayed
                    setTimeout(() => {
                        chartCards.forEach(c => c.classList.add('revealed'));
                    }, 1200);
                },

                    // Penyelarasan Otomatis Lebar Kanvas saat Sidebar Expand/Collapse
                    window.addEventListener('resize', () => {
                        if (this.stoChartInstance) {
                            this.stoChartInstance.render();
                        }
                        if (this.donutChartInstance) {
                            this.donutChartInstance.render();
                        }
                    });

                    // Event Listener saat data dimuat ulang melalui Livewire
                    Livewire.on('dashboard-refreshed', (event) => {
                        const data = event[0] || event;
                        if (data && data.stoChart && this.stoChartInstance) {
                            this.stoChartInstance.updateOptions({
                                xaxis: { categories: data.stoChart.labels },
                                colors: data.stoChart.colors
                            });
                            this.stoChartInstance.updateSeries([{
                                name: 'Kendala Aktif',
                                data: data.stoChart.series
                            }]);
                        }

                        if (data && data.donutChart && this.donutChartInstance) {
                            this.donutChartInstance.updateOptions({
                                labels: data.donutChart.labels,
                                colors: data.donutChart.colors
                            });
                            this.donutChartInstance.updateSeries(data.donutChart.series);
                        }
                    });
                },

                renderStoBarChart() {
                    const el = document.querySelector("#stoBarChart");
                    if (!el) return;
                    if (this.stoChartInstance) {
                        this.stoChartInstance.destroy();
                    }

                    const options = {
                        series: [{
                            name: 'Kendala Aktif',
                            data: this.stoSeries
                        }],
                        chart: {
                            type: 'bar',
                            height: 250,
                            toolbar: { show: false },
                            fontFamily: "'Plus Jakarta Sans', 'Inter', sans-serif"
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 5,
                                columnWidth: '38%',
                                distributed: true,
                                dataLabels: {
                                    position: 'top'
                                }
                            }
                        },
                        colors: this.stoColors,
                        dataLabels: {
                            enabled: true,
                            offsetY: -20,
                            style: {
                                fontSize: '11px',
                                fontWeight: '700',
                                fontFamily: "'JetBrains Mono', monospace",
                                colors: ['#334155']
                            }
                        },
                        xaxis: {
                            categories: this.stoLabels,
                            position: 'bottom',
                            labels: {
                                style: {
                                    fontSize: '11px',
                                    fontFamily: "'Plus Jakarta Sans', sans-serif",
                                    fontWeight: 700,
                                    colors: '#64748B'
                                }
                            },
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            show: true,
                            labels: {
                                style: {
                                    fontSize: '10px',
                                    fontFamily: "'JetBrains Mono', monospace",
                                    colors: '#94A3B8'
                                }
                            }
                        },
                        grid: {
                            borderColor: '#F1F5F9',
                            strokeDashArray: 4,
                            yaxis: {
                                lines: { show: true }
                            }
                        },
                        legend: { show: false },
                        tooltip: {
                            theme: 'light',
                            style: {
                                fontSize: '12px',
                                fontFamily: "'Plus Jakarta Sans', sans-serif"
                            },
                            y: {
                                formatter: function (val) {
                                    return val + " Kasus Deviasi";
                                }
                            }
                        }
                    };

                    this.stoChartInstance = new ApexCharts(el, options);
                    this.stoChartInstance.render();
                },

                renderDonutChart() {
                    const el = document.querySelector("#valinsDonutChart");
                    if (!el) return;
                    if (this.donutChartInstance) {
                        this.donutChartInstance.destroy();
                    }

                    const options = {
                        series: this.donutSeries,
                        labels: this.donutLabels,
                        chart: {
                            type: 'donut',
                            height: 220,
                            fontFamily: "'Plus Jakarta Sans', 'Inter', sans-serif"
                        },
                        colors: this.donutColors,
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '64%',
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '11px',
                                            fontFamily: "'Plus Jakarta Sans', sans-serif",
                                            fontWeight: 600,
                                            color: '#64748B'
                                        },
                                        value: {
                                            show: true,
                                            fontSize: '22px',
                                            fontFamily: "'JetBrains Mono', 'Plus Jakarta Sans', monospace",
                                            fontWeight: 800,
                                            color: '#0F172A',
                                            formatter: function (val) {
                                                return Number(val).toLocaleString();
                                            }
                                        },
                                        total: {
                                            show: true,
                                            showAlways: true,
                                            label: 'TOTAL PORT',
                                            fontSize: '10px',
                                            fontFamily: "'Plus Jakarta Sans', sans-serif",
                                            fontWeight: 700,
                                            color: '#94A3B8',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: { enabled: false },
                        legend: { show: false },
                        stroke: { width: 2, colors: ['#ffffff'] },
                        tooltip: {
                            theme: 'light',
                            style: {
                                fontSize: '12px',
                                fontFamily: "'Plus Jakarta Sans', sans-serif"
                            },
                            y: {
                                formatter: function (val, opts) {
                                    const total = opts && opts.globals && opts.globals.seriesTotals 
                                        ? opts.globals.seriesTotals.reduce((a, b) => a + b, 0) 
                                        : 0;
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return Number(val).toLocaleString() + " Port (" + pct + "%)";
                                }
                            }
                        }
                    };

                    this.donutChartInstance = new ApexCharts(el, options);
                    this.donutChartInstance.render();
                }
            };
        }
    </script>
</div>
