<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Valins</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-8">

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Data Temuan Baru</h2>
            <a href="{{ route('valins.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">&larr; Kembali</a>
        </div>

        <form action="{{ route('valins.store') }}" method="POST">
            @csrf

            <!-- SECTION 1: Kategori & Lokasi -->
            <h3 class="text-lg font-bold text-gray-700 mb-3">Informasi Regional & Kategori</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Tab</label>
                    <select name="kategori" class="w-full border rounded px-3 py-2 text-gray-700 bg-red-50 focus:outline-none focus:border-red-500" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="ODP TIDAK SAMA">ODP TIDAK SAMA</option>
                        <option value="DATEK TIDAK SAMA">DATEK TIDAK SAMA</option>
                        <option value="ODP DAN DATEK TIDAK SAMA">ODP & DATEK TIDAK SAMA</option>
                        <option value="Not In Service">Not In Service</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">TREG</label>
                    <input type="number" name="treg" value="3" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">WITEL</label>
                    <input type="text" name="witel" value="SUKABUMI" class="w-full border rounded px-3 py-2 text-gray-500 bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">STO</label>
                    <input type="text" name="sto" placeholder="Contoh: SKB" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" required>
                </div>
            </div>

            <!-- SECTION 2: Data ODP -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data ODP</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ODP Name</label>
                    <input type="text" name="odp_name" placeholder="ODP-SKB-FCE/8" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Panel ODP</label>
                    <input type="text" name="panel_o" placeholder="PANEL01" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Port ODP</label>
                    <input type="number" name="port_od" placeholder="1" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 3: Data Node (GPON/OLT) -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data OLT / Node</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Valins ID</label>
                    <input type="text" name="valins_id" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Node ID</label>
                    <input type="text" name="node_id" placeholder="GPON04-D3..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Node IP</label>
                    <input type="text" name="node_ip" placeholder="172.29..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Slot</label>
                    <input type="number" name="slot" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Port</label>
                    <input type="number" name="port" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 4: Data Layanan (Internet & Telepon) -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Data Layanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ONU SN</label>
                    <input type="text" name="onu_sn" placeholder="ZTEG... / HWTC..." class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">No Inet Valins</label>
                    <input type="text" name="no_inet_valins" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SIP 1 Valins</label>
                    <input type="text" name="sip1_valins" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SIP 2 Valins</label>
                    <input type="text" name="sip2_valins" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SID</label>
                    <input type="text" name="sid" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <!-- SECTION 5: Keterangan & PIC -->
            <h3 class="text-lg font-bold text-gray-700 mb-3 border-t pt-4">Status & Pelaksana</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan / Status</label>
                    <select name="keterangan" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="OTB">OTB</option>
                        <option value="DONE">DONE</option>
                        <option value="DONE OLO">DONE OLO</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="ODP TIDAK DITEMUKAN">ODP Tidak Ditemukan</option>
                        <option value="DATEK TIDAK SAMA">Datek Tidak Sama</option>
                        <option value="KENDALA BI">KENDALA BI</option>
                        <option value="TIDAK ADA ODP DI UIM">TIDAK ADA ODP DI UIM</option>
                        <option value="WITEL LAIN">WITEL LAIN</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">PIC</label>
                    <input type="text" name="pic" placeholder="Contoh: FILO / LIANTY" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-red-500">
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-8 rounded shadow text-lg">
                    Simpan Data Valins
                </button>
            </div>
        </form>
    </div>

</body>
</html>
