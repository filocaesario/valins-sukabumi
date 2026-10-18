<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Valins') }}
        </h2>
    </x-slot>

    <script>
        function valinsEditForm() {
            return {
                kategoriPilihan: '{{ $valins->kategori }}',
                daftarKategori: @json($categories),

                get kategoriAktif() {
                    return this.daftarKategori.find(k => k.nama_kategori === this.kategoriPilihan);
                },
                get isDinamis() {
                    return Boolean(this.kategoriAktif && this.kategoriAktif.konfigurasi_kolom && this.kategoriAktif.konfigurasi_kolom.length > 0);
                },
                isFieldOptional(name) {
                    if (!name) return false;
                    const normalized = name.toUpperCase().replace(/[^A-Z0-9]/g, '');
                    const optionals = ['NOINETVALINS', 'NOINET','SIP1VALINS', 'SIP1', 'SIP2VALINS', 'SIP2', 'SID', 'KETERANGAN', 'STATUS', 'KETERANGANSTATUS', 'TANGGAL', 'PIC', 'UPDATEPROGRESS', 'UPDATE', 'NOTES'];
                    return optionals.includes(normalized);
                },
                getDynamicValue(colName) {
                    const dyn = @json($valins->dynamic_data ?? []);
                    if (dyn && dyn[colName] !== undefined) return dyn[colName];
                    
                    const propName = colName.toLowerCase().replace(/ /g, '_');
                    let physical = @json($valins);
                    if (propName === 'panel_odp') return physical['panel_o'] || '';
                    if (propName === 'port_odp') return physical['port_od'] || '';
                    return physical[propName] || '';
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

    <div class="py-8" x-data="valinsEditForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Edit Data</h2>
                        <p class="text-xs text-gray-500 mt-1">Mengubah data ID: <strong class="text-blue-600">#{{ $valins->id }}</strong></p>
                    </div>
                   @php
                    $currentUser = auth()->check() ? auth()->user()->name : 'System';
                    $lockedByName = explode('|', $valins->locked_by ?? '')[0];
                    $expireTime = now()->subMinutes(15);
                    
                    // Banner Read-Only HANYA muncul jika namanya beda DAN belum kedaluwarsa
                    $isLockedByOther = !empty($valins->locked_by) 
                        && $lockedByName !== $currentUser 
                        && $valins->locked_at >= $expireTime;
                @endphp

                <!-- BANNER PERINGATAN JIKA DATA DIKUNCI -->
                @if($isLockedByOther)
                    <div class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-xl flex items-center gap-3 text-orange-900 shadow-sm">
                        <div class="bg-orange-100 p-2 rounded-full text-orange-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a5 5 0 0 1 5 5v3h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v3h6V7a3 3 0 0 0-3-3z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Mode Hanya-Lihat (Read Only)</h4>
                            <p class="text-xs text-orange-700">Data ini sedang diproses oleh <strong>{{ $valins->locked_by }}</strong>. Anda tidak dapat menyimpan perubahan pada data ini.</p>
                        </div>
                    </div>
                @endif
                    <a href="{{ route('valins.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Tabel
                    </a>
                </div>

                <!-- Form disinkronkan via Alpine (@submit) -->
                <form action="{{ route('valins.update', $valins->id) }}" method="POST" @submit="syncBeforeSubmit()">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="valins_category_id" :value="kategoriAktif ? kategoriAktif.id : ''">

                    <!-- SECTION 1: Kategori & Lokasi -->
                    <h3 class="text-lg font-bold text-gray-700 mb-3">Informasi Regional & Kategori</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <!-- Kategori Tab (Mode Locked / Terkunci) -->
                        <div class="space-y-1.5">
                            <label class="block text-gray-700 text-sm font-bold mb-1.5">
                                Kategori Tab <span class="text-red-500">*</span>
                            </label>

                            <div class="relative w-full">
                                <!-- Dropdown dalam kondisi disabled/terkunci -->
                                <select disabled 
                                        class="w-full bg-gray-100 border border-gray-300 text-gray-600 text-sm font-semibold rounded-lg px-3 py-2 pr-10 cursor-not-allowed select-none shadow-inner focus:outline-none focus:ring-0 focus:border-gray-300 transition-all">
                                    <option value="{{ $valins->kategori }}" selected>
                                        {{ $valins->kategori ?? 'PILIH KATEGORI' }}
                                    </option>
                                </select>

                                <!-- Ikon Gembok (Lock Indicator) -->
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>

                                <!-- Hidden input sebagai pengaman agar nilai kategori tetap terkirim saat form disubmit -->
                                <input type="hidden" name="kategori" value="{{ $valins->kategori }}">
                            </div>

                            <!-- Keterangan Tambahan -->
                            <p class="text-[11px] text-gray-500 flex items-center gap-1 pt-0.5">
                                <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kategori tidak dapat diubah pada mode edit data.</span>
                            </p>
                        </div>
                        
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">TREG</label>
                            <input type="number" name="treg" value="{{ $valins->treg ?? 3 }}" class="w-full border rounded-lg px-3 py-2 text-gray-500 bg-gray-100" readonly>
                        </div>
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">WITEL</label>
                            <input type="text" name="witel" value="{{ $valins->witel ?? 'SUKABUMI' }}" class="w-full border rounded-lg px-3 py-2 text-gray-500 bg-gray-100" readonly>
                        </div>
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">STO <span class="text-red-500">*</span></label>
                            <input type="text" name="sto" value="{{ $valins->sto }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis" :required="!isDinamis">
                        </div>
                    </div>

                    <!-- SECTION BAWAAN (Muncul jika Kategori Statis) -->
                    <div x-show="!isDinamis">
                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data ODP</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">ODP Name <span class="text-red-500">*</span></label>
                                <input type="text" name="odp_name" value="{{ $valins->odp_name }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis" :required="!isDinamis">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Panel ODP <span class="text-red-500">*</span></label>
                                <input type="text" name="panel_o" value="{{ $valins->panel_o ?? $valins->panel_odp }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis" :required="!isDinamis">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Port ODP <span class="text-red-500">*</span></label>
                                <input type="number" name="port_od" value="{{ $valins->port_od ?? $valins->port_odp }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis" :required="!isDinamis">
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data OLT / Node</h3>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Valins ID</label><input type="text" name="valins_id" value="{{ $valins->valins_id }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Node ID</label><input type="text" name="node_id" value="{{ $valins->node_id }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Node IP</label><input type="text" name="node_ip" value="{{ $valins->node_ip }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Slot</label><input type="number" name="slot" value="{{ $valins->slot }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Port</label><input type="number" name="port" value="{{ $valins->port }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data Layanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">ONU SN <span class="text-red-500">*</span></label><input type="text" name="onu_sn" value="{{ $valins->onu_sn }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis" :required="!isDinamis"></div>
                           <div><label class="block text-gray-700 text-sm font-bold mb-2">No Inet Valins <span class="text-gray-400 font-normal text-xs">(opsional)</span></label><input type="text" name="no_inet_valins" value="{{ $valins->no_inet_valins }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SIP 1 Valins</label><input type="text" name="sip1_valins" value="{{ $valins->sip1_valins }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SIP 2 Valins</label><input type="text" name="sip2_valins" value="{{ $valins->sip2_valins }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SID</label><input type="text" name="sid" value="{{ $valins->sid }}" class="w-full border rounded-lg px-3 py-2 text-gray-700" :disabled="isDinamis"></div>
                        </div>
                    </div>

                    <!-- SECTION DINAMIS -->
                    <div x-show="isDinamis" style="display: none;" class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mb-6 shadow-sm">
                        <h3 class="text-base font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Data Kustom Kategori: <span x-text="kategoriPilihan" class="text-blue-700"></span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <template x-for="(kolom, index) in (kategoriAktif ? kategoriAktif.konfigurasi_kolom.filter(k => !['KETERANGAN', 'TANGGAL', 'PIC'].includes(k.nama.toUpperCase().trim())) : [])" :key="index">
                                <div>
                                    <label class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                        <span x-text="kolom.nama"></span>
                                        <span x-show="!isFieldOptional(kolom.nama)" class="text-red-500 font-bold">*</span>
                                        <span x-show="isFieldOptional(kolom.nama)" class="text-gray-400 font-normal lowercase">(opsional)</span>
                                    </label>
                                    <input :type="kolom.tipe" 
                                           :name="'dynamic_data[' + kolom.nama + ']'" 
                                           :value="getDynamicValue(kolom.nama)"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 shadow-sm" 
                                           :required="isDinamis && !isFieldOptional(kolom.nama)">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- SECTION 5: Status & Pelaksana -->
                    <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Status & Pelaksana</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan / Status <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                            <input type="text" name="keterangan" value="{{ $valins->keterangan }}" list="status_options" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                            <datalist id="status_options">
                                <option value="OTB">
                                <option value="DONE">
                                <option value="DONE OLO">
                                <option value="Disconnected">
                                <option value="ODP TIDAK DITEMUKAN">
                                <option value="DATEK TIDAK SAMA">
                                <option value="KENDALA BI">
                                <option value="TIDAK ADA ODP DI UIM">
                                <option value="WITEL LAIN">
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                            <input type="date" name="tanggal" value="{{ $valins->tanggal ? \Carbon\Carbon::parse($valins->tanggal)->format('Y-m-d') : '' }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">PIC <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                            <input type="text" name="pic" value="{{ $valins->pic }}" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                    </div>

                    <div class="mt-4 mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Update / Keterangan Progress <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                        <textarea name="update_progress" rows="3" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none">{{ $valins->update_progress }}</textarea>
                    </div>

                    <div class="flex justify-end mt-8 gap-3">
                        <a href="{{ route('valins.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-xl shadow-sm transition">Batal</a>
                        
                        <button type="submit" 
                                @disabled($isLockedByOther)
                                class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2.5 px-8 rounded-xl shadow-md text-base transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <span>{{ $isLockedByOther ? 'Terkunci (Sedang Diproses)' : 'Simpan Perubahan' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>