<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->cookie('sidebar_expanded') === 'false' ? 'sidebar-collapsed' : 'sidebar-expanded' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Telkom Akses Sukabumi</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

        <!-- Fonts: Inter, Plus Jakarta Sans, JetBrains Mono & Material Symbols Outlined -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <style>
            html {
                scrollbar-gutter: stable;
            }
            html, body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                font-feature-settings: "cv02", "cv03", "cv04", "cv11";
            }
            h1, h2, h3, h4, .font-headline, .font-jakarta {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            }
            .font-mono, .font-telemetry, code, kbd, samp, pre {
                font-family: 'JetBrains Mono', ui-monospace, monospace !important;
                font-variant-numeric: tabular-nums;
            }
            .tabular-nums {
                font-variant-numeric: tabular-nums;
            }

            /* Stabilitas Bebas Kedip (Instant Persistence & Anti-Shift) */
            [x-cloak] {
                display: none !important;
            }

            /* Kontrol Panah Panel Toggle Sidebar Bebas Kedip & Anti-Shift */
            html:not(.sidebar-collapsed) .sidebar-panel-arrow-open,
            html.sidebar-expanded .sidebar-panel-arrow-open {
                display: none !important;
            }
            html:not(.sidebar-collapsed) .sidebar-panel-arrow-close,
            html.sidebar-expanded .sidebar-panel-arrow-close {
                display: block !important;
            }
            html.sidebar-collapsed .sidebar-panel-arrow-close {
                display: none !important;
            }
            html.sidebar-collapsed .sidebar-panel-arrow-open {
                display: block !important;
            }

            /* Indikator Lengkungan Garis Merah Korporat Bebas Kedip & Anti-Shift */
            .sidebar-active-indicator {
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 0.375rem; /* 6px */
                height: 1.75rem;  /* 28px */
                background-color: #AE0C00;
                border-top-right-radius: 9999px;
                border-bottom-right-radius: 9999px;
                box-shadow: 0 0 10px rgba(174, 12, 0, 0.45), 0 1px 3px rgba(174, 12, 0, 0.25);
                pointer-events: none;
            }

            /* ================= ATURAN SINKRONISASI GEOMETRI SIDEBAR DESKTOP ================= */
            @media (min-width: 1024px) {
                /* --- KONDISI 1: EXPAND (DEFAULT / LEBAR 16rem = 256px) --- */
                html:not(.sidebar-collapsed) #app-sidebar,
                html.sidebar-expanded #app-sidebar {
                    width: 16rem !important;
                }
                html:not(.sidebar-collapsed) #app-main-wrapper,
                html.sidebar-expanded #app-main-wrapper {
                    padding-left: 16rem !important;
                }
                /* Header Puncak: Menjaga Logo dan Tombol Toggle tetap pada posisinya sejak milidetik 0 */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-top-bar,
                html.sidebar-expanded #app-sidebar .sidebar-top-bar {
                    justify-content: space-between !important;
                    padding-left: 0.75rem !important;
                    padding-right: 0.75rem !important;
                }
                /* Logo Telkom Akses tampil instan tanpa kedipan/flicker */
                html:not(.sidebar-collapsed) #app-sidebar a.sidebar-logo-expanded,
                html.sidebar-expanded #app-sidebar a.sidebar-logo-expanded {
                    display: flex !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }
                /* Sembunyikan Logo Emblem saat Expand */
                html:not(.sidebar-collapsed) #app-sidebar a.sidebar-logo-collapsed,
                html.sidebar-expanded #app-sidebar a.sidebar-logo-collapsed {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                }
                /* Label Kategori "MENU UTAMA" tampil statis dengan tinggi tetap */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-category-header,
                html.sidebar-expanded #app-sidebar .sidebar-category-header {
                    display: block !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                    height: auto !important;
                }
                /* Garis pemisah collapsed disembunyikan saat expand */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-divider-collapsed,
                html.sidebar-expanded #app-sidebar .sidebar-divider-collapsed {
                    display: none !important;
                }
                /* Kapsul Menu: Terkunci pada lebar penuh dan tinggi tepat 44px (h-11) untuk mencegah dorongan */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-menu-capsule,
                html.sidebar-expanded #app-sidebar .sidebar-menu-capsule {
                    width: 100% !important;
                    height: 2.75rem !important; /* 44px */
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                }
                /* Teks Menu tampil instan tanpa loncatan posisi */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-text-truncate,
                html.sidebar-expanded #app-sidebar .sidebar-text-truncate {
                    display: inline-block !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }
                /* Info profil pengguna bagian bawah tampil instan */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-user-info,
                html.sidebar-expanded #app-sidebar .sidebar-user-info {
                    display: block !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }
                /* Chevron profil tampil instan */
                html:not(.sidebar-collapsed) #app-sidebar .sidebar-chevron-expanded,
                html.sidebar-expanded #app-sidebar .sidebar-chevron-expanded {
                    display: block !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }

                /* --- KONDISI 2: COLLAPSE (SEMPIT 5rem = 80px) --- */
                html.sidebar-collapsed #app-sidebar {
                    width: 5rem !important;
                }
                html.sidebar-collapsed #app-main-wrapper {
                    padding-left: 5rem !important;
                }
                /* Kunci Posisi Tengah Header Sidebar Puncak Saat Collapse (Anti-Bounce / Anti-Flicker) */
                html.sidebar-collapsed #app-sidebar .sidebar-top-bar {
                    justify-content: center !important;
                    padding-left: 0.5rem !important;
                    padding-right: 0.5rem !important;
                }
                /* Tampilkan Logo Emblem Telkom Akses Saat Collapse (Pengganti Posisi Toggle) */
                html.sidebar-collapsed #app-sidebar a.sidebar-logo-collapsed {
                    display: flex !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                    justify-content: center !important;
                    align-items: center !important;
                }
                /* Kunci Geometri Kapsul Menu Tengah Saat Collapse (Anti-Jump & Zero Collision) */
                html.sidebar-collapsed #app-sidebar .sidebar-menu-capsule {
                    width: 2.75rem !important; /* 44px */
                    height: 2.75rem !important; /* 44px */
                    padding: 0 !important;
                    justify-content: center !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                }
                /* Kunci Sembunyi Mutlak Elemen Teks & Label Kategori Saat Collapse */
                html.sidebar-collapsed #app-sidebar a.sidebar-logo-expanded,
                html.sidebar-collapsed #app-sidebar .sidebar-category-header,
                html.sidebar-collapsed #app-sidebar .sidebar-label-expanded,
                html.sidebar-collapsed #app-sidebar [data-sidebar-label],
                html.sidebar-collapsed #app-sidebar .sidebar-text-truncate,
                html.sidebar-collapsed #app-sidebar [data-sidebar-text],
                html.sidebar-collapsed #app-sidebar .sidebar-user-info,
                html.sidebar-collapsed #app-sidebar .sidebar-chevron-expanded {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                    height: 0 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    overflow: hidden !important;
                    pointer-events: none !important;
                }
                /* Tampilkan Garis Pemisah Proporsional Pengganti Menu Utama Saat Collapse */
                html.sidebar-collapsed #app-sidebar .sidebar-divider-collapsed {
                    display: block !important;
                }
            }
        </style>

        <!-- Skrip Sinkron Anti-Kedip: Membaca status sidebar sebelum DOM dirender -->
        <script>
            (function() {
                try {
                    let isCollapsed = false;
                    const cookieMatch = document.cookie.match(/(?:^|; )sidebar_expanded=([^;]*)/);
                    if (cookieMatch) {
                        isCollapsed = cookieMatch[1] === 'false';
                    } else {
                        isCollapsed = localStorage.getItem('sidebar_expanded') === 'false';
                    }
                    if (isCollapsed) {
                        document.documentElement.classList.add('sidebar-collapsed');
                        document.documentElement.classList.remove('sidebar-expanded');
                    } else {
                        document.documentElement.classList.remove('sidebar-collapsed');
                        document.documentElement.classList.add('sidebar-expanded');
                    }
                } catch(e) {}
            })();
        </script>

        <!-- Scripts -->
        <!-- Splide CSS untuk Slider Valins -->
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        <!-- CDN SortableJS untuk Drag and Drop Kursor yang Mulus -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScriptConfig
    </head>
    <body class="font-sans antialiased text-slate-800 bg-[#f8fafc] overflow-x-hidden">
        
        <!-- PEMBUNGKUS UTAMA DENGAN STATE SIDEBAR DI KONTROL OLEH ALPINE.JS -->
        <div x-data="{ 
                sidebarExpanded: localStorage.getItem('sidebar_expanded') !== 'false',
                mobileSidebarOpen: false,
                activeMenu: '{{ request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('valins.*') ? 'valins' : (request()->routeIs('master-gpon.*') ? 'gpon' : '')) }}',
                get currentRoute() { return this.activeMenu; },
                set currentRoute(val) { this.activeMenu = val; },
                hoveredTooltip: null,
                isNavigating: false,
                toggleSidebar() {
                    this.sidebarExpanded = !this.sidebarExpanded;
                    localStorage.setItem('sidebar_expanded', this.sidebarExpanded);
                    document.cookie = 'sidebar_expanded=' + this.sidebarExpanded + '; path=/; max-age=31536000; SameSite=Lax';
                    if (!this.sidebarExpanded) {
                        document.documentElement.classList.add('sidebar-collapsed');
                        document.documentElement.classList.remove('sidebar-expanded');
                    } else {
                        document.documentElement.classList.remove('sidebar-collapsed');
                        document.documentElement.classList.add('sidebar-expanded');
                    }
                    // Memicu event resize otomatis agar kanvas ApexCharts langsung menyesuaikan lebar baru
                    setTimeout(() => {
                        window.dispatchEvent(new Event('resize'));
                    }, 320);
                },
                selectMenu(route) {
                    this.activeMenu = route;
                    this.hoveredTooltip = null;
                    this.isNavigating = true;
                },
                navigateMenu(route) {
                    this.selectMenu(route);
                },
                showTooltip(route) {
                    if (!this.isNavigating && !this.sidebarExpanded && this.activeMenu !== route) {
                        this.hoveredTooltip = route;
                    }
                },
                hideTooltip(route) {
                    if (this.hoveredTooltip === route) {
                        this.hoveredTooltip = null;
                    }
                },
                openMobileSidebar() {
                    this.mobileSidebarOpen = false;
                },
                closeMobileSidebar() {
                    this.mobileSidebarOpen = false;
                }
             }"
             class="min-h-screen bg-slate-100/70 flex flex-col antialiased">

            <!-- 1. SIDEBAR KIRI INTERAKTIF (EXPANDABLE / COLLAPSIBLE & OVERLAY MOBILE) -->
            @include('layouts.sidebar')

            <!-- 2. PEMBUNGKUS KONTEN UTAMA DENGAN PENYESUAIAN LEBAR DINAMIS -->
            <div id="app-main-wrapper"
                 :class="sidebarExpanded ? 'lg:pl-64' : 'lg:pl-20'" 
                 class="flex flex-col flex-1 min-w-0 w-full overflow-x-hidden transition-all duration-300 ease-in-out">
                
                <!-- TOP UTILITY HEADER (BILAH UTILITAS ATAS) -->
                @include('layouts.navigation')

                <!-- Page Heading (Jika Komponen Tertentu Membutuhkannya) -->
                @isset($header)
                    <header class="bg-white border-b border-slate-200/80 shadow-2xs">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content (Dashboard, Valins, Monitoring GPON) dengan Ruang Bernapas Bawah Mobile -->
                <main class="flex-1 w-full min-w-0 pb-20 lg:pb-0">
                    {{ $slot }}
                </main>

                <!-- 3. BILAH NAVIGASI BAWAH LEKAT PENUH KHUSUS MOBILE (DOCKED BOTTOM TAB BAR) -->
                @include('layouts.mobile-bottom-nav')
            </div>

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
        </div>
    </body>
</html>
