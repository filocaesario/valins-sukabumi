<x-app-layout>
    @php
        // Ambil data tab secara dinamis agar judul ikut berubah saat nama tab diedit
        $tabInfo = \App\Models\NavbarTab::where('slug', 'valins-services')
            ->orWhere('route_name', 'valins.index')
            ->first();
        $judulTab = $tabInfo?->nama_tab ?? 'Valins Services';
        $deskripsiTab = $tabInfo?->deskripsi ?? 'PT Telkom Akses Witel Sukabumi';
    @endphp


    <!-- Kontainer Halaman Penuh Dinamis (Lebar Penuh 100%, Simetris & Bebas Ruang Kosong Kanan) -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6">

        <!-- Header Halaman Bersih & Selaras Standar Korporat -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-headline font-extrabold text-slate-900 tracking-tight">{{ $judulTab }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-normal leading-relaxed">
                    Manajemen rekonsiliasi data fisik ODP, validasi UIM, dan ketertiban layanan Witel Sukabumi.
                </p>
            </div>

            <!-- Stempel Waktu / Indikator Sinkronisasi Sistem Ringkas -->
        </div>

        <!-- Komponen Livewire Tabel Valins -->
        <div class="w-full min-w-0">
            @livewire('valins-table')
        </div>

    </div>
</x-app-layout>