<div>
    <!-- Notifikasi Sukses Melayang -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-5 right-5 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- HEADER NAVIGASI: TAB STO & TOMBOL AKSI -->
    <div class="mb-6 space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori STO:</span>
                <div wire:loading wire:target="setSto" class="flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                    <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memuat data STO...
                </div>
            </div>

            <button type="button"
                    wire:click="openModalTambah"
                    class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm hover:shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Data</span>
            </button>
        </div>

        <!-- Daftar Tab STO -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 border-b border-gray-200 scrollbar-thin">
            @forelse($stos as $sto)
                <button type="button"
                        wire:key="tab-{{ md5($sto) }}"
                        wire:click="setSto('{{ $sto }}')"
                        class="px-4 py-2 text-xs font-bold rounded-lg whitespace-nowrap transition-colors cursor-pointer {{ $activeSto === $sto && !$hasSearch ? 'bg-blue-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                    STO {{ $sto }}
                </button>
            @empty
                <span class="text-xs text-gray-400 italic">Belum ada kategori STO.</span>
            @endforelse
        </div>
    </div>

   <!-- PANEL PENCARIAN TERSTRUKTUR (SESUAI VALINS) -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 mb-6 transition-all duration-300 hover:shadow-md">

        <!-- Header Panel Pencarian -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4 border-b border-gray-100 pb-3">
            <span class="flex items-center gap-2 text-xs font-extrabold text-gray-600 uppercase tracking-wider">
                <div class="bg-blue-100 p-1.5 rounded-md shadow-inner">
                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                Filter Pencarian Data
            </span>

            @if($hasSearch)
                <!-- Tombol Reset Utama yang Elegan -->
                <button type="button"
                        wire:click="resetSearch"
                        class="group flex items-center gap-1.5 px-4 py-1.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-full text-[11px] font-bold transition-all duration-300 shadow-sm border border-red-200 hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-200 active:scale-95">
                    <!-- Icon dengan efek berputar saat di-hover -->
                    <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reset Pencarian
                </button>
            @endif
        </div>

        <!-- Grid Input Pencarian -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- 1. Input Node ID / IP -->
            <div class="relative">
                <label class="block text-[11px] font-bold text-gray-500 mb-1.5">NODE ID / NODE IP</label>
                <div class="relative group">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchNode"
                           placeholder="Contoh: 172.28... atau GPON01..."
                           class="w-full border border-gray-300 bg-gray-50 h-10 pl-3 pr-8 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">

                    <!-- Tombol Reset Individual (Micro-clear) -->
                    @if($searchNode)
                        <button type="button" wire:click="$set('searchNode', '')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full p-0.5" title="Hapus Node ID">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- 2. Input Slot -->
            <div class="relative">
                <label class="block text-[11px] font-bold text-gray-500 mb-1.5">SLOT (VALINS)</label>
                <div class="relative group">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchSlot"
                           placeholder="Contoh: 8 atau SLOT 8"
                           class="w-full border border-gray-300 bg-gray-50 h-10 pl-3 pr-8 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">

                    @if($searchSlot)
                        <button type="button" wire:click="$set('searchSlot', '')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full p-0.5" title="Hapus Slot">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- 3. Input Port -->
            <div class="relative">
                <label class="block text-[11px] font-bold text-gray-500 mb-1.5">PORT (VALINS)</label>
                <div class="relative group">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchPort"
                           placeholder="Contoh: 5 atau 12"
                           class="w-full border border-gray-300 bg-gray-50 h-10 pl-3 pr-8 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">

                    @if($searchPort)
                        <button type="button" wire:click="$set('searchPort', '')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full p-0.5" title="Hapus Port">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Indikator Status Pencarian (Blinking effect) -->
        @if($hasSearch)
            <div class="mt-4 text-[11px] font-semibold text-blue-800 bg-blue-50 py-2 px-3 rounded-lg flex items-center gap-2 border border-blue-100 shadow-inner">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                </span>
                <span>Mode Pencarian Global Aktif: Sistem sedang menjelajah ke seluruh STO.</span>
            </div>
        @endif
    </div>

    <!-- TAMPILAN KARTU DATA -->
    <div class="space-y-8 transition-opacity duration-300" wire:loading.class="opacity-50 pointer-events-none" wire:target="setSto, searchNode, searchSlot, searchPort, gotoPage, previousPage, nextPage, openModalTambah, openModalEdit">
        @forelse ($data as $nodeId => $ports)
            @php
                $firstSlot = $ports->first();
                $info = $firstSlot->first();
            @endphp

            <div wire:key="olt-{{ md5($nodeId) }}" class="bg-white rounded-xl shadow-md border border-gray-300 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                        <div class="md:col-span-2">
                            <div class="text-xs text-blue-300 font-bold uppercase tracking-widest mb-1 flex items-center gap-2">
                                NODE ID & IP
                                @if($hasSearch)
                                    <span class="bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full text-[10px] font-extrabold shadow-sm">
                                        STO {{ $info->sto ?? '-' }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold">{{ $nodeId }} <span class="text-sm font-normal text-gray-300 ml-2">({{ $info->node_ip ?? 'Tanpa IP' }})</span></h3>
                        </div>
                        <div>
                            <div class="text-xs text-blue-300 font-bold uppercase tracking-widest mb-1">ID Logical Device</div>
                            <div class="font-mono text-lg">{{ $info->id_logical_device ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-blue-300 font-bold uppercase tracking-widest mb-1">Type GPON</div>
                            <div class="font-bold text-lg text-yellow-400">{{ $info->type_gpon ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 flex gap-6 overflow-x-auto snap-x">
                    @foreach($ports as $slotName => $slotPorts)
                        <div wire:key="slot-{{ md5($nodeId . $slotName) }}" class="min-w-[320px] max-w-350px bg-white border border-gray-200 rounded-lg shadow-sm shrink-0 snap-start">
                            <div class="bg-blue-100 text-blue-900 text-center font-bold py-2 border-b border-blue-200 rounded-t-lg shadow-inner flex justify-between items-center px-4">
                                <span>{{ $slotName ?: 'TANPA SLOT' }}</span>
                                <span class="text-xs bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full">{{ $slotPorts->count() }} Port</span>
                            </div>

                           <ul class="max-h-500px overflow-y-auto divide-y divide-gray-100 relative scroll-smooth"
                                x-data="{}"
                                x-init="$nextTick(() => {
                                    let highlighted = $el.querySelector('.highlight-port');
                                    if(highlighted) {
                                        highlighted.scrollIntoView({behavior: 'smooth', block: 'center'});
                                    }
                                })">

                                @foreach($slotPorts as $port)
                                    @php
                                        $isHighlighted = false;
                                        $dbPort = strtolower(trim($port->port));

                                        if (!empty($searchPort)) {
                                            $val = strtolower(trim($searchPort));

                                            if (is_numeric($val) && strlen($val) <= 3) {
                                                if (preg_match('/[:\-\s]0*' . preg_quote($val, '/') . '$/', $dbPort)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                            else {
                                                // ANTI-RACK: Tambahkan 'rack' dan 'slot' agar diabaikan
                                                $cleanedVal = trim(str_ireplace(['gpon', 'olt', 'port', 'rack', 'slot', '-', ':'], '', $val));
                                                if (strlen($cleanedVal) >= 2 && str_contains($dbPort, $val)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                        }

                                        if (!$isHighlighted && !empty($searchNode)) {
                                            $valNode = strtolower(trim($searchNode));
                                            $nodeLower = strtolower($nodeId);
                                            $ipLower = strtolower($info->node_ip ?? '');

                                            if (!str_contains($nodeLower, $valNode) && !str_contains($ipLower, $valNode)) {
                                                // ANTI-RACK: Tambahkan 'rack' dan 'slot' agar diabaikan
                                                $cleanedValNode = trim(str_ireplace(['gpon', 'olt', 'port', 'rack', 'slot', '-', ':'], '', $valNode));
                                                if (strlen($cleanedValNode) >= 3 && str_contains($dbPort, $valNode)) {
                                                    $isHighlighted = true;
                                                }
                                            }
                                        }
                                    @endphp

                                    <li wire:key="port-{{ $port->id }}"
                                        class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 transition-colors group
                                        {{ $isHighlighted ? 'bg-yellow-100 border-l-4 border-yellow-500 highlight-port shadow-inner' : '' }}">

                                        <span class="font-mono text-sm {{ $isHighlighted ? 'text-yellow-900 font-extrabold' : 'text-gray-700' }}">
                                            {{ $port->port }}
                                        </span>

                                        <div class="flex items-center gap-1 transition-opacity
                                            {{ $isHighlighted ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}">

                                            <button type="button" wire:click="openModalEdit({{ $port->id }})" title="Edit Port" class="text-gray-400 hover:text-blue-600 bg-white shadow-sm p-1.5 rounded-md border border-gray-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <button type="button" wire:click="hapusData({{ $port->id }})" wire:confirm="Yakin ingin menghapus port {{ $port->port }}?" title="Hapus Port" class="text-gray-400 hover:text-red-600 bg-white shadow-sm p-1.5 rounded-md border border-gray-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Data Tidak Ditemukan</h3>
                <p class="text-gray-500 text-sm">Pastikan kata kunci pencarian Node, Slot, atau Port telah sesuai.</p>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION CUSTOM ELEGAN -->
    <div class="mt-8 mb-4 flex justify-between items-center bg-white p-3 rounded-xl shadow-sm border border-gray-200 transition-all">

        <!-- Tombol Mundur -->
        <button type="button"
                wire:click="previousPage"
                @if($paginatedNodes->onFirstPage()) disabled @endif
                class="px-4 py-2 text-sm font-bold rounded-lg flex items-center gap-2 transition-all duration-200 {{ $paginatedNodes->onFirstPage() ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-blue-700 bg-blue-50 hover:bg-blue-100 hover:shadow-sm active:scale-95' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            Sebelumnya
        </button>

        <!-- Indikator Halaman -->
        <div class="flex items-center gap-2">
            <span class="text-xs font-extrabold text-gray-400 uppercase tracking-widest hidden md:inline">Halaman</span>
            <span class="bg-blue-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-inner">
                {{ $paginatedNodes->currentPage() }}
            </span>
        </div>

        <!-- Tombol Maju -->
        <button type="button"
                wire:click="nextPage"
                @if(!$paginatedNodes->hasMorePages()) disabled @endif
                class="px-4 py-2 text-sm font-bold rounded-lg flex items-center gap-2 transition-all duration-200 {{ !$paginatedNodes->hasMorePages() ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-blue-700 bg-blue-50 hover:bg-blue-100 hover:shadow-sm active:scale-95' }}">
            Selanjutnya
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>

    </div>

    <!-- MODAL TAMBAH & EDIT DATA -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity">
        <div class="relative w-full max-w-3xl p-4 md:p-6 mx-auto">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <div class="bg-blue-800 px-6 py-4 flex justify-between items-center border-b border-blue-900">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        @if($isEdit)
                            <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Update Data Port
                        @else
                            <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tambah Data Port Manual
                        @endif
                    </h3>
                    <button type="button" wire:click="closeModal" class="text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg p-1.5 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 md:p-8">
                    <form wire:submit.prevent="simpanData">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori STO <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="formSto" placeholder="Contoh: BGL, CBD..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 uppercase">
                                    @error('formSto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama OLT (Node ID) <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="formNodeId" placeholder="GPON00-D3-BGL-2" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 uppercase">
                                    @error('formNodeId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Node IP (Opsional)</label>
                                    <input type="text" wire:model="formNodeIp" placeholder="172.x.x.x" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Type GPON</label>
                                    <input type="text" wire:model="formTypeGpon" placeholder="HUAWEI / ZTE" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 uppercase">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">ID Logical Device (Opsional)</label>
                                    <input type="text" wire:model="formLogicalId" placeholder="Misal: 75794" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-mono">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Slot / Rack <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="formSlot" placeholder="SLOT 1 atau RACK 1 / SLOT 2" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 uppercase">
                                    @error('formSlot') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                    <label class="block text-sm font-bold text-blue-900 mb-1">Detail Port <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="formPort" placeholder="GPON - 85927361271..." class="w-full border border-blue-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-mono shadow-inner">
                                    @error('formPort') <span class="text-red-600 font-bold text-xs mt-2 block p-2 bg-red-100 rounded">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white font-bold rounded-lg hover:bg-blue-800 transition-colors flex items-center gap-2">
                                <svg wire:loading wire:target="simpanData" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
