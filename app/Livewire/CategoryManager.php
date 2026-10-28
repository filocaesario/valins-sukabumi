<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ValinsCategory;
use App\Models\ValinsService;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class CategoryManager extends Component
{
    public $mode = 'list'; 
    public $categoryId = null;
    public $nama_kategori = '';
    public $konfigurasi_kolom = [];
    public $isEditing = false;

    // Checkbox untuk Hapus Kolom Sekaligus (Bulk Delete)
    public $selectedKolom = [];
    public $selectAllKolom = false;

    // Trigger untuk me-refresh tampilan modal otomatis saat ada data baru dari Import
    #[On('refreshKategori')]
    public function segarkanModal()
    {
        // Fungsi kosong ini cukup untuk memerintahkan Livewire merender ulang daftar kategori
    }

    public function getTemplateKolomStandar()
    {
        return [
            'col_treg'           => ['id' => 'col_treg', 'nama' => 'TREG', 'tipe' => 'text', 'hidden' => false],
            'col_witel'          => ['id' => 'col_witel', 'nama' => 'WITEL', 'tipe' => 'text', 'hidden' => false],
            'col_sto'            => ['id' => 'col_sto', 'nama' => 'STO', 'tipe' => 'text', 'hidden' => false],
            'col_odp_name'       => ['id' => 'col_odp_name', 'nama' => 'ODP NAME', 'tipe' => 'text', 'hidden' => false],
            'col_panel_odp'      => ['id' => 'col_panel_odp', 'nama' => 'PANEL ODP', 'tipe' => 'text', 'hidden' => false],
            'col_port_odp'       => ['id' => 'col_port_odp', 'nama' => 'PORT ODP', 'tipe' => 'number', 'hidden' => false],
            'col_valins_id'      => ['id' => 'col_valins_id', 'nama' => 'VALINS ID', 'tipe' => 'number', 'hidden' => false],
            'col_node_id'        => ['id' => 'col_node_id', 'nama' => 'NODE ID', 'tipe' => 'text', 'hidden' => false],
            'col_node_ip'        => ['id' => 'col_node_ip', 'nama' => 'NODE IP', 'tipe' => 'text', 'hidden' => false],
            'col_slot'           => ['id' => 'col_slot', 'nama' => 'SLOT', 'tipe' => 'number', 'hidden' => false],
            'col_port'           => ['id' => 'col_port', 'nama' => 'PORT', 'tipe' => 'number', 'hidden' => false],
            'col_onu_sn'         => ['id' => 'col_onu_sn', 'nama' => 'ONU SN', 'tipe' => 'text', 'hidden' => false],
            'col_no_inet_valins' => ['id' => 'col_no_inet_valins', 'nama' => 'NO INET VALINS', 'tipe' => 'number', 'hidden' => false],
            'col_sip_1_valins'   => ['id' => 'col_sip_1_valins', 'nama' => 'SIP 1 VALINS', 'tipe' => 'number', 'hidden' => false],
            'col_sip_2_valins'   => ['id' => 'col_sip_2_valins', 'nama' => 'SIP 2 VALINS', 'tipe' => 'number', 'hidden' => false],
            'col_sid'            => ['id' => 'col_sid', 'nama' => 'SID', 'tipe' => 'text', 'hidden' => false],
        ];
    }

    public function muatKolomStandar()
    {
        $this->konfigurasi_kolom = $this->getTemplateKolomStandar();
        $this->selectedKolom = [];
        $this->selectAllKolom = false;
        $this->dispatch('kolom-reordered');
    }

    public function bukaTambah()
    {
        $this->reset(['nama_kategori', 'konfigurasi_kolom', 'categoryId', 'selectedKolom', 'selectAllKolom']);
        $uid = 'col_' . uniqid();
        $this->konfigurasi_kolom = [
            $uid => ['id' => $uid, 'nama' => '', 'tipe' => 'text', 'hidden' => false]
        ];
        $this->isEditing = false;
        $this->mode = 'form';
    }

    public function formatNamaKategoriDisplay($nama)
    {
        $rawUpper = strtoupper(trim($nama));
        return match ($rawUpper) {
            'ODP TIDAK SAMA' => 'ODP Tidak Sama',
            'DATEK TIDAK SAMA' => 'Datek Tidak Sama',
            'ODP DAN DATEK TIDAK SAMA', 'ODP & DATEK TIDAK SAMA' => 'ODP & Datek Tidak Sama',
            'NOT IN SERVICE' => 'Not In Service',
            'KENDALA ODP' => 'Kendala ODP',
            default => preg_replace_callback('/\b(odp|gpon|nis|olo|olt|ont|sid|sip)\b/i', fn($m) => strtoupper($m[0]), ucwords(strtolower($nama))),
        };
    }

    public function bukaEdit($id)
    {
        $category = ValinsCategory::findOrFail($id);
        $this->categoryId = $category->id;
        $this->nama_kategori = $this->formatNamaKategoriDisplay($category->nama_kategori);
        $this->selectedKolom = [];
        $this->selectAllKolom = false;

        $rawCols = !empty($category->konfigurasi_kolom) ? $category->konfigurasi_kolom : $this->getTemplateKolomStandar();
        
        $keyed = [];
        foreach ($rawCols as $idx => $col) {
            if (is_array($col)) {
                $uid = !empty($col['id']) ? $col['id'] : ('col_' . $idx . '_' . uniqid());
                $keyed[$uid] = [
                    'id'     => $uid,
                    'nama'   => $col['nama'] ?? '',
                    'tipe'   => $col['tipe'] ?? 'text',
                    'hidden' => !empty($col['hidden']),
                ];
            } else {
                $uid = 'col_' . $idx . '_' . uniqid();
                $keyed[$uid] = [
                    'id'     => $uid,
                    'nama'   => (string)$col,
                    'tipe'   => 'text',
                    'hidden' => false,
                ];
            }
        }

        $this->konfigurasi_kolom = $keyed;
        $this->isEditing = true;
        $this->mode = 'form';
    }

    public function kembaliKeDaftar()
    {
        $this->reset(['nama_kategori', 'konfigurasi_kolom', 'categoryId', 'isEditing', 'selectedKolom', 'selectAllKolom']);
        $this->mode = 'list';
    }

    // Method untuk memindahkan urutan kolom saat digeser kursor (drag & drop antar dua kolom)
    public function pindahUrutanKolom($sourceUid, $targetUid)
    {
        if ($sourceUid === $targetUid) {
            return;
        }
        if (!isset($this->konfigurasi_kolom[$sourceUid]) || !isset($this->konfigurasi_kolom[$targetUid])) {
            return;
        }

        $keys = array_keys($this->konfigurasi_kolom);
        $sourceIndex = array_search($sourceUid, $keys);
        $targetIndex = array_search($targetUid, $keys);

        if ($sourceIndex === false || $targetIndex === false) {
            return;
        }

        $movedKey = array_splice($keys, $sourceIndex, 1)[0];
        array_splice($keys, $targetIndex, 0, $movedKey);

        $newOrder = [];
        foreach ($keys as $k) {
            $newOrder[$k] = $this->konfigurasi_kolom[$k];
        }

        $this->konfigurasi_kolom = $newOrder;
        $this->selectedKolom = [];
        $this->selectAllKolom = false;
        $this->dispatch('kolom-reordered');
    }

    // Method untuk mengurutkan ulang kolom saat digeser kursor (SortableJS / batch)
    public function reorderKolom($orderedUids)
    {
        $newOrder = [];
        foreach ($orderedUids as $uid) {
            if (isset($this->konfigurasi_kolom[$uid])) {
                $newOrder[$uid] = $this->konfigurasi_kolom[$uid];
            }
        }
        foreach ($this->konfigurasi_kolom as $uid => $col) {
            if (!isset($newOrder[$uid])) {
                $newOrder[$uid] = $col;
            }
        }

        $this->konfigurasi_kolom = $newOrder;
        $this->selectedKolom = [];
        $this->selectAllKolom = false;
        $this->dispatch('kolom-reordered');
    }

    // Method untuk menambah kolom baru
    public function tambahKolom()
    {
        $uid = 'col_' . uniqid();
        $this->konfigurasi_kolom[$uid] = [
            'id'     => $uid,
            'nama'   => '',
            'tipe'   => 'text',
            'hidden' => false, // Default: tampil
        ];
        $this->dispatch('kolom-reordered');
        $this->dispatch('kolom-ditambah');
    }

    // Method hapus baris kolom tunggal
    public function hapusKolom($uid)
    {
        unset($this->konfigurasi_kolom[$uid]);
        $this->selectedKolom = array_values(array_diff($this->selectedKolom, [$uid]));
        $this->selectAllKolom = false;
        $this->dispatch('kolom-reordered');
    }

    // Method sinkronisasi checkbox "Pilih Semua"
    public function updatedSelectAllKolom($value)
    {
        if ($value) {
            $this->selectedKolom = array_keys($this->konfigurasi_kolom);
        } else {
            $this->selectedKolom = [];
        }
    }

    public function updatedSelectedKolom()
    {
        $this->selectAllKolom = count($this->selectedKolom) > 0 && count($this->selectedKolom) === count($this->konfigurasi_kolom);
    }

    // Method hapus kolom yang dipilih secara massal
    public function hapusKolomTerpilih()
    {
        if (empty($this->selectedKolom)) {
            return;
        }

        $count = count($this->selectedKolom);
        foreach ($this->selectedKolom as $uid) {
            unset($this->konfigurasi_kolom[$uid]);
        }

        $this->selectedKolom = [];
        $this->selectAllKolom = false;
        $this->dispatch('kolom-reordered');
        session()->flash('info_kolom', "{$count} kolom berhasil dihapus sekaligus.");
    }

    public function geserPosisi($id, $arah)
    {
        $current = ValinsCategory::findOrFail($id);
        $target = $arah === 'up' 
            ? ValinsCategory::where('urutan', '<', $current->urutan)->orderBy('urutan', 'desc')->first()
            : ValinsCategory::where('urutan', '>', $current->urutan)->orderBy('urutan', 'asc')->first();

        if ($target) {
            $temp = $current->urutan;
            $current->urutan = $target->urutan;
            $target->urutan = $temp;
            $current->save();
            $target->save();
            $this->dispatch('refreshKategori');
        }
    }

    public function updateUrutanDrag($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            ValinsCategory::where('id', $id)->update(['urutan' => $index + 1]);
        }
        $this->dispatch('refreshKategori');
    }

    public function simpanKategori()
    {
        $this->validate([
            'nama_kategori' => 'required|string|unique:valins_categories,nama_kategori,' . $this->categoryId,
            'konfigurasi_kolom' => 'required|array|min:1',
            'konfigurasi_kolom.*.nama' => 'required|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'konfigurasi_kolom.min' => 'Kategori minimal harus memiliki 1 kolom.',
            'konfigurasi_kolom.*.nama.required' => 'Nama kolom tidak boleh kosong.',
        ]);

        $sanitizedKolom = array_values(array_map(function ($col) {
            $nama = trim($col['nama'] ?? '');
            return [
                'nama'   => $nama,
                'tipe'   => $col['tipe'] ?? 'text',
                'hidden' => !empty($col['hidden']),
            ];
        }, $this->konfigurasi_kolom));

        if ($this->isEditing) {
            $category = ValinsCategory::findOrFail($this->categoryId);
            $namaLama = $category->nama_kategori;

            $category->update([
                'nama_kategori' => $this->nama_kategori,
                'slug' => Str::slug($this->nama_kategori),
                'konfigurasi_kolom' => $sanitizedKolom,
            ]);

            if ($namaLama !== $this->nama_kategori) {
                ValinsService::where('kategori', $namaLama)
                    ->orWhere('valins_category_id', $category->id)
                    ->update(['kategori' => $this->nama_kategori]);
            }

            session()->flash('success_modal', "Kategori '{$this->nama_kategori}' berhasil diperbarui!");
        } else {
            $maxUrutan = ValinsCategory::max('urutan') ?? 0;
            ValinsCategory::create([
                'nama_kategori' => $this->nama_kategori,
                'slug' => Str::slug($this->nama_kategori),
                'urutan' => $maxUrutan + 1,
                'konfigurasi_kolom' => $sanitizedKolom,
            ]);

            session()->flash('success_modal', "Kategori baru '{$this->nama_kategori}' berhasil dibuat!");
        }

        $this->kembaliKeDaftar();
        $this->dispatch('refreshKategori');
    }

    public function hapusKategori($id)
    {
        $category = ValinsCategory::findOrFail($id);
        $nama = $category->nama_kategori;

        // Menghitung jumlah data yang akan ikut terhapus (opsional, untuk info di pesan flash)
        $jumlahData = ValinsService::where('valins_category_id', $category->id)
            ->orWhere('kategori', $nama)
            ->count();

        // MENGHAPUS SEMUA DATA yang terkait dengan kategori ini secara permanen
        ValinsService::where('valins_category_id', $category->id)
            ->orWhere('kategori', $nama)
            ->delete();

        // Setelah datanya habis, hapus kategorinya
        $category->delete();

        \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
        \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
        \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');

        session()->flash('success_modal', "Kategori '{$nama}' beserta {$jumlahData} datanya berhasil dihapus permanen!");
        
        // Refresh tabel dan kategori
        $this->dispatch('refreshKategori');
        $this->dispatch('valinsUpdated');
    }

    public function render()
    {
        return view('livewire.category-manager', [
            'daftarKategori' => ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get(),
            'mode' => $this->mode,
            'isEditing' => $this->isEditing,
            'nama_kategori' => $this->nama_kategori,
            'konfigurasi_kolom' => $this->konfigurasi_kolom,
            'selectedKolom' => $this->selectedKolom,
            'selectAllKolom' => $this->selectAllKolom,
        ]);
    }
}