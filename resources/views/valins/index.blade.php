<x-layout>
    <x-slot:title>Manajemen Data VALINS & GPON</x-slot:title>

    <div class="container mx-auto px-4 mt-8">

        <!-- Header Website -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Data VALINS & GPON</h1>
                <p class="text-sm text-gray-600 mt-1">PT Telkom Akses Witel Sukabumi</p>
            </div>
            <a href="{{ route('valins.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                + Tambah Data Manual
            </a>
        </div>

        <!-- Alert Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Navbar Tabs -->
        <div class="flex space-x-6 border-b-2 border-gray-200 mb-6 font-semibold text-sm overflow-x-auto">
            <a href="{{ route('valins.index') }}" class="pb-2 {{ empty($kategori) ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-800' }}">Semua Data</a>
            <a href="{{ route('valins.index', ['kategori' => 'ODP TIDAK SAMA']) }}" class="pb-2 {{ $kategori == 'ODP TIDAK SAMA' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-800' }}">ODP TIDAK SAMA</a>
            <a href="{{ route('valins.index', ['kategori' => 'DATEK TIDAK SAMA']) }}" class="pb-2 {{ $kategori == 'DATEK TIDAK SAMA' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-800' }}">DATEK TIDAK SAMA</a>
            <a href="{{ route('valins.index', ['kategori' => 'ODP DAN DATEK TIDAK SAMA']) }}" class="pb-2 {{ $kategori == 'ODP DAN DATEK TIDAK SAMA' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-800' }}">ODP & DATEK TIDAK SAMA</a>
            <a href="{{ route('valins.index', ['kategori' => 'Not In Service']) }}" class="pb-2 {{ $kategori == 'Not In Service' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-800' }}">Not In Service</a>
        </div>

        <!-- Panel Pencarian -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6 border">
            <form action="{{ route('valins.index') }}" method="GET" class="flex gap-4">
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari ONU SN, No Inet, Nama ODP, atau Valins ID..."
                       class="w-full border border-gray-300 bg-white h-10 px-5 rounded-lg text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                <button type="submit" class="bg-gray-800 text-white px-6 rounded-lg font-semibold hover:bg-gray-900 transition shadow">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('valins.index', ['kategori' => $kategori]) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition flex items-center shadow-sm">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel Web (Data View) -->
        <div class="bg-white rounded-lg shadow-md overflow-x-auto border">
            <table class="min-w-full leading-normal whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">STO</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">ODP Name</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">Panel</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">Port OD</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">Valins ID</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">Node IP</th>
                        <th class="px-4 py-3 border-b-2 text-center font-semibold">S/P</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">ONU SN / No Inet</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">SIP 1</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">SIP 2</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">SID</th>
                        <th class="px-4 py-3 border-b-2 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b-2 text-left font-semibold">PIC</th>
                        <th class="px-4 py-3 border-b-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                        <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ $item->sto }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->odp_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->panel_o ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->port_od ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->valins_id ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->node_ip ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-center text-gray-900">{{ $item->slot ?? '-' }}/{{ $item->port ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="font-semibold">{{ $item->onu_sn ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $item->no_inet_valins ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->sip1_valins ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->sip2_valins ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->sid ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-center">
                            @if($item->keterangan == 'DONE' || $item->keterangan == 'DONE OLO')
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold border border-green-300">{{ $item->keterangan }}</span>
                            @elseif($item->keterangan == 'OTB')
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold border border-yellow-300">OTB</span>
                            @elseif($item->keterangan == 'Disconnected')
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold border border-red-300">DISCONNECTED</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs font-bold border border-gray-300">{{ $item->keterangan ?? 'NO STATUS' }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->pic ?? '-' }}</td>

                        <!-- Kolom Aksi (Edit & Hapus) -->
                        <td class="px-4 py-3 text-sm text-center">
                            <div class="flex justify-center items-center space-x-3">
                                <a href="{{ route('valins.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 underline font-semibold text-xs">Edit</a>

                                <form action="{{ route('valins.destroy', $item->id) }}" method="POST" onsubmit="return confirm('PERINGATAN!\nApakah Anda yakin ingin menghapus data ODP {{ $item->odp_name }} secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 underline font-semibold text-xs">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="15" class="px-5 py-8 text-center text-gray-500 font-semibold bg-gray-50">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 mb-8">
            {{ $data->appends(['search' => $search, 'kategori' => $kategori])->links() }}
        </div>

    </div>
</x-layout>
