<x-app-layout>
    @php
        // Ambil data tab secara dinamis agar judul ikut berubah saat nama tab diedit
        $tabInfo = \App\Models\NavbarTab::where('slug', 'valins-services')
            ->orWhere('route_name', 'valins.index')
            ->first();
        $judulTab = $tabInfo?->nama_tab ?? 'Valins Services';
        $deskripsiTab = $tabInfo?->deskripsi ?? 'PT Telkom Akses Witel Sukabumi';
    @endphp

    <!-- Header Navbar Breeze -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $judulTab }}
            </h2>

            <!-- Tombol Kelola Tab di Sisi Kanan Header Atas -->
        </div>
    </x-slot>

    <!-- Wrapper Konten -->
    <div class="py-4 sm:py-8"> 
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            <!-- Header Halaman & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 sm:mb-6 gap-3 sm:gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">{{ $judulTab }}</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">{{ $deskripsiTab }}</p>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <!-- Tombol Tambah Data Valins -->
                    <a href="{{ route('valins.create') }}" class="w-full sm:w-auto justify-center bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold py-2.5 px-4 rounded-xl shadow-xs hover:shadow transition flex items-center gap-2 text-xs sm:text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Data Valins</span>
                    </a>
                </div>
            </div>

            <!-- Komponen Livewire Tabel Valins -->
            <div>
                @livewire('valins-table')
            </div>

        </div>
    </div>
</x-app-layout>