<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telkom Akses Sukabumi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto px-4 md:px-8 py-8 max-w-4xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Port GPON</h1>
                <p class="text-sm text-gray-500 mt-1">Input data Master OLT secara manual</p>
            </div>
            <a href="{{ route('master-gpon.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow transition">
                &larr; Kembali
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-red-600 p-6 md:p-8">
            <form action="{{ route('master-gpon.index') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- STO -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">STO (Sentral)</label>
                        <input type="text" name="sto" list="sto_options" placeholder="Contoh: BGL, CBD..." class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 uppercase" required>
                        <datalist id="sto_options">
                            <option value="BGL">
                            <option value="CBD">
                            <option value="CBE">
                        </datalist>
                    </div>

                    <!-- ID Logical Device -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">ID Logical Device</label>
                        <input type="text" name="id_logical_device" placeholder="Contoh: 75794" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Node ID -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama OLT (Node ID)</label>
                        <input type="text" name="node_id" placeholder="Contoh: GPON00-D3-BGL-2" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500" required>
                    </div>

                    <!-- Node IP -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">IP OLT (Node IP)</label>
                        <input type="text" name="node_ip" placeholder="Contoh: 172.29.137.4" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Type GPON -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Merk / Type GPON</label>
                        <input type="text" name="type_gpon" list="merk_options" placeholder="Pilih Merk..." class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 uppercase">
                        <datalist id="merk_options">
                            <option value="HUAWEI">
                            <option value="FIBERHOME">
                            <option value="ZTE">
                            <option value="ALCATEL">
                        </datalist>
                    </div>

                    <!-- Slot -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Slot</label>
                        <input type="text" name="slot" placeholder="Contoh: SLOT 1" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 uppercase" required>
                    </div>

                    <!-- Port -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Port</label>
                        <input type="text" name="port" placeholder="GPON - 85927..." class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500" required>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center justify-end border-t pt-6">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
