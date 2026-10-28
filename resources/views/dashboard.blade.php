<x-app-layout>
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4">
        
        <!-- Notifikasi Flash Message -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 3500)" 
                 x-show="show" 
                 x-transition 
                 class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-xs flex items-center justify-between text-emerald-800">
                <div class="flex items-center gap-2.5 text-sm font-semibold">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        <!-- Panel Kendali Dashboard Analytics -->
        <div class="w-full min-w-0">
            @livewire('dashboard-analytics')
        </div>

    </div>
</x-app-layout>