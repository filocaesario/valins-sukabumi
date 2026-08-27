<x-layout>
    <x-slot:title>Edit Data - {{ $valins->odp_name }}</x-slot:title>

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Data: <span class="text-red-600">{{ $valins->odp_name }}</span></h2>
            <a href="{{ route('valins.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">&larr; Kembali ke Tabel</a>
        </div>

        <form action="{{ route('valins.update', $valins->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- SECTION 1: Kategori & Lokasi -->
            <h3 class="text-lg font-bold text-gray-700 mb-3">Informasi Regional & Kategori</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Tab</label>
                    <select name="kategori" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                        <option value="">-- Pilih --</option>
                        <option value="ODP TIDAK SAMA" {{ $valins->kategori == 'ODP TIDAK SAMA' ? 'selected' : '' }}>ODP TIDAK SAMA</option>
                        <option value="DATEK TIDAK SAMA" {{ $valins->kategori == 'DATEK TIDAK SAMA' ? 'selected' : '' }}>DATEK TIDAK SAMA</option>
                        <option value="ODP DAN DATEK TIDAK SAMA" {{ $valins->kategori == 'ODP DAN DATEK TIDAK SAMA' ? 'selected' : '' }}>ODP & DATEK TIDAK SAMA</option>
                        <option value="Not In Service" {{ $valins->kategori == 'Not In Service' ? 'selected' : '' }}>Not In Service</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">TREG</label>
                    <input type="number" name="treg" value="{{ $valins->treg ?? 3 }}" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">WITEL</label>
                    <input type="text" name="witel" value="{{ $valins->witel ?? 'SUKABUMI' }}" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">STO</label>
                    <input type="text" name="sto" value="{{ $valins->sto }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" required>
                </div>
            </div>

            <!-- SECTION 2: Data ODP -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data ODP</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ODP Name</label>
                    <input type="text" name="odp_name" value="{{ $valins->odp_name }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Panel ODP</label>
                    <input type="text" name="panel_o" value="{{ $valins->panel_o }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Port ODP</label>
                    <input type="number" name="port_od" value="{{ $valins->port_od }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 3: Data Node (GPON/OLT) -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data OLT / Node</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Valins ID</label>
                    <input type="text" name="valins_id" value="{{ $valins->valins_id }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Node ID</label>
                    <input type="text" name="node_id" value="{{ $valins->node_id }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Node IP</label>
                    <input type="text" name="node_ip" value="{{ $valins->node_ip }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Slot</label>
                    <input type="number" name="slot" value="{{ $valins->slot }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Port</label>
                    <input type="number" name="port" value="{{ $valins->port }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 4: Data Layanan (Internet & Telepon) -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data Layanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ONU SN</label>
                    <input type="text" name="onu_sn" value="{{ $valins->onu_sn }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">No Inet Valins</label>
                    <input type="text" name="no_inet_valins" value="{{ $valins->no_inet_valins }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SIP 1 Valins</label>
                    <input type="text" name="sip1_valins" value="{{ $valins->sip1_valins }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SIP 2 Valins</label>
                    <input type="text" name="sip2_valins" value="{{ $valins->sip2_valins }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SID</label>
                    <input type="text" name="sid" value="{{ $valins->sid }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 5: Keterangan & PIC -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Status & Pelaksana</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan / Status</label>
                    <select name="keterangan" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="OTB" {{ $valins->keterangan == 'OTB' ? 'selected' : '' }}>OTB</option>
                        <option value="DONE" {{ $valins->keterangan == 'DONE' ? 'selected' : '' }}>DONE</option>
                        <option value="DONE OLO" {{ $valins->keterangan == 'DONE OLO' ? 'selected' : '' }}>DONE OLO</option>
                        <option value="Disconnected" {{ $valins->keterangan == 'Disconnected' ? 'selected' : '' }}>Disconnected</option>
                        <option value="ODP TIDAK DITEMUKAN" {{ $valins->keterangan == 'ODP TIDAK DITEMUKAN' ? 'selected' : '' }}>ODP Tidak Ditemukan</option>
                        <option value="DATEK TIDAK SAMA" {{ $valins->keterangan == 'DATEK TIDAK SAMA' ? 'selected' : '' }}>Datek Tidak Sama</option>
                        <option value="KENDALA BI" {{ $valins->keterangan == 'KENDALA BI' ? 'selected' : '' }}>KENDALA BI</option>
                        <option value="TIDAK ADA ODP DI UIM" {{ $valins->keterangan == 'TIDAK ADA ODP DI UIM' ? 'selected' : '' }}>TIDAK ADA ODP DI UIM</option>
                        <option value="WITEL LAIN" {{ $valins->keterangan == 'WITEL LAIN' ? 'selected' : '' }}>WITEL LAIN</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                    <!-- Formatting tanggal agar terbaca oleh input type="date" HTML5 -->
                    <input type="date" name="tanggal" value="{{ $valins->tanggal ? \Carbon\Carbon::parse($valins->tanggal)->format('Y-m-d') : '' }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">PIC</label>
                    <input type="text" name="pic" value="{{ $valins->pic }}" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <div class="flex justify-end mt-8 gap-4">
                <a href="{{ route('valins.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded shadow">Batal</a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow">
                    Update Data Valins
                </button>
            </div>
        </form>
    </div>
</x-layout>
