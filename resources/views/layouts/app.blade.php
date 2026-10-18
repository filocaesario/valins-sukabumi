<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <!-- Splide CSS untuk Slider Valins -->
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        <!-- CDN SortableJS untuk Drag and Drop Kursor yang Mulus -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScriptConfig
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Splide JS untuk Slider Valins -->
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <!-- CDN SortableJS untuk Drag and Drop Kursor yang Mulus -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

        <!-- MODAL UBAH PENAMAAN TAB NAVBAR (LANGSUNG KE FORM EDIT) -->
        <div x-data="{ 
                openModalEditTab: false,
                editId: null,
                editNama: '',
                editDeskripsi: '',
                editActionUrl: '',
                pilihTab(id, nama, deskripsi) {
                    this.editId = id;
                    this.editNama = nama;
                    this.editDeskripsi = deskripsi ?? '';
                    this.editActionUrl = '{{ url('/navbar-tabs') }}/' + id;
                }
             }"
             @buka-modal-edit-tab.window="
                openModalEditTab = true; 
                if ($event.detail && $event.detail.id) {
                    pilihTab($event.detail.id, $event.detail.nama, $event.detail.deskripsi);
                } else {
                    pilihTab(null, '', '');
                }
             "
             x-show="openModalEditTab" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
            
            <div @click.outside="openModalEditTab = false" 
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 animate-fadeIn">
                
                <div class="bg-gray-900 text-white px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        <h3 class="font-bold text-sm">Ubah Penamaan Menu</h3>
                    </div>
                    <button type="button" @click="openModalEditTab = false" class="text-gray-400 hover:text-white text-lg leading-none">&times;</button>
                </div>

                <div class="p-6">
                    <form :action="editActionUrl" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Nama Menu Navbar <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   name="nama_tab" 
                                   x-model="editNama" 
                                   required 
                                   placeholder="Contoh: Valins Services"
                                   class="w-full text-sm border border-gray-300 rounded-xl px-3.5 py-2.5 bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Deskripsi / Sub-judul <span class="text-gray-400 font-normal lowercase">(opsional)</span></label>
                            <input type="text" 
                                   name="deskripsi" 
                                   x-model="editDeskripsi" 
                                   placeholder="Sub-judul atau peruntukan menu"
                                   class="w-full text-sm border border-gray-300 rounded-xl px-3.5 py-2.5 bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition">
                        </div>

                        <div class="flex justify-end gap-2.5 pt-4 border-t border-gray-100">
                            <button type="button" @click="openModalEditTab = false" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2 text-xs font-bold bg-red-600 hover:bg-red-700 text-white rounded-xl transition shadow-xs">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </body>
</html>
