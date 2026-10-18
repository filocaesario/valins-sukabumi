<x-app-layout>
    <!-- Slot Header Bawaan Breeze -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Data GPON') }}
        </h2>
    </x-slot>

    <!-- Wrapper Utama dengan Alpine.js untuk Modal Import Excel -->
    <div x-data="{ modalOpen: false }" class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman & Tombol Import -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 px-4 sm:px-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">GPON ALL STO WITEL SUKABUMI</h1>
                    <p class="text-sm text-gray-500 mt-1">PT Telkom Akses Witel Sukabumi</p>
                </div>

                <div class="flex space-x-3">
                    <button @click="modalOpen = true" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import Excel
                    </button>

                </div>
            </div>

            <!-- Pesan Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm mx-4 sm:mx-0">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Panggil Komponen Tabel Livewire -->
            <div class="mx-4 sm:mx-0">
                @livewire('master-gpon-table')
            </div>

        </div>

        <!-- Pop-up Modal Import Excel (Tetap dipertahankan) -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="modalOpen = false"></div>

                <div x-show="modalOpen" x-transition class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-xl sm:my-8 sm:w-full sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Import Master GPON</h3>
                    <p class="text-sm text-gray-500 mb-4">Pastikan file Excel Anda (xlsx/csv) memiliki judul kolom di baris pertama dengan nama: <br><code>sto</code>, <code>id_logical_device</code>, <code>node_id</code>, <code>node_ip</code>, <code>type_gpon</code>, <code>slot</code>, <code>port</code>.</p>

                    <form action="{{ route('master-gpon.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-2">
                            <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Upload & Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
