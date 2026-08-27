<?php

namespace App\Http\Controllers;

use App\Models\ValinsService;
use Illuminate\Http\Request;

class ValinsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori'); // Menangkap tab navbar yang diklik

        $query = ValinsService::query();

        // Filter berdasarkan Tab Navbar
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('onu_sn', 'like', "%{$search}%")
                  ->orWhere('no_inet_valins', 'like', "%{$search}%")
                  ->orWhere('odp_name', 'like', "%{$search}%")
                  ->orWhere('valins_id', 'like', "%{$search}%");
            });
        }

        // Tampilkan data
        $data = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('valins.index', compact('data', 'search', 'kategori'));
    }

    // Menampilkan halaman Tambah Data
    public function create()
    {
        return view('valins.create');
    }

    // Menyimpan data baru ke Database
    public function store(Request $request)
    {
        ValinsService::create($request->all());

        return redirect()->route('valins.index')->with('success', 'Data Valins baru berhasil ditambahkan!');
    }
    // Menampilkan halaman form edit
    public function edit($id)
    {
        $valins = ValinsService::findOrFail($id);
        return view('valins.edit', compact('valins'));
    }

    // Memproses data yang di-submit dari form
   // Memproses data yang di-submit dari form EDIT
    public function update(Request $request, $id)
    {
        $valins = ValinsService::findOrFail($id);

        $data = $request->all();

        // Jika status diubah jadi DONE tapi tanggal kosong, otomatis isi tanggal hari ini
        if (($request->keterangan == 'DONE' || $request->keterangan == 'DONE OLO') && empty($request->tanggal)) {
            $data['tanggal'] = now();
        }

        $valins->update($data);

        return redirect()->route('valins.index')->with('success', 'Data ODP ' . $valins->odp_name . ' berhasil diperbarui!');
    }

    // Menghapus Data (DELETE)
    public function destroy($id)
    {
        $valins = ValinsService::findOrFail($id);
        $nama_odp = $valins->odp_name;
        $valins->delete();

        return redirect()->route('valins.index')->with('success', 'Data ' . $nama_odp . ' berhasil dihapus dari sistem!');
    }
}
