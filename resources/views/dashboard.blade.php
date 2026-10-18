<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <!-- Tombol Ubah Nama Menu di Header -->
        </div>
    </x-slot>

    <!-- Notifikasi Flash Message -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
        @if (session()->has('success'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 3500)" 
                 x-show="show" 
                 x-transition 
                 class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-xs flex items-center justify-between text-emerald-800">
                <div class="flex items-center gap-2.5 text-sm font-semibold">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif
    </div>

    <!-- Banner Info User -->
    <div class="pt-2 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-xl border border-gray-100 p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Selamat datang kembali di panel kendali Manajemen Data VALINS.</p>
                </div>

               
            </div>
        </div>
    </div>

    <!-- Grafik Analitik -->
    <div class="pb-12">
        @livewire('dashboard-analytics')
    </div>
</x-app-layout>