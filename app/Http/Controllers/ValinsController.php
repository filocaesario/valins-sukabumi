<?php

namespace App\Http\Controllers;

use App\Models\ValinsService;
use App\Models\ValinsCategory; // <-- TAMBAHAN: Memanggil model kategori
use Illuminate\Http\Request;

class ValinsController extends Controller
{
    public function index()
    {
        return view('valins.index');
    }

    // Menampilkan halaman Tambah Data
    public function create(Request $request)
    {
        // Tarik kategori dengan kolom spesifik yang dibutuhkan saja (hemat memori)
        $categories = ValinsCategory::select('id', 'nama_kategori', 'slug', 'is_navbar', 'konfigurasi_kolom', 'urutan')
            ->orderBy('urutan', 'asc')
            ->get();
        $defaultKategori = $request->query('kategori', '');
        return view('valins.create', compact('categories', 'defaultKategori'));
    }

    // Menyimpan data baru ke Database
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Kompatibilitas jika ada form yang memakai panel_odp atau port_odp (TETAP AMAN)
        if ($request->has('panel_odp') && !$request->has('panel_o')) {
            $data['panel_o'] = trim((string)$request->panel_odp);
        }
        if ($request->has('port_odp') && !$request->has('port_od')) {
            $data['port_od'] = trim((string)$request->port_odp);
        }
        unset($data['panel_odp'], $data['port_odp']);

        if (isset($data['port_od'])) {
            $pTrim = trim((string)$data['port_od']);
            $data['port_od'] = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : ($pTrim ?: null);
        }

        // TAMBAHAN: Menangkap input dynamic_data (JSON) dari form kategori kustom
        if ($request->has('dynamic_data') && is_array($request->input('dynamic_data'))) {
            $dyn = $request->input('dynamic_data');
            foreach ($dyn as $k => $v) {
                $normK = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k));
                if (in_array($normK, ['PORTODP', 'PORTOD'])) {
                    if ($v !== null && trim((string)$v) !== '' && trim((string)$v) !== '-') {
                        $pTrim = trim((string)$v);
                        $dyn[$k] = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : $pTrim;
                        $data['port_od'] = $dyn[$k];
                    } else {
                        $dyn[$k] = null;
                    }
                } elseif (is_string($v)) {
                    $dyn[$k] = trim($v);
                }
            }
            $data['dynamic_data'] = $dyn;
        } else {
            $data['dynamic_data'] = null;
        }

        ValinsService::create($data);

        return redirect()->route('valins.index')->with('success', 'Data Valins baru berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit
    public function edit($id)
    {
        $valins = ValinsService::findOrFail($id);
        $currentUser = auth()->check() ? auth()->user()->name : 'System';

        // Cegah masuk jika sedang diproses akun lain
        if (!empty($valins->locked_by) && $valins->locked_by !== $currentUser) {
            return redirect()->route('valins.index')
                ->with('error', "Akses Ditolak! Data #{$id} ({$valins->odp_name}) sedang diproses oleh {$valins->locked_by}.");
        }

        $categories = ValinsCategory::select('id', 'nama_kategori', 'slug', 'is_navbar', 'konfigurasi_kolom', 'urutan')
            ->orderBy('urutan', 'asc')
            ->get();
        return view('valins.edit', compact('valins', 'categories'));
    }

    // Memproses data yang di-submit dari form EDIT
    public function update(Request $request, $id)
    {
        $valins = ValinsService::findOrFail($id);
        $currentUser = auth()->check() ? auth()->user()->name : 'System';

        // Cegah update jika data sedang aktif dikunci orang lain
        if (!empty($valins->locked_by) && $valins->locked_by !== $currentUser) {
            return redirect()->route('valins.index')
                ->with('error', "Gagal Menyimpan! Data #{$id} sedang diproses oleh {$valins->locked_by}.");
        }

        // Ambil data request yang akan diupdate
        $data = $request->except(['_token', '_method']);

        if ($request->has('panel_odp') && !$request->has('panel_o')) {
            $data['panel_o'] = trim((string)$request->panel_odp);
        }
        if ($request->has('port_odp') && !$request->has('port_od')) {
            $data['port_od'] = trim((string)$request->port_odp);
        }
        unset($data['panel_odp'], $data['port_odp']);

        if (isset($data['port_od'])) {
            $pTrim = trim((string)$data['port_od']);
            $data['port_od'] = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : ($pTrim ?: null);
        }

        // PENGAMANAN: Pastikan kategori tetap mengacu pada kategori asli data tersebut
        $data['kategori'] = $valins->kategori;
        if (!empty($valins->valins_category_id)) {
            $data['valins_category_id'] = $valins->valins_category_id;
        }

        // Sinkronisasi data dinamis (merge agar data kustom tidak hilang)
        if ($request->has('dynamic_data') && is_array($request->input('dynamic_data'))) {
            $currentDyn = is_array($valins->dynamic_data) ? $valins->dynamic_data : [];
            $inputDyn = $request->input('dynamic_data');
            foreach ($inputDyn as $k => $v) {
                $normK = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k));
                if (in_array($normK, ['PORTODP', 'PORTOD'])) {
                    if ($v !== null && trim((string)$v) !== '' && trim((string)$v) !== '-') {
                        $pTrim = trim((string)$v);
                        $inputDyn[$k] = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : $pTrim;
                        $data['port_od'] = $inputDyn[$k];
                    } else {
                        $inputDyn[$k] = null;
                    }
                } elseif (is_string($v)) {
                    $inputDyn[$k] = trim($v);
                }
            }
            $data['dynamic_data'] = array_merge($currentDyn, $inputDyn);
        }

        // KUNCI PERBAIKAN: Lepaskan gembok otomatis saat data berhasil disimpan
        $data['locked_by'] = null;
        $data['locked_at'] = null;

        // Catat siapa yang terakhir mengubah
        if (\Illuminate\Support\Facades\Schema::hasColumn('valins_services', 'updated_by')) {
            $data['updated_by'] = $currentUser;
        }

        $valins->update($data);

        return redirect()->route('valins.index')->with('success', "Data {$valins->odp_name} berhasil diperbarui!");
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