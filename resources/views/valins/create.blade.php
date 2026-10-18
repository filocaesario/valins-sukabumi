<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Valins Baru') }}
        </h2>
    </x-slot>

    <script>
        function valinsCreateForm() {
            return {
                kategoriPilihan: '',
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
                    const optionals = ['NOINETVALINS', 'NOINET','SIP1VALINS', 'SIP1', 'SIP2VALINS', 'SIP2', 'SID', 'KETERANGAN', 'STATUS', 'KETERANGANSTATUS', 'TANGGAL', 'PIC', 'UPDATEPROGRESS', 'UPDATE'];
                    return optionals.includes(normalized);
                },
                // Fitur Cerdas: Sinkronisasi data dinamis ke fisik
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
                                        physInput.disabled = false;
                                        physInput.value = input.value;
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

    <div class="py-8" x-data="valinsCreateForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Data</h2>
                        <p class="text-xs text-gray-500 mt-1">Kolom bertanda <span class="text-red-500 font-bold">*</span> wajib diisi.</p>
                    </div>
                    <a href="{{ route('valins.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">&larr; Kembali ke Tabel</a>
                </div>

                <form action="{{ route('valins.store') }}" method="POST" @submit="syncBeforeSubmit()">
                    @csrf

                    <input type="hidden" name="valins_category_id" :value="kategoriAktif ? kategoriAktif.id : ''">

                    <!-- SECTION 1: Kategori & Lokasi -->
                    <h3 class="text-lg font-bold text-gray-700 mb-3">Informasi Regional & Kategori</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Tab <span class="text-red-500">*</span></label>
                            <select name="kategori" x-model="kategoriPilihan" class="w-full border rounded px-3 py-2 text-gray-700 bg-red-50 focus:outline-none focus:border-red-500" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">TREG</label>
                            <input type="number" name="treg" value="3" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                        </div>
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">WITEL</label>
                            <input type="text" name="witel" value="SUKABUMI" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                        </div>
                        <div x-show="!isDinamis">
                            <label class="block text-gray-700 text-sm font-bold mb-2">STO <span class="text-red-500">*</span></label>
                            <input type="text" name="sto" placeholder="Contoh: SKB" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis" :required="!isDinamis">
                        </div>
                    </div>

                    <!-- SECTION BAWAAN (Muncul saat Kategori Bawaan / Statis) -->
                    <div x-show="!isDinamis">
                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data ODP</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">ODP Name <span class="text-red-500">*</span></label><input type="text" name="odp_name" placeholder="ODP-SKB-FCE/8" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis" :required="!isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Panel ODP <span class="text-red-500">*</span></label><input type="text" name="panel_o" placeholder="PANEL01" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis" :required="!isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Port ODP <span class="text-red-500">*</span></label><input type="number" name="port_od" placeholder="1" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis" :required="!isDinamis"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data OLT / Node</h3>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Valins ID</label><input type="text" name="valins_id" placeholder="12345" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Node ID</label><input type="text" name="node_id" placeholder="GPON04-D3..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Node IP</label><input type="text" name="node_ip" placeholder="172.29..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Slot</label><input type="number" name="slot" placeholder="1" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">Port</label><input type="number" name="port" placeholder="1" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data Layanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">ONU SN <span class="text-red-500">*</span></label><input type="text" name="onu_sn" placeholder="ZTEG... / HWTC..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis" :required="!isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">No Inet Valins <span class="text-gray-400 font-normal text-xs">(opsional)</span></label><input type="text" name="no_inet_valins" placeholder="1311..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SIP 1 Valins</label><input type="text" name="sip1_valins" placeholder="Opsional" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SIP 2 Valins</label><input type="text" name="sip2_valins" placeholder="Opsional" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                            <div><label class="block text-gray-700 text-sm font-bold mb-2">SID</label><input type="text" name="sid" placeholder="Opsional" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" :disabled="isDinamis"></div>
                        </div>
                    </div>

                    <!-- SECTION DINAMIS -->
                    <div x-show="isDinamis" style="display: none;" class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6">
                        <h3 class="text-base font-bold text-blue-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            Data Kustom Kategori: <span x-text="kategoriPilihan" class="text-blue-700"></span>
                        </h3>
                        <p class="text-xs text-blue-600 mb-4">Lengkapi form berikut. Field dengan tanda <span class="text-red-500 font-bold">*</span> wajib diisi.</p>
                        
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
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white shadow-sm" 
                                           :placeholder="'Masukkan ' + kolom.nama + '...'"
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
                            <input type="text" name="keterangan" list="status_options" placeholder="Pilih atau ketik status..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                            <datalist id="status_options">
                                <option value="OTB"><option value="DONE"><option value="DONE OLO"><option value="Disconnected"><option value="ODP TIDAK DITEMUKAN"><option value="DATEK TIDAK SAMA"><option value="KENDALA BI"><option value="TIDAK ADA ODP DI UIM"><option value="WITEL LAIN">
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                            <input type="date" name="tanggal" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">PIC <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                            <input type="text" name="pic" placeholder="Contoh: Firdi / LIANTY" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                        </div>
                    </div>

                    <div class="mt-4 mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Update / Keterangan Progress <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                        <textarea name="update_progress" rows="2" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" placeholder="Contoh: Menunggu validasi tim lapangan..."></textarea>
                    </div>

                    <div class="flex justify-end mt-8 gap-4">
                        <a href="{{ route('valins.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded shadow transition">Batal</a>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow text-lg transition flex items-center gap-2">
                            Simpan Data Valins
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>